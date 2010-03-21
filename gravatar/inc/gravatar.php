<?php

// notre fonction de recherche de logo
// obsolete, on la garde pour ne pas planter les squelettes non recalcules
function calcule_logo_ou_gravatar($email) {
	$a = func_get_args();
	$email = array_shift($a);

	// la fonction normale
	$c = call_user_func_array('calcule_logo',$a);

	// si elle repond pas, on va chercher le gravatar
	if (!$c[0])
		$c[0] = gravatar($email);

	return $c;
}

function gravatar_balise_img($img,$alt="",$class=""){
	$taille = taille_image($img);
	list($hauteur,$largeur) = $taille;
	if (!$hauteur OR !$largeur)
		return "";
	return
	"<img src='$img' width='$largeur' height='$hauteur'"
	  ." alt='".attribut_html($alt)."'"
	  .($class?" class='".attribut_html($class)."'":'')
	  .' />';
}


// pour 2.1 on se contente de produire un tag IMG
function gravatar_img($email, $logo_auteur='') {
	$hasconfig = function_exists('lire_config');
	$default = '404'; // par defaut rien si ni logo ni gravatar (consigne a passer a gravatar)
	$image_default = ''; // image

	if ($hasconfig
	  AND strlen($image_default=lire_config('gravatar/image_defaut'))
		AND strpos($image_default,".")===FALSE){
		$default = $image_default; // c'est une consigne pour l'api gravatar
		$image_default = '';
	}

	// retrouver l'image du mieux qu'on peut :
	// logo_auteur si il existe
	// ou gravatar si on a un email et si on trouve le gravatar
	if (!$img = $logo_auteur){
		if (!$g = gravatar($email,$default)) // chercher le gravatar etendu pour cet email
			$img = '';
		else
			$img = gravatar_balise_img($g, "", "spip_logos photo avatar");
	}
	else {
		// changer la class du logo auteur
		$img = inserer_attribut($img, 'class', 'spip_logos photo avatar');
	}

	// si pas de config, retourner ce qu'on a
	if (!$hasconfig)
		return $img;
	
	// ensuite le mettre en forme si les options ont ete activees
	if (!$img
		AND $image_default
		AND $img = find_in_path($image_default))
		$img = gravatar_balise_img($img, "", "spip_logos photo avatar");

	if (!$img)
		return '';

	// mises en formes optionnelles du gravatar
	if ($t=lire_config('gravatar/taille')){
		$img = filtrer('image_passe_partout',$img,$t);
		$img = filtrer('image_recadre',$img,$t,$t,'center');
	}

	return $img;
}

function gravatar_verifier_index($tmp) {
	static $done = false;
	if ($done) return;
	$done = true;
	if (!file_exists($tmp.'index.php'))
		ecrire_fichier ($tmp.'index.php', '<?php
	foreach(glob(\'./*.jpg\') as $i)
		echo "<img src=\'$i\' />\n";
?>'
		);
}

function gravatar($email, $default='404') {
	static $nb=5; // ne pas en charger plus de 5 anciens par tour
	static $max=10; // et en tout etat de cause pas plus de 10 nouveaux

	// eviter une requete quand on peut
	if ($default=='404'
	  AND (!strlen($email) OR !email_valide($email)))
		return '';

	$tmp = sous_repertoire(_DIR_VAR, 'cache-gravatar');

	$md5_email = md5(strtolower($email));
	$gravatar_id = $md5_email.($default?"-$default":"");
	$gravatar_cache = $tmp.$gravatar_id.'.jpg';

	if ((!file_exists($gravatar_cache)
	OR (
		(time()-3600*24 > filemtime($gravatar_cache))
		AND $nb > 0
	  ))
	) {
		lire_fichier($tmp.'vides.txt', $vides);
		$vides = @unserialize($vides);
		if ((!isset($vides[$gravatar_id])
		OR time()-$vides[$gravatar_id] > 3600*8
		) AND $max-- > 0) {

			$nb--;
			include_spip("inc/distant");
			if ($gravatar
			= recuperer_page('http://www.gravatar.com/avatar/'.$md5_email.($default?"?d=$default":""))
			) {
				spip_log('gravatar ok pour '.$email);
				ecrire_fichier($gravatar_cache, $gravatar);
				// si c'est un png, le convertir en jpg
				$a = @getimagesize($gravatar_cache);
				if ($a[2] == 3) // png
				{
					rename($gravatar_cache, $gravatar_cache.'.png');
					include_spip('inc/filtres_images');
					$img = imagecreatefrompng($gravatar_cache.'.png');
					// Compatibilite avec la 2.1
					if(function_exists('_image_imagejpg')){
						_image_imagejpg($img, $gravatar_cache);
					}
					else
						image_imagejpg($img, $gravatar_cache);
				}
			} else {
				$vides[$gravatar_id] = time();
				ecrire_fichier($tmp.'vides.txt', serialize($vides));
			}

			gravatar_verifier_index($tmp);
		}
	}

	// On verifie si le gravatar existe en controlant la taille du fichier
	if (@filesize($gravatar_cache))
		return $gravatar_cache;
	else
		return '';
}

?>

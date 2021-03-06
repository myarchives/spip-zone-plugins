<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function photoswipe_insert_head_css($flux) {

	$flux .= "\n<link rel='stylesheet' type='text/css' media='all' href='".find_in_path("lib/photoswipe/photoswipe.css")."'>\n";
	$flux .= "\n<link rel='stylesheet' type='text/css' media='all' href='".find_in_path("lib/photoswipe/default-skin/default-skin.css")."'>\n";

	return $flux . "<style type='text/css'>
	img[data-photo].photoshow { cursor: zoom-in; }
	</style>
	";
}

function photoswipe_insert_head($flux) {
	if ((include_spip('inc/config') or function_exists('lire_config')) and lire_config('photoswipe/selecteur')) {
		$selecteur = addslashes(lire_config('photoswipe/selecteur'));
	}
	else {
		$selecteur = 'img[data-photo], a[type]';
	}
	if ((include_spip('inc/config') or function_exists('lire_config')) and lire_config('photoswipe/conteneur')) {
		$conteneurconf = addslashes(lire_config('photoswipe/conteneur'));
		/*On évite les erreurs les plus courantes (plusieurs classes entrées dans les options ou id au lieu de classe).
		La classe peut contenir des lettres, des chiffres et les caractères _ et -*/
		preg_match("/(\.[-_A-Za-z0-9]+)/i", $conteneurconf, $m);
		//On renvoie la première classe trouvée
		$conteneur = $m[1];
	}
	//Si rien ne correspond au schéma d'une classe ou qu'on a pas pu lire la config, classe par défaut
	if(!isset($conteneur)){
		$conteneur = '.photoswipe-cont';
	}
	$galerie = 'true';
	if ((include_spip('inc/config') or function_exists('lire_config')) and lire_config('photoswipe/galerie')) {
		$galerie = lire_config('photoswipe/galerie');
	}
	
	$flux = photoswipe_insert_head_css($flux); // au cas ou il n'est pas implemente

	$flux .='
<script src="'.(find_in_path('lib/photoswipe/photoswipe.min.js')).'" type="text/javascript"></script>
<script src="'.(find_in_path('lib/photoswipe/photoswipe-ui-default.min.js')).'" type="text/javascript"></script>
<script src="'.(find_in_path('photoswipe_insert.js')).'?'.filemtime(find_in_path('photoswipe_insert.js')).'" type="text/javascript"></script>
<script type="text/javascript">
// configuration
photoswipe = {
  path: "' . find_in_path('lib/photoswipe/'). '/",
  selector: "' . $selecteur . '",
  conteneur: "' . $conteneur . '",
  gallery: ' . $galerie . ', // galerie
  debug: false, // debug
};
</script>
';
	return $flux;
}

function photoswipe_post_propre($texte) {
	return filtre_photoswipe_preparer($texte);
}

function filtre_photoswipe_preparer($texte) {
	foreach (extraire_balises($texte, 'img') as $img) {
		if ($src = extraire_attribut($img, 'src')
		AND !extraire_attribut($img, 'data-photo')
		) {
			$l = largeur($img);
			$h = hauteur($img);

			if ($l > 500 OR $h > 300) {

	// pour echapper à la ligne de filtres_images_lib_mini qui remplace tout:
	// `$tag = str_replace($src,$surcharge['src'],$tag);`

				$photo_src = str_replace('.', '__.__', $src);
				$img2 = inserer_attribut($img, 'data-photo', $photo_src);
				$img2 = inserer_attribut($img2, 'data-photo-w', $l);
				$img2 = inserer_attribut($img2, 'data-photo-h', $h);
				$texte = str_replace($img, $img2, $texte);
			}
		}
	}
	return $texte;
}



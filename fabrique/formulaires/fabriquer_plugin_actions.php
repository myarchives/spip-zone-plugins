<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


// Effectue l'action demandee
// et retourne le tableau de retour de traitement du formulaire
function fabrique_action_modification_formulaire($f_action, $data) {
	// name="f_action[type]" ou "f_action[type][id]"
	$type_action = current(array_keys($f_action));
	$valeur_action = $f_action[$type_action];
	$message = '';

	switch ($type_action) {


		// Deplacement d'un objet (avec ui.tabs + ui.sortable)
		case "taborder":
			// la tab paquet, on s'en fiche
			$order = array_diff($a = explode(',', $valeur_action), array('paquet'));
			$order = array_values($order); // renumeroter
			$images = session_get(FABRIQUE_ID_IMAGES);
			$new_objets = array();
			$new_images = array();
			foreach ($order as $nom) {
				$j = substr($nom, 5); // enlever 'objet' de 'objet2'
				$new_objets[] = $data  ['objets'][$j];
				$new_images[] = $images['objets'][$j];
			}
			$data  ['objets'] = $new_objets;
			$images['objets'] = $new_images;
			session_set(FABRIQUE_ID, $data);
			session_set(FABRIQUE_ID_IMAGES, $images);
			$message = _T('fabrique:objet_deplace');
			break;



		// Deplacement d'un champ (avec ui.accordion + ui.sortable)
		case "champorder":
			$i = current(array_keys($valeur_action)); // numero d'objet
			$order = explode(',', $valeur_action[$i]); 
			$order = array_values($order); // renumeroter
			$new_champs = array();
			foreach ($order as $nom) {
				$noms = explode('-', $nom);
				$j = substr(array_pop($noms), 5); // enlever 'objetX-champ' de 'objet1-champ2'
				$new_champs[] = $data['objets'][$i]['champs'][$j];
			}
			$data['objets'][$i]['champs'] = $new_champs;
			session_set(FABRIQUE_ID, $data);
			$message = _T('fabrique:champ_deplace');
			break;



		// Ajout d'un objet
		case "ajouter_objet":
			// on ajoute un element a l'objet et a l'image.
			$images = session_get(FABRIQUE_ID_IMAGES);
			$data  ['objets'][] = array();
			$images['objets'][] = array();
			session_set(FABRIQUE_ID, $data);
			session_set(FABRIQUE_ID_IMAGES, $images);
			// on ouvre sur la nouvelle tab
			set_request('open_tab', count($data['objets']));
			$message = _T('fabrique:objet_ajoute');
			break;



		// Suppression d'un objet
		case "supprimer_objet":
			// l'objet a supprimer est dans [supprimer_objet][i]
			$i = current(array_keys($valeur_action));
			// on supprime l'element i de l'objet et des images.
			$images = session_get(FABRIQUE_ID_IMAGES);
			unset($data  ['objets'][$i]);
			unset($images['objets'][$i]);
			array_values($data  ['objets']);
			array_values($images['objets']);
			session_set(FABRIQUE_ID, $data);
			session_set(FABRIQUE_ID_IMAGES, $images);
			// on supprime l'accordion ouvert (sinon il se reouvre sur l'onglet suppression).
			$accordion = _request('open_accordion');
			unset($accordion[$i+1]);
			set_request('open_accordion', $accordion);
			$message = _T('fabrique:objet_supprime');
			break;



		// Renseigner un objet depuis une table SQL
		case "renseigner_objet":
			// l'objet a renseigner est dans [renseigner_objet][i]
			$i = current(array_keys($valeur_action));
			$data['objets'][$i] = fabrique_renseigner_objet($data['objets'][$i]);
			session_set(FABRIQUE_ID, $data);
			// on ouvre du coup le 2e accordion par defaut.
			$accordion = _request('open_accordion');
			$accordion[$i+1] = 1;
			set_request('open_accordion', $accordion);
			$message = _T('fabrique:objet_renseigne');
			break;


		// Supprimer un logo
		case "supprimer_logo":
			// i = paquet/logo | objet/n/logo_32
			$i = current(array_keys($valeur_action));
			$i = explode('/', $i);
			$type = array_shift($i);
			$images = session_get(FABRIQUE_ID_IMAGES);
			if (isset($images[$type])) {
				if (count($i) == 2) {
					unset ($images[$type][ $i[0] ][ $i[1] ]); // paquet/logo/0
				} elseif (count($i) == 3) {
					unset ($images[$type][ $i[0] ][ $i[1] ][ $i[2] ]); // obje/x/logo/0
				}
			}
			session_set(FABRIQUE_ID_IMAGES, $images);
			$message = _T('fabrique:image_supprimee');
			break;



		// Effacer les chaines de langue d'un objet
		case "reinitialiser_chaines":
			$i = current(array_keys($valeur_action));
			$data['objets'][$i]['chaines'] = array();
			session_set(FABRIQUE_ID, $data);
			$message = _T('fabrique:objet_chaines_reinitialisees');
			break;



		// Effacer les autorisations d'un objet
		case "reinitialiser_autorisations":
			$i = current(array_keys($valeur_action));
			$data['objets'][$i]['autorisations'] = array();
			session_set(FABRIQUE_ID, $data);
			$message = _T('fabrique:objet_autorisations_reinitialisees');
			break;



		// Ajouter un champ dans un objet
		case "ajouter_champ":
			$i = current(array_keys($valeur_action));
			$data['objets'][$i]['champs'][] = array();
			session_set(FABRIQUE_ID, $data);
			$message = _T('fabrique:champ_ajoute');
			break;



		// Ajouter un champ dans un objet
		case "supprimer_champ":
			$o = current(array_keys($valeur_action));
			$c = current(array_keys($valeur_action[$o]));
			unset($data['objets'][$o]['champs'][$c]);
			array_values($data['objets'][$o]['champs']);
			session_set(FABRIQUE_ID, $data);
			$message = _T('fabrique:champ_supprime');
			break;



		// par defaut, c'est qu'on s'est mal compris !
		default:
			$message = _T('fabrique:action_incomprise', array('f_action'=>$f_action));
			break;

	}


	// on ne prend pas les champs postes
	// pour que le charger() ajoute bien toutes les infos
	// supplementaires a nos tableaux (images, raccourcis...)
	set_request('objets', null);
	set_request('paquet', null);

	return array(
		'editable'=>'oui',
		'message_ok' => $message,
	);

}



/**
 * Recupere les images uploades et les stocke dans la session 
 *
**/
function fabrique_recuperer_et_stocker_les_images($data) {

	// on stocke l'image dans local/ pour les traitements d'image
	sous_repertoire(_DIR_VAR, FABRIQUE_VAR_SOURCE);

	// logo du plugin
	// _FILES[paquet][name][logo][taille]
	// _FILES[objets][name][n][logo][taille] n : numero de l'objet
	foreach (array('paquet', 'objets') as $type) {
		// on cherche s'il y a une numero d'objet intercale dans le tableau.
		$prof = !isset($_FILES[$type]['name']['logo']); // paquet : 0 / objet : 1
		$names = $prof ? $_FILES[$type]['name'] : array($_FILES[$type]['name']);
		if (is_array($names)) { // au premier objet, c'est pas forcement la
			foreach ($names as $c => $name) {
				foreach ($name['logo'] as $taille => $fichier) {
					// un fichier est envoye ?
					if ($fichier) {
						$erreur = $_FILES[$type]['error'];
						$erreur = $prof ? $erreur[$c]['logo'][$taille] : $erreur['logo'][$taille];
						if (!$erreur) {
							$ext = explode('.', $fichier);
							$ext = array_pop($ext);
							$tmp_name = $_FILES[$type]['tmp_name'];
							$tmp_name = $prof ? $tmp_name[$c]['logo'][$taille] : $tmp_name['logo'][$taille];
							$contenu = spip_file_get_contents($tmp_name);
							$images = session_get(FABRIQUE_ID_IMAGES);
							$desc = array(
								'extension' => $ext,
								'contenu' => base64_encode($contenu)
							);
							
							if ($prof) { // on est dans l'objet
								$obj = table_objet($data['objets'][$c]['table']);
								$dest = _DIR_VAR . FABRIQUE_VAR_SOURCE . $data['paquet']['prefixe'] . '_' . $obj . '_' . $taille . '.' . $ext;
								ecrire_fichier($dest, $contenu);
								$desc['fichier'] = $dest;
								$images[$type][$c]['logo'][$taille] = $desc;
							} else {
								$dest = _DIR_VAR . FABRIQUE_VAR_SOURCE . $data['paquet']['prefixe'] . '_' . $taille . '.' . $ext;
								ecrire_fichier($dest, $contenu);
								$desc['fichier'] = $dest;
								$images[$type]['logo'][$taille] = $desc;
							}
							session_set(FABRIQUE_ID_IMAGES, $images);
						}
					}
				 }
			}
		}
	}
}



/**
 * Sauvegarder 10 exports de chaque plugins (en se basant sur le prefixe)
 * ce qui permet de restaurer de vieilles versions.
 * Attention, cela ne sauve que le fichier d'export / import pour la Fabrique.
 *
 * @param string $fichier
 * 		Fichier source a sauver
 * @param string $destination
 * 		Répertoire de backup
 * @return null
**/
function fabrique_sauvegarde_tournante_export($fichier, $destination) {
	$destination .= 'exports';
	sous_repertoire_complet($destination);
	// pas de deux points dans les systemes de fichiers Windows
	$date = date("Y-m-d H-i-s");
	$base = basename($fichier, '.php');
	$copie = $base . ' ' . $date . '.php';

	$fichiers =
		new RegexIterator(
		new DirectoryIterator($destination), '/fabrique_' . substr($base, 9) . '.*\.php$/');
	// trier par date les fichiers
	$tri = array();
	foreach ($fichiers as $f) {
		$tri[$f->getMTime()] = $f->getPathname();
	}
	// enlever les vieux
	krsort($tri);
	$tri = array_slice($tri, 9);
	foreach ($tri as $f) {
		supprimer_fichier($f);
	}
	copy($fichier, $destination . '/' . $copie);
}


/**
 * Generer un diff entre la precedente generation
 * du plugin et cette nouvelle creation
 *
 * Ce diff est affiche ensuite au retour du formulaire de creation
 * et egalement stocke dans le plugin cree, dans le fichier 'fabrique_diff.diff'
 *
 * @param string $ancien
 * 		Chemin du repertoire de l'ancienne creation de plugin
 * @param string $nouveau
 * 		Chemin du repertoire de la nouvelle creation
 * @return
 * 		null
**/
function fabrique_generer_diff($ancien, $nouveau, $prefixe) {
	if (is_dir($ancien)) {
		$commande_diff = "diff -r -x fabrique_diff.diff -x fabrique_$prefixe.php $ancien $nouveau";
		$diff = "";
		exec($commande_diff, $diff);
		// chaque ligne contient une info
		// on cherche les fichiers presents dans l'ancienne version
		// supprimes de la nouvelle pour avertir
		$suppressions = array();
		foreach($diff as $l) {
			// Only in ../plugins/fabrique_auto/.backup/prefixe/dir: fichier.php
			if ($l[0] == 'O' AND substr($l, 0, 7) == 'Only in') {
				if (strpos($l, $ancien)) {
					$suppressions[] = str_replace(': ', '/', trim(substr($l, 8 + strlen($ancien))));
				}
			}
		}
		$diff = implode("\n", $diff);
		ecrire_fichier($nouveau . 'fabrique_diff.diff', $diff);
		// coloration si le plugin 'coloration_code' est la
		$diff = propre("<cadre class='diff'>\n$diff\n</cadre>");
		set_request('message_diff', $diff);
		if ($suppressions) {
			set_request('message_diff_suppressions', $suppressions);
		}
	}
}


/**
 * Execute (uniquement si webmestre) des scripts saisis dans le formulaire
 * de creation de plugin.
 *  
 *
 * @param string $quoi
 * 		Nom du type de script
 * @param array $data
 * 		Toutes les infos du formulaire
 * @param array $contexte
 * 		Variables disponibles pour les scripts (nom => valeur)
 * @return null
**/
function fabrique_executer_script($quoi, $data, $contexte = array()) {
	if (!isset($data['paquet']['scripts'][$quoi])
	OR  !$script = trim($data['paquet']['scripts'][$quoi])) {
		return;
	}
	
	// juste les webmestres pour executer des scripts, sinon ce ne serait pas tres securise
	static $autoriser = null;
	if (is_null($autoriser)) {
		$autoriser = autoriser('webmestre');
	}
	if (!$autoriser) {
		return;
	}

	extract($contexte);
	eval($script);
}
?>

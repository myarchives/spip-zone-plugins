<?php
/**
 * Plugin Emballe Medias / Wrap medias
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 * b_b (http://http://www.weblog.eliaz.fr)
 *
 * © 2008/2016 - Distribue sous licence GNU/GPL
 *
 * Fonctions utilisables dans les squelettes
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Balise #EM_LIMITE_UPLOAD affichant la taille maximale en MB d'un fichier que l'on peut mettre en ligne
 */
function balise_EM_LIMITE_UPLOAD_dist($p) {
	$p->code = 'em_limite_upload()';
	return $p;
}

/**
 * Fonction PHP affichant la taille maximale en MB d'un fichier que l'on peut mettre en ligne
 * Utilisée notamment par la balise #EM_LIMITE_UPLOAD
 */
function em_limite_upload() {
	include_spip('inc/config');
	$max_upload_php = min(intval(@ini_get('upload_max_filesize')), intval(@ini_get('post_max_size')));
	$config_max_fichier = intval(lire_config('emballe_medias/fichiers/file_size_limit'));
	if ($config_max_fichier > 0) {
		$max_upload = min($max_upload_php, $config_max_fichier);
	} else {
		$max_upload = $max_upload_php;
	}
	return $max_upload;
}
/**
 * Affiche sur le formulaire d'upload une liste d'extension de la sorte :
 * *.ext, *.ext...
 *
 * @param array $array
 * 		L'array des extensions de la configuration
 * @return string
 */
function emballe_medias_liste_extensions($array, $sep = '; *.', $debut = '*.') {
	if (!is_array($array)) {
		return _T('emballe_medias:configurer_les_extensions');
	} else {
		$liste = implode($sep, $array);
		if (!$liste) {
			return _T('emballe_medias:configurer_les_extensions');
		} else {
			$liste = $debut.$liste;
		}
	}
	return $liste;
}

function emballe_medias_liste_mimes($array) {
	if (!is_array($array)) {
		return false;
	}
	$mimes_finaux = array();
	$mimes = sql_allfetsel('mime_type', 'spip_types_documents', sql_in('extension', $array));
	foreach ($mimes as $mime) {
		$mimes_finaux[] = $mime['mime_type'];
	}
	$mimes_finaux = array_unique($mimes_finaux);
	$ret = implode(', ', $mimes_finaux);
	return $ret;
}

/**
 * La génération des extensions, utilisée par la balise #FORM_TYPE
 *
 * @return array L'array des extensions autorisées pour un type qui existe,
 * sinon un array avec toutes les extensions possibles
 * @param string $type[optional] Le type de formulaire désiré (image,video,audio,texte par défaut)
 */
function emballe_medias_generer_extensions($type = null) {
	include_spip('inc/config');
	if ($type !== null and (lire_config('emballe_medias/fichiers/gerer_types') == 'on')) {
		if (($ext = lire_config('emballe_medias/fichiers/fichiers_'.$type.'s')) && ($ext !== null)) {
			$extensions = $ext;
		} elseif (defined('_FORM_TYPE_'.strtoupper($type)) and ($ext = constant('_FORM_TYPE_'.strtoupper($type)))) {
			$extensions = explode(',', $ext);
		} elseif (!$extensions) {
			$extensions = emballe_medias_generer_extensions();
		}
	} elseif ((lire_config('emballe_medias/fichiers/gerer_types') != 'on')
			or (lire_config('emballe_medias/types/autoriser_normal') == 'on')
			or (lire_config('emballe_medias/fichiers/forcer_types') != 'on')
		) {
		$extensions = array();
		if (is_array(lire_config('emballe_medias/fichiers/fichiers_images'))) {
			$extensions = array_merge($extensions, lire_config('emballe_medias/fichiers/fichiers_images', array()));
			if (in_array('jpg', $extensions)) {
				$extensions[] = 'jpeg';
				sort($extensions);
			}
		}
		if (is_array(lire_config('emballe_medias/fichiers/fichiers_videos'))) {
			$extensions = array_merge($extensions, lire_config('emballe_medias/fichiers/fichiers_videos', array()));
		}
		if (is_array(lire_config('emballe_medias/fichiers/fichiers_audios'))) {
			$extensions = array_merge($extensions, lire_config('emballe_medias/fichiers/fichiers_audios', array()));
		}
		if (is_array(lire_config('emballe_medias/fichiers/fichiers_textes'))) {
			$extensions = array_merge($extensions, lire_config('emballe_medias/fichiers/fichiers_textes', array()));
		}
		if (!$extensions) {
			$extensions = explode(',', _FORM_TYPE_DEFAULT);
		}
	}
	return $extensions;
}

/**
 * Calcule la clé d'action pour l'action de téléchargement
 * @param string $texte
 */
function em_calculer_cle_action($texte) {
	include_spip('inc/securiser_action');
	return calculer_cle_action($texte);
}

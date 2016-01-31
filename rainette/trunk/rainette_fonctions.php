<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

if (!defined('_RAINETTE_ICONES_PATH')) {
	define('_RAINETTE_ICONES_PATH', 'rainette/');
}
if (!defined('_RAINETTE_ICONES_GRANDE_TAILLE')) {
	define('_RAINETTE_ICONES_GRANDE_TAILLE', 110);
}
if (!defined('_RAINETTE_ICONES_PETITE_TAILLE')) {
	define('_RAINETTE_ICONES_PETITE_TAILLE', 28);
}

// Balises du plugin utilisables dans les squelettes et modeles
/**
 * @param $p
 *
 * @return mixed
 */
function balise_RAINETTE_INFOS($p) {

	$code_meteo = interprete_argument_balise(1, $p);
	$code_meteo = isset($code_meteo) ? str_replace('\'', '"', $code_meteo) : '""';
	$type_info = interprete_argument_balise(2, $p);
	$type_info = isset($type_info) ? str_replace('\'', '"', $type_info) : '""';
	$service = interprete_argument_balise(3, $p);
	$service = isset($service) ? str_replace('\'', '"', $service) : '"weather"';

	$p->code = 'calculer_infos(' . $code_meteo . ', ' . $type_info . ', ' . $service . ')';
	$p->interdire_scripts = false;

	return $p;
}

/**
 * @param $lieu
 * @param $type
 * @param $service
 *
 * @return mixed|string
 */
function calculer_infos($lieu, $type, $service) {

	// Initialisation du retour
	$info = '';

	// Traitement des cas ou les arguments sont vides
	if ($lieu) {
		if (!$service) {
			$service = 'weather';
		}

		// Récupération des informations sur le lieu
		$charger = charger_fonction('charger_meteo', 'inc');
		$nom_cache = $charger($lieu, 'infos', 0, $service);
		lire_fichier($nom_cache, $contenu_cache);
		if (!isset($type) or !$type) {
			$info = $contenu_cache;
		} else {
			$tableau = unserialize($contenu_cache);
			$info = $tableau['donnees'][strtolower($type)];
		}
	}

	return $info;
}

// Filtres du plugin utilisables dans les squelettes et modeles
/**
 * @param        $meteo
 * @param string $taille
 * @param string $chemin
 * @param string $extension
 *
 * @return string
 */
function rainette_afficher_icone($meteo, $taille = 'petit', $chemin = '', $extension = 'png') {
	$taille_defaut = ($taille == 'petit') ? _RAINETTE_ICONES_PETITE_TAILLE : _RAINETTE_ICONES_GRANDE_TAILLE;

	if (is_array($meteo)) {
		// Utilisation des icones natifs des services autres que weather.com
		$resume = attribut_html(rainette_afficher_resume($meteo['code']));
		$source = $meteo['url'];
	} else {
		// Utilisation des icones weather.com
		$resume = rainette_afficher_resume($meteo);

		$meteo = ($meteo and (($meteo >= 0) and ($meteo < 48))) ? strval($meteo) : 'na';
		$chemin = (!$chemin) ? _RAINETTE_ICONES_PATH . $taille . '/' : rtrim($chemin, '/') . '/';
		$fichier = $meteo . '.' . $extension;
		// Le dossier personnalise ou le dossier passe en argument
		// a-t-il bien l'icone requise ?
		$source = find_in_path($fichier, $chemin);
		if (!$source) {
			// Non, il faut donc prendre l'icone par defaut dans le repertoire img_meteo qui existe toujours
			$source = find_in_path($fichier, "img_meteo/$taille/");
		}
	}

	// On retaille si nécessaire l'image pour qu'elle soit toujours de la même taille (grande ou petite)
	list($largeur, $hauteur) = @getimagesize($source);
	include_spip('filtres/images_transforme');
	if (($largeur < $taille_defaut)
		or ($hauteur < $taille_defaut)
	) {
		// Image plus petite que celle par défaut :
		// --> Il faut insérer et recadrer l'image dans une image plus grande à la taille par défaut
		$source = extraire_attribut(image_recadre($source, $taille_defaut, $taille_defaut, 'center', 'transparent'), 'src');
	} elseif (($largeur > $taille_defaut)
			  or ($hauteur > $taille_defaut)
	) {
		// Image plus grande que celle par défaut :
		// --> Il faut reduire l'image à la taille par défaut
		$source = extraire_attribut(image_reduire($source, $taille_defaut), 'src');
	}

	// On construit la balise img
	$texte = attribut_html($resume);
	$balise_img = "<img src=\"$source\" alt=\"$texte\" title=\"$texte\" width=\"$taille_defaut\" height=\"$taille_defaut\" />";

	return $balise_img;
}

/**
 * @param $meteo
 *
 * @return string
 */
function rainette_afficher_resume($meteo) {

	if (is_numeric($meteo)) {
		// On utilise l'option de _T permettant de savoir si un item existe ou pas
		$resume = _T('rainette:meteo_' . $meteo, array(), array('force' => false));
		if (!$resume) {
			$resume = _T('rainette:meteo_na') . " ($meteo)";
		}
	} else {
		$resume = $meteo ? $meteo : _T('rainette:meteo_na');
	}

	return ucfirst($resume);
}

/**
 * Conversion une indication de direction en une chaine traduite pour
 * l'affichage dans les modèles.
 *
 * @param    mixed $direction
 *        La direction soit sous forme d'une valeur numérique entre 0 et 360, soit sous forme
 *        d'une chaine. Certains services utilisent la chaine "V" pour indiquer une direction
 *        variable.
 *
 * @return    string
 *        La chaine traduite indiquant la direction du vent.
 */
function rainette_afficher_direction($direction) {

	include_spip('inc/convertir');
	$direction = angle2direction($direction);

	if ($direction) {
		return _T("rainette:direction_$direction");
	} else {
		return _T('rainette:valeur_indeterminee');
	}
}

/**
 * @param        $tendance_en
 * @param string $methode
 * @param string $chemin
 * @param string $extension
 *
 * @return string
 */
function rainette_afficher_tendance($tendance_en, $methode = 'texte', $chemin = '', $extension = 'png') {

	$tendance = '';

	if (($tendance_en)
		and ($texte = _T("rainette:tendance_texte_$tendance_en", array(), array('force' => false)))
	) {
		if ($methode == 'texte') {
			$tendance = $texte;
		} elseif ($methode == 'symbole') {
			$tendance = _T("rainette:tendance_symbole_$tendance_en");
		} elseif ($methode == 'icone') {
			$chemin = (!$chemin) ? _RAINETTE_ICONES_PATH : rtrim($chemin, '/') . '/';
			$fichier = $tendance_en . '.' . $extension;
			// Le dossier personnalise ou le dossier passe en argument
			// a-t-il bien l'icone requise ?
			$source = find_in_path($fichier, $chemin);
			if (!$source) {
				// Non, il faut donc prendre l'icone par defaut dans le repertoire img_meteo qui existe toujours
				$source = find_in_path($fichier, 'img_meteo/');
			}

			list($largeur, $hauteur) = @getimagesize($source);
			$tendance = "<img src=\"$source\" alt=\"$texte\" title=\"$texte\" width=\"$largeur\" height=\"$hauteur\" />";
		}
	}

	return $tendance;
}

/**
 * Affiche toute donnée météorologique au format numérique avec son unité.
 *
 *
 * @package    RAINETTE/AFFICHAGE
 * @api
 *
 * @param        int /float    $valeur            La valeur à afficher
 * @param string $type_valeur Type de données à afficher parmi 'temperature', 'pourcentage', 'angle', 'pression',
 *                                    'distance', 'vitesse', 'population', 'precipitation'
 * @param int    $precision Nombre de décimales à afficher pour les réels uniquement ou -1 pour utiliser le défaut
 * @param string $service
 *
 * @return string    La chaine calculée ou le texte désignant une valeur indéterminée
 */
function rainette_afficher_unite($valeur, $type_valeur = '', $precision = -1, $service = 'weather') {

	static $precision_defaut = array(
		'temperature'   => 0,
		'pression'      => 1,
		'distance'      => 1,
		'angle'         => 0,
		'pourcentage'   => 0,
		'population'    => 0,
		'precipitation' => 1,
		'vitesse'       => 0,
		'indice'        => 0
	);

	if (!$service) {
		$service = 'weather';
	}
	include_spip('inc/config');
	$unite = lire_config("rainette/${service}/unite", 'm');

	// On distingue la valeur NULL qui indique que la donnée météo n'est pas fournie par le service avec
	// la valeur '' qui indique que la valeur n'est pas disponible temporairement
	// Dans le cas NULL on n'affiche pas la valeur, dans le cas '' on affiche la non disponibilité
	if ($valeur === null) {
		$valeur_affichee = '';
	} else {
		$valeur_affichee = _T('rainette:valeur_indeterminee');
		if ($valeur !== '') {
			// Détermination de l'arrondi si la donnée est stockée sous format réel
			if (array_key_exists($type_valeur, $precision_defaut)) {
				$precision = ($precision < 0) ? $precision_defaut[$type_valeur] : $precision;
				$valeur = round($valeur, $precision);
			}

			// Construction de la valeur affichée en fonction de son type. Un indice ne possède pas d'unité.
			$valeur_affichee = strval($valeur);
			if ($type_valeur != 'indice') {
				$suffixe = ($type_valeur == 'population')
					? ''
					: (($unite == 'm') ? 'metrique' : 'standard');
				$espace = in_array($type_valeur, array('temperature', 'pourcentage', 'angle')) ? '' : '&nbsp;';
				$item = 'rainette:unite_' . $type_valeur . ($suffixe ? '_' . $suffixe : '');
				$valeur_affichee .= $espace . _T($item);
			}
		}
	}

	return $valeur_affichee;
}


/**
 * @param        $lieu
 * @param string $modele
 * @param string $service
 *
 * @return array|string
 */
function rainette_coasser($lieu, $mode = 'conditions', $modele = 'conditions_tempsreel', $service = 'weather', $options = array()) {

	// Initialisation du retour
	$texte = '';
	$tableau = array();

	// Détermination de la périodicité en fonction du mode et du modèle demandés
	$type_modele = 0;
	$periodicite = 0;
	$erreur = '';
	if ($mode == 'previsions') {
		// Identification de la périodicité à partir du nom du modèle. Cela évite une configuration compliquée.
		if (preg_match(',_(1|12|24)h,is', $modele, $match)) {
			$type_modele = intval($match[1]);

			// On verifie que la périodicité demandée explicitement dans l'appel du modèle est ok
			include_spip('inc/normaliser');
			if (isset($options['periodicite'])) {
				$periodicite_explicite = intval($options['periodicite']);
				if (periodicite_compatible($type_modele, $periodicite_explicite)) {
					$periodicite = $periodicite_explicite;
				} else {
					$erreur = 'modele_periodicite';
				}
			} else {
				// Dans ce cas, il faut choisir une périodicité en fonction du type du modèle et du service.
				$periodicite = trouver_periodicite($type_modele, $service);
				if (!$periodicite) {
					$erreur = 'modele_service';
				}
			}
		} else {
			// On ne connait pas le type du modèle, donc sa compatibilité.
			// Si la périodicité est passée en argument on l'utilise sans se poser de question.
			// Sinon c'est une erreur car on ne sait pas quelle périodicité est requise
			if (isset($options['periodicite'])) {
				$periodicite = intval($options['periodicite']);
			} else {
				$erreur = 'modele_inutilisable';
			}
		}
	}

	if ($erreur) {
		// On prépare un contexte extras minimal pour traiter les erreurs du modèle de façon standard
		$extras['erreur'] = $erreur;
		$extras['lieu'] = $lieu;
		$extras['mode'] = $mode;
		$extras['periodicite'] = $periodicite;
		$extras['service'] = $service;
	} else {
		// Récupération du tableau des données météo
		$charger = charger_fonction('charger_meteo', 'inc');
		$nom_cache = $charger($lieu, $mode, $periodicite, $service);
		lire_fichier($nom_cache, $contenu_cache);
		$tableau = unserialize($contenu_cache);

		// Séparation des données communes liées au service et au mode et des données météorologiques
		$extras = $tableau['extras'];
		$erreur = $extras['erreur'];

		if (!$erreur and ($mode == 'previsions')) {
			// Adaptation des données en fonction de la demande et de la périodicité modèle-cache
			$nb_index = count($tableau['donnees']);

			$jour1 = 0;
			if (isset($options['premier_jour'])) {
				$jour1 = intval($options['premier_jour']) < $nb_index
					? intval($options['premier_jour'])
					: $nb_index -1;
			}

			$nb_jours = $nb_index - $jour1;
			if (isset($options['nombre_jours'])) {
				$nb_jours = ($jour1 + intval($options['nombre_jours']) <= $nb_index)
					? intval($options['nombre_jours'])
					: $nb_index - $jour1;
			}

			$tableau['premier_jour'] = $jour1;
			$tableau['nombre_jours'] = $nb_jours;
		}
	}

	// Affichage du message d'erreur ou des données
	if ($erreur) {
		$texte = recuperer_fond('modeles/erreur', $extras);
	} else {
		// Appel du modèle avec le contexte complet
		$texte = recuperer_fond("modeles/$modele", $tableau);
	}

	return $texte;
}

include_spip('inc/debusquer');

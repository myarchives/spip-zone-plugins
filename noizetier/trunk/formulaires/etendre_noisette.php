<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

if (!function_exists('autoriser')) {
	include_spip('inc/autoriser');
}     // si on utilise le formulaire dans le public


/**
 * Formulaire listant les pages compatibles avec la noisette passée en argument et pouvant donc
 * recevoir cette même noisette dans le bloc fourni en argument.
 *
 * @param int    $noisette
 *        Tableau des informations nécessaires sur la noisette à copier, à savoir, l'id et le type de noisette.
 * @param string $bloc
 * 		  Bloc de page au sens Z.
 * @param string $redirect
 * 		URL de redirection : on revient sur la page d'origine de l'action.
 *
 * @return array
 * 		Tableau des champs postés pour l'affichage du formulaire.
 */
function formulaires_etendre_noisette_charger_dist($noisette, $page_noisette, $bloc, $redirect) {

	// Initialisation
	$valeurs = array();

	// On récupère le type de page et la composition associé au type de noisette.
	// On récupère aussi sa nature conteneur ou pas qui s'applique donc à la noisette à copier.
	$select = array('type', 'composition', 'conteneur');
	$where = array('type_noisette=' . sql_quote($noisette['type_noisette']));
	$type_noisette = sql_fetsel($select, 'spip_types_noisettes', $where);
	$valeurs['est_conteneur'] = $type_noisette['conteneur'];

	// On cherche la liste des pages:
	// - compatibles avec la noisette
	// - dont le bloc concerné est bien configurable
	// - pouvant être configurées par l'utilisateur
	$select = array('nom', 'page', 'blocs_exclus');
	$where = array();
	if (!empty($type_noisette['type'])) {
		$where[] = 'type=' . sql_quote($type_noisette['type']);
	}
	if (!empty($type_noisette['composition'])) {
		$where[] = 'composition=' . sql_quote($type_noisette['composition']);
	}
	$pages = sql_allfetsel($select, 'spip_noizetier_pages', $where);
	$valeurs['_pages'] = array();
	if ($pages) {
		foreach ($pages as $_page) {
			if (($_page['page'] != $page_noisette)
			and (!in_array($bloc, unserialize($_page['blocs_exclus'])))
			and autoriser('configurerpage', 'noizetier', 0, '', array('page' => $_page['page']))) {
				$valeurs['_pages'][$_page['page']] = _T_ou_typo($_page['nom']) . " (<em>{$_page['page']}</em>)";
			}
		}
	}

	if ($valeurs['_pages']) {
		$valeurs['editable'] = true;
	} else {
		$valeurs['editable'] = false;
	}

	return $valeurs;
}

function formulaires_etendre_noisette_verifier_dist($noisette, $page_noisette, $bloc, $redirect) {

	$erreurs = array();
	if (!_request('pages')) {
		$erreurs['pages'] = _T('noizetier:erreur_aucune_page_selectionnee');
	}

	return $erreurs;
}


function formulaires_etendre_noisette_traiter_dist($noisette, $page_noisette, $bloc, $redirect) {

	$retour = array();

	// Récupération des pages sélectionnées.
	$pages = _request('pages');

	// Construire la liste des paramètres à diffuser dans les noisettes copiées.
	$parametres = array();
	$champs = array('copie_parametres', 'copie_encapsulation', 'copie_css');
	foreach ($champs as $_champ) {
		if (_request($_champ)) {
			$champ_noisette = str_replace('copie_', '', $_champ);
			$parametres[] = $champ_noisette;
		}
	}

	// Pour chaque page on copie la noisette avec tous ses paramètres.
	// Il est inutile de tester l'autorisation sur la page car cela a déjà été fait lors du chargement.
	include_spip('inc/ncore_noisette');
	$erreurs = array();
	$conteneur = array();
	foreach ($pages as $_page) {
		// Définir le conteneur de la noisette, à savoir, le squelette du bloc de la page concernée.
		$conteneur['squelette'] = "${bloc}/${_page}";
		if (!noisette_dupliquer('noizetier', $noisette['id_noisette'], $conteneur, $parametres)) {
			$erreurs[] = $_page;
		}
	}

	if (!$erreurs) {
		$retour['message_ok'] = _T('info_modification_enregistree');
		$retour['redirect'] = $redirect;
	} else {
		$retour['message_erreur'] =
			_T('noizetier:erreur_etendre_noisette', array('pages', implode(', ', $erreurs)));
	}

	return $retour;
}

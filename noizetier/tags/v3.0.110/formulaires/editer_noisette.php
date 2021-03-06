<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

if (!function_exists('autoriser')) {
	include_spip('inc/autoriser');
}     // si on utilise le formulaire dans le public

function formulaires_editer_noisette_charger_dist($id_noisette, $redirect = '') {

	$valeurs = array('editable' => false);

	if (autoriser( 'editernoisette', 'noizetier', $id_noisette)) {
		// Récupération des informations sur la noisette en cours d'édition et sur le type de noisette
		include_spip('inc/ncore_noisette');
		$noisette = noisette_lire('noizetier', intval($id_noisette));

		if ($noisette) {
			// Id de la noisette
			$valeurs['id_noisette'] = intval($id_noisette);
			// Type de la noisette
			$valeurs['type_noisette'] = $noisette['type_noisette'];
			$valeurs['est_conteneur'] = $noisette['est_conteneur'];

			// Configuration standard de la noisette définie dans son fichier YAML.
			// Cette configuration peut comporter des paramètres de saisie spécifiques dont les valeurs sont ensuite
			// stockées dans le champ 'parametres' de la table 'spip_noisettes'.
			// Cette structure de formulaire est générée automatiquement par le plugin Saisies.
			// Récupération des informations sur le type de noisette
			include_spip('inc/ncore_type_noisette');
			$champs = type_noisette_lire('noizetier', $noisette['type_noisette'], 'parametres');
			$valeurs['_champs_noisette'] = $champs;

			// Insérer dans le contexte les valeurs des paramètres spécifiques stockées en BD.
			// On doit passer par saisies_charger_champs() au cas ou la définition de la noisette a changé
			// et qu'il y a de nouveaux champs à prendre en compte
			include_spip('inc/saisies');
			$parametres = $noisette['parametres'];
			$valeurs = array_merge($valeurs, saisies_charger_champs($valeurs['_champs_noisette']), $parametres);

			// Insérer dans le contexte les saisies des paramètres d'encapsulation stockées en BD si la noisette
			// n'est pas un conteneur.
			// Ces paramètres généraux sont inclus manuellement dans le formulaire.
			$valeurs['encapsulation'] = $noisette['encapsulation'];
			$valeurs['css'] = $noisette['css'];
			if ($noisette['est_conteneur'] != 'oui') {
				// Construction de la liste des valeurs possibles pour le choix de la encapsulation
				$valeurs['_champs_capsule'] = noizetier_saisies_encapsulation($valeurs['encapsulation']);
			}

			$valeurs['editable'] = true;
		}
	}

	return $valeurs;
}


function formulaires_editer_noisette_verifier_dist($id_noisette, $redirect = '') {

	$erreurs = array();

	// Vérifier les champs correspondant aux paramètres spécifiques de ce type de noisette
	include_spip('inc/ncore_type_noisette');
	$champs = type_noisette_lire(
		'noizetier',
		 _request('type_noisette'),
		 'parametres',
		 false);

	// La noisette n'est pas un conteneur on ajoute aussi les paramètres de la capsule pour vérification.
	if (_request('est_conteneur') != 'oui') {
		// Construction de la liste des valeurs possibles pour le choix de la encapsulation
		$saisies_capsule = noizetier_saisies_encapsulation(_request('encapsulation'));

		// On rajoute ces paramètres à ceux de la noisette.
		$champs = array_merge($champs, $saisies_capsule);
	}

	if ($champs) {
		include_spip('inc/saisies');
		$erreurs = saisies_verifier($champs, false);
	}

	return $erreurs;
}


function formulaires_editer_noisette_traiter_dist($id_noisette, $redirect = '') {

	$retour = array();

	if (autoriser( 'editernoisette', 'noizetier', $id_noisette)) {
		// On constitue le tableau des valeurs des paramètres spécifiques de la noisette
		include_spip('inc/ncore_type_noisette');
		$champs = type_noisette_lire(
			'noizetier',
			 _request('type_noisette'),
			 'parametres',
			 false);
		$parametres = array();
		if ($champs) {
			include_spip('inc/saisies_lister');
			foreach (saisies_lister_champs($champs, false) as $_champ) {
				$parametres[$_champ] = _request($_champ);
			}
		}

		// Paramètres généraux d'inclusion de la noisette : on distingue les noisettes conteneur et les autres.
		// Pour les noisettes conteneur, l'encapsulation et les css ne sont pas éditables.
		$valeurs = array('parametres' => serialize($parametres));
		if (_request('est_conteneur') != 'oui') {
			include_spip('inc/config');
			$encapsulation = _request('encapsulation');
			$css = _request('css');
			if (($encapsulation == 'non') or (($encapsulation == 'defaut') and !lire_config('noizetier/encapsulation_noisette'))) {
				// on remet à zéro les css si la capsule englobante n'est pas active
				$css = '';
			}
			$valeurs = array_merge($valeurs, array('encapsulation' => $encapsulation, 'css' => $css));
		}

		// Fermeture de la modale
		$autoclose = "<script type='text/javascript'>if (window.jQuery) jQuery.modalboxclose();</script>";

		// Mise à jour de la noisette en base de données
		include_spip('inc/ncore_noisette');
		if (noisette_parametrer('noizetier', intval($id_noisette), $valeurs)) {
			// On invalide le cache
			include_spip('inc/invalideur');
			suivre_invalideur("id='noisette/$id_noisette'");
			$retour['message_ok'] = _T('info_modification_enregistree') . $autoclose;
			if ($redirect) {
				if (strncmp($redirect, 'javascript:', 11) == 0) {
					$retour['message_ok'] .= '<script type="text/javascript">/*<![CDATA[*/'.substr($redirect, 11).'/*]]>*/</script>';
					$retour['editable'] = true;
				} else {
					$retour['redirect'] = $redirect;
				}
			}
		} else {
			$retour['message_erreur'] = _T('noizetier:erreur_mise_a_jour');
		}
	} else {
		$retour['message_erreur'] = _T('noizetier:probleme_droits');
	}

	return $retour;
}


function noizetier_saisies_encapsulation($encapsulation) {

	// Construction de la liste des valeurs possibles pour le choix de l'encapsulation
	include_spip('ncore/ncore');
	$config_encapsulation = ncore_noisette_initialiser_encapsulation('noizetier')
		? _T('noizetier:option_noizetier_encapsulation_oui')
		: _T('noizetier:option_noizetier_encapsulation_non');
	$options_encapsulation = array(
		'defaut' => _T('noizetier:option_noisette_encapsulation_defaut', array('defaut' => lcfirst($config_encapsulation))),
		'oui'    => _T('noizetier:option_noisette_encapsulation_oui'),
		'non'    => _T('noizetier:option_noisette_encapsulation_non')
	);

	// Construction des saisies pour les paramètres de base d'une capsule (encapsulation, css).
	$saisies = array(
		array(
			'saisie'  => 'radio',
			'options' => array(
				'nom'    => 'encapsulation',
				'label'  => '<:noizetier:label_noisette_encapsulation:>',
				'datas'  => $options_encapsulation,
				'defaut' => $encapsulation
			),
		),
		array(
			'saisie'  => 'input',
			'options' => array(
				'nom'    => 'css',
				'label'  => '<:noizetier:label_noisette_css:>',
				'explication' => '<:noizetier:explication_noisette_css:>'
			),
			'verifier' => array (
				'type' => 'attribut_class'
			),
		),
	);

	return $saisies;
}

<?php
/**
 * Fonction d'upgrade/installation du plugin foundation-4-spip
 *
 * @plugin     foundation_6
 * @copyright  2013
 * @author     Phenix
 * @licence    GNU/GPL
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/*
 *   Configuration de base:
 *   - Foundation desactivé
 *   - Pas de Javascript chargé.
 */
function foundation_6_upgrade($nom_meta_base_version, $version_cible) {

	// Création du tableau des mises à jour.
	$maj = array();

	$config_default = array(
		'javascript' => '',
	);

	// Tableau de la configuration par défaut
	$maj['create'] = array(
		array('ecrire_meta', 'foundation_6', serialize($config_default))
	);

	// Maj du plugin.
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

/*
 *   Désintaller foundation.
 */
function foundation_6_vider_tables($nom_meta_base_version) {
	// Supprimer les méta, ou oublie pas celle de la base.
	effacer_meta('foundation_6_base_version');
	effacer_meta('foundation_6');
}

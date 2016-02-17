<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Ayants droit
 *
 * @plugin     Ayants droit
 * @copyright  2016
 * @author     Les Développements Durables
 * @licence    GNU/GPL v3
 * @package    SPIP\Ayantsdroit\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Fonction d'installation et de mise à jour du plugin Ayants droit.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function ayantsdroit_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	$maj['create'] = array(
		array('maj_tables', array('spip_droits_ayants', 'spip_droits_contrats'))
	);
	
	// Ajout du champ "montant"
	$maj['1.1.0'] = array(
		array('maj_tables', array('spip_droits_contrats'))
	);

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Ayants droit.
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function ayantsdroit_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_droits_ayants");
	sql_drop_table("spip_droits_contrats");

	# Nettoyer les versionnages et forums
	sql_delete("spip_versions",              sql_in("objet", array('droits_ayant', 'droits_contrat')));
	sql_delete("spip_versions_fragments",    sql_in("objet", array('droits_ayant', 'droits_contrat')));
	sql_delete("spip_forum",                 sql_in("objet", array('droits_ayant', 'droits_contrat')));

	effacer_meta($nom_meta_base_version);
}

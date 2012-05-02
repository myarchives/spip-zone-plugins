<?php
/**
 * @name 		Installation
 * @author 		Piero Wbmstr <@link piero.wbmstr@gmail.com>
 * @license		http://creativecommons.org/licenses/by-nc-sa/3.0/ Creative Commons BY-NC-SA
 * @version 	1.0 (06/2009)
 * @package		Pub Banner
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Installation/maj des tables publicites
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function pubban_upgrade($nom_meta_base_version,$version_cible) 
{
	$maj = array();
	$inserer_exemples = false;

	// Si pas installe : on creer les tables et on insere les bannieres de test
	$maj['create'] = array(
		array('maj_tables',array('spip_publicites','spip_bannieres','spip_pubban_stats','spip_bannieres_publicites')),
		array('pubban_inserer_exemples')
	);

	spip_log("Plugin PUB BANNER - installation OK - tables creees ou mises a jour en base");
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

function pubban_inserer_exemples()
{
	include_spip('base/pubban_chargeur');
	foreach($GLOBALS['bannieres_site'] as $key => $value)
		sql_insertq('spip_bannieres', $value, '');
	foreach($GLOBALS['publicites_site'] as $key => $value){
		$id_empl = $value['id_banniere'];
		unset($value['id_banniere']);
		$id_pub = sql_insertq('spip_publicites', $value, '');
		if($id_pub) sql_insertq('spip_bannieres_publicites', array('id_publicite'=>$id_pub, 'id_banniere'=>$id_empl), '');
	}
	spip_log("Plugin PUB BANNER - valeurs de tests inserees");
}

function pubban_vider_tables($nom_meta_base_version) 
{
	// Flag pour forcer l'effacement ?
	$force = (defined('PUBBAN_FORCE_UNINSTALL') AND PUBBAN_FORCE_UNINSTALL==1) ? true : false;

	// On verifie qu'il n'y ait pas de valeurs enregistrees
	$count_join = $force ? 0 : sql_countsel('spip_bannieres_publicites');
	$count_stats = $force ? 0 : sql_countsel('spip_pubban_stats');
//	echo 'join : '.$count_join.' et stats : '.$count_stats; exit;

	// Si ok, on efface
	if($count_join==0 AND $count_stats==0){
		sql_drop_table('spip_publicites');
		sql_drop_table('spip_bannieres');
		sql_drop_table('spip_pubban_stats');
		sql_drop_table('spip_bannieres_publicites');
		effacer_meta($nom_meta_base_version);
	}
	// Sinon, on informe
	else {
		spip_log("Plugin PUB BANNER - uninstall pas possible car $count_join pubs et $count_stats statisqtiques en base ! - forcer l'effacement avec PUBBAN_FORCE_UNINSTALL=true dans 'pubban_options.php'");
		return false;
	}

	return true;
}

?>
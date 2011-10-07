<?php
/**
* Plugin montant
*
* Copyright (c) 2011
* Anne-lise Martenot elastick.net
*  
**/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');
include_spip('base/create');

function montants_upgrade($nom_meta_base_version, $version_cible){

	$current_version = "0.0";
	
	if (isset($GLOBALS['meta'][$nom_meta_base_version]))
		$current_version = $GLOBALS['meta'][$nom_meta_base_version];

	if ($current_version=="0.0") {
		creer_base();
		ecrire_meta($nom_meta_base_version, $current_version=$version_cible);
	}

	if (version_compare($current_version,"0.1","<")){
		sql_alter("TABLE spip_montants ADD taxe decimal(4,3) default null");
		sql_alter("TABLE spip_montants ADD descriptif text NOT NULL");
		ecrire_meta($nom_meta_base_version,$current_version=0.1);
	}
	
	if (version_compare($current_version,"0.2","<")){
		sql_alter("TABLE spip_montants CHANGE le_parent le_parent tinytext NOT NULL");
		ecrire_meta($nom_meta_base_version,$current_version=0.2);
	}

}

function montants_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_montants");
	effacer_meta($nom_meta_base_version);
}
	

		

?>

<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/cextras');
include_spip('base/metas_opengraph');



function metas_opengraph_upgrade($nom_meta_base_version,$version_cible){

	$maj = array();
	cextras_api_upgrade(metas_opengraph_declarer_champs_extras(), $maj['create']);	

	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
	
}

function metas_opengraph_vider_tables($nom_meta_base_version) {
	cextras_api_vider_tables(metas_opengraph_declarer_champs_extras());
	effacer_meta($nom_meta_base_version);
}

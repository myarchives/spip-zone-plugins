<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


function a2a_install($action){
	
	$version_locale = 0.3;
	
	switch ($action){
		case 'test':
			
			$version_installee = lire_meta('version_a2a');
			if ($version_installee){
			if ($version_locale > $version_installee){
				if (version_compare($version_installee,"0.2","<")){
					sql_alter("TABLE spip_articles_lies  ADD rang BIGINT( 21 ) NOT NULL");
					ecrire_meta('version_a2a',$version_installee="0.2");
				}
				if (version_compare($version_installee,"0.3","<")){
					sql_alter("TABLE spip_articles_lies CHANGE rang rang bigint(21) NOT NULL DEFAULT '0'");
					ecrire_meta('version_a2a',$version_installee="0.3");
				}
				return false;
			}else{
				return true;
			}}
			
		break;
		
		case 'install':
			spip_log('Installation plugin a2a '.$version_locale);
			include_spip('base/a2a');
			include_spip('base/create');
			include_spip('base/abstract_sql');
			include_spip('inc/import_origine');
			creer_base();
			ecrire_meta('version_a2a',$version_locale);
			ecrire_metas();
		break;
		
		case 'uninstall':
			$sql_supprimer_table = "DROP TABLE `spip_articles_lies`";
			spip_query($sql_supprimer_table);
			effacer_meta('version_a2a');
			ecrire_metas();
		break;
	}
}

?>

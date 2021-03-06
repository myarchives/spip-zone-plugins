<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');

// Installation et mise à jour
function formidable_upgrade($nom_meta_version_base, $version_cible){

	$version_actuelle = '0.0';
	if (
		(!isset($GLOBALS['meta'][$nom_meta_version_base]))
		|| (($version_actuelle = $GLOBALS['meta'][$nom_meta_version_base]) != $version_cible)
	){
		
		if (version_compare($version_actuelle,'0.0','=')){
			// Création des tables
			include_spip('base/create');
			include_spip('base/abstract_sql');
			creer_base();
			
			echo "Installation du plugin formidable<br/>";
			ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
		}
		
		/*if (version_compare($version_actuelle,'0.5','<')){
			include_spip('base/create');
			include_spip('base/abstract_sql');
			
			// Modification de formidable
			sql_alter('');
						
			// On change la version
			echo "Mise à jour du plugin formidable en version 0.5<br/>";
			ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
		}*/
		
		if (version_compare($version_actuelle,'0.5.7','<')){	
			include_spip('base/create');
      maj_tables('spip_formulaires');
			
			echo "Mise à jour du plugin formidable en version 0.5.7<br/>";
			ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
		}
		
		if (version_compare($version_actuelle,'0.6.5','<')){	
			include_spip('base/create');
      maj_tables('spip_formulaires');
			
			echo "Mise à jour du plugin formidable en version 0.6.5<br/>";
			ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
		}
	}
	
}

// Désinstallation
function formidable_vider_tables($nom_meta_version_base){

	include_spip('base/abstract_sql');
	
	// On efface les tables du plugin
	sql_drop_table('spip_formulaires');
	sql_drop_table('spip_formulaires_reponses');
	sql_drop_table('spip_formulaires_reponses_champs');
	sql_drop_table('spip_formulaires_liens');
		
	// On efface la version entregistrée
	effacer_meta($nom_meta_version_base);

}

?>
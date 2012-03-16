<?php
/**
 * Fichier d'installation / upgrade et désinstallation du plugin manuel site
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction d'upgrade/maj
 * On crée une configuration par défaut
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function manuelsite_upgrade($nom_meta_base_version,$version_cible){
	
	$maj = array();
	
	$maj['create'] = array(
		array('manuelsite_creer_config'),
	);
	
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}

function manuelsite_creer_config(){
	include_spip('inc/config');
	$config = lire_config('manuelsite');
	if (!is_array($config)) {
		$config = array();
	}
	$config_defaut = array_merge(array(
			'id_article' => '0',
			'cacher_public' => '',
			'intro' => _T('manuelsite:intro'),
			'email' => '',
			'afficher_bord_gauche' => 'on',
			'largeur' => '300',
			'background_color' => '#D6DDE5'
	), $config);
	
	ecrire_meta('manuelsite', serialize($config_defaut));
}

/**
 * Fonction de desinstallation
 * On efface uniquement la méta d'installation
 *
 * @param float $nom_meta_base_version
 */
function manuelsite_vider_tables($nom_meta_base_version) {
	effacer_meta('manuelsite');
	effacer_meta($nom_meta_base_version);
}

?>
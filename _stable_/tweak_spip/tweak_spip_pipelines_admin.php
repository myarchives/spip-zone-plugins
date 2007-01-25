<?php
include_spip('tweak_spip');
/*
if (!defined('_DIR_PLUGIN_TWEAK_SPIP')){
	$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
	define('_DIR_PLUGIN_TWEAK_SPIP',(_DIR_PLUGINS.end($p)));
}

function tweak_spip_affiche_droite($flux){
	return tweak_pipeline('affiche_droite', $flux);
}
function tweak_spip_affiche_gauche($flux){
	return tweak_pipeline('affiche_gauche', $flux);
}
function tweak_spip_affiche_milieu($flux){
	return tweak_pipeline('affiche_milieu', $flux);
}
function tweak_spip_ajouter_boutons($flux){
	return tweak_pipeline('ajouter_boutons', $flux);
}
*/
function tweak_spip_ajouter_onglets($flux){
	// si on est admin
	if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]) 
		if ($flux['args']=='configuration')
			$flux['data']['tweak_spip']= new Bouton("administration-24.gif", _T('tweak:titre'), generer_url_ecrire("tweak_spip_admin"));
	return $flux;
}
/*
function tweak_spip_body_prive($flux){
	return tweak_pipeline('body_prive', $flux);
}
function tweak_spip_exec_init($flux){
	return tweak_pipeline('exec_init', $flux);
}
*/
function tweak_spip_header_prive($flux){
	$flux .= "\n<!-- header TWEAKS -->\n"
		. tweak_insert_header('css')
		. tweak_insert_header('js');
	global $tweaks_metas_pipes;
	eval($tweaks_metas_pipes['header_prive']);
	return $flux;
}
function tweak_spip_install($action){
tweak_log("tweak_spip_install($action)");
	include_spip('inc/meta');
	switch ($action){
		case 'test':
			return isset($GLOBALS['meta']['tweaks_actifs']);
			break;
		case 'install':
			break;
		case 'uninstall':
			effacer_meta('tweaks_actifs');
			effacer_meta('tweaks_variables');
			effacer_meta('tweaks_pipelines');
			ecrire_metas();
			break;
	}
}	


?>
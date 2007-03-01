<?php
$p = explode(basename(_DIR_PLUGINS)."/", str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_ACCESGROUPES',(_DIR_PLUGINS.end($p)));
	
function accesgroupes_ajouter_boutons($boutons_admin) {
	// si on est admin
	if ($GLOBALS['connect_statut'] == "0minirezo") {
		// on voit le bouton comme  sous-menu de "auteurs"
		$boutons_admin['auteurs']->sousmenu['accesgroupes_admin']= new Bouton("../"._DIR_PLUGIN_ACCESGROUPES."/img_pack/groupe-24.png", _T('accesgroupes:module_titre') );
		//$boutons_admin['auteurs']->sousmenu['accesgroupes_admin192']= new Bouton("../"._DIR_PLUGIN_ACCESGROUPES."/img_pack/groupe-24.png", _T('accesgroupes:module_titre') );
	}
	return $boutons_admin;
}

function accesgroupes_affiche_milieu($flux){
	$exec = $flux['args']['exec'];
	if (($exec == 'auteurs_edit') || ($exec == 'auteur_infos')){
		//include_spip('inc/accesgroupes_gestion');
		$id_auteur = $flux['args']['id_auteur'];
		$nouv_grp = _request('nouv_grp');
		$supp_grp = _request('supp_grp');
		// le formulaire qu'on ajoute
		global $connect_statut;
		$flux['data'] .= accesgroupes_formulaire_zones('auteurs', $id_auteur, $nouv_zone, $supp_zone, $connect_statut == '0minirezo', generer_url_ecrire('auteurs_edit',"id_auteur=$id_auteur"));
	}
	return $flux;
}
?>
<?php
//
//	Spip-boutique
//
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_SPIPDIGG',(_DIR_PLUGINS.end($p)));

function boutique_ajouter_boutons($flux){
	$flux['naviguer']->sousmenu['produits_page']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/produits.png",_T('boutique:les_produits'));
	$flux['naviguer']->sousmenu['cadis_page']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/cadis.png",_T('boutique:les_cadis'));
	$flux['naviguer']->sousmenu['categories_page']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/categories.png",_T('boutique:les_categories'));
	$flux['forum']->sousmenu['forums_boutique']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/forums.png",_T('boutique:les_forum_de_boutique'));
	$flux['auteurs']->sousmenu['clients_boutique']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/clients.png",_T('boutique:les_clients'));
	if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]){
		$flux['configuration']->sousmenu['configuration_boutique']= new Bouton("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/configuration.png",_T('boutique:configurer_boutique'));
	}
	return $flux;
}

?>

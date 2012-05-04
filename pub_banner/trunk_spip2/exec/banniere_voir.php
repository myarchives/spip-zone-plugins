<?php
/**
 * @name 		Bannieres
 * @author 		Piero Wbmstr <@link piero.wbmstr@gmail.com>
 * @license		http://creativecommons.org/licenses/by-nc-sa/3.0/ Creative Commons BY-NC-SA
 * @version 	1.0 (06/2009)
 * @package		Pub Banner
 * @subpackage	Pages exec
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

function exec_banniere_voir_dist() {
	global $connect_statut, $connect_id_auteur, $spip_lang_right;
	if ($connect_statut != "0minirezo" ) { include_spip('inc/minipres'); echo minipres(); exit; }
	include_spip('inc/presentation');
	include_spip('inc/pubban_process');
	$commencer_page = charger_fonction('commencer_page', 'inc');
 	$titre_page = _T('pubban:details_empl');
	$rubrique = 'pubban';
	$sous_rubrique = "home_pub";

	$id_banniere = _request('id_banniere');
	$empl = pubban_recuperer_banniere($id_banniere);
	$list_pub = pubban_pubs_de_la_banniere($id_banniere);
	$s = ($empl['statut'] == '5poubelle') ? '3' : ( ($empl['statut'] == '1inactif') ? '2' : '1' );
	$titre_empl = ( $id_banniere != '0' ) ? "<div class='numero'>"._T('pubban:titre_info_empl')."<p>".$id_banniere."</p>" : "<div class='numero'>"._T('pubban:titre_nouvel_empl') ;
	$boite = "<div class='cadre_padding'><div class='infos'>"
		.$titre_empl
		."<ul id='instituer_banniere-".$id_banniere."' class='instituer_banniere instituer'><li>"._T('pubban:empl_is')."&nbsp;:"
		."<ul>"
		."<li class='publie ".(($s == '1') ? "selected" : "" )."'><a href='".generer_action_auteur("activer_banniere", "activer-$id_banniere", self('&'))."' onclick='return confirm(confirm_changer_statut);'><img src='../prive/images/puce-verte.gif' alt=\""._T('pubban:actif')."\"  />"._T('pubban:actif')."</a></li>"
		."<li class='prop ".(($s == '2') ? "selected" : "" )."'><a href='".generer_action_auteur("activer_banniere", "desactiver-$id_banniere", self('&'))."' onclick='return confirm(confirm_changer_statut);'><img src='../prive/images/puce-rouge.gif' alt=\""._T('pubban:inactif')."\"  />"._T('pubban:inactif')."</a></li>"
		."<li class='poubelle ".(($s == '3') ? "selected" : "" )."'><a href=\"javascript:delete_entry('".generer_action_auteur("activer_banniere", "trash-$id_banniere", generer_url_ecrire('bannieres_tous'))."', '"._T('pubban:confirm_delete_empl')."');\"><img src='../prive/images/puce-poubelle.gif' alt=\""._T('pubban:poubelle')."\"  />"._T('pubban:poubelle')."</a></li>"
		."</ul></li></ul>"
		."</div><div class='nettoyeur'></div></div></div>";

	$res = icone_horizontale(_T('pubban:home'), generer_url_ecrire("pubbanner"), find_in_path("img/stock_home.png"), "rien.gif", false)
		. icone_horizontale(_T('pubban:retour_liste_empl'), generer_url_ecrire("bannieres_tous"), find_in_path("img/stock_left.png"), "rien.gif", false)
		. icone_horizontale(_T('pubban:nouveau_empl'), generer_url_ecrire('banniere_edit','id_banniere=new'), find_in_path("img/stock_insert-image.png"), "creer.gif", false)
		. icone_horizontale(_T('pubban:page_stats'), generer_url_ecrire('statistiques_bannieres'), find_in_path("img/stock-tool-button-color-balance.png"), "rien.gif", false);
	$trash = pubban_poubelle_pleine();
	if($trash) $res .= icone_horizontale(_T('pubban:open_trash'), generer_url_ecrire('pubbanner','mode=trash'), find_in_path("img/stock_delete.png"), "rien.gif", false);

	$contexte = array(
		'id_banniere' => $id_banniere,
		'icone_editer' => icone_inline(_T('bouton_modifier'), generer_url_ecrire("banniere_edit","id_banniere=$id_banniere"), find_in_path("img/stock_edit.png"), "rien.gif",$GLOBALS['spip_lang_right']),
		'icone_nouvelle_pub' => icone_inline(_T('pubban:nouveau_pub_dans_banniere'), generer_url_ecrire("publicite_edit","id_publicite=new&id_banniere=$id_banniere"), find_in_path("img/stock_insert-object.png"), "creer.gif",$GLOBALS['spip_lang_right']),
		'redirect'=> generer_url_ecrire("banniere_voir"),
		'btn_apercu' => $GLOBALS['pubban_btns']['apercu'],
		'btn_editer' => $GLOBALS['pubban_btns']['editer'],
		'btn_poubelle' => $GLOBALS['pubban_btns']['poubelle'],
		'btn_inactive' => $GLOBALS['pubban_btns']['inactif'],
		'btn_active' => $GLOBALS['pubban_btns']['actif'],
		'btn_obsolete' => $GLOBALS['pubban_btns']['obsolete'],
		'decompte_pub' => $list_pub ? count($list_pub) : 0,
		'decompte_pub_actives' => 0,
		'decompte_pub_inactives' => 0,
		'decompte_pub_obsoletes' => 0,
		'listing_pub' => array(),
	);
	if ($list_pub && count($list_pub))
	foreach($list_pub as $k=>$id_publicite){
		$statut = pubban_recuperer_publicite($id_publicite, 'statut');
		$contexte['listing_pub'][] = $id_publicite;
		if($statut == '2actif') $contexte['decompte_pub_actives']++;
		elseif($statut == '1inactif') $contexte['decompte_pub_inactives']++;
		elseif($statut == '3obsolete') $contexte['decompte_pub_obsoletes']++;
	}
	$milieu = recuperer_fond("prive/banniere_voir",$contexte);

	echo($commencer_page(_T('pubban:pubban')." - ".$titre_page, $rubrique, $sous_rubrique)), debut_gauche('', true),
		"<br />" . debut_boite_info(true). $boite . fin_boite_info(true), bloc_des_raccourcis($res);
	if(_request('retour')) echo icone_inline(_T('pubban:retour_search'), _request('retour'), find_in_path("img/stock_search.png"), "rien.gif", $GLOBALS['spip_lang_left']);
	echo creer_colonne_droite('', true), debut_droite('', true), debut_cadre_trait_couleur(false, true),
		pipeline('affiche_milieu', array( 'args' => array( 'exec' => 'banniere_voir' ), 'data' => $milieu ) ),
		fin_cadre_trait_couleur(true), fin_gauche(), fin_page();
}
?>
<?php
/*
 * Spip SMS Liste
 * Gestion de liste de diffusion de SMS
 *
 * Auteur :
 * Cedric Morin
 * (c) 2007 - Distribue sous licence GNU/GPL
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('inc/smslist_affichage');
include_spip('base/forms_base_api');
include_spip('public/assembler');

function tables_ou_donnees($type_form,$retour){
	$res = spip_query("SELECT id_form FROM spip_forms WHERE type_form="._q($type_form));
	if (spip_num_rows($res)==1){
		$row = spip_fetch_array($res);
		return generer_url_ecrire("donnees_tous","id_form=".$row['id_form']."&retour=".urlencode($retour));
	}
	else
		return generer_url_ecrire($type_form."s_tous","retour=".urlencode($retour));
}

function exec_spip_sms_listes() {
	
	$commencer_page = charger_fonction('commencer_page', 'inc');
	if (!autoriser('administrer','smslist')) {
		echo $commencer_page(_L('Spip-sms-listes'),"", "redacteurs", "smslist");
		echo "<strong>"._T('avis_acces_interdit')."</strong>";
		echo fin_page();
		exit;
	}
	
	// Admin Spip-sms-listes
	echo $commencer_page(_L('Spip-sms-listes'),"", "redacteurs", "smslist");
	//echo smslist_onglets("smslist", "Spip-SMS-Listes");
	
	echo debut_gauche("smslist",true);
	//echo smslist_raccourcis();
	
	$retour = generer_url_ecrire('spip_sms_listes');

	$gerer = tables_ou_donnees('smslist_message',$retour);
	echo icone_etendue(_T("smslist:icone_gerer_messages"), $gerer, _DIR_PLUGIN_SMSLIST. "img_pack/smslist_message-64.png", "rien.gif",false);
		
	$gerer = tables_ou_donnees('smslist_liste',$retour);
	echo icone_etendue(_T("smslist:icone_gerer_listes"), $gerer, _DIR_PLUGIN_SMSLIST. "img_pack/smslist_liste-64.png", "rien.gif",false);

	$gerer = tables_ou_donnees('smslist_abonne',$retour);
	echo icone_etendue(_T("smslist:icone_gerer_abonnes"), $gerer, _DIR_PLUGIN_SMSLIST. "img_pack/smslist_abonne-64.png", "rien.gif",false);
	
	$gerer = tables_ou_donnees('smslist_boiteenvoi',$retour);
	echo icone_etendue(_T("smslist:icone_boite_d_envoi"), $gerer, _DIR_PLUGIN_SMSLIST. "img_pack/smslist_boiteenvoi-64.png", "rien.gif",false);

	echo icone_etendue(_T("smslist:icone_configurer"), $gerer, _DIR_PLUGIN_SMSLIST. "img_pack/smslist-config-64.png", "rien.gif",false);

	echo creer_colonne_droite();

	echo debut_droite("smslist",true);
	
	// messages en preparation
	foreach(Forms_liste_tables('smslist_message') as $id_form){
		$contexte = array('id_form'=>$id_form,
		'titre_liste'=>_T("smslist:messages_en_redaction"),
		'aucune_reponse'=>" ",
		'couleur_claire'=>$GLOBALS['couleur_claire'],'couleur_foncee'=>$GLOBALS['couleur_foncee'],
		'statuts' => array('prepa'),
		'affiche_rang'=>0,
		'affiche_de'=>1,
		'colonne_extra_titre'=>"<img src='"._DIR_PLUGIN_SMSLIST. "img_pack/envoyer-message-16.png' width='16' height='16' alt='"._L('Envoyer')."' />",
		'colonne_extra_url'=>generer_url_ecrire('smslist_envoyer_message'));
		echo recuperer_fond("exec/template/donnees_tous",$contexte);	
	}

	// messages en cours d'envoi
	foreach(Forms_liste_tables('smslist_boiteenvoi') as $id_form){
		$contexte = array('id_form'=>$id_form,
		'titre_liste'=>_T("smslist:envois_programmes"),
		'aucune_reponse'=>" ",
		'couleur_claire'=>$GLOBALS['couleur_claire'],'couleur_foncee'=>$GLOBALS['couleur_foncee'],
		'statuts' => array('prepa'),
		'affiche_rang'=>0,
		'affiche_de'=>1,
		);
		echo recuperer_fond("exec/template/donnees_tous",$contexte);	
	}

	///
	/*$messages_vus = '';
	echo spiplistes_afficher_en_liste(_T('spiplistes:aff_encours'), _DIR_PLUGIN_SPIPLISTES.'img_pack/24_send-receive.gif', 'messages', 'encour', '', 'position') ;
	echo spiplistes_afficher_en_liste(_T('spiplistes:aff_redac'), _DIR_PLUGIN_SPIPLISTES.'img_pack/stock_mail.gif', 'messages', 'redac', '', 'position') ;
	
	
	// afficher les messages auto
	echo spiplistes_afficher_pile_messages();
	
	echo "<br /><br />";

	echo spiplistes_afficher_en_liste(_T('spiplistes:messages_auto_envoye'),_DIR_PLUGIN_SPIPLISTES.'img_pack/stock_mail.gif', 'messages', 'auto', '', 'position') ;
	echo spiplistes_afficher_en_liste(_T('spiplistes:aff_envoye'), _DIR_PLUGIN_SPIPLISTES.'img_pack/stock_mail.gif', 'messages', 'publie', '', 'position') ;
	*/
	
	
	echo fin_gauche(), fin_page();
}

/******************************************************************************************/
/* SPIP-listes est un syst�e de gestion de listes d'abonn� et d'envoi d'information     */
/* par email  pour SPIP.                                                                  */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique G��ale GNU publi� par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribu�car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but sp�ifique. Reportez-vous �la Licence Publique G��ale GNU  */
/* pour plus de d�ails.                                                                  */
/*                                                                                        */
/* Vous devez avoir re� une copie de la Licence Publique G��ale GNU                    */
/* en m�e temps que ce programme ; si ce n'est pas le cas, �rivez �la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, �ats-Unis.                   */
/******************************************************************************************/
?>
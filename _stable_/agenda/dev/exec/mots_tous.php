<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2006                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('inc/actions');
include_spip('exec/grouper_mots');
include_spip('inc/agenda_gestion');
include_spip('inc/pim_agenda_gestion');

// http://doc.spip.org/@exec_mots_tous_dist
function exec_mots_tous_dist()
{
	global $conf_mot, $spip_lang, $spip_lang_right, $son_groupe;
	global $evenements, $pim_agenda;
	global $tables_principales;

	$id_groupe = intval($id_groupe);
	$conf_mot = intval($conf_mot);

	pipeline('exec_init',array('args'=>array('exec'=>'mots_tous'),'data'=>''));
	debut_page(_T('titre_page_mots_tous'), "naviguer", "mots");
	debut_gauche();

	if (acces_mots()){
		if (function_exists('Agenda_install'))	Agenda_install();
		if (function_exists('PIMAgenda_install'))	PIMAgenda_install();
		if (acces_mots()  AND !$conf_mot){
			$res = icone_horizontale(_T('icone_creation_groupe_mots'), generer_url_ecrire("mots_type","new=oui"), "groupe-mot-24.gif", "creer.gif",false);
			echo bloc_des_raccourcis($res);
		}
	}

	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'mots_tous'),'data'=>''));
	creer_colonne_droite();
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'mots_tous'),'data'=>''));
	debut_droite();

	gros_titre(_T('titre_mots_tous'));
	if (acces_mots()) {
		echo typo(_T('info_creation_mots_cles')) . aide ("mots") ;
	}
	echo "<br /><br />";


//
// On boucle d'abord sur les groupes de mots
//

	$result_groupes = spip_query($q="SELECT *, ".creer_objet_multi ("titre", "$spip_lang")." FROM spip_groupes_mots ORDER BY multi");


	while ($row_groupes = spip_fetch_array($result_groupes)) {
		$id_groupe = $row_groupes['id_groupe'];
		$titre_groupe = typo($row_groupes['titre']);
		$descriptif = $row_groupes['descriptif'];
		$texte = $row_groupes['texte'];
		$unseul = $row_groupes['unseul'];
		$obligatoire = $row_groupes['obligatoire'];
		$articles = $row_groupes['articles'];
		$breves = $row_groupes['breves'];
		$rubriques = $row_groupes['rubriques'];
		$syndic = $row_groupes['syndic'];
		if (isset($tables_principales['spip_evenements']))	$evenements = $row_groupes['evenements'];
		if (isset($tables_principales['spip_pim_agenda']))	$pim_agenda = $row_groupes['pim_agenda'];
		$acces_minirezo = $row_groupes['minirezo'];
		$acces_comite = $row_groupes['comite'];
		$acces_forum = $row_groupes['forum'];

	// Afficher le titre du groupe
	debut_cadre_enfonce("groupe-mot-24.gif", false, '', $titre_groupe);
	// Affichage des options du groupe (types d'elements, permissions...)
	echo "<font face='Verdana,Arial,Sans,sans-serif' size=1>";
	if ($articles == "oui") echo "> "._T('info_articles_2')." &nbsp;&nbsp;";
	if ($breves == "oui") echo "> "._T('info_breves_02')." &nbsp;&nbsp;";
	if ($rubriques == "oui") echo "> "._T('info_rubriques')." &nbsp;&nbsp;";
	if ($syndic == "oui") echo "> "._T('icone_sites_references')." &nbsp;&nbsp;";
	if (isset($tables_principales['spip_evenements']))
		if ($evenements == "oui") echo "> "._T('agenda:info_evenements')." &nbsp;&nbsp;";
	if (isset($tables_principales['spip_pim_agenda']))
		if ($pim_agenda == "oui") echo "> "._T('pimagenda:info_evenements')." &nbsp;&nbsp;";

	if ($unseul == "oui" OR $obligatoire == "oui") echo "<br>";
	if ($unseul == "oui") echo "> "._T('info_un_mot')." &nbsp;&nbsp;";
	if ($obligatoire == "oui") echo "> "._T('info_groupe_important')." &nbsp;&nbsp;";

	echo "<br />";
	if ($acces_minirezo == "oui") echo "> "._T('info_administrateurs')." &nbsp;&nbsp;";
	if ($acces_comite == "oui") echo "> "._T('info_redacteurs')." &nbsp;&nbsp;";
	if ($acces_forum == "oui") echo "> "._T('info_visiteurs_02')." &nbsp;&nbsp;";

	echo "</font>";
	if ($descriptif) {
		echo "<div style='border: 1px dashed #aaaaaa;'>";
		echo "<font size='2' face='Verdana,Arial,Sans,sans-serif'>";
		echo "<b>",_T('info_descriptif'),"</b> ";
		echo propre($descriptif);
		echo "&nbsp; ";
		echo "</font>";
		echo "</div>";
	}

	if (strlen($texte)>0){
		echo "<font face='Verdana,Arial,Sans,sans-serif'>";
		echo propre($texte);
		echo "</font>";
	}

	//
	// Afficher les mots-cles du groupe
	//
	$groupe = spip_fetch_array(spip_query("SELECT COUNT(*) AS n FROM spip_mots WHERE id_groupe=$id_groupe"));
	$groupe = $groupe['n'];

	echo "<div id='editer_mot-$id_groupe' style='position: relative;'>";

	// Preliminaire: confirmation de suppression d'un mot lie �qqch
	// (cf fin de afficher_groupe_mots_boucle executee a l'appel precedent)
	if ($conf_mot  AND $son_groupe==$id_groupe) {
		include_spip('inc/grouper_mots');
		echo confirmer_mot($conf_mot, $id_groupe, $groupe);
	}
	if ($groupe) {
	  	$grouper_mots = charger_fonction('grouper_mots', 'inc');
		echo $grouper_mots($id_groupe, $groupe);
	}

	echo "</div>";

		if (acces_mots()){
			echo "\n<table cellpadding='0' cellspacing='0' border='0' width='100%'>";
			echo "<tr>";
			echo "<td>";
			icone(_T('icone_modif_groupe_mots'), generer_url_ecrire("mots_type","id_groupe=$id_groupe"), "groupe-mot-24.gif", "edit.gif");
			echo "</td>";
			echo "\n<td id='editer_mot-$id_groupe-supprimer'",
			  (!$groupe ? '' : " style='visibility: hidden'"),
			  ">";
			icone(_T('icone_supprimer_groupe_mots'), redirige_action_auteur('instituer_groupe_mots', "-$id_groupe", "mots_tous"), "groupe-mot-24.gif", "supprimer.gif");
			echo "</td>";
			echo "<td>";
			echo "<div align='$spip_lang_right'>";
			icone(_T('icone_creation_mots_cles'), generer_url_ecrire("mots_edit","new=oui&id_groupe=$id_groupe&redirect=" . generer_url_retour('mots_tous')), "mot-cle-24.gif", "creer.gif");
			echo "</div>";
			echo "</td></tr></table>";
		}	

		fin_cadre_enfonce();
	}

	echo fin_gauche();
	echo fin_page();
}

function confirmer_mot ($conf_mot, $son_groupe)
{
	$row = spip_fetch_array(spip_query("SELECT * FROM spip_mots WHERE id_mot=$conf_mot"));
	$id_mot = $row['id_mot'];
	$titre_mot = typo($row['titre']);
	$type_mot = typo($row['type']);

	if (($na = intval($na)) == 1) {
		$texte_lie = _T('info_un_article')." ";
	} else if ($na > 1) {
		$texte_lie = _T('info_nombre_articles', array('nb_articles' => $na)) ." ";
	}
	if (($nb = intval($nb)) == 1) {
		$texte_lie .= _T('info_une_breve')." ";
	} else if ($nb > 1) {
		$texte_lie .= _T('info_nombre_breves', array('nb_breves' => $nb))." ";
	}
	if (($ns = intval($ns)) == 1) {
		$texte_lie .= _T('info_un_site')." ";
	} else if ($ns > 1) {
		$texte_lie .= _T('info_nombre_sites', array('nb_sites' => $ns))." ";
	}
	if (($nr = intval($nr)) == 1) {
		$texte_lie .= _T('info_une_rubrique')." ";
	} else if ($nr > 1) {
		$texte_lie .= _T('info_nombre_rubriques', array('nb_rubriques' => $nr))." ";
	}

	return debut_boite_info(true)
	. "<div class='serif'>"
	. _T('info_delet_mots_cles', array('titre_mot' => $titre_mot, 'type_mot' => $type_mot, 'texte_lie' => $texte_lie))
	. "<p>"
	  . ajax_action_auteur('editer_mot', "$son_groupe,$id_mot,,,",'grouper_mots', "&id_groupe=$son_groupe", array("<b>" . _T('item_oui') . "</b>", ''))
	. '&nbsp;'
	.  _T('info_oui_suppression_mot_cle')
	  /* troublant. A refaire avec une visibility
	 . "<LI><B><A href='" 
	. generer_url_ecrire("mots_tous")
	. "#editer_mot-$son_groupe"
	. "'>"
	. _T('item_non')
	. "</A>,</B> "
	. _T('info_non_suppression_mot_cle')
	. "</UL>" */
	. "</div>"
	. fin_boite_info(true)
	. "<br />";
}
?>
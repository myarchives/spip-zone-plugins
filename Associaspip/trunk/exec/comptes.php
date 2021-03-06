<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations
 *
 * @copyright Copyright (c) 2007 Bernard Blazin & Francois de Montlivault
 * @copyright Copyright (c) 2010--2011 Emmanuel Saint-James
 * @copyright Copyright (c) 201108 Marcel Bolla
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
\***************************************************************************/
if (!defined('_ECRIRE_INC_VERSION'))
	return;

function exec_comptes() {
	sinon_interdire_acces(autoriser('voir_compta', 'association'));
	include_spip('association_modules');
/// INITIALISATIONS
	$id_compte = association_passeparam_id('compte');
	list($id_periode, $critere_periode) = association_passeparam_periode('operation', 'asso_comptes', $id_compte);
	$where = $critere_periode;
	$imputation = _request('imputation');
	if ($imputation)
		$where .= ' AND imputation LIKE '. sql_quote($imputation);
	$vu = _request('vu');
	if (!is_numeric($vu))
		$vu = '';
	else
		$where .= " AND vu=$vu ";
/// AFFICHAGES_LATERAUX (connexes)
	echo association_navigation_onglets('titre_onglet_comptes', 'comptes');
/// AFFICHAGES_LATERAUX : TOTAUX : noperations de l'exercice par compte financier (indique rapidement les comptes financiers les plus utilises ou les modes de paiement preferes...)
	$journaux = sql_allfetsel('journal, intitule', 'spip_asso_comptes RIGHT JOIN spip_asso_plan ON journal=code', $critere_periode, "intitule DESC"); // on se permet sql_allfetsel car il s'agit d'une association (mois d'une demie dizaine de comptes) et non d'un etablissement financier (des milliers de comptes clients)
	foreach (array('recette','depense') as $direction) {
		foreach ($journaux as $financier) {
			$nombre_direction = sql_countsel('spip_asso_comptes', "journal=".sql_quote($financier['journal'])." AND $critere_periode AND $direction<>0 ");
			if ($nombre_direction) { // on ne s'embarasse pas avec ceux a zero
				$direction_decomptes[$financier['journal']] = array( $financier['intitule'], $nombre_direction, );
			}
		}
		if (count($direction_libelles))
			echo association_tablinfos_effectifs(_T('asso:compte_entete_financier') .': '. _T('asso:'.$direction.'s'), $direction_decomptes); // ToDo: tri par ordre decroissant (sorte de "top")
	}
/// AFFICHAGES_LATERAUX : TOTAUX : operations de l'exercice par type d'operation
	$classes = array('pair'=>'produits', 'impair'=>'charges', 'cv'=>'contributions_volontaires', 'vi'=>'banques');
	$liste_types = array();
	foreach ($classes as $classe_css=>$classe_cpt) {
		$liste_types[$classe_css] = array( 'compte_liste_nombre_'.$classe_css, sql_countsel('spip_asso_comptes', "LEFT(imputation,1)=".sql_quote($GLOBALS['association_metas']["classe_$classe_cpt"])." AND $critere_periode "), );
	}
	echo association_tablinfos_effectifs(_T('asso:bouton_radio_type_operation_titre'), $liste_types);
/// AFFICHAGES_LATERAUX : STATS : montants de l'exercice pour l'imputation choisie (toutes si aucune)
	echo association_tablinfos_stats('mouvements', 'comptes', array('bilan_recettes'=>'recette','bilan_depenses'=>'depense',), $where, 2);
/// AFFICHAGES_LATERAUX : TOTAUX : montants de l'exercice pour l'imputation choisie (toutes si aucune)
	$data = sql_fetsel( 'SUM(recette) AS somme_recettes, SUM(depense) AS somme_depenses, code, classe',  'spip_asso_comptes RIGHT JOIN spip_asso_plan ON imputation=code', "$where AND classe<>".sql_quote($GLOBALS['association_metas']['classe_banques']). " AND classe<>".sql_quote($GLOBALS['association_metas']['classe_contributions_volontaires']), 'code'); // une contribution benevole ne doit pas etre comptabilisee en charge/produit
	echo association_tablinfos_montants(( ($imputation=='%'||!$imputation) ? _T('asso:entete_tous') : $imputation), $data['somme_recettes'], $data['somme_depenses']);
/// AFFICHAGES_LATERAUX : RACCOURCIS
	echo association_navigation_raccourcis(array(
		array('encaisse_titre_general', 'finances-24.png', array('encaisse', ($GLOBALS['association_metas']['exercices']?'exercice':'annee')."=$id_periode"), array('voir_compta', 'association') ),
		array('cpte_resultat_titre_general', 'finances-24.png', array('compte_resultat', ($GLOBALS['association_metas']['exercices']?'exercice':'annee')."=$id_periode"), array('voir_compta', 'association') ),
		array('cpte_bilan_titre_general','finances-24.png', array('compte_bilan', ($GLOBALS['association_metas']['exercices']?'exercice':'annee')."=$id_periode"), array('voir_compta', 'association') ),
#		array('annexe_titre_general', 'finances-24.png', array('compte_annexe', ($GLOBALS['association_metas']['exercices']?'exercice':'annee')."=$id_periode"), array('voir_compta', 'association') ),
		array('ajouter_une_operation', 'ajout-24.png', array('edit_compte'), array('editer_compta', 'association') ),
	), 6);
/// AFFICHAGES_CENTRAUX (corps)
	debut_cadre_association('finances-24.png', 'informations_comptables');
/// AFFICHAGES_CENTRAUX : FILTRES
	$filtre_imputation = '<select name="imputation" onchange="form.submit()">';
	$filtre_imputation .= '<option value="" ';
	$filtre_imputation .= (($imputation=='%' || !$imputation)?' selected="selected"':'');
	$filtre_imputation .= '>'. _T('asso:entete_tous') .'</option>';
	$sql = sql_select(
		'imputation , code, intitule, classe',
		'spip_asso_comptes RIGHT JOIN spip_asso_plan ON imputation=code',
		"classe<>". sql_quote($GLOBALS['association_metas']['classe_banques']) ." AND active AND $critere_periode ", // pour l'exercice en cours... ; n'afficher ni les comptes de la classe financiere --ce ne sont pas des imputations-- ni les inactifs
		'code', 'code ASC');
	while ($plan = sql_fetch($sql)) { // Remplir le select uniquement avec les comptes utilises
		$filtre_imputation .= '<option value="'.$plan['code'].'"';
		$filtre_imputation .= ($imputation==$plan['code']?' selected="selected"':'');
		$filtre_imputation .= '>'.$plan['code'].' - '.$plan['intitule'].'</option>';
	}
	$filtre_imputation .= '</select>';
	$filtre_vu = '<select name="vu" onchange="form.submit()">';
	$filtre_vu .= '<option value="" '. ($vu==''?'':' selected="selected"') .'>'. _T('asso:cpte_op_vu_tous') .'</option>';
	$filtre_vu .= '<option value="0" '. ($vu=='0'?' selected="selected"':'') .'>'. _T('asso:cpte_op_vu_non') .'</option>';
	$filtre_vu .= '<option value="1" '. ($vu=='1'?' selected="selected"':'') .'>'. _T('asso:cpte_op_vu_oui') .'</option>';
	$filtre_vu .= '</select>';
	echo association_form_filtres(array(
		'periode' => array($id_periode, 'asso_comptes', 'operation'),
#		'id' => $id_compte,
	), 'comptes', array(
		'imputation' => $filtre_imputation,
		'vu' => $filtre_vu,
	));
/// AFFICHAGES_CENTRAUX : TABLEAU
	if ($id_compte) { // (re)calculer la pagination en fonction de id_compte
		$all_id_compte = sql_allfetsel('id_compte', 'spip_asso_comptes', $where, '',  'date_operation DESC,id_compte DESC'); // on recupere les id_comptes de la requete sans le critere de limite...
		$index_id_compte = -1;
		reset($all_id_compte);
		while (($index_id_compte<0) && (list($k,$v) = each($all_id_compte))) { // ...et on en tire l'index de l'id_compte recherche parmis tous ceux disponible
			if ($v['id_compte']==$id_compte) $index_id_compte = $k;
		}
		if ($index_id_compte>=0) { // on recalcule le parametre de limite de la requete
			set_request('debut', intval($index_id_compte/_ASSOCIASPIP_LIMITE_SOUSPAGE)*_ASSOCIASPIP_LIMITE_SOUSPAGE);
		}
	}
	$limit = intval(_request('debut')) . "," . _ASSOCIASPIP_LIMITE_SOUSPAGE;
	$tbd = comptes_while($where, $limit, $id_compte);
	if ($tbd) { // affichage de la liste
		// ENTETES
		$thd = '<tr class="row_first">';
		$thd .= '<th>'. _T('asso:entete_id') .'</th>';
		$thd .= '<th>'. _T('asso:entete_date') .'</th>';
		$thd .= '<th>'. _T('asso:compte_entete_imputation') .'</th>';
		$thd .= '<th>'. _T('asso:compte_entete_justification') .'</th>';
		$thd .= '<th>'. _T('asso:entete_montant') .'</th>';
		$thd .= '<th>'. _T('asso:compte_entete_financier') .'</th>';
		$thd .= '<th colspan="2" class="actions">'. _T('asso:entete_actions') .'</th>';
		$thd .= '<th><input title="'._T('asso:selectionner_tout').'" type="checkbox" id="selectionnerTous" onclick="var currentVal = this.checked; var checkboxList = document.getElementsByName(\'valide[]\'); for (var i in checkboxList) {checkboxList[i].checked=currentVal;}" /></th>'
		. "</tr>\n";
		// SOUS-PAGINATION
		$nav = association_form_souspage(array('spip_asso_comptes', $where), 'comptes', ($GLOBALS['association_metas']['exercices']?'exercice':'annee')."=$id_periode".($imputation?"&imputation=$imputation":''). (is_numeric($vu)?"&vu=$vu":''), '<td align="right"><input type="submit" value="'. _T('asso:bouton_valider') . '"  /></td>');
		// TOTALE
		$res = "<table width='100%' class='asso_tablo' $onload_option id='asso_liste_comptes'>\n"
		. $thd.$tbd.$thd."\n</table>\n".$nav;
		echo generer_form_ecrire('action_comptes', $res);
	} else {
		if( !sql_countsel('spip_asso_comptes', $where) ) // absence d'operation pour l'exercice
			echo _T('asso:exercice_sans_operation');
		elseif ($id_periode) // aucune operation correspondant aux filtres
			echo _T('asso:recherche_reponse0');
		else // exercice inconnu ou indefini
			echo '<a href="'.generer_url_ecrire('exercice_comptable').'">'. _T('asso:ajouter_un_exercice') .'</a>';
	}
/// AFFICHAGES_CENTRAUX : FIN
	fin_page_association();
}

function comptes_while($where, $limit, $id_compte) {
	$query = sql_select('*', 'spip_asso_comptes', $where,'',  'date_operation DESC,id_compte DESC', $limit);
	$comptes = '';
	while ($data = sql_fetch($query)) {
		if ($data['depense']>0) { // depense
			$class = 'impair';
		} else { // recette
			$class = 'pair';
		}
		if ($data['imputation']==$GLOBALS['association_metas']['pc_intravirements']) { // virement interne
			$class = 'vi';
		}
		if (substr($data['imputation'],0,1)==$GLOBALS['association_metas']['classe_contributions_volontaires']) { // contribution volontaire
			$class = 'cv';
		}
		if($id_compte==$data['id_compte']) { // operation recherchee
			$onload_option .= 'onLoad="document.getElementById(\'compte'.$id_compte.'\').scrollIntoView(TRUE);"'; // pour voir au chargement l'id_compte recherche
			$class = 'surligne';
		} else {
			$onload_option = '';
		}
		$comptes .= "<tr id='compte".$data['id_compte']."' class='$class'>"
		. '<td class="integer">'.$data['id_compte'].'</td>'
		. '<td class="date">'. association_formater_date($data['date_operation']) .'</td>'
		. '<td class="text">'. $data['imputation'].'</td>'
		. '<td class="text">&nbsp;'. propre($data['justification']) .'</td>'
		. '<td class="decimal">'. association_formater_prix($data['recette']-$data['depense']) .'</td>'
		. '<td class="text">&nbsp;'.$data['journal'].'</td>';
		if ( $data['vu'] ) { // pas d'action sur les operations validees !
			$comptes .= '<td class="action" colspan="2">'. association_formater_puce($data['id_journal'], 'verte', '', $onload_option) .' </td>'; // edition+suppresion
			$comptes .= association_bouton_coch(''); // validation
		} else {  // operation non validee (donc validable et effacable...
			if ( $data['id_journal'] && $data['imputation']!=$GLOBALS['association_metas']['pc_cotisations'] ) { // pas d'edition/suppression des operations gerees par un autre module (exepte les cotisations) ...par souci de coherence avec les donnees dupliquees dans d'autres tables...
				$comptes .= '<td class="action" colspan="2">'. association_formater_puce($data['id_journal'], 'rouge', '', $onload_option) .'</td>'; // edition+suppression
			} else { // operation geree par ce module
				if (substr($data['imputation'],0,1)==$GLOBALS['association_metas']['classe_banques']) { // pas d'edition des virements internes (souci de coherence car il faut modifier deux operations concordament : ToDo...)
					$comptes .= '<td class="action">&nbsp;</td>'; // edition
				} else { // le reste est editable
					$comptes .= association_bouton_edit('compte', 'id='.$data['id_compte']); // edition
				}
				$comptes .= association_bouton_suppr('compte', 'id='.$data['id_compte']); // suppression
			}
			$comptes .= association_bouton_coch('valide', $data['id_compte']); // validation
		}
		$comptes .= '</tr>';
	}
	return $comptes;
}

?>
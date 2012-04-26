<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Fran�ois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/


if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip ('inc/navigation_modules');

function exec_bilan()
{
	if (!autoriser('associer', 'comptes')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		$plan = sql_countsel('spip_asso_plan');
		$exercice = intval(_request('exercice'));
		if(!$exercice){
			/* on recupere l'id_exercice dont la date "fin" est "la plus grande" */
			$exercice = sql_getfetsel('id_exercice','spip_asso_exercices','','','fin DESC');
			if(!$exercice)
				$exercice=0;
		}
		$exercice_data = sql_asso1ligne('exercice', $exercice);
		// recupere l'id_destination de la ou des destinations dans POST ou cree une entree a 0 dans le tableau
		if (!($ids_destination_bilan = _request('destination')))
			$ids_destination_bilan = array(0);
		include_spip('inc/association_comptabilite');
		onglets_association('titre_onglet_comptes');
		// INTRO : rappel de l'exercicee affichee
		$infos['exercice_entete_debut'] = association_datefr($exercice_data['debut'], 'dtstart');
		$infos['exercice_entete_fin'] = association_datefr($exercice_data['fin'], 'dtend');
		echo totauxinfos_intro($exercice_data['intitule'], 'exercice', $exercice, $infos);
		if ($GLOBALS['association_metas']['destinations']=='on') {
			// cree un menu a choix multiple des destinations a inserer dans la boite info et recupere les intitule de toutes les destinations dans un tableau
			$select_destination = '';
			$intitule_destinations = array();
			$query = sql_select('id_destination, intitule', 'spip_asso_destination', '', '', 'intitule');
			while ($data = sql_fetch($query)) {
				$select_destination .= '<option value="'.$data['id_destination'].'"';
				if (!(array_search($data['id_destination'], $ids_destination_bilan)===FALSE))
					$select_destination .= ' selected="selected"';
				$select_destination .= '>'.$data['intitule'].'</option>';
				$intitule_destinations[$data['id_destination']] = $data['intitule'];
			}
			echo '<form method="post" action="'.generer_url_ecrire('bilan', "exercice=$exercice").'"><div>';
			echo '<select name ="destination[]" class="fondl" multiple>';
			echo '<option value="0"';
			if (!(array_search(0, $ids_destination_bilan)===FALSE))
				echo ' selected="selected"';
			echo '>'._T('asso:toutes_destinations').'</option><option disabled="disabled">--------</option>'.$select_destination;
			echo '</select>';
			echo '<p class="boutons"><input type="submit" value="Bilan" /></p>';
			echo '</div></form>';
		}
		// datation et raccourcis
		icones_association(array('comptes', "exercice=$exercice"), array(
			'cpte_resultat_titre_general' => array('finances-24.png', 'compte_resultat', "exercice=$exercice"),
#			'annexe_titre_general' => array('finances-24.png', 'annexe', "exercice=$exercice"),
			'encaisse' => array('finances-24.png', 'encaisse', "exercice=$exercice"),
		));
		debut_cadre_association('finances-24.png', 'bilans_comptables', $exercice_data['intitule']);
		if ($plan) {
			$join = ' RIGHT JOIN spip_asso_plan ON imputation=code';
			$sel = ', code, intitule, classe';
			$where = " date>='$exercice_data[debut]' AND date<='$exercice_data[fin]' ";
			$having =  "classe NOT IN ('". sql_quote($GLOBALS['association_metas']['classe_banques']). "','" .sql_quote($GLOBALS['association_metas']['classe_contributions_volontaires']) . "','" .sql_quote($GLOBALS['association_metas']['classe_charges']) . "','" .sql_quote($GLOBALS['association_metas']['classe_produits']) . "')";
			$order = 'code';
		} else {
			$join = $sel = $where = $having = $order = '';
		}
		$classes = array(
			sql_quote($GLOBALS['association_metas']['classe_charges']),
			sql_quote($GLOBALS['association_metas']['classe_produits']),
//			sql_quote($GLOBALS['association_metas']['classe_contributions_volontaires']),
//			sql_quote($GLOBALS['association_metas']['classe_banques']),
		);
		// on boucle sur le tableau des destinations en refaisant le fetch a chaque iteration
		foreach ($ids_destination_bilan as $id_destination) {
			$total_recettes = $total_depenses = $total_soldes = 0;
			//TABLEAU EXPLOITATION
			if ($id_destination!=0) {
				$intitule_destination_bilan = $intitule_destinations[$id_destination];
			} else {
				if ($GLOBALS['association_metas']['destinations']=='on') $intitule_destination_bilan = _T('asso:toutes_destination');
			}
			echo "\n<fieldset>";
			echo '<legend><strong>'. _T('asso:resultat_courant') . ' ' .$intitule_destination_bilan. '</strong></legend>';
			$solde = association_liste_totaux_comptes_classes($classes, 'cpte_resultat', 0, $exercice, $id_destination);
			echo '</fieldset>';
		}
		fin_page_association();
	}
}

/* Dans la fonction suivante on dissocie la "lecture" et "l'affichage"
 * afin de pouvoir traiter et calculer des valeurs intermédiaires :
 * 1 - on ne comptabilise pour le terme "encaisse" que les sommes dont le journal est 53xx ou 51xx
 * 2 - si "imputation" vaut 58xx : c'est un virement interne et le solde du compte doit etre a zéro
 *		sinon il y a une erreur !!
 * 3 - si "imputation" vaut 86xx ou 87xx : c'est une contribution volontaire ... il est preferable que
 *		que les comptes 86 et 87 s'equilibrent. Faire apparaitre dans le "bilan" uniquement le cas ou il
 *		y a desequilibre !
 */
function bilan_encaisse()
{
	$lesEcritures = array();
	$lesEcritures['_58xx']['solde'] = $lesEcritures['_86xx']['solde'] = $lesEcritures['_87xx']['solde'] = 0;
	$query = sql_select('*', 'spip_asso_plan', '(classe='.sql_quote($GLOBALS['association_metas']['classe_banques']).' OR classe='.sql_quote($GLOBALS['association_metas']['classe_contributions_volontaires']).') AND active=1', '',  'code' );
	while ($val = sql_fetch($query)) {
		/* on declare un tableau et on le rempli avec les donnees du compte */
		$lesEcritures[$val['code']] = array(
			'code' => $val['code'],
			'intitule' => $val['intitule'],
			'date_solde' => $val['date_anterieure'],
			'solde_anterieur' => $val['solde_anterieur'],
			'id_plan' => $val['id_plan'],
		);
		/* ne pas comptabiliser les opérations au delà d'aujourd'hui meme si il y a des echeances futures !!!! */
		$compte = sql_fetsel('SUM(recette) AS recettes, SUM(depense) AS depenses, date, imputation',
			'spip_asso_comptes',
			'date>='. sql_quote($lesEcritures[$val['code']]['date_solde']).' AND date<=NOW() AND (journal='. sql_quote($val['code']) .' OR imputation='. sql_quote($val['code']) .')',
			'journal');
		if ($compte) {
			if(substr($compte['imputation'],0,1)===$GLOBALS['association_metas']['classe_contributions_volontaires']) {
				/* c'est une contribution volontaire du type 8xxx :
				 * c'est une dépense evaluee si 86xx ou recette évaluée si 87xx
				 * qui doit apparaître dans le compte de resultat
				 */
				$lesEcritures['_86xx']['solde'] += $compte['depenses'];
				$lesEcritures['_87xx']['solde'] += $compte['recettes'];
			} else {
				/* c'est une recette ou une depense */
				$lesEcritures[$code]['solde'] = $compte['recettes']-$compte['depenses'];
				if (substr($compte['imputation'],0,1)===$GLOBALS['association_metas']['classe_banques'])
				/* c'est un virement interne avec le code 58xx :
				 * le solde du compte doit être à zero sinon il y a erreur !
				 */
					$lesEcritures['_58xx']['solde'] += $compte['recettes']-$compte['depenses'];
			}
		}
	}

	echo "\n<fieldset>";
	echo '<legend><strong>' . _T('asso:encaisse') . '</strong></legend>';
	echo "<table width='100%' class='asso_tablo' id='asso_tablo_bilan_encaisse'>\n";
	echo "<thead>\n<tr>";
	echo '<th colspan="2">&nbsp;</th>';
	echo '<th>'. _T('asso:avoir_initial') .'</th>';
	echo '<th>'. _T('asso:avoir_actuel') .'</th>';
	echo "</tr>\n</thead><tbody>";
	$total_actuel = $total_initial = 0;
	foreach($lesEcritures as $compteFinancier) {
		if( substr($compteFinancier['code'],0,1)==$GLOBALS['association_metas']['classe_banques'] ) { //!\ Tous les comptes financiers ne sont normalement pas concernes : idealement il aurait fallu configurer un groupe "caisse" (51xx) et un groupe "banque" (53xx) mais d'une part nous ignorons si d'autres systemes comptables n'utilisent pas plus de groupes et d'autre part (meme une association francaise) peut bien ne pas avoir les deux types de comptes...
			echo '<tr id="'.$compteFinancier['id_plan'].'">';
			echo '<td class="text">'. $compteFinancier['code'] .' : '. $compteFinancier['intitule'] .'</td>';
			echo '<td class="date">'. association_datefr($compteFinancier['date_anterieure'],'dtstart') .'</td>';
			echo '<td class="decimal">'. association_prixfr($compteFinancier['solde_anterieur']) .'</td>';
			echo '<td class="decimal">'. association_prixfr($compteFinancier['solde_anterieur']+$compteFinancier['solde']) .'</td>';
			$total_initial += $compteFinancier['solde_anterieur'];
			$total_actuel += $compteFinancier['solde_anterieur']+$compteFinancier['solde'];
		} else {
			if($compteFinancier['_86xx']['solde']!=$compteFinancier['_87xx']['solde']) {
				$erreur8687=TRUE;
			}
		}
	}
	echo "</tr>\n</tbody><tfoot>\n<tr>";
	echo '<th  colspan="2" class="text">'. _T('asso:encaisse') .'</th>';
	echo '<th class="decimal">'. association_prixfr($total_initial) .'</th>';
	echo '<th class="decimal">'. association_prixfr($total_actuel) .'</th>';
	if( $compteFinancier['_58xx']['solde']!=0 ){
		echo '<td  colspan="4" class="erreur">'. _T('asso:erreur_equilibre_comptes58') .'</td>';
	}
	if( $compteFinancier['_86xx']['solde']!=$compteFinancier['_87xx']['solde'] ){
		echo '<td  colspan="4" class="erreur">'. _T('asso:erreur_equilibre_comptes8687') .'</td>';
	}
	echo "</tr>\n</tfoot>\n</table>\n";
	echo '</fieldset>';
}

?>
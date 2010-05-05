<?php
	/**
	* Plugin Association
	*
	* Copyright (c) 2007
	* Bernard Blazin & Fran�ois de Montlivault
	* http://www.plugandspip.com 
	* Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	* Pour plus de details voir le fichier COPYING.txt.
	*  
	**/
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');
include_spip ('inc/navigation_modules');
	
function exec_comptes() {
		
	include_spip('inc/autoriser');
	if (!autoriser('configurer')) {
		include_spip('inc/minipres');
		echo minipres();

	} else {
		$commencer_page = charger_fonction('commencer_page', 'inc');
		echo $commencer_page(_T('asso:titre_gestion_pour_association')) ;
		//debut_page(_T('asso:titre_gestion_pour_association'), "", "");
		
		$url_comptes = generer_url_ecrire('comptes');
		$url_ajout_compte = generer_url_ecrire('edit_compte','agir=ajouter');
		$url_edit_compte = generer_url_ecrire('edit_compte','agir=modifier');
		$url_action_comptes = generer_url_ecrire('action_comptes');
		
		if ( isset ($_REQUEST['imputation'] )) { $imputation = $_REQUEST['imputation']; }
		else { $imputation= "%"; }
		
		$annee= intval(_request('annee'));
		if(empty($annee)){$annee = date('Y');}
		
		association_onglets();
		
		echo debut_gauche("",true);
		
		echo debut_boite_info(true);
		echo association_date_du_jour();	
		echo '<p>En bleu : Recettes<br />En rose : D&eacute;penses</p>'; 
		
		// TOTAUX
		$query = sql_select("sum(recette) AS somme_recettes, sum(depense) AS somme_depenses", 'spip_asso_comptes', "date_format( date, '%Y' ) = $annee AND imputation like '$imputation'");
		while ($data = sql_fetch($query)) {
			$somme_recettes = $data['somme_recettes'];
			$somme_depenses = $data['somme_depenses'];
			$solde= $somme_recettes - $somme_depenses;
			
			echo '<table width="100%">';
			echo '<tr>';
			echo '<td colspan="2"><strong>Totaux '.$imputation.' '.$annee.' :</strong></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td><strong style="color:blue">' . _L('Entr&eacute;es :') . '</strong></td>';
			echo '<td style="text-align:right;">'.association_nbrefr($somme_recettes).' &euro; </td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td><strong style="color:blue">' . _L('Sorties :') . '</strong></td>';
			echo '<td style="text-align:right;">'.association_nbrefr($somme_depenses).' &euro;</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td><strong style="color:#9F1C30">' . _L('Solde :') . '</strong></td>';
			echo '<td class="impair" style="text-align:right;">'.association_nbrefr($solde).' &euro;</td>';
			echo '</tr>';
			echo '</table>';
		}
		
		echo fin_boite_info(true);	
		
		$url_bilan = generer_url_ecrire('bilan', "annee=$annee");		
		$res = association_icone(_T('Bilan') . " $annee",  $url_bilan, 'finances.jpg')
		. association_icone(_L('Ajouter une op&eacute;ration'),  $url_ajout_compte, 'ajout_don.png');

		echo bloc_des_raccourcis($res);
		
		echo debut_droite("",true);
		
		debut_cadre_relief(  "", false, "", $titre = _T('Informations comptables'));
		
		echo '<table width="100%">';
		
		// FILTRES
		echo '<tr>';
		echo '<td>';
		
		$query = sql_select("date_format( date, '%Y' )  AS annee", "spip_asso_comptes", "imputation like '$imputation' ", "annee", "annee");
		
		while ($data = sql_fetch($query)) {
			if ($data['annee']==$annee)	{echo ' <strong>'.$data['annee'].' </strong>';}
			else {echo '<a href="'.$url_comptes.'&annee='.$data['annee'].'&imputation='.$imputation.'">'.$data['annee'].'</a> ';}
		}
		echo '</td>';
		
		echo '<td style="text-align:right;">';
		echo '<form method="post" action="'.$url_comptes.'">';
		echo '<select name ="imputation" class="fondl" onchange="form.submit()">';
		echo '<option value="%" ';
		if ($imputation=="%") { echo ' selected="selected"'; }
		echo '>Tous</option>';
		$sql = sqL_select('*', 'spip_asso_plan','', '', "classe,code");
		while ($plan = sql_fetch($sql)) {
			echo '<option value="'.$plan['code'].'" ';
			if ($imputation==$plan['code']) { echo ' selected="selected"'; }
			echo '>'.$plan['classe'].' - '.$plan['intitule'].'</option>';
		}
		echo '</select></td>';
		echo '</form>';
		echo '</tr></table>';

	//TABLEAU
	echo '<form method="post" action="'.$url_action_comptes.'">';
	echo "<table border=0 cellpadding=2 cellspacing=0 width='100%' class='arial2' style='border: 1px solid #aaaaaa;'>\n";
	echo '<tr bgcolor="#DBE1C5">';
	echo '<td style="text-align:right;"><strong>' . _L('ID') . '</strong></td>';
	echo '<td style="text-align:right;"><strong>' . _L('Date') . '</strong></td>';
	echo '<td><strong>' . _L('Compte') . '</strong></td>';
	echo '<td><strong>' . _L('Justification') . '</strong></td>';
	echo '<td style="text-align:right;"><strong>' . _L('Montant') . '</strong></td>';
	echo '<td><strong>' . _L('Financier') . '</strong></td>';
	echo '<td colspan="3" style="text-align:center;"><strong>&nbsp;</strong></td>';
	echo '</tr>';

	$max_par_page=30;
	$debut= intval(_request('debut'));

	$query = sql_select('*', "spip_asso_comptes", "date_format( date, '%Y' ) = $annee AND imputation like '$imputation'", '',  'date DESC', "$debut,$max_par_page");
	$auteurs = '';
	while ($data = sql_fetch($query)) {
		if ($data['recette'] >0) { $class= "pair";}
		else { $class="impair";}	   
		
		$somme_recettes += $data['recette'];
		$somme_depenses += $data['depense'];
		
		$auteurs .= '<tr> ';
		$auteurs .= '<td class="'.$class. ' border1" style="text-align:right;">'.$data['id_compte'].'</td>';
		$auteurs .= '<td class="'.$class. ' border1" style="text-align:right;">'.association_datefr($data['date']).'</td>';
		$auteurs .= '<td class="'.$class. ' border1">'.$data['imputation'].'</td>';
		$auteurs .= '<td class="'.$class. ' border1">'.propre($data['justification']).'</td>';
		$auteurs .= '<td class="'.$class. ' border1" style="text-align:right;">'.association_nbrefr($data['recette']-$data['depense']).'</td>';
		$auteurs .= '<td class="'.$class. ' border1">'.$data['journal'].'</td>';
		if($data['valide']=='oui') {$auteurs .= '<td class ='.$class.' colspan=3 style="border-top: 1px solid #CCCCCC;">&nbsp;</td>';}
		else {
			$auteurs .= '<td class="'.$class. ' border1" style="text-align:center"><a href="'.$url_edit_compte.'&id='.$data['id_compte'].'"><img src="'._DIR_PLUGIN_ASSOCIATION_ICONES.'edit-12.gif" title="Mettre &agrave; jour"></a></td>';
			$auteurs .= '<td class="'.$class. ' border1" style="text-align:center;"><a href="'.$url_action_comptes.'&agir=supprime&id='.$data['id_compte'].'"><img src="'._DIR_PLUGIN_ASSOCIATION_ICONES.'poubelle-12.gif" title="Supprimer"></a></td>';
			$auteurs .= '<td class="'.$class. ' border1" style="text-align:center"><input name="valide[]" type="checkbox" value='.$data['id_compte'].'></td>';
		}
		$auteurs .= '</tr>';
	}
	echo $auteurs, '</table>';

	echo '<table width="100%">';
	echo '<tr>';

	//SOUS-PAGINATION
	echo '<td>';
	$query = sql_select('*', 'spip_asso_comptes', "date_format( date, '%Y' ) = $annee AND imputation like '$imputation'");
	$nombre_selection=sql_count($query);
	$pages=intval($nombre_selection/$max_par_page) + 1;

	if ($pages == 1) { echo '';}
	else {
		for ($i=0;$i<$pages;$i++) { 
			$position= $i * $max_par_page;
			if ($position == $debut) 	{ echo '<strong>'.$position.' </strong>'; }
			else { echo '<a href="'.$url_comptes.'&annee='.$annee.'&debut='.$position.'&imputation='.$imputation.'">'.$position.'</a> '; }
		}	
	}
	echo '</td>';
	echo '<td  style="text-align:right;">';
	echo !$auteurs ? '' : ('<input type="submit" value="Valider" class="fondo">');
	echo '</td>';
	echo '</table>';
	echo '</form>';

	fin_cadre_relief();  
	echo fin_gauche(),fin_page(); 
	}
}
?>

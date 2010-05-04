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

function exec_plan(){
		
	include_spip('inc/autoriser');
	if (!autoriser('configurer')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		
		$url_plan = generer_url_ecrire('plan');
		$url_edit_plan=generer_url_ecrire('edit_plan');
		$url_action_plan=generer_url_ecrire('action_plan');
		
		$commencer_page = charger_fonction('commencer_page', 'inc');
		echo $commencer_page(_T('asso:plan_comptable')) ;
		
		association_onglets();
		
		echo debut_gauche("",true);
		
		echo debut_boite_info(true);
		
		echo association_date_du_jour();	
		echo propre(_T('asso:plan_info'));
		echo fin_boite_info(true);
		
		
		$res=association_icone(_T('asso:plan_nav_ajouter'),  generer_url_ecrire('edit_plan'), 'EuroOff.gif',  'creer.gif');
		
		$res.=association_icone(_T('asso:bouton_retour'),  $url_retour, "retour-24.png");	
		echo bloc_des_raccourcis($res);
		 
		echo debut_droite("",true);
		
		debut_cadre_relief(  _DIR_PLUGIN_ASSOCIATION_ICONES."EuroOff.gif", false, "", $titre = _T('asso:plan_comptable'));
		
		$classe = _request('classe'); 
		if (!$classe) $classe = '%';
		$actif = _request('actif');
		if (!$actif) $actif = 'oui'; 
		
		echo '<table width="100%">';
		echo '<tr>';
		echo '<td>';
		
		$query = sql_select('DISTINCT classe, actif', 'spip_asso_plan', "actif=". sql_quote($actif),'', "classe");
		
		while ($data = sql_fetch($query)) {
			if ($data['classe']==$class)	{echo ' <strong>'.$data['classe'].' </strong>';}
			else {echo '<a href="'.$url_plan.'&classe='.$data['classe'].'">'.$data['classe'].'</a> ';}
		}
		if ($classe == "%") { echo ' <strong>'._T('asso:plan_entete_tous').'</strong>'; }
		else { echo ' <a href="'.$url_plan.'">'._T('asso:plan_entete_tous').'</a>'; }
		echo '</td>';
		
		echo '<td style="text-align:right;">';
		
		//Filtre actif
		echo '<form method="post" action="'.$url_plan.'"><div>';
		echo '<input type="hidden" name="classe" value="'.$classe.'" />';
		echo '<select name ="actif" class="fondl" onchange="form.submit()">';
		echo '<option value="oui" ';
		if ($actif=='oui') {echo ' selected="selected"';}
		echo '> '._T('asso:plan_libelle_comptes_actifs').'</option>';
		echo '<option value="non" ';
		if ($actif=='non') {echo ' selected="selected"';}
			echo '> '._T('asso:plan_libelle_comptes_desactives').'</option>';
		echo '</select>';
		echo '</div></form>';
		echo '</td>';
		echo '</tr></table>';
		
		//Affichage de la table
		echo "<table border=0 cellpadding=2 cellspacing=0 width='100%' class='arial2' style='border: 1px solid #aaaaaa;'>\n";
		echo '<tr bgcolor="#DBE1C5">';
		echo '<td><strong>Classe</strong></td>';
		echo '<td><strong>Code</strong></td>';
		echo '<td><strong>Intitul&eacute;</strong></td>';
		echo '<td><strong>R&eacute;f&eacute;rence</strong></td>';
		echo '<td style="text-align:right;"><strong>Solde initial</strong></td>';
		echo '<td><strong>Date</strong></td>';
		echo '<td colspan=2 style="text-align:center;"><strong>Action</strong></td>';
		echo'  </tr>';
		$query = sql_select('*', 'spip_asso_plan', "classe LIKE " . sql_quote($classe) ." AND actif=" . sql_quote($actif),'', "classe, code" );
		while ($data = sql_fetch($query)) {
			echo '<tr style="background-color: #EEEEEE;">';
			echo '<td class="arial11 border1" style="text-align:right;">'.$data['classe'].'</td>';
			echo '<td class="arial11 border1">'.$data['code'].'</td>';
			echo '<td class="arial11 border1">'.$data['intitule'].'</td>';
			echo '<td class="arial11 border1">'.$data['reference'].'</td>';
			echo '<td class="arial11 border1" style="text-align:right;">'.number_format($data['solde_anterieur'], 2, ',', ' ').' &euro;</td>';
			echo '<td class="arial11 border1">'.association_datefr($data['date_anterieure']).'</td>';
			echo '<td class="arial11 border1" style="text-align:center;"><a href="'.$url_action_plan.'&id='.$data['id_plan'].'"><img src="'._DIR_PLUGIN_ASSOCIATION_ICONES.'poubelle-12.gif" title="Supprimer"></a></td>';
			echo '<td class="arial11 border1" style="text-align:center;"><a href="'.$url_edit_plan.'&id='.$data['id_plan'].'"><img src="'._DIR_PLUGIN_ASSOCIATION_ICONES.'edit-12.gif" title="Modifier"></a></td>';
			echo'  </tr>';
		}     
		echo'</table>';
		
		fin_cadre_relief();  
		
		echo fin_gauche(), fin_page();
	}
}
?>

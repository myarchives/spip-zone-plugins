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
	
	include_spip('inc/presentation');
	
	function exec_ressources(){
		global $connect_statut, $connect_toutes_rubriques;
		
		debut_page('Ressources', "", "");
		
		$url_ressources = generer_url_ecrire('ressources');
		$url_edit_ressource=generer_url_ecrire('edit_ressource');
		$url_action_ressources=generer_url_ecrire('action_ressources');
		$url_prets=generer_url_ecrire('prets');
		
		debut_gauche();
		
		debut_boite_info();
		echo '<p> Vous pouvez g&eacute;rer ici les diff&eacute;rentes ressources pr&ecirc;t&eacute;es aux membres (livres, mat&eacute;riels, ...)<br />
		La puce indique la disponibilit&eacute; des diff&eacute;rentes ressources</p>';
		fin_boite_info();
		
		debut_raccourcis();
		icone_horizontale('Ajouter une ressource', generer_url_ecrire('edit_ressource','action=ajoute'),'../'._DIR_PLUGIN_ASSOCIATION.'/fiche-perso-24.gif','cree.gif');	
		fin_raccourcis();
		
		debut_droite();
		debut_cadre_relief(  "", false, "", $titre = 'RESSOURCES');
		
		echo "<table border=0 cellpadding=2 cellspacing=0 width='100%' class='arial2' style='border: 1px solid #aaaaaa;'>\n";
		echo "<tr bgcolor='#DBE1C5'>";
		echo '<td>&nbsp;</td>';
		echo '<td><strong>Ressource</strong></td>';
		echo '<td><strong>Code</strong></td>';
		echo '<td><strong>Montant</strong></td>';
		echo '<td colspan="3" style="text-align:center;"><strong>'._T('asso:adherent_entete_action').'</strong></td>';
		echo'  </tr>';
		$query = spip_query ( "SELECT * FROM spip_asso_ressources ORDER BY id_ressource" ) ;
		while ($data = spip_fetch_array($query)) {
			echo '<tr style="background-color: #EEEEEE;">';		
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;">';
			switch($data['statut']){
				case "ok": $puce= "verte"; break;
				case "reserve": $puce= "rouge"; break;
				case "suspendu": $puce="orange"; break;
				case "sorti": $puce="poubelle"; break;	   
			}
			echo '<img src="/dist/images/puce-'.$puce.'.gif"></td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;">'.$data['intitule'].'</td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;">'.$data['code'].'</td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;text-align:right;">'.number_format($data['pu'], 2, ',', ' ').'</td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;text-align:center;"><a href="'.$url_prets.'&id='.$data['id_ressource'].'"><img src="'._DIR_PLUGIN_ASSOCIATION.'/img_pack/voir-12.gif" title="'._T('asso:ressource_label_prets').'"></a></td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;text-align:center;"><a href="'.$url_action_ressources.'&action=supprime&id='.$data['id_ressource'].'"><img src="'._DIR_PLUGIN_ASSOCIATION.'/img_pack/poubelle-12.gif" title="Supprimer la ressource"></a></td>';
			echo '<td class="arial11" style="border-top: 1px solid #CCCCCC;text-align:center;"><a href="'.$url_edit_ressource.'&action=modifie&id='.$data['id_ressource'].'"><img src="'._DIR_PLUGIN_ASSOCIATION.'/img_pack/edit-12.gif" title="Modifier la ressource"></a></td>';
			echo'  </tr>';
		}     
		echo'</table>';
		
		fin_cadre_relief();  
		fin_page();
	}
?>

<?php
	/**
	* Plugin Association
	*
	* Copyright (c) 2007-2008
	* Bernard Blazin & Fran�ois de Montlivault
	* http://www.plugandspip.com 
	* Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	* Pour plus de details voir le fichier COPYING.txt.
	*  
	**/
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');
include_spip ('inc/navigation_modules');
	
function exec_edit_activite(){
		
	include_spip('inc/autoriser');
	if (!autoriser('configurer')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		
		$url_action_activites = generer_url_ecrire('action_activites');
		$url_retour = $_SERVER["HTTP_REFERER"];
		
		$action=$_REQUEST['agir'];
		$id = intval(_request('id'));
		if($action=='ajoute'){$id_evenement=$id;}
		else {$id_activite=$id;}	
		
		$data = !$id ? '' : sql_fetsel("*", "spip_asso_activites", "id_activite=$id");
		if ($data){
			$id_evenement=$data['id_evenement'];
			$nom=$data['nom'];
			$id_adherent=$data['id_adherent'];
			$membres=$data['membres'];
			$non_membres=$data['non_membres'];
			$inscrits=$data['inscrits'];
			$email=$data['email'];
			$telephone=$data['telephone'];
			$adresse=$data['adresse'];
			$montant=$data['montant'];
			$date=$data['date'];
			$statut=$data['statut'];
			$commentaire=$data['commentaires'];
		} else $date = date('Y-m-d');
		if ($id_evenement) {
		  if ($data = sql_fetsel("*", "spip_evenements", "id_evenement=$id_evenement")) {
			$titre=$data['titre'];
			$date_debut=$data['date_debut'];
			$lieu=$data['lieu'];
		  }
		}
		$commencer_page = charger_fonction('commencer_page', 'inc');
		echo $commencer_page(_T('asso:activite_titre_mise_a_jour_inscriptions')) ;
		
		association_onglets();
		
		echo debut_gauche("",true);
		
		echo debut_boite_info(true);
		echo '<div style="font-weight: bold; text-align: center" class="verdana1 spip_xx-small">', _T('asso:activite_nd') . '<br />';
		echo '<span class="spip_xx-large">';
		echo $id_evenement;
		echo '</span></div>';
		echo '<br /><div style="font-weight: bold; text-align: center" class="verdana1 spip_xx-small">'.$titre.'</div>';
		echo '<br /><div>'.association_date_du_jour().'</div>';		
		echo fin_boite_info(true);	
		
		
		echo bloc_des_raccourcis(association_icone(_T('asso:bouton_retour'),  $url_retour, "retour-24.png"));

		
		echo debut_droite("",true);
		echo debut_cadre_relief(  "", false, "", $titre = _T('asso:activite_titre_mise_a_jour_inscriptions'));
		
		echo '<form method="post" action="'.$url_action_activites.'"><div>';
		echo '<label for="date"><strong>'._T('asso:activite_libelle_date')." (AAAA-MM-JJ) :</strong></label>\n";
		echo '<input name="date" type="text" value="'.$date.'" id="date" class="formo" />';
		echo '<label for="nom"><strong>'._T('asso:activite_libelle_nomcomplet')." :</strong></label>\n";
		echo '<input name="nom"  type="text" value="'.$nom.'" id="nom" class="formo" />';
		echo '<label for="id_membre"><strong>'._T('asso:activite_libelle_adherent')." :</strong></label>\n";
		echo '<input name="id_membre" type="text" value="'.$id_adherent.'" id="id_membre" class="formo" />';
		echo '<label for="membres"><strong>'._T('asso:activite_libelle_membres')." :</strong></label>\n";
		echo '<input name="membres"  type="text" value="'.$membres.'" id="membres" class="formo" />';
		echo '<label for="non_membres"><strong>'._T('asso:activite_libelle_non_membres')." :</strong></label>\n";
		echo '<input name="non_membres"  type="text" size="40" value="'.$non_membres.'" id="non_membrese" class="formo" />';
		echo '<label for="inscrits"><strong>'._T('asso:activite_libelle_nombre_inscrit')." :</strong></label>\n";
		echo '<input name="inscrits"  type="text" value="'.$inscrits.'" id="inscrits" class="formo" />';
		echo '<label for="email"><strong>'._T('asso:activite_libelle_email')." :</strong></label>\n";
		echo '<input name="email"  type="text" value="'.$email.'" id="email" class="formo" />';
		echo '<label for="telephone"><strong>'._T('asso:activite_libelle_telephone').' :</strong></label>';
		echo '<input name="telephone" type="text" value="'.$telephone.'" id="telephone" class="formo" />';
		echo '<label for="adresse"><strong>'._T('asso:activite_libelle_adresse_complete').' :</strong></label>';
		echo '<textarea name="adresse" id="adresse" class="formo">'.$adresse."</textarea>\n";
		echo '<label for="montant"><strong>'._T('asso:activite_libelle_montant_inscription'). " :</strong></label>\n";
		echo '<input name="montant"  type="text" value="'.$montant.'" id="montant" class="formo" />';
		echo '<label for="statut"><strong>'._T('asso:activite_libelle_statut'). " ok :</strong></label>\n";
		echo '<input name="statut"  type="checkbox" value="ok"';
		if ($statut=='ok') { echo ' checked="checked"'; }
		echo " id='statut' /><br />\n";
		echo '<label for="commentaire"><strong>'._T('asso:activite_libelle_commentaires')." :</strong></label>\n";
		echo "<textarea name='commentaire' id='commentaire' class='formo'>".$commentaire."</textarea>\n";
		echo '<input name="agir" type="hidden" value="'.$action."\" />\n";
		echo '<input name="id_evenement" type="hidden" value="'.$id_evenement.'" />';
		echo '<input name="id_activite" type="hidden" value="'.$id_activite.'" />';
		echo '<input name="url_retour" type="hidden" value="'.$url_retour.'" />';
		
		echo '<div style="float:right;">';
		echo '<input name="submit" type="submit" value="';
		if ( isset($action)) {echo _T('asso:bouton_'.$action);}
		else {echo _T('asso:bouton_envoyer');}
		echo '" class="fondo" /></div>';
		echo '</div></form>';
		
		fin_cadre_relief();  
		 echo fin_gauche(),fin_page(); 
	}  
}
?>

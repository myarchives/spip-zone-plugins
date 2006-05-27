<?php

/******************************************************************************************/
/* SPIP-listes est un syst�me de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique G�n�rale GNU publi�e par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribu� car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but sp�cifique. Reportez-vous � la Licence Publique G�n�rale GNU  */
/* pour plus de d�tails.                                                                  */
/*                                                                                        */
/* Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU                    */
/* en m�me temps que ce programme ; si ce n'est pas le cas, �crivez � la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, �tats-Unis.                   */
/******************************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');


function exec_import_patron()
{

global $id_message;

 if (!isset($mode)) $mode = $_GET['mode'] ;
if (!isset($inclure_patron)) $inclure_patron = $_POST['inclure_patron'] ; 

if (($inclure_patron == "oui") AND ($mode == "courrier")) {
	if (!isset($patron)) $patron = $_POST['patron'] ;
	if (!isset($date)) $date = $_POST['date'] ; 
  
	echo " " ; // bug de fou
	ob_start();
	//include('spip.php?page=patron');
	// on recup�re le buffer
	$texte_patron = ob_get_contents();
	// on vide et ferme le buffer
	ob_end_clean();  
	
	$titre_patron = _T('spiplistes:lettre_info')." ".$nomsite;
	
	//chdir('./ecrire/');
	//echo getcwd() . "\n";
	
	$titre = addslashes($titre_patron);
	$texte = addslashes($texte_patron);
	
	if((strlen($texte) > 10)){
	spip_query("UPDATE spip_messages SET titre='$titre', texte='$texte' WHERE id_message='$id_message'");
	}else{
	$message_erreur = _T('spiplistes:patron_erreur');
	}
	
	$nomsite=lire_meta("nom_site");
	$urlsite=lire_meta("adresse_site");
	if (!$charset)  $charset = lire_meta('charset');
	
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	echo "<HEAD><META HTTP_EQUIV='Content-Type' CONTENT='text/html; CHARSET=".$charset."'></HEAD><BODY>\n";
	
  echo "<div style='float:right;width:200px;text-align:left;border:1px solid #000;background: yellow;color: #000;margin-bottom: 10px;padding:10px;'>";  
  echo "<p><strong>$patron</strong><p>\n";
  echo _T('spiplistes:date_ref').": $date\n";
	echo "<form action='?exec=gerer_courrier&id_message=$id_message' method='post'>\n";	
	echo "<input type='submit' name='Valider' value='"._T('spiplistes:confirmer')."' class='fondo'>\n";	
	echo "<a href='?exec=gerer_courrier&id_message=$id_message'>"._T('spiplistes:retour_link')."</a><br />\n";
	echo "</form>";
	echo "</div>";
	echo "<div style='text-align:left;margin-right:250px;border-right:2px outset #000000'>";
	echo $texte_patron.$message_erreur;
	
	echo "<hr />"._T('spiplistes:editeur')."<a href=\"".$urlsite."\">".$nomsite."</a><br />";
	echo "<a href=\"".$urlsite."\">".$nomsite."</a><hr />";
	echo "<a href=\"".$addresse_desabo."?d=".$cookie."\">"._T('spiplistes:abonnement_mail')."</a>\n";
	echo "</div>";
	echo "</BODY></HTML>";
		 
	}	



}
?>

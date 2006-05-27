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


function exec_abonnes_tous()
{

global $connect_statut;
global $connect_toutes_rubriques;
global $connect_id_auteur;
global $type;
global $new;
 
 
$nomsite=lire_meta("nom_site"); 
$urlsite=lire_meta("adresse_site"); 

 
// Admin SPIP-Listes
debut_page("Spip listes", "redacteurs", "spiplistes");

// spip-listes bien install� ?
if (!function_exists(spip_listes_onglets)){
    echo("<h3>erreur: spip-listes est mal install� !</h3>"); 
    echo("<p>V�rifier les �tapes d'installation,notamment si vous avez bien renomm� <i>mes_options.txt</i> en <i>mes_options.php3</i>.</p>");    
    fin_page();
	  exit;
}

if ($connect_statut != "0minirezo" ) {
	echo "<p><b>"._T('spiplistes:acces_a_la_page')."</b></p>";
	fin_page();
	exit;
}

if (($connect_statut == "0minirezo") OR ($connect_id_auteur == $id_auteur)) {
	$statut_auteur=$statut;
	spip_listes_onglets("messagerie", "Spip listes");
}

debut_gauche();

spip_listes_raccourcis();

creer_colonne_droite();

debut_droite("messagerie");

 
// MODE STATUT: Suivi des abonnements-------------------------------------------

//
// Recherche d'auteur
//

if ($cherche_auteur) {
	echo "<p align='left'>";
	$query = "SELECT id_auteur, nom, email FROM spip_auteurs";
	$result = spip_query($query);

       


        unset($table_auteurs);
	unset($table_ids);
	while ($row = spip_fetch_array($result)) {
	 
         if( email_valide_bloog($cherche_auteur) ){
                $table_auteurs[] = $row["email"] ; }
                else {
                $table_auteurs[] = $row["nom"];
                }
		$table_ids[] = $row["id_auteur"];
	}
	$resultat = mots_ressemblants($cherche_auteur, $table_auteurs, $table_ids);
	debut_boite_info();
	if (!$resultat) {
		echo "<b>"._T('texte_aucun_resultat_auteur', array('cherche_auteur' => $cherche_auteur)).".</b><br />";
	}
	else if (count($resultat) == 1) {

		list(, $nouv_auteur) = each($resultat);
		echo "<b>"._T('spiplistes:une_inscription')."</b><br />";
		$query = "SELECT * FROM spip_auteurs WHERE id_auteur=$nouv_auteur";
		$result = spip_query($query);
		echo "<ul>";
		while ($row = spip_fetch_array($result)) {
			$id_auteur = $row['id_auteur'];
			$nom_auteur = $row['nom'];
			$email_auteur = $row['email'];
			$bio_auteur = $row['bio'];

			echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3><a href=\"?exec=abonne_edit&id_auteur=$id_auteur\">".typo($nom_auteur)."</a></font></b>";
			echo " | $email_auteur";
                        echo "</font>\n";
		}
		echo "</ul>";
	}
	else if (count($resultat) < 16) {
		reset($resultat);
		unset($les_auteurs);
		while (list(, $id_auteur) = each($resultat)) $les_auteurs[] = $id_auteur;
		if ($les_auteurs) {
			$les_auteurs = join(',', $les_auteurs);
			echo "<b>"._T('texte_plusieurs_articles', array('cherche_auteur' => $cherche_auteur))."</b><br />";
			$query = "SELECT * FROM spip_auteurs WHERE id_auteur IN ($les_auteurs) ORDER BY nom";
			$result = spip_query($query);
			echo "<ul>";
			while ($row = spip_fetch_array($result)) {
				$id_auteur = $row['id_auteur'];
				$nom_auteur = $row['nom'];
				$email_auteur = $row['email'];
				$bio_auteur = $row['bio'];

				echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3>".typo($nom_auteur)."</font></b>";

				if ($email_auteur) echo " ($email_auteur)";
				echo " | <a href=\"?exec=abonne_edit&id_auteur=$id_auteur\">"._T('spiplistes:choisir')."</a>";

				if (trim($bio_auteur)) {
					echo "<br /><font size=1>".couper(propre($bio_auteur), 100)."</font>\n";
				}
				echo "</font><p>\n";
			}
			echo "</ul>";
		}
	}
	else {
		echo "<b>"._T('texte_trop_resultats_auteurs', array('cherche_auteur' => $cherche_auteur))."</b><br />";
	}
	fin_boite_info();
	echo "<p>";

}


global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_articles AS listes LEFT JOIN ".$table_prefix."_auteurs_articles AS abonnements USING (id_article) WHERE statut='liste'";
$result_pile = spip_query($query_message);
$nb_abonnes = spip_num_rows($result_pile);
		
$query = "SELECT id_auteur, nom, extra FROM spip_auteurs";
$result = spip_query($query);
$nb_inscrits = spip_num_rows($result);

	$cmpt_texte = 0;
	$cmpt_html = 0;
	$cmpt_non = 0;

	while ($row = spip_fetch_array($result)) {
	$abo = get_extra($row["id_auteur"],auteur);

	if ($abo['abo'] == "texte"){
	$cmpt_texte = $cmpt_texte + 1 ;
	}

	if ($abo['abo'] == "html"){
	$cmpt_html = $cmpt_html + 1 ;
	}

	if ($abo['abo'] == "non"){
	$cmpt_non = $cmpt_non + 1 ;
	}

	$total_abo = $cmpt_html + $cmpt_texte ;
	}


debut_cadre_relief('forum-interne-24.gif');


echo"<div>";
echo"<div style='float:right;width:150px'>";
echo "<b>"._T('spiplistes:repartition')."</b>  <br /><b>"._T('spiplistes:html')."</b> : $cmpt_html <br /><b>"._T('spiplistes:texte')."</b> : $cmpt_texte <br /><b>"._T('spiplistes:desabonnes')."</b> : $cmpt_non";
echo"</div>";
$total= $cmpt_html+$cmpt_texte+$cmpt_non;
echo "<p>"._T('spiplistes:nb_inscrits').$total."&nbsp;&nbsp;/&nbsp;&nbsp;"._T('spiplistes:nb_abonnes').$total_abo."<br />"._T('spiplistes:nb_listes').$nb_abonnes."</p>";
echo"</div>";


//echo debut_block_invisible("auteursarticle");

	$query = "SELECT * FROM spip_auteurs WHERE ";
	$query .= "statut!='5poubelle' AND statut!='nouveau' ORDER BY statut, nom";
	$result = spip_query($query);

	if (spip_num_rows($result) > 0) {
		echo "<form action='?exec=abonnes_tous' METHOD='post'>";
        echo "<div align=center>\n";
		echo "<input type='text' name='cherche_auteur' class='fondl' value='' size='20'>";
		echo " <input type='submit' name='Chercher' value='"._T('bouton_chercher')."' class='fondo'>";
		echo "</div></FORM>";
	}
// echo fin_block();



fin_cadre_relief();

echo "<p>";

// auteur

$retour = "?exec=abonnes_tous";

//changer de statut

if(!$statut) $statut=' ';

if( ($changer_statut=='oui') AND ( ($statut=='html') OR ($statut=='texte') OR ($statut=='non') ) ){
$extras = get_extra($id_auteur,"auteur");
$extras["abo"] = $statut;
set_extra($id_auteur,$extras,"auteur");
}

if ($tri) {
	$retour .= "&tri=$tri";
	if ($tri=='nom' OR $tri=='statut')
		$partri = " "._T('info_par_tri', array('tri' => $tri));
	else if ($tri=='id')
		$partri = _T('spiplistes:par_date');
	
	}

//
// Construire la requete
//


	$sql_statut_auteurs = " AND auteurs.statut IN ('0minirezo', '1comite', '5poubelle','6forum')";
	$sql_statut_articles = "";


// tri
switch ($tri) {
//trier les extra ? pas simple..., trions par id
case 'id':
	$sql_order = ' ORDER BY auteurs.id_auteur DESC, unom';
	$type_requete = 'auteur';
	break;

case 'statut':
	$sql_order = ' ORDER BY auteurs.statut, login = "", unom';
	$type_requete = 'auteur';
	break;

case 'nom':
default:
	$sql_order = ' ORDER BY unom';
	$type_requete = 'auteur';
}


// si on doit afficher les auteurs par statut ou par nom,
// la requete principale est simple, et une autre requete
// vient calculer les nombres d'articles publies ;
// si en revanche on doit classer par nombre, la bonne requete
// est la concatenation de $query_nombres et de $query_auteurs

unset($nombre_auteurs);
$auteurs = Array();

if ($type_requete == 'auteur') {
	$result_auteurs = spip_query("SELECT id_auteur, extra, statut, source, pass, login, nom, email, url_site, UPPER(nom) AS unom
		FROM spip_auteurs AS auteurs
		WHERE 1 $sql_statut_auteurs
		$sql_order");
	while ($row = spip_fetch_array($result_auteurs)) {
		$auteurs[$row['id_auteur']] = $row;
		$nombre_auteurs ++;

		$nom_auteur = $row['nom'];
		$premiere_lettre = addslashes(strtoupper(substr($nom_auteur,0,1)));
		if ($premiere_lettre != $lettre_prec) {
			$lettre[$premiere_lettre] = $nombre_auteurs;
		}
		$lettre_prec = $premiere_lettre;
	}

	$result_nombres = spip_query("SELECT auteurs.id_auteur, UPPER(auteurs.nom) AS unom, COUNT(articles.id_article) AS compteur
		FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien, spip_articles AS articles
		WHERE auteurs.id_auteur=lien.id_auteur AND lien.id_article=articles.id_article
		$sql_statut_auteurs $sql_statut_articles
		GROUP BY auteurs.id_auteur
		$sql_order");
	while ($row = spip_fetch_array($result_nombres))
		$auteurs[$row['id_auteur']]['compteur'] = $row['compteur'];

	// si on n'est pas minirezo, supprimer les auteurs sans article publie
	// sauf les admins, toujours visibles.
	
	

} else { // tri par nombre
	$result_nombres = spip_query("SELECT auteurs.id_auteur, auteurs.statut, auteurs.source, auteurs.pass, auteurs.login, auteurs.nom, auteurs.email, auteurs.url_site, UPPER(nom) AS unom, COUNT(articles.id_article) AS compteur
		FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien, spip_articles AS articles
		WHERE auteurs.id_auteur=lien.id_auteur AND lien.id_article=articles.id_article
		$sql_statut_auteurs $sql_statut_articles
		GROUP BY auteurs.id_auteur
		$sql_order");
	unset($vus);
	while ($row = spip_fetch_array($result_nombres)) {
		$auteurs[$row['id_auteur']] = $row;
		$vus .= ','.$row['id_auteur'];
		$nombre_auteurs ++;
	}

	// si on est admin, ajouter tous les auteurs sans articles
	// sinon ajouter seulement les admins sans articles
	if ($connect_statut == '0minirezo')
		$sql_statut_auteurs_ajout = $sql_statut_auteurs;
	
	$result_auteurs = spip_query("SELECT auteurs.id_auteur, auteurs.statut, auteurs.source, auteurs.pass, auteurs.login, auteurs.nom, auteurs.email, auteurs.url_site, UPPER(nom) AS unom, 0 as compteur
		FROM spip_auteurs AS auteurs
		WHERE id_auteur NOT IN (0$vus)
		$sql_statut_auteurs_ajout
		$sql_order");
	while ($row = spip_fetch_array($result_auteurs)) {
		$auteurs[$row['id_auteur']] = $row;
		$nombre_auteurs ++;
	}
}


unset ($rub_restreinte);
if ($connect_statut == '0minirezo') { // recuperer les admins restreints
	$restreint = spip_query("SELECT * FROM spip_auteurs_rubriques");
	while ($row = spip_fetch_array($restreint))
		$rub_restreinte[$row['id_auteur']] .= ','.$row['id_rubrique'];
}

//
// Affichage
//


// reglage du debut
$max_par_page = 30;
if ($debut > $nombre_auteurs - $max_par_page)
	$debut = max(0,$nombre_auteurs - $max_par_page);
$fin = min($nombre_auteurs, $debut + $max_par_page);

// ignorer les $debut premiers
unset ($i);
reset ($auteurs);
while ($i++ < $debut AND each($auteurs));

// ici commence la vraie boucle
debut_cadre_relief('redacteurs-24.gif');
echo "<table border='0' cellpadding=3 cellspacing=0 width='100%' class='arial2'>\n";
echo "<tr bgcolor='#DBE1C5'>";
echo "<td width='20'>";
	$img = "<img src='img_pack/admin-12.gif' alt='' border='0'>";
	if ($tri=='statut')
		echo $img;
	else
		echo "<a href='?exec=abonnes_tous&tri=statut' title='"._T('lien_trier_statut')."'>$img</a>";

echo "</td><td>";
	if ($tri == '' OR $tri=='nom')
		echo '<b>'._T('info_nom').'</b>';
	else
		echo "<a href='?exec=abonnes_tous&tri=nom' title='"._T('lien_trier_nom')."'><b>"._T('info_nom')."</b></a>";

if ($options == 'avancees') echo "</td><td colspan='2'><b>"._T('info_contact')."</b>";
echo "</td><td>";
	if ($visiteurs != 'oui') {
		if ($tri=='nombre')
			echo "<b>"._T('spiplistes:format')."</b>";
		else
			echo "<b>"._T('spiplistes:format')."</b>"; 

	}
echo "</td><td>";
echo "<b>"._T('spiplistes:modifier')."</b>";

echo "</td></tr>\n";

if ($nombre_auteurs > $max_par_page) {
	echo "<tr bgcolor='white'><td colspan='".($options == 'avancees' ? 5 : 3)."'>";
	echo "<font face='Verdana,Arial,Sans,sans-serif' size='2'>";
	for ($j=0; $j < $nombre_auteurs; $j+=$max_par_page) {
		if ($j > 0) echo " | ";

		if ($j == $debut)
			echo "<b>$j</b>";
		else if ($j > 0)
			echo "<a href=$retour&debut=$j>$j</a>";
		else
			echo " <a href=$retour>0</a>";

		if ($debut > $j  AND $debut < $j+$max_par_page){
			echo " | <b>$debut</b>";
		}

	}
	echo "</font>";
	echo "</td></tr>\n";

	if (($tri == 'nom' OR !$tri) AND $options == 'avancees') {
		// affichage des lettres
		echo "<tr bgcolor='white'><td colspan='5'>";
		echo "<font face='Verdana,Arial,Sans,sans-serif' size=2>";
		while (list($key,$val) = each($lettre)) {
			if ($val == $debut)
				echo "<b>$key</b> ";
			else
				echo "<a href=$retour&debut=$val>$key</a> ";
		}
		echo "</font>";
		echo "</td></tr>\n";
	}
	echo "<tr height='5'></tr>";
}


 if($debut)$retour .="&debut=".$debut;

//translate extra field data
list(,,,$trad,$val) = explode("|",_T("spiplistes:options")); 
$trad = explode(",",$trad);
$val = explode(",",$val);
$trad_map = Array();
for($index_map=0;$index_map<count($val);$index_map++) {
	$trad_map[$val[$index_map]] = $trad[$index_map];
}

while ($i++ <= $fin && (list(,$row) = each ($auteurs))) {
	// couleur de ligne
	$couleur = ($i % 2) ? '#FFFFFF' : $couleur_claire;
	echo "<tr bgcolor='$couleur'>";

	// statut auteur
	echo "<td>";
	echo bonhomme_statut($row);

	// nom
	echo '</td><td>';
	echo "<a href='?exec=abonne_edit&id_auteur=".$row['id_auteur']."'>".typo($row['nom']).'</a>';

	if ($connect_statut == '0minirezo' AND $row['statut']=='0minirezo' AND $rub_restreinte[$row['id_auteur']])
		echo " &nbsp;<small>"._T('statut_admin_restreint')."</small>";


	// contact
	if ($options == 'avancees') {
		echo '</td><td>';
		if ($row['messagerie'] == 'oui' AND $row['login']
		AND $activer_messagerie != "non" AND $connect_activer_messagerie != "non" AND $messagerie != "non")
			echo bouton_imessage($row['id_auteur'],"force")."&nbsp;";
		if ($connect_statut=="0minirezo")
			if (strlen($row['email'])>3)
				echo "<a href='mailto:".$row['email']."'>"._T('lien_email')."</a>";
			else
				echo "&nbsp;";

		if (strlen($row['url_site'])>3)
			echo "</td><td><a href='".$row['url_site']."'>"._T('lien_site')."</a>";
		else
			echo "</td><td>&nbsp;";
	}

	// Abonn� ou pas ?
	echo '</td><td>';
	
	$extra = unserialize ($row["extra"]);
	
        if( !is_array($extra) ){
        $extra = array();
        $extra["abo"] = "non";
        set_extra($row["id_auteur"],$extra,'auteur');
        get_extra($row["id_auteur"],'auteur');
        }
	
        $abo = $extra["abo"];

		if($abo == "non") echo "-";
		else echo "&nbsp;".$trad_map[$abo];
		
		
		// Modifier l'abonnement
	echo '</td><td>';
	
  if ($row["statut"] != '0minirezo') {
if($extra["abo"] == 'html') $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=non'>"._T('spiplistes:desabo')."</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=texte'>"._T('spiplistes:texte')."</a>";
else if($extra["abo"] == 'texte') $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=non'>"._T('spiplistes:desabo')."</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=html'>html</a>";
else  if(($extra["abo"] == 'non')OR (!$extra["abo"])) $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=texte'>"._T('spiplistes:texte')."</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=html'>html</a>";
echo "&nbsp;".$option_abo;
  }
	echo "</td></tr>\n";
}

echo "</table>\n";


echo "<a name='bas'>";
echo "<table width='100%' border='0'>";

$debut_suivant = $debut + $max_par_page;
if ($debut_suivant < $nombre_auteurs OR $debut > 0) {
	echo "<tr height='10'></tr>";
	echo "<tr bgcolor='white'><td align='left'>";
	if ($debut > 0) {
		$debut_prec = strval(max($debut - $max_par_page, 0));
		$link = new Link;
		$link->addVar('debut', $debut_prec);
		echo $link->getForm('GET');
		echo "<input type='submit' name='submit' value='&lt;&lt;&lt;' class='fondo'>";
		echo "</form>";
		//echo "<a href='$retour&debut=$debut_prec'>&lt;&lt;&lt;</a>";
	}
	echo "</td><td align='right'>";
	if ($debut_suivant < $nombre_auteurs) {
		$link = new Link;
		$link->addVar('debut', $debut_suivant);
		echo $link->getForm('GET');
		echo "<input type='submit' name='submit' value='&gt;&gt;&gt;' class='fondo'>";
		echo "</form>";
		//echo "<a href='$retour&debut=$debut_suivant'>&gt;&gt;&gt;</a>";
	}
	echo "</td></tr>\n";
}

echo "</table>\n";

fin_cadre_relief();




// MODE STATUT FIN -------------------------------------------------------------


$spiplistes_version = "SPIP-listes b1.9";
echo "<p style='font-family: Arial, Verdana,sans-serif;font-size:10px;font-weight:bold'>".$spiplistes_version."<p>" ;

fin_page();

}

/******************************************************************************************/
/* SPIP-listes est un syst�me de gestion de listes d'abonn�s et d'envoi d'information     */
/* par email  pour SPIP.                                                                  */
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
?>

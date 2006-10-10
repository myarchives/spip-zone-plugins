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
include_spip('inc/acces');
include_spip('base/abstract_sql');
include_spip('inc/auteurs_complets_gestion');

// http://doc.spip.org/@exec_auteur_infos_dist
function exec_auteur_infos_dist()
{
auteurs_complets_install();
global $ajouter_id_article,
  $bio,
  $champs_extra,
  $connect_id_auteur,
  $connect_statut,
  $connect_toutes_rubriques,
  $email,
  $email,
  $telephone,
  $fax,
  $skype,
  $adresse,
  $codepostal,
  $ville,
  $pays,
  $latitude,
  $longitude,
  $id_auteur,
  $new_login,
  $new_pass,
  $new_pass2,
  $nom,
  $nom_site_auteur,
  $perso_activer_imessage,
  $pgp,
  $redirect,
  $redirect_ok,
  $statut,
  $url_site;

 $id_auteur = intval($id_auteur);
 $ajouter_id_article = intval($ajouter_id_article);
	pipeline('exec_init',
		array('args' => array(
			'exec'=>'auteur_infos',
			'id_auteur'=>$id_auteur),
		'data'=>'')
	);

//
// Recuperer id_auteur ou se preparer a l'inventer
//
	if ($id_auteur) {
		$auteur = spip_fetch_array(spip_query("SELECT * FROM spip_auteurs WHERE id_auteur=$id_auteur"));
		if (!$auteur) exit;
	} else {
		$auteur['nom'] = filtrer_entites(_T('item_nouvel_auteur'));
		$onfocus = " onfocus=\"if(!antifocus){this.value='';antifocus=true;}\"";
		$auteur['statut'] = '1comite'; // statut par defaut a la creation
		$auteur['source'] = 'spip';
	}

	// formulaire de changement de statut
	// (faux chargement pour disposer de la fonction ci-dessous. a revoir)
	$f = charger_fonction('instituer_auteur', 'inc');

	if (!statut_modifiable_auteur($id_auteur, $auteur)) {
		gros_titre(_T('info_acces_interdit'));
		exit;
	}

//
// Modification (et creation si besoin)
//

// si on poste un nom, c'est qu'on modifie une fiche auteur
if (strval($nom)!='') {
	$auteur['nom'] = corriger_caracteres($nom);

	// login et mot de passe
	$modif_login = false;
	$old_login = $auteur['login'];
	if (($new_login<>$old_login) AND $connect_statut == '0minirezo' AND $connect_toutes_rubriques AND $auteur['source'] == 'spip') {
		if ($new_login) {
			if (strlen($new_login) < 4)
				$echec .= "\n<p>"._T('info_login_trop_court');
			else {
			  $n = spip_fetch_array(spip_query("SELECT COUNT(*) AS n FROM spip_auteurs WHERE login=" . spip_abstract_quote($new_login) . " AND id_auteur!=$id_auteur AND statut!='5poubelle'"));
			  if ($n['n'])
				$echec .= "\n<p>"._T('info_login_existant');
			  else if ($new_login != $old_login) {
				$modif_login = true;
				$auteur['login'] = $new_login;
			  }
			}
		}
		// suppression du login
		else {
			$auteur['login'] = '';
			$modif_login = true;
		}
	}

	// changement de pass, a securiser en jaja ?
	if ($new_pass AND ($statut != '5poubelle') AND $auteur['login'] AND $auteur['source'] == 'spip') {
		if ($new_pass != $new_pass2)
			$echec .= "\n<p>"._T('info_passes_identiques');
		else if ($new_pass AND strlen($new_pass) < 6)
			$echec .= "\n<p>"._T('info_passe_trop_court');
		else {
			$modif_login = true;
			$auteur['new_pass'] = $new_pass;
		}
	}

	if ($modif_login) {
		$var_f = charger_fonction('session', 'inc');
		$var_f($auteur['id_auteur']);
	}

	// email
	// seuls les admins peuvent modifier l'email
	// les admins restreints peuvent modifier l'email des redacteurs
	// mais pas des autres admins
	if ($connect_statut == '0minirezo'
	AND ($connect_toutes_rubriques OR $statut<>'0minirezo')) { 
	  if (isset($email)) {
		$email = trim($email);	 
		if ($email !='' AND !email_valide($email)) 
			$echec .= "\n<p>"._T('info_email_invalide');
		$auteur['email'] = $email;
	  }
	}

	if ($connect_id_auteur == $id_auteur) {
		if ($perso_activer_imessage) {
			spip_query("UPDATE spip_auteurs SET imessage='$perso_activer_imessage' WHERE id_auteur=$id_auteur");
			$auteur['imessage'] = $perso_activer_imessage;
		}
	}

	// variables sans probleme
	$auteur['bio'] = corriger_caracteres($bio);
	$auteur['telephone'] = corriger_caracteres($telephone);
	$auteur['fax'] = corriger_caracteres($fax);
	$auteur['adresse'] = corriger_caracteres($adresse);
	$auteur['codepostal'] = corriger_caracteres($codepostal);
	$auteur['ville'] = corriger_caracteres($ville);
	$auteur['skype'] = corriger_caracteres($skype);
	$auteur['pays'] = corriger_caracteres($pays);
	$auteur['latitude'] = corriger_caracteres($latitude);
	$auteur['longitude'] = corriger_caracteres($longitude);
	$auteur['pgp'] = corriger_caracteres($pgp);
	$auteur['nom_site'] = corriger_caracteres($nom_site_auteur); // attention mix avec $nom_site_spip ;(
	$auteur['url_site'] = vider_url($url_site, false);

	if ($new_pass) {
		$htpass = generer_htpass($new_pass);
		$alea_actuel = creer_uniqid();
		$alea_futur = creer_uniqid();
		$pass = md5($alea_actuel.$new_pass);
		$query_pass = " pass='$pass', htpass='$htpass', alea_actuel='$alea_actuel', alea_futur='$alea_futur', ";
		if ($auteur['id_auteur'])
		  effacer_low_sec($auteur['id_auteur']);
	} else
		$query_pass = '';

	// recoller les champs du extra
	if ($champs_extra) {
		include_spip('inc/extra');
		$extra = extra_recup_saisie("auteurs");
	} else
		$extra = '';

	// l'entrer dans la base
	if (!$echec) {
		if (!$auteur['id_auteur']) { // creation si pas d'id
			$auteur['id_auteur'] = $id_auteur = spip_abstract_insert("spip_auteurs", "(nom)", "('temp')");

			if ($ajouter_id_article)
				spip_abstract_insert("spip_auteurs_articles", "(id_auteur, id_article)", "($id_auteur, $ajouter_id_article)");
		}

		$n = spip_query("UPDATE spip_auteurs SET $query_pass
		nom=" . spip_abstract_quote($auteur['nom']) . ",
		login=" . spip_abstract_quote($auteur['login']) . ",
		bio=" . spip_abstract_quote($auteur['bio']) . ",
		email=" . spip_abstract_quote($auteur['email']) . ",
		telephone=" . spip_abstract_quote($auteur['telephone']) . ",
		fax=" . spip_abstract_quote($auteur['fax']) . ",
		skype=" . spip_abstract_quote($auteur['skype']) . ",
		adresse=" . spip_abstract_quote($auteur['adresse']) . ",
		codepostal=" . spip_abstract_quote($auteur['codepostal']) . ",
		ville=" . spip_abstract_quote($auteur['ville']) . ",
		pays=" . spip_abstract_quote($auteur['pays']) . ",
		latitude=" . spip_abstract_quote($auteur['latitude']) . ",
		longitude=" . spip_abstract_quote($auteur['longitude']) . ",
		nom_site=" . spip_abstract_quote($auteur['nom_site']) . ",
		url_site=" . spip_abstract_quote($auteur['url_site']) . ",
		pgp=" . spip_abstract_quote($auteur['pgp']) . (!$extra ? '' : (", extra = " . spip_abstract_quote($extra) . "")) . " WHERE id_auteur=".$auteur['id_auteur']);
		if (!$n) die('UPDATE');
	}
 }


// Si on modifie la fiche auteur, reindexer et modifier htpasswd
if ($nom OR $statut) {
	if ($GLOBALS['meta']['activer_moteur'] == 'oui') {
		include_spip("inc/indexation");
		marquer_indexer('spip_auteurs', $id_auteur);
	}

	// Mettre a jour les fichiers .htpasswd et .htpasswd-admin
	ecrire_acces();
}

// Redirection
if (!$echec AND $redirect_ok == "oui") {
  redirige_par_entete($redirect ? rawurldecode($redirect) : generer_url_ecrire("auteurs_edit", "id_auteur=$id_auteur", true));
}
exec_affiche_auteur_info_dist($id_auteur, $auteur,  $echec, $redirect, $ajouter_id_article, $onfocus);

}

// http://doc.spip.org/@exec_affiche_auteur_info_dist
function exec_affiche_auteur_info_dist($id_auteur, $auteur,  $echec, $redirect, $ajouter_id_article, $onfocus)
{
  global $connect_id_auteur;

  if ($connect_id_auteur == $id_auteur)
	debut_page($auteur['nom'], "auteurs", "perso");
  else
	debut_page($auteur['nom'],"auteurs","redacteurs");

  echo "<br><br><br>";

  debut_gauche();

  cadre_auteur_infos($id_auteur, $auteur);

	echo pipeline('affiche_gauche',
		array('args' => array(
			'exec'=>'auteur_infos',
			'id_auteur'=>$id_auteur),
		'data'=>'')
	);

	creer_colonne_droite();
	echo pipeline('affiche_droite',
		array('args' => array(
			'exec'=>'auteur_infos',
			'id_auteur'=>$id_auteur),
		'data'=>'')
	);
	debut_droite();

//
// Formulaire d'edition de l'auteur
//

  if ($echec){
	debut_cadre_relief();
	echo http_img_pack("warning.gif", _T('info_avertissement'), "width='48' height='48' align='left'");
	echo "<font color='red'>$echec \n<p>"._T('info_recommencer')."</font>";
	fin_cadre_relief();
	echo "\n<p>";
  }

  debut_cadre_formulaire();
  formulaire_auteur_infos($id_auteur, $auteur, $onfocus, $redirect, $ajouter_id_article);
  fin_cadre_formulaire();
  echo "&nbsp;<p />";

  fin_page();
}



// http://doc.spip.org/@formulaire_auteur_infos
function formulaire_auteur_infos($id_auteur, $auteur, $onfocus, $redirect, $ajouter_id_article)
{
  global $connect_statut, $connect_toutes_rubriques,$connect_id_auteur, $options, $champs_extra  ;

	echo generer_url_post_ecrire('auteur_infos', (!$id_auteur ? "" : "id_auteur=$id_auteur"));

//
// Infos personnelles
//

echo "\n<div class='serif'>";

debut_cadre_relief("fiche-perso-24.gif", false, "", _T("icone_informations_personnelles"));

echo _T('titre_cadre_signature_obligatoire');
echo "("._T('entree_nom_pseudo').")<br />\n";
echo "<INPUT TYPE='text' NAME='nom' CLASS='formo' VALUE=\"".entites_html($auteur['nom'])."\" SIZE='40' $onfocus>\n<p>";

echo "<B>"._T('entree_adresse_email')."</B>";

if ($connect_statut == "0minirezo"
AND ($connect_toutes_rubriques OR $auteur['statut']<>'0minirezo')) {
	echo "<br><INPUT TYPE='text' NAME='email' CLASS='formo' VALUE=\"".entites_html($auteur['email'])."\" SIZE='40'>\n<p>\n";
}
else {
	echo "&nbsp;: <tt>".$auteur['email']."</tt>";
	echo "<br>("._T('info_reserve_admin').")\n";
	echo "\n<p>";
}

echo "<B>"._T('entree_infos_perso')."</B><br />\n";
echo "("._T('entree_biographie').")<br />\n";
echo "<TEXTAREA NAME='bio' CLASS='forml' ROWS='4' COLS='40' wrap=soft>";
echo entites_html($auteur['bio']);
echo "</TEXTAREA>\n";
echo "<b>"._T('auteurscomplets:entree_telephone')."</b>";
echo "<br><input type='text' name='telephone' class='formo' value=\"".entites_html($auteur['telephone'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_fax')."</b>";
echo "<br><input type='text' name='fax' class='formo' value=\"".entites_html($auteur['fax'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_skype')."</b>";
echo "<br><input type='text' name='skype' class='formo' value=\"".entites_html($auteur['skype'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_adresse')."</b><BR>\n";
echo "<input type='text' name='adresse' class='formo' value=\"".entites_html($auteur['adresse'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_codepostal')."</b>";
echo "<br><input type='text' name='codepostal' class='formo' value=\"".entites_html($auteur['codepostal'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_ville')."</b>";
echo "<br><input type='text' name='ville' class='formo' value=\"".entites_html($auteur['ville'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_pays')."</b>";
echo "<br><input type='text' name='pays' class='formo' value=\"".entites_html($auteur['pays'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_latitude')."</b>";
echo "<br><input type='text' name='latitude' class='formo' value=\"".entites_html($auteur['latitude'])."\" size='40'>\n<p>\n";
echo "<b>"._T('auteurscomplets:entree_longitude')."</b>";
echo "<br><input type='text' name='longitude' class='formo' value=\"".entites_html($auteur['longitude'])."\" size='40'>\n<p>\n";

debut_cadre_enfonce("site-24.gif", false, "", _T('info_site_web'));
echo "<B>"._T('entree_nom_site')."</B><br />\n";
echo "<INPUT TYPE='text' NAME='nom_site_auteur' CLASS='forml' VALUE=\"".entites_html($auteur['nom_site'])."\" SIZE='40'><P>\n";

echo "<B>"._T('entree_url')."</B><br />\n";
echo "<INPUT TYPE='text' NAME='url_site' CLASS='forml' VALUE=\"".entites_html($auteur['url_site'])."\" SIZE='40'>\n";
fin_cadre_enfonce();
	echo "\n<p>";

if ($options == "avancees") {
	debut_cadre_enfonce("cadenas-24.gif", false, "", _T('entree_cle_pgp'));
	echo "<TEXTAREA NAME='pgp' CLASS='forml' ROWS='4' COLS='40' wrap=soft>";
	echo entites_html($auteur['pgp']);
	echo "</TEXTAREA>\n";
	fin_cadre_enfonce();
	echo "\n<p>";
}
else {
	echo "<input type='hidden' name='pgp' value=\"".entites_html($auteur['pgp'])."\">";
}

echo "\n<p>";
	if ($champs_extra) {
		include_spip('inc/extra');
		extra_saisie($auteur['extra'], 'auteurs', $auteur['statut']);
	}


//
// Login et mot de passe :
// accessibles seulement aux admins non restreints et l'auteur lui-meme
//

if ($auteur['source'] != 'spip') {
	$edit_login = false;
	$edit_pass = false;
}
else if (($connect_statut == "0minirezo") AND $connect_toutes_rubriques) {
	$edit_login = true;
	$edit_pass = true;
}
else if ($connect_id_auteur == $id_auteur) {
	$edit_login = false;
	$edit_pass = true;
}
else {
	$edit_login = false;
	$edit_pass = false;
}

debut_cadre_relief("base-24.gif");

// Avertissement en cas de modifs de ses propres donnees
if (($edit_login OR $edit_pass) AND $connect_id_auteur == $id_auteur) {
	debut_cadre_enfonce();
	echo http_img_pack("warning.gif", _T('info_avertissement'), "width='48' height='48' align='right'");
	echo "<b>"._T('texte_login_precaution')."</b>\n";
	fin_cadre_enfonce();
	echo "\n<p>";
}

// Un redacteur n'a pas le droit de modifier son login !
if ($edit_login) {
	echo "<B>"._T('item_login')."</B> ";
	echo "<font color='red'>("._T('texte_plus_trois_car').")</font> :<br />\n";
	echo "<INPUT TYPE='text' NAME='new_login' CLASS='formo' VALUE=\"".entites_html($auteur['login'])."\" SIZE='40'><P>\n";
}
else {
	echo "<fieldset style='padding:5'><legend><B>"._T('item_login')."</B><br />\n</legend><br><b>".$auteur['login']."</b> ";
	echo "<i> ("._T('info_non_modifiable').")</i>\n<p>";
}

// On ne peut modifier le mot de passe en cas de source externe (par exemple LDAP)
if ($edit_pass) {
	echo "<B>"._T('entree_nouveau_passe')."</B> ";
	echo "<font color='red'>("._T('info_plus_cinq_car').")</font> :<br />\n";
	echo "<INPUT TYPE='password' NAME='new_pass' CLASS='formo' VALUE=\"\" SIZE='40'><br />\n";
	echo _T('info_confirmer_passe')."<br />\n";
	echo "<INPUT TYPE='password' NAME='new_pass2' CLASS='formo' VALUE=\"\" SIZE='40'><P>\n";
}
fin_cadre_relief();
echo "<p />";


//
// Apparaitre dans la liste des redacteurs connectes
//

 if ($apparait) apparait_auteur_infos($id_auteur, $auteur);

echo "<INPUT NAME='ajouter_id_article' VALUE='$ajouter_id_article' TYPE='hidden'>\n";
echo "<INPUT NAME='redirect' VALUE='$redirect' TYPE='hidden'>\n";
echo "<INPUT NAME='redirect_ok' VALUE='oui' TYPE='hidden'>\n";

echo "\n<div align='right'><INPUT TYPE='submit' CLASS='fondo' NAME='Valider' VALUE='"._T('bouton_enregistrer')."'></DIV>";

echo pipeline('affiche_milieu',
	array('args' => array(
		'exec'=>'auteur_infos',
		'id_auteur'=>$id_auteur),
	'data'=>'')
);

echo "</div>";
fin_cadre_relief();
echo "</form>";

// Afficher le formulaire de changement de statut (cf. inc_acces)
 $f = charger_fonction('instituer_auteur', 'inc');
 echo $f($id_auteur, $auteur['statut'], "auteurs_edit");
}

//
// Apparaitre dans la liste des redacteurs connectes
//

// http://doc.spip.org/@apparait_auteur_infos
function apparait_auteur_infos($id_auteur, $auteur)
{
	global $connect_id_auteur ;
	if ($connect_id_auteur == $id_auteur) {

		debut_cadre_relief("messagerie-24.gif", false, "", _T('info_liste_redacteurs_connectes'));
		
		echo "\n<div>"._T('texte_auteur_messagerie')."</div>";	

		if ($auteur['imessage']=="non"){
			echo "<INPUT TYPE='radio' NAME='perso_activer_imessage' VALUE='oui' id='perso_activer_imessage_on'>";
			echo " <label for='perso_activer_imessage_on'>"._T('bouton_radio_apparaitre_liste_redacteurs_connectes')."</label> ";
			echo "<br />\n<INPUT TYPE='radio' NAME='perso_activer_imessage' VALUE='non' CHECKED id='perso_activer_imessage_off'>";
			echo " <B><label for='perso_activer_imessage_off'>"._T('bouton_radio_non_apparaitre_liste_redacteurs_connectes')."</label></B> ";
		} else {
			echo "<INPUT TYPE='radio' NAME='perso_activer_imessage' VALUE='oui' id='perso_activer_imessage_on' CHECKED>";
			echo " <B><label for='perso_activer_imessage_on'>"._T('bouton_radio_apparaitre_liste_redacteurs_connectes')."</label></B> ";

			echo "<br />\n<INPUT TYPE='radio' NAME='perso_activer_imessage' VALUE='non' id='perso_activer_imessage_off'>";
			echo " <label for='perso_activer_imessage_off'>"._T('bouton_radio_non_apparaitre_liste_redacteurs_connectes')."</label> ";
		}

	fin_cadre_relief();
	echo "<p />";
	}
}
?>

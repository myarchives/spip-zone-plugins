<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2008                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

if (!defined('_LOGIN_TROP_COURT')) define('_LOGIN_TROP_COURT', 4);

function formulaires_inscription_charger_dist($mode, $focus, $id=0) {
	$valeurs = array('nom_inscription'=>'','mail_inscription'=>'', 'id'=>$id);
	if ($mode=='1comite')
		$valeurs['_commentaire'] = _T('pass_espace_prive_bla');
	else 
		$valeurs['_commentaire'] = _T('pass_forum_bla');

	if (!tester_config($id, $mode))
		$valeurs['editable'] = false;

	return $valeurs;
}

// Si inscriptions pas autorisees, retourner une chaine d'avertissement
function formulaires_inscription_verifier_dist($mode, $focus, $id=0) {

	$erreurs = array();
	include_spip('inc/filtres');	
	if (!tester_config($id, $mode))
		$erreurs['message_erreur'] = _T('rien_a_faire_ici');

	if (!$nom = _request('nom_inscription'))
		$erreurs['nom_inscription'] = _T("info_obligatoire");
	else {
		$nom = trim(corriger_caracteres($nom));
		if((strlen ($nom) < _LOGIN_TROP_COURT) OR (strlen($nom) > 64) OR (strlen(_request('nobot'))>0))
			$erreurs['nom_inscription'] = _T('info_login_trop_court');
	}
	
	if (!$mail = _request('mail_inscription'))
		$erreurs['mail_inscription'] = _T("info_obligatoire");
	elseif(!email_valide($mail)){
		$erreurs['mail_inscription'] = _T("form_prop_indiquer_email");
	}
	
	// compatibilite avec anciennes fonction surchargeables
	// plus de definition par defaut
	if (!count($erreurs)){
		if (function_exists('test_inscription'))
			$f = 'test_inscription';
		else 
			$f = 'test_inscription_dist';
		$declaration = $f($mode, $mail, $nom, $id);
		if (is_string($declaration))
			$erreurs['mail_inscription'] = $declaration;
		else {
			include_spip('base/abstract_sql');
			
			if ($row = sql_fetsel("statut, id_auteur, login, email", "spip_auteurs", "email=" . sql_quote($declaration['email']))){
				if (($row['statut'] == '5poubelle') AND !$declaration['pass'])
					// irrecuperable
					$erreurs['message_erreur'] = _T('form_forum_access_refuse');	
				if (($row['statut'] != 'nouveau') AND !$declaration['pass'])
					// deja inscrit
					$erreurs['message_erreur'] = _T('form_forum_email_deja_enregistre');
				spip_log($row['id_auteur'] . " veut se resinscrire");
			}
		}
	}
	return $erreurs;
}

function formulaires_inscription_traiter_dist($mode, $focus, $id=0) {

	$nom = _request('nom_inscription');
	$mail = _request('mail_inscription');
	$inscri_ml_ok = _request('inscri_ml_ok');
	
	if (function_exists('test_inscription'))
		$f = 'test_inscription';
	else 	$f = 'test_inscription_dist';
	$desc = $f($mode, $mail, $nom, $id);

	if (is_array($desc)) {
		$mail = $desc['email'];
		include_spip('base/abstract_sql');
		$row = sql_fetsel("statut, id_auteur, login, email", "spip_auteurs", "email=" . sql_quote($mail));
		// s'il n'existe pas deja, creer les identifiants  
		$desc = $row ? $row : inscription_nouveau($desc);
	}
	if (is_array($desc)) {
	// generer le mot de passe (ou le refaire si compte inutilise)
		$desc['pass'] = creer_pass_pour_auteur($desc['id_auteur']);
		// charger de suite cette fonction, pour ses utilitaires
		$envoyer_mail = charger_fonction('envoyer_mail','inc');
		if (function_exists('envoyer_inscription'))
			$f = 'envoyer_inscription';
		else 	$f = 'envoyer_inscription_dist';
		list($sujet,$msg,$from,$head) = $f($desc, $nom, $mode, $id);
		if (!$envoyer_mail($mail, $sujet, $msg, $from, $head))
			$desc = _T('form_forum_probleme_mail');
	}

	//envoi inscription mailinglist
	if (is_array($desc)) {
	$envoyer_mail = charger_fonction('envoyer_mail','inc');
		if ($inscri_ml_ok == "oui") {
		if (function_exists(lire_config))  { 
		$inscri_ml_sujet = lire_config('caseacocher_ml/inscri_ml_sujet').$mail;
		$inscri_ml_mail = lire_config('caseacocher_ml/inscri_ml_mail');
		$from = $mail;
		spip_log('envoi mailing list dest'.$inscri_ml_mail.' ');
		spip_log('envoi mailing list subject'.$inscri_ml_sujet.' ');
		if (!$envoyer_mail($inscri_ml_mail, $inscri_ml_sujet, $inscri_ml_msg, $from, $head))
			$desc = _T('form_forum_probleme_mail');
			}
			}
	}
			
			
	return is_string($desc) ? $desc : _T('form_forum_identifiant_mail');
}

// fonction qu'on peut redefinir pour filtrer les adresses mail et les noms,
// et donner des infos supplementaires
// Std: controler que le nom (qui sert a calculer le login) est plausible
// et que l'adresse est valide (et on la normalise)
// Retour: une chaine message d'erreur 
// ou un tableau avec au minimum email, nom, mode (redac / forum)

// https://code.spip.net/@test_inscription_dist
function test_inscription_dist($mode, $mail, $nom, $id=0) {

	include_spip('inc/filtres');
	$nom = trim(corriger_caracteres($nom));
	if (!$nom || strlen($nom) > 64)
	    return _T('ecrire:info_login_trop_court');
	if (!$r = email_valide($mail)) return _T('info_email_invalide');
	return array('email' => $r, 'nom' => $nom, 'bio' => $mode);
}

// On enregistre le demandeur comme 'nouveau', en memorisant le statut final
// provisoirement dans le champ Bio, afin de ne pas visualiser les inactifs
// A sa premiere connexion il obtiendra son statut final (auth->activer())

// https://code.spip.net/@inscription_nouveau
function inscription_nouveau($desc)
{
	if (!isset($desc['login']))
		$desc['login'] = test_login($desc['nom'], $desc['email']);

	$desc['statut'] = 'nouveau';

	$n = sql_insertq('spip_auteurs', $desc);

	if (!$n) return _T('titre_probleme_technique');

	$desc['id_auteur'] = $n;

	return $desc;
}

// construction du mail envoyant les identifiants 
// fonction redefinissable qui doit retourner un tableau
// dont les elements seront les arguments de inc_envoyer_mail

// https://code.spip.net/@envoyer_inscription_dist
function envoyer_inscription_dist($desc, $nom, $mode, $id) {

	$nom_site_spip = nettoyer_titre_email($GLOBALS['meta']["nom_site"]);
	$adresse_site = $GLOBALS['meta']["adresse_site"];
	
	$message = _T('form_forum_message_auto')."\n\n"
	  . _T('form_forum_bonjour', array('nom'=>$nom))."\n\n"
	  . _T((($mode == 'forum')  ?
		'form_forum_voici1' :
		'form_forum_voici2'),
	       array('nom_site_spip' => $nom_site_spip,
		     'adresse_site' => $adresse_site . '/',
		     'adresse_login' => $adresse_site .'/'. _DIR_RESTREINT_ABS))
	  . "\n\n- "._T('form_forum_login')." " . $desc['login']
	  . "\n- ".  _T('form_forum_pass'). " " . $desc['pass'] . "\n\n";

	return array("[$nom_site_spip] "._T('form_forum_identifiants'),
		     $message);
}

// https://code.spip.net/@test_login
function test_login($nom, $mail) {
	include_spip('inc/charsets');
	$nom = strtolower(translitteration($nom));
	$login_base = preg_replace("/[^\w\d_]/", "_", $nom);

	// il faut eviter que le login soit vraiment trop court
	if (strlen($login_base) < 3) {
		$mail = strtolower(translitteration(preg_replace('/@.*/', '', $mail)));
		$login_base = preg_replace("/[^\w\d]/", "_", $nom);
	}
	if (strlen($login_base) < 3)
		$login_base = 'user';

	// eviter aussi qu'il soit trop long (essayer d'attraper le prenom)
	if (strlen($login_base) > 10) {
		$login_base = preg_replace("/^(.{4,}(_.{1,7})?)_.*/",
			'\1', $login_base);
		$login_base = substr($login_base, 0,13);
	}

	$login = $login_base;

	for ($i = 1; ; $i++) {
		if (!sql_countsel('spip_auteurs', "login='$login'"))
			return $login;
		$login = $login_base.$i;
	}
}

// https://code.spip.net/@creer_pass_pour_auteur
function creer_pass_pour_auteur($id_auteur) {
	include_spip('inc/acces');
	$pass = creer_pass_aleatoire(8, $id_auteur);
	$mdpass = md5($pass);
	$htpass = generer_htpass($pass);
	sql_updateq('spip_auteurs', array('pass'=>$mdpass, 'htpass'=>$htpass),"id_auteur = ".intval($id_auteur));
	ecrire_acces();
	
	return $pass;
}

?>
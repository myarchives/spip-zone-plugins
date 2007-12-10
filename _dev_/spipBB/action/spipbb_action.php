<?php
/*
+-------------------------------------------+
| GAFoSPIP v. 0.5 - 21/08/07 - spip 1.9.2
+-------------------------------------------+
| Gestion Alternative des Forums SPIP
+-------------------------------------------+
| Hugues AROUX - SCOTY @ koakidi.com
+-------------------------------------------+
| les actions !
+-------------------------------------------+
*/


if (!defined("_ECRIRE_INC_VERSION")) return;

# pour 192 ..
# h. --> 193 modif requete ;-) !
include_spip('inc/spipbb_util');

#
# action generique
#
function action_spipbb_action() {

	global $action, $arg, $hash, $id_auteur;
	include_spip('inc/securiser_action');
	if (!verifier_action_auteur("$action-$arg", $hash, $id_auteur)) {
		include_spip('inc/minipres');
		minipres(_T('info_acces_interdit'));
	}

	preg_match('/^(\w+)\W(.*)$/', $arg, $r);
	$var_nom = 'action_spipbb_action_' . $r[1];
	if (function_exists($var_nom)) {
		spip_log("$var_nom $r[2]");
		$var_nom($r[2]);
	}
	else {
		spip_log("action $action: $arg incompris");
	}
}


//
// lier le sujet au mot "annonce"
//
function action_spipbb_action_sujetannonce($arg) {
	global $redirect;
	global $id_mot_annonce, $mode;
	$arg = intval($arg); // id_sujet
	
	if ($mode=="annonce") {
		spip_query("INSERT INTO spip_mots_forum (id_mot,id_forum) VALUES ('$id_mot_annonce','$arg')");
	}
	elseif ($mode=="desannonce") {
		spip_query("DELETE FROM spip_mots_forum WHERE id_mot=$id_mot_annonce AND id_forum=$arg");
	}
	redirige_par_entete(rawurldecode($redirect));
}

#
# lier le forum au mot "annonce"
#
function action_spipbb_action_forumannonce($arg) {
	global $redirect;
	global $id_mot_annonce, $mode;
	$arg = intval($arg); // id_article
	
	if ($mode=="annonce") {
		spip_query("INSERT INTO spip_mots_articles (id_mot,id_article) VALUES ('$id_mot_annonce','$arg')");
	}
	elseif ($mode=="desannonce") {
		spip_query("DELETE FROM spip_mots_articles WHERE id_mot=$id_mot_annonce AND id_article=$arg");
	}
	redirige_par_entete(rawurldecode($redirect));
}


//
// traiter  fermer ou liberer article-forum
// faut-il faire apparaitre dans les logs (hash calculer action auteur) ?? ??

function action_spipbb_action_fermelibere($arg) {
	if(!function_exists('verif_article_ferme'))
		include_spip("inc/spipbb_presentation");
	
	global $redirect;
	global $mode, $id_mot_ferme;
	$arg = intval($arg); // id_article
	
	$id_auteur = $GLOBALS['auteur_session']['id_auteur'];
	$deja_ferme = verif_article_ferme($arg, $id_mot_ferme);
	$f_gafart = _DIR_SESSIONS."spipbbart_$arg-$id_auteur.lck";
	
	if($mode=="ferme" OR $deja_ferme=='')
		{ spip_query("INSERT INTO spip_mots_articles (id_mot,id_article) VALUES ('$id_mot_ferme','$arg')"); }
	if($mode=="maintenance")
		// pose le verrou de maintenance
		{ spip_touch($f_gafart); }
	
	
	if($mode=="libere")
		{ spip_query("DELETE FROM spip_mots_articles WHERE id_mot=$id_mot_ferme AND id_article=$arg"); }
	if($mode=="libere_maintenance")
		// effacer le verrou de maintenance
		{
		if(file_exists($f_gafart))
			unlink($f_gafart);
		}
	
	redirige_par_entete(rawurldecode($redirect));
}

// fermer liberer sujet
function action_spipbb_action_ferlibsujet($arg) {

	#include_spip("inc/spipbb_presentation");
	
	global $redirect;
	global $mode, $id_mot_ferme;
	$arg = intval($arg); // id_sujet
	
	if($mode=="ferme" OR $deja_ferme=='')
		{ spip_query("INSERT INTO spip_mots_forum (id_mot,id_forum) VALUES ('$id_mot_ferme','$arg')"); }
	
	if($mode=="libere")
		{ spip_query("DELETE FROM spip_mots_forum WHERE id_mot=$id_mot_ferme AND id_forum=$arg"); }
	
	redirige_par_entete(rawurldecode($redirect));
}
?>

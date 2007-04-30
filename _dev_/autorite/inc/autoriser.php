<?php

// Ceci est une surcharge de inc/autoriser.php

if (!defined("_ECRIRE_INC_VERSION")) return;


define ('_DEBUG_AUTORISER', false);

$GLOBALS['autorite'] = @unserialize($GLOBALS['meta']['autorite']);

// Si des surcharges d'autorisation ont ete selectionnees,
// on utilise la surcharge de autoriser() pour appeler autoriser_super()
// http://doc.spip.org/@autoriser
if (is_array($GLOBALS['autorite'])
AND count($GLOBALS['autorite'])
AND !function_exists('autoriser')) {
// http://doc.spip.org/@autoriser
	function autoriser() {
		$args = func_get_args(); 
		return call_user_func_array('autoriser_super', $args);
	}
}

// Charger les versions *_dist des fonctions
include _DIR_RESTREINT.'inc/autoriser.php';

// Dire aux crayons si les visiteurs ont des droits
if (!function_exists('analyse_droits_rapide')) {
function analyse_droits_rapide() {
	return false;
}
}



//
// Surcharger les autorisations qui doivent l'etre
//

##
## autoriser_article_modifier
##
if ($GLOBALS['autorite']['auteur_mod_article']
OR false // autre possibilite de surcharge ?
) {
function autoriser_article_modifier_super($faire, $type, $id, $qui, $opt) {
	$s = spip_query(
	"SELECT id_rubrique,statut FROM spip_articles WHERE id_article="._q($id));
	$r = spip_fetch_array($s);
	include_spip('inc/auth');
	return
		autoriser('publierdans', 'rubrique', $r['id_rubrique'], $qui, $opt)
		OR (
			in_array($qui['statut'], array('0minirezo', '1comite'))
/*
			# on commente cette ligne : tous les articles sont modifiables
			AND in_array($r['statut'], array('prop','prepa', 'poubelle'))
*/			AND spip_num_rows(auteurs_article($id, "id_auteur=".$qui['id_auteur']))
		);
}
}


##
## autoriser_auteur_modifier
##
if ($GLOBALS['autorite']['auteur_mod_email']
OR false // autre possibilite de surcharge ?
) {
function autoriser_auteur_modifier_super($faire, $type, $id, $qui, $opt) {
	if ($GLOBALS['autorite']['auteur_mod_email']) {
		unset($opt['email']);
	}
	return autoriser_auteur_modifier_dist($faire, $type, $id, $qui, $opt);
}
}


##
## autoriser_forum_article_moderer
##
if ($GLOBALS['autorite']['auteur_modere_forum']
OR false // autre possibilite de surcharge ?
) {
function autoriser_modererforum_super($faire, $type, $id, $qui, $opt) {
	return
		autoriser('modifier', $type, $id, $qui, $opt)
		OR (
			$GLOBALS['autorite']['auteur_modere_forum']
			AND $type == 'article'
			AND in_array($qui['statut'], array('0minirezo', '1comite'))
			AND spip_num_rows(auteurs_article($id, "id_auteur=".$qui['id_auteur']))
		);
}
}



//
// Forker la fonction autoriser de maniere a ce qu'elle
// appelle autoriser_x_y_super() de preference a autoriser_x_y_dist()
//
function autoriser_super($faire, $type='', $id=0, $qui = NULL, $opt = NULL) {
	static $restreint = array();

	// Qui ? auteur_session ?
	if ($qui === NULL)
		$qui = $GLOBALS['auteur_session']; // "" si pas connecte
	elseif (is_int($qui)) {
		$qui = spip_fetch_array(spip_query(
		"SELECT * FROM spip_auteurs WHERE id_auteur=$qui"));
	}

	// Admins restreints, les verifier ici (pas generique mais...)
	// Par convention $restreint est un array des rubriques autorisees
	// (y compris leurs sous-rubriques), ou 0 si admin complet
	if (is_array($qui)
	AND $qui['statut'] == '0minirezo'
	AND !isset($qui['restreint'])) {
		if (!isset($restreint[$qui['id_auteur']])) {
			include_spip('inc/auth'); # pour auth_rubrique
			$restreint[$qui['id_auteur']] = auth_rubrique($qui['id_auteur'], $qui['statut']);
		}
		$qui['restreint'] = $restreint[$qui['id_auteur']];
	}
	if (_DEBUG_AUTORISER) spip_log("autoriser $faire $type $id ($qui[nom]) ?");

	// Chercher une fonction d'autorisation explicite
	if (
	// 1. Sous la forme "autoriser_type_faire"
		(
		$type
		AND $f = 'autoriser_'.$type.'_'.$faire
		AND (function_exists($f) OR function_exists($f=($f2=$f).'_super') OR function_exists($f=$f2.'_dist'))
		)

	// 2. Sous la forme "autoriser_type"
	// ne pas tester si $type est vide
	OR (
		$type
		AND $f = 'autoriser_'.$type
		AND (function_exists($f) OR function_exists($f=($f2=$f).'_super') OR function_exists($f=$f2.'_dist'))
	)

	// 3. Sous la forme "autoriser_faire"
	OR (
		$f = 'autoriser_'.$faire
		AND (function_exists($f) OR function_exists($f=($f2=$f).'_super') OR function_exists($f=$f2.'_dist'))
	)

	// 4. Sinon autorisation generique
	OR (
		$f = 'autoriser_defaut'
		AND (function_exists($f) OR function_exists($f=($f2=$f).'_super') OR function_exists($f=$f2.'_dist'))
	)

	)
		$a = $f($faire,$type,intval($id),$qui,$opt);

	if (_DEBUG_AUTORISER) spip_log("$f($faire,$type,$id,$qui[nom]): ".($a?'OK':'niet'));

	return $a;
}



?>

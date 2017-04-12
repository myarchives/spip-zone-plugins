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

// Cette fonction est systematiquement appelee par les squelettes
// pour constuire une requete SQL de type "lecture" (SELECT) a partir
// de chaque boucle.
// Elle construit et exe'cute une reque^te SQL correspondant a` une balise
// Boucle ; elle notifie une erreur SQL dans le flux de sortie et termine
// le processus.
// Sinon, retourne la ressource interrogeable par spip_abstract_fetch.
// Recoit en argument:
// - le tableau des champs a` ramener (Select)
// - le tableau des tables a` consulter (From)
// - le tableau des conditions a` remplir (Where)
// - le crite`re de regroupement (Group by)
// - le tableau de classement (Order By)
// - le crite`re de limite (Limit)
// - une sous-requete e'ventuelle (inutilisee pour le moment. MySQL > 4.1)
// - le tableau des des post-conditions a remplir (Having)
// - le nom de la table (pour le message d'erreur e'ventuel)
// - le nom de la boucle (pour le message d'erreur e'ventuel)
// - le serveur sollicite (pour retrouver la connexion)


// http://code.spip.net/@spip_mysql_showtable
function spip_abstract_mysql_showtable($nom_table)
{
	$a = spip_query("SHOW TABLES LIKE '$nom_table'");
	if (!$a) return "";
	if (!spip_fetch_array($a)) return "";
	list(,$a) = spip_fetch_array(spip_query("SHOW CREATE TABLE $nom_table"),SPIP_NUM);
	if (!preg_match("/^[^(),]*\((([^()]*\([^()]*\)[^()]*)*)\)[^()]*$/", $a, $r))
		return "";
	else {
		$dec = $r[1];
		if (preg_match("/^(.*?),([^,]*KEY.*)$/s", $dec, $r)) {
			$namedkeys = $r[2];
			$dec = $r[1];
		}
		else 
			$namedkeys = "";

		$fields = array();
		foreach(preg_split("/,\s*`/",$dec) as $v) {
			preg_match("/^\s*`?([^`]*)`\s*(.*)/",$v,$r);
			$fields[strtolower($r[1])] = $r[2];
		}
		$keys = array();

		foreach(preg_split('/\)\s*,?/',$namedkeys) as $v) {
			if (preg_match("/^\s*([^(]*)\((.*)$/",$v,$r)) {
				$k = str_replace("`", '', trim($r[1]));
				$t = strtolower(str_replace("`", '', $r[2]));
				if ($k && !isset($keys[$k])) $keys[$k] = $t; else $keys[] = $t;
			}
		}
		return array('field' => $fields,	'key' => $keys);
	}
}


// http://code.spip.net/@spip_abstract_select
function spip_abstract_select (
	$select = array(), $from = array(), $where = array(),
	$groupby = '', $orderby = array(), $limit = '',
	$sousrequete = '', $having = array(),
	$table = '', $id = '', $serveur='') {

	if (!$serveur)
	  // le serveur par defaut est celui defini dans inc_connect.php
	  { spip_connect();
	    $f = 'spip_mysql_select';
	  }
	else {
	  // c'est un autre; le charger si ce n'est fait
		$f = spip_abstract_serveur('select', $serveur);
	}
	return $f($select, $from, $where,
		  $groupby, $orderby, $limit,
		  $sousrequete, $having,
		  $table, $id, $serveur);
}

// Chargement a la volee de la description d'un serveur de base de donnees

// http://code.spip.net/@spip_abstract_serveur
function spip_abstract_serveur($ins_sql, $serveur) {
	$f = 'spip_' . $serveur . '_' . $ins_sql;
	if (function_exists($f)) return $f;

	$d = find_in_path('inc_connect-' . $serveur . '.php');
	if (@file_exists($d))
		include($d);
	else spip_log("pas de fichier $d pour decrire le serveur '$serveur'");

	if (function_exists($f)) return $f;

	erreur_squelette(" $f " ._T('zbug_serveur_indefini'), $serveur);

	// hack pour continuer la chasse aux erreurs
	return 'spip_log';
}

// http://code.spip.net/@spip_abstract_fetch
function spip_abstract_fetch($res, $serveur='') {
	if (!$serveur) return spip_fetch_array($res, SPIP_ASSOC);
	$f = spip_abstract_serveur('fetch', $serveur);
	return $f($res);
}

// http://code.spip.net/@spip_abstract_count
function spip_abstract_count($res, $serveur='')
{
  if (!$serveur) return spip_num_rows($res);
  $f = spip_abstract_serveur('count', $serveur);
  return $f($res);
}

// http://code.spip.net/@spip_abstract_free
function spip_abstract_free($res, $serveur='')
{
  if (!$serveur) return spip_free_result($res);
  $f = spip_abstract_serveur('free', $serveur);
  return $f($res);
}

// http://code.spip.net/@spip_abstract_insert
function spip_abstract_insert($table, $noms, $valeurs, $serveur='')
{
  $f = (!$serveur ? 'spip_mysql_insert' :
	spip_abstract_serveur('insert', $serveur));
  return $f($table, $noms, $valeurs);
}

// http://code.spip.net/@spip_abstract_showtable
function spip_abstract_showtable($table, $serveur='', $table_spip = false)
{
/*
echo "<p>ecrire base $table" ;
echo "<p>ecrire base $serveur" ;
echo "<p>ecrire base $table_spip" ;
*/
	if ($table_spip){
		if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix']."_";
		else $table_pref = "";
		$table = preg_replace('/^spip_/', $table_pref, $table);
	}
// echo "<p>ici" ;	
  $f = (!$serveur ? 'spip_abstract_mysql_showtable' :
	spip_abstract_serveur('showtable', $serveur));
  return $f($table);
}

# une composition tellement frequente...
// http://code.spip.net/@spip_abstract_fetsel
function spip_abstract_fetsel(
	$select = array(), $from = array(), $where = array(),
	$groupby = '', $orderby = array(), $limit = '',
	$sousrequete = '', $having = array(),
	$table = '', $id = '', $serveur='') {
	return spip_abstract_fetch(spip_abstract_select(
$select, $from, $where,	$groupby, $orderby, $limit,
$sousrequete, $having, $table, $id, $serveur),
				   $serveur);
}


//
// IN (...) est limite a 255 elements, d'ou cette fonction assistante
//
// http://code.spip.net/@calcul_mysql_in
function calcul_mysql_in($val, $valeurs, $not='') {
	if (!strlen(trim($valeurs))) return ($not ? "0=0" : '0=1');

	$n = $i = 0;
	$in_sql ="";
	while ($n = strpos($valeurs, ',', $n+1)) {
	  if ((++$i) >= 255) {
			$in_sql .= "($val $not IN (" .
			  substr($valeurs, 0, $n) .
			  "))\n" .
			  ($not ? "AND\t" : "OR\t");
			$valeurs = substr($valeurs, $n+1);
			$i = $n = 0;
		}
	}
	$in_sql .= "($val $not IN ($valeurs))";

	return "($in_sql)";
}
?>

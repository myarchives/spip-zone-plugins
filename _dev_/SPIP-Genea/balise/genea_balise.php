<?php

/*******************************************************************
 *
 * Copyright (c) 2007-2008
 * Xavier BUROT
 * fichier : balise/genea_balise
 *
 * Ce programme est un logiciel libre distribue sous licence GNU/GPL
 *
 * *******************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('base/genea_base');
include_spip('base/create');
include_spip('inc/filtres');

//
// GESTION DES DATES
//

// -- Recupere et verif le droit a l'affichage des dates ----------
function genea_date_evt($id_individu, $type_evt, $fin=false, $second=false){
	$date_evt='';
	if ($id_individu) {
		$q="SELECT ";
		if ($fin==false) {
			if (($second==false)) $q.="date_debut";
			else $q.="date_debut2";
		}else{
			if (($second==false)) $q.="date_fin";
			else $q.="date_fin2";
		}
		$q.=" FROM ".$table_prefix."_genea_evt WHERE (id_individu=$id_individu) AND (type_evt='$type_evt')";
		$res=spip_query($q);
		if ($row=spip_fetch_array($res)) {
			if ($fin==false) {
				if (($second==false)) $date_evt=$row['date_debut'];
				else $date_evt=$row['date_debut2'];
			}else{
				if (($second==false)) $date_evt=$row['date_fin'];
				else $date_evt=$row['date_fin2'];
			}
		}
	}
	// Faire verification des droits de visualisation des dates
	// si elles sont inferieures a 100 ans. Ne pas afficher, sauf
	// pour les redacteurs et les administrateurs autorises.

	// Transformer au format Date
	$annee = intval(substr($date_evt, 0, 4));
	$mois = intval(substr($date_evt, 3, 2));
	$jour = intval(substr($date_evt, 5, 2));
	$heure = intval(substr($date_evt, 7,2));
	$minute = intval(substr($date_evt, 9,2));
	$date_ret = mktime($heure, $minute, 0, $mois, $jour, $annee);
	return $date_ret;
}

// -- Affiche la date de deces  -----------------------------------
function balise_DATE_DECES($p){
	$p->code = "genea_date_evt(".champ_sql('id_individu',$p).", 'deat')";
	$p->interdire_scripts = true;
	return $p;
}

// -- Affiche la date de naissance --------------------------------
function balise_DATE_NAISSANCE($p){
	$p->code = "genea_date_evt(".champ_sql('id_individu',$p).", 'birt')";
	$p->interdire_scripts = true;
	return $p;
}

// -- Affiche le sexe de l'individu -------------------------------
function balise_SEXE($p){
	$p->code = "gtraduc(".champ_sql('sexe', $p).")";
	$p->interdire_scripts = true;
	return $p;
}

// -- Recherche le numero SOSA d'un invidu ------------------------
function trouve_sosa($id_individu){
	global $table_prefix;
	$sosa='';
	if($id_individu){
		$q = "SELECT id_sosa FROM ".$table_prefix."_genea_sosa WHERE id_individu=$id_individu";
		$res = spip_query($q);
		if ($row = spip_fetch_array($res)) $sosa = $row['id_sosa'];
	}
	return $sosa;
}

// -- Affiche le numero SOSA d'un individu ------------------------
function balise_SOSA($p){
	$p->code = "trouve_sosa(".champ_sql.('id_individu', $p).")";
	$p->interdire_scripts = true;
	return $p;
}
?>
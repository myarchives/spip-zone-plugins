<?php
/**
 * Plugin Spip 2.0 Reloaded
 * Ce que vous ne trouverez pas dans Spip 2.0
 * (c) 2008 Matthieu Marcillaud
 * Licence GPL
 * 
 */

/**
 * #SET
 * Affecte une variable locale au squelette
 * #SET{nom,valeur}
 * 
 * SURCHARGE DU CORE : 
 * 		Affecte un filtre a une variable locale au squelette
 * 		#SET{nom,filtre,param1,param2,...,paramN}
 *
 * @param object $p : objet balise
 * @return ""
**/
/*
function balise_SET($p){
	$_code = array();	
	
	$n=1;
	while ($_v = interprete_argument_balise($n++,$p))
		$_code[] = $_v;

	$_nom = array_shift($_code);
	$_valeur = array_shift($_code);
	if ($_nom AND $_valeur AND count($_code)) {
		$filtre = str_replace("'", "", strtolower($_valeur));
		$f = chercher_filtre($filtre);
		$p->code = "vide(\$Pile['vars'][$_nom]=$f(". join(', ',$_code)."))";
	} elseif ($_nom AND $_valeur)
		$p->code = "vide(\$Pile['vars'][$_nom] = $_valeur)";
	else
		$p->code = "''";

	$p->interdire_scripts = false; // la balise ne renvoie rien
	return $p;
}
*/


/**
 * Empile un element dans un tableau declare par #SET{tableau,#ARRAY}
 * #SET_PUSH{tableau,valeur}
 *
 * @param object $p : objet balise
 * @return ""
**/
function balise_SET_PUSH_dist($p){
	$_nom = interprete_argument_balise(1,$p);
	$_valeur = interprete_argument_balise(2,$p);

	if ($_nom AND $_valeur)
		// si le tableau n'existe pas encore, on le cree
		// on ajoute la valeur ensuite (sans passer par array_push)
		$p->code = "vide((\$cle=$_nom) 
			. (is_array(\$Pile['vars'][\$cle])?'':\$Pile['vars'][\$cle]=array())
			. (\$Pile['vars'][\$cle][]=$_valeur))";
	else
		$p->code = "''";

	$p->interdire_scripts = false; // la balise ne renvoie rien
	return $p;
}

/**
 * Si 3 arguments : Cree un tableau nom_tableau de t1 + t2
 * #SET_MERGE{nom_tableau,t1,t2}
 * #SET_MERGE{nom_tableau,#GET{tableau},#ARRAY{cle,valeur}}
 * 
 * Si 2 arguments : Merge t1 dans nom_tableau
 * #SET_MERGE{nom_tableau,t1}
 * #SET_MERGE{nom_tableau,#GET{tableau}}
 * 
 * @param object $p : objet balise
 * @return ""
**/
function balise_SET_MERGE_dist($p){
	$_nom = interprete_argument_balise(1,$p);
	$_t1 = interprete_argument_balise(2,$p);
	$_t2 = interprete_argument_balise(3,$p);

	if ($_nom AND $_t1 AND !$_t2)
		// 2 arguments : merge de $_nom et $_t1 dans $_nom
		// si le tableau n'existe pas encore, on le cree
		$p->code = "vide((\$cle=$_nom) 
			. (is_array(\$Pile['vars'][\$cle])?'':\$Pile['vars'][\$cle]=array())
			. (is_array(\$new=$_t1)?'':\$new=array(\$new))
			. (\$Pile['vars'][\$cle] = array_merge(\$Pile['vars'][\$cle],\$new)))";
	elseif ($_nom AND $_t1 AND $_t2)
		// 3 arguments : merge de $_t1 et $_t2 dans $_nom
		// si le tableau n'existe pas encore, on le cree
		$p->code = "vide((\$cle=$_nom) 
			. (is_array(\$Pile['vars'][\$cle])?'':\$Pile['vars'][\$cle]=array())
			. (is_array(\$new1=$_t1)?'':\$new1=array(\$new1))
			. (is_array(\$new2=$_t2)?'':\$new2=array(\$new2))
			. (\$Pile['vars'][\$cle] = array_merge(\$new1,\$new2)))";	
	else
		$p->code = "''";

	$p->interdire_scripts = false; // la balise ne renvoie rien
	return $p;
}

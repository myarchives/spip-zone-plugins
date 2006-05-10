<?php

/** BOUCLE TABLEAU
 * Christian Lefebvre, Oct. 2005
 * Distribué sous licence GPL 2
 *
 * on accepte les critères {var=...} pour aller chercher le contenu d'une
 * variable globale, {fonction=...} pour appeler une fonction ou {valeur} pour
 * utiliser la valeur d'une boucle tableau englobante.
 */

$tableau = array(
	"var" => "varchar(100)",
	"fonction" => "varchar(100)",
	"cle" => "varchar(100)",
	"valeur" => "varchar(100)"
);
$tableau_key = array(
	"PRIMARY KEY"	=> "cle"
);

$GLOBALS['tables_principales']['spip_tableau'] =
	array('field' => &$tableau, 'key' => &$tableau_key);
$GLOBALS['table_des_tables']['tableau'] = 'tableau';

$GLOBALS['tables_principales']['spip_affecter'] =
	array('field' => &$tableau, 'key' => array());
$GLOBALS['table_des_tables']['affecter'] = 'affecter';

// A REMPLACER PAR CA ?
// $GLOBALS['tables_des_serveurs_sql']['']['tableau'] =
// 	array('field' => &$tableau, 'key' => &$tableau_key);
// $GLOBALS['tables_des_serveurs_sql']['']['affecter'] =
// 	array('field' => $tableau, 'key' => $tableau_key);
// MAIS POURQUOI CA MARCHE PAS ?

function boucle_TABLEAU($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];

	if (count($boucle->separateur))
	  $code_sep= ("'" . ereg_replace("'","\'",join('',$boucle->separateur))
				  . "'");
	else
	  $code_sep="''";

	$var=null; $cle='';

	foreach($boucle->criteres as $critere) {
	  if($critere->op=='valeur') {
		$var= '$Pile[$SP][\'valeur\']';
	  } elseif($critere->op=='=' && $critere->param[0][0]->texte=='var') {
		$var= '$GLOBALS['.calculer_liste($critere->param[1],
			array(), $boucles, $boucle->id_parent).']';
	  } elseif($critere->op=='=' && $critere->param[0][0]->texte=='fonction') {
		$var= calculer_liste($critere->param[1],
			array(), $boucles, $boucle->id_parent);
	  } elseif($critere->op=='=' && $critere->param[0][0]->texte=='cle') {
		$cle.= '['.calculer_liste($critere->param[1],
			array(), $boucles, $boucle->id_parent).']';
	  }
	}

	if($var===null) {
	  erreur_squelette("pas de variable sélectionnée",
					   $boucle->id_boucle);
	  return;
	}

	$code=<<<CODE
	\$__t= ${var}$cle;
	\$SP++;
	if(empty(\$__t)) { return ''; }
	\$code=array();
	\$Pile[\$SP]['var']=&\$__t;
	\$i= 1;
	foreach(\$__t as \$k => \$v) {
		\$Numrows['$id_boucle']['compteur_boucle']=\$i++;
		\$Pile[\$SP]['cle']=\$k;
		\$Pile[\$SP]['valeur']=\$v;
		\$code[]=$boucle->return;
	}
	\$t0= join($code_sep, \$code);
	return \$t0;
CODE;

	return $code;
}

function boucle_AFFECTER($id_boucle, &$boucles) {
	$boucle = &$boucles[$id_boucle];

	if (count($boucle->separateur))
	  $code_sep= ("'" . ereg_replace("'","\'",join('',$boucle->separateur))
				  . "'");
	else
	  $code_sep="''";

	$var=null; $cle='';

	foreach($boucle->criteres as $critere) {
	  if($critere->op=='=' && $critere->param[0][0]->texte=='var') {
		$var= '$GLOBALS['.calculer_liste($critere->param[1],
			array(), $boucles, $boucle->id_parent).']';
	  } elseif($critere->op=='=' && $critere->param[0][0]->texte=='cle') {
		$cle.= '['.calculer_liste($critere->param[1],
			array(), $boucles, $boucle->id_parent).']';
	  }
	}

	if($var===null) {
	  erreur_squelette("pas de variable sélectionnée",
					   $boucle->id_boucle);
	  return;
	}

	$code=<<<CODE
	\$__t= &${var}$cle;
	\$SP++;
	\$__t[]=$boucle->return;
	return '';
CODE;

	return $code;
}

function balise_TABLEAU($p) {
	$var=null; $cle='';

	if ($p->param && !$p->param[0][0]) {
		$var=  calculer_liste($p->param[0][1],
			 $p->descr, $p->boucles, $p->id_boucle);

		// les cles
		array_shift($p->param[0]);
		array_shift($p->param[0]);
		foreach($p->param[0] as $pp) {
			$cle.= '['.calculer_liste($pp,
				$p->descr, $p->boucles, $p->id_boucle).']';
		}
		array_shift($p->param);
	} else {
	  erreur_squelette("pas de variable sélectionnée dans balise TABLEAU",
					   $boucle->id_boucle);
	  return;
	}
	$p->code = "(\$GLOBALS[$var]$cle)";
	$p->interdire_scripts = false;
	return $p;
}

function balise_AFFECTER($p) {
	$var=null; $cle='';

	if ($p->param && !$p->param[0][0]) {
		$var=  calculer_liste($p->param[0][1],
			 $p->descr, $p->boucles, $p->id_boucle);

		// les cles
		array_shift($p->param[0]);
		array_shift($p->param[0]);
		foreach($p->param[0] as $pp) {
			$cle.= '['.calculer_liste($pp,
				$p->descr, $p->boucles, $p->id_boucle).']';
		}
		array_shift($p->param);
	} else {
	  erreur_squelette("pas de variable sélectionnée dans balise AFFECTER",
					   $boucle->id_boucle);
	  return;
	}
	$p->code = "((\$GLOBALS[$var]$cle="
		.calculer_liste($p->avant, $p->descr, $p->boucles, $p->id_boucle).'.'
		.calculer_liste($p->apres, $p->descr, $p->boucles, $p->id_boucle).")?'':'')";
	$p->interdire_scripts = false;
	return $p;
}

function champ($tableau, $champ) {
  return ($tableau[$champ])?$tableau[$champ]:'';
}

function toto() {
  return array('aze', 'qsd', 'wxc');
}

?>

<?php

function http_calendrier_mini_agenda ($annee, $mois, $jour_ved, $mois_ved, $annee_ved, $semaine = false,  $script='', $ancre='', $evt=''){
	include_spip('inc/agenda');
	return http_calendrier_agenda ($annee, $mois, $jour_ved, $mois_ved, $annee_ved, $semaine, $script, $ancre, $evt);
}

function balise_OBJ($p) {
	if ($p->param && !$p->param[0][0]) {
		$php = array_shift( $p->param );
		array_shift($php);
		$obj = calculer_liste($php[0],
					$p->descr,
					$p->boucles,
					$p->id_boucle);
	}
	
	if($obj) {
		$p->code = $obj;
		if(count($php)>1) $p->code.='->'.$php[1][0]->texte;
	}
	
	return $p;
}

//
// #URL_ACTION{logout} -> ecrire/?action=naviguer
//
function balise_URL_ACTION($p) {

	if ($p->param && !$p->param[0][0]) {
		$p->code =  calculer_liste($p->param[0][1],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		$args =  calculer_liste($p->param[0][2],
					$p->descr,
					$p->boucles,
					$p->id_boucle);

		if ($args != "''")
			$p->code .= ','.$args;

		// autres filtres (???)
		array_shift($p->param);
	}

	$p->code = 'generer_url_action(' . $p->code .')';

	#$p->interdire_scripts = true;
	return $p;
}

//
// Get the next available accesskey
// Cannot manage accesskey on ajax fragments
//
function balise_GET_ACCESSKEY($p) {
	global $accesskey;
	if(!$accesskey) $accesskey = 97;
	$key = $accesskey<=122?chr($accesskey):'';
	$p->code = "'$key'";
	return $p;
}

//
// #INSERT_HEAD_PRIVE
// pour permettre aux plugins d'inserer des styles, js ou autre
// dans l'entete sans modification du squelette prive
// #INSERT_HEAD_PRIVE
//
// http://code.spip.net/@balise_INSERT_HEAD_dist
function balise_INSERT_HEAD_PRIVE($p) {
	$p->code = "pipeline('header_prive',recuperer_fond('modeles/init_entete',array()))";
	$p->interdire_scripts = false;
	return $p;
}

?>

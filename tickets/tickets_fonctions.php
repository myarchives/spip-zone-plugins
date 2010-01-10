<?php

// Creation de la liste des options du select des champ jalon, version, projet ou composant
function tickets_select_champ_optionnel($champ='', $en_cours){
	if (!$liste = tickets_champ_optionnel_actif($champ)) {
		return null;
	}

	$options = '';
	foreach ($liste as $_item) {
		if ($_item != '') {
			$selected = ($_item == $en_cours) ? ' selected="selected"' : '';
			$options .= '<option value="' . $_item . '"' . $selected . '>' . $_item . '</option>';
		}
	}
	return $options;
}

// retourne false si pas de champ defini
// sinon retourne un tableau des elements du champ
function tickets_champ_optionnel_actif($nom){
	$nom = '_TICKETS_LISTE_' . strtoupper($nom);
	if (!defined($nom)) {
		return false;
	}
	$liste = constant($nom);
	if ($liste == '') return false;

	return explode(':', $liste);
}


// Creation de la liste des options du select d'assignation
function tickets_select_assignation($en_cours){
	$options = NULL;

	include_spip('inc/tickets_autoriser');
	$select = array('nom','id_auteur');
	$from = array('spip_auteurs AS t1');
	$autorises = definir_autorisations_tickets('assigner');
	if ($autorises['statut'])
		$where = array(sql_in('t1.statut', $autorises['statut']), 't1.email LIKE '.sql_quote('%@%'));
	else
		$where = array(sql_in('t1.id_auteur', $autorises['auteur']), 't1.email LIKE '.sql_quote('%@%'));
	$query_auteurs = sql_select($select, $from, $where);
	while ($row_auteur = sql_fetch($query_auteurs)) {
		$selected = ($row_auteur["id_auteur"] == $en_cours) ? ' selected="selected"' : '';
		$options .= '<option value="' . $row_auteur["id_auteur"] . '"' . $selected . '>' . $row_auteur["nom"] . '</option>';

	}

	return $options;
}

// Affichage de la page des tickets classes par jalon
function tickets_classer_par_jalon($bidon) {
	$page = NULL;
	if (defined('_TICKETS_LISTE_JALONS')) {
		$liste = explode(":", _TICKETS_LISTE_JALONS);
		$i = 0;
		foreach($liste as $_jalon) {
			$i += 1;
			$page .= recuperer_fond('prive/contenu/inc_liste_detaillee',
				array_merge($_GET, array('titre' => _T('tickets:champ_jalon').' '.$_jalon, 'statut' => 'ouvert', 'jalon' => $_jalon, 'bloc' => "_bloc$i")),
				array('ajax'=>true));
		}
	}
	return $page;
}

// Affichage des blocs de liste depliables et ajaxes
function tickets_debut_block_depliable($deplie,$id=""){
	include_spip('inc/layer');
	return debut_block_depliable($deplie,$id);
}
function tickets_fin_block() {
	include_spip('inc/layer');
	return fin_block();
}
function tickets_bouton_block_depliable($texte,$deplie,$page="",$ids=""){
	include_spip('inc/layer');
	if ($page)
		return bouton_block_depliable(afficher_plus(generer_url_ecrire($page)).$texte,$deplie,$ids);
	else
		return bouton_block_depliable($texte,$deplie,$ids);
	
}

// creation des fonction de selection de texte
// encore en truc a reprendre !
foreach (array('severite', 'type', 'statut') as $nom){
	eval("function tickets_texte_$nom(\$niveau) {
		\$type = tickets_liste_$nom();
		if (isset(\$type[\$niveau])) {
			return \$type[\$niveau];
		}
	}");
}

function tickets_icone_statut ($niveau) {
	if ($niveau == "redac") $img = "puce-blanche.gif";
	else if ($niveau == "ouvert") $img = "puce-orange.gif";
	else if ($niveau == "resolu") $img = "puce-verte.gif";
	else if ($niveau == "ferme")  $img = "puce-poubelle.gif";

	return $img;
}
function tickets_icone_severite ($niveau) {
	if ($niveau == 1) $img = "puce-rouge-breve.gif";
	else if ($niveau == 2) $img = "puce-orange-breve.gif";
	else if ($niveau == 3) $img = "puce-verte-breve.gif";
	else if ($niveau == 4) $img = "puce-poubelle-breve.gif";

	return $img;
}

function tickets_liste_statut($connecte = true){
	$statuts = array(
		"redac" => _T("tickets:statut_redac"),
		"ouvert" => _T("tickets:statut_ouvert"),
		"resolu" => _T("tickets:statut_resolu"),
		"ferme" => _T("tickets:statut_ferme"),
	);
	if (!$connecte) {
		unset($statuts['redac']);
	}
	return $statuts;
}


function tickets_liste_type($id_ticket = null){
	$types = array(
		1 => _T("tickets:type_probleme"),
		2 => _T("tickets:type_amelioration"),
		3 => _T("tickets:type_tache"),
	);
	return $types;
}

function tickets_liste_severite($id_ticket = null){
	$severites = array(
		1 => _T("tickets:severite_bloquant"),
		2 => _T("tickets:severite_important"),
		3 => _T("tickets:severite_normal"),
		4 => _T("tickets:severite_peu_important"),
	);
	return $severites;
}

if(!function_exists('barre_typo')){
	function barre_typo(){
		return;
	}
}
?>

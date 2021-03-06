<?php 

if (!defined("_ECRIRE_INC_VERSION")) return;

// critere {contenu_auteur_select} , cf. sedna
function critere_contenu_auteur_select_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];

	if (isset($crit->param[0][0])
	AND $crit->param[0][0]->texte == 'strict')
		$debut = '';
	else
		$debut = '%';

	// un peu trop rapide, ca... le compilateur exige mieux (??)
	$boucle->hash = '
	// RECHERCHE
	if ($r = _request("q")) {
		$r = _q("'.$debut.'$r%");
		$s = "(
			auteurs.nom LIKE $r
			OR auteurs.email LIKE $r'

	// on ne cherche pas dans la bio etc
	// si on peut trouver direct dans le nom ou l'email
	. (!$debut
		? ''
		: '
			OR auteurs.bio LIKE $r
			OR auteurs.nom_site LIKE $r
			OR auteurs.url_site LIKE $r
		')
	.'
		)";
	} else {
		$s = 1;
	}
	';
	$boucle->where[] = '$s';
}

// Un filtre pour afficher le bonhomme_statut
function icone_statut_auteur($statut) {
	include_spip('inc/presentation');
	$text = bonhomme_statut(array('statut'=>$statut));
	return replace($text,'\n','');
}
?>
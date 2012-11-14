<?php
/**
 * Plugin SpipAd - 2roues
 * (c) 2012 Collectif SPIP - Montpellier
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;



/**
 * Ajout de contenu sur certaines pages,
 * notamment des formulaires de liaisons entre objets
 */
function ad_deux_roues_affiche_milieu($flux) {
	$texte = "";
	$e = trouver_objet_exec($flux['args']['exec']);

	// auteurs sur les ad_deux_roues
	if (!$e['edition'] AND in_array($e['type'], array('ad_deux_roue'))) {
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'auteurs',
			'objet' => $e['type'],
			'id_objet' => $flux['args'][$e['id_table_objet']]
		));
	}



	if ($texte) {
		if ($p=strpos($flux['data'],"<!--affiche_milieu-->"))
			$flux['data'] = substr_replace($flux['data'],$texte,$p,0);
		else
			$flux['data'] .= $texte;
	}

	return $flux;
}


/**
 * Ajout de liste sur la vue d'un auteur
 */
function ad_deux_roues_affiche_auteurs_interventions($flux) {
	if ($id_auteur = intval($flux['args']['id_auteur'])) {

		$flux['data'] .= recuperer_fond('prive/objets/liste/ad_deux_roues', array(
			'id_auteur' => $id_auteur,
			'titre' => _T('ad_deux_roue:info_ad_deux_roues_auteur')
		), array('ajax' => true));

	}
	return $flux;
}


?>
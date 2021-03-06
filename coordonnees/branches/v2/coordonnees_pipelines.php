<?php
/**
 * Pipelines du plugin Coordonnees
 *
 * @plugin     Coordonnees
 * @copyright  2013
 * @author     Marcimat / Ateliers CYM
 * @licence    GNU/GPL
 * @package    SPIP\Coordonnees\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Ajout des coordonnées (adresses, mails, numéros)
 * sur la page de visualisation des objets associes
**/
function coordonnees_afficher_fiche_objet($flux) {
	$texte = "";
	$exec = isset($flux['args']['exec']) ? $flux['args']['exec'] : _request('exec');
	$e = trouver_objet_exec($exec);
	$type = $flux['args']['type'];

	if (!$e['edition'] AND in_array(table_objet_sql($type),lire_config('coordonnees/objets'))) {
		$texte .= recuperer_fond('prive/squelettes/contenu/coordonnees_fiche_objet', array(
			'objet' => $type,
			'id_objet' => intval($flux['args']['id']),
			),
			array('ajax'=>'coordonnees')
		);
	}

	if ($texte) {
		if ($p=strpos($flux['data'],"<!--afficher_fiche_objet-->"))
			$flux['data'] = substr_replace($flux['data'],$texte,$p,0);
		else
			$flux['data'] .= $texte;
	}

	return $flux;
}

/**
 * Liaisons avec les objets
 * sur la page de visualisation des coordonnées
**/
function coordonnees_affiche_gauche($flux) {
	$texte = "";
	$exec = isset($flux['args']['exec']) ? $flux['args']['exec'] : _request('exec');
	$e = trouver_objet_exec($exec);
	if (
		!$e['edition']
		and $type = $e['type']
		and in_array($type,array('adresse','email','numero'))
		and $id_coordonnee = $flux['args']["id_${type}"]
	) {
		$texte .= recuperer_fond("prive/squelettes/contenu/utilisations_${type}", array(
			"id_${type}" => intval($id_coordonnee)
			),
			array('ajax'=>true)
		);
	}

	if ($texte) {
		$flux['data'] .= $texte;
	}

	return $flux;
}


/**
 * Optimiser la base de donnees en supprimant les liens orphelins
 * de l'objet vers quelqu'un et de quelqu'un vers l'objet.
 *
 * @param int $n
 * @return int
 */
function coordonnees_optimiser_base_disparus($flux){
	include_spip('action/editer_liens');
	$flux['data'] += objet_optimiser_liens(array('adresse'=>'*', 'numero'=>'*', 'email'=>'*'),'*');
	return $flux;
}


/**
 * Déclaration du pipeline qui liste les types des coordonnées
 */
function coordonnees_types_coordonnees($flux) { return $flux; }


?>

<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function couleur_objet_affiche_droite($flux){

	$e     = trouver_objet_exec($flux['args']['exec']);
	$table_objet_sql = $e['table_objet_sql'];
	$objets_config = lire_config('couleur_objet/objets');
	if (
		in_array($table_objet_sql,$objets_config) // si configuration objets ok
		AND $e !== false // page d'un objet éditorial
		AND $e['edition'] === false // pas en mode édition
		AND $id_objet=$flux['args'][$e['id_table_objet']]
	){
		$objet = $e['table'];
		$row = sql_fetsel("couleur_objet", "spip_couleur_objet_liens", "id_objet=".intval($id_objet)." AND objet=".sql_quote($objet));
		$couleur_objet = $row['couleur_objet'];
		$contexte = array('id_objet' => $id_objet,'objet' => $objet, 'couleur_objet' => $couleur_objet);
		$flux["data"] .= recuperer_fond("inclure/couleur_objet", $contexte);
	}
	return $flux;
}

<?php
/**
 * Plugin Catalogue pour Spip 2.0
 * Licence GPL (c) 2009 - Ateliers CYM
 */

function catalogue_declarer_tables_principales($tables_principales){

	//-- Table cat_familles ------------------------------------------
	$cat_familles = array(
		"id_famille"	=> "bigint(21) NOT NULL auto_increment",
		"id_parent" 	=> "bigint(21) NOT NULL DEFAULT 0",
		"titre" 		=> "tinytext DEFAULT '' NOT NULL",
		"descriptif" 	=> "tinytext DEFAULT '' NOT NULL",
		"date" 			=> "datetime NOT NULL default '0000-00-00 00:00:00'",
		"maj"			=> "TIMESTAMP"
		);
	
	$cat_familles_key = array(
		"PRIMARY KEY"	=> "id_famille",
		);

	//-- Table cat_produits ------------------------------------------
	$cat_produits = array(
		"id_produit" 	=> "bigint(21) NOT NULL auto_increment",
		"id_famille"	=> "bigint(21) NOT NULL DEFAULT 0",
		"titre" 		=> "tinytext DEFAULT '' NOT NULL",
		"descriptif" 	=> "tinytext DEFAULT '' NOT NULL",
		"prix_ht" 		=> "decimal(6,2) default NULL",
		"date" 			=> "datetime NOT NULL default '0000-00-00 00:00:00'",
		"maj"			=> "TIMESTAMP"
		);
	
	$cat_produits_key = array(
		"PRIMARY KEY"	=> "id_produit",
		);

	//-- Table cat_variantes ------------------------------------------
	$cat_variantes = array(
		"id_variante" 	=> "bigint(21) NOT NULL auto_increment",
		"id_produit" 	=> "bigint(21) NOT NULL DEFAULT 0",
		"titre" 		=> "tinytext DEFAULT '' NOT NULL",
		"descriptif" 	=> "tinytext DEFAULT '' NOT NULL",
		"prix_ht" 		=> "decimal(6,2) default NULL",
		"date" 			=> "datetime NOT NULL default '0000-00-00 00:00:00'",
		"maj"			=> "TIMESTAMP"
		);
	
	$cat_variantes_key = array(
		"PRIMARY KEY"	=> "id_variante",
		);
	

	$tables_principales['cat_familles'] =
		array('field' => &$cat_familles, 'key' => &$cat_familles_key);
		
	$tables_principales['cat_produits'] =
		array('field' => &$cat_produits, 'key' => &$cat_produits_key);

	$tables_principales['cat_variantes'] =
		array('field' => &$cat_variantes, 'key' => &$cat_variantes_key);
				
	return $tables_principales;
}

// xxx_declarer_tables_interfaces est l'endroit ou l'on indique les raccourcis � utiliser comme table de boucle SPIP
function catalogue_declarer_tables_interfaces($interface){
	
	// $tables_interfaces['table_des_tables']['nouvelletable'] = 'nouvelleboucle';
	
	/*
	 * Objectif : pouvoir utiliser les noms de boucles "FAMILLES", "PRODUITS", "VARIANTES"...
	 *
	 */
	$interface['table_des_tables']['familles'] = 'familles';
	$interface['table_des_tables']['produits'] = 'produits';
	$interface['table_des_tables']['variantes'] = 'variantes';
	
	
	/*
	 * Objectif : autoriser les traitements SPIP sur certains champs texte...
	 *
	 */
	$interface['table_des_traitements']['TITRE'][] = _TRAITEMENT_TYPO;
	$interface['table_des_traitements']['DESCRIPTIF'][] = _TRAITEMENT_RACCOURCIS;

	
	return $interface;
}

function boucle_FAMILLES($id_boucle, &$boucles) {
        $boucle = &$boucles[$id_boucle];
        $id_table = $boucle->id_table;
        $boucle->from[$id_table] =  "zozo";  
        return calculer_boucle($id_boucle, $boucles);
}


?>

<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

function formidable_declarer_tables_interfaces($interface){
	// 'spip_' dans l'index de $tables_principales
	$interface['table_des_tables']['formulaires'] = 'formulaires';
	$interface['table_des_tables']['formulaires_reponses'] = 'formulaires_reponses';
	$interface['table_des_tables']['formulaires_reponses_champs'] = 'formulaires_reponses_champs';
	
	
	$interface['table_titre']['formulaires'] = 'titre';
	
	$interface['tables_jointures']['spip_formulaires'][] = 'formulaires_liens';
	$interface['tables_jointures']['spip_articles'][] = 'formulaires_liens';
	$interface['tables_jointures']['spip_rubriques'][] = 'formulaires_liens';
	
	return $interface;
}

function formidable_declarer_tables_principales($tables_principales){
	//-- Table formulaires -----------------------------------------------------
	$formulaires = array(
		"id_formulaire" => "bigint(21) NOT NULL",
		"identifiant" => "varchar(200)",
		"titre" => "text NOT NULL default ''",
		"descriptif" => "text",
		"message_retour" => "text NOT NULL default ''",
		"saisies" => "longtext NOT NULL default ''",
		"traitements" => "text NOT NULL default ''",
		"public" => "enum('non', 'oui') DEFAULT 'non' NOT NULL",
		"statut" => "varchar(10) NOT NULL default ''",
		"maj" => "timestamp",
		"apres" => "varchar(12) NOT NULL default ''",
		"url_redirect" => "varchar(255)"
	);
	$formulaires_cles = array(
		"PRIMARY KEY" => "id_formulaire"
	);
	$tables_principales['spip_formulaires'] = array(
		'field' => &$formulaires,
		'key' => &$formulaires_cles,
		'join'=> array(
			'id_formulaire' => 'id_formulaire'
		)
	);
	
	//-- Table formulaires_reponses --------------------------------------------
	$formulaires_reponses = array(
		"id_formulaires_reponse" => "bigint(21) NOT NULL",
		"id_formulaire" => "bigint(21) NOT NULL default 0",
		"date" => "datetime NOT NULL default '0000-00-00 00:00:00'",
		"ip" => "varchar(255) NOT NULL default ''",
		"id_auteur" => "bigint(21) NOT NULL default 0",
		"cookie" => "varchar(255) NOT NULL default ''",
		"statut" => "varchar(10) NOT NULL default ''",
		"maj" => "timestamp"
	);
	$formulaires_reponses_cles = array(
		"PRIMARY KEY" => "id_formulaires_reponse",
		"KEY id_formulaire" => "id_formulaire",
		"KEY id_auteur" => "id_auteur",
		"KEY cookie" => "cookie"
	);
	$tables_principales['spip_formulaires_reponses'] = array(
		'field' => &$formulaires_reponses,
		'key' => &$formulaires_reponses_cles,
		'join'=> array(
			'id_formulaires_reponse' => 'id_formulaires_reponse',
			'id_formulaire' => 'id_formulaire',
			'id_auteur' => 'id_auteur'
		)
	);
	
	//-- Table formulaires_reponses_champs -------------------------------------
	$formulaires_reponses_champs = array(
		"id_formulaires_reponse" => "bigint(21) NOT NULL default 0",
		"nom" => "varchar(255) NOT NULL default ''",
		"valeur" => "text NOT NULL DEFAULT ''",
		"maj" => "timestamp"
	);
	$formulaires_reponses_champs_cles = array(
		"PRIMARY KEY" => "id_formulaires_reponse, nom",
		"KEY id_formulaires_reponse" => "id_formulaires_reponse"
	);
	$tables_principales['spip_formulaires_reponses_champs'] = array(
		'field' => &$formulaires_reponses_champs,
		'key' => &$formulaires_reponses_champs_cles
	);
	
	return $tables_principales;
}

function formidable_declarer_tables_auxiliaires($tables_auxiliaires){
	$formulaires_liens = array(
		"id_formulaire"	=> "bigint(21) DEFAULT '0' NOT NULL",
		"id_objet"	=> "bigint(21) DEFAULT '0' NOT NULL",
		"objet"	=> "VARCHAR (25) DEFAULT '' NOT NULL"
	);

	$formulaires_liens_cles = array(
		"PRIMARY KEY" => "id_formulaire,id_objet,objet",
		"KEY id_formulaire" => "id_formulaire"
	);
	
	$tables_auxiliaires['spip_formulaires_liens'] = array(
		'field' => &$formulaires_liens,
		'key' => &$formulaires_liens_cles
	);
	
	return $tables_auxiliaires;
}

function formidable_rechercher_liste_des_champs($tables){
	$tables['formulaire']['titre'] = 5;
	$tables['formulaire']['descriptif'] = 3;
	return $tables;
}

?>

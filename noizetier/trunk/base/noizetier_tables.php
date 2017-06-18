<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Déclaration des informations tierces (alias, traitements, jointures, etc)
 * sur les tables de la base de données modifiées ou ajoutées par le plugin.
 *
 * Le plugin se contente de déclarer les alias des tables.
 *
 * @pipeline declarer_tables_interfaces
 *
 * @param array $interface
 * 		Tableau global des informations tierces sur les tables de la base de données
 * @return array
 *		Tableau fourni en entrée et mis à jour avec les nouvelles informations
 */
function noizetier_declarer_tables_interfaces($interface) {
	// 'spip_' dans l'index de $tables_principales
	$interface['table_des_tables']['noisettes'] = 'noisettes';
	$interface['table_des_tables']['noizetier_pages'] = 'noizetier_pages';
	$interface['table_des_tables']['noizetier_noisettes'] = 'noizetier_noisettes';

	return $interface;
}

/**
 * Déclaration des nouvelles tables de la base de données propres au plugin.
 *
 * Le plugin déclare deux nouvelles tables qui sont :
 *
 * - `spip_noisettes_pages`, qui contient les éléments descriptifs des pages et compositions,
 * - `spip_noisettes`, qui contient la desxcription de l'utilisation des noisettes dans les pages concernées.
 *
 * @pipeline declarer_tables_principales
 *
 * @param array $tables_principales
 *		Tableau global décrivant la structure des tables de la base de données
 * @return array
 *		Tableau fourni en entrée et mis à jour avec les nouvelles déclarations
 */
function noizetier_declarer_tables_principales($tables_principales) {

	// Table spip_noizetier_pages
	$pages = array(
		'page'           => "varchar(255) DEFAULT '' NOT NULL",
		'type'           => "varchar(127) DEFAULT '' NOT NULL",
		'composition'    => "varchar(127) DEFAULT '' NOT NULL",
		'nom'            => "text DEFAULT '' NOT NULL",
		'description'    => "text DEFAULT '' NOT NULL",
		'icon'           => "varchar(255) DEFAULT '' NOT NULL",
		'blocs_exclus'   => "text DEFAULT '' NOT NULL",
		'necessite'      => "text DEFAULT '' NOT NULL",
		'branche'        => "text DEFAULT '' NOT NULL",
		'est_page_objet' => "varchar(3) DEFAULT 'oui' NOT NULL",
		'est_virtuelle'  => "varchar(3) DEFAULT 'non' NOT NULL",
		'image_exemple'  => "varchar(255) DEFAULT '' NOT NULL",
		'class'          => "varchar(255) DEFAULT '' NOT NULL",
		'configuration'  => "varchar(255) DEFAULT '' NOT NULL",
		'signature'      => "varchar(32) DEFAULT '' NOT NULL",
		"maj"			 => "timestamp",
	);

	$pages_cles = array(
		'PRIMARY KEY'        => 'page',
		'KEY type'           => 'type',
		'KEY composition'    => 'composition',
		"KEY est_page_objet" => "est_page_objet",
		"KEY est_virtuelle"  => "est_virtuelle",
	);

	$tables_principales['spip_noizetier_pages'] = array(
		'field' => &$pages,
		'key' => &$pages_cles,
	);

	// Table spip_noizetier_noisettes
	$noisettes = array(
		'noisette'       => "varchar(255) DEFAULT '' NOT NULL",
		'type'           => "varchar(127) DEFAULT '' NOT NULL",
		'nom'            => "text DEFAULT '' NOT NULL",
		'description'    => "text DEFAULT '' NOT NULL",
		'icon'           => "varchar(255) DEFAULT '' NOT NULL",
		'necessite'      => "text DEFAULT '' NOT NULL",
		'contexte'       => "text DEFAULT '' NOT NULL",
		'ajax'           => "varchar(6) DEFAULT '' NOT NULL",
		'inclusion'      => "varchar(9) DEFAULT '' NOT NULL",
		'parametres'     => "text DEFAULT '' NOT NULL",
		'signature'      => "varchar(32) DEFAULT '' NOT NULL",
		"maj"			 => "timestamp",
	);

	$noisettes_cles = array(
		'PRIMARY KEY'    => 'noisette',
		'KEY type'       => 'type',
		'KEY ajax'       => 'ajax',
		'KEY inclusion'  => 'inclusion',
	);

	$tables_principales['spip_noizetier_noisettes'] = array(
		'field' => &$noisettes,
		'key' => &$noisettes_cles,
	);

	// Table spip_noisettes
	// TODO : a renommer à terme spip_noizetier
	$noizetier = array(
		'id_noisette' => 'bigint(21) NOT NULL',
		'rang'        => "smallint DEFAULT '1' NOT NULL",
		'type'        => "varchar(127) DEFAULT '' NOT NULL",
		'composition' => "varchar(127) DEFAULT '' NOT NULL",
		'objet'       => 'varchar(25) not null default ""',
		'id_objet'    => 'bigint(21) not null default 0',
		'bloc'        => "tinytext DEFAULT '' NOT NULL",
		'noisette'    => "tinytext DEFAULT '' NOT NULL",
		'parametres'  => "text DEFAULT '' NOT NULL",
		'balise'      => "varchar(6) DEFAULT 'defaut' NOT NULL",
		'css'         => "tinytext DEFAULT '' NOT NULL",
	);

	$noizetier_cles = array(
		'PRIMARY KEY'     => 'id_noisette',
		'KEY type'        => 'type(255)',
		'KEY composition' => 'composition(255)',
		'KEY bloc'        => 'bloc(255)',
		'KEY noisette'    => 'noisette(255)',
		'KEY objet'       => 'objet',
		'KEY id_objet'    => 'id_objet',
	);

	$tables_principales['spip_noisettes'] = array(
		'field' => &$noizetier,
		'key' => &$noizetier_cles,
	);

	return $tables_principales;
}

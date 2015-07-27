<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Thèmes CLIL
 * @copyright  2015
 * @author     Pierre Miquel
 * @licence    GNU/GPL
 * @package    SPIP\Clil\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function clil_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['clil_themes'] = 'clil_themes';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function clil_declarer_tables_objets_sql($tables) {

	$tables['spip_clil_themes'] = array(
		'type' => 'clil_theme',
		'principale' => "oui", 
		'table_objet_surnoms' => array('cliltheme'), // table_objet('clil_theme') => 'clil_themes' 
		'field'=> array(
			"id_clil_theme"      => "bigint(21) NOT NULL",
			"code"               => "int(11) NOT NULL DEFAULT 0",
			"code_parent"        => "int(11) NOT NULL DEFAULT 0",
			"niveau"             => "smallint(6)",
			"libelle"            => "text NOT NULL DEFAULT ''",
			"descriptif"         => "text NOT NULL DEFAULT ''",
			"tag"                => "char(3) NOT NULL DEFAULT 'non'",
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_clil_theme",
		),
		'titre' => "Libelle AS titre, '' AS lang",
		 #'date' => "",
		'champs_editables'  => array('code', 'niveau', 'libelle', 'descriptif', 'tag'),
		'champs_versionnes' => array(),
		'rechercher_champs' => array("code" => 4, "libelle" => 6),
		'tables_jointures'  => array(),
		

	);

	return $tables;
}

function clil_declarer_champs_extras($champs = array()) {
	
	$liste_rub = clil_affichage_dans_rubriques();
	$datas = array();
	$r = sql_select('code,libelle', 'spip_clil_themes', "tag='oui'");

	while ($t = sql_fetch($r)){
		$code = $t['code'];
		$datas[$code] = $t['libelle'];
	}

	$champs['spip_articles']['code_clil'] = array(
		'saisie' => 'selection', //Type du champ (voir plugin Saisies)
		'options' => array(
			'nom' => 'code_clil', 
			'label' => _T('clil_theme:label_code_clil'), 
			'sql' => "int(11) NOT NULL DEFAULT '0'",
			'datas' => $datas,
			'restrictions'=>array( 	'rubrique' => $liste_rub, 
									'voir' => array('auteur' => '0minirezo'),//Tout le monde peut voir
									'modifier' => array('auteur' => '0minirezo')),//Seuls les webmestres peuvent modifier
		),
	);
  return $champs;	
}

function clil_affichage_dans_rubriques() {

	$liste_rub = '';
	if (!is_null($quelles_rubriques = lire_config('clil_rubriques/clil_theme'))) {
		foreach ($quelles_rubriques as $key => $value) {
			$liste_rub .= $value.':';
		}
		$liste_rub = substr($liste_rub, 0, -1);
	}
	// Sinon, aucume rubriques sélectionnées, on affiche tout
	else {
		$res = sql_allfetsel('id_rubrique', 'spip_rubriques', "statut='publie'");
		foreach ($res as $key => $value) {
			$liste_rub .= $value['id_rubrique'].':';
		}
		$liste_rub = substr($liste_rub, 0, -1);
	}
	return $liste_rub;
}



?>
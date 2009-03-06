<?php


	/**
	 * SPIP-Lettres
	 *
	 * Copyright (c) 2006-2009
	 * Agence Artégo http://www.artego.fr
	 *  
	 * Ce programme est un logiciel libre distribue sous licence GNU/GPLv3.
	 * Pour plus de details voir http://www.gnu.org/licenses/gpl-3.0.html
	 *  
	 **/


	function lettres_declarer_tables_interfaces($interface) {
		$interface['table_des_tables']['abonnes'] = 'abonnes';
		$interface['table_des_tables']['abonnes_statistiques'] = 'abonnes_statistiques';
		$interface['table_des_tables']['lettres'] = 'lettres';
		$interface['table_des_tables']['lettres_statistiques'] = 'lettres_statistiques';
		$interface['table_des_tables']['themes'] = 'themes';
		$interface['tables_jointures']['spip_abonnes'][] = 'abonnes_lettres';
		$interface['tables_jointures']['spip_abonnes'][] = 'abonnes_rubriques';
		$interface['tables_jointures']['spip_abonnes'][] = 'abonnes_statistiques';
		$interface['tables_jointures']['spip_abonnes'][] = 'rubriques';
		$interface['tables_jointures']['spip_abonnes'][] = 'abonnes_clics';
		$interface['tables_jointures']['spip_abonnes'][] = 'clics';
		$interface['tables_jointures']['spip_articles'][] = 'articles_lettres';
		$interface['tables_jointures']['spip_articles'][] = 'lettres';
		$interface['tables_jointures']['spip_lettres'][] = 'articles_lettres';
		$interface['tables_jointures']['spip_lettres'][] = 'articles';
		$interface['tables_jointures']['spip_lettres'][] = 'lettres_statistiques';
		$interface['tables_jointures']['spip_lettres'][] = 'mots_lettres';
		$interface['tables_jointures']['spip_lettres'][] = 'mots';
		$interface['tables_jointures']['spip_lettres'][] = 'rubriques';
		$interface['tables_jointures']['spip_lettres'][] = 'abonnes_lettres';
		$interface['tables_jointures']['spip_lettres'][] = 'auteurs_lettres';
		$interface['tables_jointures']['spip_lettres'][] = 'documents_liens';
		$interface['tables_jointures']['spip_auteurs'][] = 'auteurs_lettres';
		$interface['tables_jointures']['spip_mots'][] = 'mots_lettres';
		$interface['tables_jointures']['spip_themes'][] = 'rubriques';
		$interface['table_date']['abonnes']	= 'maj';
		$interface['table_date']['lettres']	= 'date';
		$interface['table_des_traitements']['URL_FORMULAIRE_LETTRES'][] = 'quote_amp(%s)';
		$interface['table_des_traitements']['URL_LETTRE'][] = 'quote_amp(%s)';
		return $interface;
	}


	function lettres_declarer_tables_principales($tables_principales) {
		$spip_abonnes = array(
							"id_abonne"	=> "BIGINT(21) NOT NULL",
							"objet"		=> "VARCHAR(255) NOT NULL DEFAULT 'abonnes'",
							"id_objet"	=> "BIGINT(21) NOT NULL",
							"email"		=> "VARCHAR(255) NOT NULL DEFAULT ''",
							"code"		=> "VARCHAR(255) NOT NULL DEFAULT ''",
							"nom"		=> "VARCHAR(255) NOT NULL DEFAULT ''",
							"format"	=> "ENUM('html','texte','mixte') NOT NULL DEFAULT 'mixte'",
							"maj"		=> "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
							"extra"		=> "LONGBLOB NULL"
						);
		$spip_abonnes_key = array(
							"PRIMARY KEY" 	=> "id_abonne",
							"UNIQUE code"	=> "code"
						);
		$spip_clics = array(
							"id_clic"		=> "BIGINT(21) NOT NULL",
							"id_lettre"		=> "BIGINT(21) NOT NULL",
							"url"			=> "VARCHAR(255) NOT NULL"
						);
		$spip_clics_key = array(
							"PRIMARY KEY"	=> "id_clic",
							"UNIQUE lettre"	=> "id_lettre, url"
						);
		$spip_desabonnes = array(
							"id_desabonne"	=> "BIGINT(21) NOT NULL",
							"email"			=> "VARCHAR(255) NOT NULL DEFAULT ''"
						);
		$spip_desabonnes_key = array(
							"PRIMARY KEY" 	=> "id_desabonne",
							"UNIQUE email"	=> "email"
						);
		$spip_lettres = array(
							"id_lettre"				=> "BIGINT(21) NOT NULL",
							"id_rubrique"			=> "BIGINT(21) NOT NULL",
							"id_secteur"			=> "BIGINT(21) NOT NULL",
							"titre"					=> "TEXT NOT NULL",
							"descriptif"			=> "TEXT NOT NULL",
							"texte"					=> "LONGBLOB NOT NULL",
							"ps"					=> "TEXT NOT NULL",
							"date"					=> "DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL",
							"programmer_envoi"		=> "TINYINT NOT NULL DEFAULT '0'",
							"lang"					=> "VARCHAR(10) NOT NULL",
							"langue_choisie"		=> "VARCHAR(3) DEFAULT 'non'",
							"maj"					=> "DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL",
							"message_html"			=> "LONGBLOB NOT NULL",
							"message_texte"			=> "LONGBLOB NOT NULL",
							"date_debut_envoi"		=> "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
							"date_fin_envoi"		=> "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
							"statut"				=> "ENUM('brouillon','envoi_en_cours','envoyee') NOT NULL DEFAULT 'brouillon'",
							"extra"					=> "LONGBLOB NULL"
						);
		$spip_lettres_key = array(
							"PRIMARY KEY"	=> "id_lettre"
						);
		$spip_rubriques_crontabs = array(
							"id_rubrique"			=> "BIGINT (21) DEFAULT '0' NOT NULL"
						);
		$spip_rubriques_crontabs_key = array(
							"UNIQUE id_rubrique"	=> "id_rubrique"
						);
		$spip_themes = array(
							"id_theme"		=> "BIGINT(21) NOT NULL",
							"id_rubrique"	=> "BIGINT (21) DEFAULT '0' NOT NULL",
							"titre"			=> "TEXT NOT NULL",
							"lang"			=> "VARCHAR(10) NOT NULL"
						);
		$spip_themes_key = array(
							"PRIMARY KEY"			=> "id_theme",
							"UNIQUE id_rubrique"	=> "id_rubrique"
						);
		$tables_principales['spip_abonnes'] =
			array('field' => &$spip_abonnes, 'key' => &$spip_abonnes_key);
		$tables_principales['spip_clics'] =
			array('field' => &$spip_clics, 'key' => &$spip_clics_key);
		$tables_principales['spip_desabonnes'] =
			array('field' => &$spip_desabonnes, 'key' => &$spip_desabonnes_key);
		$tables_principales['spip_lettres'] =
			array('field' => &$spip_lettres, 'key' => &$spip_lettres_key);
		$tables_principales['spip_rubriques_crontabs'] =
			array('field' => &$spip_rubriques_crontabs, 'key' => &$spip_rubriques_crontabs_key);
		$tables_principales['spip_themes'] =
			array('field' => &$spip_themes, 'key' => &$spip_themes_key);
		return $tables_principales;
	}


	function lettres_declarer_tables_auxiliaires($tables_auxiliaires) {
		$spip_abonnes_clics = array(
							"id_abonne"		=> "BIGINT(21) NOT NULL",
							"id_clic"		=> "BIGINT(21) NOT NULL",
							"id_lettre"		=> "BIGINT(21) NOT NULL"
						);
		$spip_abonnes_clics_key = array();
		$spip_abonnes_lettres = array(
							"id_abonne"		=> "BIGINT(21) NOT NULL DEFAULT '0'",
							"id_lettre" 	=> "BIGINT(21) NOT NULL DEFAULT '0'",
							"statut"		=> "ENUM('a_envoyer','envoye','echec','annule') NOT NULL DEFAULT 'a_envoyer'",
							"format"		=> "ENUM('mixte','html','texte') NOT NULL DEFAULT 'mixte'",
							"verrou"		=> "TINYINT NOT NULL DEFAULT '0'",
							"maj"			=> "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'"
						);
		$spip_abonnes_lettres_key = array(
							"PRIMARY KEY"	=> "id_abonne, id_lettre"
						);
		$spip_abonnes_rubriques = array(
							"id_abonne"			=> "BIGINT(21) NOT NULL DEFAULT '0'",
							"id_rubrique" 		=> "BIGINT(21) NOT NULL DEFAULT '0'",
							"date_abonnement"	=> "DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
							"statut"			=> "ENUM('a_valider','valide') NOT NULL DEFAULT 'a_valider'"
						);
		$spip_abonnes_rubriques_key = array(
							"PRIMARY KEY" => "id_abonne, id_rubrique"
						);
		$spip_abonnes_statistiques = array(
							"periode"				=> "VARCHAR(7) NOT NULL",
							"nb_inscriptions"		=> "BIGINT (21) DEFAULT '0' NOT NULL",
							"nb_desinscriptions"	=> "BIGINT (21) DEFAULT '0' NOT NULL"
						);
		$spip_abonnes_statistiques_key = array(
							"PRIMARY KEY"	=> "periode"
						);
		$spip_articles_lettres = array(
							"id_article"	=> "BIGINT(21) NOT NULL",
							"id_lettre"		=> "BIGINT(21) NOT NULL"
						);
		$spip_articles_lettres_key = array(
							"PRIMARY KEY" 		=> "id_article, id_lettre",
							"KEY id_article"	=> "id_article",
							"KEY id_lettre"		=> "id_lettre"
						);
		$spip_auteurs_lettres = array(
							"id_auteur"		=> "BIGINT(21) NOT NULL",
							"id_lettre"		=> "BIGINT(21) NOT NULL"
						);
		$spip_auteurs_lettres_key = array(
							"PRIMARY KEY" 	=> "id_auteur, id_lettre",
							"KEY id_auteur"	=> "id_auteur",
							"KEY id_lettre"	=> "id_lettre"
						);
		$spip_lettres_statistiques = array(
							"periode"		=> "VARCHAR(7) NOT NULL",
							"nb_envois"		=> "BIGINT (21) DEFAULT '0' NOT NULL"
						);
		$spip_lettres_statistiques_key = array(
							"PRIMARY KEY"	=> "periode"
						);
		$spip_mots_lettres = array(
							"id_mot"		=> "BIGINT (21) DEFAULT '0' NOT NULL",
							"id_lettre"		=> "BIGINT (21) DEFAULT '0' NOT NULL"
						);
		$spip_mots_lettres_key = array(
							"PRIMARY KEY"	=> "id_lettre, id_mot",
							"KEY id_mot"	=> "id_mot"
						);
		$tables_auxiliaires['spip_abonnes_clics'] = 
			array('field' => &$spip_abonnes_clics, 'key' => &$spip_abonnes_clics_key);
		$tables_auxiliaires['spip_abonnes_lettres'] = 
			array('field' => &$spip_abonnes_lettres, 'key' => &$spip_abonnes_lettres_key);
		$tables_auxiliaires['spip_abonnes_rubriques'] = 
			array('field' => &$spip_abonnes_rubriques, 'key' => &$spip_abonnes_rubriques_key);
		$tables_auxiliaires['spip_abonnes_statistiques'] = 
			array('field' => &$spip_abonnes_statistiques, 'key' => &$spip_abonnes_statistiques_key);
		$tables_auxiliaires['spip_articles_lettres'] = 
			array('field' => &$spip_articles_lettres, 'key' => &$spip_articles_lettres_key);
		$tables_auxiliaires['spip_auteurs_lettres'] = 
			array('field' => &$spip_auteurs_lettres, 'key' => &$spip_auteurs_lettres_key);
		$tables_auxiliaires['spip_lettres_statistiques'] = 
			array('field' => &$spip_lettres_statistiques, 'key' => &$spip_lettres_statistiques_key);
		$tables_auxiliaires['spip_mots_lettres'] = 
			array('field' => &$spip_mots_lettres, 'key' => &$spip_mots_lettres_key);
		return $tables_auxiliaires;
	}


	function lettres_install($action){
		include_spip('inc/plugin');
		$info_plugin_lettres = plugin_get_infos(_NOM_PLUGIN_LETTRE_INFORMATION);
		$version_plugin = $info_plugin_lettres['version'];
		switch ($action){
			case 'test':
				return (isset($GLOBALS['meta']['spip_lettres_version']) AND ($GLOBALS['meta']['spip_lettres_version'] >= $version_plugin));
				break;
			case 'install':
				include_spip('base/create');
				include_spip('base/abstract_sql');
				if (!isset($GLOBALS['meta']['spip_lettres_version'])) {
					creer_base();
#TODO					spip_query("ALTER TABLE spip_groupes_mots ADD lettres VARCHAR(3) NOT NULL DEFAULT 'non';");
					ecrire_meta('spip_lettres_version', $version_plugin);
					ecrire_meta('spip_lettres_fond_formulaire_lettres', 'lettres');
					ecrire_meta('spip_lettres_fond_lettre_titre', 'lettre_titre');
					ecrire_meta('spip_lettres_fond_lettre_html', 'lettre_html');
					ecrire_meta('spip_lettres_fond_lettre_texte', 'lettre_texte');
					ecrire_meta('spip_lettres_notifier_suppression_abonne', 'non');
					ecrire_meta('spip_lettres_utiliser_articles', 'non');
					ecrire_meta('spip_lettres_utiliser_ps', 'non');
					ecrire_meta('spip_lettres_cron', md5(uniqid(rand())));
					ecrire_metas();
					include_spip('inc/getdocument');
					creer_repertoire_documents('lettres');
				} else {
					$version_base = $GLOBALS['meta']['spip_lettres_version'];
					// seulement à partir de la version 3.0 - migrer les scripts de maj c'est trop long
					if ($version_base < 3.0) {
						creer_base();
						ecrire_meta('spip_lettres_notifier_suppression_abonne', 'non');
						ecrire_meta('spip_lettres_utiliser_articles', 'non');
						ecrire_meta('spip_lettres_version', $version_base = 3.0);
						ecrire_metas();
					}
					if ($version_base < 3.1) {
						maj_tables('spip_lettres');
						ecrire_meta('spip_lettres_utiliser_ps', 'non');
						ecrire_meta('spip_lettres_version', $version_base = 3.1);
						ecrire_metas();
					}
					if ($version_base < 3.2) {
						$INDEX_elements_objet = unserialize($GLOBALS['meta']['INDEX_elements_objet']);
						unset($INDEX_elements_objet['spip_lettres']); 
						ecrire_meta('INDEX_elements_objet',serialize($INDEX_elements_objet));
						ecrire_meta('spip_lettres_version', $version_base = 3.2);
						ecrire_metas();
					}
					if ($version_base < 3.3) {
						creer_base(); // table spip_desabonnes
						ecrire_meta('spip_lettres_version', $version_base = 3.3);
						ecrire_metas();
					}
					if ($version_base < 3.4) {
						include_spip('inc/getdocument');
						creer_repertoire_documents('lettres');
						ecrire_meta('spip_lettres_version', $version_base = 3.4);
						ecrire_metas();
					}
					if ($version_base < 3.5) {
						// localisation allemande et italienne
						ecrire_meta('spip_lettres_version', $version_base = 3.5);
						ecrire_metas();
					}
					if ($version_base < 3.6) {
						ecrire_meta('spip_lettres_cron', md5(uniqid(rand())));
						ecrire_meta('spip_lettres_version', $version_base = 3.6);
						ecrire_metas();
					}
					if ($version_base < 3.7) {
						creer_base(); // table spip_rubriques_crontabs
						ecrire_meta('spip_lettres_version', $version_base = 3.7);
						ecrire_metas();
					}
					if ($version_base < 3.8) {
						maj_tables('spip_lettres'); // bye bye idx
						ecrire_meta('spip_lettres_fond_lettre_titre', 'lettre_titre');
						ecrire_meta('spip_lettres_version', $version_base = 3.8);
						ecrire_metas();
					}
				}
				break;
			case 'uninstall':
				include_spip('base/abstract_sql');
				sql_drop_table('spip_abonnes', true);
				sql_drop_table('spip_clics', true);
				sql_drop_table('spip_desabonnes', true);
				sql_drop_table('spip_lettres', true);
				sql_drop_table('spip_rubriques_crontabs', true);
				sql_drop_table('spip_themes', true);
				sql_drop_table('spip_abonnes_clics', true);
				sql_drop_table('spip_abonnes_lettres', true);
				sql_drop_table('spip_abonnes_rubriques', true);
				sql_drop_table('spip_abonnes_statistiques', true);
				sql_drop_table('spip_articles_lettres', true);
				sql_drop_table('spip_auteurs_lettres', true);
				sql_drop_table('spip_documents_lettres', true);
				sql_drop_table('spip_lettres_statistiques', true);
				sql_drop_table('spip_mots_lettres', true);
				effacer_meta('spip_lettres_version');
				effacer_meta('spip_lettres_fond_formulaire_lettres');
				effacer_meta('spip_lettres_fond_lettre_html');
				effacer_meta('spip_lettres_fond_lettre_texte');
				effacer_meta('spip_lettres_notifier_suppression_abonne');
				effacer_meta('spip_lettres_utiliser_articles');
				effacer_meta('spip_lettres_utiliser_ps');
				effacer_meta('spip_lettres_cron');
				include_spip('inc/getdocument');
				effacer_repertoire_temporaire(_DIR_LETTRES);
				break;
		}
	}


	global $table_des_abonnes;
	$table_des_abonnes['abonnes'] = array(
										'table'				=> 'abonnes',
										'url_prive'			=> 'abonnes_edit',
										'url_prive_titre'	=> _T('lettresprive:modifier_abonne'),
										'champ_id'			=> 'id_abonne',
										'champ_email'		=> 'email',
										'champ_nom'			=> 'nom'
										);
	$table_des_abonnes['auteurs'] = array(
										'table'				=> 'auteurs',
										'url_prive'			=> 'auteur_infos',
										'url_prive_titre'	=> _T('lettresprive:voir_fiche_auteur'),
										'champ_id'			=> 'id_auteur',
										'champ_email'		=> 'email',
										'champ_nom'			=> 'nom'
										);


/*
		if ($tables_installees = unserialize($GLOBALS['meta']['MotsPartout:tables_installees'])) {
			if (!$tables_installees['lettres']) {
				$tables_installees['lettres'] = true;
				ecrire_meta('MotsPartout:tables_installees',serialize($tables_installees));
	  			ecrire_metas();
			}
		}
	$choses_possibles['lettres'] = array(
										  'titre_chose' => 'lettres',
										  'id_chose' => 'id_lettre',
										  'table_principale' => 'spip_lettres',
									  	  'url_base' => 'lettres',
										  'tables_limite' => array(
																   'lettres' => array(
																					   'table' => 'spip_lettres',
																					   'nom_id' => 'id_lettre'),
																   'rubriques' => array(
																						'table' => 'spip_lettres',
																						'nom_id' =>  'id_rubrique'),
																   'documents' => array(
																						'table' => 'spip_documents_lettres',
																						'nom_id' =>  'id_document'),
																   'auteurs' => array(
																					  'table' => 'spip_auteurs_lettres',
																					  'nom_id' => 'id_auteur')
																   )
										  );
*/

?>
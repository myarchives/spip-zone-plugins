<?php

/**
 * Définit les fonctions du plugin Info Sites.
 *
 * @plugin     Info Sites
 *
 * @copyright  2014-2016
 * @author     Teddy Payet
 * @licence    GNU/GPL
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/filtres_ecrire');

function lister_tables_liens() {
	$tables_auxilaires = lister_tables_auxiliaires();
	$tables_auxilaires_objets = array();

	foreach ($tables_auxilaires as $key => $table_auxilaire) {
		if (isset($table_auxilaire['field']['objet'])) {
			$tables_auxilaires_objets[] = $key;
		}
	}

	return $tables_auxilaires_objets;
}

/**
 * Cette fonction compte les éléments enregistrés dans une table.
 *
 * @param        $table Le nom de la table à compter.
 * @param string $where Cibler des éléments en particulier
 *
 * @return bool|int
 */
function nb_elements($table, $where = '') {
	include_spip('base/abstract_sql');

	return sql_countsel($table, $where);
}

/**
 * Compter le nombre d'enregistrement pour la table organisation.
 *
 * @param string $where Cibler des éléments en particulier
 *
 * @return bool|int
 */
function nb_organisations($where = '') {
	return nb_elements('spip_organisations', $where);
}

/**
 * Compter le nombre d'enregistrement pour la table projets.
 *
 * @param string $where Cibler des éléments en particulier
 *
 * @return bool|int
 */
function nb_projets($where = '') {
	return nb_elements('spip_projets', $where);
}

/**
 * Compter le nombre d'enregistrement pour la table projets.
 *
 * @param string $where Cibler des éléments en particulier
 *
 * @return bool|int
 */
function nb_projets_sites($where = '') {
	return nb_elements('spip_projets_sites', $where);
}

/**
 * Compter le nombre de sites de projets d'un certain type.
 *
 * @param string $type_site Cibler des types de site en particulier. Par défaut, des sites en production.
 *
 * @return bool|int
 */
function nb_projets_sites_types($type_site = '07prod') {
	if (empty($type_site)) {
		$type_site = '07prod';
	}

	return nb_projets_sites("type_site='" . $type_site . "'");
}

/**
 * Compter le nombre d'enregistrement pour la table projets.
 *
 * @param string $where Cibler des éléments en particulier
 *
 * @return bool|int
 */
function nb_projets_cadres($where = '') {
	return nb_elements('spip_projets_cadres', $where);
}

/**
 * @param string $where
 *
 * @return bool|int
 */
function nb_contacts($where = '') {
	return nb_elements('spip_contacts', $where);
}

/**
 * Lister les sites de projets ayant un webservice renseigné.
 *
 * @return array Liste des sites de projets
 */
function sites_webservices() {
	include_spip('base/abstract_sql');
	$sites_id = array();
	$sites_projets = sql_allfetsel('id_projets_site', 'spip_projets_sites', "webservice!=''");
	if (is_array($sites_projets) and count($sites_projets) > 0) {
		foreach ($sites_projets as $site_projet) {
			$sites_id[] = $site_projet['id_projets_site'];
		}
	} else {
		// S'il n'y a aucun site de projet avec un webservice renseigné,
		// on renvoie false.
		$sites_id = false;
	}

	return $sites_id;
}

/**
 * Lister les sites projets ayant des plugins à mettre à jour.
 * La première version de cette fonction est pour le CMS SPIP. Il faudra l'adapter pour les autres CMS.
 *
 * @uses formater_tableau()
 *
 * @return array
 */
function sites_projets_maj_plugins() {
	include_spip('base/abstract_sql');
	$sites_projets = sites_webservices();
	$liste_plugins = array();

	if (is_array($sites_projets)) {
		$liste_sites_projets_plugins = sql_allfetsel('id_projets_site, logiciel_nom, logiciel_plugins', 'spip_projets_sites', 'id_projets_site IN (' . implode(',', $sites_projets) . ") AND logiciel_plugins!=''");
		if (is_array($liste_sites_projets_plugins) and count($liste_sites_projets_plugins) > 0) {
			foreach ($liste_sites_projets_plugins as $key => $site_projet) {
				$liste_plugins_tmp = formater_tableau($site_projet['logiciel_plugins']);
				foreach ($liste_plugins_tmp as $key => $plugin) {
					switch (strtolower($site_projet['logiciel_nom'])) {
						case 'spip':
							# TODO : utiliser la fonction idoine plugin_spip()
							break;

						default:
							# code...
							break;
					}
				}
				$liste_plugins = array_merge($liste_plugins, $liste_plugins_tmp);
			}
		}
	}

	return $liste_plugins;
}

function plugins_spip($plugins = array(), $branche_spip = null) {
	if (is_array($plugins) and count($plugins) > 0 and !is_null($branche_spip)) {
		# TODO : Créer la fonction qui va chercher les infos d'un plugin SPIP.
	}
}

/**
 * Lister le nom des logiciels des sites de projets.
 *
 * @return array
 */
function info_sites_lister_logiciels_sites() {
	include_spip('base/objets');
	$logiciels_nom = array();
	$logiciels_base = sql_allfetsel("DISTINCT(logiciel_nom)", 'spip_projets_sites');

	if (is_array($logiciels_base) and count($logiciels_base) > 0) {
		foreach ($logiciels_base as $site) {
			$logiciels_nom[] = $site['logiciel_nom'];
		}
	}
	$logiciels_nom = info_sites_nettoyer_tableau($logiciels_nom);

	return $logiciels_nom;
}

function info_sites_lister_logiciels_projet($id_projet, $class = '') {
	include_spip('base/bastract_sql');
	$logiciels_nom = array();
	$logiciels_base = sql_allfetsel('logiciel_nom', 'spip_projets_sites', "id_projets_site IN (SELECT id_projets_site FROM spip_projets_sites_liens WHERE id_objet=$id_projet AND objet='projet')");
	if (is_array($logiciels_base) and count($logiciels_base) > 0) {
		foreach ($logiciels_base as $site) {
			if (is_null($class) or empty($class)) {
				$logiciels_nom[] = $site['logiciel_nom'];
			} else {
				$logiciels_nom[] = info_sites_nom_machine($site['logiciel_nom']);
			}
		}
	}
	$logiciels_nom = info_sites_nettoyer_tableau($logiciels_nom);

	return $logiciels_nom;
}

function info_sites_nom_machine($subject) {
	$nom_tmp = trim($subject); // On enlève les espaces indésirables
	$nom_tmp = translitteration_complexe($nom_tmp); // On enlève les accents et cie
	$nom_tmp = preg_replace("/(\/|[[:space:]])/", '_', $nom_tmp); // On enlève les espaces et les slashs
	$nom_tmp = preg_replace("/(_+)/", '_', $nom_tmp); // pas de double underscores
	$nom_tmp = strtolower($nom_tmp); // On met en minuscules

	return $nom_tmp;
}

function info_sites_lister_type($meta) {
	include_spip('inc/config');
	include_spip('base/objets');
	$objets_selectionnes = lire_config($meta, array());
	if (count($objets_selectionnes) > 0) {
		foreach ($objets_selectionnes as $key => $value) {
			$objets_selectionnes[$key] = objet_type($value);
		}
	}
	$objets_selectionnes = info_sites_nettoyer_tableau($objets_selectionnes);

	return $objets_selectionnes;
}

function info_sites_lister_diagnostic_logiciel() {
	include_spip('inc/utils');
	$repo_diagnostic = array();
	$logiciels_nom = info_sites_lister_logiciels_sites();
	if (is_array($logiciels_nom) and count($logiciels_nom) > 0) {
		foreach ($logiciels_nom as $logiciel_nom) {
			if (find_in_path('diagnostic/' . mb_strtolower($logiciel_nom) . '/diagnostic.html')) {
				$repo_diagnostic[] = $logiciel_nom;
			}
		}
	}

	return $repo_diagnostic;
}

function info_sites_determine_source_lien_objet($a, $b, $c) {
	include_spip('formulaires/editer_liens');

	list($table_source, $objet, $id_objet, $objet_lien) = determine_source_lien_objet($a, $b, $c);

	return array(
		'table_source' => $table_source,
		'objet' => $objet,
		'id_objet' => $id_objet,
		'$objet_lien' => $objet_lien,
	);
}

function info_sites_lister_content_html() {
	$resultats = find_all_in_path('content/', "\.html$");
	$resultats = array_keys($resultats);

	return $resultats;
}

/**
 * Lister les rôles possibles d'un auteur sur les projets.
 *
 * @return array
 *          Liste des rôles d'un auteur sur les projets
 */
function info_sites_lister_roles_auteurs() {
	include_spip('base/objets');
	$desc_auteurs = lister_tables_objets_sql('spip_auteurs');
	$roles = array();
	if (isset($desc_auteurs['roles_titres']) and isset($desc_auteurs['roles_objets']['projets']['choix'])) {
		foreach ($desc_auteurs['roles_objets']['projets']['choix'] as $role_objet) {
			if (isset($desc_auteurs['roles_titres'][$role_objet])) {
				$roles[$role_objet] = $desc_auteurs['roles_titres'][$role_objet];
			}
		}
	}

	return $roles;
}

function info_sites_lister_projets_auteurs($id_auteur = '') {
	if (is_null($id_auteur) or empty($id_auteur)) {
		$id_auteur = session_get('id_auteur');
	}
	$projets_id = array();
	$projets_base = sql_allfetsel('id_objet', 'spip_auteurs_liens', "objet='projet' AND id_auteur=$id_auteur");

	if (is_array($projets_base) and count($projets_base) > 0) {
		foreach ($projets_base as $projet) {
			$projets_id[] = $projet['id_objet'];
		}
	}
	$projets_id = info_sites_nettoyer_tableau($projets_id);

	return $projets_id;
}

function info_sites_nettoyer_tableau($tableau = array()) {
	if (count($tableau) > 0) {
		$tableau = array_unique($tableau); // Pas de doublons
		$tableau = array_filter($tableau); // On enlève les valeurs vides
		$tableau = array_values($tableau); // On réindexe le tableau pour éviter des surprises
	}

	return $tableau;
}

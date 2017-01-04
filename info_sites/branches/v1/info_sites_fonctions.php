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

/**
 * Lister des tables de liens des différents objets de SPIP
 * On récupère toutes les tables auxiliaires référencées et on ne garde que les tables ayant un champ `objet`. Ce qui présuppose dans SPIP que la table est de type 'liens' entre objets.
 *
 * @example array('spip_auteurs_liens', 'spip_mots_liens')
 * @see     lister_tables_auxiliaires()
 * @return array Liste des tables de liens des différents objets de SPIP
 */
function lister_tables_liens() {
	include_spip('base/objets');
	$tables_auxilaires = lister_tables_auxiliaires();
	$tables_auxilaires_objets = array();

	foreach ($tables_auxilaires as $key => $table_auxilaire) {
		if (isset($table_auxilaire['field']['objet'])) {
			$tables_auxilaires_objets[] = $key;
		}
	}

	return $tables_auxilaires_objets;
}

if (!function_exists('lister_tables_objets')) {
	/**
	 * Lister les noms d’objet référencés dans SPIP.
	 *
	 * @example array('articles', 'rubriques', 'mots', 'auteurs');
	 * @see     lister_tables_principales()
	 * @see     table_objet()
	 * @return array|bool Si on a bien des tables principales, on retourne la liste des objets de SPIP
	 *                    Sinon, on envoie un false.
	 */
	function lister_tables_objets() {
		include_spip('bas/objets');
		/* récupérer les tables principales */
		$tables_principales = lister_tables_principales();
		/* Ne garder que les noms de tables */
		$tables_principales = array_keys($tables_principales);
		if (is_array($tables_principales) and count($tables_principales)) {
			$liste_objets = array();
			foreach ($tables_principales as $table) {
				$liste_objets[] = table_objet($table);
			}
			natsort($liste_objets);

			return $liste_objets;
		}

		return false;
	}
}

/**
 * Compter les éléments enregistrés dans une table.
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
	include_spip('inc/utils');
	include_spip('projets_sites_fonctions');
	$sites_projets = sites_webservices();
	$liste_plugins = array();

	if (is_array($sites_projets)) {
		$liste_sites_projets_plugins = sql_allfetsel('id_projets_site, logiciel_nom, logiciel_version, logiciel_plugins', 'spip_projets_sites', 'id_projets_site IN (' . implode(',', $sites_projets) . ") AND logiciel_plugins!=''");
		if (is_array($liste_sites_projets_plugins) and count($liste_sites_projets_plugins) > 0) {
			foreach ($liste_sites_projets_plugins as $key => $site_projet) {
				$liste_plugins[$site_projet['id_projets_site']] = array();
				$liste_plugins_tmp = formater_tableau($site_projet['logiciel_plugins'], 'plugins');
				foreach ($liste_plugins_tmp as $key => $plugin) {
					$logiciel = strtolower($site_projet['logiciel_nom']);
					$info_plugin = charger_fonction('plugins_' . $logiciel, 'inc');
					/**
					 * Si la fonction n'existe pas pour ce logiciel, on s'arrête là.
					 */
					if ($info_plugin !== false) {
						$a_mettre_jour = $info_plugin($plugin, $site_projet['logiciel_version']);
						/**
						 * Si la fonction renvoie false, c'est que le plugin est à jour,
						 * pas la peine d'aller plus loin
						 */
						if ($a_mettre_jour === false) {
							unset($liste_plugins_tmp[$key]);
						} else {
							/**
							 * Le plugin est à mettre à jour.
							 * On reprend les infos issues de la fonction info_plugin
							 * qui contient le numéro de version de la maj
							 */
							$liste_plugins_tmp[$key] = $a_mettre_jour;
						}
					}
				}
				if (is_array($liste_plugins_tmp) or count($liste_plugins_tmp) > 0) {
					/**
					 * Les plugins de ce site sont à mettre à jour
					 */
					$liste_plugins_tmp = array_values($liste_plugins_tmp);
					$liste_plugins[$site_projet['id_projets_site']] = $liste_plugins_tmp;
				} else {
					/**
					 * Les plugins de ce site sont tous à jour
					 */
					unset($liste_plugins[$site_projet['id_projets_site']]);
				}
			}
		}
	}
	echo _DIR_TMP;

	return $liste_plugins;
}

/**
 * Lister le nom des logiciels des sites de projets.
 *
 * @return array
 */
function info_sites_lister_logiciels_sites() {
	include_spip('base/objets');
	include_spip('base/abstract_sql');
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
	include_spip('base/abstract_sql');
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
	$nom_tmp = translitteration($nom_tmp); // On enlève les accents et cie
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
	include_spip('inc/utils');
	$resultats = find_all_in_path('content/', "\.html$");
	if (is_array($resultats) and count($resultats) > 0) {
		$resultats = array_keys($resultats);
	}

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

function info_sites_lister_roles_auteurs_tableaux() {
	$roles = info_sites_lister_roles_auteurs();
	$roles_tableaux = array();
	foreach ($roles as $role) {
		$roles_tableaux[$role] = array();
	}

	return $roles_tableaux;
}

/**
 * Réupérer les rôles de l'auteur sur les projets auxquels il est associé.
 *
 * @param string $id_auteur
 *
 * @return array
 */
function info_sites_lister_projets_auteurs($id_auteur = '') {
	include_spip('inc/session');
	include_spip('base/abstract_sql');
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

/**
 * Récupérer la liste des sites des projets auxquels l'auteur est associé
 *
 * @param string $id_auteur
 *
 * @return array
 */
function info_sites_lister_projets_sites_auteurs($id_auteur = '') {
	include_spip('base/abstract_sql');
	$liste_projets = info_sites_lister_projets_auteurs($id_auteur);
	$projets_sites_id = array();
	if (is_array($liste_projets) and count($liste_projets)) {
		$projets_sites_base = sql_allfetsel('id_projets_site', 'spip_projets_sites_liens', "objet='projet' AND id_objet IN (" . implode(',', $liste_projets) . ")");
		if (is_array($projets_sites_base) and count($projets_sites_base) > 0) {
			foreach ($projets_sites_base as $projets_site) {
				$projets_sites_id[] = $projets_site['id_projets_site'];
			}
		}
		$projets_sites_id = info_sites_nettoyer_tableau($projets_sites_id);
	}

	return $projets_sites_id;
}

/**
 * Récupérer les auteurs par rôles sur les projets.
 *
 * @param $id_projet
 *
 * @return array|bool
 */
function info_sites_lister_projets_auteurs_roles($id_projet) {
	include_spip('base/abstract_sql');
	if (is_null($id_projet) or empty($id_projet)) {
		return false;
	}
	$projets_roles = array();
	$projets_base = sql_allfetsel('id_auteur, role', 'spip_auteurs_liens', "objet='projet' AND id_objet=$id_projet");

	if (is_array($projets_base) and count($projets_base) > 0) {
		foreach ($projets_base as $projet) {
			$projets_roles[$projet['role']][] = $projet['id_auteur'];
		}
	}

	/**
	 * On ne passe pas par le nettoyeur pour ne pas réindexer le tableau car ici on a besoin des index rôle.
	 * $projets_roles = info_sites_nettoyer_tableau($projets_roles);
	 */

	return $projets_roles;
}

/**
 * Avoir un tableau propre et bien indexé.
 *
 * @param array $tableau
 *
 * @return array
 */
function info_sites_nettoyer_tableau($tableau = array()) {
	if (count($tableau) > 0) {
		$tableau = array_unique($tableau); // Pas de doublons
		$tableau = array_filter($tableau); // On enlève les valeurs vides
		$tableau = array_values($tableau); // On réindexe le tableau pour éviter des surprises
	}

	return $tableau;
}

/**
 * Récupérer la liste des plugins à mettre à jour pour chaque site.
 *
 * @return array    liste des plugins ou un tableau vide si le fichier n'existe pas.
 */
function recuperer_maj_plugins() {
	$fichier_maj_plugins = _FICHIER_MAJ_PLUGINS;
	if (is_file($fichier_maj_plugins)) {
		$liste_maj_plugins = file_get_contents($fichier_maj_plugins);
		$liste_maj_plugins = unserialize($liste_maj_plugins);

		return $liste_maj_plugins;
	}

	return array();
}

/**
 * Récupérer la liste des plugins à mettre à jour pour chaque site.
 *
 * @return array    liste des plugins ou un tableau vide si le fichier n'existe pas.
 */
function recuperer_maj_plugins_auteurs($id_auteur = '') {
	// Récupération de tous les sites à mettre à jour
	$maj_plugins = recuperer_maj_plugins();
	// On ne garde que les index
	if (is_array($maj_plugins) and count($maj_plugins) > 0) {
		$maj_plugins = array_keys($maj_plugins);
	}
	// Lister les sites des projets de l'auteur
	$projets_sites_auteurs = info_sites_lister_projets_sites_auteurs($id_auteur);
	// Ne garder que ceux qui sont à mettre à jour
	$maj_plugins_auteurs = array_intersect($projets_sites_auteurs, $maj_plugins);

	return $maj_plugins_auteurs;
}

/**
 * Savoir si un type-page (cf. `needle`) est présent dans le menu d'info sites.
 *
 * @param $needle
 *        Nom de l'élément à retrouver dans le menu d'info sites.
 *
 * @return bool
 *         true si présent
 *         false si absent
 */
function in_ismenu($needle) {
	if (is_null($needle)) {
		return false;
	}

	include_spip('inc/config');
	$info_sites_menu = lire_config('info_sites_menu');
	if (is_array($info_sites_menu) and count($info_sites_menu) > 0) {
		$element_menus = array_keys($info_sites_menu);
		$resultats = in_array($needle, $element_menus);
		if ($resultats) {
			return true;
		} else {
			return false;
		}
	}

	return false;
}

function info_sites_lister_doublons_versioning_rss() {
	include_spip('base/abstract_sql');
	$doublons = sql_allfetsel("COUNT(versioning_rss) as nbr_doublon, versioning_rss", 'spip_projets', "versioning_rss!=''", 'versioning_rss', '', '', "nbr_doublon > 1");

	var_dump($doublons);
}

function info_sites_lister_doublons_commits() {
	include_spip('base/abstract_sql');
	$doublons = sql_allfetsel("COUNT(guid) as nbr_doublon, guid", 'spip_commits', "guid!=''", 'guid', '', '', "nbr_doublon > 1");

	var_dump($doublons);
}


function filtre_compiler_branches_logiciel_dist($logiciel_nom = null) {
	include_spip('inc/info_sites_outiller');
	$f = compiler_branches_logiciel($logiciel_nom);

	return $f;
}
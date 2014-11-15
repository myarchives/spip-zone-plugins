<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Chargement de tous les taxons d'un règne donné, du règne lui-même aux taxons de genre au maximum.
 * La fonction permet aussi de choisir un rang taxonomique feuille différent du genre.
 * Les nom communs anglais et français peuvent aussi être chargés en complément mais
 * ne couvrent pas l'ensemble des taxons.
 *
 * @api
 * @filtre
 *
 * @param string	$regne
 * 		Nom scientifique du règne en lettres minuscules (animalia, plantae, fungi)
 * @param string	$rang
 * 		Rang taxonomique minimal jusqu'où charger le règne. Ce rang est fournit en anglais et
 * 		correspond à : phylum, class, order, family, genus.
 * @param array		$langues
 * 		Tableau des codes (au sens SPIP) des langues à charger pour les noms communs des taxons
 *
 * @return bool|string
 * 		Retour true/false
 */
function taxonomie_charger_regne($regne, $rang, $langues=array('fr')) {
	$retour = false;
	$meta_regne = array();

	// Lecture de la hiérarchie des taxons à partir du fichier texte extrait de la base ITIS
	include_spip('services/itis/itis');
	$taxons = itis_read_hierarchy($regne, $rang, $meta_regne['sha']);

	// Ajout des noms communs extraits de la base ITIS dans la langue demandée
	if ($taxons) {
		$meta_regne['compteur'] = count($taxons);
		foreach ($langues as $_cle => $_langue) {
			$prefixe = ($_cle == count($langues)-1) ? '<multi>' : '';
			$suffixe = ($_cle == count($langues)-1) ? '</multi>' : '';
			$noms = itis_read_vernaculars($_langue, $sha_langue);
			if ($noms) {
				$meta_regne['langues'][$_langue]['sha'] = $sha_langue;
				$nb_traductions = 0;
				foreach ($noms as $_tsn => $_nom) {
					if (array_key_exists($_tsn, $taxons)) {
						$taxons[$_tsn]['nom_commun'] = $prefixe . $taxons[$_tsn]['nom_commun'] . $_nom . $suffixe;
						$nb_traductions += 1;
					}
				}
				$meta_regne['langues'][$_langue]['compteur'] = $nb_traductions;
			}
		}

		// Insertion dans la base de données
		$retour = sql_insertq_multi('spip_taxons', array_values($taxons));
		if ($retour) {
			// Insérer les sha dans une meta propre au règne.
			// Ca permettra de tester l'utilité ou pas d'un rechargement du règne
			$meta_regne['rang'] = $rang;
			$meta_regne['maj'] = date('Y-m-d H:i:s');
			ecrire_meta("taxonomie_$regne", serialize($meta_regne));
		}
	}

	return $retour;
}


/**
 * Suppression de tous les taxons d'un règne donné de la base de données.
 * La meta concernant les informations de chargement du règne est aussi effacée.
 *
 * @api
 * @filtre
 *
 * @param string	$regne
 * 		Nom scientifique du règne en lettres minuscules (animalia, plantae, fungi)
 *
 * @return bool
 * 		Retour true/false
 */
function taxonomie_vider_regne($regne) {
	$retour = sql_delete('spip_taxons', 'regne=' . sql_quote($regne));
	if ($retour !== false) {
		// Supprimer la meta propre au règne.
		effacer_meta("taxonomie_$regne");
		$retour = true;
	}

	return $retour;
}


/**
 * Interrogation sur l'existence ou pas d'un règne en base de données.
 * La fonction scrute la table spip_taxons et non la meta propre au règne.
 *
 * @api
 * @filtre
 *
 * @param string	$regne
 * 		Nom scientifique du règne en lettres minuscules (animalia, plantae, fungi)
 *
 * @return bool
 */
function taxonomie_regne_existe($regne, &$meta_regne) {
	$meta_regne = array();
	$existe = false;

	$retour = sql_countsel('spip_taxons', 'regne=' . sql_quote($regne));
	if ($retour) {
		// Supprimer la meta propre au règne.
		include_spip('inc/config');
		$meta_regne = lire_config("taxonomie_$regne");
		$existe = true;
	}

	return $existe;
}


/**
 * Fourniture de l'ascendance taxonomique d'un taxon donné.
 *
 * @api
 * @filtre
 *
 * @param int	$id_taxon
 * 		Id du taxon pour lequel il faut fournir l'ascendance
 * @param int	$tsn_parent
 *      TSN du parent correspondant au taxon id_taxon. Ce paramètre permet d'optimiser le traitement
 * 		mais n'est pas obligatoire.
 *
 * @return array
 */
function taxonomie_informer_ascendance($id_taxon, $tsn_parent=null, $ordre='descendant') {
	$ascendance = array();

	// Si on ne passe pas le tsn du parent correspondant au taxon pour lequel on cherche l'ascendance
	// alors on le cherche en base de données.
	// Le fait de passer ce tsn parent est une uniquement optimisation.
	if (is_null($tsn_parent)) {
		$tsn_parent = sql_getfetsel('tsn_parent', 'spip_taxons', 'id_taxon=' . intval($id_taxon));
	}

	while ($tsn_parent > 0) {
		$select = array('id_taxon', 'tsn_parent', 'nom_scientifique', 'nom_commun', 'rang');
		$where = array('tsn=' . intval($tsn_parent));
		$taxon = sql_fetsel($select, 'spip_taxons', $where);
		if ($taxon) {
			$ascendance[] = $taxon;
			$tsn_parent = $taxon['tsn_parent'];
		}
	}

	if ($ascendance
	AND ($ordre == 'descendant'))
		$ascendance = array_reverse($ascendance);

	return $ascendance;
}

?>
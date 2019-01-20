<?php
/**
 * Ce fichier contient l'API complémentaire spécifique au noiZetier de gestion des conteneurs.
 *
 * @package SPIP\NOIZETIER\CONTENEUR\API
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Détermine l'id du conteneur à partir des données d'une page, d'un objet ou d'une noisette conteneur.
 * Cette fonction est en fait une encapsalution de la fonction conteneur_identifier() qui permet
 * de reconstituer le conteneur à partir des données du noizetier page, composition, objet et noisette.
 *
 * @api
 *
 * @uses conteneur_identifier()
 *
 * @param array|string $page_ou_objet
 * 		  Page au sens SPIP ou objet spécifiquement identifié.
 *        - dans le cas d'une page SPIP comme sommaire, l'argument est une chaîne.
 * 	 	  - dans le cas d'un objet SPIP comme un article d'id x, l'argument est un tableau associatif à deux index,
 *          `objet` et `id_objet`.
 * @param string       $bloc
 * 		  Bloc de page au sens Z.
 * @param array        $noisette
 *        Tableau descriptif d'une noisette contenant à minima son type et son id.
 *
 * @return string
 */
function conteneur_noizetier_composer($page_ou_objet, $bloc, $noisette=array()) {

	$conteneur = array();

	// Construction du tableau associatif canonique du conteneur.
	if (!empty($noisette['type_noisette']) and !empty($noisette['id_noisette'])) {
		// Le conteneur est une noisette.
		$conteneur = $noisette;
	} else {
		if (is_array($page_ou_objet)) {
			// Le conteneur est un objet.
			$conteneur = $page_ou_objet;
			$conteneur['squelette'] = "${bloc}/{$page_ou_objet['objet']}";
		}
		else {
			// Le conteneur est une page ou une composition.
			$conteneur['squelette'] = "${bloc}/${page_ou_objet}";
		}
	}

	// Calcul de l'identifiant du conteneur. On utilise l'API de N-Core pour traiter aussi le cas
	// des noisettes conteneur et assurer une vérification du conteneur tabulaire.
	include_spip('inc/ncore_conteneur');
	$id_conteneur = conteneur_identifier('noizetier', $conteneur);

	return $id_conteneur;
}

/**
 * Détermine à partir de l'id du conteneur les données propres au noiZetier, à savoir, la page, l'objet ou la noisette
 * conteneur concernée.
 * Le tableau ainsi produit peut-être fourni aux autorisations concernant la manipulation des pages du noiZetier.
 *
 * @api
 *
 * @uses page_noizetier_extraire_type()
 * @uses page_noizetier_extraire_composition()
 * @uses type_noisette_localiser()
 *
 * @param string $id_conteneur
 *        Identifiant du conteneur sous forme de chaine unique.
 *
 * @return array
 */
function conteneur_noizetier_decomposer($id_conteneur) {

	// Construction du tableau associatif propre au noizetier contenant les éléments
	// d'un conteneur mais aussi les éléments propres au noiZetier comme la page,
	// la composition, le type, l'objet ou la noisette conteneur

	// -- On commence d'abord par contruire le conteneur canonique avec le service de N-Core.
	include_spip('inc/ncore_conteneur');
	$conteneur = conteneur_construire('noizetier', $id_conteneur);

	if (count($conteneur) == 1) {
		// C'est une page ou une composition : l'index squelette est le seul initialisé
		// -- Page et bloc
		list($bloc, $page) = explode('/', $conteneur['squelette']);
		$conteneur['bloc'] = $bloc;
		$conteneur['page'] = $page;
		// -- Type et composition
		include_spip('inc/noizetier_page');
		$conteneur['type'] = page_noizetier_extraire_type($conteneur['page']);
		$conteneur['composition'] = page_noizetier_extraire_composition($conteneur['page']);
	} else {
		if (!empty($conteneur['id_noisette'])) {
			// C'est une noisette conteneur : les index type de noisette et id_noisette sont initialisés.
			// -- le squelette
			include_spip('ncore_fonctions');
			$conteneur['squelette'] = type_noisette_localiser('noizetier', $conteneur['type_noisette']);
			// -- les éléments du conteneur de la noisette parent utiles pour les autorisations
			$select = array('type', 'composition', 'objet', 'id_objet', 'bloc');
			$where = array('id_noisette=' . $conteneur['id_noisette']);
			$noisette = sql_fetsel($select, 'spip_noisettes', $where);
			if ($noisette['type']) {
				$conteneur['type'] = $noisette['type'];
				$conteneur['composition'] = $noisette['composition'];
				$conteneur['page'] = $noisette['composition']
					? $noisette['type'] . '-' . $noisette['composition']
					: $noisette['type'];
			} else {
				$conteneur['objet'] = $noisette['objet'];
				$conteneur['id_objet'] = $noisette['id_objet'];
			}
			$conteneur['bloc'] = $noisette['bloc'];
		}
		else {
			// C'est un objet : le squelette, le type d'objet et son id sont déjà initialisés
			// -- le bloc
			list($bloc, ) = explode('/', $conteneur['squelette']);
			$conteneur['bloc'] = $bloc;
		}
	}

	return $conteneur;
}

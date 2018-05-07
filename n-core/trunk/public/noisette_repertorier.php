<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function balise_NOISETTE_REPERTORIER_dist($p) {

	// Récupération des arguments.
	// -- la balise utilise toujours le rangement par rang au sein du conteneur
	// -- et ne permet pas de filtrer les noisettes autrement que sur le conteneur.
	$plugin = interprete_argument_balise(1, $p);
	$plugin = isset($plugin) ? str_replace('\'', '"', $plugin) : '""';
	$conteneur = interprete_argument_balise(2, $p);
	$conteneur = isset($conteneur) ? str_replace('\'', '"', $conteneur) : '""';
	$stockage = interprete_argument_balise(3, $p);
	$stockage = isset($stockage) ? str_replace('\'', '"', $stockage) : '""';

	// On appelle la fonction de calcul de la liste des noisette
	$p->code = "calculer_liste_noisettes($plugin, $conteneur, $stockage)";

	return $p;
}

function calculer_liste_noisettes($plugin, $conteneur, $stockage) {

	include_spip('inc/ncore_noisette');
	$noisettes = noisette_repertorier($plugin, $conteneur, 'rang_noisette', array(), $stockage);

	return $noisettes;
}
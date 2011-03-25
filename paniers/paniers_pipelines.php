<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

// Supprimer tous les paniers en cours qui sont trop vieux
function paniers_optimiser_base_disparus($flux){
	include_spip('inc/config');
	// On cherche la date depuis quand on a le droit d'avoir fait le panier
	$depuis_ephemere = date('Y-m-d H:i:s', time() - lire_config('paniers/limite_ephemere', 24*3600));
	$depuis_enregistres = date('Y-m-d H:i:s', time() - lire_config('paniers/limite_enregistres', 7*24*3600));
	
	// Soit le panier est à un anonyme donc on prend la limite éphémère, soit le panier appartient à un auteur et on prend l'autre limite
	$nombre = intval(sql_delete(
		'spip_paniers',
		'statut = '.sql_quote('encours').' and ((id_auteur=0 and date<'.sql_quote($depuis_ephemere).') or (id_auteur>0 and date<'.sql_quote($depuis_enregistres).'))'
	));
	
	$flux['data'] += $nombre;
}

?>

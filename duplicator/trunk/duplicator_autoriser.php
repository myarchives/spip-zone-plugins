<?php

/***************************************************************************\
 * Plugin Duplicator pour Spip 3.0
 * Licence GPL (c) 2010-2014 - Apsulis
 * Duplication de rubriques et d'articles
 *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function duplicator_autoriser(){}

function autoriser_dupliquer($faire, $quoi='', $id=0, $qui=null, $options=null) {
	include_spip('inc/config');
	
	// S'il y a une autorisation explicite dans la configuration, on l'utilise
	if ($autorisation = lire_config("duplication/$quoi/autorisation")) {
		if ($autorisation == 'webmestre') {
			return autoriser('webmestre', $quoi, $id, $qui, $options);
		}
		elseif ($autorisation == 'administrateur') {
			return $qui['statut'] <= '0minirezo' and !$qui['restreint'];
		}
		elseif ($autorisation == 'redacteur') {
			return $qui['statut'] <= '1comite';
		}
	}
	// Sinon on cherche une autorisation logique par défaut, de création ou de création dans un parent
	else {
		// TODO ici une recherche du parent et appel d'autorisation de "creerpatatedans"
		return true;
	}
	
	return false;
}

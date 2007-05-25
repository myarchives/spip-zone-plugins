<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2007                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *  as original founders of spip                                           *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return; // securiser

if (!function_exists('generer_url_article')) { // si la place n'est pas prise
/*
Fonctionnement défaut: query string : http://mon.site.tld/?titre-de-l-objet
Rien a faire

Pour fonctionner en mode url sans ? : http://mon.site.tld/titre-de-l-objet
 recopiez le fichier "htaccess.txt" du repertoire du plugin dans le
 repertoire de base du site SPIP sous le nom ".htaccess"
 (attention a ne pas ecraser d'autres reglages
 que vous pourriez avoir mis dans ce fichier) 
Si votre site est en "sous-repertoire",
 vous devrez aussi editer la ligne "RewriteBase" ce fichier.
Les URLs definies seront alors redirigees vers les fichiers de SPIP.

Definissez ensuite dans ecrire/mes_options.php :
	< ?php 	define ('_debut_urls_propres', ''); ? >
 ou configurez grace a cfg ecrire/?exec=cfg&cfg=urls_libres (methode conseillee)
*/
	// config cfg ?
	(function_exists('lire_config') && $cfg = lire_config('urls_libres')) ||
	($cfg = array('mode_direct' => '', 'term_html' => '', 'debut_url' => '', 'fin_url' => ''));
spip_log($cfg, 'mon');
	// pour compatibilite
	define('_terminaison_urls_propres', $cfg['fin_url'] . ($cfg['term_html'] ? '.html' : ''));
	define('_debut_urls_propres',
	 (!$cfg['mode_direct'] && strpos($cfg['debut_url'], '?') === false ? '?' : '')
	 	. $cfg['debut_url']);

	// constantes non incluses dans l'url libre stockee
	define('_terminaison_urls_libres', _terminaison_urls_propres);
	if (($pos = strpos(_debut_urls_propres, '?')) !== false) {
		define('_debut_urls_libres', substr(_debut_urls_propres, $pos + 1));
		define('_qs_urls_libres', substr(_debut_urls_propres, 0, $pos + 1));
	} else {
		define('_debut_urls_libres', _debut_urls_propres);
		define('_qs_urls_libres', '');
	}

	include_spip('urls/urls_libres_recuperer');
	include_spip('urls/urls_libres_generer');
}
?>

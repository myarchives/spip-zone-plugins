<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2019                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/**
 * Action pour exécuter accelerer_jobs de manière asynchrone si le serveur le permet
 *
 * @package SPIP\Core\Genie
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Url pour lancer l'accélération des jobs de manière asynchrone si le serveur le permet

 * @param string $args  parm de l'action
 *
 * @see action_super_cron_dist() Dont une partie du code est repris ici avec le fix https://core.spip.net/issues/4345
 * @see queue_affichage_cron() Dont une partie du code est repris ici.
 * @see action_cron() URL appelée en asynchrone pour excécuter le cron
 */
function action_accelerer_jobs_async_dist($args=null) {
	if (is_null ($args)) {
		$securiser_action = charger_fonction ('securiser_action', 'inc');
		$args = $securiser_action();
	}
	list ($function, $nb) = explode ('/', $args);

	// on lance le cron via un socket en asynchrone avec fsockopen
	if (!function_exists('fsockopen')) {
		spip_log ('accelerer_mails_async : manque fsockopen', 'erreur_accelerer_mail');
		exit; // sinon faudrait lancer via un CURL asynchrone si CURL est présent
	}

	$url = generer_url_action('accelerer_jobs');

	// si nécessaire, pour être certain de régulièrement passer un cache agressif (varnish ou autre)
	// _SUPER_CRON_DELAIS vaut 1 ou le délai mini en sec. avec lequel on veut s'assurer d'outrepercer les caches
	if (defined('_SUPER_CRON_DELAIS')) {
		$t = intval(time()/_SUPER_CRON_DELAIS);
		$url = parametre_url($url, 't', $t);
	}

	spip_log("accelerer_jobs_async fsockopen url $url", 'accelerer_jobs');
	$parts = parse_url($url);

	$host_protocol = '';
	if (substr($url, 0, 5) == 'https') {
		if (empty($parts['port'])) {
			$parts['port'] = 443;
		}
		$host_protocol = 'ssl://';
	}
	elseif (empty($parts['port'])) {
		$parts['port'] = 80;
	}

	$fp = fsockopen(
		$host_protocol.$parts['host'],
		$parts['port'],
		$errno,
		$errstr,
		30
	);
	if ($fp) {
		$out = 'GET ' . $parts['path'] . '?' . $parts['query'] . " HTTP/1.1\r\n";
		$out .= 'Host: ' . $parts['host'] . "\r\n";
		$out .= "Connection: Close\r\n\r\n";
		fwrite($fp, $out);

		$response = fgets($fp, 4096);
		$statut = substr($response, 9, 3);
		// Généralement 204 : OK + pas de retour et rien à faire
		spip_log ("Statut '$statut' pour fsockopen $url", 'accelerer_jobs');
		if (substr ($response, 9, 1) != '2') {
			spip_log ("Statut '$statut' pour fsockopen $url\n$response...", 'erreur_accelerer_jobs');
		}
		fclose($fp);
		return;
	} else {
		spip_log("echec fsockopen pour accelerer_jobs_async pour $url - ".$host_protocol.$parts['host']." : errno=$errno errstr=$errstr ", 'erreur_accelerer_jobs');
	}
	return;
}

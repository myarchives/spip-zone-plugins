<?php
/*
 * Plugin Job Queue
 * (c) 2009 Cedric&Fil
 * Distribue sous licence GPL
 *
 */

/**
 * Url pour lancer le cron de manière asynchrone si le serveur
 * le permet
 *
 * On se base sur le même code que celui du pipeline affichage final
 *
 * Cette fonction est utile pour être appelée depuis un cron UNIX par exemple
 * car elle retourne tout de suite
 *
 * Exemple de tache cron Unix pour un appel toutes les minutes :
 * "* * * * * curl  http://www.mondomaine.tld/spip.php?action=super_cron"
 */
function action_super_cron_dist(){
	// Si fsockopen est possible, on lance le cron via un socket
	// en asynchrone
	if(function_exists('fsockopen')){
		$url = generer_url_action('cron');
		$parts=parse_url($url);
		$fp = fsockopen($parts['host'],
	        isset($parts['port'])?$parts['port']:80,
	        $errno, $errstr, 30);
		if ($fp) {
	    	$out = "GET ".$url." HTTP/1.1\r\n";
    		$out.= "Host: ".$parts['host']."\r\n";
    		$out.= "Connection: Close\r\n\r\n";
			fwrite($fp, $out);
			fclose($fp);
			return;
		}
	}
	// ici lancer le cron par un CURL asynchrone si CURL est présent
	// TBD

	return;
}
?>
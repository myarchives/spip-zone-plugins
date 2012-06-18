<?php
/**
 * SPIPmotion
 * Gestion de l'encodage et des métadonnées de vidéos directement dans spip
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 * 2008-2012 - Distribué sous licence GNU/GPL
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function inc_spipmotion_encodage_direct_dist(){
	/**
	 * Si on a fsockopen
	 * On essaie de relancer un encodage directement
	 * On force l'execution comme étant publique
	 */
	if(function_exists('fsockopen')){
		spip_log('Appel de spipmotion_encoder en fsokopen ','spipmotion');
		$url = generer_url_action('spipmotion_encoder','','',true);
		$parts=parse_url($url);
		$fp = fsockopen($parts['host'],
	        isset($parts['port'])?$parts['port']:80,
	        $errno, $errstr, 30);
		if ($fp) {
	    	$out = "GET ".$parts['path']."?".$parts['query']." HTTP/1.1\r\n";
    		$out.= "Host: ".$parts['host']."\r\n";
    		$out.= "Connection: Close\r\n\r\n";	
			fwrite($fp, $out);
			fclose($fp);
		}else{
			spip_log('fsockopen ne semble pas fonctionner','spipmotion');
		}
	}else{
		spip_log('fsockopen ne semble pas disponible','spipmotion');
	}
	return;
}

?>
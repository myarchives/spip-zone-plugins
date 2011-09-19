<?php

define('_DIR_JQUERYUI_JS',_DIR_PLUGIN_JQUERYUI.'javascript/jquery-ui-1.8.16/ui/');
define('_DIR_JQUERYUI_CSS',_DIR_PLUGIN_JQUERYUI.'javascript/jquery-ui-1.8.16/themes/');

/**
 * Fonction pour lister les ss-repertoires de themes/ de jQuery UI
 * retourne: array('rep1'=>'rep1','rep2'=>'rep2',...'no_css'=>'ne pas charger les CSS...')
 * 
 */ 
function jqueryui_array_themes() {
	$Tthemes = array();
    if ($pointeur = opendir('../'._DIR_JQUERYUI_CSS)) {  
        while (false !== ($rep = readdir($pointeur))) {
            if ($rep != "." AND $rep != ".." AND is_dir('../'._DIR_JQUERYUI_CSS.$rep)) {
                $Tthemes[$rep] = $rep;
            }
        }
        closedir($pointeur);
    }
    if(!defined('_JQUERYUI_FORCER_CSS'))
    	$Tthemes['no_css'] = _T('jqueryui:cfg_no_css');
    
	return $Tthemes;
}

?>
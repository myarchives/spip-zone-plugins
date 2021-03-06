<?php
/**
 * @name 		Options
 * @author 		Piero Wbmstr <@link piero.wbmstr@gmail.com>
 * @copyright 	CreaDesign 2009 {@link http://creadesignweb.free.fr/}
 * @license		(c) 2009 GNU GPL v3 {@link http://opensource.org/licenses/gpl-license.php GNU Public License}
 * @version 	1.0 (10/2009)
 * @package		Javascript_Scroller
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

// chemin du plugin (vieilles versions)
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_JS_SCROLLER',(_DIR_PLUGINS.end($p)));

// Displayer XML
define('_JS_SCROLLER_XML', $GLOBALS['meta']['adresse_site'].'/?page=content_scroller');

// Fichier CSS surchargable dans le repertoire squelettes
define('_JS_SCROLLER_CSS', 'js_scroller.css');
//define('_JS_SCROLLER_CSS', 'js_scroller_spip3.css'); // styles homogenes dist SPIP3

// Valeurs par défaut :
$GLOBALS['js_scroller_defauts'] = array(
	'items_separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
	'description_separator' => ' | ',
	'speed' => '3',
);

?>
<?php
#----------------------------------------------------------#
#  Plugin  : spipbb - Licence : GPL                        #
#  File    : inc/spipbb_common                             #
#  Authors : Chryjs, 2007 et als                           #
#  http://www.spip-contrib.net/Plugin-SpipBB#contributeurs #
#  Contact : chryjs!@!free!.!fr                            #
# [fr] Fonction et définitions essentielles du plugin      #
# [en] Functions and data required for this plugin         #
#----------------------------------------------------------#

//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

if (!defined("_ECRIRE_INC_VERSION")) return;
// [fr] Protection contre les inclusions multiples (ne devrait jamais arriver)
// [en] Protects against multiples includes (should never occur)
if (defined("_INC_SPIPBB_COMMON")) return; else define("_INC_SPIPBB_COMMON", true);

spipbb_log('included',2,__FILE__);

// Default log level
define('_SPIPBB_LOG_LEVEL',3);

// Numero de version de spip_version_code pour les differentes comparaisons et inclusions
define('_SPIPBB_REV_AJAXCONFIG','1.9250'); // Introduction du repertoire configuration/ avec fonctions ajax_... SVN 9080/9081 ->9134
define('_SPIPBB_REV_STYLISER','1.9250'); // Evolution de public/styliser (SVN 9918 ?)
define('_SPIPBB_REV_REQSQL','1.9259'); // trace_query_start apparus en SVN 9932 -> version_code 1.9259/1.9260
define('_SPIPBB_REV_SQL','1.9260'); // Changement pour les fonctions SQL (abstract) SVN 9919 -> 9955
define('_SPIPBB_REV_BALISE_SESSION','1.9262'); // Ajout de la balise SESSION SVN 10124/10130 -> 10132
define('_SPIPBB_REV_TABLE_AUTRUB','1.9270'); // Passage auteurs_rubriques en table principale
define('_SPIPBB_REV_EDITER_ARTRUB','1.9300'); // Suppression de la fonction editer_article_rubrique SVN 10818

// Cron SPIP
define('_SPIPBB_DELAIS_CRON', 1 * 30 ); // toutes les 30 sec

// Pour les migrations
define('_SPIPBB_STATUT_ABONNE', '6forum' ); // Statut par défaut d'un nouveau membre lors d'une migration
define('_SPIPBB_IMPORT_TEST','oui'); // Par defaut import a blanc

// Petit controle de definition generale
if (!defined('_DIR_PLUGIN_SPIPBB')) {
	$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
	define('_DIR_PLUGIN_SPIPBB',(_DIR_PLUGINS.end($p))."/");
	spipbb_log('_DIR_PLUGIN_SPIPBB undef redef:'._DIR_PLUGIN_SPIPBB,1,__FILE__);
}

// [fr] Plugin ecrit pour spip rev 1.9.3 -> fournir les fonctions requises pour spip 1.9.2
// [en] Plugin written for spip rev 1.9.3 -> provide required functions for spip 1.9.2
if (version_compare(substr($GLOBALS['spip_version_code'],0,6),_SPIPBB_REV_SQL,'<')) {
	include_spip('inc/spipbb_192'); // SPIP 1.9.2
}

//----------------------------------------------------------------------------
// [fr] Genere une trace pour spipbb sauf si on ne veut pas de log
// [fr] pour cela mettre : define('_SPIPBB_LOG_LEVEL',0); dans spipbb_options.php
// [en] Log for spipbb except if we don't want logs
// [en] in this case just put: define('_SPIPBB_LOG_LEVEL',0); in spipbb_options.php
// [en] log_level : 0 none
// [en] log_level : 1 low
// [en] log_level : 2 medium
// [en] log_level : 3 high (very verbose)
//----------------------------------------------------------------------------
function spipbb_log($message='',$log_level=1,$obsolete_prefix="") {

	if (defined('_SPIPBB_LOG_LEVEL')) $spipbb_log_level=_SPIPBB_LOG_LEVEL;
	else $spipbb_log_level=1;

	if ($log_level<=$spipbb_log_level) {
		if (function_exists('debug_backtrace')) { // dispo a partir de PHP 4.3
			// on prefixe avec l'appelant
			$bt=debug_backtrace();
			$message = $bt[0]['file'].":".$bt[1]['function']."():".$message;
		}
		else $message=$obsolete_prefix.":".$message;

		// c: 23/2/8 on ne peut pas utiliser spip_log suite a sa limitation arbitraire a 100 ...
		//spip_log($message,'spipbb');
		$logname = 'spipbb';

		$pid = '(pid '.@getmypid().')';

		// accepter spip_log( Array )
		if (!is_string($message)) $message = var_export($message, true);

		$message = date("M d H:i:s").' '.$GLOBALS['ip'].' '.$pid.' '
			.preg_replace("/\n*$/", "\n", $message);

		$logfile = _DIR_TMP . $logname . '.log';
		if (@is_readable($logfile)
		AND (!$s = @filesize($logfile) OR $s > 10*1024)) {
			$rotate = true;
			$message .= "[-- rotate --]\n";
		} else $rotate = '';
		$f = @fopen($logfile, "ab");
		if ($f) {
			fputs($f, htmlspecialchars($message));
			fclose($f);
		}
		if ($rotate) {
			@unlink($logfile.'.9');
			@rename($logfile.'.8',$logfile.'.9');
			@rename($logfile.'.7',$logfile.'.8');
			@rename($logfile.'.6',$logfile.'.7');
			@rename($logfile.'.5',$logfile.'.6');
			@rename($logfile.'.4',$logfile.'.5');
			@rename($logfile.'.3',$logfile.'.4');
			@rename($logfile.'.2',$logfile.'.3');
			@rename($logfile.'.1',$logfile.'.2');
			@rename($logfile,$logfile.'.1');
		}
		// doit on dupliquer dans le log general ? inutile...

	} // should we log ?

} // spipbb_log

?>

<?php
/**
 * Plugin générique de configuration pour SPIP
 *
 * @license    GNU/GPL
 * @package    plugins
 * @subpackage cfg
 * @category   outils
 * @copyright  (c) toggg, marcimat 2007-2008
 * @link       https://contrib.spip.net/
 * @version    $Id$
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 *
 * @param string $champ
 * @param Object $cfg
 * @return string
 */
function cfg_verifier_type_id($champ, &$cfg){
	if (!preg_match('#^[a-z_]\w*$#', $cfg->val[$champ])){
		$cfg->ajouter_erreur(_T('cfg:erreur_type_id', array('champ'=>$champ)));
	}
	return true;
}

?>

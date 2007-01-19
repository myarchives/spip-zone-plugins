<?php
/* etend la balise #CONFIG 
 *
 *  cfg plugin for spip (c) toggg 2007 -- licence LGPL
 */

//
// #CONFIG etendue dynamique interpretant les /
//
// Par exemple #CONFIG{xxx/yyy/zzz} fait comme #CONFIG{xxx}['yyy']['zzz']
// xxx etant un tableau serialise dans spip_meta comme avec exec=cfg&cfg=montruc
// Le 2eme argument de la balise est la valeur defaut comme pour la dist
//
function balise_CONFIG($p) {
	if (!$arg = interprete_argument_balise(1,$p)) $arg="''";
	$sinon = interprete_argument_balise(2,$p);
	$p->code = 'lire_config(' . $arg . ',1)';
	if ($sinon AND $sinon != "''")
		$p->code = 'sinon(' . $p->code .','.$sinon.')';
	return $p;
}

// lire_cfg() permet de recuperer une config depuis le php
// $cfg: la config, lire_cfg('montruc') est un tableau
// lire_cfg('montruc/sub') est l'element "sub" de cette config
// $def: un defaut optionnel
function lire_config($cfg='', $serialize=false) {
	$config = $GLOBALS['meta'];
	$cfg = explode('/', $cfg);

	while ($x = array_shift($cfg)) {
		if (is_string($config) && is_array($c = @unserialize($config)))
			$config = $c[$x];
		else
			$config = $config[$x];
	}

	// transcodage vers le mode serialize
	if ($serialize && is_array($config))
		return serialize($config);
	// transcodage vers le mode non serialize
	if (!$serialize && ($c = @unserialize($config)))
		return $c;
	// pas de transcodage
	return $config;
}

?>

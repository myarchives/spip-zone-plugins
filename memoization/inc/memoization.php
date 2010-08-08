<?php

# xcache ?

if (function_exists('cache_set')) {
	@define('_MEMOIZE', '??');
} elseif (function_exists('xcache_set')) {
	@define('_MEMOIZE', 'xcache');
	require_once dirname(dirname(__FILE__)).'/memo/xcache.inc';
} elseif (function_exists('eaccelerator_put')) {
	@define('_MEMOIZE', 'eaccelerator');
	require_once dirname(dirname(__FILE__)).'/memo/eaccelerator.inc';
} else {
	@define('_MEMOIZE', 'filecache');
	require_once dirname(dirname(__FILE__)).'/memo/filecache.inc';
}

//
// Cache a function's result cache_me()
// (c) Fil 2009 - Double-licensed under the GNU/LGPL and MIT licenses
// http://zzz.rezo.net/-SPIP-
// $ttl = time to live
// $vars = other variables that could change the result
// (the function's variables are automatically taken into account)
//
// Usage: include_spip('inc/memoization');
// In any cacheable function add at top:
// if(!is_null($c=cache_me())) return$c;
if (!function_exists('debug_backtrace')) {
	function cache_me() {return;}
} else {
	function cache_me($vars=null, $ttl=3600) {
		$trace = debug_backtrace();
		$trace = $trace[1];
		if (isset($trace['object']))
			$fun = array($trace['object'], $trace['function']);
		else
			$fun = $trace['function'];
		$key = md5(
			$fun
			.serialize($trace['args'])
			.serialize($vars)
		);
		if (!cache_isset($key)) {
			cache_set($key, null, $ttl);
			$r = call_user_func_array($fun, $trace['args']);
			cache_set($key, $r, $ttl);
			return $r;
		}
		return cache_get($key);
	}
}

?>

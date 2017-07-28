<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de https://trad.spip.net/tradlang_module/memoization?lang_cible=en
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// C
	'cfg_description' => 'Memoization. This configuration page is reserved for the webmaster.',
	'cfg_titre' => 'Memoization',

	// E
	'explication_memcache_servers' => 'indicate a server line, as <kbd>host:port</kbd>',
	'explication_redis_serveur' => 'indicate a server, as <kbd>host:port</kbd>',
	'explication_redis_sock' => 'the path to a unix domain socket',
	'explications_redis_auth' => 'authenticate the connection using a password',
	'explication_redis_dbindex' => 'change the selected database',
	'explication_redis_serializer' => 'Serialization / deserialization method. CAUTION emptying the cache in case of change',

	// I
	'info_taille_cache_inconnue' => '@methode@ method doesn’t allow to know the size of the cache.',
	'invalider_cache' => 'Delete cache',

	// L
	'label_cache_pages' => 'Manage the page cache',
	'label_memcache_serveurs' => 'Memcache server(s) :',
	'label_methode' => 'Select the memoization mode',
	'legend_cache_methode' => 'Memoization method',
	'legend_cache_pages' => 'Page cache',
	'legend_memcache' => 'Memcache settings',
	'lien_administration_memcache' => 'Manage memcache',
	'legend_redis' => 'Redis parameters',

	// M
	'memcached_donnes' => 'Data of your server memcached',
	'memcached_script' => 'Script memcache.php by <a href="http://livebookmark.net">Harun Yayli</a>',
	'memcached_serveur' => 'Server memcached',
	'methodes_cache' => 'The page cache is managed by the method @type@',
	'methodes_grisees' => 'Greyed-out methods are not available on this server',

	// O
	'option_methode_apc' => 'APC',
	'option_methode_defaut' => 'Auto-detection',
	'option_methode_eaccelerator' => 'EAccelerator',
	'option_methode_filecache' => 'Files (filecache)',
	'option_methode_memcache' => 'Memcache',
	'option_methode_nocache' => 'Disabled (nocache)',
	'option_methode_xcache' => 'XCache',

	// R
	'redis_serveur' => 'Server:',
	'redis_sock' => 'Unix socket:',
	'redis_auth' => 'Password:',
	'redis_dbindex' => 'Database:',
	'redis_type_serveur' => 'Server',
	'redis_type_sock' => 'Unix Socket',
	'redis_serializer' => 'Serialization:',

	// T
	'taille_tototale_indisponible' => 'Total size not available'
);

<?php
/**
 * Plugin Lecteur (mp3)
 * Licence GPL
 * 2007-2011
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Code JS a inserer dans la page pour faire fonctionner le player
 * @param $player
 * @return string
 */
function player_call_js($player) {
	$flux = "\n"
		. "<!-- Player JS -->\n"
		. '<script type="text/javascript" src="'.find_in_path('soundmanager/soundmanager2.js').'"></script>'
		. '<script type="text/javascript"><!--' . "\n"
		. 'var musicplayerurl="' . find_in_path('flash/' . $player . '.swf') . '";'."\n"
		. "var key_espace_stop = true;\n"
		. 'var image_play="'.find_in_path('images/playl.gif').'";'."\n"
		. 'var image_pause="'.find_in_path('images/pausel.gif').'";'."\n"
		. 'soundManager.url = "'.find_in_path('soundmanager/soundmanager2.swf').'";'."\n"
  	. 'soundManager.nullURL = "'.find_in_path('soundmanager/null.mp3').'";'."\n"
		. 'var videoNullUrl = "null.flv";'."\n"
		. 'var DIR_PLUGIN_PLAYER = "' . _DIR_PLUGIN_PLAYER . '";'
		. "//--></script>\n"
		. '<script type="text/javascript" src="'._DIR_PLUGIN_PLAYER.'javascript/jscroller.js"></script>'."\n"
		. '<script type="text/javascript" src="'._DIR_PLUGIN_PLAYER.'player_enclosure.js"></script>'."\n"
		;
	return $flux;
}

/**
 * Code CSS a inserer dans la page pour habiller le player
 * @return string
 */
function player_call_css() {
	$flux = "\n".'<link rel="stylesheet" href="'.direction_css(find_in_path('player.css')).'" type="text/css" media="all" />';
	return $flux;
}

/**
 * inserer systematiquement le CSS dans la page
 * @param string $flux
 * @return string
 */
function player_insert_head_css($flux){
	if (test_espace_prive()
		OR (!defined('_PLAYER_AFFICHAGE_FINAL') OR !_PLAYER_AFFICHAGE_FINAL))
		$flux .= player_call_css();

	return $flux;
}

/**
 * Inserer systematiquement le JS dans la page
 * @param string $flux
 * @return string
 */
function player_insert_head($flux){
	if (test_espace_prive()
		OR (!defined('_PLAYER_AFFICHAGE_FINAL') OR !_PLAYER_AFFICHAGE_FINAL)){
		$player = unserialize($GLOBALS['meta']['player']);
		$player = isset($player['player_mp3'])?$player['player_mp3']:'eraplayer';
		$flux .= player_call_js($player);
	}
	return $flux;
}


/**
 * Inserer JS+CSS dans la page si elle contient un player
 * (a la demande)
 * @param string $flux
 * @return string
 */
function player_affichage_final($flux){
	if (defined('_PLAYER_AFFICHAGE_FINAL') AND _PLAYER_AFFICHAGE_FINAL){
		// inserer le head seulement si presente d'un rel='enclosure'
		if ((strpos($flux,'rel="enclosure"')!==FALSE)){
			$player = unserialize($GLOBALS['meta']['player']);
			$player = isset($player['player_mp3'])?$player['player_mp3']:'eraplayer';
			$ins = player_call_css();
			$ins .= player_call_js($player);

			$p = stripos($flux,"</head>");
			if ($p)
				$flux = substr_replace($flux,$ins,$p,0);
			else
				$flux .= player_head();
		}
	}
	return $flux;
}


/**
 * enclosures
 * ajout d'un rel="enclosure" sur les liens mp3 absolus
 * appele en pipeline apres propre pour traiter les [mon son->http://monsite/mon_son.mp3]
 * peut etre appele dans un squelette apres |liens_absolus
 *
 * @param $texte
 * @return mixed
 */
function player_post_propre($texte) {

	$reg_formats="mp3";

	$texte = preg_replace(
		",<a(\s[^>]*href=['\"]?(http:\/\/[a-zA-Z0-9\s()\/\:\._%\?+'=~-]*\.($reg_formats))['\"]?[^>]*)>(.*)</a>,Uims",
		'<a$1 rel="enclosure">$4</a>', 
		$texte);
	
	return $texte;
}

/**
 * Un filtre pour afficher de joli titre a partir du nom du fichier
 * @param $titre
 * @return mixed|string
 */
function joli_titre($titre){
	$titre=basename($titre);
	$titre=preg_replace('/.mp3/','',$titre);
	$titre=preg_replace('/^ /','',$titre);
	$titre = preg_replace("/_/i"," ", $titre );
	$titre = preg_replace("/'/i"," ",$titre );

	return $titre ;
}
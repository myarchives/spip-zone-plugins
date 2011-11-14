<?php
/**
 * Plugin oEmbed
 * Licence GPL3
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

function oembed_posttraite_slideshare_rich_dist($data){

	if (!isset($data['thumbnail_url']) AND isset($data['thumbnail'])){
		$data['thumbnail_url'] = _DIR_RACINE . copie_locale($data['thumbnail']);
	}

	return $data;
}
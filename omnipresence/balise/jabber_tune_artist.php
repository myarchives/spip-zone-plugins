<?php
include_spip('inc/omnipresence');

function balise_JABBER_TUNE_ARTIST($p) {
	return calculer_balise_dynamique($p, 'JABBER_TUNE_ARTIST', array(CHAMP_JID, CHAMP_SERVEUR_OMNIPRESENCE));
}

function balise_JABBER_TUNE_ARTIST_stat($args, $filtres) {
	return array(
		isset($args[2]) ? $args[2] : $args[0],
		$args[1],
	);
}

function balise_JABBER_TUNE_ARTIST_dyn($jid, $host) {
	return demander_action('pep/tune/artist.txt', $jid, $host);
}
?>

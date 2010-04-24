<?php
function formulaires_sauvegarder_savecfg_charger() {
	$fond = _request('cfg');
	$valeurs = array(
		'nom' => $fond,
	);
	return $valeurs;
}
function formulaires_sauvegarder_savecfg_verifier(){
	$erreurs = array();
	if (strlen(_request('titre')) < 1)
		$erreurs['message_erreur'] = _T('spip:info_obligatoire');
	return $erreurs;
}
function formulaires_sauvegarder_savecfg_traiter() {
	$fond = _request('fond');
	if (sql_countsel('spip_meta', 'nom='.sql_quote($fond)) == 1) {
		$sfg = sql_getfetsel('valeur', 'spip_meta', 'nom='.sql_quote($fond));

		include_spip('inc/sauvegarder_savecfg');
		$message = sauvegarder_savecfg($fond, _request('titre'), $sfg);
	} else {
		$message = _T('savecfg:sauvegarde_pas_ok');
	}
	return $message;
}
?>
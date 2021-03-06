<?php
/**
 * SPIP-Lettres
 *
 * Copyright (c) 2006-2009
 * Agence Artégo http://www.artego.fr
 *
 * Ce programme est un logiciel libre distribue sous licence GNU/GPLv3.
 * Pour plus de details voir http://www.gnu.org/licenses/gpl-3.0.html
 *
 **/
if (!defined("_ECRIRE_INC_VERSION")) return;


include_spip('lettres_fonctions');


/**
 * action_clic
 *
 * @author Pierre BASSON
 **/
function action_clic() {

	$id_clic = intval(_request('id_clic'));
	$email = _request('email');
	$code = _request('code');

	if ($email and lettres_verifier_validite_email($email)) {
		$abonne = new abonne(0, $email);
		if ($abonne->existe and $abonne->verifier_code($code) and !empty($id_clic)) 
			$redirection = $abonne->enregistrer_clic($id_clic);
	} elseif ($GLOBALS['meta']['spip_lettres_cliquer_anonyme']=='oui') {
		$abonne = new abonne(0, "edgard@spip.rob"); 		// encore lui
		$redirection = $abonne->enregistrer_clic($id_clic);
	} else
		$redirection = redirection_clic($id_clic);

	include_spip('inc/headers');
	redirige_par_entete($redirection);
}


?>
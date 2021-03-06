<?php
/**
 * @name 		Editer banniere
 * @author 		Piero Wbmstr <@link piero.wbmstr@gmail.com>
 * @license		http://creativecommons.org/licenses/by-nc-sa/3.0/ Creative Commons BY-NC-SA
 * @version 	1.0 (06/2009)
 * @package		Pub Banner
 * @subpackage	Formulaires
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_pubban_editer_banniere_charger($id_empl='new', $retour=''){
	$valeurs = array(
		'titre' => '',
		'width' => '',
		'height' => '',
		'ratio_pages' => '',
		'statut' => '1inactif',
	);
	if( $id_empl != 'new' ) {
		$emp = pubban_recuperer_emplacement($id_empl);
		$valeurs = array_merge($valeurs, $emp);
	}
	return $valeurs;
}

function formulaires_pubban_editer_banniere_verifier($id_empl='new', $retour=''){
	$erreurs = array();
	if(!$titre = _request('titre') OR !strlen($titre)) 
		$erreurs['titre'] = _T('pubban:error_titre_empl');	
	if(!$width = _request('width') OR !$height = _request('height')) 
		$erreurs['dimensions'] = _T('pubban:error_dimensions_missing_empl');	
	elseif(!is_numeric($width) OR !is_numeric($height))
			$erreurs['dimensions'] = _T('pubban:error_dimensions_numeric_empl');
	return $erreurs;
}

function formulaires_pubban_editer_banniere_traiter($id_empl='new', $retour=''){
	include_spip('inc/pubban_process');
	$datas = array(
		'titre' => _request('titre'),
		'width' => pubban_transformer_nombre( _request('width') ),
		'height' => pubban_transformer_nombre( _request('height') ),
		'ratio_pages' => _request('ratio_pages'),
		'statut' => _request('statut'),
	);
	if($id_empl == 'new') {
		$instit_empl = charger_fonction('instituer_emplacement', 'inc');
		if( $id_empl = $instit_empl($datas) )
			$redirect = generer_url_ecrire("pubban_integer","id_empl=$id_empl");
	}
	else {
		$editer_empl = charger_fonction('editer_emplacement', 'inc');
		if ($ok = $editer_empl($id_empl, $datas))
			$redirect = strlen($retour) ? $retour : generer_url_ecrire("pubban_integer","id_empl=$id_empl");
	}
	if($redirect){
		include_spip('inc/headers');
		return( redirige_formulaire($redirect) );
	}
	return array(
		'message_erreur' => _T('pubban:error_global')
	);
}
?>
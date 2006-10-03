<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Pas besoin de contexte de compilation
global $balise_FORMS_collecte;
$balise_FORMS_collecte = array('id_form','id_article');

function balise_FORMS ($p) {
	return calculer_balise_dynamique($p,'FORMS', array('id_form', 'id_article', 'class'));
}

function balise_FORMS_stat($args, $filtres) {
	return $args;
}
 
function balise_FORMS_dyn($id_form = 0, $id_article = 0, $class='', $script_validation = 'valide_form', $message_confirm='forms:avis_message_confirmation',$reponse_enregistree="forms:reponse_enregistree") {
	$url = self();
	// nettoyer l'url qui est passee par htmlentities pour raison de securitÚs
	$url = str_replace("&amp;","&",$url);
	if ($retour=='') $retour = $url;

	$res = spip_query("SELECT * FROM spip_forms WHERE id_form=".spip_abstract_quote($id_form));
	if (!$row = spip_fetch_array($res)) return;
		
	$erreur = array();
	$valide_sondage = '';
	$reponse = '';
	$formok = '';
	$valeurs = array('0'=>'0');
	$affiche_sondage = '';
	$formactif = (_DIR_RESTREINT==_DIR_RESTREINT_ABS)?' ':'';
	
	$flag_reponse = (_request('ajout_reponse') == 'oui' && _request('id_form') == $id_form) && _request('nobotnobot')=='';
	if ($flag_reponse) {
		include_spip('inc/forms');
		$url_validation = Forms_enregistrer_reponse_formulaire($id_form, $erreur, $reponse, $script_validation, $id_article?"id_article=$id_article":"");
		if (!$erreur) {
			$formok = _T($reponse_enregistree);
			if ($reponse)
			  $reponse = _T($message_confirm,array('mail'=>$reponse));
		}
		else {
			// on reinjecte get et post dans $valeurs
			foreach($_GET as $key => $val)
				$valeurs[$key] = interdire_scripts($val);
			foreach($_POST as $key => $val)
				$valeurs[$key] = interdire_scripts($val);
		}
	}
	if ($row['sondage'] == 'public'){
		include_spip('inc/forms');
		if ((Forms_verif_cookie_sondage_utilise($id_form)==true)&&(_DIR_RESTREINT!=""))
			$affiche_sondage=' ';
	}
	return array('formulaires/forms', 0, 
		array(
			'erreur_message'=>isset($erreur['@'])?$erreur['@']:'',
			'erreur'=>serialize($erreur),
			'reponse'=>filtrer_entites($reponse),
			'id_article' => $id_article,
			'id_form' => $id_form,
			'self' => $url,
			'valeurs' => serialize($valeurs),
			'url_validation' => str_replace("&amp;","&",$url_validation),
			'affiche_sondage' => $affiche_sondage,
			'formok' => filtrer_entites($formok),
			'formactif' => $formactif,
			'class' => 'formulaires/'.($class?$class:'forms_structure')
		));
}

?>

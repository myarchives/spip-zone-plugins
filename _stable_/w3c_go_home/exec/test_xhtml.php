<?php
/*
 * valide_site
 *
 * outil de validation w3c et accessibilite du site
 *
 * Auteur : cedric.morin@yterium.com
 * � 2006 - Distribue sous licence GPL
 *
 */

function test_validateur_interne($url){
	$url = str_replace("&amp;","&",$url);
	include_spip('inc/distant');
	$page = recuperer_page($url);
	$transformer_xml=charger_fonction('valider_xml', 'inc');
	$transformer_xml($page, false);
	$erreurs = (strlen($GLOBALS['xhtml_error'])>0);
	
	$texte = "Erreur";
	$ok = false;
	$couleur="cc0000";
	if(!$erreurs){
		$ok = true;
		$couleur="00cc00";
		$texte = "OK";
	}	
	return array($erreurs,$texte,$couleur);
}

function test_validator($url){
	// validation xhtml validator
	$w3cvalidator='http://validator.w3.org/check?uri=%s';
	$urlvalidator=str_replace('%s',urlencode($url),$w3cvalidator);
	include_spip('inc/distant');
	$test = recuperer_page($urlvalidator);
	if ($test!==FALSE){
		if (preg_match('/passed validation/is',$test))
			$erreurs=0;
		else{
			$erreurs=1;
			if (preg_match('/([0-9]*)\s+error[s]?.*/is',$test,$regs))
				$erreurs=intval($regs[1]);
		}
		$texte = "Erreurs : $erreurs";
	}
	else{
		$erreurs=999; // timeout
		$texte = "timeout";
	}

	$ok = false;
	$couleur="cc0000";
	if($erreurs==0){
		$ok = true;
		$couleur="00cc00";
		$texte = "OK";
	}	
	return array($erreurs,$texte,$couleur);
}

function exec_test_xhtml(){
	global $connect_statut,$erreurs;
	$url=urldecode(_request('url'));
	if ($connect_statut != '0minirezo') {
		exit;
	}
	$compliance = isset($GLOBALS['meta']['xhtml_w3c_compliance'])?unserialize($GLOBALS['meta']['xhtml_w3c_compliance']):false;
	if (!$compliance)
		$compliance = array();
	$total_erreurs=0;
	foreach($compliance as $url_verif=>$result)
		$total_erreurs+=$result[0];
	if (($total_erreurs>5)&&(!isset($compliance[$url]))&&($GLOBALS['spip_version_code']<1.9203))
		exit;

	if ($GLOBALS['spip_version_code']<1.9203)
		list($erreurs,$texte,$couleur) = test_validator($url);
	else
		list($erreurs,$texte,$couleur) = test_validateur_interne($url);
	
	// enregistrer dans la meta
	// on recharge d'abord car il y a pu avoir des validations concourantes
	lire_metas();
	$compliance = isset($GLOBALS['meta']['xhtml_w3c_compliance'])?unserialize($GLOBALS['meta']['xhtml_w3c_compliance']):false;
	if (!$compliance)
		$compliance = array();
	$compliance[$url]=array($erreurs,time());
	ecrire_meta('xhtml_w3c_compliance',serialize($compliance));
	ecrire_metas();
	
	include_spip('inc/filtres');
	$img = image_typo($texte, "police=dustismo.ttf","couleur=$couleur", "taille=12");
	$img = extraire_attribut($img,'src');
	header('Content-Type: image/png');
	header('Content-Length: '.filesize($img));
	readfile($img);

}
<?php
/**
 * Plugin MailShot
 * (c) 2012 Cedric Morin
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Afficher partiellement un password que l'on ne veut pas rendre lisible par un champ hidden
 * @param $pass
 * @return string
 */
function mailshot_affiche_password_masque($pass){
	$l = strlen($pass);
	if ($l<=8){
		return str_pad('',$l,'*');
	}
	$e = intval(ceil($l/10));
	$mid = str_pad('',$l-2*$e,'*');
	if (strlen($mid)>8){
		$mid = '***...***';
	}
	return substr($pass,0,$e) . $mid . substr($pass,-$e);
}

/**
 * Inliner du contenu base64 pour presenter les versions de newsletter dans une iframe
 * @param string $texte
 * @param string $type
 * @return string
 */
function mailshot_inline_base64src($texte, $type="text/html"){
	return "data:$type;base64,".base64_encode($texte);
}


/**
 * Trouver l'url de la newsletter si id est numerique, rien sinon
 *
 * @param string|int $id
 * @return string
 */
function mailshot_url_newsletter($id){
	if (!is_numeric($id))
		return "";

	if (!test_plugin_actif("newsletters"))
		return "";

	return generer_url_entite($id,'newsletter');
}

/**
 * Afficher l'avancement de l'envoi
 * @param int $current
 * @param int $total
 * @param int $failed
 * @return string
 */
function mailshot_afficher_avancement($current,$total,$failed=0){
	$out = "$current/$total";
	if ($current == $total){
		$out = "{$total} (100%)";
	}
	if ($failed){
		$out .= " ($failed&nbsp;fail)";
	}
	return $out;
}


/**
 * Puce statut non modifiable (temporaire avec SPIP <=3.0.5)
 * @param $statut
 * @param $objet
 * @param int $id_objet
 * @param int $id_parent
 * @return mixed
 */
function mailshot_puce_statut($statut,$objet,$id_objet=0,$id_parent=0){
	static $puce_statut = null;
	if (!$puce_statut)
		$puce_statut = charger_fonction('puce_statut','inc');
	return $puce_statut($id_objet, $statut, $id_parent, $objet, false, objet_info($objet,'editable')?_ACTIVER_PUCE_RAPIDE:false);
}


?>
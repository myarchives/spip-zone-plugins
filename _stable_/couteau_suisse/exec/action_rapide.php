<?php
#-----------------------------------------------------#
#  Plugin  : Couteau Suisse - Licence : GPL           #
#  Auteur  : Patrice Vanneufville, 2008               #
#  Contact : patrice�.!vanneufville�@!laposte�.!net   #
#  Infos : http://www.spip-contrib.net/?article2166   #
#-----------------------------------------------------#
if (!defined("_ECRIRE_INC_VERSION")) return;

// compatibilite spip 1.9
if(!function_exists(ajax_retour)) { 
	function ajax_retour($corps) {
		$c = $GLOBALS['meta']["charset"];
		header('Content-Type: text/html; charset='. $c);
		$c = '<' . "?xml version='1.0' encoding='" . $c . "'?" . ">\n";
		echo $c, $corps;
		exit;
	}
}

function exec_action_rapide_dist() {
	if (!cout_autoriser()) {
		include_spip('inc/minipres');
		echo defined('_SPIP19100')?minipres( _T('avis_non_acces_page')):minipres();
		exit;
	}
	$arg = _request('arg');
	spip_log("exec 'action_rapide' du Couteau suisse : $arg / "._request('submit'));
//	spip_log($_POST); spip_log($_GET);

	switch ($arg) {

	// forms[0] : tout purger (cas SPIP < 2.0)
	case 'edit_urls_0': // idem edit_urls2_1
	// forms[1] : editer un objet (cas SPIP < 2.0)
	case 'edit_urls_1': // idem edit_urls2_1
	// forms[0] : tout purger (cas SPIP >= 2.0)
	case 'edit_urls2_0': // idem edit_urls2_1
	// forms[1] : editer un objet (cas SPIP >= 2.0)
	case 'edit_urls2_1':
cs_log("INIT : exec_action_rapide_dist() - Preparation du retour par Ajax (donnees transmises par GET)");
		$script = _request('script');
		$outil = _request('outil');
cs_log(" -- outil = $outil - script = $script - arg = $arg");
		if (!preg_match('/^\w+$/', $script)) { echo minipres(); exit; }
		include_spip('inc/cs_outils');
		$res = cs_action_rapide($outil);
cs_log(" FIN : exec_description_outil_dist() - Appel maintenant de ajax_retour() pour afficher la ligne de configuration de l'outil");	
		ajax_retour($res);
		break;

	// renvoie les caracteristiques URLs d'un objet (cas SPIP < 2.0)
	case 'type_urls_spip':
	// renvoie les caracteristiques URLs d'un objet (cas SPIP >= 2.0)
	case 'type_urls_spip2':
		$type = _request('type_objet');
		$trouver_table = charger_fonction('trouver_table', 'base');
		$desc = $trouver_table(table_objet($type));
		$table = $desc['table'];
		$champ_titre = $desc['titre'];
		$col_id =  @$desc['key']["PRIMARY KEY"];
		if (!$col_id) return false; // Quand $type ne reference pas une table
		$id_objet = intval(_request('id_objet'));

		//  Recuperer une URL propre correspondant a l'objet.
		$row = sql_fetsel("U.url, O.$champ_titre", "$table AS O LEFT JOIN spip_urls AS U ON (U.type='$type' AND U.id_objet=O.$col_id)", "O.$col_id=$id_objet", '', '', 1);

		if (!$row) return false; # Quand $id_objet n'est pas un numero connu
		list($champ_titre,) = explode(',', $champ_titre, 2);
		// Calcul de l'URL complete
//		if(defined('_SPIP19300')) 
			$url = generer_url_entite($id_objet, $type, '', '', true); // depuis SPIP 2.0
//			else { charger_generer_url(); $f = "generer_url_$type"; $url = $f($id_objet); } // avant SPIP 2.0
		$row2 = !strlen($url2 = $row['url'])
			// si l'URL n'etait pas presente en base, maintenant elle l'est !
			?sql_fetsel("url", "spip_urls", "id_objet=$id_objet AND type='$type'", '', '', 1)
			:array('url'=>$url2);
		$type = $GLOBALS['type_urls']?$GLOBALS['type_urls']:'page';
		echo $url2.'||'.$row[trim($champ_titre)].'||'.$url.'||'.$type.'||'.$row2['url'];
		break;

	}
}

?>
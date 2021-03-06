<?php
/**
 * Plugin Diogene
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
 *
 * Fonctions spécifiques à Diogene
 *
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Redéfinition de la balise #URL_ARTICLE
 * https://code.spip.net/@balise_URL_ARTICLE_dist
 * 
 * Si l'article n'existe pas ou n'est pas publier, on envoie vers la page publique de publication
 * Pratique pour les liens vers associé à une auteur mais pas encore publiés
 * 
 * @param unknown_type $p
 */
function balise_URL_ARTICLE($p) {
	include_spip('balise/url_');
	// Cas particulier des boucles (SYNDIC_ARTICLES)
	if ($p->type_requete == 'syndic_articles') {
		$code = champ_sql('url', $p);
		$p->code = "vider_url($code)";
	} else{
		$code = generer_generer_url('article', $p);
		$_id = interprete_argument_balise(1,$p);
		if (!$_id){
			$_id = champ_sql('id_article', $p);
		}
		$p->code = "generer_url_publier($_id,'article','',false)";

		$p->interdire_scripts = false;
	}
	return $p;
}

if(!test_espace_prive()){
	function generer_url_ecrire_article($id, $args, $ancre, $public, $connect){
		return url_absolue(generer_url_publier($id,article,'article',false));
	}
}
/**
 * Génération d'une url vers la page de publication d'un objet
 * 
 * @param int $id Identifiant numérique de l'objet
 * @param string $objet Le type de l'objet
 * @param boolean $forcer Dans le cas où l'objet est déjà publié cela renverra vers la page de l'objet. Si $forcer = true,
 * cela forcera le fait d'aller sur la page de modification de l'objet
 * @return string $url L'URL de la page que l'on souhaite
 */
function generer_url_publier($id,$objet='article',$id_secteur=0,$forcer=true){
	include_spip('inc/urls');
	
	$id_table_objet = id_table_objet($objet) ? id_table_objet($objet) : 'id_article';
	$table = table_objet_sql($objet);
	$table_objet = table_objet($objet);
	
	$infos_cherchees = array('statut');
	$trouver_table = charger_fonction('trouver_table', 'base');
	
	if ($desc = $trouver_table($table_objet, $serveur)
		AND isset($desc['field']['id_secteur'])){
			$infos_cherchees[] = 'id_secteur';
	}
		
	if(is_numeric($id)){
		$infos_objet = sql_fetsel($infos_cherchees,$table,$id_table_objet."=".intval($id));
		$id_secteur = $infos_objet['id_secteur'] ? $infos_objet['id_secteur'] : 0;
	}
	/**
	 * Si on ne force pas, on envoit vers la page de l'objet
	 */
	if(!$forcer){
		if($infos_objet['statut'] == 'publie')
			return generer_url_entite($id,$objet);
	}
	$objets[] = $objet;
	if($objet == 'article'){
		$objets[] = 'emballe_media';
		$objets[] = 'page';
	}
	$type_objet = sql_getfetsel('type','spip_diogenes','id_secteur='.$id_secteur.' AND '.sql_in("objet",$objets));
	if($type_objet){
		$url = generer_url_public('publier','type_objet='.$type_objet,'',true);
		if(is_numeric($id)){
			$url = parametre_url($url,$id_table_objet,intval($id));
		}
	}else{
		$url = generer_url_ecrire_objet($objet,$id);
	}
	return $url;
}

/**
 * Fonction retournant la chaine de langue depuis un statut
 *
 * @param string $statut Le statut de l'objet
 * @param string $type Le type d'objet SPIP
 * @return string La locution adéquate pour le statut 
 */
function diogene_info_statut($statut, $type='article') {
	$statuts = objet_info($type,'statut_titres');
	if(!is_array($statuts)){
		$statuts = objet_info($type,'statut_textes_instituer');
	}
	if(is_array($statuts) && array_key_exists($statut,$statuts)){
		return _T($statuts[$statut]);
	}
	else{
		switch ($type) {
			case 'article':
				$etats = array_flip($GLOBALS['liste_des_etats']);
				return _T($etats[$statut]);
			case 'rubrique':
				$etats = array_flip($GLOBALS['liste_des_etats']);
				if(isset($etats[$statut])){
					return _T($etats[$statut]);
				}
				elseif($statut == 'new')
					return _T('diogene:info_rubrique_new');
				/**
				 * Rubrique qui a été dépubliée
				 * cf depublier_rubrique_if() dans inc/rubriques
				 */
				elseif($statut == 0)
					return _T('diogene:info_rubrique_vide');
	
				else
					return $statut;
		}
	}
	return;
}

if(!function_exists('puce_statut')){
	include_spip('inc/autoriser');
	include_spip('inc/puce_statut');
}

if(!function_exists('puce_statut_rubrique')){
	/**
	 * Surcharge de la fonction puce_statut_dist() de inc/puce_statut
	 *
	 * @param $id_objet int L'id_rubrique
	 * @param $statut string Le statut de la rubrique
	 * @param $id_parent int
	 * @param $type string 'rubrique'
	 * @param $ajax
	 *
	 * @return un tag image <img src... /> ou le string du statut
	 */
	function puce_statut_rubrique($id_objet, $statut, $id_parent, $type, $ajax='') {
		if(test_espace_prive()){
			return puce_statut_rubrique_dist($id_objet, $statut, $id_parent, $type, $ajax='');
		}else{
			switch ($statut) {
				case 'publie':
					$img = 'puce-verte.gif';
					$alt = _T('diogene:info_rubrique_publie');
					return http_img_pack($img, $alt, $atts);
				/**
				 * Nouvelle rubrique cr&eacute;&eacute;e
				 */
				case 'new':
					$img = 'puce-blanche.gif';
					$alt = _T('diogene:info_rubrique_new');
					return http_img_pack($img, $alt, $atts);
				/**
				 * Rubrique qui a été dépubliée
			 	 * cf depublier_rubrique_if() dans inc/rubriques
				 */
				case '0':
					$img = 'puce-blanche.gif';
					$alt = _T('diogene:info_rubrique_new');
					return http_img_pack($img, $alt, $atts);
				default:
					return $statut;
			}
		}
	}
}


/**
 * Generer un lien d'aide (icone + lien)
 *
 * @param string $aide
 * 		cle d'identification de l'aide souhaitee
 * @param strink $skel
 * 		Nom du squelette qui appelle ce bouton d'aide
 * @param array $env
 * 		Environnement du squelette
 * @param bool $aide_spip_directe
 * 		false : Le lien genere est relatif a notre site (par defaut)
 * 		true : Le lien est realise sur spip.net/aide/ directement ...
 * @return 
**/
function inc_aider($aide='', $skel='', $env=array(), $aide_spip_directe = false) {
	global $spip_lang, $aider_index;
	include_spip('inc/aider');
	if (($skel = basename($skel))
	AND isset($aider_index[$skel])
	AND isset($aider_index[$skel][$aide]))
		$aide = $aider_index[$skel][$aide];

	if ($aide_spip_directe) {
		// on suppose que spip.net est le premier present
		// dans la liste des serveurs. C'est forcement le cas
		// a l'installation tout du moins
		$help_server = $GLOBALS['help_server'];
		$url = array_shift($help_server) . '/';
		$url = parametre_url($url, 'exec', 'aide');
		$url = parametre_url($url, 'aide', $aide);
		$url = parametre_url($url, 'var_lang', $spip_lang);
	} else {
		$args = "aide=$aide&var_lang=$spip_lang";
		if(test_espace_prive()){
			$url = generer_url_ecrire("aide", $args);
		}else{
			$url = generer_url_public("aide_spip", $args);
		}
	}
	
	return aider_icone($url);
}

function diogene_puce_statut($id_objet,$type,$statut,$id_parent='0'){
	$puce_statut = charger_fonction('puce_statut','inc');
	return $puce_statut($id_objet, $statut, $id_parent, $type,false,null);
}

?>
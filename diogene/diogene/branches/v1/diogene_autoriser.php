<?php
/**
 * Plugin Diogene
 *
 * Auteurs :
 * kent1 (kent1@arscenic.info)
 *
 * © 2010-2011 - Distribue sous licence GNU/GPL
 *
 * Autorisations spécifiques à Diogene
 *
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;
 
function diogene_autoriser(){};

/**
 * Autorisation à modifier un template de formulaire (Diogene)
 * 
 * @param unknown_type $faire
 * @param unknown_type $type
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opt
 */
function autoriser_diogene_modifier($faire,$type,$id,$qui,$opt){
	return autoriser('configurer','','',$qui,$opt);
}
/**
 * Autorisation de creer dans le template
 *
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_diogene_creerdans($faire, $type, $id, $qui, $opt) {
	$statut = sql_getfetsel('statut_auteur','spip_diogenes','id_diogene='.intval($id));
	return
		$qui['statut'] AND $id
		AND ($qui['statut'] <= $statut);
}

/**
 * Autoriser a creer un article dans la rubrique $id
 * Surcharge de SPIP
 * 
 * Changement par rapport à la fonction par défaut :
 * Si on a le plugin pages, on autorise à publier dans la rubrique 0
 * 
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 * 
 * https://code.spip.net/@autoriser_rubrique_creerarticledans_dist
 */
function autoriser_rubrique_creerarticledans($faire, $type, $id, $qui, $opt) {
	if(_DIR_PLUGIN_PAGES){
		return $qui['statut'] && autoriser('voir','rubrique',$id);
	}else
		return $qui['statut'] && autoriser_rubrique_creerarticledans_dist($faire, $type, $id, $qui, $opt);
	
}
/**
 * Permet de créer un article dans une rubrique
 * Surcharge de SPIP
 * 
 * Ne concerne que la création et non la publication
 * voir : rubrique_creerarticledans_dist() dans ecrire/inc/autoriser
 *
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_rubrique_voir($faire, $type, $id, $qui, $opt) {
	$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id));
	/**
	 * Cas des pages
	 */
	if($id == '-1'){
		$id_secteur=0;
	}
	$statut = sql_getfetsel('statut_auteur','spip_diogenes','id_secteur='.intval($id_secteur));

	return
		($qui['statut'] AND $id
		AND ($qui['statut'] <= $statut)) OR
		autoriser_voir_dist('voir','rubrique', $id, $qui, $opt);
}

/**
 * Permet de publier dans une rubrique
 * Surcharge de SPIP
 * 
 * Concerne la publication d'articles dans une rubrique
 * On vérifie que l'auteur à les droits dans le template
 * voir : autoriser_rubrique_publierdans_dist() dans ecrire/inc/autoriser
 * voir aussi pour les articles : http://trac.rezo.net/trac/spip/browser/spip/ecrire/action/editer_article.php#L174
 *
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_rubrique_publierdans($faire, $type, $id, $qui, $opt) {
	$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id));
	if($id == 0){
		$id_secteur=0;
	}
	$statut = sql_getfetsel('statut_auteur_publier','spip_diogenes','id_secteur='.intval($id_secteur));
	return ($qui['statut'] AND $id
		AND ($qui['statut'] <= $statut)) OR autoriser_rubrique_publierdans_dist($faire, $type, $id, $qui, $opt);
}

/**
 * Permet de modifier l'article dont on est l'auteur et que l'on peut publier nous même
 * Surcharge de SPIP
 * 
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_article_modifier($faire, $type, $id, $qui, $opt) {
	$r = sql_fetsel("id_rubrique,statut", "spip_articles", "id_article=".sql_quote($id));
	include_spip('inc/auth'); // pour auteurs_article si espace public
	return
		(autoriser('creerarticledans', 'rubrique', $r['id_rubrique'], $qui, $opt)
			AND in_array($r['statut'], array('prop','prepa', 'publie'))
			AND auteurs_article($id, "id_auteur=".$qui['id_auteur'])
		)
		OR in_array($qui['statut'], array('0minirezo'));
}

/**
 * Autorisation de suppression de document
 * Surcharge de SPIP si le plugin Mediathèque n'est pas installé 
 * 
 * On ne peut supprimer un document que :
 * - si nous sommes autorisé à le modifier
 * - si le document n'est lié à plus de un id_objet
 * - si le document est marqué comme vu (mis à l'intérieur d'un objet)
 *
 * Par rapport à l'originale :
 * - on enlève le besoin d'avoir accès à l'espace privé
 *
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
if(!function_exists('autoriser_document_supprimer')){
	function autoriser_document_supprimer($faire, $type, $id, $qui, $opt){
		if (!intval($id)
			OR !$qui['id_auteur']
			OR !autoriser('modifier','document',$id,$qui))
			return false;
		if (sql_countsel('spip_documents_liens', 'id_document='.intval($id)))
			return false;

		$liens = sql_select('objet,id_objet,vu','spip_documents_liens','id_document='.intval($id));
		while ($lien_doc = sql_fetch($liens)) {
			if($lien_doc['vu'] == 'oui'){
				return false;
			}
		}

		return true;
	}
}

/**
 * Autorisation de modification d'un document
 * Surcharge de SPIP si le plugin Mediathèque n'est pas installé 
 * 
 * On peut modifier un document quand :
 * - il n'est pas lie a un objet qu'on n'a pas le droit d'editer
 *
 * Fonction reprise du plugin mediathèque
 *
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
if(!function_exists('autoriser_document_modifier')){
	function autoriser_document_modifier($faire, $type, $id, $qui, $opt){
		static $m = array();

		// les admins ont le droit de modifier tous les documents
		if ($qui['statut'] == '0minirezo'
		AND !$qui['restreint'])
			return true;

		if (!isset($m[$id])) {
			$interdit = false;

			$s = sql_select("id_objet,objet", "spip_documents_liens", "id_document=".sql_quote($id));
			while ($t = sql_fetch($s)) {
				if (!autoriser('modifier', $t['objet'], $t['id_objet'], $qui, $opt)) {
					$interdit = true;
					break;
				}
			}

			$m[$id] = ($interdit?false:true);
		}

		return $m[$id];
	}
}

/**
 * Autoriser a creer un site dans la rubrique $id
 * Surcharge de SPIP : https://code.spip.net/@autoriser_rubrique_creersitedans_dist
 * 
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_rubrique_creersitedans($faire, $type, $id, $qui, $opt) {
	$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id));
	$statut = sql_getfetsel('statut_auteur','spip_diogenes','id_secteur='.intval($id_secteur));

	return
		$id
		AND autoriser('voir','rubrique',$id)
		AND $GLOBALS['meta']['activer_sites'] != 'non'
		AND (($qui['statut'] <= $statut) OR
			($qui['statut']=='0minirezo'
			OR ($GLOBALS['meta']["proposer_sites"] >=
			    ($qui['statut']=='1comite' ? 1 : 2)))
			    );
}

/**
 * Autorisation a modifier le logo d'un template de formulaire (Diogene)
 * 
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
function autoriser_diogene_iconifier_dist($faire,$quoi,$id,$qui,$opts){
	return (($qui['statut'] == '0minirezo') AND !$qui['restreint']);
}

/**
 * Si le plugin champs extras 2 est activé, on utilise une fonction d'autorisation
 * d'affichage des saisies de champs extras
 * 
 * Cette fonction vérifie tout d'abord s'il existe un diogène associé au type d'objet en cours et 
 * au secteur en cours et si oui :
 * -* on vérifie s'il y a une configuration liée aux champs extras sur ce diogène
 * -* on retourne false s'il est nécessaire de cacher ces champs extras
 * -* on retourne la fonction de base de cette autorisation dans le cas contraire
 * 
 * @param string $faire L'action
 * @param string $type Le type d'objet
 * @param int $id L'identifiant numérique de l'objet
 * @param array $qui Les informations de session de l'auteur
 * @param array $opt Des options
 * @return boolean true/false
 */
if(_DIR_PLUGIN_CEXTRAS){
	if(!function_exists('autoriser_modifierextra')){
		function autoriser_modifierextra($faire,$quoi,$id,$qui,$opts){
			/**
			 * On recherche un parent pour trouver le secteur qui nous permettra de trouver le diogene s'il existe
			 */
			if(is_numeric($opts['contexte']['id_parent']) OR is_numeric(_request('id_parent')) OR is_array(_request('parents'))){
				$id_parent = $opts['contexte']['id_parent'] ? $opts['contexte']['id_parent'] : (_request('id_parent') ? _request('id_parent') : table_valeur('0',_request('parents',array())));
				if($opts['type'] == 'article'){
					$objets = array('emballe_media','article');
				}else{
					$objets = array($opts['type']);
				}
				$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id_parent));
				$diogene_parent = sql_fetsel('*','spip_diogenes','id_secteur='.intval($id_secteur).' AND '.sql_in('objet',$objets));
				if(is_array(unserialize($diogene_parent['options_complements'])) && ($complements = unserialize($diogene_parent['options_complements'])) && is_array(unserialize($complements['cextras_enleves']))){
					foreach(unserialize($complements['cextras_enleves']) as $enleve){
						if($quoi == $opts['type'].'_'.$enleve){
							return false;
						}
					}
				}
			}
			return autoriser_modifierextra_dist($faire,$quoi,$id,$qui,$opts);
		}
	}
}

/**
 * Autorisation à traduire un article (spécifique à Diogène)
 * 
 * Est autorisé à traduire un article :
 * -* Dans le cas général, un auteur qui a le droit de créer un article dans la même rubrique que 
 * l'article en question;
 * -* Si on est dans un diogène, on se réfère à la configuration :
 * -** Par défaut, l'autorisation précedente;
 * -** Si dans la configuration du template, seulement l'auteur  ou un des auteurs originaux est sélectionné, 
 * on modifie le résultat à la configuration
 * -** Si dans la configuration du template, aucune traduction possible est sélectionnée, on retourne false;
 * 
 * On retourne toujours faux si :
 * -* Uniquement une seule langue dans le site;
 * 
 * @param unknown_type $faire
 * @param unknown_type $quoi
 * @param unknown_type $id
 * @param unknown_type $qui
 * @param unknown_type $opts
 */
function autoriser_article_traduire_dist($faire,$quoi,$id,$qui,$opts){
	$article = sql_fetsel("id_secteur,id_rubrique", "spip_articles", "id_article=".sql_quote($id));
	$diogene = sql_getfetsel("id_diogene","");
	include_spip('inc/auth'); // pour auteurs_article si espace public
	return
		(autoriser('creerarticledans', 'rubrique', $r['id_rubrique'], $qui, $opt)
			AND in_array($r['statut'], array('prop','prepa', 'publie'))
			AND auteurs_article($id, "id_auteur=".$qui['id_auteur'])
		)
		OR in_array($qui['statut'], array('0minirezo'));
}
?>
<?php
/**
 * Plugin Diogene
 *
 * Auteurs :
 * b_b
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * Distribue sous licence GNU/GPL
 *
 * Utilisation des pipelines par Diogene
 *
 * @package SPIP\Diogenes\Pipelines
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Insertion dans le pipeline insert_head_css (SPIP)
 * 
 * Compromis entre faire deux hits pour de petits fichiers sur la page d'upload
 * ou les trimballer sur tout le site dans une css compressée pour quelques octets (on choisi la 2)
 * 
 * @param $flux string
 * 		Le contenu de la balise #INSERT_HEAD_CSS
 * @return $flux string
 * 		Le contenu de la balise modifié
 */
function diogene_insert_head_css($flux){
	$diogene_css = direction_css(find_in_path('css/diogene.css'), lang_dir());
	$datepicker_css = direction_css(find_in_path('css/jquery.ui.datepicker.css'), lang_dir());
	$flux .= "<link rel='stylesheet' type='text/css' media='all' href='$diogene_css' />\n"
			 . "<link rel='stylesheet' type='text/css' media='all' href='$datepicker_css' />\n";
	return $flux;
}
/**
 * Insertion dans le pipeline editer_contenu_objet (SPIP)
 * 
 * Insère ou enlève les champs dans le formulaire
 * que l'on souhaite ajouter ou supprimer
 *
 * @param array $flux
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte du pipeline modifié
 */
function diogene_editer_contenu_objet($flux){
	$args = $flux['args'];
	$type = $args['type'];
	$pipeline = pipeline('diogene_objets', array());
	if (in_array($type,array_keys($pipeline))){
		$langues_dispos = explode(',',$GLOBALS['meta']['langues_multilingue']);
		
		/**
		 * Recherche de l'id_secteur afin de trouver le bon diogène
		 * - soit on a un id_secteur > 0 dans le contexte;
		 * - soit on a un id_parent dans le contexte et on cherche son secteur
		 */
		$id_secteur = ($args['contexte']['id_secteur'] > 0) ?
			$args['contexte']['id_secteur'] :
			sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($args['contexte']['id_parent']));
		
		/**
		 * Cas des pages uniques
		 * 
		 * On n'a pas d'id_secteur et on a un id_parent dans le contexte soit = 0 soit = -1
		 * Du coup c'est le cas d'une page unique, on change donc le type en "page", id_secteur en "0"
		 */
		if(!$id_secteur && (($args['contexte']['id_parent'] == 0) OR ($args['contexte']['id_parent'] == '-1') OR (!$args['contexte']['id_parent']  && !$args['contexte']['parents'])) && ($type=='article')){
			$id_secteur='0';
			$type = 'page';
		}
		
		/**
		 * Création de la clause Where de la requète pour trouver dans quel diogène on est
		 */
		if($type == 'article'){
			if($id_diogene = intval(_request('id_diogene')))
				$where = "id_diogene = ".intval($id_diogene)." AND id_secteur=".intval($id_secteur)." AND objet IN ('article','emballe_media')";
			else
				$where = "id_secteur=".intval($id_secteur)." AND objet IN ('article','emballe_media')";
		}
		
		if(!$where){
			if((!$id_secteur) && $pipeline[$type]['diogene_max'] == 1)
				$where = "objet=".sql_quote($type);
			else
				$where = "id_secteur=".intval($id_secteur)." AND objet=".sql_quote($type);
		}

		/**
		 * On n'agit que si on a trouvé un diogene
		 */
		if($diogene = sql_fetsel('*','spip_diogenes',$where)){
			/**
			 * On ajoute dans l'environnement les champs ajoutés par diogènes et ses sous plugins
			 */
			if(unserialize($diogene['champs_ajoutes']) == 'false')
				$args['diogene_ajouts'] = array();
			else
				$args['diogene_ajouts'] = unserialize($diogene['champs_ajoutes']);
			
			/**
			 * On ajoute dans l'environnement les options des complements
			 */
			if(unserialize($diogene['options_complements']) == 'false')
				$args['options_complements'] = array();
			else
				$args['options_complements'] = unserialize($diogene['options_complements']);

			/**
			 * On vire les champs que l'on ne souhaite pas
			 */
			if($diogene['objet'] == 'page')
				$diogene['champs_caches']['id_parent'];

			/**
			 * Si on a des champs à cacher :
			 * - On les enlève si présents dans la conf
			 * - Avant de les enlever, on vérifie bien qu'ils ne soient pas remplis, si ils le sont,
			 * on laisse le champ jusqu'à ce qu'il soit vide
			 */
			if(is_array($champs_caches = unserialize($diogene['champs_caches']))){
				foreach($champs_caches as $champ){
					if($champ == 'urlref')
						$champ = 'liens_sites';
					if (($champ == 'liens_sites') && preg_match(",<li [^>]*class=[\"']editer editer_($champ).*<fieldset>.*<\/fieldset>.*<\/li>,Uims",$flux['data'],$regs))
						$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer (editer_$champ).*<fieldset>.*<\/fieldset>.*<\/li>),Uims","",$flux['data'],1);
					else if (($champ != 'liens_site') && (!isset($args['contexte'][$champ]) OR (strlen($args['contexte'][$champ]) == 0)) && preg_match(",<li [^>]*class=[\"']editer editer_($champ).*<\/li>,Uims",$flux['data'],$regs)){
						$flux['data'] = preg_replace(",<li [^>]*class=[\"']editer editer_$champ.*<\/li>,Uims","",$flux['data'],1);
					}
				}
			}

			/**
			 * On ajoute ce que l'on souhaite ajouter avant le formulaire
			 */
			if($type=='page'){
				$type='article';
				$args['type'] = 'article';
				$old_type = 'page';
			}
			if (preg_match(",<div [^>]*class=[\"'][^>]*formulaire_editer_($type),Uims",$flux['data'],$regs)){
				$args['champs_ajoutes'] = $diogene['champs_ajoutes'];
				$args['diogene_identifiant'] = $diogene['type'];
				$ajouts = pipeline('diogene_avant_formulaire',array('args'=>$args,'data'=>''));
				$flux['data'] = preg_replace(",(<div [^>]*class=[\"'][^>]*formulaire_editer_$type),Uims",$ajouts."\\1",$flux['data'],1);
			}
			/**
			 * On ajoute le formulaire de langue sur les articles
			 */
			if($old_type){
				$type=$old_type;
				$args['type'] = $old_type;
			}
			if(in_array($type,array('article','page')) && (count($langues_dispos)>1)){
				$saisie_langue = recuperer_fond('formulaires/selecteur_langue',array('langues_dispos'=>$langues_dispos,'id_article'=>$args['contexte']['id_article']));
				$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer editer_titre.*<\/li>),Uims","\\1".$saisie_langue,$flux['data'],1);
			}
			/**
			 * On remplace le selecteur de rubrique par le notre dans le public
			 * On fait attention au fait qu'il y ait ou pas polyhiérarchie
			 * On laisse le séleceteur normal dans le prive pour pouvoir changer l'objet de place
			 */
			if (!test_espace_prive() && preg_match(",<li [^>]*class=[\"']editer editer_parent,Uims",$flux['data'],$regs) && (!preg_match(",<li [^>]*class=[\"']editer editer_parents,Uims",$flux['data'],$regs2) OR ($args['options_complements']['polyhier_desactiver'] == 'on'))){
				$contexte_selecteur = array(
					'id_rubrique_limite'=>$id_secteur,
					'type' => $type,
					'id_parent'=>$args['contexte']['id_parent'],
					'rubrique_principale' => $rubrique_principale);
				if($type == 'rubrique')
					$contexte_selecteur['id_rubrique'] = $args['contexte']['id_rubrique'];

				if(count($regs2) > 0){
					$class = "editer editer_parents";
					$contexte_selecteur['selecteur_type'] = "polyhier";
					$contexte_selecteur['parents'] = $args['contexte']['parents'];
				}else{
					$class = "editer editer_parent";
					$contexte_selecteur['selecteur_type'] = "normal";
				}
				$contexte_selecteur['rubrique_principale'] = 'oui';
				if($diogene['objet'] == 'emballe_media')
					$contexte_selecteur['rubrique_principale'] = 'non';

				$saisie_rubrique = recuperer_fond('formulaires/selecteur_rubrique',$contexte_selecteur);
				if($args['contexte']['id_parent'] > 0)
					$flux['data'] = preg_replace(",(<li [^>]*class=[\"']$class.*)(<li [^>]*class=[\"'](editer|fieldset).*),Uims",$saisie_rubrique."\\2",$flux['data'],1);
				else
					$flux['data'] = preg_replace(",(<li [^>]*class=[\"']$class.*)(<li [^>]*class=[\"'](editer|fieldset).*),Uims","\\2",$flux['data'],1);
				if(($class == 'editer editer_parents') && ($args['options_complements']['polyhier_desactiver'] == 'on')){
					$sous_rub_count = sql_countsel('id_rubrique','spip_rubriques','id_secteur='.intval($args['id_secteur']));
					if($sous_rub_count == 0){
						$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer editer_parent.*)(<li [^>]*class=[\"']editer.*),Uims",''."\\2",$flux['data'],1);
						$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer editer_parents.*)(<li [^>]*class=[\"']editer.*),Uims",''."\\2",$flux['data'],1);
					}
					else
						$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer editer_parents.*)(<li [^>]*class=[\"']editer.*),Uims",''."\\2",$flux['data'],1);
				}
			}else if(!test_espace_prive() && ($type != 'page') && preg_match(",<li [^>]*class=[\"']editer editer_parents,Uims",$flux['data'],$regs)){
				$contexte = $args['contexte'];
				$contexte['id_rubrique'] = $diogene['id_secteur'];
				$contexte['limite_branche'] = $diogene['id_secteur'];
				$saisie_rubrique = recuperer_fond("formulaires/inc-selecteur-parents_diogene",$contexte);
				$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer editer_parents.*)(<li [^>]*class=[\"']editer.*),Uims",$saisie_rubrique."\\2",$flux['data'],1);
			}
			/**
			 * On ajoute en fin de formulaire les blocs supplémentaires
			 */
			
			if (strpos($flux['data'],'<!--extra-->')!==FALSE){
				$saisie = pipeline('diogene_ajouter_saisies',array('args'=>$args,'data' => ''));
				/**
				 * On ajoute encore à la fin le sélecteur de statuts à la fin du formulaire
				 * Uniquement si l'on n'est pas dans le privé
				 */
				if($type=='page')
					$type='article';

				if ($args['options_complements']['workflow_simplifie'] == 'on')
					$args['contexte']['workflow_simplifie'] = 'on';
				
				$contexte = array(id_table_objet($type)=>$args['contexte'][id_table_objet($type)],'statut'=>$args['contexte']['statut'],'workflow_simplifie'=>$args['contexte']['workflow_simplifie']);
				if(!test_espace_prive() && find_in_path('formulaires/selecteur_statut_'.$diogene['objet'].'.html'))
					$saisie .= trim(recuperer_fond('formulaires/selecteur_statut_'.$diogene['objet'],$contexte));
				else if(!test_espace_prive() && find_in_path('formulaires/selecteur_statut_'.$type.'.html'))
					$saisie .= trim(recuperer_fond('formulaires/selecteur_statut_'.$type,$contexte));
				else if(!test_espace_prive() && find_in_path('formulaires/selecteur_statut_objet.html') AND $type != 'rubrique'){
					$args['contexte']['type'] = $type;
					$saisie .= trim(recuperer_fond('formulaires/selecteur_statut_objet',$contexte));
				}
				$flux['data'] = preg_replace(',(.*)(<!--extra-->),ims',"\\1<ul>".$saisie."</ul>\\2",$flux['data'],1);
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_charger (SPIP)
 * 
 * Charge des valeurs spécifiques dans le formulaire d'édition en cours
 * Les sous plugins peuvent se brancher sur le pipeline spécifique à Diogene : diogene_charger
 * Diogène ajoute dans le $flux de départ l'id_diogene correspondant à l'objet édité ($flux['data']['id_diogene'])
 * ainsi que l'id_diogene dans les hidden.
 * 
 * @param array $flux 
 * 		Le contexte d'environnement du pipeline
 * @return array $flux 
 * 		Le contexte d'environnement modifié
 */
function diogene_formulaire_charger($flux){
	if(isset($flux['args']['form']) && $flux['args']['form'] == 'editer_diogene'){
		$complements = unserialize($flux['data']['options_complements']);
		$valeurs = array();
		if(is_array($complements)){
			foreach($complements as $complement => $valeur){
				if(is_array(unserialize($valeur)))
					$valeurs[$complement] = unserialize($valeur);
				else
					$valeurs[$complement] = $valeur;
			}
		}
		if($flux['data']['objet'] == 'page'){
			$diogene_orig = _request('id_diogene');
			if($diogene = sql_getfetsel('id_diogene','spip_diogenes',"objet = 'page' AND id_diogene != ".intval($diogene_orig))){
				$flux['data']['editable'] = false;
				$flux['data']['message_erreur'] = _T('diogene:erreur_diogene_multiple_page');
			}else
				$flux['data']['_hidden'] .= "\n<input type='hidden' name='id_secteur' value='0' />\n";
		}
		$flux['data'] = array_merge($flux['data'],$valeurs);
	}else{
		$pipeline = pipeline('diogene_objets', array());
		if (isset($flux['args']['form']) &&  substr($flux['args']['form'],0,7) == 'editer_' && ($objet = substr($flux['args']['form'],7)) && in_array($objet,array_keys($pipeline))){
			$id_table_objet = id_table_objet($objet);
			$id_objet = $flux['data'][$id_table_objet];
			$flux['data']['id_objet'] = $id_objet;
			$id_secteur = (intval($flux['data']['id_secteur']) > 0) ? $flux['data']['id_secteur'] : ((intval($flux['data']['id_parent']) > 0) ? $flux['data']['id_parent'] : false);
	
			/**
			 * Cas spécifique pour les pages uniques
			 * -* Uniquement dans l'espace public
			 */
			if(($flux['args']['form'] == 'editer_article') && !$flux['args']['id_parent']){
				$type_objet= _request('type_objet');
				$id_secteur = sql_getfetsel('id_secteur','spip_diogenes','type='.sql_quote($type_objet));
				if(!$flux['args']['id_parent'] && is_numeric($flux['args']['args'][1])){
					$flux['data']['id_parent'] = $flux['args']['args'][1];
					$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.$flux['data']['id_parent']);
				}
			}
			
			if(!test_espace_prive() && (($flux['args']['form'] == 'editer_article') && ($flux['data']['id_parent'] == '-1') OR ($id_secteur == 0)))
				$flux['data']['type'] = 'page';
			
			if(intval($id_secteur)){
				if($objet == 'article'){
					$diogene = sql_fetsel('id_diogene,objet','spip_diogenes','id_secteur='.intval($id_secteur).' AND objet IN ("article","emballe_media")');
					$id_diogene = $diogene['id_diogene'];
					$type_diogene = $diogene['objet'];
				}else{
					$id_diogene = sql_getfetsel('id_diogene','spip_diogenes','id_secteur='.intval($id_secteur).' AND objet ='.sql_quote($objet));
					$type_diogene = $objet;
				}
			}else if($pipeline[$objet]['diogene_max'] == 1)
				$id_diogene = sql_getfetsel('id_diogene','spip_diogenes','objet ='.sql_quote($objet));
			
			/**
			 * On est effectivement dans un diogene
			 * On ajoute deux input hidden :
			 * -* id_diogene qui est l'id_diogene
			 * -* type_diogene qui est le champ 'objet' de la table spip_diogene
			 * Ces deux informations peuvent être intéressantes dans d'autres pipeline comme formulaire_traiter ...
			 */
			if(intval($id_diogene)){
				$flux['data']['_hidden'] .= "<input type='hidden' name='id_diogene' value='".$id_diogene."' />\n";
				$flux['data']['_hidden'] .= "<input type='hidden' name='type_diogene' value='".$type_diogene."' />\n";
				$flux['data']['id_diogene'] = $id_diogene;
			}
	
			$post_valeurs = pipeline('diogene_charger',
					array(
						'args' => array(
							$id_table_objet => $id_objet,
							'mode' => 'chargement',
							'valeurs' => $flux['data']
						),
						'data' => array()
					));
	
			if(is_array($post_valeurs))
				$flux['data'] = array_merge($flux['data'],$post_valeurs);
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_verifier (SPIP)
 * 
 * Vérifie les valeurs du formulaire avant leur traitement
 * Les sous plugins peuvent se brancher sur le pipeline spécifique à Diogene : diogene_verifier
 * 
 * @param array $flux 
 * 		Le contexte d'environnement du pipeline
 * @return array $flux 
 * 		Le contexte d'environnement modifié
 */
function diogene_formulaire_verifier($flux){
	$pipeline = pipeline('diogene_objets', array());
	if ($objet = substr($flux['args']['form'],7) AND in_array($objet,array_keys($pipeline))){
		// On ne fait rien si l'id_parent principal est incoherent (exemple : compat pages uniques)
		//if (_request('id_parent') < 0) return $flux;

		if($objet == 'rubrique' &&
			!strcmp($flux['args']['form'], 'editer_rubrique') &&
			($flux['args']['args'][0] == $flux['args']['args'][1])){
				$flux['data']['id_parent'] = _T('diogene:erreur_id_parent_id_rubrique');
		}
			
		$flux['data'] = pipeline('diogene_verifier',
			array(
				'args' => array(
					'erreurs' => $flux['data']
				),
				'data' => $flux['data']
			)
		);
		$messages = $flux['data'];
		unset($messages['message_ok']);
		if(count($messages) > 0){
			/**
			 * Si c'est la récupération automatique des infos d'un site, on n'affiche pas de message d'erreur
			 */
			if(count($messages) == 1 && isset($messages['verif_url_auto']))
				return $flux;
			$flux['data']['message_erreur'] = _T('diogene:message_erreur_general');
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_traiter (SPIP)
 * 
 * Insertion à la fin du traitement des formulaires
 * Les sous plugins peuvent également se brancher sur le pipeline spécifique à Diogene : diogene_traiter
 * Ce pipeline agit au moment de la pré édition de SPIP
 * 
 * On ne s'insère que sous certaines conditions :
 * -* on se trouve dans l'espace public;
 * -* on est dans le cas d'un formulaire du type #FORMULAIRE_EDITER_xx
 * -* dans le cas d'un diogene (passé dans le post);
 * -* le diogène passé dans le post existe bien;
 * 
 * Ce pipeline agit sur le message de retour et la redirection lors de la validation d'un formulaire
 * -* On ne redirige pas sur la page de l'objet même si publié;
 * -* On ajoute un lien pour voir l'objet publié dans le message de retour du formulaire
 * -* On ajoute un ajaxReload dans le message de retour pour rafraichir certains morceaux de la page (jQuery(".description_$objet,.diogene_$id_diogene"))
 * 
 * @param array $flux 
 * 		Le contexte d'environnement du pipeline
 * @return array $flux 
 * 		Le contexte d'environnement modifié
 */
function diogene_formulaire_traiter($flux){
	if(!test_espace_prive()
		&& isset($flux['args']['form'])
		&& (substr($flux['args']['form'],0,7) == 'editer_')
		&& ($objet = substr($flux['args']['form'],7))
		&& ($objet != 'diogene')
		&& ($id_diogene = intval(_request('id_diogene'))) 
		&& ($id_diogene == sql_getfetsel('id_diogene','spip_diogenes','id_diogene='.intval($id_diogene)))){
		
		$id_table_objet = id_table_objet($objet);
		$table_objet = table_objet_sql($objet);
		$id_objet = intval($flux['data'][$id_table_objet]);
		$statut_objet = sql_getfetsel('statut',$table_objet,$id_table_objet.'='.intval($id_objet));
		
		/**
		 * On récupère le titre dans le post que l'on passera aux chaines de langue
		 * On test 'titre','nom_site','nom' qui sont les 3 plus probables
		 * En dernier ressort on utilise generer_info_entite() pour trouver quelque chose
		 * (dans ce cas on doit appeler inc/texte qui pose problème)
		 */
		$titre = _request('titre') ? _request('titre') : (_request('nom_site') ? _request('nom_site') : _request('nom'));
		if(!$titre){
			include_spip('inc/filtres'); // Pour generer_info_entite
			$titre = generer_info_entite($id_objet,$objet,'titre');
		}
			
		/**
		 * Cas de la modification d'un objet
		 */
		if((_request($id_table_objet) == $flux['data'][$id_table_objet]) || (_request('arg') == $flux['data'][$id_table_objet])){
			/**
			 * TODO Utiliser les fonctions recherchant dans la déclaration des tables pour prendre le bon statut
			 * ici : refuse est pour les sites et poubelle pour le reste
			 */
			include_spip('inc/filtres');
			if(in_array($statut_objet,array('refuse','poubelle'))){
				$flux['data']['message_ok'] = _T('diogene:message_objet_supprime',array('titre'=>extraire_multi($titre)));
				$flux['data']['redirect'] = parametre_url(self(),$id_table_objet,'');
				$flux['data']['editable'] = false;
			}
			else{
				$flux['data']['message_ok'] = _T('diogene:message_objet_mis_a_jour',array('titre'=>extraire_multi($titre)));
				if(objet_test_si_publie($objet,$id_objet)){
					$url = generer_url_entite($id_objet,$objet);
					$flux['data']['message_ok'] .= '<br />'._T('diogene:message_objet_mis_a_jour_lien',array('url'=>$url));
				}
				if (!defined('_DIOGENE_REDIRIGE_PUBLICATION')) { // TODO : à ajouter dans infos_supp du diogene
					$flux['data']['message_ok'] .= '<script type="text/javascript">if (window.jQuery) jQuery(".description_'.$objet.',.diogene_'.$id_diogene.'").ajaxReload();</script>';
					$flux['data']['editable'] = true;
					$flux['data']['redirect'] = false;
				} else {
					$flux['data']['editable'] = false;
					$flux['data']['redirect'] = $url;
				}
			}
		}else{
			if(defined('_DIOGENE_REDIRIGE_PUBLICATION') && objet_test_si_publie($objet,$id_objet)){
				$flux['data']['redirect'] = generer_url_entite($id_objet,$objet);
			}else{
				$flux['data']['redirect'] = parametre_url(self(),$id_table_objet,$id_objet);
			}
			$flux['data']['message_ok'] = _T('diogene:message_objet_cree',array('titre'=>extraire_multi($titre)));
			$flux['data']['editable'] = false;
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline pre_insertion (SPIP)
 * 
 * A la création d'un article on vérifie si on nous envoie la langue
 * si oui on la met correctement dès l'insertion
 *
 * @param array $flux 
 * 		Le contexte du pipeline
 * @return array $flux 
 * 		Le contexte modifié 
 */
function diogene_pre_insertion($flux){
	if(($flux['args']['table'] == 'spip_articles') && _request('changer_lang')){
		$flux['data']['lang'] = _request('changer_lang');
		$flux['data']['langue_choisie'] = 'oui';
	}
	return $flux;
}

/**
 * Insertion dans le pipeline pre_edition (SPIP)
 * 
 * A la modification d'un article on vérifie si on nous envoie la langue
 * si elle est différente de celle de l'article on la change
 *
 * @param array $flux 
 * 		Le contexte du pipeline
 * @return array $flux 
 * 		Le contexte modifié 
 */
function diogene_pre_edition($flux){
	$pipeline = pipeline('diogene_objets', array());
	if(in_array($flux['args']['type'],array_keys($pipeline)) && ($flux['args']['action']=='modifier'))
		$flux = pipeline('diogene_traiter',$flux);

	/**
	 * Attention au herit envoyé dans le privé
	 */
	if(($flux['args']['table'] == 'spip_articles') && _request('changer_lang') && _request('changer_lang') != 'herit'){
		$flux['data']['lang'] = _request('changer_lang');
		$flux['data']['langue_choisie'] = 'oui';
	}
	
	if($flux['args']['table'] == 'spip_diogenes'){
		$champs = pipeline('diogene_champs_pre_edition',array('polyhier_desactiver','cextras_enleves','cacher_heure','workflow_simplifie'));
		if(isset($flux['data']['options_complements']))
			$options_complements = is_array(unserialize($flux['data']['options_complements'])) ? unserialize($flux['data']['options_complements']) : array();

		foreach(array('champs_ajoutes','champs_caches') as $array){
			if($val_array = _request($array)){
				if(is_array($val_array))
					$flux['data'][$array] = serialize($val_array);
				else
					$flux['data'][$array] = $val_array;
			}
		}
		foreach($champs as $champ){
			if(_request($champ)){
				if(is_array($val = _request($champ)))
					$options_complements[$champ] = serialize($val);
				else
					$options_complements[$champ] = $val;
			}
		}
		if($flux['data']['objet'] == 'page')
			$options_complements['polyhier_desactiver'] = 'on';
		if($options_complements)
			$flux['data']['options_complements'] = serialize($options_complements);
	}
	return $flux;
}

/**
 * Insertion dans le pipeline post_edition (SPIP)
 * 
 * On s'insère à la fin des actions d'edition (action/editer_*)
 * Notamment pour lancer un recalcul de la publication des rubriques
 *
 * @param array $flux 
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte modifié 
 */
function diogene_post_edition($flux){
	/**
	 * On rejoue le calcul des rubriques car il n'a pas lieu avec le bon
	 * id_rubrique au premier coup
	 * C'est un hack ...
	 */
	if(isset($flux['data']['id_rubrique']) && ($flux['data']['statut'] == 'publie') && ($flux['args']['action'] == 'instituer')){
		include_spip('inc/rubriques');
		calculer_rubriques_if($flux['data']['id_rubrique'], array('statut'=>'publie'),'');
	}
	return $flux;
}

/**
 * Insertion dans le pipeline diogene_objets (plugin Diogene)
 * 
 * On ajoute les champs que l'on peut ajouter
 * 
 * @param array $flux 
 * 		Un tableau bidimentionnel listant les champs pouvant être ajoutés aux objets
 * @return array $flux 
 * 		Le tableau modifié
 */
function diogene_diogene_objets($flux){
	$flux['article']['champs_sup']['date'] = _T('diogene:champ_date_publication');
	if($GLOBALS['meta']['articles_redac'] !== 'non')
		$flux['article']['champs_sup']['date_redac'] = _T('diogene:champ_date_publication_anterieure');
	$flux['article']['champs_sup']['forum'] = _T('diogene:champ_forum');
	
	if(defined('_DIR_PLUGIN_PAGES')){
		$flux['page'] = $flux['article'];
		$flux['page']['type_orig'] = 'article';
		$flux['page']['diogene_max'] = 1;
		$flux['page']['ss_rubrique'] = true;
	}
	
	$flux['site'] = array();
	
	$flux['rubrique'] = array();
	return $flux;
}

/**
 * Insertion dans le formulaire diogene_avant_formulaire (plugin Diogene)
 * 
 * Insert des scripts javascript nécessaire au bon fonctionnement des formulaires d'édition :
 * -* prive/javascript/presentation.js
 * -* formulaires/dateur/inc-dateur.html si une date est présente dans le formulaire
 * 
 * @param array $flux 
 * 		Le contexte du pipeline
 * @return array $flux 
 * 		Le contexte modifié
 */
function diogene_diogene_avant_formulaire($flux){
	$flux['data'] .= '<script type="text/javascript" src="'.find_in_path('prive/javascript/presentation.js').'"></script>';
	if(is_array(unserialize($flux['args']['champs_ajoutes'])) &&
		(in_array('date',unserialize($flux['args']['champs_ajoutes'])) || in_array('date_redac',unserialize($flux['args']['champs_ajoutes'])))){
		$flux['data'] .= recuperer_fond('formulaires/dateur/inc-dateur', $flux['args']);
	}
	return $flux;
}

/**
 * Insertion dans le formulaire diogene_ajouter_saisies (plugin Diogene)
 * 
 * Insert les saisies configurées dans le formulaire
 * 
 * @param array $flux
 * 		Le contexte du pipeline
 * @return array $flux 
 * 		Le contexte modifié
 */
function diogene_diogene_ajouter_saisies($flux){
	if(is_array(unserialize($flux['args']['champs_ajoutes']))){
		if(in_array('date_redac',unserialize($flux['args']['champs_ajoutes'])) && in_array('date',unserialize($flux['args']['champs_ajoutes'])) && ($GLOBALS['meta']['articles_redac'] != 'non')){
			$dates_ajoutees = 'date_full';
			if(!$flux['args']['contexte']['date'])
				list($flux['args']['contexte']['date_orig'],$flux['args']['contexte']['heure_orig']) = explode(' ',date('d/m/Y H:i',time()));
			else
				list($flux['args']['contexte']['date_orig'],$flux['args']['contexte']['heure_orig']) = explode(' ',date('d/m/Y H:i',strtotime($flux['args']['contexte']['date'])));
			if($flux['args']['contexte']['date_redac'])
				list($flux['args']['contexte']['date_redac_orig'],$flux['args']['contexte']['heure_redac_orig']) = explode(' ',date('d/m/Y H:i',strtotime($flux['args']['contexte']['date_redac'])));
		}else if(in_array('date_redac',unserialize($flux['args']['champs_ajoutes'])) && ($GLOBALS['meta']['articles_redac'] != 'non')){
			if($flux['args']['contexte']['date_redac'])
				list($flux['args']['contexte']['date_redac_orig'],$flux['args']['contexte']['heure_redac_orig']) = explode(' ',date('d/m/Y H:i',strtotime($flux['args']['contexte']['date_redac'])));
			$dates_ajoutees = 'date_redac_orig';
		}else if(in_array('date',unserialize($flux['args']['champs_ajoutes']))){
			if(!$flux['args']['contexte']['date'])
				list($flux['args']['contexte']['date_orig'],$flux['args']['contexte']['heure_orig']) = explode(' ',date('d/m/Y H:i',time()));
			else
				list($flux['args']['contexte']['date_orig'],$flux['args']['contexte']['heure_orig']) = explode(' ',date('d/m/Y H:i',strtotime($flux['args']['contexte']['date'])));
			$dates_ajoutees = 'date_orig';
		}
		if($dates_ajoutees){
			$flux['args']['contexte']['dates_ajoutees'] = $dates_ajoutees;
			$flux['args']['contexte']['cacher_heure'] = $flux['args']['options_complements']['cacher_heure'];
			$flux['data'] .= recuperer_fond('formulaires/diogene_ajouter_dates',$flux['args']['contexte']);
		}
		if(in_array('forum',unserialize($flux['args']['champs_ajoutes']))){
			if(isset($flux['args']['contexte']['id_article']) && is_numeric($flux['args']['contexte']['id_article'])){
				include_spip('formulaires/activer_forums_objet'); // Pour get_forums_publics
				$flux['args']['contexte']['forums_actuels'] = get_forums_publics($flux['args']['contexte']['id_article']);
			}
			$flux['data'] .= recuperer_fond('formulaires/diogene_ajouter_forums',$flux['args']['contexte']);
		}
	}
	return $flux;
}

/**
 * Insertion dans le formulaire diogene_verifier (plugin Diogene)
 * 
 * Vérification de saisies du formulaire
 * -* vérifie principalement les dates "date" et "date_redac"
 * -* vérifie la valeur pour le forum également
 * 
 * @param array $flux
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte modifié
 */
function diogene_diogene_verifier($flux){
	$erreurs = $flux['args']['erreurs'];
	if(_request('date_orig') || _request('date_redac_orig')){
		/**
		 * Ce fichier se trouve dans plugins-dist/organiseur/inc/date_gestion.php
		 * Mériterait une réincorporation dans SPIP?
		 */
		include_spip('inc/date_gestion');
		if(!$erreurs['date'] && ($date = _request('date_orig')))
			$date_orig = verifier_corriger_date_saisie('orig', 'oui', $erreurs);
		if(!$erreurs['date_redac'] && ($date = _request('date_redac_orig')))
			$date_redac_orig = verifier_corriger_date_saisie('redac_orig', 'oui', $erreurs);
	}
	if(!$erreurs['forums'] && ($forums = _request('forums')) && !in_array($forums,array('pos','pri','abo','non')))
		$erreurs['forums'] = _T('diogene:erreur_forums');
	return $flux;
}

/**
 * Insertion dans le formulaire diogene_traiter (plugin Diogene)
 * 
 * Traitement de saisies du formulaire
 * -* traite les dates "date" et "date_redac"
 * -* traite la valeur pour le forum également, si spécifié à "abo" et 
 * l'inscription des visiteurs n'est pas ouverte, on l'ouvre automatiquement 
 * 
 * @param array $flux 
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte modifié
 */
function diogene_diogene_traiter($flux){
	$id_objet = $flux['args']['id_objet'];

	if(_request('date_orig') || _request('date_redac_orig')){
		include_spip('inc/date_gestion');
		if(_request('date_orig')){
			$flux['data']['date'] = date('Y-m-d H:i:s',verifier_corriger_date_saisie('orig', 'oui', $erreurs));
			set_request('date',$flux['data']['date']);
		}
		if(_request('date_redac_orig'))
			$flux['data']['date_redac'] = date('Y-m-d H:i:s',verifier_corriger_date_saisie('redac_orig','oui', $erreurs));
	}
	if($forums = _request('forums')){
		$flux['data']['accepter_forum'] = $forums;
		if ($forums == 'abo' && ($GLOBALS['meta']['accepter_visiteurs'] != 'oui')){
			ecrire_meta('accepter_visiteurs', 'oui');
			include_spip('inc/invalideur');
			suivre_invalideur("id='id_forum/$id_objet'");
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline ajouter_menus (SPIP)
 * 
 * Ajouter des boutons dans les menus pour chaque diogène que l'on sait gérer dans l'espace privé
 * 
 * @param object $boutons_admin 
 * 		La description des boutons
 * @return object $boutons_admin
 * 		La description des boutons complétée
 */
function diogene_ajouter_menus($boutons_admin) {
	if(!function_exists('quete_logo'))
		include_spip('public/quete');
	
	$diogenes = sql_allfetsel('*','spip_diogenes','objet != "emballe_media"');
	
	foreach($diogenes as $diogene){
		if (autoriser('utiliser', 'diogene',$diogene['id_diogene'])) {
			$url = false;
			if($diogene['objet'] == 'rubrique'){
				$url = generer_url_ecrire('rubrique_edit','new=oui&id_parent='.$diogene['id_secteur']);
				$icon = find_in_theme('images/rubrique-add-16.png');
			}
			else if($diogene['objet'] == 'article'){
				$url = generer_url_ecrire('article_edit','new=oui&id_rubrique='.$diogene['id_secteur']);
				$icon = find_in_theme('images/article-add-16.png');
			}
			else if($diogene['objet'] == 'site'){
				$url = generer_url_ecrire('site_edit','new=oui&id_rubrique='.$diogene['id_secteur']);
				$icon = find_in_theme('images/site-add-16.png');
			}
			
			if($logo = quete_logo('diogene', 'ON', $diogene['id_diogene'], $diogene['id_secteur'], false)){
				include_spip('inc/filtres_images_mini');
				include_spip('filtres/images_transforme');
				$icon = extraire_attribut(image_reduire($logo[0],'16','16'),'src');
			}
			
			if($url){
				$boutons_admin['menu_edition']->sousmenu[$diogene['type']] =
				new Bouton($icon, extraire_multi($diogene['titre']),$url);
			}
		}
	}
	return $boutons_admin;
}
?>

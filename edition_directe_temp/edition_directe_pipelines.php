<?php

function edition_directe_header_prive($flux){
    	$flux .= '<link rel="stylesheet" href="'.generer_url_public("edition_directe_styles").'" type="text/css" media="all" />';
	return $flux;	
 }

// Seulement pour les version inférieure à SPIP 3



if($version = $GLOBALS['spip_version_branche']<3) {
	/*Modifie l'affichage de l'article dans l'espace interne*/
	 function edition_directe_afficher_fiche_objet($flux){
	    $type = $flux['args']['type'];
	
	    
		// objet article
	   if ($type=='article' AND objet_edition_directe($type)){
		$id_article= _request('id_article');
		if($id_article){
			$row = sql_fetsel("*", "spip_articles", "id_article=$id_article");
			
			$contexte = array(
				'icone_retour'=>icone_inline(_T('icone_retour'), $oups, "article-24.gif", "rien.gif",$GLOBALS['spip_lang_left']),
				'redirect'=>generer_url_ecrire("articles"),
				'titre'=>$row['titre'],
				'new'=>$new?$new:$id_article,
				'id_rubrique'=>$row['id_rubrique'],
				'id_secteur'=>$row['id_secteur'],
				'config_fonc'=>'articles_edit_config',
				// passer row si c'est le retablissement d'une version anterieure
				'row'=> $id_version
				? $row
				: null
				);
			
			$formulaire=recuperer_fond('prive/editer/article_mod',$contexte);
			
			$flux['data'] =preg_replace('/<div id=\'props\' class=\'tabs-container\'>/',$formulaire.'<div id="props" class="tabs-container">',$flux['data']);
			}
		}
	
		
	return $flux;
	}
	
	function edition_directe_afficher_contenu_objet($flux){
	
	    $type = $flux['args']['type'];
		// objet rubrique
		if ($type=='rubrique' AND objet_edition_directe($type)){
		
		$id_rubrique= _request('id_rubrique');
		if($id_rubrique){
			$row = sql_fetsel("*", "spip_rubriques", "id_rubrique=$id_rubrique");
		
			$contexte = array(
				'new'=>$id_rubrique,
				'titre'=>$row['titre'],
				'id_rubrique'=>$row['id_parent'], // pour permettre la specialisation par la rubrique appelante
				'config_fonc'=>'rubriques_edit_config',
				);
		
			 $flux['data']=recuperer_fond("prive/editer/rubrique_mod", $contexte);
			 }
		
		}
		
		// objet breve
		if ($type=='breve' AND objet_edition_directe($type)){
		$id_breve= _request('id_breve');
			if($id_breve){
				$contexte = array(
				'redirect'=>generer_url_ecrire("breves_voir"),
				'new'=>$id_breve,
				'id_rubrique'=>$id_rubrique,
				'config_fonc'=>'breves_edit_config'
				);
	 
				 $flux['data']=recuperer_fond("prive/editer/breve", $contexte);
				 }
		
		}
			
		//objet site	
		if ($type=='site' AND objet_edition_directe($type)){
		
		$id_syndic= _request('id_syndic');
			if($id_syndic){
				$contexte = array(
				'redirect'=>generer_url_ecrire("sites"),
				'new'=>$id_syndic,
				'id_rubrique'=>$id_rubrique,
				'config_fonc'=>'sites_edit_config'
				);
			
				$flux['data']=recuperer_fond("prive/editer/site_mod", $contexte);
				 }
		
		}		
			
		return $flux;
	}


	// affichage du formulaire de téléchargement des docs
	function edition_directe_affiche_gauche($flux){
		$exec= $flux['args']['exec'];
			if(test_plugin_actif('medias') or test_plugin_actif('gest_doc')) $mediatheque='ok';
			
			if($exec=='articles' AND $mediatheque AND autoriser('joindredocument','article',_request('id_article')) AND  objet_edition_directe('article')){
				$flux['data'] .=recuperer_fond('prive/editer/colonne_documents_aed',array('objet'=>'article','id_objet'=>_request('id_article')));
				}
			if($exec=='naviguer' AND autoriser('joindredocument','rubrique',_request('id_rubrique')) AND  objet_edition_directe('rubrique')){
				$flux['data'] .= recuperer_fond('prive/editer/colonne_documents_aed',array('objet'=>'rubrique','id_objet'=>_request('id_rubrique')));
				}		
			if($exec=='breves_voir' AND autoriser('joindredocument','breve',_request('id_breve')) AND  objet_edition_directe('breve')){
				$flux['data'] .= recuperer_fond('prive/editer/colonne_documents_aed',array('objet'=>'breve','id_objet'=>_request('id_breve')));
				}
	
	return $flux;
	}
}
else{
	function edition_directe_afficher_config_objet($flux){
		$type= $flux['args']['type'];
		$id = $flux['args']['id'];
		if($type=='article' AND autoriser('joindredocument',$type,$id ) AND  objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
				}
		if($type=='rubrique' AND autoriser('joindredocument',$type,_request('id_rubrique')) AND  objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
				}	
						
		if($type=='breve' AND autoriser('joindredocument',$type,_request('id_breve')) AND  objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
			}
		if($type=='site' AND autoriser('joindredocument',$type,_request('id_'.$type)) AND  objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
			}									
		/* pas de pipeline disponible pour le moment
		if($type=='auteur' AND autoriser('joindredocument',$type,_request('id_'.$type)) AND objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
			}								
		if($type=='mot' AND autoriser('joindredocument',$type,_request('id_'.$type)) AND objet_edition_directe($type)){
			$flux['data'] .=recuperer_fond('prive/objets/editer/colonne_document',array('objet'=>$type,'id_objet'=>$id));
			}	*/					
	    return $flux;
	}
}
?>

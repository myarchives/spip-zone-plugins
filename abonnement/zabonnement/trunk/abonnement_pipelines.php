<?php
 
if (!defined("_ECRIRE_INC_VERSION")) return;


// abonnement payant gere par panier / commande etc
// espace public
// � la validation du paiement de la commande inserer l'abonnement � l'abonnement 
//todo sinon inserer l'abonnement -refuse-
function abonnement_post_insertion($flux){
	
	if (
		$flux['args']['table'] == 'spip_commandes'
		and ($id_commande = intval($flux['args']['id_objet'])) > 0
		and $flux['data']['statut'] == 'paye'
	){
	
	$objet='abonnement';
	
	// On recupere le contenu des articles dans les details de la commande
		$commande_abos = sql_allfetsel(
			'*',
			'spip_commandes_details',
			'id_commande = '.$id_commande." AND objet='$objet'"
		);
		
	// On recupere le id_auteur (unique) du flux data
	$id_auteur=$flux['args']['id_auteur'];

		// Pour chaque commande d'abonnement
		foreach($commande_abos as $abo){
			$objet=$abo['objet'];
			$id_objet = $abo['id_objet'];
			$id_commandes_detail=$abo['id_commandes_detail'];
			if (_DEBUG_ABONNEMENT) spip_log('abonnement_post_insertion > id_commande='.$id_commandes_detail.' id_abonnement='.$id_objet.'et auteur= '.$id_auteur,'abonnement');
			
			$abonnement = sql_fetsel('*', 'spip_abonnements', 'id_abonnement = '. $id_objet);
			
			$date = date('Y-m-d H:i:s');
			$ids_zone=$verif['ids_zone'];
			if($ids_zone!='')
			ouvrir_zone($id_auteur,$ids_zone);
					
					// jour
					if ($verif['periode'] == 'jours') {
						$validite = date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('n'),date('j')+$verif['duree'],date('Y')));
					}
					// ou mois
					else {
						$validite = date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('n')+$verif['duree'],date('j'),date('Y')));
					}
					
			// attention aux doublons, on verifie 
			if ((!$id = sql_getfetsel('id_auteur','spip_contacts_abonnements','objet="'.$objet.'" and id_auteur='.$id_auteur.' and id_objet='.sql_quote($id_objet).' and validite > NOW()')))
						sql_insertq("spip_contacts_abonnements",
							array(
							'id_auteur'=> $id_auteur,
							'objet'=>$objet,							
							'id_objet'=> $id_objet,
							'date'=>$date,
							'validite'=>$validite,
							'id_commandes_detail'=>$id_commandes_detail,
							'statut_abonnement'=>$flux['data']['statut'],
							'prix'=>$abo['prix_unitaire_ht'])
							);
					// sinon cet abonnement existe deja
					else { 
					if (_DEBUG_ABONNEMENT) spip_log("abonnement $objet existe deja","abonnement");
					}

		}

	}
	
return $flux;
	
}

//fonctions a mettre ailleurs?
              
function ouvrir_zone($id_auteur,$ids_zone)
{
	$array_ids = explode(",", $ids_zone);
	foreach($array_ids as $id_zone)
	{
	if (_DEBUG_ABONNEMENT) spip_log("ouvrir_zone $id_zone pour $id_auteur",'abonnement');
		sql_insertq("spip_zones_auteurs", array(
			"id_zone"=>$id_zone,
			"id_auteur"=>$id_auteur
		));
	}
}

//espace prive
//affiche les abonnements auxquels l'auteur est abonne (sur auteur_infos)
function abonnement_affiche_milieu($flux){
	if($flux['args']['exec'] == 'auteur_infos') {
		$legender_auteur_supp = recuperer_fond('prive/abonnement_fiche',array('id_auteur'=>$flux['args']['id_auteur']));
		$flux['data'] .= $legender_auteur_supp;
	}
	//todo tester le flux pour savoir si abonnement ok
	/*
	//affiche les auteurs dont l'abonnement comprend cet article (sur articles)	
	if($flux['args']['exec'] == 'articles') {
		$affiche_abonnes = recuperer_fond('prive/abocomprend_article',
			array('id_objet'=>$flux['args']['id_article'],	
			'objet'=>'article'
			));
		$flux['data'] .= $affiche_abonnes;
	}
	//affiche les auteurs dont l'abonnement comprend cette rubrique (sur rubriques)	
	if($flux['args']['exec'] == 'naviguer') {
		$affiche_abonnes = recuperer_fond('prive/abocomprend_rubrique',
			array('id_objet'=>$flux['args']['id_rubrique'],	
			'objet'=>'rubrique'
			));
		$flux['data'] .= $affiche_abonnes;
	}
	*/
	return $flux;
}


//affiche liste des abonnements pour s'abonner dans le formulaire d'un auteur
function abonnement_editer_contenu_objet($flux){
	if ($flux['args']['type']=='auteur') {
		$abonnement = recuperer_fond('prive/abonnement_fiche_modif',array('id_auteur'=>$flux['args']['id']));
		$flux['data'] = preg_replace('%(<li class="editer_pgp(.*?)</li>)%is', '$1'."\n".$abonnement, $flux['data']);
	}
	return $flux;
}


/**
 *
 * Insertion dans le pipeline post_edition
 * ajouter les champs abonnement soumis lors de la soumission du formulaire CVT editer_auteur
 *
 * @return
 * @param object $flux
 */
  /*
$flux['args']['action'] = modifier
 il faudrait savoir si on est dans prive ou en public
 todo car determine si paiement possible...
 ne sert actuellement que dans le backoffice en 'cadeau' (statut paye sans lien a une commande = offert)
 */
function abonnement_post_edition($flux){
		
	// lors de l'edition d'un auteur
	if ($flux['args']['table']=='spip_auteurs') {
	$continue=false;
	
		$id_auteur = $flux['args']['id_objet'];
		
		$abonnements = _request('abonnements');
		$rubriques = _request('rubriques');
		$articles = _request('articles');
		$echeances = _request('validites');
		
		$statut_abonnement='offert';
		$duree = 3; //valable 3 jours, todo in config
		
		if ($articles && is_array($articles)) {
		$objet='article';
		$ids=$articles;
		$table="spip_articles";
		creer_abonnement_objet($id_auteur,$statut_abonnement,$objet,$table,$ids,$duree);
		}
		
		if ($rubriques && is_array($rubriques)) {
		$objet='rubrique';
		$ids=$rubriques;
		$table="spip_rubriques";
		creer_abonnement_objet($id_auteur,$statut_abonnement,$objet,$table,$ids,$duree);
		}
		
		if ($abonnements && is_array($abonnements)) {
		$objet='abonnement';
		$ids=$abonnements;
		$table="spip_abonnements";
		creer_abonnement_objet($id_auteur,$statut_abonnement,$objet,$table,$ids,$duree);
		}

	}

	return $flux;
}

function creer_abonnement_objet($id_auteur,$statut_abonnement,$objet,$table,$ids,$duree)
{
	foreach($ids as $key => $id_objet)
	{
		if($id_objet!='non')
		{
				
			$verif = sql_fetsel('*', $table, 'id_'."$objet = " . $id_objet);
			if (!$verif) 
			{
				if (_DEBUG_ABONNEMENT) spip_log("$objet $id_objet inexistant",'abonnement');
				die("$objet $id_objet inexistant");
			}
			
			//todo verifier avec plugin montants?
			$calculer_prix = charger_fonction('prix', 'inc/');
			$prix=($statut_abonnement=='offert')?'':$calculer_prix($objet,$id_objet);//pas de prix puisque offert
			$date = date('Y-m-d H:i:s');
			$validite = date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('n'),date('j')+$duree,date('Y')));
			
			//specific a abonnement
			if($objet=='abonnement'){
				$prix=($statut_abonnement=='offert')?'':$verif['prix'];//pas de prix puisque offert
				$duree = $verif['duree'];
				$periode = $verif['periode'];
					
				// jour
				if ($periode == 'jours') {
					$validite = date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('n'),date('j')+$duree,date('Y')));
				}
				// ou mois
				else {
					$validite = date('Y-m-d H:i:s', mktime(date('H'),date('i'),date('s'),date('n')+$duree,date('j'),date('Y')));
				}
			}
				
			if (_DEBUG_ABONNEMENT) spip_log("zaboarticle_post_edition $objet $id_objet date $validite",'abonnement');

			if (!$deja = sql_getfetsel('id_auteur,validite',
				'spip_contacts_abonnements',
				'id_auteur='.$id_auteur.' AND id_objet='.sql_quote($id_objet)." AND objet='$objet'")
				)
			{
				$ids_zone=$verif['ids_zone'];
				if($ids_zone!='')
				ouvrir_zone($id_auteur,$ids_zone);
					
				sql_insertq("spip_contacts_abonnements",array(
					'id_auteur'=> $id_auteur,
					'objet'=>$objet,
					'id_objet' => $id_objet,
					'date'=>$date,
					'validite'=>$validite,
					'statut_abonnement'=>$statut_abonnement,
					'prix'=>$prix));
			}else{
				if (_DEBUG_ABONNEMENT) spip_log("abonnement_post_edition pour auteur=$id_auteur $objet $id_objet existe deja",'abonnement');
				//modif des dates d'echeances
				if($echeances[$key]!='' && ($echeances[$key]!=$deja['validite'])){
					if (_DEBUG_ABONNEMENT) spip_log("changer date ". $echeances[$key]."!=".$deja['validite'],'abonnement');
				sql_updateq("spip_contacts_abonnements",array('validite'=>$echeances[$key]),
					'id_auteur='.$id_auteur.' and id_objet='.sql_quote($id_objet)." and objet='$objet'");
				}
			}
		}
	}
			// Notifications, gestion des revisions, reindexation...
		pipeline('post_edition',
		array(
			'args' => array(
				'table' => 'spip_contacts_abonnements',
				'id_auteur' => $id_auteur,
				'objet'=>$objet,
				'id_objet' => $id_objet,
				'statut_abonnement' => $statut_abonnement
			),
			'data' => $ids
		)
		);
		
}

//utiliser le cron pour gerer les dates de validite des abonnements et envoyer les messages de relance
function abonnement_taches_generales_cron($taches_generales){
	$taches_generales['abonnement'] = 60*60*24 ;
	return $taches_generales;
}

?>

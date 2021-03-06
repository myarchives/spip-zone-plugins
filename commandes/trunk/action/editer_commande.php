<?php
/**
 * API d'édition du plugin Commandes
 *
 * @plugin     Commandes
 * @copyright  2014
 * @author     Ateliers CYM, Matthieu Marcillaud, Les Développements Durables
 * @licence    GPL 3
 * @package    SPIP\Commandes\Editer
 */

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Point d'entrée d'édition d'une commande
 *
 * On ne peut entrer que par un appel en fournissant `$id_commande`
 * mais pas pas une url
 *
 * @uses commande_inserer()
 * @uses commande_modifier()
 *
 * @param int $id_commande
 *     Identifiant de la commande
 * @return array
 *     Identifiant de la commande et message d'erreur eventuel
 */
function action_editer_commande_dist($id_commande=null) {

	// appel direct depuis une url interdit
	if (is_null($id_commande)){
		//$securiser_action = charger_fonction('securiser_action', 'inc');
		//$id_commande = $securiser_action();
		include_spip('inc/minipres');
		echo minipres(_T('info_acces_interdit'));
		die();
	}

	// si id_commande n'est pas un nombre, c'est une creation
	if (!$id_commande = intval($id_commande)) {
		$id_commande = commande_inserer(null,array('id_auteur'=>_request('id_auteur')));
	}

	if (!($id_commande = intval($id_commande))>0)
		return array($id_commande,_L('echec enregistrement en base'));

	// Enregistre l'envoi dans la BD
	$err = commande_modifier($id_commande);

	return array($id_commande,$err);
}


/**
 * Crée une nouvelle commande et retourne son identifiant
 *
 * Les notifications par email sont traitées après l'insertion en base et l'appel des pipelines
 *
 * @uses commandes_notifier()
 *
 * @pipeline_appel pre_insertion
 * @pipeline_appel post_insertion
 * @param null $id_parent
 *     Paramètre inutilisé, présent pour compatibilité avec api modifier objet
 * @param array $champs
 *     Couples des champs/valeurs par défaut
 * @return int|bool
 *     - Identifiant de la commande si succès
 *     - False en cas d'erreur
 */
 
function commande_inserer($id_parent=null, $champs=array()) {
	$id_commande = false;

	// On insère seulement s'il y a un auteur correct
	$id_auteur = 0;
	if (isset($champs['id_auteur'])) {
		$id_auteur = intval($champs['id_auteur']);
	}
	include_spip('inc/autoriser');
	if (autoriser('commander','',0,$id_auteur)){
		// La date de tout de suite
		$champs['date'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		
		// Le statut en cours par défaut
		if (!isset($champs['statut'])) {
			$champs['statut'] = 'encours';
		}

		// Envoyer aux plugins avant insertion
		$champs = pipeline('pre_insertion',
			array(
				'args' => array(
					'table' => 'spip_commandes',
				),
				'data' => $champs
			)
		);

		// Si on veut insérer des échéances et que ce n'est pas déjà sérialisé, on sérialise TOUJOURS ce champ
		if (isset($champs['echeances']) and @unserialize($champs['echeances']) === false) {
			$champs['echeances'] = serialize($champs['echeances']);
		}
		
		// Insérer l'objet
		$id_commande = sql_insertq("spip_commandes", $champs);

		// La référence si elle n'est pas déjà donnée : on attend d'avoir l'id_commande pour pouvoir generer un numero unique
		if (!isset($champs['reference'])) {
			$commandes_reference = charger_fonction('commandes_reference', 'inc/');
			$champs['reference'] = $commandes_reference($id_commande, $id_auteur=0);
			sql_updateq('spip_commandes', array('reference' => $champs['reference']), 'id_commande=' . intval($id_commande));
		}

		// Envoyer aux plugins après insertion
		pipeline('post_insertion',
			array(
				'args' => array(
					'table' => 'spip_commandes',
					'id_objet' => $id_commande
				),
				'data' => $champs
			)
		);
		
		// Envoi des notifications par email
		spip_log("inserer_commande : appel des notifications pour la commande $id_commande",'commandes.'._LOG_INFO);
		include_spip('inc/commandes');
		// c'est une creation : statut_ancien=''
		commandes_notifier($id_commande, '');

	}

	return $id_commande;
}

/**
 * Appelle les fonctions de modification d'une commande
 *
 * @uses objet_modifier_champs()
 * @uses commande_instituer()
 *
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array|null $set
 *     Couples des champs/valeurs à modifier
 * @return mixed|string $err
 *     Message d'erreur éventuel
 */
function commande_modifier($id_commande, $set=null) {
	$err = '';

	include_spip('inc/modifier');
	include_spip('inc/filtres');
	$c = collecter_requests(
		// whitelist
		objet_info('commande','champs_editables'),
		// blacklist
		array('date','statut'),
		// donnees eventuellement fournies
		$set
	);
	
	// Si on veut insérer des échéances et que ce n'est pas déjà sérialisé, on sérialise TOUJOURS ce champ
	if (isset($c['echeances']) and @unserialize($c['echeances']) === false) {
		$c['echeances'] = serialize($c['echeances']);
	}
	
	// Si l'objet est publie, invalider les caches et demander sa reindexation
	if (objet_test_si_publie('commande',$id_commande)){
		$invalideur = "id='id_commande/$id_commande'";
		$indexation = true;
	}
	else {
		$invalideur = "";
		$indexation = false;
	}

	if ($err = objet_modifier_champs('commande', $id_commande,
		array(
			'data' => $set,
			'nonvide' => array('statut' => _T('info_sans_statut')),
			'invalideur' => $invalideur,
			'indexation' => $indexation,
		),
		$c))
		return $err;

	// Modification de statut
	$c = array();
	foreach (array('id_auteur', 'date', 'statut',) as $champ)
		$c[$champ] = _request($champ, $set);
	$err = commande_instituer($id_commande, $c);

	return $err;
}

/**
 * Instituer une commande
 *
 * Modifie des éléments à part que sont l'auteur, la date, le statut
 *
 * @uses editer_commande_details()
 * @uses commandes_notifier()
 *
 * @pipeline_appel pre_edition
 * @pipeline_appel post_edition
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $c
 *     Couples champ/valeur à modifier
 * @param bool $calcul_details
 *     (?) Inutilisé
 * @return mixed|string
 */
function commande_instituer($id_commande, $c, $calcul_details=true){
	include_spip('inc/autoriser');
	include_spip('inc/modifier');

	$row = sql_fetsel("statut, date, id_auteur", "spip_commandes", "id_commande=$id_commande");
	$id_auteur = $row['id_auteur'];
	$statut_ancien = $statut = $row['statut'];
	$date_ancienne = $date = $row['date'];
	$champs = array();

	$d = isset($c['date']) ? $c['date'] : null;
	$s = isset($c['statut']) ? $c['statut'] : $statut;

	// On ne modifie le statut que si c'est autorisé
	if ($s != $statut or ($d AND $d != $date)) {
		//todo = donner l'autorisation a commandes_paypal_traitement_paypal
		//if (autoriser('modifier', 'commande', $id_commande))
			$statut = $champs['statut'] = $s;
		//else
		//	spip_log("editer_commande $id_commande refus " . join(' ', $c),'commandes');

		// Si on doit changer la date explicitement
		if ($d){
			$champs['date'] = $date = $d;
		}
	}

	$champs['id_auteur'] = $id_auteur;

	// Mettre à jour les dates de paiement ou d'envoi pour les statuts correspondants
	if ($statut != $statut_ancien)
		foreach (array('partiel'=>'paiement', 'paye'=>'paiement', 'envoye'=>'envoi') as $k=>$v)
			if ($statut == $k)
				$champs["date_$v"] = date('Y-m-d H:i:s');

	// Envoyer aux plugins avant édition
	$champs = pipeline(
		'pre_edition',
		array(
			'args' => array(
				'table' => 'spip_commandes',
				'id_objet' => $id_commande,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);

	if (!count($champs)) return;

	// Envoyer les modifications et calculer les héritages
	editer_commande_details($id_commande, $champs, $calcul_details);

	// Invalider les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='id_commande/$id_commande'");

	include_spip('inc/commandes');
	// distribuer la commande si payee
	if ($statut != $statut_ancien
	  and $statut=='paye'
	  and in_array($statut_ancien,array('encours','attente','partiel','erreur','poubelle'))
	  and $distribuer_commande = charger_fonction('distribuer_commande','action',true)){
		$distribuer_commande($id_commande);
	}

	spip_log("instituer_commande : flux post_edition pour la commande $id_commande",'commandes.'._LOG_INFO);

	// Envoyer aux plugins après édition
	pipeline(
		'post_edition',
		array(
			'args' => array(
				'table' => 'spip_commandes',
				'id_objet' => $id_commande,
				'action' => 'instituer',
				'statut_ancien' => $statut_ancien,
			),
			'data' => $champs
		)
	);

	// Envoi des notifications par email
	if ($statut != $statut_ancien) {
		spip_log("instituer_commande : appel des notifications pour la commande $id_commande",'commandes.'._LOG_INFO);
		commandes_notifier($id_commande, $statut_ancien);
	}

	return ''; // pas d'erreur
}

/**
 * Fabrique la requête d'institution de la commande
 *
 * Modifie la commande en calculant les dépendances des détails
 * 
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $champs
 *     Couples des champs/valeurs à modifier
 * @param bool $cond
 *     (?) inutilisé
 * @return void
 */
function editer_commande_details($id_commande, $champs, $cond=true) {

	if (!$champs) return;

	sql_updateq(table_objet_sql('commande'), $champs, "id_commande=$id_commande");

	// Changer le statut des elements concernes ? (voir details)

	/*
	if ($cond) {
		include_spip('inc/rubriques');
		$postdate = ($GLOBALS['meta']["post_dates"] == "non" and isset($champs['date']) and (strtotime($champs['date']) < time())) ? $champs['date'] : false;
		calculer_rubriques_if($id_rubrique, $champs, $statut, $postdate);
	}
	*/
}

// Ci dessous, fonctions dépréciées gardées pour rétro-compatibilité

/**
 * Enregistre une modification d'une commande
 *
 * @deprecated Alias de 'commande_modifier' pour rétro-compatibilité
 * @uses commande_modifier()
 *
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $c
 *     Couples des champs/valeurs modifiées
 * @return mixed|string
 */
function revision_commande($id_commande, $c=false) {
	return commande_modifier($id_commande, $c);
}

/**
 * Crée une nouvelle commande
 *
 * @deprecated Alias de 'commande_inserer' pour rétro-compatibilité
 * @uses commande_inserer()
 *
 * @param array $champs
 *     Couples des champs/valeurs par défaut
 * @return
 */
function commande_insert($champs=array()){
	return commande_inserer(null,$champs);
}

/**
 * Appelle les fonctions de modification d'une commande
 *
 * @deprecated Alias de 'commande_modifier' pour rétro-compatibilité
 * @uses commande_modifier()
 * 
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array|null $set
 *     Couples des champs/valeurs à modifier
 * @return
 */
function commande_set($id_commande, $set=null){
	return commande_modifier($id_commande, $set);
}

/**
 * Modifie des éléments à part que sont l'auteur, la date, le statut
 * 
 * @deprecated Alias de 'commande_instituer' pour rétro-compatibilité
 * @uses commande_instituer()
 * 
 * @param int $id_commande
 *     Identifiant de la commande
 * @param array $c
 *     Couples des champs/valeurs à modifier
 * @param bool $calcul_details
 *     (?) Inutilisé
 * @return
 */
function instituer_commande($id_commande, $c, $calcul_details=true){
	return commande_instituer($id_commande, $c, $calcul_details);
}

?>

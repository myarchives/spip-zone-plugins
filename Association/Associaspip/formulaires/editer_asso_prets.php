<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Francois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip('inc/actions');
include_spip('inc/editer');
include_spip('inc/association_comptabilite');

function formulaires_editer_asso_prets_charger_dist($id_pret='')
{
	/* cet appel va charger dans $contexte tous les champs de la table spip_asso_prets associes a l'id_pret passe en param */
	$contexte = formulaires_editer_objet_charger('asso_prets', $id_pret, '', '',  generer_url_ecrire('prets'), '');
	if (!$id_pret) { /* si c'est une nouvelle operation, on charge la date d'aujourd'hui, charge un id_compte et journal null, le statut et le prix de location de base */
		$contexte['date_sortie'] = $contexte['date_retour'] = date('Y-m-d');
		$contexte['heure_sortie'] = $contexte['heure_retour'] = date('H:i');
		$contexte['commentaire_sortie'] = $contexte['commentaire_retour'] = '';
		$id_compte = $journal = '';
		$contexte['id_ressource'] = intval(_request('id_ressource'));
		$ressource = sql_fetsel('pu,ud', 'spip_asso_ressources', "id_ressource=$contexte[id_ressource]");
		$contexte['ud'] = $ressource['ud'];
		$montant = $contexte['prix_unitaire'] = $ressource['pu'];
	} else { /* sinon on recupere l'id_compte correspondant et le journal dans la table des comptes */
		$comptes = sql_fetsel('id_compte,journal,recette', 'spip_asso_comptes', "imputation='".$GLOBALS['association_metas']['pc_prets']."' AND id_journal='$id_pret'");
		$id_compte = $comptes['id_compte'];
		$journal = $comptes['journal'];
		$montant = $comptes['recette'];
		$contexte['ud'] =  sql_asso1champ('ressource', $contexte['id_ressource'], 'ud');
		$contexte['heure_sortie'] = substr($contexte['date_sortie'],12,5);
		$contexte['date_sortie'] = substr($contexte['date_sortie'],0,10);
		$contexte['heure_retour'] = substr($contexte['date_retour'],12,5);
		$contexte['date_retour'] = substr($contexte['date_retour'],0,10);
	}
	/* ajout du journal et du montant qui ne se trouvent pas dans la table asso_prets et ne sont donc pas charges par editer_objet_charger */
	$contexte['journal'] = $journal;
	$contexte['montant'] = $montant;

	/* on concatene au _hidden inseres dans $contexte par l'appel a formulaire_editer_objet les id_compte et id_ressource qui seront utilises dans l'action editer_asso_prets */
	$contexte['_hidden'] .= "<input type='hidden' name='id_compte' value='$id_compte' />";
	$contexte['_hidden'] .= "<input type='hidden' name='id_ressource' value='$contexte[id_ressource]' />";
	$contexte['_hidden'] .= "<input type='hidden' name='ud' value='$contexte[ud]' />";

	/* si id_emprunteur est egal a 0, c'est que le champ est vide, on ne prerempli rien */
	if (!$contexte['id_emprunteur'])
		$contexte['id_emprunteur']='';
	/* paufiner la presentation des valeurs  */
	if ($contexte['montant'])
		$contexte['montant'] = association_nbrefr($contexte['montant']);
	if ($contexte['prix_unitaire'])
		$contexte['prix_unitaire'] = association_nbrefr($contexte['prix_unitaire']);
	if ($contexte['duree'])
		$contexte['duree'] = association_nbrefr($contexte['duree']);

	// on ajoute les metas destinations
	if ($GLOBALS['association_metas']['destinations']) {
		include_spip('inc/association_comptabilite');
		/* on recupere les destinations associees */
		$dest_id_montant = association_liste_destinations_associees($id_compte);
		if (is_array($dest_id_montant)) {
			$contexte['id_dest'] = array_keys($dest_id_montant);
			$contexte['montant_dest'] = array_values($dest_id_montant);
		} else {
			$contexte['id_dest'] = '';
			$contexte['montant_dest'] = '';
		}
		$contexte['unique_dest'] = true;
		$contexte['defaut_dest'] = $GLOBALS['association_metas']['dc_prets'];; /* ces variables sont recuperees par la balise dynamique directement dans l'environnement */
	}
	return $contexte;
}

function formulaires_editer_asso_prets_verifier_dist($id_pret)
{
	$erreurs = array();
	/* on verifie que montant et duree ne soient pas negatifs */
	set_request('montant', _request('prix_unitaire')*_request('duree') );
	if ($erreur = association_verifier_montant(_request('montant')) )
		$erreurs['montant'] = $erreur;
	if ($erreur = association_verifier_montant(_request('prix_unitaire')) )
		$erreurs['prix_unitaire'] = $erreur;
	if ($erreur = association_verifier_montant(_request('duree')) )
		$erreurs['duree'] = $erreur;
	/* verifier si on a un numero d'adherent qu'il existe dans la base */
	if ($erreur = association_verifier_membre(_request('id_emprunteur')) )
		$erreurs['id_emprunteur'] = $erreur;
	/* verifier si besoin que le montant des destinations correspond bien au montant de l'opération */
	if (($GLOBALS['association_metas']['destinations']) && !array_key_exists('montant', $erreurs)) {
		include_spip('inc/association_comptabilite');
		if ($err_dest = association_verifier_montant_destinations(_request('montant'))) {
			$erreurs['destinations'] = $err_dest;
		}
	}
	/* verifier les dates */
	if ($erreur = association_verifier_date(_request('date_sortie')) )
		$erreurs['date_sortie'] = $erreur;
	if ($erreur = association_verifier_date(_request('date_retour')) )
		$erreurs['date_retour'] = $erreur;
	if (count($erreurs)) {
		$erreurs['message_erreur'] = _T('asso:erreur_titre');
	}
	return $erreurs;
}

function formulaires_editer_asso_prets_traiter_dist($id_pret)
{
	$id_ressource = intval(_request('id_ressource'));
	return formulaires_editer_objet_traiter('asso_prets', $id_pret, '', '',  generer_url_ecrire('prets',"id=$id_ressource"), '');
}

?>
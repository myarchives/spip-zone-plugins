<?php
/***************************************************************************
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Francois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

// recupere dans la table de comptes et celle des destinations la liste des destinations associees a une operation
// le parametre correspond a l'id_compte de l'operation dans spip_asso_compte (et spip_asso_destination)
function association_liste_destinations_associees($id_compte)
{
	if (!$id_compte) return '';

	if ($destination_query = sql_select('spip_asso_destination_op.id_destination, spip_asso_destination_op.recette, spip_asso_destination_op.depense, spip_asso_destination.intitule', 'spip_asso_destination_op RIGHT JOIN spip_asso_destination ON spip_asso_destination.id_destination=spip_asso_destination_op.id_destination', "id_compte=$id_compte", '', 'spip_asso_destination.intitule'))
	{
		$destination = array();
		while ($destination_op = sql_fetch($destination_query))	{
			/* soit recette soit depense est egal a 0, donc pour l'affichage du montant on se contente les additionner */
			$destination[$destination_op[id_destination]] = $destination_op[recette]+$destination_op[depense]; 
		}
		if (count($destination) == 0) $destination = '';
	}
	else
	{
		$destination='';
	}

	return $destination;
}

// retourne une liste d'option HTML de l'ensemble des destinations de la base, ordonee par intitule
function association_toutes_destination_option_list()
{
	$liste_destination = '';
	$sql = sql_select('id_destination,intitule', 'spip_asso_destination', "", "", "intitule");
	while ($destination_info = sql_fetch($sql)) {
		$id_destination = $destination_info['id_destination'];
	 	$liste_destination .= "<option value='$id_destination'>".$destination_info['intitule'].'</option>';
	}
	return $liste_destination;
}

// retourne dans un <div> le code HTML/javascript correspondant au selecteur de destinations dynamique
// le premier parametre permet de donner un tableau de destinations deja selectionnees(ou '' si on ajoute une operation)
// le second parametre (optionnel) permet de specifier si on veut associer une destination unique, par default on peut ventiler sur
// plusieurs destinations
// le troisieme parametre permet de regler une destination par defaut[contient l'id de la destination] - quand $destination est vide
function association_editeur_destinations($destination, $unique='', $defaut='')
{
	// recupere la liste de toutes les destination dans un code HTML <option value="destination_id">destination</option>
	$liste_destination = association_toutes_destination_option_list();

	$res = '';

	if ($liste_destination)	{
		$res = "<script type='text/javascript' src='".find_in_path("javascript/jquery.destinations_form.js")."'></script>";
		$res .= '<label for="destination"><strong>'
		. _T('asso:destination')
		. '&nbsp;:</strong></label>'
		. '<div id="divTxtDestination" class="formulaire_edition_destinations">';

		$idIndex=1;
		if ($destination != '') { /* si on a une liste de destinations (on edite une operation) */
			foreach ($destination as $destId => $destMontant) {						
				$liste_destination_selected = preg_replace('/(value=\''.$destId.'\')/', '$1 selected="selected"', $liste_destination);
				$res .= '<div class="formo" id="row'.$idIndex.'">';
				$res .= '<li class="editer_id_dest['.$idIndex.']">'
				. '<select name="id_dest['.$idIndex.']" id="id_dest['.$idIndex.']" >'
				. $liste_destination_selected
				. '</select></li>';
				if ($unique==false) {
					$res .= '<li class="editer_montant_dest['.$idIndex.']"><input name="montant_dest['.$idIndex.']" value="'
					. association_nbrefr(association_recupere_montant($destMontant))
					. '" type="text" id="montant_dest['.$idIndex.']" /></li>'
					. "<button class='destButton' type='button' onClick='addFormField(); return false;'>+</button>";
					if ($idIndex>1)	{
						$res .= "<button class='destButton' type='button' onClick='removeFormField(\"#row".$idIndex."\"); return false;'>-</button>";
					}
				}
				$res .= '</div>';
				$idIndex++;
			}
		}
		else {/* pas de destination deja definies pour cette operation */
			if ($defaut!='') {
				$liste_destination = preg_replace('/(value=\''.$defaut.'\')/', '$1 selected="selected"', $liste_destination);
			}
			$res .= '<div id="row1" class="formo"><li class="editer_id_dest[1]"><select name="id_dest[1]" id="id_dest[1]" >'
			. $liste_destination
			. '</select></li>';
			if (!$unique) {
				$res .= '<li class="editer_montant_dest[1]"><input name="montant_dest[1]" value="'
				. ''
				. '" type="text" id="montant_dest[1]"/></li>'
				. "<button class='destButton' type='button' onClick='addFormField(); return false;'>+</button>";
			}
			$res .= '</div>';
		}

		if ($unique==false) $res .= '<input type="hidden" id="idNextDestination" value="'.($idIndex+1).'">';
		$res .= '</div>';
	}
	return $res;
}

/* Ajouter une operation dans spip_asso_comptes ainsi que si necessaire dans spip_asso_destination_op */
function association_ajouter_operation_comptable($date, $recette, $depense, $justification, $imputation, $journal, $id_journal)
{
	include_spip('base/association');		

	$id_compte = sql_insertq('spip_asso_comptes', array(
		    'date' => $date,
		    'imputation' => $imputation,
		    'recette' => $recette,
		    'depense' => $depense,
		    'journal' => $journal,
		    'id_journal' => $id_journal,
		    'justification' => $justification));

	// on laisse passer ce qui est peut-etre une erreur,
	// pour ceux qui ne definisse pas de plan comptable.
	// Mais ce serait bien d'envoyer un message d'erreur au navigateur
	// plutot que de le signaler seulement dans les log
	if (!$imputation) {
		spip_log("imputation manquante dans $id_compte, $date, $recette, $depense, $justification, $journal, $id_journal");
	}
	/* Si on doit gerer les destinations */
	if ($GLOBALS['association_metas']['destinations']=="on")
	{
		association_ajouter_destinations_comptables($id_compte, $recette, $depense);
	}

	return $id_compte;

}

/* modifier une operation dans spip_asso_comptes ainsi que si necessaire dans spip_asso_destination_op */
function association_modifier_operation_comptable($date, $recette, $depense, $justification, $imputation, $journal, $id_journal, $id_compte)
{
	include_spip('base/association');		

	/* Si on doit gerer les destinations */
	if ($GLOBALS['association_metas']['destinations']=="on")
	{
		$err = association_ajouter_destinations_comptables($id_compte, $recette, $depense);
	}

	// tester $id_journal, si il est null, ne pas le modifier afin de ne pas endommager l'entree dans la base en editant directement depuis le libre de comptes
	if ($id_journal) {
		sql_updateq('spip_asso_comptes', array(
			    'date' => $date,
			    'imputation' => $imputation,
			    'recette' => $recette,
			    'depense' => $depense,
			    'journal' => $journal,
			    'id_journal' => $id_journal,
			    'justification' => $justification),
			    "id_compte=$id_compte");
	} else {
		sql_updateq('spip_asso_comptes', array(
			    'date' => $date,
			    'imputation' => $imputation,
			    'recette' => $recette,
			    'depense' => $depense,
			    'journal' => $journal,
			    'justification' => $justification),
			    "id_compte=$id_compte");

	}

	return $err;
}

/* fonction de verification des montants de destinations entres */
/* le parametre d'entree est le montant total attendu, les montants des destinations sont recuperes */
/* directement dans $_POST */
function association_verifier_montant_destinations($montant_attendu)
{
	$err = '';

	$toutesDestinations = _request('id_dest');
	$toutesDestinationsMontants = _request('montant_dest');

	/* on verifie que le montant des destinations correspond au montant global et qu'il n'y a pas deux fois la meme destination (uniquement si on a plusieurs destinations) */
	$total_destination = 0;
	$id_inserted = array();

	if (count($toutesDestinations) > 1) {
		foreach ($toutesDestinations as $id => $id_destination)
		{		
			/* on verifie qu'on n'a pas deja insere une destination avec cette id */
			if (!array_key_exists($id_destination,$id_inserted)) {
				$id_inserted[$id_destination]=0;
			}
			else {
				$err = _T('asso:erreur_destination_dupliquee');
			}

			$total_destination += association_recupere_montant($toutesDestinationsMontants[$id]); /* les montants sont dans un autre tableau aux meme cles */
		}
	
		/* on verifie que la somme des montants des destinations correspond au montant attendu */
		if ($montant_attendu != $total_destination) {
			$err .= _T('asso:erreur_montant_destination');
		}

	} else { /* une seule destination, le montant peut ne pas avoir ete precise, dans ce cas pas de verif, c'est le montant attendu qui sera entre dans la base */
		/* quand on a une seule destination, l'id dans les tableaux est forcement 1 par contruction de l'editeur */
		if ($toutesDestinationsMontants[1]) {
			$montant = association_recupere_montant($toutesDestinationsMontants[1]);
			/* on verifie que le montant indique correspond au montant attendu */
			if ($montant_attendu != $montant) {
				$err = _T('asso:erreur_montant_destination');
			}
		}
	}
	return $err;
}

/* fonction permettant d'ajouter/modifier les destinations comptables (presente dans $_POST) a une operation comptable */
function association_ajouter_destinations_comptables($id_compte, $recette, $depense)
{
	include_spip('base/association');

	/* on efface de la table destination_op toutes les entrees correspondant a cette operation  si on en trouve*/
	sql_delete("spip_asso_destination_op", "id_compte=$id_compte");

	if ($recette>0) {
		$attribution_montant = "recette";
	}
	else {
		$attribution_montant = "depense";
	}

	$toutesDestinations = _request('id_dest');
	$toutesDestinationsMontants = _request('montant_dest');

	if (count($toutesDestinations) > 1) {
		foreach ($toutesDestinations as $id => $id_destination)	{
			$montant = association_recupere_montant($toutesDestinationsMontants[$id]);	/* le tableau des montants a des cles indentique a celui des id */
			sql_insertq('spip_asso_destination_op', array(
			    'id_compte' => $id_compte,
			    'id_destination' => $id_destination,
			    $attribution_montant => $montant));
		}
	} else { /* une seule destination, le montant peut ne pas avoir ete precise, on entre directement le total recette+depense */
		sql_insertq('spip_asso_destination_op', array(
		    'id_compte' => $id_compte,
		    'id_destination' => $toutesDestinations[1],
		    $attribution_montant => $depense+$recette));
	}
}

function inc_association_imputation_dist($nom, $table='')
{
	$champ = ($table ? ($table . '.') : '') . 'imputation';
	return $champ . '=' . sql_quote($GLOBALS['association_metas'][$nom]);
}

/* valide le plan comptable: on doit avoir au moins deux classes de comptes differentes */
/* le code du compte doit etre unique */
/* le code du compte doit commencer par un chiffre egal a sa classe */
function association_valider_plan_comptable()
{
	$classes = array();
	$codes = array();
	/* recupere le code et la classe de tous les comptes du plan comptable */
	$query = sql_select("code, classe", "spip_asso_plan");
	while ($data = sql_fetch($query)) {
		$classe = $data['classe'];
		$code = $data['code'];
		$classes[$classe] = 0; /* on comptes les classes differentes */
		if(array_key_exists($code, $codes)) {
			return false; /* on a deux fois le meme code */
		} else {
			$codes[$code] = 0;
		}
		/* on verifie que le code est bien de la forme chiffre-chiffre-caracteres alphanumeriques et que le premier digit correspond a la classe */
		if ((!preg_match("/^[0-9]{2}\w*$/", $code)) || ($code[0] != $classe)) return false;
	}
	if (count($classes)<2) return false; /* on doit avoir au moins deux classes differentes */

	return true;
}
?>

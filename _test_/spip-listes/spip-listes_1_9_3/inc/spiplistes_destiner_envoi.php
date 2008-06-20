<?php
// Orginal From SPIP-Listes-V :: Id: spiplistes_destiner_envoi.php paladin@quesaco.org
// $LastChangedRevision$
// $LastChangedBy$
// $LastChangedDate$

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/spiplistes_api');

/*
	Formulaire de s�lection destinataire

	$flag_editable: si true, possibilit� de modifier le destinataire
	sinon, ne fait qu'afficher l'�tat
	
	Renvoie :
	$$nom_bouton_validation: si bouton de validation press�
	$radio_destination: d�termine le choix
	-> soit 'email_test' si adresse mail choisie
	-> soit 'id_liste' si c'est une liste qui est choisie
	$email_test: adresse email de test
	$id_liste: id de la liste choisie
*/
function spiplistes_destiner_envoi ($id_courrier, $id_liste, $flag_editable
	, $statut, $type, $nom_bouton_validation, $email_test = "") {

	include_spip('inc/presentation');
	include_spip('inc/texte');
	include_spip('inc/actions');
	include_spip('inc/date');

	global $spip_lang_left
		, $spip_lang_right
		, $options
		;

	$id_liste = intval($id_liste);
	
	$result = 
		$destinataire = "";
	
	if($id_liste) {
		if($row = sql_fetsel("titre", "spip_listes", "id_liste=".sql_quote($id_liste))) {
			$destinataire = $row['titre'];
		}
	}
	else if (!empty($email_test)) {
		$destinataire = $email_test;
	}

	if(empty($destinataire)) {
		$destinataire = "<span style='color:gray;font-size:90%;'>"._T('spiplistes:Choix_non_defini')."</span>";
	}

	$invite =  "<strong><span class='verdana1' style='text-transform: uppercase;'>"
		. _T('spiplistes:Destination')
		. ' : </span> '
		.  $destinataire
		.  "</strong>"
		;
			
	if($flag_editable && (($statut == _SPIPLISTES_STATUT_REDAC) || ($statut == _SPIPLISTES_STATUT_READY))) {

			$adresse_test = $GLOBALS['auteur_session']['email'];
			$listes_abos = spiplistes_listes_lister_abos();
			$liste_disabled = $listes_abos ? "" : " disabled='disabled'";
			// propose l'envoi en test
			$masque = ""
				. "<ul class='verdana2' style='list-style-type:none;padding-left:0;'>"
				. "<li> <input type='radio' name='radio_destination' value='email_test' checked='checked' id='desttest' />"
				. "<label for='desttest'>"._T('spiplistes:email_tester')."</label> : "
				. "<input type='text' name='email_test' value='$adresse_test' class='fondo' size='35' />\n"
				. "</li>"
				. "<li> <input type='radio' name='radio_destination' value='id_liste' id='destlist' $liste_disabled />"
				. "<label for='destlist'>"._T('spiplistes:listes_de_diffusion_')."</label> : "
				;
			// propose les listes
			if($listes_abos) {
				$masque .= ""
					. "<select class='verdana2' name='id_liste' onchange='document.getElementById(\"destlist\").checked=true;' >\n"
					;
				foreach($listes_abos as $row) {
					$checked = ($id_liste == $row['id_liste']) ? "checked='checked'" : "";
					$nb_abos = 
						($row['nb_abos']  > 0)
						? spiplistes_singulier_pluriel_str_get(
							$row['nb_abos']
							, _T('spiplistes:nb_abonnes_sing')
							, _T('spiplistes:nb_abonnes_plur')
							)
						: _T('spiplistes:sans_abonne')
						;
					$option_disabled = ($row['nb_abos']  > 0) ? "" : "disabled='disabled'";
					$masque .= "<option value='" . $row['id_liste'] . "' $checked $option_disabled>" 
						. $row['titre'] . " (" . $nb_abos . ")</option>\n";
				}
				$masque .= ""
					. "</select>\n"
					;
			}
			else {
				$masque .= _T('spiplistes:aucune_liste_dispo');
			}
			$masque .= ""
				. "</li>"
				. "</ul>"
				. "<div style='text-align:right;'>"
				. "<input type='submit' name='$nom_bouton_validation' value=\""._T('bouton_valider')."\" class='fondo' /></div>\n"
				;
		
		// enveloppe dans un formulaire
		$masque = ""
				. "<form action='".generer_url_ecrire(_SPIPLISTES_EXEC_COURRIER_GERER,'id_courrier='.$id_courrier)."' method='post'>\n"
				. $masque
				. "</form>\n"
				;
		
		$result = block_parfois_visible('destinerblock', $invite, $masque, 'text-align: left');
	}
	else {
		$result = $invite;
	}

	if(!empty($result)) {
		$result =  "<div style='margin-top:1ex;'>" . debut_cadre_couleur('',true) . $result .  fin_cadre_couleur(true) ."</div>\n";
	}

	return ($result);
}

?>
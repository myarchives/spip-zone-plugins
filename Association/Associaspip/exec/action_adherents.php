<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations
 *
 * @copyright Copyright (c) 2007 (v1) Bernard Blazin & Francois de Montlivault
 * @copyright Copyright (c) 2010--2011 (v2) Emmanuel Saint-James & Jeannot Lapin
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip ('inc/navigation_modules');

function exec_action_adherents() {
	$action_adherents = _request('action_adherents');
	if (!autoriser('editer_membres', 'association') ||
		(($action_adherents=='grouper' || $action_adherents=='degrouper' ) && !autoriser('editer_groupes', 'association', 100)) ) { // pour agir sur les adherents il faut avoir le droit d'edition sur les adherents ainsi que le droit de gestion des groupes si c'est ca qu'on modifie.
			include_spip('inc/minipres');
			echo minipres();
	} else {
		$id_auteurs = association_recuperer_liste('id_auteurs', TRUE);
		if (!($action_adherents && $id_auteurs)) {
			include_spip('inc/minipres');
			echo minipres(_T('asso:erreur_titre'));
		} else {
			onglets_association('titre_onglet_membres', 'adherents');
			// info
			echo association_totauxinfos_intro(_T('asso:confirmation'));
			// datation et raccourcis
			raccourcis_association('adherents');
			if ($action_adherents=='desactive') {
				$statut_courant = _request('statut_courant');
				if($statut_courant==='sorti') {
					debut_cadre_association('annonce.gif', 'activation_des_adherents');
					echo '<p>'. _T('asso:adherent_message_detail_activation').'</p>';
					echo '<p>'. _T('asso:adherent_message_confirmer_activation').' : </p>';
				} else {
					debut_cadre_association('annonce.gif', 'desactivation_des_adherents');
					echo '<p>'. _T('asso:adherent_message_detail_desactivation').'</p>';
					echo '<p>'. _T('asso:adherent_message_confirmer_desactivation').' : </p>';
				}
				echo modification_adherents($id_auteurs,'desactiver', $statut_courant);
			}
			if ($action_adherents=='delete') {
				debut_cadre_association('annonce.gif', 'suppression_des_adherents');
				echo '<p>'. _T('asso:adherent_message_detail_suppression').'</p>';
				echo '<p>'. _T('asso:adherent_message_confirmer_suppression').' : </p>';
				echo modification_adherents($id_auteurs,'supprimer');
			}
			if ($action_adherents=='grouper') {
				debut_cadre_association('annonce.gif', 'rejoindre_un_groupe');
				echo _T('asso:adherent_message_grouper');
				echo modification_adherents($id_auteurs,'grouper');
			}
			if ($action_adherents=='degrouper') {
				debut_cadre_association('annonce.gif', 'quitter_un_groupe');
				echo _T('asso:adherent_message_degrouper');
				echo modification_adherents($id_auteurs,'degrouper');
			}
			fin_page_association();
		}
	}
}

function modification_adherents($tab, $action, $statut='') {
	$res ='';
	if ($action=='grouper' || $action=='degrouper') { // on ajoute une table des groupes si il y en a
		$res .='<p class="titrem">'._T('asso:groupes_membre').'</p>';
		$query = sql_select('id_groupe, nom','spip_asso_groupes', 'id_groupe>=100', '', 'nom'); // on ne considere que les groupes d'id >=100, les autres c'est pour la gestion des autorisations
		if (sql_count($query)) {
			$res .='<table>';
			while($data = sql_fetch($query)) {
				$res .= '<tr><td>'.$data['nom'].'</td>'. association_bouton_coch('id_groupe', $data['id_groupe']) .'</tr>';
			}
			$res .='</table>';
			$res .='<p class="titrem">'._T('asso:adherents_dp').'</p>';
		}
		if ($action=='grouper') {
			$action_file = 'ajouter_membres_groupe';
		} else {
			$action_file = 'exclure_membres_groupe';
		}
	} else {
		$action_file = $action.'_adherents';
	}
	$res .='<table>';
	$in = sql_in('id_auteur', $tab);
	$query = sql_select('sexe, id_auteur, prenom, nom_famille','spip_asso_membres', $in, '', 'nom_famille');
	while($data = sql_fetch($query)) {
		$res .= '<tr><td>' . $data['id_auteur'] .association_formater_nom($data['sexe'], $data['prenom'], $data['nom_famille'], 'b').'</td>'. association_bouton_coch('id_auteurs', $data['id_auteur']) .'</tr>';
	}
	sql_free($query);
	$res .='<tr>';
	$res .='<td colspan="2" class="boutons">';
	$res .='<input type="submit" value="'._T('asso:bouton_confirmer').'" /></td></tr>';
	if ($statut) {
		$res .='<input type="hidden" name="statut_courant" value="'.$statut.'" />';
	}
	$res .='</table>';
	// count est juste du bruit de fond pour la secu
	return redirige_action_post($action_file, count($tab), 'adherents', '', $res);
}

?>
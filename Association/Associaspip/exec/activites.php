<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations
 *
 * @copyright Copyright (c) 2007 (v1) Bernard Blazin & Francois de Montlivault
 * @copyright Copyright (c) 2010--2011 (v2) Emmanuel Saint-James & Jeannot Lapin
 *
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION'))
	return;

function exec_activites() {
	if (!autoriser('associer', 'activites')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		include_spip ('inc/navigation_modules');
		$id_evenement = association_passeparam_id('evenement');
		list($annee, $critere_periode) = association_passeparam_annee('debut', 'evenements', $id_evenement);
		if ($id_evenement) { // la presence de ce parametre interdit la prise en compte d'autres (a annuler donc si presents dans la requete)
			$id_mot = $incription = '';
		} else { // on peut prendre en compte les filtres ; on recupere les parametres de :
			$id_mot = association_recuperer_entier('mot'); // id du mot cle
			$inscription = _request('inscription');
		}
		onglets_association('titre_onglet_activite', 'activites');
		// TOTAUX : nombre d'activites de l'annee en cours selon iscriptions
		$id_evenements = sql_in_select('id_evenement', 'id_evenement', 'spip_evenements', $critere_periode);
		$liste_effectifs = array();
		$liste_effectifs['impair'] = sql_countsel('spip_asso_activites', $id_evenements, 'id_evenement');
		$liste_effectifs['pair'] = sql_countsel('spip_evenements', $critere_periode)-$liste_effectifs['impair'];
		echo association_totauxinfos_effectifs('activites', array(
			'pair'=>array( 'activites_sans_inscrits', $liste_effectifs['pair'], ),
			'impair'=>array( 'activites_avec_inscrits', $liste_effectifs['impair'], ),
		));
		// STATS sur toutes les participations
//		echo association_totauxinfos_stats('participations_par_personne_par_activite', 'activites', array('activite_entete_inscrits'=>'inscrits','entete_montant'=>'montant',), "DATE_FORMAT(date_inscription, '%Y')=$annee"); // v1
		echo association_totauxinfos_stats('participations_par_personne_par_activite', 'activites AS a INNER JOIN spip_evenements AS e ON a.id_evenement=e.id_evenement', array('entete_quantite'=>'inscrits','entete_montant'=>'montant',), $critere_periode); // v2
		// TOTAUX : montants des participations durant l'annee en cours
		$data = sql_fetsel('SUM(recette) AS somme_recettes, SUM(depense) AS somme_depenses', 'spip_asso_comptes', "DATE_FORMAT('date', '%Y')=$annee AND imputation=".sql_quote($GLOBALS['association_metas']['pc_activites']) ); // 1. on peut interroger les recettes directement dans la table des activites 2. les paiement en avance (reservations qui tombent dans l'anne d'avant) ou en retard (paiement a credit qui tombent dans l'annee d'apres) peuvent fausser la donne
		echo association_totauxinfos_montants('activites', $data['somme_recettes'], $data['somme_depenses']);
		// datation et raccourci vers la gestion des evenements
		if ( test_plugin_actif('SIMPLECAL') ) { // gestion des evenements avec Simple Calendrier
			raccourcis_association(array(), array(
				'evenements' => array('simplecal-logo-16.png', 'evenement_tous'),
			) );
		} elseif ( test_plugin_actif('AGENDA') ) { // gestion des evenements avec Agenda 2
			raccourcis_association(array(), array(
				'evenements' => array('agenda-evenements-16.png', 'agenda_evenements'),
			) );
		} else { // pas de bloc de raccourcis
			echo association_date_du_jour();
			echo fin_boite_info(TRUE);
		}
		debut_cadre_association('activites.gif','activite_titre_toutes_activites');
		// FILTRES
		$filtre_motscles = '<select name="mot" onchange="form.submit()">';
		$filtre_motscles .= '<option value="">' ._T('asso:entete_tous') .'</option>';
		$query_groupes = sql_select('id_groupe, titre', 'spip_groupes_mots', "tables_liees LIKE '%evenements%'");
		while($data_groupes = sql_fetch($query_groupes)) {
			$filtre_motscles .= '<optgroup label="'.$data_groupes['titre'].'">';
			$query_mots = sql_select('id_mot, titre', 'spip_mots', 'id_groupe='.$data_groupes['id_groupe']);
			while($data_mots = sql_fetch($query_mots)) {
				$filtre_motscles .= '<option value="'.$data_mots['id_mot'].'"';
				$filtre_motscles .= ($id_mot==$data_mots['id_mot']?' selected="selected"':'');
				$filtre_motscles .= '>'.$data_mots['titre'].'</option>';
			}
			$filtre_motscles .= '</optgroup>';
		}
		$filtre_motscles .= '</select>';
		$filtre_incrits = '<select name="inscription" onchange="form.submit()">';
		$filtre_incrits .= '<option value="">' ._T('asso:entete_tous') .'</option>';
		$filtre_incrits .= '<option value="avec"';
		$filtre_incrits .= ($inscription=='avec'?' selected="selected"':'');
		$filtre_incrits .= '>'. _T('asso:activites_avec_inscrits') .'</option>';
		$filtre_incrits .= '<option value="sans"';
		$filtre_incrits .= ($inscription=='sans'?' selected="selected"':'');
		$filtre_incrits .= '>'. _T('asso:activites_sans_inscrits') .'</option>';
		$filtre_incrits .= '</select>';
		filtres_association(array(
			'annee' => array($annee, 'evenements', 'debut'),
#			'id' => $id_evenement,
		), 'activites', array(
			'mot' => $filtre_motscles,
			'inscription' => $filtre_incrits,
		));
		// TABLEAU
		$q_from = 'spip_evenements AS e LEFT JOIN spip_asso_activites AS a ON e.id_evenement=a.id_evenement';
		$q_where = $critere_periode;
		if ($id_mot) {
			$mc_sel = ', m.id_mot AS motact';
			$q_from .= ' LEFT JOIN spip_mots_evenements AS k ON  k.id_evenement=e.id_evenement LEFT JOIN spip_mots AS m ON k.id_mot=m.id_mot';
			//$q_where .= " AND (m.id_mot=$id_mot OR m.titre LIKE '$mot' OR m.titre IS NULL) ";
			$q_where .= " AND m.id_mot=$id_mot";
		} else {
			$mc_sel = '';
		}
		if ($inscription) {
			$q_having = 'inscriptions'. ($inscription=='avec'?'>':'=') .'0';
//			$ia_having = 'COUNT(a.id_activite)'. ($inscription=='avec'?'>':'=') .'0';
		} else {
			$q_having = '';
		}
		echo association_bloc_listehtml(
			array("e.id_evenement, e.date_debut, e.date_fin, e.titre  AS intitule, e.lieu,  COUNT(a.id_activite) AS inscriptions, SUM(a.inscrits) AS quantites, SUM(a.montant) AS montants, CASE COUNT(a.id_activite) WHEN 0 THEN 0 ELSE 1 END AS participations $mc_sel", $q_from, $q_where, 'e.id_evenement', 'date_debut DESC, date_fin DESC', sql_asso1page(), $q_having), // requete
			array(
				'id_evenement' => array('asso:entete_id', 'entier'),
				'date_debut' => array('agenda:evenement_date_du', 'date', 'dtstart'),
				'date_fin' => array('agenda:evenement_date_au', 'date', 'dtend'),
				'intitule' => array('asso:entete_intitule', 'texte', '', '', 'summary'),
				'lieu' => array('agenda:evenement_lieu', 'texte', '', '', 'location'),
				'inscriptions' => array('asso:activite_entete_inscrits', 'entier'),
				'quantites' => array('asso:entete_quantite', 'entier'),
				'montants' => array('asso:entete_montant', 'prix', 'fee'),
			), // entetes et formats des donnees
			array(
				array('act', 'activite_bouton_ajouter_inscription', 'creer-12.gif', 'edit_activite', 'id_evenement=$$'),
				array('act', 'activite_bouton_voir_liste_inscriptions', 'voir-12.png', 'inscrits_activite', 'id=$$'),
			), // boutons d'action
			'id_evenement', // champ portant la cle des lignes et des boutons
			array('pair vevent', 'impair vevent'), 'participations', $id_evenement
		);
		//SOUS-PAGINATION
		echo association_selectionner_souspage(array($q_from, $q_where, 'e.id_evenement', $q_having), "activites&annee=$annee".($mot?"&mot=$mot":'').($inscription?"&inscription='$inscription'":'') );
		fin_page_association();
	}
}

?>
<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Fran�ois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/


if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip ('inc/navigation_modules');

function exec_edit_activite()
{
	if (!autoriser('associer', 'activites')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		$id_activite = intval(_request('id'));
		$id_evenement = $id_activite ? sql_getfetsel('id_evenement', 'spip_asso_activites', "id_activite=$id_activite") : intval(_request('id_evenement'));
		onglets_association('titre_onglet_activite', 'activites');
		// INTRO : Rappel Infos Evenement
		$evenement = sql_fetsel('*', 'spip_evenements', "id_evenement=$id_evenement");
		$format = 'association_formater_'. (($evenement['horaire']=='oui')?'heure':'date');
		$infos['agenda:evenement_date_du'] = $format($evenement['date_debut'],'dtstart');
		$infos['agenda:evenement_date_au'] = $format($evenement['date_fin'],'dtend');
		$infos['agenda:evenement_lieu'] = '<span class="location">'.$evenement['lieu'].'</span>';
		echo '<div class="vevent">'. association_totauxinfos_intro('<span class="summary">'.$evenement['titre'].'</span>', 'evenement', $id_evenement, $infos, 'evenement') .'</div>';
		// datation et raccourcis
		raccourcis_association('');
		debut_cadre_association(($id_activite?'activites.gif':'panier_in.gif'), 'activite_titre_mise_a_jour_inscriptions');
		// formulaire
		echo recuperer_fond('prive/editer/editer_asso_activites', array (
			'id_activite' => $id_activite,
			'id_evenement' => $id_evenement,
		));
		fin_page_association();
	}
}

?>
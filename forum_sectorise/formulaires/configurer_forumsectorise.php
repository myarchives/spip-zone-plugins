<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/config');

function formulaires_configurer_forumsectorise_saisies_dist(){
	$config = lire_config('forumsectorise');

	return array(
		array(
			'saisie' => 'explication',
			'options' => array(
				'nom' => 'explication',
				'texte' => _T('forumsectorise:configurer_explication')
			)
		),
		array(
			'saisie' => 'secteur',
			'options' => array(
				'nom' => 'id_secteur',
				'label' => _T('forumsectorise:label_id_secteur'),
				'explication' => _T('forumsectorise:explication_id_secteur'),
				'multiple' => 'oui',
				'defaut' => $config['id_secteur']
			)
		),
		array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'type',
				'label' => _T('forumsectorise:label_type'),
				'explication' => _T('forumsectorise:explication_type'),
				'cacher_option_intro' => 'on',
				'defaut' => $config['type'],
            'datas' => array(
               'pos' => _T('bouton_radio_modere_posteriori'),
               'pri' => _T('bouton_radio_modere_priori'),
               'abo' => _T('bouton_radio_modere_abonnement'),
               'non' => _T('info_pas_de_forum')
            )
			)
		),
		array(
			'saisie' => 'radio',
			'options' => array(
				'nom' => 'option',
				'label' => _T('forumsectorise:label_option'),
				'explication' => _T('forumsectorise:explication_option'),
				'multiple' => 'oui',
				'defaut' => $config['option'],
            'datas' => array(
               'futur' => _T('bouton_radio_articles_futurs'),
               'saufnon' => _T('bouton_radio_articles_tous_sauf_forum_desactive'),
               'tous' => _T('bouton_radio_articles_tous')
            )
			)
		)
	);

}

function formulaires_configurer_forumsectorise_traiter(){
	$tab_secteur = _request('id_secteur');
	$type = _request('type');
	$option = _request('option');
	$config = lire_config('forumsectorise');
	
	if ($tab_secteur != $config['id_secteur']) {
		include_spip('inc/invalideur');
		purger_repertoire(_DIR_SKELS);
	}

	// Appliquer les changements de moderation forum
	// option : futur, saufnon, tous
	if (in_array($option,array('tous', 'saufnon')) && count($tab_secteur)) {
		$where1 = ($option == 'saufnon') ? "accepter_forum != 'non'" : '';
		$where2 = sql_in('id_secteur',$tab_secteur) ;
		if(($where1!= '') && ($where2 != '')) {
			$where = $where1 . ' AND ' . $where2 ;
		} else {
			$where = $where1 . $where2 ;
		}
		sql_updateq('spip_articles', array('accepter_forum'=>$type), $where);
	}
}


?>
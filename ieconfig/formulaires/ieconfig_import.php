<?php


function ieconfig_saisies_import() {
	// Etape de selection du fichier
	if (!_request('_code_yaml') or _request('annuler') or _request('importer')) {
		$saisies = array (
			array(
				'saisie' => 'fieldset',
				'options' => array(
					'nom' => 'ieconfig_import_choix_fichier',
					'label' => '<:ieconfig:label_ieconfig_import_choix_fichier:>',
					'icone' => 'img/ieconfig-import.png'
				),
				'saisies' => array(
					array(
						'saisie' => 'input',
						'options' => array(
							'type' => 'file',
							'nom' => 'ieconfig_import_fichier',
							'label' => '<:ieconfig:label_ieconfig_import_fichier:>',
							'explication' => '<:ieconfig:explication_ieconfig_import_fichier:>'
						)
					),
					array(
						'saisie' => 'selection',
						'options' => array(
							'type' => 'selection',
							'nom' => 'ieconfig_import_local',
							'label' => '<:ieconfig:label_ieconfig_import_local:>',
							'explication' => '<:ieconfig:explication_ieconfig_import_local:>',
							'cacher_option_intro' => 'oui',
							'datas' => ieconfig_config_locales()
						)
					)
				)
			)
		);
	// Options d'importations
	} else {
		include_spip('inc/yaml');
		$config = yaml_decode(_request('_code_yaml'));
		$texte_explication = '<b>'._T('ieconfig:texte_nom').'</b> '._T_ou_typo($config['nom']);
		if ($config['description']!= '')
			$texte_explication .= '<br /><b>'._T('ieconfig:texte_description').'</b> '._T_ou_typo($config['description']);
		$saisies = array(
			array(
				'saisie' => 'explication',
				'options' => array(
					'nom' => 'import_details',
					'texte' => $texte_explication
				)
			)
		);
		// Le fichier contient-il une configuration des contenus du site
		if (isset($config['spip_contenu'])) {
			$texte_explication = _T('ieconfig:texte_spip_contenu_import_explication');
			$i = 0;
			foreach($config['spip_contenu'] as $meta => $valeur)
				if ($GLOBALS['meta'][$meta] != $valeur) {
					$texte_explication .= '<br />&raquo; '.$meta.' : '.$GLOBALS['meta'][$meta].' -> '.$valeur;
					$i++;
				}
			if ($i>0)
				$saisies_spip_contenu = array(
					array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => 'spip_contenu',
							'label' => '<:spip:onglet_contenu_site:>',
							'icone' => 'images/racine-site-24.gif'
						),
						'saisies' => array(
							array(
								'saisie' => 'explication',
								'options' => array(
									'nom' => 'spip_contenu_explication',
									'texte' => $texte_explication
								)
							),
							array(
								'saisie' => 'oui_non',
								'options' => array(
									'nom' => 'spip_contenu_importer',
									'label' => '<:ieconfig:label_importer:>',
									'defaut' => '',
								)
							)
						)
					)
				);
			else
				$saisies_spip_contenu = array(
					array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => 'spip_contenu',
							'label' => '<:spip:onglet_contenu_site:>',
							'icone' => 'images/racine-site-24.gif'
						),
						'saisies' => array(
							array(
								'saisie' => 'explication',
								'options' => array(
									'nom' => 'spip_contenu_explication',
									'texte' => '<:ieconfig:texte_configuration_identique:>'
								)
							)
						)
					)
				);
			$saisies = array_merge($saisies,$saisies_spip_contenu);
		}
		// Le fichier contient-il une configuration pour l'onglet interactivit�
		if (isset($config['spip_interactivite'])) {
			$texte_explication = _T('ieconfig:texte_spip_interactivite_import_explication');
			$i = 0;
			foreach($config['spip_interactivite'] as $meta => $valeur)
				if ($GLOBALS['meta'][$meta] != $valeur) {
					$texte_explication .= '<br />&raquo; '.$meta.' : '.$GLOBALS['meta'][$meta].' -> '.$valeur;
					$i++;
				}
			if ($i>0)
				$saisies_spip_interactivite = array(
					array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => 'spip_interactivite',
							'label' => '<:spip:onglet_interactivite:>',
							'icone' => 'images/forum-interne-24.gif'
						),
						'saisies' => array(
							array(
								'saisie' => 'explication',
								'options' => array(
									'nom' => 'spip_interactivite_explication',
									'texte' => $texte_explication
								)
							),
							array(
								'saisie' => 'oui_non',
								'options' => array(
									'nom' => 'spip_interactivite_importer',
									'label' => '<:ieconfig:label_importer:>',
									'defaut' => '',
								)
							)
						)
					)
				);
			else
				$saisies_spip_interactivite = array(
					array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => 'spip_interactivite',
							'label' => '<:spip:onglet_interactivite:>',
							'icone' => 'images/forum-interne-24.gif'
						),
						'saisies' => array(
							array(
								'saisie' => 'explication',
								'options' => array(
									'nom' => 'spip_interactivite_explication',
									'texte' => '<:ieconfig:texte_configuration_identique:>'
								)
							)
						)
					)
				);
			$saisies = array_merge($saisies,$saisies_spip_interactivite);
		}
		// On passe via le pipeline ieconfig
		$saisies = pipeline('ieconfig',array(
			'args' => array(
				'action' => 'form_import',
				'config' => $config
			),
			'data' => $saisies
		));
		// On identifie les �l�ments de config correspondant � des plugins non actifs
		// Convention : les cl�s du tableau de config correspondent aux pr�fixes des plugins
	}
	return $saisies;
}

function formulaires_ieconfig_import_charger_dist() {
	$saisies = ieconfig_saisies_import();
	$contexte = array(
		'_saisies' => $saisies
	);
	if (_request('_code_yaml') and !_request('annuler') and !_request('importer'))
		$contexte['_code_yaml'] = _request('_code_yaml');
	return array_merge(saisies_lister_valeurs_defaut($saisies),$contexte);
}

function formulaires_ieconfig_import_verifier_dist() {
	$erreurs = array();
	// Etape de selection du fichier
	if (!_request('_code_yaml')) {
		// On a rien transmis et pas de fichier local
		if (!_request('ieconfig_import_local') AND $_FILES['ieconfig_import_fichier']['name']=='')
			$erreurs['message_erreur'] = _T('ieconfig:message_erreur_fichier_import_manquant');
	}
	// Options d'import
	else {
		include_spip('inc/saisies');
		$erreurs = saisies_verifier(ieconfig_saisies_import());
	}
	return $erreurs;
}

function formulaires_ieconfig_import_traiter_dist() {
	// Si on est � l'�tape de s�lection d'un fichier de configuration
	// On place le code YAML dans le contexte
	if (!_request('_code_yaml')) {
		if ($_FILES['ieconfig_import_fichier']['name']!='')
			$fichier = $_FILES['ieconfig_import_fichier']['tmp_name'];
		else
			$fichier = _request('ieconfig_import_local');
		lire_fichier($fichier, $code_yaml);
		set_request('_code_yaml',$code_yaml);
	}
	// Si on valide l'import
	elseif (_request('importer') && _request('_code_yaml')) {
		include_spip('inc/yaml');
		$config = yaml_decode(_request('_code_yaml'));
		
		// Le fichier contient-il une configuration des contenus du site � importer
		if (isset($config['spip_contenu']) && _request('spip_contenu_importer')=='on') {
			foreach($config['spip_contenu'] as $nom => $valeur)
				ecrire_meta($nom,$valeur);
			ecrire_metas();
		}
		
		// Le fichier contient-il une configuration pour l'ongler interactivit�
		if (isset($config['spip_interactivite']) && _request('spip_interactivite_importer')=='on') {
			foreach($config['spip_interactivite'] as $nom => $valeur)
				ecrire_meta($nom,$valeur);
			ecrire_metas();
		}
		
		// On passe via le pipeline ieconfig
		$message_erreur = pipeline('ieconfig',array(
			'args' => array(
				'action' => 'import',
				'config' => $config
			),
			'data' => ''
		));
		
		if ($message_erreur!='')
			return array('message_erreur' => $message_erreur);
		else
			return array('message_ok' => _T('ieconfig:message_ok_import'));
	}
}

// Renvoie la liste des fichiers de configurations pr�sents dans un sous-r�pertoires ieconfig/
function ieconfig_config_locales() {
	static $liste_config = null;
	
	if (is_null($liste_config)){
		include_spip('inc/yaml');
		$liste_config = array();
		$match = ".+[.]yaml$";
		foreach (array_merge(find_all_in_path('ieconfig/', $match),find_all_in_path('tmp/ieconfig/', $match)) as $fichier => $chemin) {
			$config = yaml_decode_file($chemin);
			//on v�rifie s'il y a un champs nom
			if (isset($config['nom']))
				$liste_config[$chemin] = _T_ou_typo($config['nom']);
			else
				$liste_config[$chemin] = $fichier;
		}
	}
	return $liste_config;
}


?>
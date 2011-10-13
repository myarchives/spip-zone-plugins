<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_editer_client_saisies_dist($id_auteur, $retour=''){
	$conf=lire_config('clients/elm',array());
	
	$civilite=array();
	if (in_array("civilite", $conf) and !in_array("obli_civilite", $conf)) {
		$civ=lire_config('clients/elm_civ',array('m', 'mme'));
		$civ_t=array();
		foreach($civ as $v){
			// pas moyen de faire marcher array_merge ici
				array_push($civ_t, _T($v));
		}
		$civ_t = array_values($civ_t);
		$civ_t = array_combine($civ_t, $civ_t);
		$civilite=array(
			'saisie' => 'radio',
			'options' => array(
				'nom' => 'civilite',
				'label' => _T('contacts:label_civilite'),
				'datas' => $civ_t
			)
		);
	}elseif (in_array("civilite", $conf) and in_array("obli_civilite", $conf)) {
		$civ=lire_config('clients/elm_civ',array('m', 'mme'));
		$civ_t=array();
		foreach($civ as $v){
			// pas moyen de faire marcher array_merge ici
				array_push($civ_t, _T($v));
		}
		$civ_t = array_values($civ_t);
		$civ_t = array_combine($civ_t, $civ_t);
		$civilite=array(
			'saisie' => 'radio',
			'options' => array(
				'nom' => 'civilite',
				'label' => _T('contacts:label_civilite'),
				'obligatoire' => 'oui',
				'datas' => $civ_t
			)
		);
	}
	
	$complement=array();
	if (in_array("complement", $conf) and !in_array("obli_complement", $conf)) {
		$complement=array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'complement',
				'label' => _T('coordonnees:label_complement'),
			)
		);
	}elseif (in_array("complement", $conf) and in_array("obli_complement", $conf)) {
		$complement=array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'complement',
				'label' => _T('coordonnees:label_complement'),
				'obligatoire' => 'oui'
			)
		);
	}
	
	$numero=array();
	if (in_array("numero", $conf) and !in_array("obli_numero", $conf)) {
		$numero=array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'numero',
				'label' => _T('coordonnees:label_numero'),
			)
		);
	}elseif (in_array("numero", $conf) and in_array("obli_numero", $conf)) {
		$numero=array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'numero',
				'label' => _T('coordonnees:label_numero'),
				'obligatoire' => 'oui'
			)
		);
	}
	
	$pays=array();
	if (in_array("pays", $conf) and !in_array("obli_pays", $conf)) {
		$pays=array(
			'saisie' => 'pays',
			'options' => array(
				'nom' => 'pays',				
				'code_pays' => 'oui',
				'label' => _T('coordonnees:label_pays'),
			)
		);
	}elseif (in_array("pays", $conf) and in_array("obli_pays", $conf)) {
		$pays=array(
			'saisie' => 'pays',
			'options' => array(
				'nom' => 'pays',				
				'code_pays' => 'oui',
				'label' => _T('coordonnees:label_pays'),
				'obligatoire' => 'oui'
			)
		);
	}
	
	return array(
		$civilite,
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'prenom',
				'label' => _T('contacts:label_prenom'),
				'obligatoire' => 'oui'
			)
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'nom',
				'label' => _T('contacts:label_nom'),
				'obligatoire' => 'oui'
			)
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'email_rien',
				'label' => _T('contacts:label_email'),
				'disable' => 'oui',
			),
			'verifier' => array(
				'type' => 'email'
			)
		),
		$numero,
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'voie',
				'label' => _T('coordonnees:label_voie'),
				'obligatoire' => 'oui'
			)
		),
		$complement,
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'code_postal',
				'label' => _T('coordonnees:label_code_postal'),
				'obligatoire' => 'oui'
			)
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'ville',
				'label' => _T('coordonnees:label_ville'),
				'obligatoire' => 'oui'
			)
		),
		$pays
	);
}

function formulaires_editer_client_charger_dist($id_auteur, $retour=''){
	include_spip('inc/session');
	$contexte = array();
	
	// On vérifie qu'il y a un client correct (auteur+contact+adresse) quelque part
	if (
		$id_auteur > 0
		and $email = sql_getfetsel('email', 'spip_auteurs', 'id_auteur = '.intval($id_auteur))
		and $contact = sql_fetsel(
			'*',
			'spip_contacts_liens LEFT JOIN spip_contacts USING(id_contact)',
			array(
				'objet = '.sql_quote('auteur'),
				'id_objet = '.intval($id_auteur)
			)
		)
	){
		$contexte['email_rien'] = $email;
		foreach ($contact as $cle=>$valeur) {
			$contexte[$cle] = $valeur;
		}
		
		// S'il y a une adresse principale, on charge les infos
		if ($adresse = sql_fetsel(
			'*',
			'spip_adresses_liens LEFT JOIN spip_adresses USING(id_adresse)',
			array(
				'objet = '.sql_quote('auteur'),
				'id_objet = '.intval($id_auteur),
				'type = '.sql_quote('principale')
			)
		))
			$contexte = array_merge($contexte, $adresse);
			
		// S'il y a un numero principale, on charge les infos
		if ($numero = sql_fetsel(
			'*',
			'spip_numeros_liens LEFT JOIN spip_numeros USING(id_numero)',
			array(
				'objet = '.sql_quote('auteur'),
				'id_objet = '.intval($id_auteur),
				'type = '.sql_quote('principale')
			)
		))
			$contexte = array_merge($contexte, $numero);
	}
	// Sinon rien
	else{
		$contexte['editable'] = false;
	}
	
	return $contexte;
}

function formulaires_editer_client_verifier_dist($id_auteur, $retour=''){
	$erreurs = array();
	
	return $erreurs;
}

function formulaires_editer_client_traiter_dist($id_auteur, $retour=''){
	// Si redirection demandée, on refuse le traitement en ajax
	if ($retour) refuser_traiter_formulaire_ajax();
	
	$retours = array();
	
	// On modifie le contact
	$id_contact = sql_getfetsel(
		'id_contact',
		'spip_contacts_liens',
		'objet = '.sql_quote('auteur').' and id_objet = '.$id_auteur
	);
	$editer_contact = charger_fonction('editer_contact', 'action/');
	$editer_contact($id_contact);
	
	// Le pseudo SPIP est construit 
	set_request('nom', trim(_request('prenom').' '._request('nom'))); 
	
	// On modifie l'auteur
	$editer_auteur = charger_fonction('editer_auteur', 'action/');
	$editer_auteur($id_auteur);
	
	// On modifie l'adresse
	$id_adresse = sql_getfetsel(
		'id_adresse',
		'spip_adresses_liens',
		array(
			'objet = '.sql_quote('auteur'),
			'id_objet = '.$id_auteur,
			'type = '.sql_quote('principale')
		)
	);
	// S'il n'y a pas d'adresse principale, on la crée
	if (!$id_adresse){
		$id_adresse = 'oui';
		set_request('objet', 'auteur');
		set_request('id_objet', $id_auteur);
		set_request('type', 'principale');
	}
	
	$editer_adresse = charger_fonction('editer_adresse', 'action/');
	$editer_adresse($id_adresse);
	
	// On modifie le numero
	$id_numero = sql_getfetsel(
		'id_numero',
		'spip_numeros_liens',
		array(
			'objet = '.sql_quote('auteur'),
			'id_objet = '.$id_auteur,
			'type = '.sql_quote('principale')
		)
	);
	
	// S'il n'y a pas de numero de telephone principale, on le crée
	if (!$id_numero){
		$id_numero = 'oui';
		set_request('objet', 'auteur');
		set_request('id_objet', $id_auteur);
		set_request('type', 'principale');
	}
	
	$editer_numero = charger_fonction('editer_numero', 'action/');
	$editer_numero($id_numero);
	
	// Quand on reste sur la même page, on peut toujours éditer après
	$retours['editable'] = true;
	
	// Si on demande une redirection
	if ($retour) $retours['redirect'] = $retour;
	
	return $retours;
}

?>

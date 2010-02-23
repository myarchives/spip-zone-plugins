<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_construire_formulaire_charger($identifiant, $formulaire_initial=array()){
	include_spip('inc/saisies');
	$contexte = array();
	
	// On ajoute un préfixe devant l'identifiant, pour être sûr
	$identifiant = 'constructeur_formulaire_'.$identifiant;
	
	// On vérifie ce qui a été passé en paramètre 
	if (!is_array($formulaire_initial)) $formulaire_initial = array();
	
	// On initialise la session si elle est vide
	if (is_null($formulaire_actuel = session_get($identifiant))){
		session_set($identifiant, $formulaire_initial);
		$formulaire_actuel = $formulaire_initial;
	}
	
	// On passe ça pour l'affichage
	$contexte['_contenu'] = $formulaire_actuel;
	// On passe ça pour la récup plus facile des champs
	$contexte['_saisies_par_nom'] = $contexte['saisies_modifiees'] = saisies_recuperer_saisies($formulaire_actuel);
	
	// La liste des saisies
	$saisies_disponibles = saisies_lister_disponibles();
	$contexte['saisies_disponibles'] = $saisies_disponibles;
	
	return $contexte;
}

function formulaires_construire_formulaire_verifier($identifiant, $formulaire_initial=array()){
	include_spip('inc/saisies');
	$erreurs = array();
	// On ajoute un préfixe devant l'identifiant
	$identifiant = 'constructeur_formulaire_'.$identifiant;
	// On récupère le formulaire à son état actuel
	$formulaire_actuel = session_get($identifiant);
	// On récupère les saisies actuelles
	$saisies_actuelles = saisies_recuperer_saisies($formulaire_actuel);
	// La liste des saisies
	$saisies_disponibles = saisies_lister_disponibles();
	
	if ($nom = $configurer_saisie =  _request('configurer_saisie') or $nom = $enregistrer_saisie = _request('enregistrer_saisie')){
		$saisie = $saisies_actuelles[$nom];
		$form_config = $saisies_disponibles[$saisie['saisie']]['options'];
		array_walk_recursive($form_config, 'formidable_transformer_nom', "saisie_modifiee_${nom}[options][@valeur@]");
		$erreurs['configurer_'.$nom] = $form_config;
		$erreurs['positionner'] = '#configurer_'.$nom;
		
		if ($enregistrer_saisie){
			include_spip('inc/verifier');
			$vraies_erreurs = verifier_saisies($form_config);
			if ($vraies_erreurs){
				$erreurs = array_merge($erreurs, $vraies_erreurs);
			}
			else
				$erreurs = array();
		}
	}
	
	return $erreurs;
}

function formulaires_construire_formulaire_traiter($identifiant, $formulaire_initial=array()){
	include_spip('inc/saisies');
	$retours = array();
	
	// On ajoute un préfixe devant l'identifiant
	$identifiant = 'constructeur_formulaire_'.$identifiant;
	// On récupère le formulaire à son état actuel
	$formulaire_actuel = session_get($identifiant);
	
	// Si on demande à ajouter une saisie
	if ($ajouter_saisie = _request('ajouter_saisie')){
		$formulaire_actuel[] = array(
			'saisie' => $ajouter_saisie,
			'options' => array(
				'nom' => saisies_generer_nom($formulaire_actuel, $ajouter_saisie)
			)
		);
	}
	
	// Si on enregistre la conf d'une saisie
	if ($nom = _request('enregistrer_saisie')){
		// On récupère les options postées en vidant les chaines vides
		$options = _request("saisie_modifiee_$nom");
		$options = $options['options'];
		$options = array_filter($options);
		if (is_array($options))
			spip_desinfecte($options);
		array_walk($formulaire_actuel, 'formidable_ajouter_options', array('nom'=>$nom, 'options'=>$options));
	}
	
	// On enregistre en session la nouvelle version du formulaire
	session_set($identifiant, $formulaire_actuel);
	
	// Le formulaire reste éditable
	$retours['editable'] = true;
	
	return $retours;
}

// À utiliser avec un array_walk_recursive()
// Applique une transformation à la @valeur@ de tous les champs "nom" d'un formulaire, y compris loin dans l'arbo
function formidable_transformer_nom(&$valeur, $cle, $transformation){
	if ($cle == 'nom' and is_string($valeur)){
		$valeur = str_replace('@valeur@', $valeur, $transformation);
	}
}

// À utiliser avec un array_walk()
// Modifie les options d'une saisie
function formidable_ajouter_options(&$valeur, $cle, $nouvelle){
	if (is_array($valeur) and $valeur['saisie'] and $valeur['options']['nom'] == $nouvelle['nom']){
		$nouvelle['options']['nom'] = $valeur['options']['nom'];
		$valeur['options'] = $nouvelle['options'];
	}
	elseif ($cle == 'contenu')
		array_walk($valeur, 'formidable_ajouter_options', array('nom'=>$nom, 'options'=>$options));
}

// Préparer une saisie pour la transformer en truc configurable
function formidable_generer_saisie_configurable($saisie, $env){
	// On récupère le nom
	$nom = $saisie['options']['nom'];
	// On cherche si ya un formulaire de config
	$formulaire_config = $env['erreurs']['configurer_'.$nom];
	
	// On ajoute les boutons d'actions
	$saisie = saisies_inserer_html(
		$saisie,
		recuperer_fond(
			'formulaires/inc-construire_formulaire-actions',
			array('nom' => $nom, 'formulaire_config' => $formulaire_config)
		),
		'debut'
	);
	
	// On ajoute une ancre pour s'y déplacer
	$saisie = saisies_inserer_html(
		$saisie,
		"\n<a id=\"configurer_$nom\"></a>\n",
		'debut'
	);
	
	// Si ya un form de config on l'ajoute à la fin
	if (is_array($formulaire_config)){
		// On double l'environnement
		$env2 = $env;
		// On ajoute une classe
		$saisie['options']['li_class'] .= ' en_configuration';
		
		// Si possible on met en readonly
		$saisie['options']['readonly'] = 'oui';
		
		$env2['saisies'] = $formulaire_config;
		
		// Un test pour savoir si on prend le _request ou bien
		$erreurs_test = $env['erreurs'];
		unset($erreurs_test['configurer_'.$nom]);
		unset($erreurs_test['positionner']);
		if ($erreurs_test){
			// Là aussi on désinfecte à la main
			if (is_array($env["saisie_modifiee_$nom"]['options']))
				spip_desinfecte($env2["saisie_modifiee_$nom"]['options']);
		}
		else
			$env2["saisie_modifiee_$nom"] = $env2['_saisies_par_nom'][$nom];
		
		$saisie = saisies_inserer_html(
			$saisie,
			'<ul class="formulaire_configurer">'
			.recuperer_fond(
				'inclure/generer_saisies',
				$env2
			)
			.'</ul>',
			'fin'
		);
	}
	
	// On génère le HTML de la saisie
	$html = generer_saisie($saisie, $env);
	
	// Si le <li> est en display:none on l'enlève
	$html = preg_replace('/display[\s]*:[\s]*none;?/i',' ',$html);
	
	// Les input hidden sont transformés en text readonly
	$html = preg_replace('/type=(\'|")hidden\\1/i','type="text" class="text" readonly="readonly"',$html);
	
	return $html;
}

?>

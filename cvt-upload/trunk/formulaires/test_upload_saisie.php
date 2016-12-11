<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/cvtupload');

function formulaires_test_upload_saisie_charger(){
	$saisies = array(
		array(
			'saisie'=>'input',
			'options'=>array(
				'nom'=>'tromperie',
				'label'=>'Si c\'est rempli, on se trompe',
				'defaut'=>_request('tromperie')
			)
		),
		array(
			'saisie'=>'fichiers',
			'options'=>array(
				'nom'=>'pdfs',
				'label'=>'Plusieurs fichiers PDF dans un même champ',
				'nb_fichiers'=>2
			)
		),
		array(
			'saisie'=>'fichiers',
			'options'=>array(
				'nom'=>'fichier_tout_mime', 
				'label'=>'Un fichier, n\'importe quel type MIME accepté par SPIP',
				'nb_fichiers'=>1
			)
		),
		array(
			'saisie' => 'fichiers',
			'options' => array(
				'nom' => 'fichier_image_web',
				'label' => 'Un fichier de type image web (jpg, png, gif)',
				'nb_fichiers' => 1
			)
		),
		array(
			'saisie' => 'fichiers',
			'options' => array(
				'nom' => 'fichier_leger',
				'label' => 'Un fichier léger (≤ 10 kio)',
				'nb_fichiers' => 1
			)
		),
		array(
			'saisie' => 'fichiers',
			'options' => array(
				'nom' => 'image_web_pas_trop_grande',
				'label' => 'Une image web pas plus grande que 1024 px de largeur et 640 px de hauteur',
				'nb_fichiers' => 1
			)
		),
		array(
			'saisie' => 'fichiers',
			'options' => array(
				'nom' => 'image_web_pas_trop_grande_rotation',
				'label' => 'Une image web pas plus grande que 1024 px de largeur et 640 px de hauteur, ou l\'inverse',
				'nb_fichiers' => 1
			)
		)
	);
	$contexte = array(
		'mes_saisies' => $saisies
	);

	return $contexte;
}

function formulaires_test_upload_saisie_fichiers(){
	return array(
		'pdfs',
		'fichier_tout_mime',
		'fichier_image_web',
		'fichier_leger',
		'image_web_pas_trop_grande', 
		'image_web_pas_trop_grande_rotation',
	);
}

function formulaires_test_upload_saisie_verifier(){
	$erreurs = array();

	if (_request('tromperie'))
		$erreurs['tromperie'] = 'Il ne fallait rien remplir.';

	$verifier = charger_fonction('verifier', 'inc', true);

	// Vérifier que la saisie PDFs ne contient que des PDF
	$options = array(
		'mime'=>'specifique',
		'mime_specifique'=>array('application/pdf')
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['pdfs'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['pdfs'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('pdfs',$erreurs_par_fichier);
	}	

	// Vérifier que le champ saisie fichier_tout_mime soit d'un mime permis par SPIP
	$options = array(
		'mime' => 'tout_mime'
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['fichier_tout_mime'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['fichier_tout_mime'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('fichier_tout_mime',$erreurs_par_fichier);
	}	

	// Vérifier que le champ saisie fichier_image_web soit une image web
	$options = array(
		'mime' => 'image_web'
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['fichier_image_web'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['fichier_image_web'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('fichier_image_web',$erreurs_par_fichier);
	}	

	// Vérifier que le champ saisie fichier_leger ne dépasse pas 10 kio
	$options = array(
		'taille_max' => 10
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['fichier_leger'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['fichier_leger'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('fichier_leger',$erreurs_par_fichier);
	}

	// Vérifier que le champ saisie image_web_pas_trop_grande ne dépasse pas 1024 px de large et 640 de haut 
	$options = array(
		'mime' => 'image_web', 
		'dimension_max' => array(
			'largeur' => 1024,
			'hauteur' => 640
		)
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['image_web_pas_trop_grande'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['image_web_pas_trop_grande'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('image_web_pas_trop_grande',$erreurs_par_fichier);
	}

	// Vérifier que le champ saisie image_web_pas_trop_grande_rotation ne dépasse pas 1024 px de large et 640 de haut, ou l'inverse
	$options = array(
		'mime' => 'image_web', 
		'dimension_max' => array(
			'largeur' => 1024,
			'hauteur' => 640,
			'autoriser_rotation' => True
		)
	);
	$erreurs_par_fichier = array();
	if ($erreur = $verifier($_FILES['image_web_pas_trop_grande_rotation'], 'fichiers', $options,$erreurs_par_fichier)){
		$erreurs['image_web_pas_trop_grande_rotation'] = $erreur;
		cvtupload_nettoyer_files_selon_erreurs('image_web_pas_trop_grande_rotation',$erreurs_par_fichier);
	}
	return $erreurs;
}

function formulaires_test_upload_saisie_traiter(){
	$retours = array('message_ok' => 'Il ne se passe rien.');
	
	$fichiers = _request('_fichiers');
	var_dump($_FILES);
	var_dump($fichiers);
	
	return $retours;
}


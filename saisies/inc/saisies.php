<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/*
 * Une librairie pour manipuler ou obtenir des infos sur un tableau de saisies
 *
 * saisies_lister_par_nom()
 * saisies_lister_champs()
 * saisies_chercher()
 * saisies_chemin()
 * saisies_supprimer()
 * saisies_inserer()
 * saisies_modifier()
 * saisies_verifier()
 * saisies_generer_html()
 * saisies_generer_nom()
 * saisies_inserer_html()
 * saisies_lister_disponibles()
 * saisies_autonomes()
 */


/*
 * Prend la description complète du contenu d'un formulaire et retourne
 * les saisies "à plat" classées par nom.
 *
 * @param array $contenu Le contenu d'un formulaire
 * @return array Un tableau avec uniquement les saisies
 */
function saisies_lister_par_nom($contenu){
	$saisies = array();
	
	if (is_array($contenu)){
		foreach ($contenu as $ligne){
			if (is_array($ligne)){
				if (array_key_exists('saisie', $ligne)){
					$saisies[$ligne['options']['nom']] = $ligne;
				}
				if (is_array($ligne['saisies'])){
					$saisies = array_merge($saisies, saisies_lister_par_nom($ligne['saisies']));
				}
			}
		}
	}
	
	return $saisies;
}

/*
 * Prend la description complète du contenu d'un formulaire et retourne
 * une liste des noms des champs du formulaire.
 *
 * @param array $contenu Le contenu d'un formulaire
 * @return array Un tableau listant les noms des champs
 */
function saisies_lister_champs($contenu){
	$saisies = saisies_lister_par_nom($contenu);
	return array_keys($saisies);
}

/*
 * Cherche une saisie par son nom ou son chemin et renvoie soit la saisie, soit son chemin
 *
 * @param array $saisies Un tableau décrivant les saisies
 * @param unknown_type $nom_ou_chemin Le nom de la saisie à chercher ou le chemin sous forme d'une liste de clés
 * @param bool $retourner_chemin Indique si on retourne non pas la saisie mais son chemin
 * @return array Retourne soit la saisie, soit son chemin, soit null
 */
function saisies_chercher($saisies, $nom_ou_chemin, $retourner_chemin=false){
	if (is_array($saisies) and $nom_ou_chemin){
		if (is_string($nom_ou_chemin)){
			$nom = $nom_ou_chemin;
			foreach($saisies as $cle => $saisie){
				$chemin = array($cle);
				if ($saisie['options']['nom'] == $nom)
					return $retourner_chemin ? $chemin : $saisie;
				elseif ($saisie['saisies'] and is_array($saisie['saisies']) and ($retour = saisies_chercher($saisie['saisies'], $nom, $retourner_chemin))){
					return $retourner_chemin ? array_merge($chemin, array('saisies'), $retour) : $retour;
				}
			}
		}
		elseif (is_array($nom_ou_chemin)){
			$chemin = $nom_ou_chemin;
			$saisie = $saisies;
			// On vérifie l'existence quand même
			foreach ($chemin as $cle){
				$saisie = $saisie[$cle];
			}
			// Si c'est une vraie saisie
			if ($saisie['saisie'] and $saisie['options']['nom'])
				return $retourner_chemin ? $chemin : $saisie;
		}
	}
	
	return null;
}

/*
 * Supprimer une saisie dont on donne le nom ou le chemin
 *
 * @param array $saisies Un tableau décriant les saisies
 * @param unknown_type $nom_ou_chemin Le nom de la saisie à supprimer ou son chemin sous forme d'une liste de clés
 * @return array Retourne le tableau modifié décrivant les saisies
 */
function saisies_supprimer($saisies, $nom_ou_chemin){
	// Si la saisie n'existe pas, on ne fait rien
	if ($chemin = saisies_chercher($saisies, $nom_ou_chemin, true)){
		// La position finale de la saisie
		$position = array_pop($chemin);
	
		// On va chercher le parent par référence pour pouvoir le modifier
		$parent =& $saisies;
		foreach($chemin as $cle){
			$parent =& $parent[$cle];
		}
		
		// On supprime et réordonne
		unset($parent[$position]);
		$parent = array_values($parent);
	}
	
	return $saisies;
}

/*
 * Insère une saisie à une position donnée
 * 
 * @param array $saisies Un tableau décrivant les saisies
 * @param array $saisie La saisie à insérer
 * @param array $chemin La position complète où insérer la saisie
 * @return array Retourne le tableau modifié des saisies
 */
function saisies_inserer($saisies, $saisie, $chemin=array()){
	// On vérifie quand même que ce qu'on veut insérer est correct
	if ($saisie['saisie'] and $saisie['options']['nom']){
		// Par défaut le parent c'est la racine
		$parent =& $saisies;
		// S'il n'y a pas de position, on va insérer à la fin du formulaire
		if (!$chemin){
			$position = count($parent);
		}
		elseif (is_array($chemin)){
			$position = array_pop($chemin);
			foreach ($chemin as $cle){
				// Si la clé est un conteneur de saisies "saisies" et qu'elle n'existe pas encore, on la crée
				if ($cle == 'saisies' and !isset($parent[$cle]))
					$parent[$cle] = array();
				$parent =& $parent[$cle];
			}
			// On vérifie maintenant que la position est cohérente avec le parent
			if ($position < 0) $position = 0;
			elseif ($position > count($parent)) $position = count($parent);
		}
		// Et enfin on insère
		array_splice($parent, $position, 0, array($saisie));
	}
	
	return $saisies;
}

/*
 * Déplace une saisie existante autre part
 *
 * @param array $saisies Un tableau décrivant les saisies
 * @param unknown_type $nom_ou_chemin Le nom ou le chemin de la saisie à déplacer
 * @param string $ou Le nom de la saisie devant laquelle on déplacera OU le nom d'un conteneur entre crochets [conteneur]
 * @return array Retourne le tableau modifié des saisies
 */
function saisies_deplacer($saisies, $nom_ou_chemin, $ou){
	// On récupère le contenu de la saisie à déplacer
	$saisie = saisies_chercher($saisies, $nom_ou_chemin);
	
	// Si on l'a bien trouvé
	if ($saisie){
		// On cherche l'endroit où la déplacer
		// Si $ou est vide, c'est à la fin de la racine
		if (!$ou){
			$saisies = saisies_supprimer($saisies, $nom_ou_chemin);
			$chemin = array(count($saisies));
		}
		// Si l'endroit est entre crochet, c'est un conteneur
		elseif (preg_match('/^\[([\w]*)\]$/', $ou, $match)){
			$parent = $match[1];
			// Si dans les crochets il n'y a rien, on met à la fin du formulaire
			if (!$parent){
				$saisies = saisies_supprimer($saisies, $nom_ou_chemin);
				$chemin = array(count($saisies));
			}
			// Sinon on vérifie que ce conteneur existe
			elseif (saisies_chercher($saisies, $parent, true)){
				// S'il existe on supprime la saisie et on recherche la nouvelle position
				$saisies = saisies_supprimer($saisies, $nom_ou_chemin);
				$parent = saisies_chercher($saisies, $parent, true);
				$chemin = array_merge($parent, array('saisies', 1000000));
			}
			else
				$chemin = false;
		}
		// Sinon ça sera devant un champ
		else{
			// On vérifie que le champ existe
			if (saisies_chercher($saisies, $ou, true)){
				// S'il existe on supprime la saisie et on recherche la nouvelle position
				$saisies = saisies_supprimer($saisies, $nom_ou_chemin);
				$chemin = saisies_chercher($saisies, $ou, true);
			}
			else
				$chemin = false;
		}
		
		// Si seulement on a bien trouvé un nouvel endroit où la placer, alors on déplace
		if ($chemin)
			$saisies = saisies_inserer($saisies, $saisie, $chemin);
	}
	
	return $saisies;
}

/*
 * Modifie une saisie
 *
 * @param array $saisies Un tableau décrivant les saisies
 * @param unknown_type $nom_ou_chemin Le nom ou le chemin de la saisie à modifier
 * @param array $modifs Le tableau des modifications à apporter à la saisie
 * @return Retourne le tableau décrivant les saisies, mais modifié
 */
function saisies_modifier($saisies, $nom_ou_chemin, $modifs){
	$chemin = saisies_chercher($saisies, $nom_ou_chemin, true);
	$position = array_pop($chemin);
	$parent =& $saisies;
	foreach ($chemin as $cle){
		$parent =& $parent[$cle];
	}
	
	// On récupère le type, le nom et les enfants tels quels
	$modifs['saisie'] = $parent[$position]['saisie'];
	$modifs['options']['nom'] = $parent[$position]['options']['nom'];
	if (is_array($parent[$position]['saisies'])) $modifs['saisies'] = $parent[$position]['saisies'];
	
	// On remplace tout
	$parent[$position] = $modifs;
	
	// Cette méthode ne marche pas trop
	//$parent[$position] = array_replace_recursive($parent[$position], $modifs);
	
	return $saisies;
}

/*
 * Transforme tous les noms du formulaire avec un preg_replace
 *
 * @param array $saisies Un tableau décrivant les saisies
 * @param string $masque Ce que l'on doit chercher dans le nom
 * @param string $remplacement Ce par quoi on doit remplacer
 * @return array Retourne le tableau modifié des saisies
 */
function saisies_transformer_noms($saisies, $masque, $remplacement){
	if (is_array($saisies)){
		foreach ($saisies as $cle => $saisie){
			$saisies[$cle]['options']['nom'] = preg_replace($masque, $remplacement, $saisie['options']['nom']);
			if (is_array($saisie['saisies']))
				$saisies[$cle]['saisies'] = saisies_transformer_noms($saisie['saisies'], $masque, $remplacement);
		}
	}
	
	return $saisies;
}

/*
 * Vérifier tout un formulaire tel que décrit avec les Saisies
 *
 * @param array $formulaire Le contenu d'un formulaire décrit dans un tableau de Saisies
 * @return array Retourne un tableau d'erreurs
 */
function saisies_verifier($formulaire){
	include_spip('inc/verifier');
	$erreurs = array();
	$verif_fonction = charger_fonction('verifier','inc',true);
	
	$saisies = saisies_lister_par_nom($formulaire);
	foreach ($saisies as $saisie){
		$obligatoire = $saisie['options']['obligatoire'];
		$champ = $saisie['options']['nom'];
		$verifier = $saisie['verifier'];
		
		// Si le nom du champ est un tableau indexé, il faut parser !
		if (preg_match('/([\w]+)((\[[\w]+\])+)/', $champ, $separe)){
			$valeur = _request($separe[1]);
			preg_match_all('/\[([\w]+)\]/', $separe[2], $index);
			// On va chercher au fond du tableau
			foreach($index[1] as $cle){
				$valeur = $valeur[$cle];
			}
		}
		// Sinon la valeur est juste celle du nom
		else
			$valeur = _request($champ);
		
		// On regarde d'abord si le champ est obligatoire
		if ($obligatoire and $obligatoire != 'non' and ($valeur == ''))
			$erreurs[$champ] = _T('info_obligatoire');
		
		// On continue seulement si ya pas d'erreur d'obligation et qu'il y a une demande de verif
		if (!$erreurs[$champ] and is_array($verifier) and $verif_fonction){
			// Si le champ n'est pas valide par rapport au test demandé, on ajoute l'erreur
			if ($erreur_eventuelle = $verif_fonction($valeur, $verifier['type'], $verifier['options']))
				$erreurs[$champ] = $erreur_eventuelle;
		}
	}
	
	return $erreurs;
}

/*
 * Génère une saisie à partir d'un tableau la décrivant et de l'environnement
 * Le tableau doit être de la forme suivante :
 * array(
 *		'saisie' => 'input',
 *		'options' => array(
 *			'nom' => 'le_name',
 *			'label' => 'Un titre plus joli',
 *			'obligatoire' => 'oui',
 *			'explication' => 'Remplissez ce champ en utilisant votre clavier.'
 *		)
 * )
 */
function saisies_generer_html($champ, $env=array()){
	// Si le parametre n'est pas bon, on genere du vide
	if (!is_array($champ))
		return '';
	
	$contexte = array();
	
	// On sélectionne le type de saisie
	$contexte['type_saisie'] = $champ['saisie'];
	
	// Peut-être des transformations à faire sur les options textuelles
	$options = $champ['options'];
	foreach ($options as $option => $valeur){
		$options[$option] = _T_ou_typo($valeur, 'multi');
	}
	
	// On ajoute les options propres à la saisie
	$contexte = array_merge($contexte, $options);
	
	// Si env est définie dans les options ou qu'il y a des enfants, on ajoute tout l'environnement
	if(isset($contexte['env']) or is_array($champ['saisies'])){
		unset($contexte['env']);
		
		// À partir du moment où on passe tout l'environnement, il faut enlever certains éléments qui ne doivent absolument provenir que des options
		unset($env['inserer_debut']);
		unset($env['inserer_fin']);
		$saisies_disponibles = saisies_lister_disponibles();
		if (is_array($saisies_disponibles[$contexte['type_saisie']]['options'])){
			$options_a_supprimer = saisies_lister_champs($saisies_disponibles[$contexte['type_saisie']]['options']);
			foreach ($options_a_supprimer as $option_a_supprimer){
				unset($env[$option_a_supprimer]);
			}
		}
		
		$contexte = array_merge($env, $contexte);
	}
	// Sinon on ne sélectionne que quelques éléments importants
	else{
		// On récupère la liste des erreurs
		$contexte['erreurs'] = $env['erreurs'];
	}
	
	// Dans tous les cas on récupère de l'environnement la valeur actuelle du champ
	// Si le nom du champ est un tableau indexé, il faut parser !
	if (preg_match('/([\w]+)((\[[\w]+\])+)/', $contexte['nom'], $separe)){
		$contexte['valeur'] = $env[$separe[1]];
		preg_match_all('/\[([\w]+)\]/', $separe[2], $index);
		// On va chercher au fond du tableau
		foreach($index[1] as $cle){
			$contexte['valeur'] = $contexte['valeur'][$cle];
		}
	}
	// Sinon la valeur est juste celle du nom
	else
		$contexte['valeur'] = $env[$contexte['nom']];
	
	// Si ya des enfants on les remonte dans le contexte
	if (is_array($champ['saisies']))
		$contexte['saisies'] = $champ['saisies'];
	
	// On génère la saisie
	return recuperer_fond(
		'saisies/_base',
		$contexte
	);
}

/*
 * Génère une vue d'une saisie
 *
 * @param array $saisie Un tableau décrivant une saisie
 * @param array $env L'environnement, contenant normalement la réponse à la saisie
 * @return string Retour le HTML des vues
 */
function saisies_generer_vue($saisie, $env=array()){
	// Si le paramètre n'est pas bon, on génère du vide
	if (!is_array($saisie))
		return '';
	
	$contexte = array();
	
	// On sélectionne le type de saisie
	$contexte['type_saisie'] = $saisie['saisie'];
	
	// Peut-être des transformations à faire sur les options textuelles
	$options = $saisie['options'];
	foreach ($options as $option => $valeur){
		$options[$option] = _T_ou_typo($valeur, 'multi');
	}
	
	// On ajoute les options propres à la saisie
	$contexte = array_merge($contexte, $options);
	
	// Si env est définie dans les options ou qu'il y a des enfants, on ajoute tout l'environnement
	if(isset($contexte['env']) or is_array($saisie['saisies'])){
		unset($contexte['env']);
		
		// À partir du moment où on passe tout l'environnement, il faut enlever certains éléments qui ne doivent absolument provenir que des options
		$saisies_disponibles = saisies_lister_disponibles();
		if (is_array($saisies_disponibles[$contexte['type_saisie']]['options'])){
			$options_a_supprimer = saisies_lister_champs($saisies_disponibles[$contexte['type_saisie']]['options']);
			foreach ($options_a_supprimer as $option_a_supprimer){
				unset($env[$option_a_supprimer]);
			}
		}
		
		$contexte = array_merge($env, $contexte);
	}
	
	// Dans tous les cas on récupère de l'environnement la valeur actuelle du champ
	
	// On regarde en priorité s'il y a un tableau listant toutes les valeurs
	if ($env['valeurs'] and is_array($env['valeurs']) and $env['valeurs'][$contexte['nom']]){
		$contexte['valeur'] = $env['valeurs'][$contexte['nom']];
	}
	// Si le nom du champ est un tableau indexé, il faut parser !
	elseif (preg_match('/([\w]+)((\[[\w]+\])+)/', $contexte['nom'], $separe)){
		$contexte['valeur'] = $env[$separe[1]];
		preg_match_all('/\[([\w]+)\]/', $separe[2], $index);
		// On va chercher au fond du tableau
		foreach($index[1] as $cle){
			$contexte['valeur'] = $contexte['valeur'][$cle];
		}
	}
	// Sinon la valeur est juste celle du nom
	else
		$contexte['valeur'] = $env[$contexte['nom']];
	
	// Si ya des enfants on les remonte dans le contexte
	if (is_array($saisie['saisies']))
		$contexte['saisies'] = $saisie['saisies'];
	
	// On génère la saisie
	return recuperer_fond(
		'saisies-vues/_base',
		$contexte
	);
}

/*
 * Génère un nom unique pour un champ d'un formulaire donné
 *
 * @param array $formulaire Le formulaire à analyser 
 * @param string $type_saisie Le type de champ dont on veut un identifiant 
 * @return string Un nom unique par rapport aux autres champs du formulaire
 */
function saisies_generer_nom($formulaire, $type_saisie){
	$champs = saisies_lister_champs($formulaire);
	
	// Tant que type_numero existe, on incrémente le compteur
	$compteur = 1;
	while (array_search($type_saisie.'_'.$compteur, $champs) !== false)
		$compteur++;
	
	// On a alors un compteur unique pour ce formulaire
	return $type_saisie.'_'.$compteur;
}

/**
 * Insère du HTML au début ou à la fin d'une saisie
 *
 * @param array $saisie La description d'une seule saisie
 * @param string $insertion Du code HTML à insérer dans la saisie 
 * @param string $ou L'endroit où insérer le HTML : "debut" ou "fin"
 * @return array Retourne la description de la saisie modifiée
 */
function saisies_inserer_html($saisie, $insertion, $ou='fin'){
	if (!in_array($ou, array('debut', 'fin')))
		$ou = 'fin';
	
	if ($ou == 'debut')
		$saisie['options']['inserer_debut'] = $insertion.$saisie['options']['inserer_debut'];
	elseif ($ou == 'fin')
		$saisie['options']['inserer_fin'] = $saisie['options']['inserer_fin'].$insertion;
	
	return $saisie;
}

/*
 * Liste toutes les saisies configurables (ayant une description)
 *
 * @return array Un tableau listant des saisies et leurs options
 */
function saisies_lister_disponibles(){
	static $saisies = null;
	
	if (is_null($saisies)){
		$saisies = array();
		$liste = find_all_in_path('saisies/', '.+[.]yaml$');
		
		if (count($liste)){
			foreach ($liste as $fichier=>$chemin){
				$type_saisie = preg_replace(',[.]yaml$,i', '', $fichier);
				$dossier = str_replace($fichier, '', $chemin);
				// On ne garde que les saisies qui ont bien le HTML avec !
				if (file_exists("$dossier$type_saisie.html")
					and (
						is_array($saisie = saisies_charger_infos($type_saisie))
					)
				){
					$saisies[$type_saisie] = $saisie;
				}
			}
		}
	}
	
	return $saisies;
}

/**
 * Charger les informations contenues dans le yaml d'une saisie
 *
 * @param string $type_saisie Le type de la saisie
 * @return array Un tableau contenant le YAML décodé
 */
function saisies_charger_infos($type_saisie){
	include_spip('inc/yaml');
	$fichier = find_in_path("saisies/$type_saisie.yaml");
	$saisie = yaml_decode_file($fichier);
	if (is_array($saisie)){
		$saisie['titre'] = $saisie['titre'] ? _T_ou_typo($saisie['titre']) : $type_saisie;
		$saisie['description'] = $saisie['description'] ? _T_ou_typo($saisie['description']) : '';
		$saisie['icone'] = $saisie['icone'] ? find_in_path($saisie['icone']) : '';
	}
	return $saisie;
}

/*
 * Quelles sont les saisies qui se débrouillent toutes seules, sans le _base commun
 *
 * @return array Retourne un tableau contenant les types de saisies qui ne doivent pas utiliser le _base.html commun
 */
function saisies_autonomes(){
	$saisies_autonomes = pipeline(
		'saisies_autonomes',
		array(
			'fieldset',
			'hidden',
			'destinataires'
		)
	);
	
	return $saisies_autonomes;
}

/*
 * Transforme une chaine en tableau avec comme principe :
 * - une ligne devient une case
 * - si la ligne est de la forme truc|bidule alors truc est la clé et bidule la valeur
 *
 * @param string $chaine Une chaine à transformer
 * @return array Retourne un tableau PHP
 */
function saisies_chaine2tableau($chaine, $separateur="\n"){
	if ($chaine and is_string($chaine)){
		$tableau = array();
		// On découpe d'abord en lignes
		$lignes = explode($separateur, $chaine);
		foreach ($lignes as $i=>$ligne){
			$ligne = trim(trim($ligne), '|');
			// Si ce n'est pas une ligne sans rien
			if ($ligne !== ''){
				// Si on trouve un découpage dans la ligne on fait cle|valeur
				if (strpos($ligne, '|') !== false){
					list($cle,$valeur) = explode('|', $ligne, 2);
					$tableau[$cle] = $valeur;
				}
				// Sinon on génère la clé
				else{
					$tableau[$i] = $ligne;
				}
			}
		}
		return $tableau;
	}
	// Si c'est déjà un tableau on le renvoie tel quel
	elseif (is_array($chaine)){
		return $chaine;
	}
	else{
		return array();
	}
}

/*
 * Transforme un tableau en chaine de caractères avec comme principe :
 * - une case de vient une ligne de la chaine
 * - chaque ligne est générée avec la forme cle|valeur
 */
function saisies_tableau2chaine($tableau){
	if ($tableau and is_array($tableau)){
		$chaine = '';
	
		foreach($tableau as $cle=>$valeur){
			$ligne = trim("$cle|$valeur");
			$chaine .= "$ligne\n";
		}
		$chaine = trim($chaine);
	
		return $chaine;
	}
	// Si c'est déjà une chaine on la renvoie telle quelle
	elseif (is_string($tableau)){
		return $tableau;
	}
	else{
		return '';
	}
}

?>

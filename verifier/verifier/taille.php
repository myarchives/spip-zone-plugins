<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Vérifier une taille minimale/maximale, pour un mot de passe par exemple
 *
 * @param string $valeur La valeur à vérifier.
 * @param array $option Les éléments à vérifier (min, max, egal).
 * @return string Retourne une chaine vide si c'est valide, sinon une chaine expliquant l'erreur.
 */

function verifier_taille_dist($valeur, $options=array()){
	$ok = true;
	$erreur = '';
	
	if (isset($options['min']))
		$ok = ($ok and (strlen($valeur) >= $options['min']));
	
	if (isset($options['max'])){
		$ok = ($ok and (strlen($valeur) <= $options['max']));
	}
	if (isset($options['egal'])){
		$ok = ($ok and (strlen($valeur) == $options['egal']));
	}
	
	if (!$ok){
		if (isset($options['min']) and isset($options['max']))
			$erreur = _T('verifier:erreur_taille_entre', $options);
		elseif (isset($options['max']))
			$erreur = _T('verifier:erreur_taille_max', $options);
		elseif (isset($options['egal']))
			$erreur = _T('verifier:erreur_taille_egal', $options);
		else
			$erreur = _T('verifier:erreur_taille_min', $options);
	}
	
	return $erreur;
}

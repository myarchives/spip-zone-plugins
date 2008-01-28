<?php

//intégration des fonctions necessaires de SPIP 1.9.3
if($GLOBALS['spip_version'] < 1.93)
	include_spip('193_fonctions');

function balise_NUAGE_dist($p) {
  $filtre = chercher_filtre('nuage');
	$p->interdire_scripts = false;
	if(function_exists('balise_ENV'))
		return balise_ENV($p, $filtre.'(0, "", "", -1, $Pile["0"]["expose"])');
	else
		return balise_ENV_dist($p, $filtre.'(0, "", "", -1, $Pile["0"]["expose"])');
	return $p;
}

function filtre_calculer_nuage_dist($titres, $urls, $poids, $expose) {
  $filtre_find = chercher_filtre('find');
  $resultat = array();
  $max = empty($poids)?0:max($poids);
  if($max>0) {
    foreach ($titres as $id => $t) {
      $score = $poids[$id]/$max; # entre 0 et 1
      if($score > 0.05){
        $s = ($unite=floor($score += 0.900001)) . floor(10*($score - $unite));
        $s -= 9;
        $resultat[$t] = array(
          'url'   => $urls[$id],
          'poids' => $poids[$id].'/'.$max,
          'class' => $s,
          'expose' => $filtre_find($expose, $id)
        );
      }
    }
  }
  return $resultat;
}

function filtre_nuage_dist($id_mot, $titre = '', $url = '', $poids = -1, $expose = array()){
	static $nuage = array();
	if($titre and $url){
		$nuage['titre'][$id_mot] = $titre;
		$nuage['url'][$id_mot] = $url;
	}
	elseif($poids>=0){
		$nuage['poids'][$id_mot] += $poids;
	}
	else {
		$calcul = chercher_filtre('calculer_nuage');
		$retour = $calcul($nuage['titre'], $nuage['url'], $nuage['poids'], $expose);
	    $nuage = array();
	}
	return !empty($retour) ? $retour : '';
}

?>
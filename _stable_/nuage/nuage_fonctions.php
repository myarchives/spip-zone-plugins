<?php

function balise_NUAGE_dist($p) {
  $filtre = chercher_filtre('nuage');
	$p->interdire_scripts = false;
	if(function_exists('balise_ENV'))
		return balise_ENV($p, $filtre.'(0, "", "", -1, $Pile["vars"]["expose"])');
	else
		return balise_ENV_dist($p, $filtre.'(0, "", "", -1, $Pile["vars"]["expose"])');
	return $p;
}

function filtre_calculer_nuage_dist($titres, $urls, $poids, $expose) {
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
          'expose' => filtre_find($expose, $id)
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

//compat SPIP 1.9.2
if(!function_exists('push')) {
	function push($array, $val) {
		if($array == '' OR !array_push($array, $val)) return '';
		return $array;
	}
}

if(!function_exists('find')) {
	function find($array, $val) {
		return ($array != '' AND in_array($val, $array));
	}
}

//la gestion du critere {frequence}
include_spip('frequence_fonctions');


?>
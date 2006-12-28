<?php
#---------------------------------------------------#
#  Plugin  : Tweak SPIP                             #
#  Auteur  : Patrice Vanneufville, 2006             #
#  Contact : patrice�.!vanneufville�@!laposte�.!net #
#  Licence : GPL                                    #
#  Infos : http://www.spip-contrib.net/?article1554 #
#---------------------------------------------------#

include_spip('tweak_spip_config');

// ajoute un tweak � $tweaks;
function add_tweak($tableau) {
	global $tweaks;
	$tweaks[] = $tableau;
}

// $type ici est egal � 'options' ou 'fonctions'
function include_tweaks($type) {
	global $tweaks_pipelines;
	foreach ($tweaks_pipelines['inc_'.$type] as $inc) include_spip('inc/'.$inc);
}

// passe le $flux dans le $pipeline ...
function tweak_pipeline($pipeline, $flux) {
	global $tweaks, $tweaks_pipelines;
	if (isset($tweaks_pipelines[$pipeline])) {
		foreach ($tweaks_pipelines[$pipeline][0] as $inc) include_spip('inc/'.$inc);
		foreach ($tweaks_pipelines[$pipeline][1] as $fonc) if (function_exists($fonc)) $flux = $fonc($flux);
	}
	return $flux;
}

// retourne les css utilises (en vue d'un insertion en head)
function tweak_insert_css() {
	global $tweaks_css;
	$head = "\n<!-- CSS TWEAKS -->\n";
	foreach ($tweaks_css as $css) $head .= $css;
	return $head;
}

// met a jour : $tweaks_pipelines, $tweaks_css
function tweaks_initialise_includes() {
  global $tweaks, $tweak_exclude, $tweaks_pipelines, $tweaks_css;
  foreach ($tweaks as $i=>$tweak) {
	// stockage de la liste des fonctions par pipeline, si le tweak est actif...
	if ($tweak['actif']) {
		foreach ($tweak as $pipe=>$fonc) if(!in_array($pipe, $tweak_exclude)) {
			$tweaks_pipelines[$pipe][0][] = $tweak['include'];
			$tweaks_pipelines[$pipe][1][] = $fonc;
		}
		$f = find_in_path('inc/'.$tweak['include'].'.css');
		include_spip('inc/filtres');
		if ($f) $tweaks_css[] = '<link rel="stylesheet" href="'.direction_css($f).'" type="text/css" media="projection, screen" />';
		if ($tweak['options']) $tweaks_pipelines['inc_options'][] = $tweak['include'];
		if ($tweak['fonctions']) $tweaks_pipelines['inc_fonctions'][] = $tweak['include'];
	}
  }
}

// lire les metas et initialiser $tweaks_pipelines
function tweak_lire_metas() {
	global $tweaks, $tweaks_pipelines;
	include_spip('inc/meta');
	lire_metas();
	$metas_tweaks = unserialize($GLOBALS['meta']['tweaks']);
	// incorporer l'activite lue dans les metas et completer les categories
	foreach($temp = $tweaks as $i=>$tweak) {
		$tweaks[$i]['actif'] = isset($metas_tweaks[$tweak['include']])?$metas_tweaks[$tweak['include']]['actif']:0;
		if (!isset($tweak['categorie'])) $tweaks[$i]['categorie'] = _T('tweak:divers');
	}
	ecrire_meta('tweaks', serialize($metas_tweaks));
	ecrire_metas();
	tweaks_initialise_includes();
}

// evite les transformations typo dans les balises $balise
// par exemple pour <cadre>, <code>, <acronym> et <cite>, $balise = 'cadre|code|acronym|cite'
// $fonction est la fonction de transformation typo
// $texte est le texte d'origine
function tweak_exclure_balises($balises, $fonction, $texte){
	$t=preg_split(",<(\/?)($balises)>,", $texte, 3, PREG_SPLIT_DELIM_CAPTURE);
	if (count($t)==1) return $fonction($t[0]);
	if ($t[2]=='' || $t[5]=='') return $texte;
	if ($t[1]=='' && $t[4]=='/' && $t[2]==$t[5]) 
		return $fonction($t[0]).'<'.$t[2].'>'.$t[3].'</'.$t[5].'>'.tweak_exclure_balises($balises, $fonction, $t[6]);
	else 
		return $fonction($t[0]).'<'.$t[1].$t[2].'>'.$t[3].tweak_exclure_balises($balises, $fonction, '<'.$t[4].$t[5].'>'.$t[6]);
}


?>
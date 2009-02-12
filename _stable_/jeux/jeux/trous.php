<?php

# il s'agit ici de proposer des textes a trous.

#---------------------------------------------------#
#  Plugin  : jeux                                   #
#  Auteur  : Patrice Vanneufville, 2006             #
#  Contact : patrice�.!vanneufville�@!laposte�.!net #
#  Licence : GPL                                    #
#--------------------------------------------------------------------------#
#  Documentation : http://www.spip-contrib.net/Des-jeux-dans-vos-articles  #
#--------------------------------------------------------------------------#
/*

Insere un test de closure dans vos articles !
---------------------------------------------

separateurs obligatoires : [texte], [trou]
separateurs optionnels   : [titre], [config]
parametres de configurations par defaut :
	taille=auto	// taille des trous
	indices=oui	// afficher les indices ?
	couleurs=oui // appliquer des couleurs sur les corrections ?

Exemple de syntaxe dans l'article :
-----------------------------------

<jeux>
	[texte]
	Ceci est un exemple de closure (exercice a trous).
	L'utilisateur doit entrer ses 
	[trou]
	reponses 
	[texte]
	dans les espaces vides.
	Pour chaque mot manquant, plusieurs reponses correctes 
	peuvent	etre acceptees. Par exemple, ce  
	[trou]
	trou, vide, blanc
	[texte]
	autorise les reponses "trou", "vide" ou "blanc".
	[config]
	indices = oui
</jeux>

La liste des mots a placer apres [trou] peut accepter 
les separateurs usuels : 
	retours a la ligne, tabulations, espaces
	virgules, point-virgules, points
Pour une expression comprenant des espaces, utiliser les 
guillemets ou le signe + :
	par ex. : "afin de" est equivalent a : afin+de
Les comparaisons sont insensibles a la casse.
Pour une expression sensible a la casse, ajouter /M
en fin d'expression :
	par ex. : "la France/M" (ou : la+France/M)
Pour une expression reguliere, utiliser les guillemets et
les virgules pour separateur :
	par ex. : ",stylo(graphe)?,"
A propos de la casse, voici des expressions equivalentes :
	"la France/M", la+France/M, ",la France,"
ou :
	"la France", la+France, la+france, ",la france,i"
Pour l'affichage des indices, veillez a ce que la premiere
expression ne soit pas une expression reguliere

*/

function trous_inserer_le_trou($indexJeux, $indexTrou, $size, $corriger) {
	global $propositionsTROUS, $scoreTROUS, $score_detailTROUS;
	// Initialisation du code a retourner
	$nomVarSelect = "var{$indexJeux}_T{$indexTrou}";
	$mots = $propositionsTROUS[$indexTrou];
	$prop = trim($_POST[$nomVarSelect]);
	$disab = $color = '';
	// en cas de correction
	if($corriger) {
		$ok = strlen($prop) && jeux_in_liste($prop, $mots);
		if($ok) ++$scoreTROUS;
		if(jeux_config('couleurs')) $color = $ok?' juste':' faux';
		// on renseigne le resultat detaille
		$score_detailTROUS[] = 'T'.($indexTrou+1).":$prop:".($ok?'1':'0');
		$disab = " disabled='disabled'";
	}
	$codeHTML = "<input name='$nomVarSelect' class='jeux_input trous$color' size='$size' type='text'$disab' value=\"$prop\" />";
//	if($corriger) $codeHTML .= '(T'.($indexTrou+1).":$prop/".$GLOBALS['meta']['charset']."[".join('|',$mots)."]:".($ok?'1':'0').'pt)';
	return $codeHTML;
}

function trous_inserer_les_trous($chaine, $indexJeux) {
  global $propositionsTROUS;
  if (ereg('<ATTENTE_TROU>([0-9]+)</ATTENTE_TROU>', $chaine, $eregResult)) {
	$indexTROU = intval($eregResult[1]);
	list($texteAvant, $texteApres) = explode($eregResult[0], $chaine, 2); 
	$texteApres = trous_inserer_les_trous($texteApres, $indexJeux);
	if (($sizeInput = intval(jeux_config('taille')))==0)
		foreach($propositionsTROUS as $trou) foreach($trou as $mot) $sizeInput = max($sizeInput, strlen($mot));
	$chaine = $texteAvant.jeux_rem('TROU-DEBUT', $indexTROU, '', 'span')
		. trous_inserer_le_trou($indexJeux, $indexTROU, $sizeInput, isset($_POST["var_correction_".$indexJeux]))
		. jeux_rem('TROU-FIN', $indexTROU, '', 'span')
		. $texteApres; 
  }
  return $chaine;
}

// afficher l'ensemble des solutions dans le desordre...
// si plusieurs solutions sont possibles, seule la premiere est retenue
function trous_afficher_indices($indexJeux) {
 global $propositionsTROUS;
 foreach ($propositionsTROUS as $prop) 
 	$indices[] = strpos($prop[0], '/M')===($len=strlen($prop[0])-2) ?substr($prop[0],0,$len):$prop[0];
 shuffle($indices);
 return '<br/>'.jeux_block_depliable(_T('jeux:indices'), '<center>'.charset2unicode(join(' -&nbsp;', $indices)).'</center>');
}

function jeux_trous($texte, $indexJeux) {
  global $propositionsTROUS, $scoreTROUS, $score_detailTROUS;
  $titre = $html = false;
  $indexTrou = $scoreTROUS = 0;
  $score_detailTROUS = array();

  // parcourir tous les #SEPARATEURS
  $tableau = jeux_split_texte('trous', $texte); 
  // configuration par defaut
  jeux_config_init("
	taille=auto	// taille des trous
	indices=oui	// afficher les indices ?
	couleurs=oui	// afficher les indices ?
  ", false);
  foreach($tableau as $i => $valeur) if ($i & 1) {
	 if ($valeur==_JEUX_TITRE) $titre = $tableau[$i+1];
	  elseif ($valeur==_JEUX_TEXTE) $html .= $tableau[$i+1];
	  elseif ($valeur==_JEUX_TROU) {
		// remplacement des trous par : <ATTENTE_TROU>ii</ATTENTE_TROU>
		$html .= "<ATTENTE_TROU>$indexTrou</ATTENTE_TROU>";
		$propositionsTROUS[$indexTrou] = jeux_liste_mots($tableau[$i+1]);
		$indexTrou++;
	  }
  }

   // reinserer les trous mis en forme
  $texte = trous_inserer_les_trous($html, $indexJeux);

  $tete = '<div class="jeux_cadre">' . ($titre?'<div class="jeux_titre">'.$titre.'<hr /></div>':'');
  $pied = jeux_config('indices')?trous_afficher_indices($indexJeux):'';

  if (!isset($_POST["var_correction_".$indexJeux])) { 
	$tete .= jeux_form_debut('trous', $indexJeux);
	$pied .= '<br /><div align="center"><input type="submit" value="'._T('jeux:corriger').'" class="jeux_bouton"></div>'.jeux_form_fin();
  } else {
      // On ajoute le score final
	    sort($score_detailTROUS);
        $pied .= jeux_afficher_score($scoreTROUS, $indexTrou, $_POST['id_jeu'], join(', ', $score_detailTROUS))
  			. jeux_bouton_recommencer();
  }
  
  unset($propositionsTROUS, $scoreTROUS, $score_detailTROUS);
  return $tete.$texte.$pied.'</div>';
}
?>

<?php
#-----------------------------------------------------#
#  Plugin  : Tweak SPIP - Licence : GPL               #
#  Auteur  : Patrice Vanneufville, 2006               #
#  Contact : patrice�.!vanneufville�@!laposte�.!net   #
#  Infos : http://www.spip-contrib.net/?article1554   #
#-----------------------------------------------------#
if (!defined("_ECRIRE_INC_VERSION")) return;

define('_TWEAK_VAR', tweak_code_echappement("<!--  TWEAK-VAR -->\n", 'TWEAK'));

include_spip('inc/actions');
include_spip('inc/texte');
include_spip('inc/layer');
include_spip('inc/presentation');
include_spip('inc/message_select');

// retourne le code html qu'il faut pour fabriquer le formulaire du tweak proprietaire
function tweak_input_une_variable($index, $tweak, $variable, $label, &$ok_input_, &$ok_valeur_) {
	global $tweak_variables, $metas_vars;
	$actif = $tweak['actif'];
	// la valeur de la variable n'est stockee dans les metas qu'au premier post
	if (isset($metas_vars[$variable])) $valeur = $metas_vars[$variable];
		else $valeur = tweak_get_defaut($variable);
	$valeur = tweak_retire_guillemets($valeur);
cout_log(" -- tweak_input_une_variable($index) - Traite %$variable%");

	// si la variable necessite des boutons radio
	if (is_array($radios = &$tweak_variables[$variable]['radio'])) {
		$ok_input = $label;
		$i = 0; $nb = intval($tweak_variables[$variable]['radio/ligne']);
		foreach($radios as $code=>$traduc) {
			$br = (($nb>0) && ( ++$i % $nb == 0))?'<br />':' ';
			$ok_input .= 
				"<label><input id=\"label_{$variable}_$code\" type=\"radio\""
				.($valeur==$code?' checked="checked"':'')." value=\"$code\" name=\"HIDDENTWEAKVAR__$variable\"/>"
				.($valeur==$code?'<b>':'')._T($traduc).($valeur==$code?'</b>':'')
				."</label>$br";
		}
		$ok_input .= _TWEAK_VAR;
		$ok_valeur = $label.(strlen($valeur)?ucfirst(_T($radios[$valeur])):'&nbsp;-');
	} 
	// ici, donc juste une case input
	else {
		$len = $tweak_variables[$variable]['format']=='nombre'?4:0;
//			else $len=strlen(strval($valeur));
		$ok_input = $label."<input name='HIDDENTWEAKVAR__$variable' value=\"".htmlspecialchars($valeur)."\" type='text' size='$len' />"._TWEAK_VAR;
		$ok_valeur = $label.(strlen($valeur)?"$valeur":'&nbsp;'._T('cout:variable_vide'));
	}
	$ok_input_ .= $ok_input; $ok_valeur_ .= $ok_valeur;
}

// renvoie la description de $tweak0 : toutes les %variables% ont ete remplacees par le code adequat
function inc_tweak_input_dist($tweak0, $url_self, $modif=false) {
	global $tweaks, $tweak_variables, $metas_vars;
	$tweak = &$tweaks[$tweak0];
	$actif = $tweak['actif'];
	$index = $tweak['index'];
	// remplacement des puces
	$descrip = str_replace('#PUCE', definir_puce(), $tweak['description']);
	// remplacement des zone input de format [[label->varable]]
	$descrip = preg_replace(',(\[\[([^][]*)->([^]]*)\]\]),msS', '<fieldset><legend>\\2 </legend>\\3</fieldset>', $descrip);
	// remplacement des variables de format : %variable%
	$t = preg_split(',%([a-zA-Z_][a-zA-Z0-9_]*)%,', $descrip, -1, PREG_SPLIT_DELIM_CAPTURE);
	
cout_log("inc_tweak_input_dist() - Parse la description de '$tweak0'");
	$ok_input = $ok_valeur = $ok_visible = '';
	$tweak['nb_variables'] = 0; $variables = array();
	for($i=0;$i<count($t);$i+=2) if (strlen($var=trim($t[$i+1]))) {
		// si la variable est presente on fabrique le input
		if (isset($tweak_variables[$var])) {
			tweak_input_une_variable(
				$index + (++$tweak['nb_variables']), 
				$tweak, $var, 
				$t[$i], 
				$ok_input, $ok_valeur);
			$variables[] = $var;
		} else { 
			// probleme a regler dans tweak_spip_config.php !
			$temp = $t[$i]."[$var?]"; $ok_input .= $temp; $ok_valeur .= $temp; 
		}
	} else { $ok_input .= $t[$i]; $ok_valeur .= $t[$i]; }
	$tweak['variables'] = $variables;
	$c = $tweak['nb_variables'];

//	if (count($t)==1) { $ok_input .= "<p>$ok_input</p>"; $ok_valeur .= "<p>$ok_valeur</p>"; }

	// bouton 'Modifier' : en dessous du texte s'il y a plusieurs variables, a la place de _TWEAK_VAR s'il n'y en a qu'une.
	// attention : on ne peut pas modifier les variables si le tweak est inactif
	if ($actif) {
		$bouton = "<input type='submit' class='fondo' value=\"".($c>1?_T('cout:modifier_vars', array('nb'=>$c)):_T('bouton_modifier'))."\" />";
		if($c>1) $ok_input .= "<div style=\"margin-top: 0; text-align: right;\">$bouton</div>";
			else $ok_input = str_replace(_TWEAK_VAR, $bouton, $ok_input);
	} else 
		$ok_input = $ok_valeur . '<div style="margin-top: 0; text-align: right;">'._T('cout:validez_page').' <span class="fondo" style="cursor:pointer; padding:0.2em;" onclick="submit_general('.$index.')">'._T('bouton_valider').'</span></div>';
	// nettoyage...
	$ok_input = str_replace(_TWEAK_VAR, '', $ok_input);
	// HIDDENTWEAKVAR__ pour eviter d'avoir deux inputs du meme nom...
	$ok_visible .= $actif?str_replace("HIDDENTWEAKVAR__", "", $ok_input):$ok_valeur;
	$variables = urlencode(serialize($variables));
//	$ok_visible=paragrapher($ok_visible);
//	$ok_input=paragrapher($ok_input);
//	$ok_valeur=paragrapher($ok_valeur);
	$res = "\n<div id='tweak$index-visible' >$ok_visible</div>";
	if($c) {
		$res = "\n<input type='hidden' value='$variables' name='variables'><input type='hidden' value='$tweak0' name='tweak'>"
			. "\n<div id='tweak$index-input' style='position:absolute; visibility:hidden;' >$ok_input</div>"
			. "\n<div id='tweak$index-valeur' style='position:absolute; visibility:hidden;' >$ok_valeur</div>\n"
			. $res;
		// syntaxe : ajax_action_auteur($action, $id, $script, $args='', $corps=false, $args_ajax='', $fct_ajax='')
		$res = ajax_action_auteur('tweak_input', $index, $url_self, "tweak={$tweak['id']}", "$res");
	}
//cout_log("Fin   : inc_tweak_input_dist({$tweak['id']}) - {$tweak['nb_variables']} variables(s) trouv�e(s)");
	$modif=$modif?'<div style="font-weight:bold; color:green; margin:0.4em; text-align:center">&gt;&nbsp;'._T('cout:vars_modifiees').'&nbsp;&lt;</div>':'';
	return ajax_action_greffe("tweak_input-$index", $res, $modif);
}
?>
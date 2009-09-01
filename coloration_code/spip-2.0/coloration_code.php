<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Pierre ANDREWS
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// pour interdire globalement et optionnellement le téléchargement associé
if (!defined('PLUGIN_COLORATION_CODE_TELECHARGE')) {
	define('PLUGIN_COLORATION_CODE_TELECHARGE', true);
}

// pour utiliser des styles inline (ou des classes css)
if (!defined('PLUGIN_COLORATION_CODE_STYLES_INLINE')) {
	define('PLUGIN_COLORATION_CODE_STYLES_INLINE', true);
}

// pouvoir definir la taille des tablations (defaut de geshi : 8)
// define('PLUGIN_COLORATION_CODE_TAB_WIDTH', 4);

	
// pour utiliser le colorieur 'spip' ou 'spip2' si on
// passe une class "spip" simplement.
// note: le colorieur "spip" est celui present originellement dans le plugin
// mais possede des regexp qui se trompaient parfois à quelques } ou > pres...
// il est laisse pour ceux qui le preferaient neanmoins (le nouveau n'a pas les memes couleurs).
if (!defined('PLUGIN_COLORATION_CODE_COLORIEUR_SPIP')) {
	define('PLUGIN_COLORATION_CODE_COLORIEUR_SPIP', 'spip2');
}


function coloration_code_color($code, $language, $cadre='cadre') {

	// Supprime le premier et le dernier retour chariot
	$code = preg_replace("/^(\r\n|\n|\r)/m", "", $code);
	$code = preg_replace("/(\r\n|\n|\r)$/m", "", $code);

	$params = explode(' ', $language);
	$language = array_shift($params);
	
	if ($language=='spip') $language = PLUGIN_COLORATION_CODE_COLORIEUR_SPIP;
	
	include_spip('geshi/geshi');
	//
	// Create a GeSHi object
	//
	$geshi = & new GeSHi($code, $language);
	if ($geshi->error()) {
		return false;
	}
	global $spip_lang_right;
	
	// eviter des ajouts abusifs de CSS par Geshy 
	// qui pose des 'font-family: monospace;' un peu partout
	// et que FF ne gere pas comme les autres navigateurs (va comprendre).
	$geshi->set_overall_style('');
	$geshi->set_code_style('');
	
	$stylecss = "";
	if (defined('PLUGIN_COLORATION_CODE_STYLES_INLINE') and !PLUGIN_COLORATION_CODE_STYLES_INLINE) {
		$geshi->enable_classes();
		$stylecss = "<style type='text/css'>".$geshi->get_stylesheet()."</style>";
	}


	if (defined('PLUGIN_COLORATION_CODE_TAB_WIDTH') and PLUGIN_COLORATION_CODE_TAB_WIDTH) {
		$geshi->set_tab_width(PLUGIN_COLORATION_CODE_TAB_WIDTH);
	}
		
	$code = echappe_retour($code);

	$telecharge = 
		(PLUGIN_COLORATION_CODE_TELECHARGE || in_array('telechargement', $params))
	 && (strpos($code, "\n") !== false) && !in_array('sans_telechargement', $params);
	if ($telecharge) {
		// Gerer le fichier contenant le code au format texte
		$nom_fichier = md5($code);
		$dossier = sous_repertoire(_DIR_VAR, 'cache-code');
		$fichier = "$dossier$nom_fichier.txt";

		if (!file_exists($fichier)) {
			ecrire_fichier($fichier, $code);
		}
	}

	if ($cadre == 'cadre') {
	  $geshi->set_header_type(GESHI_HEADER_DIV);
	  $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
	} else {
	  $geshi->set_header_type(GESHI_HEADER_NONE);
	  $geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
	}

	//
	// And echo the result!
	//
	$rempl = $stylecss . '<div class="coloration_code"><div class="spip_'.$language.' '.$cadre.'">'.$geshi->parse_code().'</div>';

	if ($telecharge) {
		$rempl .= "<div class='" . $cadre . "_download'
		style='text-align: $spip_lang_right;'>
		<a href='$fichier'
		style='font-family: verdana, arial, sans; font-weight: bold; font-style: normal;'>" .
		  _T('colorationcode:telecharger') .
				"</a></div>";
	}
	return $rempl.'</div>';
}

function cadre_ou_code($regs) {
	$ret = false;
// pour l'instant, on oublie $matches[1] et $matches[4] les attributs autour de class="machin"
	if (!preg_match(',^(.*)class=("|\')(.*)\2(.*)$,Uims',$regs[2], $matches)
	|| !($ret = coloration_code_color($regs[3], $matches[3], $regs[1]))) {
		$ret = $regs[1] == 'code' ? traiter_echap_code_dist($regs)
					: traiter_echap_cadre_dist($regs);
	}
	return $ret;
}

function traiter_echap_code($regs) {
	return cadre_ou_code($regs);
}

function traiter_echap_cadre($regs) {
	return cadre_ou_code($regs);
}

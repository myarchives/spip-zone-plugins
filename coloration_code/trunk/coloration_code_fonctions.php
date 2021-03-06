<?php
/**
 * Plugin coloration code
 * Fonctions spécifiques au plugin
 *
 * @package SPIP\Coloration_code\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/plugin');

// pour interdire globalement et optionnellement le téléchargement associé
if (!defined('PLUGIN_COLORATION_CODE_TELECHARGE')) {
	define('PLUGIN_COLORATION_CODE_TELECHARGE', true);
}

// pour utiliser des styles inline (ou des classes css)
if (!defined('PLUGIN_COLORATION_CODE_STYLES_INLINE')) {
	define('PLUGIN_COLORATION_CODE_STYLES_INLINE', true); // false mettra des class et une css associe
}

// pour mettre des classes css MAIS ne mettre aucun style correspondant
// cela suppose donc qu'une CSS externe a ce plugin s'occupe de les styler
if (!defined('PLUGIN_COLORATION_CODE_SANS_STYLES')) {
	define('PLUGIN_COLORATION_CODE_SANS_STYLES', false); // true mettra des class mais pas de css associe
}

// pouvoir definir la taille des tablations (defaut de geshi : 8)
// define('PLUGIN_COLORATION_CODE_TAB_WIDTH', 4);

// Liens externes sur les mots cles de langage (defaut de geshi : true)
if (!defined('PLUGIN_COLORATION_CODE_LIENS_LANGAGE')) {
	define('PLUGIN_COLORATION_CODE_LIENS_LANGAGE', true); // false pour les eviter
}

if (!defined('PLUGIN_COLORATION_CODE_COLORIEUR_SPIP')) {
	define('PLUGIN_COLORATION_CODE_COLORIEUR_SPIP', 'spip');
}

function coloration_code_color($code, $language, $cadre = 'cadre', $englobant = 'div') {

	// On ajoute une argument a la fonction pour permettre d'afficher du code dans des <span>
	// plutot que dans un <div>. Par contre, cette option de span est a utiliser avec la balise <code>
	// et pas <cadre> pour des raisons de validite et de presentation.
	// En outre, le bouton telecharger n'est pas affiche.
	if ($cadre == 'cadre') {
		$englobant = 'div';
	}
	$balise_code = ($englobant == 'div' ? "div" : "code");

	// conserver une version du code reçu avant nettoyage
	$code_avant_nettoyage = $code;
	// Supprime le premier et le dernier retour chariot
	$code = preg_replace("/^(\r\n|\n|\r)*/", "", $code);
	$code = preg_replace("/(\r\n|\n|\r)*$/", "", $code);

	$params   = explode(' ', $language);
	$language = strtolower(array_shift($params));

	if ($language == 'spip') {
		$language = PLUGIN_COLORATION_CODE_COLORIEUR_SPIP;
	}
	if ($language == 'bibtex' and _COLORATION_BIBTEX_COMME_BIBLATEX == 1) {
		$language = 'biblatex';
	}
	include_spip('inc/spip_geshi');
	//
	// Create a GeSHi object
	//
	$geshi = new SPIP_GeSHi($code, $language);
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
	if (!PLUGIN_COLORATION_CODE_STYLES_INLINE OR PLUGIN_COLORATION_CODE_SANS_STYLES) {
		$geshi->enable_classes();
		if (!PLUGIN_COLORATION_CODE_SANS_STYLES) {
			$stylecss = "<style type='text/css'>" . $geshi->get_stylesheet() . "</style>";
		}
	}

	if (defined('PLUGIN_COLORATION_CODE_TAB_WIDTH') and PLUGIN_COLORATION_CODE_TAB_WIDTH) {
		$geshi->set_tab_width(PLUGIN_COLORATION_CODE_TAB_WIDTH);
	}

	// permettre de supprimer les liens vers les documentations sur les mots cles de langage
	if (!PLUGIN_COLORATION_CODE_LIENS_LANGAGE) {
		$geshi->enable_keyword_links(false);
	}

	include_spip('inc/texte');
	$code = echappe_retour($code);

	$telecharge = ($englobant == 'div')
		&& (PLUGIN_COLORATION_CODE_TELECHARGE || in_array('telechargement', $params))
		&& (strpos($code, "\n") !== false) && !in_array('sans_telechargement', $params);
	if ($telecharge) {
		// Gerer le fichier contenant le code au format texte
		$nom_fichier = md5($code);
		$dossier     = sous_repertoire(_DIR_VAR, 'cache-code');
		$fichier     = "$dossier$nom_fichier.txt";

		if (!file_exists($fichier)) {
			ecrire_fichier($fichier, $code);
		}
	}

	/**
	 * On insère un attribut data-clipboard-text si on n'a pas le lien de téléchargement car pas de saut de ligne
	 */
	$datatext         = !$telecharge && PLUGIN_COLORATION_CODE_TELECHARGE;
	$datatext_content = "";
	if ($datatext) {
		$datatext_content = ' data-clipboard-text="' . attribut_html($code) . '"';
	}

	$traitement_par_precode = false;
	if (defined('_DIR_PLUGIN_PRECODE') && _DIR_PLUGIN_PRECODE) {
		// si le plugin PRECODE est activé, on utilise son balisage moderne
		// header <pre> pour ne pas générer de <br>
		$geshi->set_header_type(GESHI_HEADER_PRE);
		$geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
		$code_corps = $geshi->parse_code();
		// si le code est sur plusieurs lignes, on passe le traitement à precode
		// sinon, c'est du code inline que precode ne gère pas
		if (strpos($code_avant_nettoyage, "\n") !== false) {
			$traitement_par_precode = true;
			// supprimer le <pre> englobant, qui sera ajouté par PRECODE
			$code_corps = trim(preg_replace('!^<pre[^>]*>|</pre>$!', '', $code_corps), "\n\r");
			$rempl      = precode_balisage_code('class="' . $language . '"', $code_corps);
		}
	}

	if ($cadre == 'cadre' OR $englobant == "div") {
		$geshi->set_header_type(GESHI_HEADER_DIV);
		$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
	} else {
		$geshi->set_header_type(GESHI_HEADER_NONE);
		$geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);
	}
	
	if(!$traitement_par_precode) {
		$rempl = $stylecss . '<' . $englobant . ' class="coloration_code ' . $cadre . '"><' . $balise_code . ' class="spip_' . $language . ' ' . $cadre. '"' . $datatext_content . '>' . $geshi->parse_code() . '</' . $balise_code . '>';
		if ($telecharge) {
			$rempl .= "<p class='download " . $cadre . "_download'><a href='$fichier'>" . _T('bouton_download') . "</a></p>";
		}
		$rempl .= '</' . $englobant . '>';
	}

	return $rempl;
}

/**
 * Est-ce à Geshi de traiter les codes et cadres ou on utilise les fonctions natives de SPIP
 *
 * @param array $regs
 *
 * @return string $ret
 */
function cadre_ou_code($regs) {

	// pour l'instant, on oublie $matches[1] et $matches[4] les attributs autour de class="machin"
	if (preg_match(',^(.*)class=("|\')(.*)\2(.*)$,Uims', $regs[2], $matches)) {
		$englobant = "div";
		if ($regs[1] == "code" AND strpos($regs[3], "\n") === false) {
			$englobant = "span";
		}
		if ($ret = coloration_code_color($regs[3], $matches[3], $regs[1], $englobant)) {
			return $ret;
		}
	} else {
		// traiter les <cadre> sans class par precode pour ne pas générer de <textarea>
		if ($regs[1] == "cadre" && defined('_DIR_PLUGIN_PRECODE') && _DIR_PLUGIN_PRECODE) {
			return precode_balisage_code('class=""', trim(entites_html($regs[3])));
		}
	}

	if ($regs[1] == 'code') {
		return defined('_DIR_PLUGIN_PRECODE') && _DIR_PLUGIN_PRECODE ?
			precode_traiter_echap_code($regs) : traiter_echap_code_dist($regs);
	}
	
	return defined('_DIR_PLUGIN_PRECODE') && _DIR_PLUGIN_PRECODE ?
		precode_traiter_echap_cadre($regs) : traiter_echap_cadre_dist($regs);
}

/**
 * Surcharge de la fonction traiter_echap_code_dist native de SPIP
 * cf : ecrire/inc/texte_mini
 *
 * @param array $regs
 *
 * @return string
 */
function traiter_echap_code($regs) {
	return cadre_ou_code($regs);
}

/**
 * Surcharge de la fonction traiter_echap_cadre_dist native de SPIP
 * cf : ecrire/inc/texte_mini
 *
 * @param array $regs
 *
 * @return string
 */
function traiter_echap_cadre($regs) {
	return cadre_ou_code($regs);
}

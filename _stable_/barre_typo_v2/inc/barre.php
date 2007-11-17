<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2007                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

//Compatibilite pour avant 1.9.3
if (!function_exists('test_espace_prive')) {
	function test_espace_prive() {
		return defined('_DIR_RESTREINT') ? !_DIR_RESTREINT : false;
	}
}

// construit un bouton (ancre) de raccourci avec icone et aide

// http://doc.spip.org/@bouton_barre_racc
function bouton_barre_racc($action, $img, $help, $champhelp) {
	include_spip('inc/charsets');

	$a = attribut_html($help);
	$action = str_replace ("&lt;", '%3C',  $action);
	$action = str_replace ("&gt;", '%3E',  $action);
	$action = str_replace ("\n", '%5Cn',  $action);
	$action = unicode_to_javascript(html2unicode($action));
	$action = str_replace("\"","&quot;",$action);
	return "<a href=\"javascript:"
		.$action
		."\"\n tabindex='1000' title=\""
		. $a
		."\"" 
		.(test_espace_prive() ? '' :  " onmouseover=\"helpline('"
		  .addslashes(str_replace('&#39;',"'",$a))
		  ."',$champhelp)\" onmouseout=\"helpline('"
		  .attribut_html(_T('barre_aide'))
		  ."', $champhelp)\"")
		."><img src='"
		.$img
		."' style=\"height: 16px; width: 16px; background-position: center center;\" alt=\"$a\" /></a>";
}

// sert a construire les sousbarre
function bte_renomme_block($nom_block) { 
	global $numero_block, $compteur_block; 
	if (!isset($numero_block[$nom_block])){ 
		$compteur_block++; 
		$numero_block[$nom_block] = $compteur_block;
	}
	return $numero_block["$nom_block"];
}

function bte_debut_block_visible($nom_block){ 
	global $browser_layer; 
	if (!$browser_layer) return ''; 
	return "<div id='Layer".bte_renomme_block($nom_block)."' style='display: block;'>"; 
} 

function bte_debut_block_invisible($nom_block){ 
	global $browser_layer; 
	if (!$browser_layer) return ''; 

	// si on n'accepte pas js, ne pas fermer 
	if (!_SPIP_AJAX) 
		return debut_block_visible($nom_block); 
	return "<div id='Layer".bte_renomme_block($nom_block)."' style='display: none;'>"; 
}

function produceWharf($id, $title = '', $sb = '') {
  $visible = ($changer_virtuel || $virtuel);
  $res .= $title;
  $GLOBALS['numero_block'][$id] = ($GLOBALS['compteur_block']+1);
  if ($visible) {
    $res .= bte_debut_block_visible("arb_".$GLOBALS['numero_block'][$id]);
  } else {
    $res .= bte_debut_block_invisible("arb_".$GLOBALS['numero_block'][$id]);
  }
  $res .= $sb;
  $res .= '</div>';
  return $res;
}

//gestion des lignes optionnelles

// construction des liens
function afficher_gestion_lien($champ, $num_barre) {

$tableau_formulaire = '
 <table class="spip_barre" style="width: auto; padding: 1px!important; border-top: 0px;" summary="">
<tr><td> 
'._T('bartypenr:barre_adresse').'&nbsp;: <input type="text" name="lien_nom" id="lien_nom'.$num_barre.'" value="http://" size="21" maxlength="255" /><br />
'._T('bartypenr:barre_bulle').'&nbsp;: <input type="text" name="lien_bulle" id="lien_bulle'.$num_barre.'" value="" size="21" maxlength="255" />
</td><td>
'._T('bartypenr:barre_langue').'&nbsp;: <input type="text" name="lien_langue" id="lien_langue'.$num_barre.'" value="" size="10" maxlength="10" />
</td><td>
  <input type="button" value="'._T('pass_ok').'" class="fondo" onclick="javascript:barre_demande_lien(\'[\', \'->\', \']\', document.getElementById(\'lien_nom'.$num_barre.'\').value, document.getElementById(\'lien_bulle'.$num_barre.'\').value, document.getElementById(\'lien_langue'.$num_barre.'\').value,'.$champ.','.$num_barre.');document.getElementById(\'lien_nom'.$num_barre.'\').value=\'\';document.getElementById(\'lien_bulle'.$num_barre.'\').value=\'\';document.getElementById(\'lien_langue'.$num_barre.'\').value=\'\';" /> 
</td></tr></table>
';
  return produceWharf('tableau_lien','',$tableau_formulaire); 	
}

// Changer la casse
function RaccourcisMajusculesMinuscules($champ, $champhelp, $num_barre) {
	return bouton_barre_racc ("barre_capitales($champ,true,$num_barre)",  _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/text_uppercase.png', _T('bartypenr:barre_gestion_cr_changercassemajuscules'), $champhelp) .'&nbsp;'
. bouton_barre_racc ("barre_capitales($champ,false,$num_barre)",  _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/text_lowercase.png', _T('bartypenr:barre_gestion_cr_changercasseminuscules'), $champhelp);
}

// gestion de la recherche

function afficher_gestion_remplacer($champ, $champhelp, $num_barre) {

$tableau_formulaire = '
<table class="spip_barre" style="width: auto; padding: 1px!important; border-top: 0px;" summary="">
<tr><td><label for="barre_chercher'.$num_barre.'">'.
_T('bartypenr:barre_gestion_cr_chercher')
.'</label> <input type="text" id="barre_chercher'.$num_barre.'" name="barre_chercher" value="" size="12" maxlength="255" /><br />
<input type="checkbox" name="rec_case" id="rec_case'.$num_barre.'" value="yes" />
<label for="rec_case'.$num_barre.'">'._T('bartypenr:barre_gestion_cr_casse').'</label><br />
   <input type="button" value="'._T('bartypenr:barre_gestion_cr_chercher').'" class="fondo"
  onclick="javascript:barre_search(document.formulaire.barre_chercher.value, document.formulaire.rec_entier.checked, document.formulaire.rec_case.checked,'.$num_barre.');" /> 
</td><td><label for="barre_remplacer'.$num_barre.'">'
._T('bartypenr:barre_gestion_cr_remplacer')
.'</label> <input type="text" name="barre_remplacer" id="barre_remplacer'.$num_barre.'" value="" size="12" maxlength="255" /><br />
<input type="checkbox" name="rec_tout" id="rec_tout'.$num_barre.'" value="yes" />
<label for="rec_tout'.$num_barre.'">'._T('bartypenr:barre_gestion_cr_tout').'</label><br />
<input type="checkbox" name="rec_entier" id="rec_entier'.$num_barre.'" value="yes" />
<label for="rec_entier'.$num_barre.'">'._T('bartypenr:barre_gestion_cr_entier').'</label><br />
   <input type="button" value="'._T('bartypenr:barre_gestion_cr_remplacer').'" class="fondo"
  onclick="javascript:barre_searchreplace(document.formulaire.barre_chercher'.$num_barre.'.value, document.formulaire.barre_remplacer'.$num_barre.'.value, document.formulaire.rec_tout'.$num_barre.'.checked, document.formulaire.rec_case'.$num_barre.'.checked, document.formulaire.rec_entier'.$num_barre.'.checked,'.$champ.','.$num_barre.');" /> 
</td>
<td>'._T('bartypenr:barre_gestion_cr_changercasse').' :'. RaccourcisMajusculesMinuscules($champ, $champhelp, $num_barre).'
</td>
</tr></table>';

  return produceWharf('tableau_remplacer','',$tableau_formulaire); 
}

// pour les ancres
function afficher_gestion_ancre($champ, $num_barre) {

$tableau_formulaire = '
<table class="spip_barre" style="width: auto; padding: 1px!important; border-top: 0px;" summary="">
  <tr>
    <td style="width:auto; text-align:center;"><strong>'.
_T('bartypenr:barre_gestion_anc_caption')
.'</strong></td>
    <td style="width:auto;"><strong>'.
_T('bartypenr:barre_gestion_anc_inserer')
.'</strong><br />
    <label for="ancre_nom'.$num_barre.'"><i>'.
_T('bartypenr:barre_gestion_anc_nom')
.'</i></label> <br />
      <input type="text" name="ancre_nom" id="ancre_nom'.$num_barre.'" />
	  
	<input type="button" value="'._T('pass_ok').'" class="fondo" onclick="javascript:barre_ancre(\'[\', \'<-\', \']\', document.formulaire.ancre_nom'.$num_barre.'.value, '.$champ.','.$num_barre.');" />
    </td>
	<td style="width:auto;"><strong>'.
_T('bartypenr:barre_gestion_anc_pointer')
.'</strong><br />
    <label for="ancre_cible'.$num_barre.'"><i>'.
_T('bartypenr:barre_gestion_anc_cible')
.'</i></label> <input type="text" name="ancre_cible" id="ancre_cible'.$num_barre.'" /><br />
	<label for="ancre_bulle'.$num_barre.'"><i>'.
_T('bartypenr:barre_gestion_anc_bulle')
.'</i></label> <input type="text" name="ancre_bulle" id="ancre_bulle'.$num_barre.'" />
	<input type="button" value="'._T('pass_ok').'" class="fondo" onclick="javascript:barre_demande(\'[\', \'->#\', \']\', document.formulaire.ancre_cible'.$num_barre.'.value, document.formulaire.ancre_bulle'.$num_barre.'.value, '.$champ.', '.$num_barre.');" /> 
</td>
  </tr> 
</table>';

  return produceWharf('tableau_ancre','',$tableau_formulaire); 	
}

// pour les caracteres
function afficher_caracteres($champ, $spip_lang, $champhelp, $num_barre) {

	// guillemets
	if ($spip_lang == "fr" OR $spip_lang == "eo" OR $spip_lang == "cpf" OR $spip_lang == "ar" OR $spip_lang == "es") {
$reta .= bouton_barre_racc ("barre_raccourci('&laquo;~','~&raquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets.png", _T('barre_guillemets'), $champhelp);
$reta .= bouton_barre_racc ("barre_raccourci('&ldquo;','&rdquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets-simples.png", _T('barre_guillemets_simples'), $champhelp);
}
else if ($spip_lang == "bg" OR $spip_lang == "de" OR $spip_lang == "pl" OR $spip_lang == "hr" OR $spip_lang == "src") {
$reta .= bouton_barre_racc ("barre_raccourci('&bdquo;','&ldquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets-de.png", _T('barre_guillemets'), $champhelp);
$reta .= bouton_barre_racc ("barre_raccourci('&sbquo;','&lsquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets-uniques-de.png", _T('barre_guillemets_simples'), $champhelp);
}
else {
$reta .= bouton_barre_racc ("barre_raccourci('&ldquo;','&rdquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets-simples.png", _T('barre_guillemets'), $champhelp);
$reta .= bouton_barre_racc ("barre_raccourci('&lsquo;','&rsquo;',$champ)", _DIR_IMG_ICONES_BARRE."guillemets-uniques.png", _T('barre_guillemets_simples'), $champhelp);
}
	// caracteres
if ($spip_lang == "fr" OR $spip_lang == "eo" OR $spip_lang == "cpf") {

$reta .= bouton_barre_racc ("barre_inserer('&Agrave;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/agrave-maj.png', _T('barre_a_accent_grave'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&Eacute;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/eacute-maj.png', _T('barre_e_accent_aigu'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&Egrave;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/eagrave-maj.png', _T('bartypenr:barre_e_accent_grave'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&aelig;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/aelig.png', _T('bartypenr:barre_ea'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&AElig;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/aelig-maj.png', _T('bartypenr:barre_ea_maj'), $champhelp);

if ($spip_lang == "fr") {
$reta .= bouton_barre_racc ("barre_inserer('&oelig;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/oelig.png', _T('barre_eo'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&OElig;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/oelig-maj.png', _T('barre_eo_maj'), $champhelp);
$reta .= bouton_barre_racc ("barre_inserer('&Ccedil;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/ccedil-maj.png', _T('bartypenr:barre_c_cedille_maj'), $champhelp);
}
}
// euro
$reta .= bouton_barre_racc ("barre_inserer('&euro;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/euro.png', _T('barre_euro'), $champhelp);
$reta .= '&nbsp;'.RaccourcisMajusculesMinuscules($champ, $champhelp, $num_barre);

$reta .= '&nbsp;';
	
$tableau_formulaire = '
<table class="spip_barre" style="width: auto; padding: 1px!important; border-top: 0px;" summary="">
  <tr class="spip_barre">
    <td>'._T('bartypenr:barre_caracteres').'</td>
    <td>'.$reta.'
    </td>
  </tr> 
</table>
';

  return produceWharf('tableau_caracteres','',$tableau_formulaire); 	
}

// pour les caracteres
function afficher_formatages_speciaux($champ, $spip_lang, $champhelp, $num_barre) {
	$reta = bouton_barre_racc ("barre_raccourci('\n\n&lt;quote&gt;','&lt;/quote&gt;\n\n',$champ)", _DIR_IMG_ICONES_BARRE."quote.png", _T('barre_quote'), $champhelp);
	$reta .= bouton_barre_racc ("barre_raccourci('&lt;code&gt;','&lt;/code&gt;',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/page_white_code_red.png", _T('bartypenr:barre_code'), $champhelp);
	$reta .= bouton_barre_racc ("barre_raccourci('\n\n&lt;cadre&gt;','&lt;/cadre&gt;\n\n',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/page_white_code.png", _T('bartypenr:barre_cadre'), $champhelp);
	$reta .= bouton_barre_racc ("barre_raccourci('\n\n&lt;poesie&gt;','&lt;/poesie&gt;\n\n',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/poesie.png", _T('bartypenr:barre_poesie'), $champhelp);
	$tableau_formulaire = '
	<table class="spip_barre" style="width: auto; padding: 1px!important; border-top: 0px;" summary="">
	  <tr class="spip_barre">
		<td>'._T('bartypenr:barre_formatages_speciaux').'</td>
		<td>'.$reta.'
		</td>
	  </tr> 
	</table>
	';
	return produceWharf('tableau_formatages_speciaux','',$tableau_formulaire); 	
}

// construit un tableau de raccourcis pour un noeud de DOM

// http://doc.spip.org/@afficher_barre
function afficher_barre($champ, $forum=false, $lang='') {
	global $spip_lang, $spip_lang_right, $spip_lang_left;
	static $num_barre = 0;
	include_spip('inc/layer');
	if (!$GLOBALS['browser_barre']) return '';
	if (!$lang) $lang = $spip_lang;
	$num_barre++;
	$champhelp = "document.getElementById('barre_$num_barre')";

	$layer_public = '<script type="text/javascript" src="' . find_in_path('javascript/layer.js').'"></script>';
	$ret = ($num_barre > 1)  ? '' :
	  $layer_public . '<script type="text/javascript" src="' . find_in_path('javascript/spip_barre.js').'"></script>';




 // Pregeneration des toolzbox.. (wharfing)
    $toolbox .= afficher_caracteres($champ, $spip_lang, $champhelp, $num_barre);
	$toolbox .= afficher_formatages_speciaux($champ, $spip_lang, $champhelp, $num_barre);
    $toolbox .= afficher_gestion_lien($champ, $num_barre);
    $toolbox .= afficher_gestion_ancre($champ, $num_barre);
    $toolbox .= afficher_gestion_remplacer($champ, $champhelp, $num_barre);
//un pipeline pour ajouter une toolbox
    $params = array($champ,$champhelp,$spip_lang, $num_barre);
    $add = pipeline("BarreTypoEnrichie_toolbox", $params);
    if ($params!=$add)
		$toolbox .= $add;

//

	$ret .= "<table class='spip_barre' cellpadding='0' cellspacing='0' border='0'>";
	$ret .= "\n<tr>";
	$ret .= "\n<td style='text-align: $spip_lang_left;' valign='middle'>";
	$col = 1;

	// Italique, gras, intertitres
	$ret .= bouton_barre_racc ("barre_raccourci('{','}',$champ)", _DIR_IMG_ICONES_BARRE."italique.png", _T('barre_italic'), $champhelp);
	$ret .= bouton_barre_racc ("barre_raccourci('{{','}}',$champ)", _DIR_IMG_ICONES_BARRE."gras.png", _T('barre_gras'), $champhelp);
	$params = array($champ,$champhelp,$spip_lang);
	$add = pipeline("BarreTypoEnrichie_tous",array($champ,$champhelp,$spip_lang));
	if ($params!=$add)
		$ret .= $add;

	$params = array($champ,$champhelp,$spip_lang);
	$add = pipeline("BarreTypoEnrichie_avancees",array($champ,$champhelp,$spip_lang));
	if ($params!=$add)
		$ret .= $add;
	if (!$forum) {
		$params = array($champ,$champhelp,$spip_lang);
		$add = pipeline("BarreTypoEnrichie_ecrire",array($champ,$champhelp,$spip_lang));
		if ($params!=$add)
			$ret .= $add;
		$ret .= "&nbsp;";
		$ret .= bouton_barre_racc ("barre_raccourci('\n\n{{{','}}}\n\n',$champ)", _DIR_IMG_ICONES_BARRE."intertitre.png", _T('barre_intertitre'), $champhelp);
	}
	$ret .= "&nbsp;</td>\n<td>";
	$col ++;

// gestion des liens
      $ret .=    bouton_barre_racc("swap_couche('".$GLOBALS['numero_block']['tableau_lien']."','');", _DIR_IMG_ICONES_BARRE."lien.png", _T('barre_lien'), $champhelp);
// gestion des ancres		
		$ret .=    bouton_barre_racc("swap_couche('".$GLOBALS['numero_block']['tableau_ancre']."','');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/ancre.png", _T('bartypenr:barre_ancres'), $champhelp);  
	if (!$forum) {
		$ret .= bouton_barre_racc ("barre_raccourci('[[',']]',$champ)", _DIR_IMG_ICONES_BARRE."notes.png", _T('barre_note'), $champhelp);
	}
	if ($forum) {
		$params = array($champ,$champhelp,$spip_lang);
		$add = pipeline("BarreTypoEnrichie_forum",array($champ,$champhelp,$spip_lang));
		if ($params!=$add)
			$ret .= $add;
		$ret .= "&nbsp;</td>\n<td style='text-align: $spip_lang_left;' valign='middle'>";
		$col ++;
		$ret .= bouton_barre_racc ("barre_raccourci('\n\n&lt;quote&gt;','&lt;/quote&gt;\n\n',$champ)", _DIR_IMG_ICONES_BARRE."quote.png", _T('barre_quote'), $champhelp);
	} elseif (lire_config('btv2/avancee') == 'Oui') {
		$ret .= "&nbsp;</td>\n<td style='text-align: $spip_lang_left;' valign='middle'>";
		$col ++;
		$ret .= bouton_barre_racc("swap_couche('".$GLOBALS['numero_block']['tableau_formatages_speciaux']."','');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/tag.png", _T('bartypenr:barre_formatages_speciaux'), $champhelp);;
	}
	$ret .= bouton_barre_racc ("barre_raccourci('[?',']',$champ)", _DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/barre-wiki.png', _T('bartypenr:barre_glossaire'), $champhelp);

	//gestion des tableaux
	$ret .= bouton_barre_racc("barre_tableau($champ, '"._DIR_RESTREINT."')",
		_DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/barre-tableau.png', _T('bartypenr:barre_tableau'),
		$champhelp);

	$ret .= "</td>\n<td style='text-align: $spip_lang_left;' valign='middle'>";

	// gestion du remplacement
      $ret .=    bouton_barre_racc("swap_couche('".$GLOBALS['numero_block']['tableau_remplacer']."','');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/chercher_remplacer.png", _T('bartypenr:barre_chercher'), $champhelp);
	// DEB Galerie JPK
	// id�e originale de http://www.gasteroprod.com/la-galerie-spip-pour-reutiliser-facilement-les-images-et-documents.html
	if (!$forum) {
		$ret .= bouton_barre_racc ("javascript:barre_galerie($champ, '"._DIR_RESTREINT."')",
			_DIR_PLUGIN_BARRETYPOENRICHIE.'/img_pack/icones_barre/galerie.png', _T('bartypenr:barre_galerie'), $formulaire, $texte);
	}
	// FIN Galerie JPK




	$ret .= "</td>";
	$col++;

	// Insertion de caracteres difficiles a taper au clavier (guillemets, majuscules accentuees...)
	$ret .= "\n<td style='text-align: $spip_lang_left;' valign='middle'>";
	$col++;
	$ret .=    bouton_barre_racc("swap_couche('".$GLOBALS['numero_block']['tableau_caracteres']."','');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/clavier.png", _T('bartypenr:barre_caracteres'), $champhelp);
	


	$ret .= "</td>";
	$col++;

	if (test_espace_prive()) {
		if (!$forum) {
			$ret .= "\n<td style='text-align: $spip_lang_left;' valign='middle'>";
			$col++;
			$ret .= bouton_barre_racc("toggle_preview($num_barre,'".str_replace("'","\\'",$champ)."');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/eye.png", _T('bartypenr:barre_preview'), $champhelp);
			$ret .= bouton_barre_racc("toggle_stats($num_barre,'".str_replace("'","\\'",$champ)."');", _DIR_PLUGIN_BARRETYPOENRICHIE."/img_pack/icones_barre/stats.png", _T('bartypenr:barre_stats'), $champhelp);
			$ret .= "</td>";
		}
		$ret .= "\n<td style='text-align:$spip_lang_right;' valign='middle'>";
		$col++;
		$ret .= aide("raccourcis");
		$ret .= "&nbsp;";
		$ret .= "</td>";
	}
	$ret .= "</tr>";

	// Sur les forums publics, petite barre d'aide en survol des icones
	if (!test_espace_prive())
		$ret .= "\n<tr>\n<td colspan='$col'><input disabled='disabled' type='text' class='barre' id='barre_$num_barre' size='45' maxlength='100'\nvalue=\"".attribut_html(_T('barre_aide'))."\" /></td></tr>";

	$ret .= "</table>";
	 $ret .= $toolbox;
	 $ret .= '<script type="text/javascript"><!--';
	 $ret .= '
form_dirty = false;
warn_onunload = true;

/* ChainHandler, py Peter van der Beken
-------------------------------------------------------- */
function chainHandler(obj, handlerName, handler) {
        obj[handlerName] = (function(existingFunction) {
                return function() {
                        handler.apply(this, arguments);
                        if (existingFunction)
                                existingFunction.apply(this, arguments);
                };
        })(handlerName in obj ? obj[handlerName] : null);
};

$(document).ready(function(){';
	 if (!$forum) {
	 $ret .= '
	$('.$champ.').after("<div id=\"article_preview'.$num_barre.'\"></div>");
	$('.$champ.').before("<div id=\"article_stats'.$num_barre.'\"></div>");
	';
	global $spip_version_code;
	if (version_compare($spip_version_code,'1.925','<')){
	 $ret .= '$.ajaxTimeout( 5000 );
	 '; // jquery < 1.1.4
	} else {
	 $ret .= '$.ajaxSetup({timeout: 5000});'; // a partir de jquery 1.1.4, donc de SPIP 1.9.3
	}
	 $ret .= '
	$('.$champ.').keypress(function() { MajPreview('.$num_barre.',"'.$champ.'") });
	$('.$champ.').select(function() { MajStats('.$num_barre.',"'.$champ.'") });
	$('.$champ.').click(function() { MajStats('.$num_barre.',"'.$champ.'") });';
	 }
	 $ret .= '
	chainHandler(window,\'onbeforeunload\',function(e) { 
		if (e == undefined && window.event) {
	                e = window.event;
		}
		if ( (warn_onunload == true) && (form_dirty == true) && ($.browser.mozilla) ) {
			e.returnValue = \'Quitter la page sans sauvegarder ?\';
			return \'Quitter la page sans sauvegarder ?\'; 
		}
		return false;
	} );
	$("form").submit ( function() {warn_onunload=false;} );
	$('.$champ.')
		.parents(\'form\')
		.find(\'input,textarea,select\')
		.not(\'[@type=hidden]\')
		.change ( function() {form_dirty=true;} );
	$("input").change ( function() {form_dirty=true;} );
});
	 //--></script>';
	return $ret;
}

// expliciter les 3 arguments pour avoir xhtml strict

// http://doc.spip.org/@afficher_textarea_barre
function afficher_textarea_barre($texte, $forum=false, $form='document.formulaire.texte')
{
	global $spip_display, $spip_ecran;

	$rows = ($spip_ecran == "large") ? 28 : 15;

	return (($spip_display == 4) ? '' : afficher_barre($form.'.texte', $forum))
			. "<textarea name='texte' id='texte' "
			. $GLOBALS['browser_caret']
			. " rows='$rows' class='formo' cols='40'>"
			. entites_html($texte)
			. "</textarea>\n";
}

?>
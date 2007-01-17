<?php
/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/

// Bloogletter


// Verifier la conformite d'une ou plusieurs adresses email
function email_valide_bloog($adresse) {
	// Si c'est un spammeur autant arreter tout de suite
	if (preg_match(",[\n\r].*(MIME|multipart|Content-),i", $adresse)) {
		spip_log("Tentative d'injection de mail : $adresse");
		return false;
	}
	
	$adresses = explode(',', $adresse);
	if (is_array($adresses)) {
		while (list(, $adresse) = each($adresses)) {
			// nettoyer certains formats
			// "Marie Toto <Marie@toto.com>"
			$adresse = eregi_replace("^[^<>\"]*<([^<>\"]+)>$", "\\1", $adresse);
			// pas RFC 822  mais un truc plus restrictif pour les bounces
			if (!eregi('^[_\.0-9a-z-]+@([0-9a-z-]+\.)+[a-z]{2,4}$', trim($adresse)))
				return false;
		}
		return true;
	}
	return false;
}

/****
 * titre : propre_bloog
 * Enleve les enluminures Spip pour la bloogletter
 Vincent CARON
****/

function propre_bloog($texte) {

        $texte = ereg_replace("<p class=\"spip\">(\r\n|\n|\r)?</p>",'',$texte);
        $texte = eregi_replace("\n{3}", "\n", $texte);
       
      
      // div imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<div([^>]*)>" , "<div\\2>" , $texte);
        $texte = eregi_replace( "<\/div>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);
        
        // style imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<style([^>]*)>" , "<style>" , $texte);
        $texte = eregi_replace( "<\/style>(\r\n|\n|\r| )*<\/p>" , "</style>" , $texte);
      
      
        // h3 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h3 class=\"spip\">" , "<h3>" , $texte);
        $texte = eregi_replace( "<\/h3>(\r\n|\n|\r| )*<\/p>" , "</h3>" , $texte);

	// h2 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h2>" , "<h2>" , $texte);
        $texte = eregi_replace( "<\/h2>(\r\n|\n|\r| )*<\/p>" , "</h2>" , $texte);
        
    // h1 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h1>" , "<h1>" , $texte);
        $texte = eregi_replace( "<\/h1>(\r\n|\n|\r| )*<\/p>" , "</h1>" , $texte);
        

	// tableaux imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(table|TABLE)" , "<table" , $texte);
       $texte = eregi_replace( "<\/(table|TABLE)>(\r\n|\n|\r| )*<\/p>" , "</table>" , $texte);

	// TD imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(\/td|\/TD)" , "</td" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);

	// p imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(p|P)" , "<p" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);

         // DIV imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(div|DIV)" , "<div" , $texte);
       $texte = eregi_replace( "<\/(DIV|div)>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);

 //$texte = PtoBR($texte);
  $texte = ereg_replace ("\.php3&nbsp;\?",".php3?", $texte);
  $texte = ereg_replace ("\.php&nbsp;\?",".php?", $texte);

  return $texte;
}


/****
 * titre : version_texte
 * d'après Clever Mail (-> NHoizey)
****/

function version_texte ($in) {
// Nettoyage des liens des notes de bas de page
$out = ereg_replace("<a href=\"#n(b|h)[0-9]+-[0-9]+\" name=\"n(b|h)[0-9]+-[0-9]+\" class=\"spip_note\">([0-9]+)</a>", "\\3", $in);

// Supprimer tous les liens internes
$patterns = array("/\<a href=['\"]#(.*?)['\"][^>]*>(.*?)<\/a>/");
$replacements = array("\\2");
$out = preg_replace($patterns,$replacements, $out);

// Supprime feuille style
$out = ereg_replace("<style[^>]*>[^<]*</style>", "", $out);

// les puces
$out = str_replace($GLOBALS['puce'], "\n".'-', $out);

// Remplace tous les liens	
$patterns = array(
           "/\<a href=['\"](.*?)['\"][^>]*>(.*?)<\/a>/"
       );
       $replacements = array(
           "\\2 (\\1)"
       );
$out = preg_replace($patterns,$replacements, $out);

$out = ereg_replace("<h1[^>]*>", "\n--------------------------------------------------------\n", $out);
$out = str_replace("</h1>", "\n--------------------------------------------------------\n", $out);
$out = ereg_replace("<h2[^>]*>", "\n............... ", $out);
$out = str_replace("</h2>", " ...............\n", $out);
$out = ereg_replace("<h3[^>]*>", "\n + ", $out);
$out = str_replace("</h3>", "\n", $out);
$out = str_replace("<p class=\"spip\"[^>]*>", "\n", $out);

// Les notes de bas de page
    $out = str_replace("<p class=\"spip_note\">", "\n", $out);
    $out = ereg_replace("<sup>([0-9]+)</sup>", "[\\1]", $out);

    //$out = str_replace('<br /><img class=\'spip_puce\' src=\'puce.gif\' alt=\'-\' border=\'0\'>', "\n".'-', $out);
$out = ereg_replace ('<li[^>]>', "\n".'-', $out);
    //$out = str_replace('<li>', "\n".'-', $out);


    // accentuation du gras -
    // <b>texte</b> -> *texte*
    $out = ereg_replace ('<b[^>|r]*>','*' ,$out);
    $out = str_replace ('</b>','*' ,$out);

    // accentuation de l'italique
    // <i>texte</i> -> *texte*
    $out = ereg_replace ('<i[^>|mg]*>','*' ,$out);
    $out = str_replace ('</i>','*' ,$out);

	$out = str_replace('&oelig;', 'oe', $out);
	$out = str_replace("&nbsp;", " ", $out);
	$out = filtrer_entites($out);

	$out = supprimer_tags($out);

        //$out = ereg_replace("^(\n|\r|\r\n| )+", "", $out);
		 //$out = ereg_replace("^( )", "", $out);
		 //$out = ereg_replace("(\n\n\n)+", "", $out) ;
		 //$out = ereg_replace("(\n\n)+", "", $out) ;
		 
		 $out = str_replace("\x0B", "", $out); 
		 $out = ereg_replace("\t", "", $out) ;
		 //$out = ereg_replace("[\n]{3,}", "\n\n", $out);
		 $out = ereg_replace("[ ]{3,}", "", $out);
		  // Bring down number of empty lines to 2 max
        $out = preg_replace("/\n\s+\n/", "\n\n", $out);
        $out = preg_replace("/[\n]{3,}/", "\n\n", $out);
		
		//$out = trim($out) ;
		
    return $out;

}




/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/
?>

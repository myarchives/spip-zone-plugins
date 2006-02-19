<?php

define('_DIR_PLUGIN_COLORATION_CODE',(_DIR_PLUGINS . basename(dirname(__FILE__))));

function coloration_code_color($code, $language='php') {
  
  include_once(_DIR_PLUGIN_COLORATION_CODE.'/geshi/geshi.php');
  //
  // Create a GeSHi object
  //
  $geshi =& new GeSHi($code, $language);
  $geshi->set_header_type(GESHI_HEADER_DIV);
  $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);

  //
  // And echo the result!
  //
  return $geshi->parse_code();

}

function coloration_code_echappe($texte) {
  $rempl ='';
  if (preg_match_all(
					 ',<ccode\\((.*)\\)>(.*)</ccode>,Uims',
					 $texte, $matches, PREG_SET_ORDER))
	foreach ($matches as $regs) {
	  $code = echappe_retour($regs[2]);
	  $rempl = coloration_code_color($code,$regs[1]);
	  $texte = str_replace($regs[0],code_echappement($rempl,"COLCODE"),$texte);
	}
  return $texte;
}

function coloration_code_echappe_retour($texte) {
  return echappe_retour($texte,"COLCODE");
}


?>

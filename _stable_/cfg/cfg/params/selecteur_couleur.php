<?php

/*
 * Plugin CFG pour SPIP
 * (c) toggg, marcimat, dF 2008, distribue sous licence GNU/GPL
 * Documentation et contact: http://www.spip-contrib.net/
 * 
 * Patch de compatibilité avec classe cfg_couleur, OBSOLETE (utilisez la classe palette) 
 */


function cfg_charger_param_selecteur_couleur($valeur, &$cfg){
	// si provient d'un CVT, on met inline, sinon dans head
	$ou = ($cfg->depuis_cvt) ? 'inline':'head';
	// si le plugin Palette est installé, on patche
	if (is_dir(find_in_path(_DIR_PLUGIN_PALETTE))) {
		$cfg->param[$ou] .= "\n<script langage='javascript' src='$lib'></script>\n";
		$cfg->param[$ou] .= "
<style>
.colorpicker {position: relative;}
</style>
<script type='text/javascript'>
//<![CDATA[
$(document).ready(function() {
	$('input.cfg_couleur').each(function() {
		$(this).addClass('palette');
		$(this).removeClass('cfg_couleur');
	});
});".
($ou=='inline' ? "init_palette();" : ""). // On fait un init_palette si on est en Ajax
"//]]>
</script>
";
	}
}
?>

<?php

/*function phpmv_header_prive($flux) {
	$exec = _request('exec');
	// les CSS
	if ($exec == 'phpmv'){
		$flux .=  '<link href="'.DIR_PLUGIN_PHPMV.'/themes/default/css/{if $styleCommon}{$styleCommon}{else}interfaceCommon{/if}.css" rel="stylesheet" type="text/css" />	
	<link href="{$DIR_PLUGIN_PHPMV}/themes/default/css/styles.php?dir={'text_dir'|translate}" rel="stylesheet" type="text/css" />	
	<script type="text/javascript" src="{$DIR_PLUGIN_PHPMV}/themes/default/include/menu.js"></script>
	<script type="text/javascript" src="{$DIR_PLUGIN_PHPMV}/themes/default/include/misc.js"></script>
	<link rel="alternate" type="application/rss+xml" title="RSS" href="./?exec=phpmv&mod=view_rss&amp;rss_hash={$rss_hash}" />
		$flux .= '<link rel="stylesheet" href="' ._DIR_PLUGIN_AGENDA_EVENEMENTS . '/img_pack/calendrier.css" type="text/css" />'. "\n";
		$flux .= '<link rel="stylesheet" href="' ._DIR_PLUGIN_AGENDA_EVENEMENTS . '/img_pack/agenda.css" type="text/css" />'. "\n";
	}
	return $flux;
}*/


function phpmv_affichage_final($texte){
	//$html= preg_match(',^\s*text/html,',$page['entetes']['Content-Type']);
	global $html;
	if ($html){
		include_spip("inc/meta");
		ecrire_meta('_PHPMV_DIR_CONFIG',realpath(_DIR_SESSIONS . "phpmvconfig"));
		ecrire_meta('_PHPMV_DIR_DATA',realpath(_DIR_SESSIONS . "phpmvdatas"));
		ecrire_meta('_DIR_PLUGIN_PHPMV',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__)))))));
		ecrire_metas();

		//define(PHPMV_URL,'@@');
		$i_site = 1;
		
		$code = '<!-- phpmyvisites -->
				<div style="display:none;">
				<script type="text/javascript">
				<!--
				var a_vars = Array();
				var pagename=\'\';
				
				var phpmyvisitesSite = '.$i_site.';
				var phpmyvisitesURL = "'.generer_url_public('phpmyvisites','',true).'";
				//-->
				</script>
				<script language="javascript" src="'.url_de_base().find_in_path('spip_phpmyvisites.js').'" type="text/javascript"></script>
				<noscript>
				<img src="'.generer_url_public('phpmyvisites','',true).'" alt="phpMyVisites" style="border:0" />
				</noscript>
				</div>
				<!-- /phpmyvisites -->';
		
		$texte=str_replace("</body>","$code\n</body>",$texte);
	}
	return $texte;
	
}
?>
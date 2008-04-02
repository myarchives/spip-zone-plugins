<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// ajoute les css et js necessaires dans les pages adequates
function xspf_header_prive($texte) {
	global $auteur_session, $spip_display, $spip_lang;
	$cfg = _request('cfg');
	$pos = strpos($cfg, 'imagecycle');
	if ($pos === 0){
		$tooltipcss = find_in_path('scripts/jquery.tooltip.css');
		$farbcss = url_absolue_css(direction_css(find_in_path('css/farbtastic.css')));
		
		$bgiframejs = find_in_path('scripts/jquery.bgiframe.js');
		$dimensionjs = find_in_path('scripts/jquery.dimensions.pack.js');
		$tooltipjs = find_in_path('scripts/jquery.tooltip.pack.js');
		$farbjs = find_in_path('scripts/farbtastic.js');
				
		$texte.= "
			<link rel='stylesheet' type='text/css' href='$tooltipcss' />\n
			<link rel='stylesheet' type='text/css' href='$farbcss' />\n
			<script type='text/scripts' src='$bgiframejs'></script>\n
			<script type='text/scripts' src='$dimensionjs'></script>\n
			<script type='text/scripts' src='$tooltipjs'></script>\n
			<script type='text/scripts' src='$farbjs'></script>" . "\n";

		$texte.= "
			<script type='text/javascript'>
				$(document).ready(function() {
					$('a').Tooltip({
						track: true,
						delay: 0,
						showURL: false,
						showBody: ' - '
					});
				});
	
			$(document).ready(function() {
				$('.picker').css('opacity', 0.25);
				var selected;
				$('.colorwell')
					.each(function () { 
						var pick = $(this).parent().children('.picker');
						$.farbtastic(pick).linkTo(this);$(this).css('opacity', 0.75);})
				
					.focus(function() {
						if (selected) {
							$(selected).css('opacity', 0.75).removeClass('colorwell-selected');
						}
						var pick = $(this).parent().children('.picker');
						$.farbtastic(pick).linkTo(this);
						pick.css('opacity', 1);
						$(selected = this).css('opacity', 1).addClass('colorwell-selected');
					})
					.blur(function() {
						var pick = $(this).parent().children('.picker');
						pick.css('opacity', 0.25);
						$(selected = this).css('opacity', 0.75).removeClass('colorwell-selected');
					});
			});
			</script>\n";
	}
	return $texte;
}



?>

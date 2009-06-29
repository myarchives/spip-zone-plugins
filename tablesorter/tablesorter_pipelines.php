<?php

function tablesorter_insert_head($flux){
	// Insertion des librairies js
	$flux .='<script src="'.url_absolue(find_in_path('scripts/jquery.tablesorter.js')).'" type="text/javascript"></script>';
	// Inclusion des styles du plugin
	$flux .='<link rel="stylesheet" href="'.url_absolue(find_in_path('styles/tablesorter.css')).'" type="text/css" />';
	// Init de tablesorter
	$flux .='
	<script type="text/javascript">/* <![CDATA[ */
	(function($){
		$(function(){
			$("table.spip").tablesorter();
		});
	})(jQuery);
	/* ]]> */</script>';
	return $flux;
}

?>
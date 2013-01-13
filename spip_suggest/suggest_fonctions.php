<?php
function spip_suggest_complete($q) {
	define('_MYSQL_DIR', '/var/lib/mysql/');
	// lire la base de donnees
	$s = lire_config('db_name');
	// lire les cles fulltext
	$k = lire_config('db_keys');
	$w = array();
	$tout = array();
	// on parse les donnes pour stocker tout dans un tableau
	foreach(array_filter(explode(',', $k)) as $table) {
		// securite
		$table = explode(':', str_replace(' ', '', $table));
		$tout[$table[0]][] = $table[1];
	}
	// on execute le programme
	foreach ($tout as $key=>$value) {
		foreach($value as $cle) {
			exec($c = 'myisam_suggest '._MYSQL_DIR.$s.'/'.$key.' '.$cle.' '.escapeshellarg($q), $lines);
		}
	}
	
	// les resultats maintenant
	$res = array();
	foreach (array_map('strtolower',$lines) as $line)
		$res[trim($line)]++;
	if (lire_config('suggest_classement', 'nom') == 'popularite') {
		arsort($res);
	}
	foreach ($res as $key=>$value) {
		if (intval($value) > 1) 
			$aff = $value.' '._T('spip_suggest:resultats');
		else
			$aff = $value.' '._T('spip_suggest:resultat');
		$w[] = array('label' => strtolower($key), 'nb' => $aff);
	}
	return $w;
}

function spip_suggest_insert_head($flux) {
	$flux .= '
<script type="text/javascript">
	$(document).ready(function(){
$( "#recherche" ).autocomplete({
      minLength: 0,
      source:"'.generer_url_public("suggest").'",
      position: { my : "left top", at: "left bottom", of: "#formulaire_recherche" },
      focus: function( event, ui ) {
        $("#recherche").val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#recherche" ).val( ui.item.label );
		$("#formulaire_recherche form").submit();
        return false;
      }
    }).data( "autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + item.label + " (" + item.nb + ")</a>" )
        .appendTo( ul );
    };
});
</script>';
	return $flux;
}
?>
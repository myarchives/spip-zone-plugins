<?php 

    function innerfade_insert_head($flux){
        $flux .= '<link rel="stylesheet" href="'.find_in_path('css/diaporama_innerfade.css').'" type="text/css" media="projection, screen, tv" />'."\n";
        $flux .= '<script src="'.find_in_path('js/jquery.innerfade.js').'" type="text/javascript"></script>'."\n";
        return $flux;

    }

?>

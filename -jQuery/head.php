<?php

function JQuery_insert_head($flux){
		//if (_request('jqdb')!==NULL)
			$js = '<script src="'.find_in_path('jquery.lite.213.js').'" type="text/javascript"></script>';
			$js .= '<script src="'.find_in_path('form.js').'" type="text/javascript"></script>';
		//else
		//	$js = '<script src="'.find_in_path('jquery.pack.213.js').'" type="text/javascript"></script>';
		if (strpos($flux,'<head')!==FALSE)
			return preg_replace('/(<head[^>]*>)/i', "\n\$1".$js, $flux, 1);
		else 
			return $js.$flux;
	}

?>
<?php

define('_RAINETTE_WUNDERGROUND_URL_BASE_REQUETE', 'http://api.wunderground.com/api');
define('_RAINETTE_WUNDERGROUND_URL_BASE_ICONE', 'http://icons.wxug.com/i/c');
define('_RAINETTE_WUNDERGROUND_JOURS_PREVISIONS', 3);
define('_RAINETTE_WUNDERGROUND_SUFFIXE_METRIQUE', 'c:mb:km:kph');
define('_RAINETTE_WUNDERGROUND_SUFFIXE_STANDARD', 'f:in:mi:mph');

function wunderground_service2cache($lieu, $mode) {

	$dir = sous_repertoire(_DIR_CACHE, 'rainette');
	$dir = sous_repertoire($dir, 'wunderground');
	$fichier_cache = $dir . str_replace(array(',', '+', '.', '/'), '-', $lieu) . "_" . $mode . ".txt";

	return $fichier_cache;
}

function wunderground_service2url($lieu, $mode) {

	include_spip('inc/config');
	$cle = lire_config('rainette/wunderground/inscription');

	// Determination de la demande
	if ($mode == 'infos') {
		$demande = 'geolookup';
	}
	else {
		$demande = ($mode == 'previsions') ? 'forecast/astronomy' : 'conditions';
	}

	// Identification et formatage du lieu
	$query = str_replace(array(' ', ','), array('', '/'), trim($lieu));
	$index = strpos($query, '/');
	if ($index !== false) {
		$ville = substr($query, 0, $index);
		$pays = substr($query, $index+1, strlen($query)-$index-1);
		$query = $pays . '/' . $ville;
	}

	// Identification de la langue du resume
	// TODO : creer une fonction de transcodage prefixe spip vers prefixe wunderground
	$langue = strtoupper($GLOBALS['spip_lang']);

	$url = _RAINETTE_WUNDERGROUND_URL_BASE_REQUETE
		.  '/' . $cle
		.  '/' . $demande
		.  '/lang:' . $langue
		.  '/q'
		.  '/' . $query . '.xml';

	return $url;
}

function wunderground_url2flux($url) {

	include_spip('inc/distant');
	$flux = recuperer_page($url);

	include_spip('inc/rainette_utils');
	$xml = @simplexml2array(simplexml_load_string($flux));

	return $xml;
}


function wunderground_meteo2weather($meteo, $periode=0) {
	static $wunderground2weather = array(
							'chanceflurries'=> array('41','46'),
							'chancerain'=> array('39','45'),
							'chancesleet'=> array('39','45'),
							'chancesleet'=> array('41','46'),
							'chancesnow'=> array('41','46'),
							'chancetstorms'=> array('38','47'),
							'chancetstorms'=> array('38','47'),
							'clear'=> array('32','31'),
							'cloudy'=> array('26','26'),
							'flurries'=> array('15','15'),
							'fog'=> array('20','20'),
							'hazy'=> array('21','21'),
							'mostlycloudy'=> array('28','27'),
							'mostlysunny'=> array('34','33'),
							'partlycloudy'=> array('30','29'),
							'partlysunny'=> array('28','27'),
							'sleet'=> array('5','5'),
							'rain'=> array('11','11'),
							'sleet'=> array('5','5'),
							'snow'=> array('16','16'),
							'sunny'=> array('32','31'),
							'tstorms'=> array('4','4'),
							'thunderstorms'=> array('4','4'),
							'thunderstorm'=> array('4','4'),
							'unknown'=> array('4','4'),
							'cloudy'=> array('26','26'),
							'scatteredclouds'=> array('30','29'),
							'overcast'=> array('26','26'));

	$icone = 'na';
	if (array_key_exists($meteo,  $wunderground2weather))
		$icone = strval($wunderground2weather[$meteo][$periode]);
	return $icone;
}

/**
 * lire le xml fournit par le service meteo et en extraire les infos interessantes
 * retournees en tableau jour par jour
 * utilise le parseur xml de Spip
 *
 * ne gere pas encore le jour et la nuit de la date courante suivant l'heure!!!!
 * @param array $xml
 * @return array
 */
function wunderground_xml2previsions($xml){
	include_spip('inc/xml');
	$tableau = array();
	$n = spip_xml_match_nodes(",^dayf,",$xml,$previsions);
	if ($n==1){
		$previsions = reset($previsions['dayf']);
		// recuperer la date de debut des previsions (c'est la date de derniere maj)
		$date_maj = $previsions['lsup'][0];
		$date_maj = strtotime(preg_replace(',\slocal\s*time\s*,ims','',$date_maj));
		$index = 0;
		foreach($previsions as $day=>$p){
			if (preg_match(",day\s*d=['\"?]([0-9]+),Uims",$day,$regs)){
				$date_stamp = $date_maj+$regs[1]*24*3600;
				$p = reset($p);
				// Index du jour et date du jour
				$tableau[$index]['index'] = $index;
				$tableau[$index]['date'] = date('Y-m-d',$date_stamp);
				// Date complete des lever/coucher du soleil
				$date = getdate($date_stamp);
				$heure = getdate(strtotime($p['sunr'][0]));
				$sun = mktime($heure['hours'],$heure['minutes'],0,$date['mon'],$date['mday'],$date['year']);
				$tableau[$index]['lever_soleil'] = date('Y-m-d H:i:s',$sun);
				$heure = getdate(strtotime($p['suns'][0]));
				$sun = mktime($heure['hours'],$heure['minutes'],0,$date['mon'],$date['mday'],$date['year']);
				$tableau[$index]['coucher_soleil'] = date('Y-m-d H:i:s',$sun);
				// Previsions du jour
				$tableau[$index]['temperature_jour'] = intval($p['hi'][0]) ? intval($p['hi'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['code_icone_jour'] = intval($p['part p="d"'][0]['icon'][0]) ? intval($p['part p="d"'][0]['icon'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['vitesse_vent_jour'] = intval($p['part p="d"'][0]['wind'][0]['s'][0]) ? intval($p['part p="d"'][0]['wind'][0]['s'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['angle_vent_jour'] = $p['part p="d"'][0]['wind'][0]['d'][0];
				$tableau[$index]['direction_vent_jour'] = $p['part p="d"'][0]['wind'][0]['t'][0];
				$tableau[$index]['risque_precipitation_jour'] = intval($p['part p="d"'][0]['ppcp'][0]);
				$tableau[$index]['humidite_jour'] = intval($p['part p="d"'][0]['hmid'][0]) ? intval($p['part p="d"'][0]['hmid'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				// Previsions de la nuit
				$tableau[$index]['temperature_nuit'] = intval($p['low'][0]) ? intval($p['low'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['code_icone_nuit'] = intval($p['part p="n"'][0]['icon'][0]) ? intval($p['part p="n"'][0]['icon'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['vitesse_vent_nuit'] = intval($p['part p="n"'][0]['wind'][0]['s'][0]) ? intval($p['part p="n"'][0]['wind'][0]['s'][0]) : _RAINETTE_VALEUR_INDETERMINEE;
				$tableau[$index]['angle_vent_nuit'] = $p['part p="n"'][0]['wind'][0]['d'][0];
				$tableau[$index]['direction_vent_nuit'] = $p['part p="n"'][0]['wind'][0]['t'][0];
				$tableau[$index]['risque_precipitation_nuit'] = intval($p['part p="n"'][0]['ppcp'][0]);
				$tableau[$index]['humidite_nuit'] = intval($p['part p="n"'][0]['hmid'][0]) ? intval($p['part p="n"'][0]['hmid'][0]) : _RAINETTE_VALEUR_INDETERMINEE;

				$index += 1;
			}
		}
		// On stocke en fin de tableau la date de derniere mise a jour
		$tableau[$index]['derniere_maj'] = date('Y-m-d H:i:s',$date_maj);
		// trier par date
		ksort($tableau);
	}
	return $tableau;
}

function wunderground_xml2conditions($xml){
	$tableau = array();
	include_spip('inc/rainette_utils');

	// On stocke les informations disponibles dans un tableau standard
	if (isset($xml['children']['current_observation'][0]['children'])) {
		$conditions = $xml['children']['current_observation'][0]['children'];

		// Date d'observation
		$date_maj = (isset($conditions['observation_epoch'])) ? intval($conditions['observation_epoch'][0]['text']) : 0;
		$tableau['derniere_maj'] = date('Y-m-d H:i:s', $date_maj);
		// Station d'observation
		// TODO : pour l'instant le champ full n'est pas complet et a une virgule apres la ville - http://gsfn.us/t/329p4
		$tableau['station'] = (isset($conditions['observation_location']))
			? trim($conditions['observation_location'][0]['children']['full'][0]['text'], ',')
			: '';

		// Identification des suffixes d'unite pour choisir le bon champ
		// -> wunderground fournit toujours les valeurs dans les deux systemes d'unites
		include_spip('inc/config');
		$unite = lire_config('rainette/wunderground/unite');
		if ($unite == 'm')
			$suffixes = explode(':', _RAINETTE_WUNDERGROUND_SUFFIXE_METRIQUE);
		else
			$suffixes = explode(':', _RAINETTE_WUNDERGROUND_SUFFIXE_STANDARD);
		list($ut, $up, $ud, $uv) = $suffixes;


		// Liste des conditions meteo extraites dans le systeme demande
		$tableau['vitesse_vent'] = (isset($conditions['wind_'.$uv])) ? intval($conditions['wind_'.$uv][0]['text']) : '';
		$tableau['angle_vent'] = (isset($conditions['wind_degrees'])) ? intval($conditions['wind_degrees'][0]['text']) : '';
		// TODO : a confirmer suite a la reponse au post - http://gsfn.us/t/32w74
		// -> La documentation indique que les directions uniques sont fournies sous forme de texte comme North
		//    alors que les autres sont des acronymes. On passe donc tout en acronyme
		$tableau['direction_vent'] = (isset($conditions['wind_dir']))
			? (strlen($conditions['wind_dir'][0]['text']) <= 3 ? $conditions['wind_dir'][0]['text'] : strtoupper(substr($conditions['wind_dir'][0]['text'], 0, 1))) : '';

		$tableau['temperature_reelle'] = (isset($conditions['temp_'.$ut])) ? intval($conditions['temp_'.$ut][0]['text']) : '';
		$tableau['temperature_ressentie'] = (isset($conditions['feelslike_'.$ut])) ? intval($conditions['feelslike_'.$ut][0]['text']) : '';

		$tableau['humidite'] = (isset($conditions['relative_humidity'])) ? intval($conditions['relative_humidity'][0]['text']) : '';
		$tableau['point_rosee'] = (isset($conditions['dewpoint_'.$ut])) ? intval($conditions['dewpoint_'.$ut][0]['text']) : '';

		$tableau['pression'] = (isset($conditions['pressure_'.$up])) ? intval($conditions['pressure_'.$up][0]['text']) : '';
		$tableau['tendance_pression'] = (isset($conditions['pressure_trend'])) ? intval($conditions['pressure_trend'][0]['text']) : '';

		$tableau['visibilite'] = (isset($conditions['visibility_'.$ud])) ? intval($conditions['visibility_'.$ud][0]['text']) : '';

		// Code meteo, resume et icone natifs au service
		$tableau['code_meteo'] = (isset($conditions['icon'])) ? $conditions['icon'][0]['text'] : '';
		$tableau['icon_meteo'] = (isset($conditions['icon_url'])) ? $conditions['icon_url'][0]['text'] : '';
		$tableau['desc_meteo'] = (isset($conditions['weather'])) ? $conditions['weather'][0]['text'] : '';

		// Determination de l'indicateur jour/nuit qui permet de choisir le bon icone
		// Pour ce service (cas actuel) le nom du fichier icone commence par "nt_" pour la nuit.
		// TODO : prendre en compte a terme le nouvel indicateur de jour/nuit dans une prochaine version de WUI
		$icone = basename($tableau['icon_meteo']);
		if (strpos($icone, 'nt_') === false)
			$tableau['periode'] = 0; // jour
		else
			$tableau['periode'] = 1; // nuit

		// Determination, suivant le mode choisi, du code, de l'icone et du resume qui seront affiches
		$condition = lire_config('rainette/wunderground/condition');
		if ($condition == 'wunderground') {
			// On affiche les conditions natives fournies par le service
			$tableau['icone']['code'] = $tableau['code_meteo'];
			$tableau['icone']['url'] = copie_locale($tableau['icon_meteo']);
			$tableau['resume'] = ucfirst($tableau['desc_meteo']);
		}
		else {
			// On affiche les conditions traduites dans le systeme weather.com
			$meteo = wunderground_meteo2weather($tableau['code_meteo'], $tableau['periode']);
			$tableau['icone'] = $meteo;
			$tableau['resume'] = meteo2resume($meteo);
		}
	}

	return $tableau;
}

function wunderground_xml2infos($xml){
	$tableau = array();

	// On stocke les informations disponibles dans un tableau standard
	if (isset($xml['children']['location'][0]['children'])) {
		$infos = $xml['children']['location'][0]['children'];

		if (isset($infos['city'])) {
			$tableau['ville'] = $infos['city'][0]['text'];
			$tableau['ville'] .= (isset($infos['country_name'])) ? ', ' . $infos['country_name'][0]['text'] : '';
		}
		$tableau['region'] = '';

		$tableau['longitude'] = (isset($infos['lon'])) ? round(floatval($infos['lon'][0]['text']), 2) : '';
		$tableau['latitude'] = (isset($infos['lat'])) ? round(floatval($infos['lat'][0]['text']), 2) : '';

		$tableau['population'] = '';
		$tableau['zone'] = '';
	}

	return $tableau;
}

?>
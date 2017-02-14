<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/rainette/lang/
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// C
	'coucher_soleil' => 'coucher du soleil',

	// D
	'demain' => 'demain',
	'derniere_maj' => 'mise à jour',
	'description' => 'description',
	'direction_E' => 'est',
	'direction_ENE' => 'est nord-est',
	'direction_ESE' => 'est sud-est',
	'direction_N' => 'nord',
	'direction_NE' => 'nord-est',
	'direction_NNE' => 'nord nord-est',
	'direction_NNW' => 'nord nord-ouest',
	'direction_NW' => 'nord-ouest',
	'direction_S' => 'sud',
	'direction_SE' => 'sud-est',
	'direction_SSE' => 'sud sud-est',
	'direction_SSW' => 'sud sud-ouest',
	'direction_SW' => 'sud-ouest',
	'direction_V' => 'variable',
	'direction_W' => 'ouest',
	'direction_WNW' => 'ouest nord-ouest',
	'direction_WSW' => 'ouest sud-ouest',

	// E
	'erreur_affichage_modele' => 'Le modèle @modele@ n\'est pas compatible avec le service @service@.',
	'erreur_affichage_conseil' => 'Veuillez utiliser un autre modèle.',
	'erreur_chargement_conditions' => 'Le service @service@ ne fournit actuellement aucune information géographique sur le lieu @lieu@.',
	'erreur_chargement_infos' => 'Le service @service@ ne fournit actuellement aucune condition météorologique sur le lieu @lieu@.',
	'erreur_chargement_previsions' => 'Le service @service@ ne fournit actuellement aucune prévision météorologique sur le lieu @lieu@.',
	'erreur_chargement_conseil' => 'Veuillez vérifier le nom du lieu ou la disponibilité du service.',
	'erreur_jour_previsions' => 'Le service @service@ ne fournit pas de prévision météorologique pour le @date@.',
	'erreur_jour_conseil' => 'Ce service ne fournit que @max@ jours de prévisions.',

	// G
	'groupe_donnees_observation' => 'Données d\'observation',
	'groupe_donnees_astronomiques' => 'Données astronomiques',
	'groupe_donnees_temperatures' => 'Températures',
	'groupe_donnees_anemometriques' => 'Données anémométriques',
	'groupe_donnees_atmospheriques' => 'Données atmosphériques',
	'groupe_donnees_etats_natifs' => 'États météorologiques natifs',
	'groupe_donnees_etats_calcules' => 'États météorologiques calculés',
	'groupe_donnees_lieu' => 'Lieu',
	'groupe_donnees_coordonnees' => 'Coordonnées géographiques',

	// H
	'humidite' => 'humidité',

	// I
	'info_configurer_format' => 'Choisissez le format d\'échange dans lequel le service fournit les données. En général, la valeur par défaut (@defaut@) n\'a pas à être modifiée car le format ne devrait pas influer sur la valeur des données météorologiques. Néanmoins, certains services ne garantissent pas cette cohérence et il peut être intéressant de tester les deux options.',
	'info_configurer_unite' => 'Choisissez le système d\'unité dans lequel seront exprimées les données météorologiques.',
	'info_configurer_cle_obligatoire' => 'Ce service nécessite une clé d\'inscription pour être utilisé. Veuillez acquérir cette clé sur @url@ et la saisir ci-dessous.',
	'info_configurer_cle_facultative' => 'Ce service <strong>ne nécessite pas une clé d\'inscription</strong> pour être utilisé mais vous pouvez en préciser une comme le recommande le fournisseur. Si vous le decidez, veuillez acquérir cette clé sur @url@ et la saisir ci-dessous.',
	'info_configurer_cle_aucune' => 'Ce service ne nécessite aucune clé d\'inscription pour être utilisé.',
	'info_configurer_condition' => 'Choisissez le mode d\'affichage du résumé et de l\'icone représentatifs d\'une condition météorologique donnée.',
	'info_utilisation_rainette' => 'Les modèles d\'affichage fournis par Rainette suivent les règles d\'usage de chaque service. Si vous créez vos propres modèles veillez également à les respecter.',
	'info_utilisation_weather' => 'Le service fournit gratuitement les données météorologiques. Il est demandé de créditer le service avec un lien vers le site web et le logo du service.',
	'info_utilisation_owm' => 'Le service fournit gratuitement les données météorologiques sous licence CC-BY-SA 2.0 pour une utilisation commerciale ou pas. Il est demandé de créditer le service avec un lien vers le site web. Pour consulter les termes exacts d\'utilisation veuillez vous rendre sur la page <a href="http://openweathermap.org/copyright">Terms and Conditions</a>.',
	'info_utilisation_wwo' => 'Le service fournit gratuitement les données météorologiques pour une utilisation commerciale ou pas. Il est demandé de créditer le service avec un lien vers le site web. Pour consulter les termes exacts d\'utilisation veuillez vous rendre sur la page <a href="http://developer.worldweatheronline.com/api_terms_and_conditions">API Terms and Conditions</a>.',
	'info_utilisation_wunderground' => 'Le service fournit gratuitement les données météorologiques. Il est demandé de créditer le service avec le nom et le logo du service. Pour consulter les termes exacts d\'utilisation veuillez vous rendre sur la page <a href="http://www.wunderground.com/weather/api/d/terms.html">Weather API Terms of Service</a>.',
	'info_utilisation_yahoo' => 'Le service fournit gratuitement les données météorologiques pour les usages personnel et à but non lucratif. Il est demandé de créditer le service avec le nom du service ou le logo. Pour consulter les termes exacts d\'utilisation veuillez vous rendre sur la page <a href="http://developer.yahoo.com/weather/#terms">Terms of Use</a>.',
	'info_configurer_theme' => 'Choisissez le thème d\'icônes utilisé dans les affichages.',
	'info_page_configurer' => 'Rainette propose une configuration pour chacun des services de météorologie intégré au plugin. Néanmoins, seuls les services utilisés dans votre site nécessitent d\'être configurés.',
	'info_credits' => 'Données fournies par @service@',

	// I
	'indice_uv' => 'Indice UV',

	// J
	'jour' => 'jour',

	// L
	'latitude' => 'latitude',
	'lever_soleil' => 'lever du soleil',
	'lieu' => 'lieu',
	'longitude' => 'longitude',
	'label_theme' => 'Thème d\'icônes',
	'label_theme_wunderground_a' => 'Default',
	'label_theme_wunderground_b' => 'Smiley',
	'label_theme_wunderground_c' => 'Generic',
	'label_theme_wunderground_d' => 'Old school',
	'label_theme_wunderground_e' => 'Cartoon',
	'label_theme_wunderground_f' => 'Clip art',
	'label_theme_wunderground_g' => 'Simple',
	'label_theme_wunderground_h' => 'Comtemporary',
	'label_theme_wunderground_i' => 'Minimalist',
	'label_theme_wunderground_k' => 'Incredible',
	'label_unite' => 'Système d\'unité',
	'label_unite_metrique' => 'Système métrique',
	'label_unite_standard' => 'Système impérial',
	'label_cle' => 'Clé d\'inscription',
	'label_condition' => 'Conditions météorologiques',
	'label_condition_native' => 'Utilisation du résumé et de l\'icone fourni par ce service',
	'label_condition_weather' => 'Utilisation du résumé et de l\'icone du service Weather.com (nécessite une conversion approximative de la condition)',
	'label_format' => 'Format d\'échange',
	'label_format_xml' => 'XML',
	'label_format_json' => 'JSON',
	'legende_configurer_affichage' => 'Affichages des données',
	'legende_configurer_format' => 'Récupération des données',
	'legende_configurer_inscription' => 'Enregistrement',
	'legende_configurer_utilisation' => 'Conditions d\'utilisation',

	// M
	'meteo' => 'météo',
	'meteo_0' => 'tornade',
	'meteo_1' => 'tempête tropicale',
	'meteo_10' => 'pluie verglaçante',
	'meteo_11' => 'averses',
	'meteo_12' => 'averses',
	'meteo_13' => 'quelques flocons',
	'meteo_14' => 'faibles averses de neige',
	'meteo_15' => 'blizzard',
	'meteo_16' => 'neige',
	'meteo_17' => 'grêle',
	'meteo_18' => 'neige fondue',
	'meteo_19' => 'poussière',
	'meteo_2' => 'ouragan',
	'meteo_20' => 'brumeux',
	'meteo_21' => 'brume',
	'meteo_22' => 'brouillard',
	'meteo_23' => 'bourasques',
	'meteo_24' => 'vent',
	'meteo_25' => 'froid',
	'meteo_26' => 'nuageux',
	'meteo_27' => 'clair de lune très nuageux',
	'meteo_28' => 'très nuageux',
	'meteo_29' => 'clair de lune et nuages épars',
	'meteo_3' => 'orage violent',
	'meteo_30' => 'soleil et nuages épars',
	'meteo_31' => 'clair de lune',
	'meteo_32' => 'soleil',
	'meteo_33' => 'clair de lune voilé',
	'meteo_34' => 'soleil voilé',
	'meteo_35' => 'pluie et grêle mélée',
	'meteo_36' => 'chaleur',
	'meteo_37' => 'orages isolés',
	'meteo_38' => 'orage épars',
	'meteo_39' => 'orage épars',
	'meteo_4' => 'orage',
	'meteo_40' => 'averses éparses',
	'meteo_41' => 'fortes chutes de neige',
	'meteo_42' => 'averses de neige éparses',
	'meteo_43' => 'forte chute de neige',
	'meteo_44' => 'ensoleillé',
	'meteo_45' => 'averses orageuses',
	'meteo_46' => 'averses de neige',
	'meteo_47' => 'orages isolés',
	'meteo_5' => 'pluie et neige mélée',
	'meteo_6' => 'pluie et verglas',
	'meteo_7' => 'neige et verglas',
	'meteo_8' => 'bruine verglaçante',
	'meteo_9' => 'bruine',
	'meteo_conditions' => 'conditions météorologiques actuelles',
	'meteo_consultation' => 'Consultez la météo de @ville@',
	'meteo_de' => 'Météo de @ville@',
	'meteo_na' => 'N/D',
	'meteo_previsions' => 'prévisions météorologiques',
	'meteo_previsions_aujourdhui' => 'prévisions météorologiques pour aujourd\'hui',
	'meteo_previsions_n_jours' => 'prévisions météorologiques à @nbj@ jours',

	'meteo_395' => 'Neige Lourde',
	'meteo_392' => 'Tempête',
	'meteo_389' => 'Orage',
	'meteo_386' => 'Tempête',
	'meteo_377' => 'Pluie avec grêle',
	'meteo_374' => 'Pluie légère avec grêle',
	'meteo_371' => 'Neige lourde',
	'meteo_368' => 'Neige légère',
	'meteo_365' => 'Grésils lourds',
	'meteo_362' => 'Grésils légers',
	'meteo_359' => 'Pluie torrentielle',
	'meteo_356' => 'Averses',
	'meteo_353' => 'Légère pluie',
	'meteo_350' => 'Grêle',
	'meteo_338' => 'Neige lourde',
	'meteo_335' => 'Neige lourde et éparse',
	'meteo_332' => 'Neige modérée',
	'meteo_329' => 'Neige modérée et éparse',
	'meteo_326' => 'Neige légère',
	'meteo_323' => 'Neige légère et éparse',
	'meteo_320' => 'Grêle lourde',
	'meteo_317' => 'Grêle légère',
	'meteo_314' => 'Froid',
	'meteo_311' => 'Froid léger',
	'meteo_308' => 'Pluie torrentielle',
	'meteo_305' => 'Pluie torrentielle intermittente',
	'meteo_302' => 'Pluie modérée',
	'meteo_299' => 'Pluie modérée intermittente',
	'meteo_296' => 'Pluie légère',
	'meteo_293' => 'Pluie légère et éparse',
	'meteo_284' => 'Bruine gelée',
	'meteo_281' => 'Bruine froide',
	'meteo_266' => 'Bruine légère',
	'meteo_263' => 'Bruine légère et éparse',
	'meteo_260' => 'Brouillard et froid',
	'meteo_248' => 'Brouillard           ',
	'meteo_230' => 'Tempête de neige',
	'meteo_227' => 'Neige et vent',
	'meteo_200' => 'Orage localisé',
	'meteo_185' => 'Bruine froide et éparse',
	'meteo_182' => 'Grêle éparse',
	'meteo_179' => 'Neige éparse',
	'meteo_176' => 'Pluie éparse',
	'meteo_143' => 'Brume',
	'meteo_122' => 'Nuage épais',
	'meteo_119' => 'Nuageux',
	'meteo_116' => 'Partiellement nuageux',
	'meteo_113' => 'Ensoleillé',

	// N
	'noisette_description_conditions' => 'Affichage des conditions météorologiques pour un service donné',
	'noisette_description_previsions_24h' => 'Affichage des prévisions météorologiques 24h pour un service donné',
	'noisette_explication_lieu' => 'Suivant le service, le lieu peut être exprimé comme une ville suivie par le code ISO d\'un pays, comme des coordonnées géographiques, comme une adresse IP ou comme un identifiant weather.com&reg;.
	Consultez la documentation pour connaitre la compatibilité avec le service choisi.',
	'noisette_explication_jour' => 'Le jour courant correspond à la valeur 0 et ainsi de suite. Consultez la documentation pour connaitre le nombre de jours de prévisions fournis pour chaque service.',
	'noisette_titre_conditions' => 'Conditions météorologiques',
	'noisette_titre_previsions_24h' => 'Prévisions météorologiques 24h',
	'noisette_label_jour_1' => 'Premier jour des prévisions',
	'noisette_label_nb_jours' => 'Nombre de jours affichés',
	'noisette_label_lieu' => 'Lieu',
	'noisette_label_service' => 'Service météorologique utilisé',
	'noisette_label_titre_conditions' => 'Afficher un titre pour les conditions ?',
	'noisette_label_titre_previsions' => 'Afficher un titre pour les prévisions ?',
	'noisette_label_modele' => 'Modèle d\'affichage à utiliser',
	'nuit' => 'nuit',

	// P
	'point_rosee' => 'point de rosée',
	'population' => 'population',
	'precipitation' => 'précipitations',
	'pression' => 'pression',

	// R
	'region' => 'région',
	'risque_precipitation' => 'risque de précip.',

	// S
	'station_observation' => 'station',

	// T
	'temperature_max' => 'max',
	'temperature_min' => 'min',
	'temperature_ressentie' => 'ressentie',
	'tendance_symbole_falling_rapidly' => '⇊',
	'tendance_symbole_falling' => '↓',
	'tendance_symbole_rising' => '↑',
	'tendance_symbole_steady' => '→',
	'tendance_texte_falling_rapidly' => 'en chute',
	'tendance_texte_falling' => 'en baisse',
	'tendance_texte_rising' => 'en hausse',
	'tendance_texte_steady' => 'stable',
	'titre_service_owm' => 'Open Weather Map',
	'titre_service_weather' => 'weather.com&reg;',
	'titre_service_wwo' => 'World Weather Online',
	'titre_service_wunderground' => 'Weather Underground',
	'titre_page_configurer' => 'Configuration du plugin Rainette',

	// U
	'unite_angle_metrique' => '°',
	'unite_angle_standard' => '°',
	'unite_distance_metrique' => 'km',
	'unite_distance_standard' => 'miles',
	'unite_pourcentage_metrique' => '%',
	'unite_pourcentage_standard' => '%',
	'unite_precipitation_metrique' => 'mm',
	'unite_precipitation_standard' => 'pouces',
	'unite_pression_metrique' => 'mbar',
	'unite_pression_standard' => 'pouces',
	'unite_temperature_metrique' => '°C',
	'unite_temperature_standard' => '°F',
	'unite_vitesse_metrique' => 'km/h',
	'unite_vitesse_standard' => 'mph',
	'unite_population' => 'habitants',

	// V
	'valeur_indeterminee' => 'N/D',
	'vent' => 'vent',
	'visibilite' => 'visibilité',

	// Z
);

?>

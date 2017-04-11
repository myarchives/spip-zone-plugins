<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de https://trad.spip.net/tradlang_module/gis?lang_cible=nl
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucun_gis' => 'Geen enkel punt',
	'aucun_objet' => 'Geen object',

	// B
	'bouton_annuler_title' => 'Stop en verwijder alle aanpassing.',
	'bouton_enregistrer_title' => 'Sla je aanpassingen op.',
	'bouton_lier' => 'Koppel dit punt',
	'bouton_supprimer_gis' => 'Verwijder dit punt permanent',
	'bouton_supprimer_lien' => 'Verwijder deze link',

	// C
	'cfg_descr_gis' => 'Geografisch Informatie Systeem.<br /><a href="http://www.spip-contrib.net/4189" class="spip_out">Naar de documentatie</a>.', # MODIF
	'cfg_inf_adresse' => 'Toon extra addresvelden (land, stad, staat, adres ...)',
	'cfg_inf_bing' => 'De Bing Aerial layer heeft een sleutel nodig die je kunt aanmaken op <a href=\'@url@\' class="spip_out">de Bing website</a>.',
	'cfg_inf_geocoder' => 'Maak geocoder functies mogelijk (adres zoeken, adres vinden aan de hand van coördinaten).',
	'cfg_inf_geolocaliser_user_html5' => 'Als de browser het toestaat, wordt de geografische locatie gebruikt als default positie bij het aanmaken van een nieuw punt.',
	'cfg_inf_google' => 'Deze API heeft een sleutel nodig die je kunt aanmaken op <a href=\'@url@\' class="spip_out">de Google Maps website</a>.',
	'cfg_inf_styles' => 'Toon de aanvullend stijlvelden (kleur, opaciteit, dikte...)',
	'cfg_lbl_activer_objets' => 'Maak geotagging mogelijk van inhoud:',
	'cfg_lbl_adresse' => 'Toon adresvelden',
	'cfg_lbl_api' => 'Geolocatie API',
	'cfg_lbl_api_key_bing' => 'Bing key',
	'cfg_lbl_api_key_google' => 'GoogleMaps API key',
	'cfg_lbl_api_microsoft' => 'Microsoft Bing',
	'cfg_lbl_geocoder' => 'Geocoder',
	'cfg_lbl_geolocaliser_user_html5' => 'Centreer de map op de locatie van de gebruiker tijdens het aanmaken',
	'cfg_lbl_layer_defaut' => 'Standaard layer',
	'cfg_lbl_layers' => 'Voorgestelde layers',
	'cfg_lbl_maptype' => 'Basiskaart',
	'cfg_lbl_styles' => 'Toon de stijlvelden',
	'cfg_titre_gis' => 'Configuratie van GIS',

	// E
	'editer_gis_editer' => 'Pas dit punt aan',
	'editer_gis_nouveau' => 'Maak een nieuw punt',
	'editer_gis_titre' => 'Locatiepunten',
	'erreur_geocoder' => 'Geen resultaat voor de zoekopdracht',
	'erreur_recherche_pas_resultats' => 'Geen enkel punt correspondeert met de gezochte tekst.',
	'erreur_xmlrpc_lat_lon' => 'Latitude en longitude moeten worden ingevuld',
	'explication_api_forcee' => 'Dit is vereist door een andere plugin or een ander model.',
	'explication_color' => 'Kleur van de streep in CSS-formaat (standaardwaarde: #0033FF)',
	'explication_fillcolor' => 'Opvulkleur in CSS-formaat (standaardwaarde: die van de streep)',
	'explication_fillopacity' => 'Opaciteit van de opvulling tussen 0 en 1 (standaardwaarde: 0.2)',
	'explication_import' => 'Importeer een bestand in GPX of KML formaat.',
	'explication_layer_forcee' => 'De layer is vereist door een andere plugin of een ander model.',
	'explication_maptype_force' => 'De basiskaart is vereist door een andere plugin of een ander model.',
	'explication_opacity' => 'Opaciteit van de streep tussen 0 en 1 (standaardwaarde: 0.5)',
	'explication_weight' => 'Streepdikte (standaardwaarde: 5)',

	// F
	'formulaire_creer_gis' => 'Maak een nieuw locatiepunt:',
	'formulaire_modifier_gis' => 'Pas het locatiepunt aan:',

	// G
	'gis_pluriel' => 'Locatiepunten',
	'gis_singulier' => 'Locatiepunt',

	// I
	'icone_gis_tous' => 'Locatiepunten',
	'info_1_gis' => 'Een locatiepunt',
	'info_1_objet_gis' => '1 object gekoppeld aan dat punt',
	'info_aucun_gis' => 'Geen locatie punt',
	'info_aucun_objet_gis' => 'Geen object gekoppeld aan dat punt',
	'info_geolocalisation' => 'Geolocatie',
	'info_id_objet' => 'Nr',
	'info_liste_gis' => 'Locatiepunten',
	'info_nb_gis' => '@nb@ location-based punts',
	'info_nb_objets_gis' => '@nb@ objecten gekoppeld aan dat punt',
	'info_numero_gis' => 'Punt nummer',
	'info_objet' => 'Object',
	'info_recherche_gis_zero' => 'Geen resultaat voor « @cherche_gis@ ».',
	'info_supprimer_lien' => 'Ontkoppel',
	'info_supprimer_liens' => 'Ontkoppel alle punten',
	'info_voir_fiche_objet' => 'Ga naar bladzijde',

	// L
	'label_adress' => 'Adres',
	'label_code_pays' => 'Landcode',
	'label_code_postal' => 'Postcode',
	'label_color' => 'Kleur',
	'label_departement' => 'Departement',
	'label_fillcolor' => 'Opvulkleur',
	'label_fillopacity' => 'Opaciteit van de opvulling',
	'label_import' => 'Importeer',
	'label_inserer_modele_articles' => 'gekoppeld aan artikelen',
	'label_inserer_modele_articles_sites' => 'gekoppeld aan artikelen + websites',
	'label_inserer_modele_auteurs' => 'gekoppeld aan auteurs',
	'label_inserer_modele_centrer_auto' => 'Geen automatische centrering',
	'label_inserer_modele_centrer_fichier' => 'Centreer de kaart niet op KLM/GPX bestanden',
	'label_inserer_modele_controle' => 'Verberg bedieningsknoppen',
	'label_inserer_modele_controle_type' => 'Verberg types',
	'label_inserer_modele_description' => 'Omschrijving',
	'label_inserer_modele_documents' => 'gekoppeld aan documenten',
	'label_inserer_modele_echelle' => 'Schaal',
	'label_inserer_modele_fullscreen' => 'Knop volledig scherm',
	'label_inserer_modele_gpx' => 'GPX bestand naar overlay',
	'label_inserer_modele_hauteur_carte' => 'Kaarthoogte',
	'label_inserer_modele_identifiant' => 'ID',
	'label_inserer_modele_identifiant_opt' => 'ID (optioneel)',
	'label_inserer_modele_identifiant_placeholder' => 'id_gis',
	'label_inserer_modele_kml' => 'KML bestanden naar overlay',
	'label_inserer_modele_kml_gpx' => 'id_document of url',
	'label_inserer_modele_largeur_carte' => 'Kaartbreedte',
	'label_inserer_modele_limite' => 'Maximum aantal punten',
	'label_inserer_modele_localiser_visiteur' => 'Centreer op lokatie bezoeker',
	'label_inserer_modele_mini_carte' => 'Mini situatiekaart',
	'label_inserer_modele_molette' => 'Schakel het scroll-wiel uit',
	'label_inserer_modele_mots' => 'Gekoppeld aan woorden',
	'label_inserer_modele_objets' => 'Categorie van punt(en)',
	'label_inserer_modele_point_gis' => 'enkel punt geregistreerd',
	'label_inserer_modele_point_libre' => 'enkel vrij punt',
	'label_inserer_modele_points' => 'Verberg punten',
	'label_inserer_modele_rubriques' => 'gekoppeld aan rubrieken',
	'label_inserer_modele_sites' => 'gekoppeld aan websites',
	'label_inserer_modele_titre_carte' => 'Kaarttitel',
	'label_opacity' => 'Opaciteit',
	'label_pays' => 'Land',
	'label_rechercher_address' => 'Zoek een adres',
	'label_rechercher_point' => 'Zoek een punt',
	'label_region' => 'Regio',
	'label_ville' => 'Stad',
	'label_weight' => 'Dikte',
	'lat' => 'Breedtegraad',
	'libelle_logo_gis' => 'LOGO VAN HET PUNT',
	'lien_ajouter_gis' => 'Voeg dit punt toe',
	'lon' => 'Lengtegraad',

	// P
	'placeholder_geocoder' => 'Een adres, een plaats, een land, een toeristische plek...',

	// T
	'telecharger_gis' => 'Download in @format@ formaat',
	'texte_ajouter_gis' => 'Voeg een locatiepunt toe',
	'texte_creer_associer_gis' => 'Maak en link een locatiepunt',
	'texte_creer_gis' => 'Maak een locatiepunt',
	'texte_modifier_gis' => 'Pas het locatiepunt aan',
	'texte_voir_gis' => 'Toon het locatiepunt',
	'titre_bloc_creer_point' => 'Koppel een nieuw punt',
	'titre_bloc_points_lies' => 'Gekoppelde punten',
	'titre_bloc_rechercher_point' => 'Zoek een punt',
	'titre_nombre_utilisation' => 'Eén toepassing',
	'titre_nombre_utilisations' => '@nb@ toepassingen',
	'titre_nouveau_point' => 'Nieuw punt',
	'titre_objet' => 'Titel',
	'toolbar_actions_title' => 'Annuleer de tekening',
	'toolbar_buttons_circle' => 'Teken een circel',
	'toolbar_buttons_marker' => 'Plot een punt',
	'toolbar_buttons_polygon' => 'Teken een polygoon',
	'toolbar_buttons_polyline' => 'Teken een lijn',
	'toolbar_buttons_rectangle' => 'Teken een rechthoek',
	'toolbar_edit_buttons_edit' => 'Pas het object aan',
	'toolbar_edit_buttons_editdisabled' => 'Geen aanpasbaar object',
	'toolbar_edit_buttons_remove' => 'Een object verwijderen',
	'toolbar_edit_buttons_removedisabled' => 'Geen te verwijderen object',
	'toolbar_edit_handlers_edit_tooltip_subtext' => 'Klik op annuleren om de aanpassingen ongedaan te maken',
	'toolbar_edit_handlers_edit_tooltip_text' => 'Verplaats de markeringen om het object aan te passen.',
	'toolbar_edit_handlers_remove_tooltip_text' => 'Klik op een object om het te verwijderen',
	'toolbar_handlers_marker_tooltip_start' => 'Klik om de marker in te stellen',
	'toolbar_handlers_polygon_tooltip_cont' => 'Klik om de polygoon verder te tekenen',
	'toolbar_handlers_polygon_tooltip_end' => 'Klik op het eerste punt om de polygoon te sluiten',
	'toolbar_handlers_polygon_tooltip_start' => 'Klik om een polygoon te gaan tekenen',
	'toolbar_handlers_polyline_tooltip_cont' => 'Klik om de lijn verder te tekenen',
	'toolbar_handlers_polyline_tooltip_end' => 'Klik het laatste punt voor het einde van de lijn',
	'toolbar_handlers_polyline_tooltip_start' => 'Klik om een lijn te gaan tekenen',
	'toolbar_handlers_rectangle_tooltip_start' => 'Klik en verplaats om een rechthoek te tekenen',
	'toolbar_handlers_simpleshape_tooltip_end' => 'Laat de muisknop los om het ontwerp te beëindigen',
	'toolbar_undo_text' => 'Wis het laatste punt',
	'toolbar_undo_title' => 'Wis het laatst uitgestippelde punt',

	// Z
	'zoom' => 'Zoom'
);

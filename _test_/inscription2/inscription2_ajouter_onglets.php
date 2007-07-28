<?php

// Ajoute le bouton d'amin aux webmestres

if (!defined("_ECRIRE_INC_VERSION")) return;

function Inscription2_ajouter_onglets($flux) {
	if ($flux['args'] == 'configuration') {
		// on voit le bouton dans la barre "configurer"
		$flux['data']['cfg_inscription2'] =
			new Bouton(
			"../"._DIR_PLUGIN_INSCRIPTION2."images/inscription2_icone.png",  
			_T('inscription2:icone_menu_config'),	
			generer_url_ecrire('cfg', 'cfg=inscription2'),
			NULL,
			'cfg_inscription2'
			);
	}
	return $flux;
}

function Inscription2_ajouter_boutons($boutons_admin){

	if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]) {

		$boutons_admin['auteurs']->sousmenu['inscription2_adherents']= new Bouton(
		"../"._DIR_PLUGIN_INSCRIPTION2."images/inscription2_icone.png", // icone
		_T("inscription2:adherents") //titre
		);
	}
	return $boutons_admin;
}

function Inscription2_affiche_milieu($flux){
	if ($GLOBALS['spip_version_code']<=1.9256){
		switch($flux['args']['exec']) {	
		case 'auteur_infos':
		case 'auteurs_edit':
			include_spip('inc/inscription2_fiche_adherent');
				$id_auteur = $flux['args']['id_auteur'];
				$flux['data'] .= inscription2_fiche_adherent($id_auteur);
				break;
			default:
				break;
		}
	}
	else{
	switch($flux['args']['exec']) {	
			case 'auteur_infos':
				include_spip('inc/inscription2_gestion');
				$id_auteur = $flux['args']['id_auteur'];
				$flux['data'] .= inscription2_ajouts($id_auteur);
				break;
			case 'auteurs_edit':
				include_spip('inc/inscription2_fiche_adherent');
				$id_auteur = $flux['args']['id_auteur'];
				$flux['data'] .= inscription2_fiche_adherent($id_auteur);
				break;
			default:
				break;
		}
	
	}
	return $flux;
}

function inscription2_affichage_final($page){

    // regarder si la page contient le formulaire inscription2
    if (!strpos($page, 'id="inscription"'))
        return $page;

	$page = inscription2_preparer_page($page);
    return $page;
}

function inscription2_preparer_page($page) {

	$css = find_in_path('css/inscription2_forms.css');
	$jqueryvalidate = find_in_path('javascript/jquery.validate.js');

    $incHead = <<<EOS
<script type='text/javascript' src='$jqueryvalidate'></script>
<link rel="stylesheet" href="$css" type="text/css" media="all" />
EOS;
	return substr_replace($page, $incHead, strpos($page, '</head>'), 0);

}

function Inscription2_header_prive($texte){
	global $auteur_session, $spip_display, $spip_lang;
	$couleurs = charger_fonction('couleurs', 'inc');
	$paramcss = 'ltr='. $GLOBALS['spip_lang_left'] . '&'. $couleurs($auteur_session['prefs']['couleur']);
	$css = generer_url_public('jquery.tabs_prive', $paramcss);
	$js = find_in_path('javascript/jquery.tabs.pack.js');
	
    $texte .= "<link rel='stylesheet' type='text/css' href='$css' /> <script type='text/javascript' src='$js'>";
	return $texte;
}
				
?>
<?
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('exec/inc_boites_infos');

function exec_jeux_gerer_resultats(){
	// les boutons ... le pire ennemi des ados parait-il
	$supprimer_tout = _request('supprimer_tout');
	$supprimer_confirmer = _request('supprimer_confirmer');
	
	($supprimer_confirmer) ? $bouton = 'supprimer_confirmer' : $bouton = '';
	($bouton == '' and $supprimer_tout) ? $bouton = 'supprimer_tout' : $bouton = $bouton;
	
	$id_jeu 	= _request('id_jeu');
	$id_auteur  = _request('id_auteur');
//	$tous = _request('tous');

	if ($id_jeu) { gerer_resultat_jeux($id_jeu,$bouton); return; }
	if ($id_auteur) { gerer_resultats_auteur($id_auteur,$bouton); return; }
	
	//if ($tous == 'oui')
	gerer_resultat_tous($bouton);
}

function gerer_resultat_tous($bouton){
	
	if ($bouton == 'supprimer_confirmer'){
		include_spip('base/jeux_supprimer');
		jeux_supprimer_tout_tout();
		include_spip('inc/headers');
		redirige_par_entete(generer_url_ecrire('jeux_tous'));
	}

	debut_page(_T("jeux:gerer_resultats_tout"));
	debut_gauche();
	
	boite_infos_accueil();
	
	creer_colonne_droite();
	debut_droite();
	if ($bouton == 'supprimer_tout') gros_titre(_T("jeux:confirmation"));
	debut_cadre_relief();
	gros_titre(_T("jeux:gerer_resultats_tout"));
	formulaire_suppression($bouton, 'tout');
	fin_cadre_relief();

	echo fin_gauche(), fin_page();
}

function gerer_resultats_auteur($id_auteur, $bouton){
	
	$requete	= spip_fetch_array(spip_query("SELECT nom FROM spip_auteurs WHERE id_auteur =".$id_auteur));
	$nom 	= $requete['nom'];
	// aïe, aïe, on efface tout
	if ($bouton == 'supprimer_confirmer'){
		include_spip('base/jeux_supprimer');
		jeux_supprimer_tout_auteur($id_auteur);
		include_spip('inc/headers');
		redirige_par_entete(generer_url_ecrire('jeux_resultats_auteur', 'id_auteur='.$id_auteur, true));
	}
	
	debut_page(_T("jeux:gerer_resultats_auteur",array('nom'=>$nom)));
			
	debut_gauche();
	
	boite_infos_auteur($id_auteur, $nom);
	boite_infos_accueil();
	
	creer_colonne_droite();
	debut_droite();
	if ($bouton == 'supprimer_tout') gros_titre(_T("jeux:confirmation"));
	debut_cadre_relief();
	gros_titre(_T("jeux:gerer_resultats_auteur",array('nom'=>$nom)));
	formulaire_suppression($bouton, 'auteur');

	fin_cadre_relief();

	echo fin_gauche(), fin_page();
}




function gerer_resultat_jeux($id_jeu, $bouton){
	// determination du bouton enclencher
	
	$requete	= spip_fetch_array(spip_query("SELECT id_jeu,nom FROM spip_jeux WHERE id_jeu =".$id_jeu));
	$id_jeu		= $requete['id_jeu'];
	$nom		= $requete['nom'];
	if(!$id_jeu){
		debut_page(_T("jeux:pas_de_jeu"));
		gros_titre(_T("jeux:pas_de_jeu"));
		fin_page();
		return;
	}
	// aïe, aïe, on efface tout
	if ($bouton == 'supprimer_confirmer'){
		include_spip('base/jeux_supprimer');
		jeux_supprimer_tout_jeu($id_jeu);
		include_spip('inc/headers');
		redirige_par_entete(generer_url_ecrire('jeux_resultats_jeu', 'id_jeu='.$id_jeu, true));
	}

	debut_page(_T("jeux:gerer_resultats_jeu",array('id'=>$id_jeu,'nom'=>$nom)));
			
	debut_gauche();
	
	boite_infos_jeu($id_jeu, $nom);
	boite_infos_accueil();

	creer_colonne_droite();
	debut_droite();
	if ($bouton == 'supprimer_tout') gros_titre(_T("jeux:confirmation"));
	debut_cadre_relief();
	
	echo gros_titre(_T("jeux:gerer_resultats_jeu",array('id'=>$id_jeu,'nom'=>$nom)));
	formulaire_suppression($bouton, 'jeu'); 
	
	fin_cadre_relief();
	echo fin_gauche(), fin_page();
}

function formulaire_suppression($bouton, $type){
	debut_cadre_formulaire();
	echo "<form method='post'  name='supprimer_resultat'>";
	debut_cadre_relief();	

	if ($bouton == 'supprimer_tout'){
		$res = "<br/><input type='submit' name='supprimer_confirmer' value='"._T('jeux:supprimer_confirmer')."' class='fondo' />";
		echo
			_T('jeux:confirmation_supprimer_'.$type),
			"\n<div style='text-align: center'>",
			debut_boite_alerte(),
			"\n<div class='serif'>",
			"\n<b>"._T('avis_suppression_base')."&nbsp;!</b>",
			"\n</div>",
			$res,
			fin_boite_alerte(),
			"</div>";
	} else {
		$res = "<br/><input type='submit' name='supprimer_tout' value='"._T('jeux:supprimer_tout_'.$type)."' class='fondo' />";
		echo
			_T('jeux:explication_supprimer_'.$type),
			"\n<div style='text-align: center'>",
			debut_boite_alerte(),
			"\n<div class='serif'>",
			"\n<b>"._T('avis_suppression_base')."&nbsp;!</b>",
			"\n</div>",
			$res,
			fin_boite_alerte(),
			"</div>";
	}

	fin_cadre_relief();
	echo "</form>";
	
	fin_cadre_formulaire();
}

?>
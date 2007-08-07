<?
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');

function exec_jeux_tous(){
	$par = _request('par');
	($par =='') ? $par='date' : $par = $par;
	
	debut_page(_T("jeux:jeux_tous"));
			
	debut_gauche();
	
	
	debut_boite_info();
	echo icone_horizontale(_T('jeux:nouveau_jeu'),generer_url_ecrire('jeux_edit','nouveau=oui'),find_in_path('img/jeu-nouveau.png'));
	if (function_exists('lire_config')) 
		echo icone_horizontale(_T('jeux:configurer_jeux'),generer_url_ecrire('cfg','cfg=jeux'),find_in_path('img/jeu-cfg.png'));
	echo icone_horizontale(_T('jeux:gerer_resultats'),generer_url_ecrire('jeux_gerer_resultats','tous=oui'),find_in_path('img/jeu-laurier.png'));
	fin_boite_info();
	
	
	creer_colonne_droite();
	debut_droite();
	debut_cadre_relief();
	
	echo gros_titre(_T("jeux:jeux_tous"));
	
	include_spip('public/assembler');
	debut_cadre('liste');
	echo recuperer_fond('fonds/jeux_tous', array('par'=>$par));
	fin_cadre();
	
	fin_cadre_relief();
	fin_gauche();
	fin_page();
	}


?>
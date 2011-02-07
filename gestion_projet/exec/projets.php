<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('public/assembler');

function exec_projets_dist(){
	$contexte = Array();
	$contexte = calculer_contexte();
	
	// si pas autorise : message d'erreur
	if (!autoriser('modifier', 'article')) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}
	
	// pipeline d'initialisation
	pipeline('exec_init', array('args'=>array('exec'=>'projets'),'data'=>''));
	// entetes
	$commencer_page = charger_fonction('commencer_page', 'inc');


	// titre, partie, sous_partie (pour le menu)
	echo $commencer_page(_T('gestpro:projets'), "editer", "editer");
	
	
	// colonne gauche
	echo debut_gauche('', true);
	echo debut_boite_info(true);
	echo '<div class="infos">';
	echo '<h2 style="text-align:center;">'._T('gestpro:projet').'</h2>';
	echo	'</div>';
	echo fin_boite_info(true);
	
					
	echo pipeline('affiche_gauche', array('args'=>array('exec'=>'projets'),'data'=>''));	
	

	// colonne droite
	echo creer_colonne_droite('', true);
	echo pipeline('affiche_droite', array('args'=>array('exec'=>'projets'),'data'=>''));
	
	// centre
	echo debut_droite('', true);
	// contenu
	// ...

	echo recuperer_fond('prive/contenu/projets',$contexte,Array("ajax"=>true));

	// ...
	// fin contenu
	echo pipeline('affiche_milieu', array('args'=>array('exec'=>'boutique'),'data'=>''));
	
	echo fin_gauche(), fin_page();

}
?>

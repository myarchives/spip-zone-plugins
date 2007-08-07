<?
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('exec/inc_boites_infos');

function exec_jeux_resultats_jeu(){
	$id_jeu 	= _request('id_jeu');
	$par = _request('par');
	($par == '') ? $par='resultat_court' : $par = $par;
	
	$requete	= spip_fetch_array(spip_query("SELECT id_jeu,nom,titre FROM spip_jeux WHERE id_jeu =".$id_jeu));
	$id_jeu		= $requete['id_jeu'];
	$nom		= $requete['nom'];
	$titre		= $requete['titre'];
	if(!$id_jeu){
		debut_page(_T("jeux:pas_de_jeu"));
		gros_titre(_T("jeux:pas_de_jeu"));
		fin_page();
		return;
		}
	debut_page(_T("jeux:resultats_jeu",array('id'=>$id_jeu,'nom'=>$nom)));
			
	debut_gauche();
	
	boite_infos_jeu($id_jeu, $nom);
	boite_infos_accueil();
	
	creer_colonne_droite();
	debut_droite();
	debut_cadre_relief();
	
	echo gros_titre(_T("jeux:resultats_jeu", array('id'=>$id_jeu,'nom'=>$nom)));
	$titre = $titre==''?_T('jeux:sans_titre'):propre($titre);
	echo "<div style='font-weight:bold'>$titre</div><br />";
	echo "<div class='nettoyeur'></div>";
	include_spip('public/assembler');
	debut_cadre('liste');
	echo recuperer_fond('fonds/resultats_jeu_detail', array('id_jeu'=>$id_jeu,'par'=>$par));
	fin_cadre();
	
	fin_cadre_relief();
	fin_gauche();
	fin_page();
	}


?>
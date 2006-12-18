<?php
#---------------------------------------------------#
#  Plugin  : Tweak SPIP                             #
#  Auteur  : Patrice Vanneufville, 2006             #
#  Contact : patrice�.!vanneufville�@!laposte�.!net #
#  Licence : GPL                                    #
#---------------------------------------------------#

include_spip('inc/texte');
include_spip('inc/layer');

$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
define('_DIR_PLUGIN_TWEAK_SPIP',(_DIR_PLUGINS.end($p)));

function tweak_styles() {
	global $couleur_claire;
	echo "<style type='text/css'>\n";
	echo <<<EOF
div.cadre-padding ul li {
	list-style:none ;
}
div.cadre-padding ul {
	padding-left:1em;
	margin:.5em 0 .5em 0;
}
div.cadre-padding ul ul {
	border-left:5px solid #DFDFDF;
}
div.cadre-padding ul li li {
	margin:0;
	padding:0 0 0.25em 0;
}
div.cadre-padding ul li li div.nomplugin, div.cadre-padding ul li li div.nomplugin_on {
	border:1px solid #AFAFAF;
	padding:.3em .3em .6em .3em;
	font-weight:normal;
}
div.cadre-padding ul li li div.nomplugin a, div.cadre-padding ul li li div.nomplugin_on a {
	outline:0;
	outline:0 !important;
	-moz-outline:0 !important;
}
div.cadre-padding ul li li div.nomplugin_on {
	background:$couleur_claire;
	font-weight:bold;
}
div.cadre-padding div.droite label {
	padding:.3em;
	background:#EFEFEF;
	border:1px dotted #95989F !important;
	border:1px solid #95989F;
	cursor:pointer;
	margin:.2em;
	display:block;
	width:10.1em;
}
div.cadre-padding input {
	cursor:pointer;
}
div.detailplugin {
	border-top:1px solid #B5BECF;
	padding:.6em;
	background:#F5F5F5;
}
div.detailplugin hr {
	border-top:1px solid #67707F;
	border-bottom:0;
	border-left:0;
	border-right:0;
	}
EOF;
	echo "</style>";
}

function exec_tweak_spip_admin() {
  global $connect_statut, $connect_toutes_rubriques;
  global $spip_lang_right;
  global $couleur_claire;
  global $tweaks;

  include_spip('tweak_spip_config');
  include_spip("inc/presentation");
//  include_spip ("base/abstract_sql");

  if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
	debut_page(_T('icone_admin_plugin'), "configuration", "plugin");
	echo _T('avis_non_acces_page');
	fin_page();
	exit;
  }
/*
	// mise a jour des donnees si envoi via formulaire
	// sinon fait une passe de verif sur les plugin
	if (_request('changer_tweaks')=='oui'){
		enregistre_modif_plugin();
		// pour la peine, un redirige, 
		// que les plugin charges soient coherent avec la liste
//		redirige_par_entete(generer_url_ecrire('tweak_spip_admin'));
	}
	else
		verif_plugin();
	if (isset($_GET['surligne']))
		$surligne = $_GET['surligne'];
*/
  debut_page(_T('tweak:titre'), 'configuration', 'tweak_spip');
  tweak_styles();

	echo '<br><br><br>';

	gros_titre(_T('tweak:titre'));

	/*Affichage*/
	debut_gauche();	
	
	debut_boite_info();
	echo propre(_T('tweak:help'));
	fin_boite_info();

	debut_droite();

	debut_cadre_relief();

	global $couleur_foncee;
	echo "\n<table border='0' cellspacing='0' cellpadding='5' width='100%'>";
	echo "<tr><td bgcolor='$couleur_foncee' background='' colspan='4'><b>";
	echo "<font face='Verdana,Arial,Sans,sans-serif' size='3' color='#ffffff'>";
	echo _T('tweak:tweaks_liste')."</font></b></td></tr>";

	echo "<tr><td class='serif' colspan=4>";
	echo _T('tweak:texte_presente_tweaks');

	echo generer_url_post_ecrire("tweak_spip_admin");

	echo '<ul>';
	foreach($temp = $tweaks as $tweak) echo '<li>' . ligne_tweak($tweak) . "</li>\n"; 
	echo '</ul>';
	
//	echo "\n<input type='hidden' name='id_auteur' value='$connect_id_auteur' />";
//	echo "\n<input type='hidden' name='hash' value='" . calculer_action_auteur("valide_plugin") . "'>";
	echo "\n<input type='hidden' name='changer_tweaks' value='oui'>";

	echo "\n<div style='text-align:$spip_lang_right'>";
	echo "<input type='submit' name='Valider' value='"._T('bouton_valider')."' class='fondo' onclick=\"alert('� faire, si vous trouvez un moyen simple de stocker l\'�tat des tweaks !')\">";
	echo "</div>";

# ce bouton est trop laid :-)
# a refaire en javascript, qui ne fasse que "decocher" les cases
#	echo "<div style='text-align:$spip_lang_left'>";
#	echo "<input type='submit' name='desactive_tous' value='"._T('bouton_desactive_tout')."' class='fondl'>";
#	echo "</div>";

	echo "</form></td></tr></table>\n";

//  ecrire_meta('SquelettesMots:fond_pour_groupe',serialize($fonds));
//  ecrire_metas();
  
	echo fin_page();
  
}

// est-ce que $pipe est un pipeline ?
function is_tweak_pipeline($pipe) {
	global $tweak_exclude;
	return !in_array($pipe, $tweak_exclude);
}

// affiche un tweak sur une ligne
function ligne_tweak($tweak){
	static $id_input=0;
	$inc = $tweak['include'];
	$actif = $tweak['actif'];
	$puce = $actif?'puce-verte.gif':'puce-rouge.gif';
	$titre_etat = _T('tweak:'.($actif?'':'in').'actif');
	$tweak_id = $inc.$id_input;
	
	$s = "<div id='$tweak_id' class='nomplugin".($actif?'_on':'')."'>";
/*
	if (isset($info['erreur'])){
		$s .=  "<div style='background:".$GLOBALS['couleur_claire']."'>";
		$erreur = true;
		foreach($info['erreur'] as $err)
			$s .= "/!\ $err <br/>";
		$s .=  "</div>";
	}
*/
	$s .= "<img src='"._DIR_IMG_PACK."$puce' width='9' height='9' style='border:0;' alt=\"$titre_etat\" title=\"$titre_etat\" />&nbsp;";

	$s .= "<input type='checkbox' name='tweak_$inc' value='O' id='label_$id_input'";
	$s .= $actif?" checked='checked'":"";
	$s .= " onclick='verifchange.apply(this,[\"$inc\"])' /> <label for='label_$id_input' style='display:none'>"._T('tweak:activer_tweak')."</label>";

	$s .= bouton_block_invisible($tweak_id) . propre($tweak['nom']);

	$s .= "</div>";

	$s .= debut_block_invisible($tweak_id);

	$s .= "\n<div class='detailplugin'>";
	if (isset($tweak['description'])) $s .= propre($tweak['description']);
	if (isset($tweak['auteur'])) $s .= "<br/><br/>" . _T('auteur') .' '. propre($tweak['auteur']) . "<hr/>";
	$s .= _T('tweak:tweak') ." $inc.php";
	if ($tweak['options']) $s .= ' | options';
	if ($tweak['fonctions']) $s .= ' | fonctions';
	foreach ($tweak as $pipe=>$fonc) if(is_tweak_pipeline($pipe)) $s .= ' | '.$pipe;
	$s .= "</div>";

	$s .= fin_block();
	$id_input++;

	return $s;
}
?>

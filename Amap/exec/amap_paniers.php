<?php

##########################################################################
#
#           Page de configuration du plugin Amap pour SPIP
#
#
#             Site de documentation du plugin Amap
#                       http://www.dadaprod.org/amap-spip
#
#	                 2008 - Stéphane Moulinet
############################################################################

if (!defined("_ECRIRE_INC_VERSION")) return;
require_once ("base/abstract_sql.php");
include_spip('inc/presentation');
include_spip('inc/config');
include(_DIR_PLUGIN_AMAP."/inc/fonctions_panier.php");
include(_DIR_PLUGIN_AMAP."/inc/fonctions_choix.php");
include(_DIR_PLUGIN_AMAP."/inc/fonctions_famille_variete.php");
include(_DIR_PLUGIN_AMAP."/inc/fonctions_variete.php");

//=========================================================================
//=========================================================================
//
function exec_amap_paniers()
{

  global $connect_statut, $connect_toutes_rubriques, $options, $spip_lang_left, $spip_lang_right, $changer_config, $spip_display;
  global $debut, $visiteurs, $connect_id_auteur, $table_prefix;

  $table = _request('table');

  if ($connect_statut != '0minirezo') {
  //if (!( ($connect_statut == '0minirezo') || ($connect_statut == '1comite') )) {
	echo _T('avis_non_acces_page');
	echo fin_page();
	exit;
  }

  $page = preg_replace('/\W/', '', _request('page'));

  pipeline('exec_init',array('args'=>array('exec'=>'amap_paniers'),'data'=>''));

  $commencer_page = charger_fonction('commencer_page', 'inc');
  echo $commencer_page("Gestion des paniers", "paniers", "amap_paniers");

  echo "<br /><br /><br />\n";
  echo gros_titre("Gestion des paniers",'',false);
  echo barre_onglets("amap", "paniers");

  echo debut_gauche("", true);

  // Affichage du sous-menu de configuration
  debut_cadre_relief();
  echo "<b><div class='verdana2'>";
  $res = icone_horizontale("Paniers", generer_url_ecrire("amap_paniers"), _DIR_PLUGIN_AMAP."img_pack/page_accueil.png", _DIR_PLUGIN_AMAP."img_pack/rien.gif", false)
       .icone_horizontale("Familles de produits", generer_url_ecrire("amap_paniers", "table=familles"),  _DIR_PLUGIN_AMAP."img_pack/options.png",  _DIR_PLUGIN_AMAP."img_pack/rien.gif", false)
       .icone_horizontale("Vari&eacute;t&eacute;s de familles", generer_url_ecrire("amap_paniers", "table=varietes"),  _DIR_PLUGIN_AMAP."img_pack/themes.png",  _DIR_PLUGIN_AMAP."img_pack/rien.gif", false);
  echo $res . "</div>";
  fin_cadre_relief();

  echo pipeline('affiche_gauche',array('args'=>array('exec'=>'amap_paniers'),'data'=>''));
  creer_colonne_droite();
  echo pipeline('affiche_droite',array('args'=>array('exec'=>'amap_paniers'),'data'=>''));
  echo debut_droite("", true);

  // Affichage avertissement
  echo   debut_cadre_trait_couleur("", true, "", "");
  echo "<div class='verdana2' style='text-align: justify'>
        <p style='text-align: center'><b>";
  echo _T('amap:attention');
  echo  "</b></p><img src='../prive/images/warning.gif' alt='ATTENTION !' width='48' height='48' style='float: right; padding-left: 10px;' />";
  echo _T('amap:attention_modifications');
  echo "</div>";
  echo fin_cadre_trait_couleur(true);
  echo "<br />&nbsp;<br />";


  if ($table == 'familles') { // Page familles de produits
    $msg_presentation_1 = "Liste des familles de produits ";
    $msg_presentation_2 = "Enregistrement d'une nouvelle famille de produits ";

    // CHOIX DE L'ACTION A REALISER => de l'affichage

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      // la page est arrivée en POST
      switch ($_POST['action'])
      {
        case "maj" :
          // la page est arrivée en POST avec action=maj
          //  ==> Demande Enregistrement des valeurs.
          if ($_POST['labelFamille'])
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_modif_post_famille_variete()."</div>";
            echo fin_cadre_trait_couleur(true);
          }
          else
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>entrez un label de famille...</div>";
            echo fin_cadre_trait_couleur(true);
          }
          break;
        case "add" :
          // la page est arrivée en POST sans action ou autre
          //  ==> Demande Insertion des valeurs.
          if ($_POST['labelFamille'])
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_post_famille_variete()."</div>";
            echo fin_cadre_trait_couleur(true);
          }
          else
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>entrez un label de famille...</div>";
            echo fin_cadre_trait_couleur(true);
          }          
          break;
      } // switch ($_POST['action'])
          echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
      echo table_amap_lister_choix_produit(1, $_POST['idProduit'], "familles", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_POST['idProduit']);
      echo table_amap_lister_famille_variete($_POST['idProduit']);
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_POST['idProduit']);
      echo table_amap_get_famille_variete($_POST['idProduit']);
      echo fin_cadre_trait_couleur(true);
    }  // if ($_SERVER['REQUEST_METHOD'] == 'POST')
    else
    {
      // la page n'est pas arrivée en POST => en GET
      switch ($_GET['action'])
      {
        case "modif" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", "modification de la table amap_famille_variete");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_getmodif_famille_variete()."</div>";
          echo fin_cadre_trait_couleur(true);
          break;
        case "suppr" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
  echo   debut_cadre_trait_couleur("", true, "", "");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_suppr_famille_variete()."</div>";
          echo fin_cadre_trait_couleur(true);

          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit(1, $_GET['idProduit'], "familles", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_GET['idProduit']);
          echo table_amap_lister_famille_variete($_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_GET['idProduit']);
          echo table_amap_get_famille_variete($_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);
          break;
        default :
          // sans action ou autre
          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit(1, $_GET['idProduit'], "familles", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_GET['idProduit']);
          echo table_amap_lister_famille_variete($_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_GET['idProduit']);
          echo table_amap_get_famille_variete($_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);
          break;
      } // switch ($_GET['action'])
    } // if ($_SERVER['REQUEST_METHOD'] == 'POST')
 
  } // fin if ($page == 'familles')
  else if ($table == 'varietes') 
  { // Page variétés de produits
    $msg_presentation_1 = "Liste des vari&eacute;t&eacute;s dans une familles";
    $msg_presentation_2 = "Enregistrement d'une nouvelle vari&eacute;t&eacute;";

    // CHOIX DE L'ACTION A REALISER => de l'affichage

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      // la page est arrivée en POST
      switch ($_POST['action'])
      {
        case "maj" :
          // la page est arrivée en POST avec action=maj
          //  ==> Demande Enregistrement des valeurs.
          if ($_POST['labelVariete'])
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_modif_post_variete()."</div>";
            echo fin_cadre_trait_couleur(true);
          }
          else
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>entrez un label de vari&eacute;t&eacute;</div>";
            echo fin_cadre_trait_couleur(true);
          }
          break;
        case "add" :
          // la page est arrivée en POST sans action ou autre
          //  ==> Demande Insertion des valeurs.
          if ($_POST['labelVariete'])
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_post_variete()."</div>";
            echo fin_cadre_trait_couleur(true);
          }
          else
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>entrez un label de vari&eacute;t&eacute;</div>";
            echo fin_cadre_trait_couleur(true);
          }
          break;
      } // switch ($_POST['action'])
          echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
      echo table_amap_lister_choix_produit(1, $_POST['idProduit'], "varietes", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur("", true, "", "Choix de la famille");
      echo table_amap_lister_choix_famille($_POST['idProduit'], $_POST['idFamille'], "varietes", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_POST['idProduit']);
      echo table_amap_lister_variete($_POST['idProduit'], $_POST['idFamille']);
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_POST['idProduit']);
      echo table_amap_get_variete($_POST['idProduit'], $_POST['idFamille']);
      echo fin_cadre_trait_couleur(true);
    }  // if ($_SERVER['REQUEST_METHOD'] == 'POST')
    else
    {
      // la page n'est pas arrivée en POST => en GET
      switch ($_GET['action'])
      {
        case "modif" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", "modification de la table amap_variete");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_getmodif_variete()."</div>";
          echo fin_cadre_trait_couleur(true);
          break;
        case "suppr" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
  echo   debut_cadre_trait_couleur("", true, "", "");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_suppr_variete()."</div>";
          echo fin_cadre_trait_couleur(true);

          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit(1, $_GET['idProduit'], "varietes", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", "Choix de la famille");
          echo table_amap_lister_choix_famille($_GET['idProduit'], $_GET['idFamille'], "varietes", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_GET['idProduit']);
          echo table_amap_lister_variete($_GET['idProduit'], $_GET['idFamille']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_GET['idProduit']);
          echo table_amap_get_variete($_GET['idProduit'], $_GET['idFamille']);
          echo fin_cadre_trait_couleur(true);
          break;
        default :
          // sans action ou autre
          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit(1, $_GET['idProduit'], "varietes", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", "Choix de la famille");
          echo table_amap_lister_choix_famille($_GET['idProduit'], $_GET['idFamille'], "varietes", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1.$_GET['idProduit']);
          echo table_amap_lister_variete($_GET['idProduit'], $_GET['idFamille']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2.$_GET['idProduit']);
          echo table_amap_get_variete($_GET['idProduit'], $_GET['idFamille']);
          echo fin_cadre_trait_couleur(true);
          break;
      } // switch ($_GET['action'])
    } // if ($_SERVER['REQUEST_METHOD'] == 'POST')
 
  } // fin if ($page == 'varietes')
  else 
  { // page composition d'un panier
    $msg_presentation_1 = "Composition du panier";
    $msg_presentation_2 = "Enregistrement d'une vari&eacute;t&eacute; suppl&eacute;mentaire au panier";

    // CHOIX DE L'ACTION A REALISER => de l'affichage

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      // la page est arrivée en POST
      switch ($_POST['action'])
      {
        case "maj" :
          // la page est arrivée en POST avec action=maj
          //  ==> Demande Enregistrement des valeurs.
  echo   debut_cadre_trait_couleur("", true, "", "");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_modif_post_panier()."</div>";
          echo fin_cadre_trait_couleur(true);
          break;
        case "add" :
          // la page est arrivée en POST sans action ou autre
          //  ==> Demande Insertion des valeurs.
          if ( ($_POST['quantite'] <> '') || ($_POST['poids'] <> '') )
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>"
                 .table_amap_post_panier()."</div>";
            echo fin_cadre_trait_couleur(true);
            $_POST['quantite'] = '';
            $_POST['poids'] = '';
          }
          else
          {
    echo   debut_cadre_trait_couleur("", true, "", "");
            echo "<div class='verdana2' style='text-align: justify'>entrez une quantit&eacute; ou un poids</div>";
            echo fin_cadre_trait_couleur(true);
          }
          break;
      } // switch ($_POST['action'])
          echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_saison'));
      echo table_amap_lister_choix_saison($_POST['idSaison'], "", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
      echo table_amap_lister_choix_produit($_POST['idSaison'], $_POST['idProduit'], "", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur("", true, "", "Choix de la distribution");
      echo table_amap_lister_choix_distribution($_POST['idSaison'], $_POST['idProduit'], $_POST['idDistrib'], "", "amap_paniers");
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1
										." de la saison ".$_POST['idSaison']
										." pour la distribution ".$_POST['idDistrib']
										." de produit ".$_POST['idProduit']);
      echo table_amap_lister_panier($_POST['idSaison'], $_POST['idDistrib'], $_POST['idProduit']);
      echo fin_cadre_trait_couleur(true);

          echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2);
      echo table_amap_get_panier($_POST['idSaison'], $_POST['idDistrib'], $_POST['idProduit']);
      echo fin_cadre_trait_couleur(true);
    }  // if ($_SERVER['REQUEST_METHOD'] == 'POST')
    else
    {
      // la page n'est pas arrivée en POST => en GET
      switch ($_GET['action'])
      {
        case "modif" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", "modification de la table amap_panier");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_getmodif_panier()."</div>";
          echo fin_cadre_trait_couleur(true);
          break;
        case "suppr" :
          // avec action=maj
          //  ==> Affichage formulaire de modification
  echo   debut_cadre_trait_couleur("", true, "", "");
          echo "<div class='verdana2' style='text-align: justify'>"
               .table_amap_suppr_panier()."</div>";
          echo fin_cadre_trait_couleur(true);

          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_saison'));
          echo table_amap_lister_choix_saison($_GET['idSaison'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit($_GET['idSaison'], $_GET['idProduit'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", "Choix de la distribution");
          echo table_amap_lister_choix_distribution($_GET['idSaison'], $_GET['idProduit'], $_GET['idDistrib'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1
										." de la saison ".$_GET['idSaison']
										." pour la distribution ".$_GET['idDistrib']
										." de produit ".$_GET['idProduit']);
          echo table_amap_lister_panier($_GET['idSaison'], $_GET['idDistrib'], $_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2);
          echo table_amap_get_panier($_GET['idSaison'], $_GET['idDistrib'], $_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);
          break;
        default :
          // sans action ou autre
          //  ==> Affichage de la liste
              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_saison'));
          echo table_amap_lister_choix_saison($_GET['idSaison'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", _T('amap:choix_produit'));
          echo table_amap_lister_choix_produit($_GET['idSaison'], $_GET['idProduit'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur("", true, "", "Choix de la distribution");
          echo table_amap_lister_choix_distribution($_GET['idSaison'], $_GET['idProduit'], $_GET['idDistrib'], "", "amap_paniers");
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata.gif", true, "", $msg_presentation_1
										." de la saison ".$_GET['idSaison']
										." pour la distribution ".$_GET['idDistrib']
										." de produit ".$_GET['idProduit']);
          echo table_amap_lister_panier($_GET['idSaison'], $_GET['idDistrib'], $_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);

              echo   debut_cadre_trait_couleur(_DIR_PLUGIN_AMAP."img_pack/tabledata-add.gif", true, "", $msg_presentation_2);
          echo table_amap_get_panier($_GET['idSaison'], $_GET['idDistrib'], $_GET['idProduit']);
          echo fin_cadre_trait_couleur(true);
          break;
      } // switch ($_GET['action'])
    } // if ($_SERVER['REQUEST_METHOD'] == 'POST')

  } // fin else du if ($page

  echo pipeline('affiche_milieu',array('args'=>array('exec'=>'amap_paniers'),'data'=>''));
  echo "\n<br/><br/><hr/>\n"
          ,"<center><i class='arial1' >"
          ,"Plugin Amap v1.1 par St&eacute;phane Moulinet -dadaprod.org - <br/>"
          ,"pour la gestion de 'tables amap'."
          ,"</i></center>\n<hr/>\n" ;
  echo fin_gauche(), fin_page();
}
?>

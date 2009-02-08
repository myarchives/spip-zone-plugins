<?php
/*
 *   +----------------------------------+
 *    Nom :   Table des matieres
 *   +----------------------------------+
 *    Date : aout 2004
 *    Auteur :  Mortimer Porte mortimer.pa@free.fr
 *    Modifications: Bertrand Marne bmarne@gmail.com
 *    Modifications: St�phane Deschamps spip@nota-bene.org
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche une table des mati�res ou g�n�re automatiquement la num�rotation des titres.
 *   +-------------------------------------+ 
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.spip-contrib.net/article.php3?id_article=627
 *
 * Petites modifications de Bertrand Marne (mise en plugin)
 * - prise en compte des di�ses:
 * les * donnent des titres non num�rot�s, les # des titres num�rot�s
 * Mais attention ils sont tous d�compt�s pareil pour l'arborescence de la table
 * des mati�res et la num�rotation, qu'ils soient num�rot�s (#) ou non (*).
 *
 * - prise ne compte des titres comme <hx class="spip"> o� x>3
 *
 * - encore une modif, tr�s moche: pour permettre de n'afficher que la table,
 * quand on utilise ceci comme un filtre avec unn second param�tre:
 * [(#TEXTE|table_des_matieres{table_seule})]
 * - ajout d'une fonction qui converti les intertitres des enluminures en
 * intertitres compatibles avec cette contrib'
 * 
 * Petites modifications de St�phane Deschamps
 * - prise en compte des niveaux de titres si ils sont d�clar�s dans mes_fonctions ou mes_options par $GLOBALS['debut_intertitre']
*/
function IntertitresTdm_table_des_matieres($texte,$tableseule=false,$url_article="") {
  global $debut_intertitre, $fin_intertitre;

   // d�finition de la balise pour les titres des sections %num% sera remplac� 
  // par la profondeur de la section
  // les raccourcis soient remplac�s par des headlines (<hx>)
  $css_debut_intertitre = "\n<h%num% class=\"spip\">";
  $css_fin_intertitre = "</h%num%>\n";

  // on trouve combien ajouter au level pour �tre dans le bon niveau de titres quand on g�n�re la balise <hx>
  // sinon par defaut on ajoute 2 pour garder les niveaux du script original
  if($GLOBALS['debut_intertitre']) {
	$find = @preg_match("/(\<h)([0-9])/",$GLOBALS['debut_intertitre'],$matches);
	if($matches) {
		$level_base = $matches[2] -1; // on d�duit 1 pour �tre au bon niveau ensuite : ce sera 1 + nombre d'ast�risques trouv�es
	}
  }
  if(!isset($level_base)) {
 	$level_base = 2;
  }

  // on cherche les noms de section commen�ant par des * et #
  $my_debut_intertitre=trim($debut_intertitre); //astuce des trim trouv�e l� : http://www.spip-contrib.net/Generation-automatique-de#forum383092
  $my_fin_intertitre=trim($fin_intertitre);

  // pour que les diff�rents niveaux d'intertitres soient g�r�s quand on repasse sur le texte dans le cadre d'un filtre avec tableseule
  if ($tableseule) {
	$my_debut_intertitre=trim("\n<h([3-9]) class=\"spip\">");
	$my_fin_intertitre=trim("</h[3-9]>\n");
	}

  // on cherche les noms de section commen�ant par des * et #
  $count = preg_match_all(
	"(($my_debut_intertitre([\\*#]*)(.*?)(<(.*?)>)?$my_fin_intertitre))",
	$texte,
	$matches
	);

  $table = '';

  //initialisation du compteur
  $cnt[0] = 0;

  // initialisation du code de la table des mati�res
  // s'articule autour d'un <a name=""> et d'un <ul>
  $table = "\n<a name=\"table_des_matieres\"></a><div id=\"tablematiere\">\n<ul>";
  $lastlevel = 1;
  $cite[''] = '';

  // d�calle le matching quand on repasse sur le texte avec tableseule
  if ($tableseule) $ajout=1;

  // pour chaque titre trouv�
  for ($j=0; $j< $count; $j++) {
	$level = $matches[2+$ajout][$j];

  // quand tableseule, le niveau est "recr��" � partir du nombre du headline (ex <h4> donne niveau 2)
	if ($tableseule) {
		$level=str_repeat("*",$matches[2][$j]-2);
	}

  // pour tenir compte des {{{ }}} sans * ou # et donc qu'un name leur soit ajout�, et qu'ils soient quand m�me dans la table des mati�res
	if(strlen($level) == 0) $level="*";
	$titre = $matches[3+$ajout][$j];

  // Si tableseule alors on vire les <a name=''></a> des titres
	if ($tableseule) {
		$titre=preg_replace("/(<a name=')(.*?)('><\/a>)/","",$titre);
	}
	$ref = $matches[5+$ajout][$j];

  // si tableseule alors le $ref correspond au contenu du <a name=''></a>... Je sais pas si �a marche: pas test� ! :o)
	if ($tableseule) {
		preg_match(
			"/(<a name=')(.*?)('><\/a>)/",
			$matches[3+$ajout][$j],
			$tsmatches
		);
		$ref=$tsmatches[2];
	}
	if(strlen($level) == 1) {

           //on est au niveau de base
          //on r�initialise les compteurs
	  for ($i=1; $i < count($cnt); $i++) {
		$cnt[$i] = 0;
	  }

          //on g�n�re le titre et le num�ros
	  $numeros = ++$cnt[0];

	// on teste si le level contient des # pour savoir si l'on affiche les
	//num�ros avec le titre ou non (#->num�ros affich�s)
	  if (preg_match("/#+/",$level)) $titre = $numeros.'- '.$titre;
	} else {

           //on est � un niveau plus profond
          // on construit le num�ros
	  $numeros = $cnt[0].'.';
	  for ($i=1; $i < strlen($level)-1; $i++) {
		$numeros .= $cnt[$i].".";
	  }
	  $numeros = $numeros.(++$cnt[$i]);

          //on g�n�re le titre
	  //on teste si le level contient des # pour savoir si l'on affiche les
	  //num�ros avec le titre ou non (#->num�ros affich�s)
	  if(preg_match("/#+/",$level)) $titre = $numeros.'- '.$titre;
	}

        //gestion de la liste dans la table
	if($lastlevel < strlen($level)) {

          //on ouvre une sous liste
	  $table .= "<ul>\n";
	}
	if($lastlevel > strlen($level)) {

          //on doit fermer les derniers niveaux
	  for ($i=0; $i < ($lastlevel - strlen($level)); $i++) {
             if($i+1==$lastlevel) {
               $table .= "\n</div></ins>";	// derniere fermeture
             } else {
               $table .= "</li>\n</ul>"; 
             }	
	  }
	}
	if($lastlevel >= strlen($level)) {

          //on doit fermer l'item pr�c�dent
	  if($cnt[0] > 1 || strlen($level) > 1) {
		$table .= "</li>\n";
	  }
	}
 
       //on se rappelle du raccourcis
	$cite[$ref] = $numeros;
	$table .= "<li><a href=\"$url_article#$numeros\" title=\"Aller directement &agrave;  	&laquo;&nbsp;".textebrut($titre)."&nbsp;&raquo;\">$titre</a>";

       //on m�morise le niveau de ce titre
	$lastlevel = strlen($level);

        //on g�n�re la balise avec le bon style pour le niveau
	//et on ajoute $level_base � $lastlevel pour avoir des <hx> qui commencent � <h{$level_base}>
	$mdebut_intertitre = str_replace('%num%',$lastlevel+$level_base,$css_debut_intertitre);
	$mfin_intertitre = str_replace('%num%',$lastlevel+$level_base,$css_fin_intertitre);

        //on remplace le titre dans le texte
	$texte = str_replace($matches[0][$j],"$mdebut_intertitre<a name='$numeros'></a>$titre$mfin_intertitre",$texte);
  }

  //on fini la table
  for ($i=0; $i < $lastlevel; $i++) {
	$table .= "</li>\n</ul>";		
  }

  //on remplace les raccourcis par les num�ros des sections.
  foreach ($cite as $ref => $num) {
	$texte = str_replace("<$ref>","<a href=\"$url_article#$num\">$num</a>",$texte);	
  }

  // ajout d'un div plus propre !
  $table .="\n</div>";

  //on place la table des mati�res dans le texte
  //si y'a rien, ben on envoie rien !
  if ($cnt[0]==0) $table='';

  // Comme la TDM est d�sormais affich�e de mani�re externe aux articles, si un auteur met #TABLEMATIERES dans son article, cel� cr�e un lien vers la TDM externe, d'o� un remplacement de:
  //$texte = str_replace('#TABLEMATIERES',$table,$texte); par:
  $texte = str_replace('#TABLEMATIERES',"<a href=\"#table_des_matieres\" title=\"Aller &agrave; la table des mati&egrave;res de l'article\">Table des mati&egrave;res</a>",$texte);

  // si tableseule on ne renvoit que la table, sinon, on renvoie tout
  if ($tableseule) {return $table;} else {return $texte;}
}
?>
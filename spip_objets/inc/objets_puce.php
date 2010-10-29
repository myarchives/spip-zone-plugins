<?php 


function objets_puce_statut($id_objet, $statut, $id_rubrique, $objet, $ajax='') {
  global $lang_objet;
  static $coord = array('publie' => 1,
            'prop' => 0,	
            'poubelle' => 2,
            'prepa' => 3);

  $lang_dir = lang_dir($lang_objet);
  $puces = array(
           0 => 'puce-orange-breve.gif',
           1 => 'puce-verte-breve.gif',
           2 => 'puce-rouge-breve.gif',
           3 => 'puce-blanche-breve.gif');

  switch ($statut) {
    case 'prop':
      $clip = 0;
      $puce = $puces[0];
      $title = _T('objets:titre_objet_proposee');
      break;
    case 'prepa':
      $clip = 3;
      $puce = $puces[3];
      $title = _T('objets:titre_objet_prepa');
      break;
    case 'publie':
      $clip = 1;
      $puce = $puces[1];
      $title = _T('objets:titre_objet_publiee');
      break;
    case 'refuse':
      $clip = 2;
      $puce = $puces[2];
      $title = _T('objets:titre_objet_refusee');
      break;
    default:
      $clip = 3;
      $puce = $puces[3];
      $title = '';
  }

  $type1 = "statut$objet$id_objet"; 
  $inser_puce = http_img_pack($puce, $title, "id='img".$type1."' style='margin: 1px;'");
  
  $nom_objet=objets_nom_objet($objet);

  if (!autoriser('publierdans','rubrique',$id_rubrique)
  OR !_ACTIVER_PUCE_RAPIDE)
    return $inser_puce;

  $titles = array(
        "blanche" => _T('texte_statut_en_cours_redaction'),
        "orange" => _T('texte_statut_propose_evaluation'),
        "verte" => _T('texte_statut_publie'),
        "rouge" => _T('texte_statut_refuse'),
        "poubelle" => _T('texte_statut_poubelle'));
        
  $clip = 1+ (11*$coord[$statut]);

  if ($ajax){
    return  "<span class='puce_objet_fixe'>"
    . $inser_puce
    . "</span>" ;
    /* 
     * TODO : gestion du statut de l'objet ... a priori il faudrait aussi un fichier action/instituer_OBJET 
     * 
     * 
    . "<span class='puce_article_popup' id='statutdecal$objet$id_objet' style='margin-left: -".$clip."px;'>" //TODO : la classe n'est super bonne mais ca marche
		. afficher_script_statut($id_objet, $nom_objet, -1, $puces[3], 'prepa', $titles['blanche'])
    . afficher_script_statut($id_objet, $nom_objet, -10, $puces[1], 'publie', $titles['verte'])
    . afficher_script_statut($id_objet, $nom_objet, -19, $puces[2], 'refuse', $titles['rouge'])
    . "</span>";
    
    */
  }

  $nom = "puce_statut_";

  if (! _SPIP_AJAX) 
    $over ='';
  else {
    $action = generer_url_ecrire('puce_statut',$objet,false);
    $action = "if (!this.puce_loaded) { this.puce_loaded = true; prepare_selec_statut('$nom', '$nom_objet', '$id_objet', '$action'); }";
    $over = " onmouseover=\"$action\"";
  }

  return  "<span class='puce_$objet' id='$nom$objet$id_objet' dir='$lang_dir'$over>"
  . $inser_puce
  . '</span>';

}

?>
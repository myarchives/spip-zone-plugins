<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite


// les filtres pour le formulaire
function echapper_mot($titre, $type, $groupe_defaut) {
  include_spip('inc/tag-machine');
  $tag = '';
  if($type) {
	if($type == $groupe_defaut)
	  $tag = new Tag($titre,'');
	else
	  $tag = new Tag($titre,$type);
  } else
	$tag = new Tag($titre,$groupe_defaut);
  return $tag->echapper();
}



function balise_FORMULAIRE_TAG_FORUM ($p) {
	return calculer_balise_dynamique($p,'FORMULAIRE_TAG_FORUM', array('id_forum', 'fond'));
}


/*
* La fonction statique retourne fait les verifications sur les variables r�cup�r�es par collecte
* ici, $args[0] contient donc id_forum.
*
* ensuite en renvoi les arguments en questions pour la balise dynamique.
* 
*/
function balise_FORMULAIRE_TAG_FORUM_stat($args, $filtres) {

	// Pas d'id_forum ? Erreur de squelette
	if (!$args[0])
		return erreur_squelette(
			_T('zbug_champ_hors_motif',
				array ('champ' => '#FORMULAIRE_TAG_FORUM',
					'motif' => 'FORUMS')), '');

	return $args;
}

/* la fonction dynamique fait les calculs et renvois le squelette qu'il faut afficher.
_request() cherche dans les valeurs post.
*/
function balise_FORMULAIRE_TAG_FORUM_dyn($id_forum,$fond) {

	include_spip('inc/tag-machine');

	$url = self();
	if($fond) parametre($url,'fond',$fond);
	// si ya pas de mot dans le formulaire
	if (!_request('tags_'._request('id_groupe').'_'.$id_forum)) {
	  // on affiche le squelette en ajoutant un id_forum et l'url de la page (self) dans le contexte
	  return array('formulaires/formulaire_tag_forum', $GLOBALS['delais'],
				   array('self' => $url,
						 'id' => $id_forum,
						 'fond' => $fond
						 )
				   );
	} else {
	  // sinon
	  //on ajoute les mots avec tag-machine (ou on fait tout autre calcul)
	  $tags = new ListeTags(_request('tags_'._request('id_groupe').'_'.$id_forum),_request('titre_groupe'));
	  
	  $tags->ajouter($id_forum, 'forum', 'id_forum', true);
	  
	  //et on retourne le formulaire (c'est le m�me apres tout)
	  return array('formulaires/formulaire_tag_forum', $GLOBALS['delais'],
				   array('self' => $url,
						 'id' => $id_forum,
						 'fond' => $fond
						 )
				   );
	}
}

?>

<?php

function exec_flickr_choix_sets() {
  global $connect_id_auteur;

  include_spip('inc/flickr_api');
  include_spip('base/abstract_sql');
  
  echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>'._T('fpipr:ajouter_sets').'</title>
    <style>
       li {float: left; list-style-type:none; height: 90px; width: 90px; margin: 1em;}
       li img {display:block; clear:both;}
    </style>
  </head>

  <body>';

  echo '<h1>'._T('fpipr:ajouter_sets').'</h1>';
  echo _T('fpipr:info_sets');

  $from = array('spip_auteurs');
  $select = array('flickr_token','flickr_nsid');
  $where = array('id_auteur='.$connect_id_auteur);
  $row = spip_abstract_fetsel($select,$from,$where);
  if($row['flickr_nsid'] != '' && $row['flickr_token'] != '') {
	$page = _request('page')?_request('page'):1;
	$photosets = flickr_photosets_getList($row['flickr_nsid'],$row['flickr_token']);
	
	$html = '<input type="hidden" name="flickr_nsid" value="'.$row['flickr_nsid'].'">';
	$html .= '<input type="hidden" name="flickr_token" value="'.$row['flickr_token'].'">';
	$html .= "<ul>\n";
	foreach($photosets as $set) {
	  $html .= '<li>';
	  if($set->title) {
		$html .= '<a  href="'.$set->url().'">';
		$html .= '<img src="'.$set->logo('s').'" alt="'.$set->title.' on Flickr">';
		$html .= '</a>';
		$html .= '<input type="checkbox" name="sets[]" id="set_'.$set->id.'" value="'.$set->id.'"/>';
		$html .= '<label for="set_'.$set->id.'">'.$set->title.'</label>';
	  } else {
		$html .= '<label for="set_'.$set->id.'">';
		$html .= '<a  href="'.$set->url().'">';
		$html .= '<img src="'.$set->logo('s').'" alt="'.$set->title.' on Flickr">';
		$html .= '</a>';
		$html .= '</label>';
		$html .= '<input type="checkbox" name="sets[]" id="set_'.$set->id.'" value="'.$set->id.'"/>';
	  }
	  $html .= '</li>'."\n";
	}
	$html .= "</ul>\n";
	$html .= '<br clear="both">';
	$html .= '<button type="submit">'._T('spip:bouton_valider')."</button>\n";
	$html .= '<input type="hidden" name="type" value="'._request('type').'"/>'."\n";
	$html .= '<input type="hidden" name="id" value="'._request('id').'"/>'."\n";
	$html .= '<input type="hidden" name="set" value="oui"/>'."\n";


	include_spip('inc/actions');
	if(_request('type') == 'article') {
	  echo generer_action_auteur('flickr_ajouter_documents',_request('id'), generer_url_ecrire('articles','id_article='._request('id')),$html);
	} else if(_request('type') == 'rubrique') {
	  echo generer_action_auteur('flickr_ajouter_documents',_request('id'), generer_url_ecrire('naviguer','id_rubrique='._request('id')),$html);
	} else {
	  echo generer_action_auteur('flickr_ajouter_documents',_request('id'), generer_url_ecrire('breves_edit','id_breve='._request('id')),$html);
	}
  } else {
	echo _T('fpipr:demande_authentification',array('url'=>generer_url_ecrire('auteurs_edit','id_auteur='.$connect_id_auteur).'">l&agrave;</a>'));
  }
  if(_request('type') == 'article') {
	echo '<a href="'.generer_url_ecrire('articles','id_article='._request('id')).'">'._T('fpipr:retour').'</a>';
  } else if(_request('type') == 'rubrique') {
	  echo '<a href="'.generer_url_ecrire('naviguer','id_rubrique='._request('id')).'">'._T('fpipr:retour').'</a>';
  } else {
	  echo '<a href="'.generer_url_ecrire('breves_edit','id_breve='._request('id')).'">'._T('fpipr:retour').'</a>';
  }
  echo '</body></html>';  
}

?>

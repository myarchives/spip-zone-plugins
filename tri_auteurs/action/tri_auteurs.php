<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Pierre ANDREWS
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


function action_tri_auteurs() {
  global $hash, $id_auteur, $id_article, $order;

  $id_article = intval($id_article);
  
  include_ecrire("inc_session");
  if (!verifier_action_auteur("tri_auteurs $id_article", $hash, $id_auteur)) {
	include_ecrire('inc_minipres');
	minipres(_T('info_acces_interdit'));
  }

  $table_pref = 'spip';
  if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix'];
  
  
  if($order = $_REQUEST['o']) {
	for($i=0;$i<count($order);$i++) {  									
	  spip_query("UPDATE ".$table_pref."_auteurs_articles SET rang = $i WHERE id_article=$id_article AND id_auteur=".intval($order[$i]));
	}
  }
}

?>

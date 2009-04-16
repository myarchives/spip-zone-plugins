<?php
#              ACS
#          (Plugin Spip)
#     http://acs.geomaticien.org
#
# Copyright Daniel FAIVRE, 2007-2009
# Copyleft: licence GPL - Cf. LICENCES.txt

//include_spip('inc/acs_presentation');//(implicite)
include_spip('lib/composant/composants_variables');

function acs_vars_gauche(){
  return acs_box(_T('acs:variables'), _T('acs:toutes_les_variables'), _DIR_PLUGIN_ACS.'/img_pack/vars-24.gif', false, '<img src="'._DIR_PLUGIN_ACS.'/img_pack/info.png" />');
}

function acs_vars() {
  return acs_page_get_all_variables();
}

function acs_vars_droite() {
  
}

function acs_page_get_all_variables() {

  $cv = composants_variables();
  ksort($cv);
  $r .= "\n<table cellpadding='3' cellspacing='1' border='0' width=\"100%\">";
  $r .= "\n<tr style='background: ".$GLOBALS['couleur_foncee']."; color:white;'><td class='verdana1'><b>"._T('acs:variable')."</b></td>\n<td class='verdana2'><b>"._T('acs:valeur')."</b></td>\n</tr>\n";
  $cvars = array();
  foreach($cv as $v=>$c) {
    if ($last && ($last != $c['composant'])) {
      $r .= '<tr><td colspan="2" style=" height: 1px; padding: 0; background-color: '.$GLOBALS['couleur_claire'].'"></td></tr>';
      $instances = composant_instances($last);
      if (is_array($instances)) {
        foreach($instances as $nic) {
          $r .= '<tr><td colspan="2" style=" height: 1px; padding: 0; background-color: '.$GLOBALS['couleur_claire'].'"></td></tr>';
          foreach($cvars as $c_v=>$c_c) {
            $var = str_replace(ucfirst($c_c['composant']), ucfirst($c_c['composant']).$nic, $c_v);
            $r .= composant_variable($var, $c_c, $nic);
          }
        }
      }
      $cvars = array(); 
    }
    $cvars[$v] = $c; // Variables du composant
    $r .= composant_variable($v, $c);
    $last = $c['composant'];
  }
  $r .= '</table>';  
  return acs_box('', $r);
}

function composant_variable($v, $c, $nic=false) {
  static $i;
  if (substr($v, 0, 6) == '#over#') {
    $v = substr($v, 6);
    $before = '<u>';
    $after = '</u>';
  }
  else {
    $before = '';
    $after = '';
  }
  $bgcolor = alterner($i++, '#eeeeee','white');
  return '<tr style="background: '.$bgcolor.'; vertical-align: top;"><td class="verdana2">'.
  '<a href="?exec=acs&onglet=composants&composant='.$c['composant'].($nic ? '&nic='.$nic : '').'" class="nompage" style="font-size: 1.2em">'.
  $before.'<span style="color:#8d8d8f">acs</span>'.$v.$after.'</a></td>'.
  '<td class="crayon var-'.$v.'-'.($nic ? $nic : 0).' type_pinceau crayon_'.$v.' arial2">'.
  (isset($GLOBALS['meta']['acs'.$v]) ? couper(htmlspecialchars($GLOBALS['meta']['acs'.$v]), 150) : '<span style="color:darkviolet">'._T('acs:undefined').'</span>').
  '</td></tr>';
}
?>
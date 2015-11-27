<?php
/**
 *      \file log.section.php
 *
 *      Copyright 2011 dorch <dorch@dorch-xps>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


class cLog {
   public $txt;

   function __construct() {
      $this->txt = '<div class="hyd_log">
            <div class="titre">'._T('hydraulic:log_titre').'</div>
            <ul>';
   }

   public function Add($sTxt,$bErr=false) {
      $this->txt .= '<li';
      if($bErr) {$this->txt .= ' class="hyd_erreur"';}
      $this->txt .= '>'.$sTxt.'</li>';
   }

   public function Result() {
      return $this->txt.'</ul></div>';
   }
}
?>

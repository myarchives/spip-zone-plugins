<?php
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_chmod.php, released on 2003-03-31.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	Permission-Change Functions
	
	Have Fun...

	Adaptation spip, plugin spixplorer : bertrand@toggg.com © 2007

------------------------------------------------------------------------------*/

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_spx_chmod()
{
	include_spip('inc/spx_init');
	chmod_item($GLOBALS['spx']["dir"], $GLOBALS['spx']["item"]);
}

//------------------------------------------------------------------------------
function chmod_item($dir, $item) {		// change permissions
	if(($GLOBALS['spx']["permissions"]&01)!=01) show_error(_T('spixplorer:accessfunc'));
	if(!file_exists(get_abs_item($dir, $item))) show_error($item.": "._T('spixplorer:fileexist'));
	if(!get_show_item($dir, $item)) show_error($item.": "._T('spixplorer:accessfile'));
	
	// Execute
	if(_request("confirm")=="true") {
		$bin='';
		for($i=0;$i<3;$i++) for($j=0;$j<3;$j++) {
			$tmp="r_".$i.$j;
			if(_request($tmp)=="1" ) $bin.='1';
			else $bin.='0';
		}
		
		if(!@chmod(get_abs_item($dir,$item),bindec($bin))) {
			show_error($item.": "._T('spixplorer:permchange'));
		}
		header("Location: ".make_link("list",$dir,NULL));
		return;
	}
	
	$mode = parse_file_perms(get_file_perms($dir,$item));
	if($mode===false) show_error($item.": "._T('spixplorer:permread'));
	$pos = "rwx";
	
	$s_item=get_rel_item($dir,$item);	if(strlen($s_item)>50) $s_item="...".substr($s_item,-47);
	show_header(_T('spixplorer:actperms').": /".$s_item);
	

	// Form
	echo "<BR><TABLE width=\"175\"><FORM method=\"post\" action=\"";
	echo make_link("chmod",$dir,$item) . "\">\n";
	echo "<INPUT type=\"hidden\" name=\"confirm\" value=\"true\">\n";
	
	// print table with current perms & checkboxes to change
	$miscchmod = explode('/', _T('spixplorer:miscchmod')); 	
	for($i=0;$i<3;++$i) {
		echo "<TR><TD>" . $miscchmod[$i] . "</TD>";
		for($j=0;$j<3;++$j) {
			echo "<TD>" . $pos{$j} . "&nbsp;<INPUT type=\"checkbox\"";
			if($mode{(3*$i)+$j} != "-") echo " checked";
			echo " name=\"r_" . $i.$j . "\" value=\"1\"></TD>";
		}
		echo "</TR>\n";
	}
	
	// Submit / Cancel
	echo "</TABLE>\n<BR><TABLE>\n<TR><TD>\n<INPUT type=\"submit\" value=\""._T('spixplorer:btnchange');
	echo "\"></TD>\n<TD><input type=\"button\" value=\""._T('spixplorer:btncancel');
	echo "\" onClick=\"javascript:location='".make_link("list",$dir,NULL)."';\">\n</TD></TR></FORM></TABLE><BR>\n";
}
//------------------------------------------------------------------------------
?>

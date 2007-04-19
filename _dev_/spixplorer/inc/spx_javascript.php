<script language="JavaScript1.2" type="text/javascript">
<!--
	// Checkboxes
	function Toggle(e) {
		if(e.checked) {
			Highlight(e);
			document.selform.toggleAllC.checked = AllChecked();
		} else {
			UnHighlight(e);
			document.selform.toggleAllC.checked = false;
		}
   	}

	function ToggleAll(e) {
		if(e.checked) CheckAll();
		else ClearAll();
	}
	
	function CheckAll() {
		var ml = document.selform;
		var len = ml.elements.length;
		for(var i=0; i<len; ++i) {
			var e = ml.elements[i];
			if(e.name == "selitems[]") {
				e.checked = true;
				Highlight(e);
			}
		}
		ml.toggleAllC.checked = true;
	}

	function ClearAll() {
		var ml = document.selform;
		var len = ml.elements.length;
		for (var i=0; i<len; ++i) {
			var e = ml.elements[i];
			if(e.name == "selitems[]") {
				e.checked = false;
				UnHighlight(e);
			}
		}
		ml.toggleAllC.checked = false;
	}
   
	function AllChecked() {
		ml = document.selform;
		len = ml.elements.length;
		for(var i=0; i<len; ++i) {
			if(ml.elements[i].name == "selitems[]" && !ml.elements[i].checked) return false;
		}
		return true;
	}
	
	function NumChecked() {
		ml = document.selform;
		len = ml.elements.length;
		num = 0;
		for(var i=0; i<len; ++i) {
			if(ml.elements[i].name == "selitems[]" && ml.elements[i].checked) ++num;
		}
		return num;
	}
	
	
	// Row highlight

	function Highlight(e) {
		var r = null;
		if(e.parentNode && e.parentNode.parentNode) {
			r = e.parentNode.parentNode;
		} else if(e.parentElement && e.parentElement.parentElement) {
			r = e.parentElement.parentElement;
		}
		if(r && r.className=="rowdata") {
			r.className = "rowdatasel";
		}
	}

	function UnHighlight(e) {
		var r = null;
		if(e.parentNode && e.parentNode.parentNode) {
			r = e.parentNode.parentNode;
		} else if (e.parentElement && e.parentElement.parentElement) {
			r = e.parentElement.parentElement;
		}
		if(r && r.className=="rowdatasel") {
			r.className = "rowdata";
		}
	}
	
<?php if (($GLOBALS['spx']["permissions"] & 01) == 01) { ?>
	
	// Copy / Move / Delete
	
	function Copy() {
		if(NumChecked()==0) {
			alert("<?php echo _T('spixplorer:miscselitems'); ?>");
			return;
		}
		document.selform.arg.value = document.selform.arg_copy_move.value;
		document.selform.hash.value = document.selform.hash_copy_move.value;
		document.getElementById("action").value = "spx_copy_move";
		document.selform.do_action.value = "copy";
		document.selform.submit();
	}
	
	function Move() {
		if(NumChecked()==0) {
			alert("<?php echo _T('spixplorer:miscselitems'); ?>");
			return;
		}
		document.selform.arg.value = document.selform.arg_copy_move.value;
		document.selform.hash.value = document.selform.hash_copy_move.value;
		document.getElementById("action").value = "spx_copy_move";
		document.selform.do_action.value = "move";
		document.selform.submit();
	}
	
	function Delete() {
		num=NumChecked();
		if(num==0) {
			alert("<?php echo _T('spixplorer:miscselitems'); ?>");
			return;
		}
		if(confirm("<?php echo _T('spixplorer:miscdelitems'); ?>")) {
			document.selform.arg.value = document.selform.arg_del.value;
			document.selform.hash.value = document.selform.hash_del.value;
			document.getElementById("action").value = "spx_del";
			document.selform.submit();
		}
	}
	
	function Archive() {
		if(NumChecked()==0) {
			alert("<?php echo _T('spixplorer:miscselitems'); ?>");
			return;
		}
		document.selform.namearch.value = document.creaform.mkname.value;
		document.selform.arg.value = document.selform.arg_archive.value;
		document.selform.hash.value = document.selform.hash_archive.value;
		document.getElementById("action").value = "spx_archive";
		document.selform.submit();
	}
	
<?php } ?>

// -->
</script>

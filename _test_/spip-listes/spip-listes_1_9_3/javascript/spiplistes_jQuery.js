// spiplistes_jQuery_courrier.js
// utilis� par _SPIPLISTES_EXEC_COURRIER_REDAC

// $LastChangedRevision: 15830 $
// $LastChangedBy: paladin@quesaco.org $
// $LastChangedDate: 2007-10-07 05:41:13 +0200 (dim., 07 oct. 2007) $

$(document).ready(function(){
	
	$("#ajax-loader").hide();
	
	$("#ajax-loader").ajaxStart(function(){
			$(this).show();
	});
		
	$("#ajax-loader").ajaxStop(function(){
		$(this).hide();
	});

	$("#template").submit(function(){
		var	 data = $('input,textarea,radio,select, checkbox', this).serialize();
		$.ajax({ type: "POST", 
					url: "./?exec=spiplistes_courrier_previsu", 
					data: data, 
					success: function(msg){  $("#apercu-c").html(msg); }
			});
		return false;
	});
});
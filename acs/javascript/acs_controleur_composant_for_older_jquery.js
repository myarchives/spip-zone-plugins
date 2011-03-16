[(#REM)
               ACS
           (Plugin Spip)
      http://acs.geomaticien.org

  Copyright Daniel FAIVRE, 2007-2011
  Copyleft: licence GPL - Cf. LICENCES.txt

  JS interface d'admin d'ACS - ACS admin GUI
]#HTTP_HEADER{'Content-Type: text/javascript'}

jQuery(".edit_composant").each(
  	function(i, composant) {
    	jQuery(this).Draggable({zIndex: 99999000, handle: ".acs_box_titre"});
    	jQuery(this).find(".acs_box_titre").css("cursor", "move");
  	}
  );
  jQuery(".type_pinceau").each(
  	function(i, composant) {
    	jQuery(this).Draggable({
    		zIndex: 99998000,
    		helper: "clone",
    		delay: 100,
    		distance: 20,
    		ghosting: true,
    		opacity:	0.8,
    		revert: true,
    		onStart: function(drag) {
    			jQuery(this).parent().css("cursor", "move");
    			jQuery(this).attr("style", "cursor:move");
					jQuery(".cadre-composant").each(function(i, composant) {jQuery(this).attr("style","display:block;border:1px dotted orange;left:-1px;top:-1px;min-height:15px;margin-bottom:5px;");});
				},
    		onStop: function(drag) {
    			jQuery(this).css("cursor", "");
					//jQuery(".cadre-composant").each(function(i, composant) {jQuery(this).attr("style","");});
				}
			});
  	}
  );
  jQuery(".cadre-composant").Droppable({
  	accept: "type_pinceau",
		activeclass: "ctlWidget_droppable_active",
		hoverclass: "ctlWidget_droppable_over",
		onHover: function(drag) {
			var dropid = jQuery(this).attr("id");
			var c = jQuery(drag).attr("class");
			c = c.match(/\b\w+-(\w+)-(\d+)\b/);
			var com = c[1];
			var nic = c[2];
			window.status =  com + " " + nic + " => " + dropid + " doesn\'t work, yet : drag/drop is still under development !!!";
		}
	});
  try {init_palette();}
  catch(e) {}
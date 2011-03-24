function loadPictos(map, urlPictos, idmap, msg) {
  var bbox = map.getExtent();
  bbox.transform(map.projection, map.displayProjection);
  var markerMgr = eval('markers'+idmap);
  var zoom = map.getZoom();
  if(zoom>=2) {
  	zoom = zoom - 2;
  }
	if (jQuery("#attente" + idmap).is(":hidden")) {
		jQuery("#attente" + idmap).show();
	}
	jQuery.ajax({
		url: urlPictos,
		dataType: "json",
		data: 'minlat=' + bbox.bottom + '&maxlat=' + bbox.top + '&minlon=' + bbox.left + '&maxlon=' + bbox.right,
		success: function(data) {
			var nb = data.pictos.length;
			for (var i=0;i<nb;i++) {
				addPicto(data.pictos[i], markerMgr, map);
			}
		},
		complete: function() {
			jQuery("#attente" + idmap).hide();
		}
	});
}

function addPicto(item, markerLayer, map) {
	if ((typeof(item.lat) == "undefined")||(typeof(item.lon) == "undefined")) return;
	else {
		var popup = null;
		var lat = parseFloat(item.lat);
		var lng = parseFloat(item.lon);
		var point = new OpenLayers.LonLat(lng,lat);    
    var i = item.icon;
    if (typeof i.image != "undefined") {
	    var img = i.image;
	    var imgW = parseInt(i.imageWidth);
	    var imgH = parseInt(i.imageHeight);
    }
    else {
	    var img = MarkerImgBase;
	    var imgW = MarkerBaseWidth;
	    var imgH = MarkerBaseHeight;
    }
    var size = new OpenLayers.Size(imgW,imgH);
    var offset = function(size) { return new OpenLayers.Pixel(-size.w/2, -size.h/2); };
    var icon = new OpenLayers.Icon(
    	img,
      size,
      null,
      offset
    );
    var html = '<div class="bulle"><p class="titre"><a href="' + item.url + '">' + item.title + '</a></p><div id="pa' + item.id + '"><img src="" /></div></div>';
		var marker = new OpenLayers.Marker(point.fromDataToDisplay(), icon);
		jQuery(marker.icon.imageDiv).attr("title", item.title);
		marker.events.register("click", marker, function click(evt) {
      if (popup == null) {
        popup = new OpenLayers.Popup.FramedCloud("popup" + item.id, point.fromDataToDisplay(), new OpenLayers.Size(300,200), html, undefined, true);
        popup.autoSize = false;
        popup.contentDisplayClass = "ccPopup";
        map.addPopup(popup);
        jQuery.ajax({
        	url: item.urlajax,
        	success: function(data) {
        		jQuery("#pa" + item.id).html(data);
        	},
        });        
      } else {
        popup.toggle();
      }
      OpenLayers.Event.stop(evt);
    });
		marker.events.register("mouseover", marker, function onmouseover(evt) {
      jQuery(marker.icon.imageDiv).css("cursor", "pointer");
      OpenLayers.Event.stop(evt);
    });
 		marker.events.register("mouseout", marker, function onmouseout(evt) {
      jQuery(marker.icon.imageDiv).css("cursor", "");
      OpenLayers.Event.stop(evt);
    });
		markerLayer.addMarker(marker);
	}	
}
function ahah(url, target, delay) {
  // afficher la roue ajax dans le premier <span> du <div> cible.
  //document.getElementById(target).getElementsByTagName('SPAN')[0].innerHTML = '<div style="position:absolute;z-index:10;"><img src="ecrire/img_pack/searching.gif" alt="Waiting..." /></div>';
  $('#'+target).each(function(){
		var group=this;
		var s= $('.waiting',group).get(0);
		s.innerHTML = '<div style="position:absolute;z-index:10;"><img src="ecrire/img_pack/searching.gif" alt="Waiting..." /></div>';
  });
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (req != undefined) {
    req.onreadystatechange = function() {ahahDone(url, target, delay);};
    req.open("GET", url, true);
    req.send("");
  }
}  

function ahahDone(url, target, delay) {
  if (req.readyState == 4) { // only if req is "loaded"
    if (req.status == 200) { // only if "OK"
      document.getElementById(target).innerHTML = req.responseText;
    } else {
      document.getElementById(target).innerHTML="ahah error:\n"+req.statusText;
    }
    if (delay != undefined) {
       setTimeout("ahah(url,target,delay)", delay); // resubmit after delay
	    //server should ALSO delay before responding
    }
  }
}


function ahahform(url,target) {
	var getstr = "?";
	$('#'+target).each(function(){
		var group=this;
		$('input',group).each(function(){
			if ((this.type == "text") || (this.type == "hidden"))
				getstr += this.name + "=" + encodeURIComponent(this.value) + "&";
			if (this.type == "checkbox")
				if (this.checked)
					getstr += this.name + "=" + encodeURIComponent(this.value) + "&";
				else
					getstr += this.name + "=&";
			if (this.type == "radio")
				if (this.checked)
					getstr += this.name + "=" + encodeURIComponent(this.value) + "&";
		});
		$('select',group).each(function(){
			getstr += this.name + "=" + encodeURIComponent(this.value) + "&";
		});
	});
  ahah(url+getstr+'action=fragment&fragment='+target, target);
}

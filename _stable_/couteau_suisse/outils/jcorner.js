jQuery.fn.jc_ajouter_parent = function(color, padding, margin) {
	color = ((typeof color=='undefined') || (color==''))?'':(' background-color:'+color+';');
	if ((typeof padding=='undefined') || (padding=='')) padding = '4px';
	if ((typeof margin=='undefined') || (margin=='')) margin = '4px 0';
	return this.wrap('<div class="jc_parent" style="padding:'+padding+';'+color+' margin:'+margin+';"></div>');
};
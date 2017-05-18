
function _getComputedTranslateX(obj)
{
    var transform = $(obj).css("transform");
    var mat = transform.match(/^matrix3d\((.+)\)$/);
    if(mat) return parseFloat(mat[1].split(', ')[12]);
    mat = transform.match(/^matrix\((.+)\)$/);
    return mat ? parseFloat(mat[1].split(', ')[4]) : 0;
}


function activer_porfolio_slide() {

	$(".portfolio_slide").on("touchstart MSPointerDown pointerdown", function(e) {
		var event = e.originalEvent;
		if (event.pointerType && (event.pointerType == event.MSPOINTER_TYPE_MOUSE || event.pointerType == "mouse" )) return;

		this.pos_gauche_init = event.pageX || event.targetTouches[0].pageX;
		this.pos_gauche = this.pos_gauche_init;
		$(this).addClass("notrans");
		this.margin_left_init = _getComputedTranslateX(this);		
		
	}).on("touchmove MSPointerMove pointermove", function(e) {
		var event = e.originalEvent;
		if (event.pointerType && (event.pointerType == event.MSPOINTER_TYPE_MOUSE || event.pointerType == "mouse" )) return;
		//event.preventDefault();

		this.pos_gauche = event.pageX || event.targetTouches[0].pageX;

		if (Math.abs(this.pos_gauche - this.pos_gauche_init) > 50 ) {
			event.preventDefault();
		}


		var decal = this.margin_left_init + this.pos_gauche - this.pos_gauche_init;
		
			$(this).css("transform", "translate3d("+ decal +"px, 0,0)");
		
	}).on("touchend MSPointerUp pointerup", function(e) {
		var event = e.originalEvent;
		if (event.pointerType && (event.pointerType == event.MSPOINTER_TYPE_MOUSE || event.pointerType == "mouse" )) return;

		$(this).removeClass("notrans").css("transform", "");

		if (Math.abs(this.pos_gauche - this.pos_gauche_init) > 50 ) {
			event.preventDefault();
	
			if (this.pos_gauche > this.pos_gauche_init - 50) {
				$(this).parent(".portfolio_slide_container").find(".portfolio_slide_radio:checked").prev(".portfolio_slide_radio").click();
			} else {
				$(this).parent(".portfolio_slide_container").find(".portfolio_slide_radio:checked").next(".portfolio_slide_radio").click();
			}
		}

	});

}


$(document).ready( activer_porfolio_slide );

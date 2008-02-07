$(document).ready(function(){

	$("#text_area").parent().append("<div style='float:right;margin-top:10px' id='div_result'></div><input id='autosave' type='submit' name='autosave' value='sauvegarder'>").keypress(function(){
	
	$("#autosave").removeAttr("disabled");
	if(typeof autosave !== 'undefined')
		clearTimeout(autosave);
	autosave = setTimeout(saveauto,5000);
	
	});


	$('#autosave').click(saveauto);


});

saveauto = function(e){
//console.log(e.type);

var automatiquement = '' ;

if(typeof autosave !== 'undefined')
		clearTimeout(autosave);
		
if(e.type !== undefined){
	e.preventDefault();
}else{
	automatiquement = 'automatiquement' ;
}	

var titre = $("form[@name='formulaire'] input[@name='titre']").val();
var text_a_sauver = $("#text_area").val() ;
var arg = $("form[@name='formulaire'] input[@name='arg']").val();
var id_parent = $("form[@name='formulaire'] input[@name='id_parent']").val();

url = './?exec=autosave' ;

$.ajax({
   type: "POST",
   url: url,
   dataType: "json",
   data: "texte="+text_a_sauver+"&arg="+arg+"&id_parent="+id_parent+"&titre="+titre,
   success: function(msg){

   $("form[@name='formulaire'] input[@name='arg']").val(msg.id_article);
   $("form[@name='formulaire'] input[@name='hash']").val(msg.hash);
     $("#div_result").html("sauvegard&eacute; "+ automatiquement +" &agrave; " + msg.date);
     $("#autosave").attr("disabled","disabled");
   }
 });

}
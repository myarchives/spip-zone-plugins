<?php

include_spip('tcpdf/pdfLibForSpip');

function spip2pdf_ajouter_image(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());

	(array_key_exists('fichier', $args))
		?$file=$args['fichier']
		:$file="";
	(array_key_exists('x', $args))
		?$x=$args['x']
		:$x=-1;
	(array_key_exists('y', $args))
		?$y=$args['y']
		:$y=-1;
	(array_key_exists('taille', $args))
		?$w=$args['taille']
		:$w=0;
	(array_key_exists('hauteur', $args))
		?$h=$args['hauteur']
		:$h=0;
	(array_key_exists('type', $args))
		?$type=$args['type']
		:$type="";
	(array_key_exists('lien', $args))
		?$link=$args['lien']
		:$link="";
	(array_key_exists('aligner', $args))
		?$align=$args['aligner']
		:$align="";

	if($x == -1){
		$x = $pdf->GetX();
	}
	if($y == -1){
		$y = $pdf->GetY();
	}

	$pdf->Image(K_PATH_IMAGES.$file,$x,$y,$w,$h,$type,$link,$align);
}


function spip2pdf_ln(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	if(!isset($args['hauteur'])){
		$pdf->ln('');
	}else{
		$pdf->ln($args['hauteur']);
	}
}

function spip2pdf_cellule(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	(array_key_exists('largeur', $args))
		?$width=$args['largeur']
		:$width=0;
	(array_key_exists('hauteur', $args))
		?$height=$args['hauteur']
		:$height=5;
	(array_key_exists('texte', $args))
		?$txt=$args['texte']
		:$txt="";
	(array_key_exists('bordure', $args))
		?$border=$args['bordure']
		:$border=0;
	(array_key_exists('a_la_ligne', $args))
		?$ln=$args['a_la_ligne']
		:$ln=0;
	(array_key_exists('aligner', $args))
		?$align=$args['aligner']
		:$align="left";
	(array_key_exists('remplir', $args))
		?$fill=$args['remplir']
		:$fill=0;
	(array_key_exists('lien', $args))
		?$link=$args['lien']
		:$link="";
	(array_key_exists('etendre', $args))
		?$stretch=$args['etendre']
		:$stretch="";

	$pdf->Cell($width,$height,$txt,$border,$ln,$align,$fill,$link,$stretch);
}

function spip2pdf_draw_color(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	if($args['couleur']){
		$couleur = $args['couleur'];
		$rgb = $pdf->colorTxt2ArrayRGB($couleur);
		$pdf->SetDrawColor($rgb['R'],$rgb['G'],$rgb['B']);
	}
}

function spip2pdf_fill_color(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	if($args['couleur']){
		$couleur = $args['couleur'];
		$rgb = $pdf->colorTxt2ArrayRGB($couleur);
		$pdf->SetFillColor($rgb['R'],$rgb['G'],$rgb['B']);
	}
}

function spip2pdf_text_color(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	if($args['couleur']){
		$couleur = $args['couleur'];
		$rgb = $pdf->colorTxt2ArrayRGB($couleur);
		$pdf->SetTextColor($rgb['R'],$rgb['G'],$rgb['B']);
	}
}

function spip2pdf_lang_dir(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());

	if($args['dir']){
		if($args['dir']=='rtl'){
			$pdf->setRTL(true);
		}else{
			$pdf->setRTL(false);
		}
	}
}

function spip2pdf_multi_cellule(){
	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	(array_key_exists('largeur', $args))
		?$width=$args['largeur']
		:$width=0;
	(array_key_exists('hauteur', $args))
		?$height=$args['hauteur']
		:$height=5;
	(array_key_exists('texte', $args))
		?$txt=$args['texte']
		:$txt="";
	(array_key_exists('bordure', $args))
		?$border=$args['bordure']
		:$border=0;
	(array_key_exists('a_la_ligne', $args))
		?$ln=$args['a_la_ligne']
		:$ln=0;
	(array_key_exists('aligner', $args))
		?$align=$args['aligner']
		:$align="left";
	(array_key_exists('remplir', $args))
		?$fill=$args['remplir']
		:$fill=0;

	$pdf->MultiCell($width,$height,$txt,$border,$align,$fill,$ln);
}

function spip2pdf_write_html(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('texte', $args))
		?$texte=$args['texte']
		:$texte="";
	(array_key_exists('aligner', $args))
		?$aligner=$args['aligner']
		:$aligner="justify";
	$pdf->writeSpipContent($texte,$aligner);
}

function spip2pdf_page(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	$pdf->AddPage($args);
}

function spip2pdf_addFont(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('nom',$args))?$fontName=$args['nom']:$fontName = PDF_FONT_NAME_MAIN;
	(array_key_exists('style',$args))?$fontStyle=$args['style']:$fontStyle = '';
	(array_key_exists('taille',$args))?$fontSize=$args['taille']:$fontSize = 0;
	$pdf->setFont($fontName,$fontStyle,$fontSize);
}

function spip2pdf_font(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('nom',$args))?$fontName=$args['nom']:$fontName = $pdf->FontFamily;
	(array_key_exists('style',$args))?$fontStyle=$args['style']:$fontStyle = $pdf->FontStyle;
	(array_key_exists('taille',$args))?$fontSize=$args['taille']:$fontSize = $pdf->FontSizePt;
	if(array_key_exists('couleur',$args)){
		$couleur = $args['couleur'];
		$array_rgb = $pdf->colorTxt2ArrayRGB($couleur);
		$pdf->SetTextColor($array_rgb['R'],$array_rgb['G'],$array_rgb['B']);
	}
	$pdf->setFont($fontName,$fontStyle,$fontSize);
}

function spip2pdf_header_logo(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());

	(array_key_exists('logo', $args))
		?$logo=$args['logo']
		:$logo=PDF_HEADER_LOGO;
	(array_key_exists('aligner', $args))
		?$aligner=$args['aligner']
		:$aligner=PDF_HEADER_ALIGN;
	(array_key_exists('taille', $args))
		?$taille=$args['taille']
		:$taille=PDF_HEADER_LOGO_WIDTH;



	$pdf->setHeaderLogo($logo, $aligner, $taille);
}

function spip2pdf_liens(){
	global $pdf;
	global $visiteur_session;

	$args = obtenir_assoc_arguments(func_get_args());

	if( $args['squelette'] && $args['fichier']){
		$squelette = $args['squelette'];
		$fichier = $args['fichier'];
		$links = "";
		$pdf_exist = false;
		//does the file exist ?
		$file_exist = file_exists(_DIR_PDF.$fichier);
		if($file_exist){
			$links .= ' <a class="pdf_file" href="'._DIR_PDF.$fichier.'">'._T('spip2pdf:download').'</a> ';
			$pdf_exist = true;
		}else{
			//if the guy is admin no point to repropose to generate
			if(!$visiteur_session)
			{
				$links .= ' <a class="pdf_file" href="'.generer_url_public($squelette).'&var_mode=calcul">'._T('spip2pdf:download').'</a> ';
				$pdf_exist = false;
			}
		}
		if ($visiteur_session AND $visiteur_session['statut']=="0minirezo"){
			$links .= ' <a class="pdf_generate" href="'.generer_url_public($squelette).'">'._T('spip2pdf:generate').'</a> ';
		}
		return $links;
	}else{
		$pdf->Error("'squelette' or 'fichier' parameter is missing I can't generate the link");
	}

}

function spip2pdf_header(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	(array_key_exists('texte', $args))?$texte=$args['texte']
		:$texte=PDF_HEADER_LABEL;
	(array_key_exists('font', $args))?$font=$args['font']
		:$font=PDF_HEADER_FONT;
	(array_key_exists('style', $args))?$style=$args['style']
		:$style=PDF_HEADER_FONT_STYLE;
	(array_key_exists('taille', $args))?$size=$args['taille']
		:$size=PDF_HEADER_FONT_SIZE;
	(array_key_exists('aligner', $args))?$aligner=$args['aligner']
		:$aligner=PDF_HEADER_ALIGN;
	(array_key_exists('couleur', $args))?$couleur=$args['couleur']
		:$couleur=PDF_HEADER_COLOR;
	(array_key_exists('bordure', $args))?$bordure=$args['bordure']
		:$bordure='';
	(array_key_exists('marge', $args))?$marge=$args['marge']
		:$pdf->setHeaderMargin(PDF_HEADER_MARGIN);

	$pdf->setHeaderProperties($marge,0);


	$pdf->setHeaderTitle(
		$texte,
		$font,
		$style,
		$couleur,
		$size,
		$aligner
	);

}

function spip2pdf_header_text(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('texte', $args))
		?$texte=$args['texte']
		:$texte=PDF_HEADER_TXT_LABEL;
	(array_key_exists('font', $args))
		?$font=$args['font']
		:$font=PDF_HEADER_TXT_FONT;
	(array_key_exists('style', $args))
		?$style=$args['style']
		:$style=PDF_HEADER_TXT_FONT_STYLE;
	(array_key_exists('taille', $args))
		?$size=$args['taille']
		:$size=PDF_HEADER_TXT_FONT_SIZE;
	(array_key_exists('aligner', $args))
		?$aligner=$args['aligner']
		:$aligner=PDF_HEADER_TXT_ALIGN;
	(array_key_exists('couleur', $args))
		?$couleur=$args['couleur']
		:$couleur=PDF_HEADER_TXT_COLOR;

	$pdf->setHeaderString(
		$texte,
		$font,
		$style,
		$couleur,
		$size,
		$aligner
	);

}

function spip2pdf_desactive_header(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	$pdf->print_header = false;

}

function spip2pdf_reactive_header(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	$pdf->print_header = true;

}

function obtenir_assoc_arguments($args){
	$tab_arg = array();
	foreach ($args as $arg){
		$t_arg = explode("=",$arg,2);
		$tab_arg[$t_arg[0]] = str_replace("'",'',$t_arg[1]);
	}
	return $tab_arg;
}

function spip2pdf_sortir_document(){
	global $pdf;
	$pdf->Output($pdf->outputFile);
}

function spip2pdf_multicol(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('nombre', $args))?$nombre = $args['nombre']:$largeur=PDF_MULTICOL_NUMBER;
	(array_key_exists('espacement', $args))?$espacement = $args['espacement']:$espacement=PDF_MULTICOL_SPACE;
	$pdf->multiColumn($nombre-1,$espacement);
}

function spip2pdf_setXY(){
	global $pdf;
	$args = obtenir_assoc_arguments(func_get_args());
	(array_key_exists('x', $args))?$x = $args['x']:$x=$pdf->GetX();
	(array_key_exists('y', $args))?$y = $args['y']:$y=$pdf->GetY();
	$pdf->SetXY($x,$y);
}


function spip2pdf_creer(){

	global $pdf;

	$args = obtenir_assoc_arguments(func_get_args());

	$pdf = new PDF_FOR_SPIP	(PDF_PAGE_ORIENTATION, PDF_DOCUMENT_UNIT, PDF_PAGE_FORMAT, true,"UTF-8");

	$pdf->debug = false;

	//$pdf->debug = true;

	//manage margin definition
	$marges = PDF_MARGINS;
	if($args['marges']){
		$marges = $args['marges'];
	}
	$marges_array = explode(" ",$marges);
	if(count($marges_array)==2){
		$left_margin 	= $marges_array[0];
		$top_margin 	= $marges_array[1];
		$right_margin 	= $marges_array[0];
	}elseif(count($marges_array)==3){
		$left_margin 	= $marges_array[0];
		$top_margin 	= $marges_array[1];
		$right_margin 	= $marges_array[2];
	}else{
		$pdf->Error("The magins definition is incorrect it should be something like 10 20 or 10 20 20");
	}
	$pdf->SetMargins($left_margin,$top_margin,$right_margin);


	//manage file name definition
	$fileName = PDF_OUTPUTFILE;
	if($args['fichier']){
		$fileName = $args['fichier'];
	}
	$pdf->outputFile = _DIR_PDF . $fileName;


	//create the PDF directory if needed
	if(!is_dir(_DIR_PDF)){
		$rights = 0777;
		if(!@mkdir(_DIR_PDF, $rights)){
			$pdf->Error("Can't create folder \""._DIR_PDF."\"");
		}
	}


	//properties of the file
	$doc_title = PDF_TITLE;
	if($args['doc_titre']){
		$doc_title = $args['doc_titre'];
	}
	$doc_subject = PDF_SUBJECT;
	if($args['doc_sujet']){
		$doc_subject = $args['doc_sujet'];
	}
	$doc_keywords = PDF_KEYWORDS;
	if($args['doc_mot_cles']){
		$doc_keywords = $args['doc_mot_cles'];
	}
	$doc_autor = PDF_AUTOR;
	if($args['doc_auteur']){
		$doc_autor = $args['doc_auteur'];
	}
	$pdf->setProperties(PDF_CREATOR, $doc_autor, $doc_title, $doc_subject, $doc_keywords);

	//should  be redefine by the header functions
	$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	//Will be overriden hy header function
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	//TODO set it up with PDF_MARGIN_BOTTOM
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	//set language items
	//TODO How let the spip webmaster override this ?
	$pdf->setLanguageArray($l);

	//can be redefined in SPIP Balises
	$pdf->multiColumn(2,5);

	//initialize document
	$pdf->AliasNbPages();
}

/*
 * Strip the html code of images inside a text.
 *
 * @param $texte the texte on which we want to strip the image
 * @return $texte the texte with images striped
 */
function spip2pdf_supprimer_images($texte){
	$pattern = array('/<img[^>]*>/i');
	$replacement = array("");
	return preg_replace($pattern,$replacement,$texte);
}

function init_balise_param($p){
	if ($p->param && !$p->param[0][0]) {
		for($i=1; $i<count($p->param[0]);$i++){
			$param[$i] = calculer_liste($p->param[0][$i],
			$p->descr,
			$p->boucles,
			$p->id_boucle);
		}
	}
	return $param;
}
?>
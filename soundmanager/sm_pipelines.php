<?php

function sm_insert_head($flux){

	return $flux;
}


// Ajouter soundmanager s'il n'y est pas déjà et qu'on a des enclosures dans la page
function sm_affichage_final($page) {
	if (!strpos($page, 'script/soundmanager2.js')){
		if(strpos($page, 'rel="enclosure"')  OR strpos($page, "rel='enclosure'") AND $GLOBALS['html']){
						
			$script .= "\n"."<script type=\"text/javascript\" src=\"" . find_in_path('script/soundmanager2.js') . "\"></script>"."\n";
			$script .= "<script type=\"text/javascript\" src=\"" . find_in_path('multimedia.js') . "\"></script>"."\n";
			$script .= "<link rel='stylesheet' href='" . generer_url_public('soundmanager.css') . "' type='text/css' media='projection, screen, tv' />"."\n";
			
			$page = substr_replace($page, $script, strpos($page, '</head>'), 0);
		}

		if(strpos($page, 'class="ui360')  OR strpos($page, "class='ui360") AND $GLOBALS['html']){					
			$script .= "<link rel='stylesheet' href='" . find_in_path('360-player/360player.css') . "' type='text/css' />"."\n";
			$script .= "<link rel='stylesheet' href='" . find_in_path('360-player/360player-visualization.css') . "' type='text/css' />"."\n";

			$script .= "\n"."<script type=\"text/javascript\" src=\"" . find_in_path('360-player/script/berniecode-animator.js') . "\"></script>"."\n";
			$script .= "\n"."<script type=\"text/javascript\" src=\"" . find_in_path('script/soundmanager2.js') . "\"></script>"."\n";
			
			$script .= "\n". "<!-- special IE-only canvas fix -->" . "\n". "<!--[if IE]><script type=\"text/javascript\" src=\"" . find_in_path('360-player/script/excanvas.js') . "\"></script><![endif]-->"."\n";
			$script .= "\n"."<script type=\"text/javascript\" src=\"" . find_in_path('360-player/script/360player.js') . "\"></script>"."\n";
		
			
$str = <<<EOD
<script type="text/javascript">

soundManager.setup({
	  url: '/plugins/soundmanager/swf/',
	  flashVersion: 9, // optional: shiny features (default = 8)
	  useFlashBlock: false, // optionally, enable when you're ready to dive in
	  debugMode: false
});

threeSixtyPlayer.config.scaleFont = (navigator.userAgent.match(/msie/i)?false:true);
threeSixtyPlayer.config.showHMSTime = true;

// enable some spectrum stuffs

threeSixtyPlayer.config.useWaveformData = true;
threeSixtyPlayer.config.useEQData = true;

// enable this in SM2 as well, as needed

if (threeSixtyPlayer.config.useWaveformData) {
  soundManager.flash9Options.useWaveformData = true;
}
if (threeSixtyPlayer.config.useEQData) {
  soundManager.flash9Options.useEQData = true;
}
if (threeSixtyPlayer.config.usePeakData) {
  soundManager.flash9Options.usePeakData = true;
}

if (threeSixtyPlayer.config.useWaveformData || threeSixtyPlayer.flash9Options.useEQData || threeSixtyPlayer.flash9Options.usePeakData) {
  // even if HTML5 supports MP3, prefer flash so the visualization features can be used.
  soundManager.preferFlash = true;
}

</script>
EOD;

			$script .= "\n" . $str ."\n";
			
			$page = substr_replace($page, $script, strpos($page, '</head>'), 0);
		}

	}
	return $page;
}


 /**
 * Ajout d'un rel="enclosure" sur les liens mp3.
 * Permet de traiter les [mon son->http://monsite/mon_son.mp3] dans un texte.
 * Le filtre peut etre appele dans un squelette apres |liens_absolus
 *
 * Pete cependant dans les cas (tordus) suivants :
 * [{{Une histoire d'amour}}->documents/sons/PIRATAGE/01 UNE HISTOIRE D'AMOUR.mp3]
 * [{{Une histoire d'amour à trois}}->documents/sons/PIRATAGE/02 UNE HISTOIRE D'AMOUR A TROIS[2].mp3]
 *
 */

function sm_pre_liens($texte) {
	
	define('_RACCOURCI_LIEN_MP3', "/\[([^][]*?([[]\w*[]][^][]*)*)->(>?)([^]]*\.mp3)\]/msS");
	
	if (preg_match_all(_RACCOURCI_LIEN_MP3, $texte, $regs, PREG_SET_ORDER)) {

		foreach ($regs as $k => $reg) {
			if($reg[1]){
				$l = "<a href='$reg[4]' rel='enclosure'>$reg[1]</a>";
			}else{
				$l = "<a href='$reg[4]' rel='enclosure'>".couper($reg[4],50)."</a>";
			}
			$p = $reg[0];
			$texte = str_replace($p,$l,$texte);
		} 
	}

	return $texte;
}

//
function sm_styliser($flux){
	
	return $flux;
}


<?php
// insert le css et le js externes pour l'�chiquier dans le <head> du document (#INSERT_HEAD)
function chess_insert_head($flux)
{
	$metacfg = array(
		'selector' => '#contenu .texte',
		'cssFile' => 'chess',
		'imgPath' => 'images/wk.png',

	);
	
	$selector = $metacfg['selector'];
	$jsFile = generer_url_public('chess.js');
	$cssFile = generer_url_public($metacfg['cssFile'].'.css');
	$imgPath = dirname(find_in_path($metacfg['imgPath']));

	$incHead = <<<EOH
<!-- link rel="stylesheet" href="$cssFile" type="text/css" media="all" / -->
<script src="$jsFile" type="text/javascript"></script>
<script type="text/javascript">
	if(!window.$)window.$ = function(e) { return document.getElementById(e); };
	function showDetails(gameDetails){
		// when called from callback event, gameDetails will contain information about the game.
		document.getElementById('moveTab').style.display='block';
		document.getElementById('gameList').style.display='none';
		document.getElementById('pgnList').style.display='none';
		document.getElementById('tabDetails').className = 'tabActive';
		document.getElementById('tabGames').className = 'tabInactive';
		document.getElementById('tabPgns').className = 'tabInactive';
	}
	function showGames()
	{
		document.getElementById('moveTab').style.display='none';
		document.getElementById('pgnList').style.display='none';
		document.getElementById('gameList').style.display='block';
		document.getElementById('tabGames').className = 'tabActive';
		document.getElementById('tabDetails').className = 'tabInactive';		
		document.getElementById('tabPgns').className = 'tabInactive';
	}
	function showPgns()
	{
		document.getElementById('moveTab').style.display='none';
		document.getElementById('gameList').style.display='none';
		document.getElementById('pgnList').style.display='block';
		document.getElementById('tabGames').className = 'tabInactive';
		document.getElementById('tabDetails').className = 'tabInactive';		
		document.getElementById('tabPgns').className = 'tabActive';		
		
	}

	function guessedWrongMove()
	{	
		alert('sorry - that move was wrong');
		
	}
	
	function correctMove()
	{
		
		
	}
	
	$(document).ready(function(){
		$("#mainContainer").dblclick(function(){
		return false;
		});
	});
	
	document.onkeyup = KeyCheck;
	function KeyCheck(e){
		var keyID = (window.event) ? event.keyCode : e.keyCode;
		
		switch(keyID){
			case 37:
				chessObj.move(-1);
				break;
			case 39:
				chessObj.move(1);
				break;
			}
		};

</script >
EOH;

	return preg_replace('#(</head>)?$#i', $incHead . "\$1\n", $flux, 1);
}

function chess_header_prive($flux) {
//    $flux .= "<link rel='stylesheet' type='text/css' href='".generer_url_public('chess.css')."' />";
	$flux .= "<script src='".generer_url_public('chess.js')."' type='text/javascript'></script>" . "\n";
    return $flux;
}

	
?>

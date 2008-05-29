<?php

/*
 * convert a string to a 32-bit integer
 */
function PB_PR_StrToNum($Str, $Check, $Magic)
{
    $Int32Unit = 4294967296;  // 2^32

    $length = strlen($Str);
    for ($i = 0; $i < $length; $i++) {
        $Check *= $Magic; 	
        //If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31), 
        //  the result of converting to integer is undefined
        //  refer to http://www.php.net/manual/en/language.types.integer.php
        if ($Check >= $Int32Unit) {
            $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
            //if the check less than -2^31
            $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
        }
        $Check += ord($Str{$i}); 
    }
    return $Check;
}

/* 
 * Genearate a hash for a url
 */
function PB_PR_HashURL($String)
{
    $Check1 = PB_PR_StrToNum($String, 0x1505, 0x21);
    $Check2 = PB_PR_StrToNum($String, 0, 0x1003F);

    $Check1 >>= 2; 	
    $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
    $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
    $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);	
	
    $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
    $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
	
    return ($T1 | $T2);
}

/* 
 * genearate a checksum for the hash string
 */
function PB_PR_CheckHash($Hashnum)
{
    $CheckByte = 0;
    $Flag = 0;

    $HashStr = sprintf('%u', $Hashnum) ;
    $length = strlen($HashStr);
	
    for ($i = $length - 1;  $i >= 0;  $i --) {
        $Re = $HashStr{$i};
        if (1 === ($Flag % 2)) {              
            $Re += $Re;     
            $Re = (int)($Re / 10) + ($Re % 10);
        }
        $CheckByte += $Re;
        $Flag ++;	
    }

    $CheckByte %= 10;
    if (0 !== $CheckByte) {
        $CheckByte = 10 - $CheckByte;
        if (1 === ($Flag % 2) ) {
            if (1 === ($CheckByte % 2)) {
                $CheckByte += 9;
            }
            $CheckByte >>= 1;
        }
    }

    return '7'.$CheckByte.$HashStr;
}

function pb_getpagerank($url) {

	$query = spip_query("SELECT *  FROM `spip_meta` WHERE `nom` = 'pagerank' AND `maj` > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
	
	if ($row = spip_fetch_array($query)) {
		$pagerank = $row["valeur"];
		return $pagerank;
	}

	$fp = fsockopen("toolbarqueries.google.com", 80, $errno, $errstr, 30);
	if (!$fp) {
   		return '';
	} else {
		$out = "GET /search?client=navclient-auto&ch=".PB_PR_CheckHash(PB_PR_HashURL($url))."&features=Rank&q=info:".$url."&num=100&filter=0 HTTP/1.1\r\n";
		$out .= "Host: toolbarqueries.google.com\r\n";
		$out .= "User-Agent: Mozilla/4.0 (compatible; GoogleToolbar 2.0.114-big; Windows XP 5.1)\r\n";
		$out .= "Connection: Close\r\n\r\n";
	
		fwrite($fp, $out);
	   
		//$pagerank = substr(fgets($fp, 128), 4);
		//echo $pagerank;
		while (!feof($fp)) {
			$data = fgets($fp, 128);
			$pos = strpos($data, "Rank_");
			if($pos === false){} else{
				$pagerank = substr($data, $pos + 9);

		   		include_spip("inc/metas");
		   		ecrire_meta('pagerank', $pagerank);
		   		ecrire_metas();


				return $pagerank;
			}
	   	}
   		fclose($fp);
	}
}





	function pb_pagerank_interface ( $vars="" ) {
		$exec = $vars["args"]["exec"];
		$id_rubrique = $vars["args"]["id_rubrique"];
		$id_article = $vars["args"]["id_article"];
		$data =	$vars["data"];
		
		$ret = "";
		
		if ($exec == "accueil") {
			
			$url_site = lire_meta("adresse_site");
			
			$pagerank = pb_getpagerank($url_site);
//			$pagerank = 10;
			
			for ($i=1;  $i <= $pagerank; $i ++) {
				$pr .= "<div style='width: 6px; margin-right: 1px; height: 6px; background-color: green; float: left;'></div>";
			}	
				
				$ret .= debut_cadre_enfonce("", true);
				$ret .= "<div style='padding-left: 60px;'>";
				$ret .= "<div class='verdana1'>PageRank : <b style='color: red;'>$pagerank</b></div>";
				$ret .= "<div style='margin-top: 3px; border: 1px solid #666666; background-color: white; height: 6px; width: 70px; overflow: hidden; padding: 1px; padding-right: 0px; '>$pr</div>";
				$ret .= "</div>";
				$ret .= fin_cadre_enfonce(true);
			
		}


		$data .= $ret;
	
		$vars["data"] = $data;
		return $vars;
	}


?>
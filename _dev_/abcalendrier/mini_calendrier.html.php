#CACHE{0}
<style>
.calendario a{
	font-weight:bold;
	text-decoration:none;
	color:green;
}
	</style>

<?php

    $calendrier_mois=$_GET['calendrier_mois'];
    $calendrier_annee=$_GET['calendrier_annee'];
?>
<div class="rubriques calendario">
<h3 class="menu-titre"><:abcalendrier:agenda:></h3>

					  <?php
$months = array('', _T('spip:date_mois_1'), _T('spip:date_mois_2'), _T('spip:date_mois_3'), _T('spip:date_mois_4'), _T('spip:date_mois_5'), _T('spip:date_mois_6'), _T('spip:date_mois_7'), _T('spip:date_mois_8'), _T('spip:date_mois_9'), _T('spip:date_mois_10'), _T('spip:date_mois_11'), _T('spip:date_mois_12'));
$days = array(substr(_T('spip:date_jour_1_abbr'),0,2), substr(_T('spip:date_jour_2_abbr'),0,2), substr(_T('spip:date_jour_3_abbr'),0,2), substr(_T('spip:date_jour_4_abbr'),0,2), substr(_T('spip:date_jour_5_abbr'),0,2), substr(_T('spip:date_jour_6_abbr'),0,2), substr(_T('spip:date_jour_7_abbr'),0,2));

if ($test_mini_agenda_deja_present!=1) {
function mkdate($month, $day, $year)
{
	return mktime(0, 0, 0, $month, $day, $year);
}

function preparation_URL($texte_URL,$mois_URL,$annee_URL)
    {
    $position = StrPos($texte_URL,"calendrier_mois");
    $texte_remplacement = "calendrier_mois=".$mois_URL."&calendrier_annee=".$annee_URL;
    if ($position!==FALSE)
        {
        $texte_URL = substr_replace ($texte_URL,$texte_remplacement,$position);}
        else  { $presence = StrPos($texte_URL,"?");
                if ($presence==FALSE)
                  {$texte_URL = $texte_URL."?".$texte_remplacement;}
                else
                  {$texte_URL = $texte_URL."&".$texte_remplacement;}
              }
    return $texte_URL;
    }
}
if(isset($GLOBALS['var_nav_month'])) {
	$cal_day = mkdate($GLOBALS['var_nav_month'], 1, $GLOBALS['var_nav_year']);
} else {
	$cal_day = time();
}

$D = intval(date('d', $cal_day));
if (isset($calendrier_mois)) {
$M = $calendrier_mois;
} else {$M = intval(date('m', $cal_day));}
if (isset($calendrier_annee)) {
$Y = $calendrier_annee;
} else {$Y = intval(date('Y', $cal_day));}
$events = array();
$test_mini_agenda_deja_present = 1;
?>


<BOUCLE_evenements(ARTICLES){titre_mot="mini-calendrier"}{annee_redac!=0000}>
	<?php

	$date = ereg_replace("^([0-9]{4})-([0-9]{2})-([0-9]{2}).*$", "\\1\\2\\3", '#DATE_REDAC');
	if ($date > date("Ymd", mkdate($M, $D - 31, $Y)) && $date < date("Ymd", mkdate($M, $D + 31, $Y))) {
		if (!isset($events[$date])) {
			$events[$date] = array();
		}
		$events[$date] = array('link' => '#URL_ARTICLE', 'title' => '[(#TITRE|supprimer_numero|texte_script)]', 'logo' => "");
	}
	$titulo='[(#TITRE|supprimer_numero|texte_script)]';
	?>
</BOUCLE_evenements>
<BOUCLE_breves_evenements(BREVES){titre_mot="mini-calendrier"}>

	<?php
//ooo #EVENTO #TITRE
	$date = ereg_replace("^([0-9]{4})-([0-9]{2})-([0-9]{2}).*$", "\\1\\2\\3", '#EVENTO');
	//echo "$date uuuu";
	if ($date > date("Ymd", mkdate($M, $D - 31, $Y)) && $date < date("Ymd", mkdate($M, $D + 31, $Y))) {
		if (!isset($events[$date])) {
			$events[$date] = array();
		}
		$events[$date] = array('link' => '#URL_BREVE', 'title' => '[(#TITRE|supprimer_numero|texte_script)]', 'logo' => "");
	}
	$titulo='[(#TITRE|supprimer_numero|texte_script)]';
	?>
</BOUCLE_breves_evenements>

		<?php
        $mes = $months [$M];
        if ($M==1){
            $calendrier_mois_moins=12;
            $calendrier_annee_moins=$Y-1;}
        else {
            $calendrier_mois_moins=$M-1;
            $calendrier_annee_moins=$Y;}
        if ($M==12){
            $calendrier_mois_plus=1;
            $calendrier_annee_plus=$Y+1;}
        else {
            $calendrier_mois_plus=$M+1;
            $calendrier_annee_plus=$Y;}

	echo '<ul><li class="un"><center><a href="'.preparation_URL('#SELF',$calendrier_mois_moins,$calendrier_annee_moins).'" title="'._T('abcalendrier:Mois_precedent').'">&lt;&lt;
        </a>&nbsp;&nbsp;'.$mes.' '.$Y.'&nbsp;&nbsp;<a href="'.preparation_URL('#SELF',$calendrier_mois_plus,$calendrier_annee_plus).'" title="'._T('abcalendrier:Mois_suivant').'">
        &gt;&gt;</a></center></li>';
		?>
	</td>
</tr>

<li class="deux"><center><table width="100%" cellpadding="1" cellspacing="0" align="center">

<tr align="center">
	<?php

	for($i = 1; $i < 8; $i++) {
		echo '<th width="14%" >'.$days[$i%7].'</th>';
	}
	$TempD = 1;
	if(date('w', mkdate($M, 1, $Y)) != 1) {
		echo '</tr><tr align="center">';
		$tmp = '';
		while(date('w', mkdate($M, $TempD, $Y)) != 1) {
			$TempD--;
			$case = '<td valign="top" style="font-size:80%;">';
			$case .= date('j', mkdate($M, $TempD, $Y));
			$date = date('Ymd', mkdate($M, $TempD, $Y));

			$case .= '</td>';
			$tmp = $case.$tmp;
		}
		echo $tmp;
	}
	$TempD = 1;
	while((date('m', mkdate($M, $TempD, $Y)) == $M) || (date('w', mkdate($M, $TempD, $Y)) != 1)) {
		if(date('w', mkdate($M, $TempD, $Y)) == 1) {
			echo '</tr><tr align="center">';
		}
		echo '<td  valign="top" style="'.(date('Ymd', mkdate($M, $TempD, $Y)) == date('Ymd') ? 'text-decoration:underline;' : '').' font-size:80%;">';
		$date = date('Ymd', mkdate($M, $TempD, $Y));
		if (isset($events[$date])) {
				echo '<a href="'.$events[$date]['link'].'" title="'.$events[$date]['title'].'" >'. date('j', mkdate($M, $TempD, $Y)) .'</a>';
		}
		else {
		echo date('j', mkdate($M, $TempD, $Y));
		}
		echo '</td>';
		$TempD++;
	}


	?>
</tr>
</table>
</center></li>
<li class="un">

<?php
if (count($events)>0)
{
ksort($events);
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><table width="90%" border="0" cellpadding="0" cellspacing="0" style="font-size:80%;">
        <?php
        $test_boucle=0;
        if($M<10) $Mi = '0'.$M;
        else $Mi = $M;
        for ($i=0;$i<32;$i++)
        {
        	if($i<10) $i='0'.$i;
        	$datai=$Y.$Mi.$i;
        	if(isset($events[$datai]))
        	{
                echo "<tr>
                    <td align=\"left\" valign=\"top\" nowrap > <i>$i-$M</i>: </td>
                    <td width=\"100%\" align=\"left\" valign=\"top\"><a href=\"{$events[$datai][link]}\" >{$events[$datai][title]}</a><br>
                    </td>
                    </tr>";
                $test_boucle++;
            }

        }
          IF ($test_boucle==0) {
          echo "<tr>
                <td width='100%' align='center' valign='top'>"._T('abcalendrier:aucun_evenement')."</td>
                </tr>";
          }?>
        </table></td>
      </tr>
    </table></li></ul>
<?php
}
else
{
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td align="center" valign="top" style="font-size:80%;">
    <:abcalendrier:aucun_evenement:></td>
  </tr>
</table></li></ul>
<?php
}
?>
</div>
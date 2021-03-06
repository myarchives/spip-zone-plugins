<?php
/**
 * Fichier gérant les importations en base de donnée.
 *
 * @plugin     Continents
 * @copyright  2013 - 2020
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Continents\Base
 */
if (!defined("_ECRIRE_INC_VERSION"))
	return;

function continents_definitions() {
	return array(
		array(
			'id_continent' => '1',
			'code_onu' => '2',
			'nom' => '<multi>[fr]Afrique[en]Africa[es]Africa[de]Afrika</multi>',
			'lat' => 0,
			'lon' => '20',
			'zoom' => 3,
			'code_iso_a2' => 'AF',
			'code_iso_a3' => 'AFR'
		),
		array(
			'id_continent' => '2',
			'code_onu' => '3',
			'nom' => '<multi>[fr]Amérique du Nord[en]North America[es]Norteamérica[de]Nordamerika</multi>',
			'lat' => 40,
			'lon' => -100,
			'zoom' => 3,
			'code_iso_a2' => 'NA',
			'code_iso_a3' => 'NAM'
		),
		array(
			'id_continent' => '3',
			'code_onu' => '5',
			'nom' => '<multi>[fr]Amérique du Sud[en]South America[de]Südamerika</multi>',
			'lat' => -20,
			'lon' => -60,
			'zoom' => 3,
			'code_iso_a2' => 'SA',
			'code_iso_a3' => 'SAM'
		),
		array(
			'id_continent' => '4',
			'code_onu' => '142',
			'nom' => '<multi>[fr]Asie[en]Asia[es]Asia[de]Asien</multi>',
			'lat' => 40,
			'lon' => 90,
			'zoom' => 3,
			'code_iso_a2' => 'AS',
			'code_iso_a3' => 'ASA'
		),
		array(
			'id_continent' => '5',
			'code_onu' => '150',
			'nom' => '<multi>[fr]Europe[es]Europa[de]Europa</multi>',
			'lat' => 50,
			'lon' => 20,
			'zoom' => 4,
			'code_iso_a2' => 'EU',
			'code_iso_a3' => 'EUR'
		),
		array(
			'id_continent' => '6',
			'code_onu' => '9',
			'nom' => '<multi>[fr]Océanie[en]Oceania[es]Oceania[de]Ozeanien</multi>',
			'lat' => -30,
			'lon' => 150,
			'zoom' => 4,
			'code_iso_a2' => 'OC',
			'code_iso_a3' => 'OCA'
		),
		array(
			'id_continent' => '7',
			'code_onu' => '',
			'nom' => '<multi>[fr]Antarctique[en]Antarctica[es]Antártida[de]Antarktika</multi>',
			'lat' => -80,
			'lon' => 70,
			'zoom' => 3,
			'code_iso_a2' => 'AQ',
			'code_iso_a3' => 'ATA'
		),
	);
}


function peupler_base_continents() {
	$definitions = continents_definitions();
	sql_insertq_multi('spip_continents', $definitions);
}

function inserer_table_pays() {
	$pays_continent = array(
		'1' => '4',
		'2' => '1',
		'3' => '5',
		'4' => '5',
		'5' => '1',
		'6' => '5',
		'7' => '5',
		'8' => '1',
		'9' => '2',
		'10' => '7',
		'11' => '2',
		'12' => '2',
		'13' => '4',
		'14' => '3',
		'15' => '5',
		'16' => '3',
		'17' => '6',
		'18' => '5',
		'19' => '5',
		'20' => '2',
		'21' => '4',
		'22' => '4',
		'23' => '2',
		'24' => '5',
		'25' => '2',
		'26' => '1',
		'27' => '2',
		'28' => '4',
		'29' => '5',
		'30' => '4',
		'31' => '3',
		'32' => '5',
		'33' => '1',
		'34' => '3',
		'35' => '4',
		'36' => '5',
		'37' => '1',
		'38' => '1',
		'39' => '4',
		'40' => '1',
		'41' => '2',
		'42' => '1',
		'43' => '1',
		'44' => '3',
		'45' => '4',
		'46' => '5',
		'47' => '3',
		'48' => '1',
		'49' => '1',
		'50' => '1',
		'51' => '4',
		'52' => '4',
		'53' => '2',
		'54' => '1',
		'55' => '5',
		'56' => '2',
		'57' => '5',
		'58' => '1',
		'59' => '2',
		'60' => '1',
		'61' => '4',
		'62' => '3',
		'63' => '1',
		'64' => '5',
		'65' => '5',
		'66' => '2',
		'67' => '1',
		'68' => '6',
		'69' => '5',
		'70' => '5',
		'71' => '1',
		'72' => '1',
		'73' => '5',
		'74' => '7',
		'75' => '1',
		'76' => '1',
		'77' => '5',
		'78' => '2',
		'79' => '2',
		'80' => '2',
		'81' => '6',
		'82' => '3',
		'83' => '5',
		'84' => '1',
		'85' => '1',
		'86' => '1',
		'87' => '3',
		'88' => '3',
		'89' => '2',
		'90' => '2',
		'91' => '4',
		'92' => '5',
		'93' => '7',
		'94' => '6',
		'95' => '5',
		'96' => '2',
		'97' => '4',
		'98' => '6',
		'99' => '5',
		'100' => '3',
		'101' => '6',
		'102' => '6',
		'103' => '6',
		'104' => '2',
		'105' => '2',
		'106' => '2',
		'107' => '4',
		'108' => '4',
		'109' => '4',
		'110' => '4',
		'111' => '5',
		'112' => '5',
		'113' => '4',
		'114' => '5',
		'115' => '2',
		'116' => '4',
		'117' => '5',
		'118' => '4',
		'119' => '4',
		'120' => '1',
		'121' => '4',
		'122' => '6',
		'123' => '4',
		'124' => '4',
		'125' => '1',
		'126' => '5',
		'127' => '4',
		'128' => '1',
		'129' => '1',
		'130' => '5',
		'131' => '5',
		'132' => '5',
		'133' => '4',
		'134' => '5',
		'135' => '1',
		'136' => '4',
		'137' => '1',
		'138' => '4',
		'139' => '1',
		'140' => '5',
		'141' => '1',
		'142' => '6',
		'143' => '2',
		'144' => '1',
		'145' => '1',
		'146' => '1',
		'147' => '2',
		'148' => '6',
		'149' => '5',
		'150' => '5',
		'151' => '4',
		'152' => '5',
		'153' => '2',
		'154' => '1',
		'155' => '1',
		'156' => '6',
		'157' => '4',
		'158' => '2',
		'159' => '1',
		'160' => '1',
		'161' => '6',
		'162' => '6',
		'163' => '5',
		'164' => '6',
		'165' => '6',
		'166' => '4',
		'167' => '1',
		'168' => '4',
		'169' => '4',
		'170' => '6',
		'171' => '4',
		'172' => '2',
		'173' => '6',
		'174' => '3',
		'175' => '5',
		'176' => '3',
		'177' => '4',
		'178' => '6',
		'179' => '5',
		'180' => '6',
		'181' => '2',
		'182' => '5',
		'183' => '4',
		'184' => '2',
		'185' => '5',
		'186' => '1',
		'187' => '5',
		'188' => '5',
		'189' => '5',
		'190' => '1',
		'191' => '1',
		'192' => '2',
		'193' => '1',
		'194' => '2',
		'195' => '5',
		'196' => '2',
		'197' => '2',
		'198' => '2',
		'199' => '6',
		'200' => '6',
		'201' => '1',
		'202' => '1',
		'203' => '5',
		'204' => '1',
		'205' => '1',
		'206' => '4',
		'207' => '5',
		'208' => '5',
		'209' => '1',
		'210' => '1',
		'211' => '4',
		'212' => '5',
		'213' => '5',
		'214' => '3',
		'215' => '5',
		'216' => '1',
		'217' => '4',
		'218' => '4',
		'219' => '4',
		'220' => '1',
		'221' => '1',
		'222' => '7',
		'223' => '4',
		'224' => '6',
		'225' => '4',
		'226' => '4',
		'227' => '1',
		'228' => '6',
		'229' => '6',
		'230' => '3',
		'231' => '1',
		'232' => '4',
		'233' => '5',
		'234' => '6',
		'235' => '5',
		'236' => '3',
		'237' => '6',
		'238' => '5',
		'239' => '3',
		'240' => '4',
		'241' => '6',
		'242' => '4',
		'243' => '1',
		'244' => '1'
	);

	foreach ($pays_continent as $id_pays => $id_continent) {
		sql_updateq('spip_pays', array(
			'id_continent' => $id_continent
		), 'id_pays=' . $id_pays);
	}
}

function inserer_codes_iso() {
	$definitions = continents_definitions();
	foreach ($definitions as $id_continent => $codes) {
		sql_updateq(
				'spip_continents',
				array(
					'code_iso_a2' => $codes['code_iso_a2'],
					'code_iso_a3' => $codes['code_iso_a3'],
				),
				'id_continent=' . $id_continent);
	}
}

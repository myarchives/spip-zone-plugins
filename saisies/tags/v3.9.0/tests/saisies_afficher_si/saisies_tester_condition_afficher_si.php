<?php
/**
 * Test unitaire de la fonction saisies_tester_condition_afficher_si
 * du fichier ../plugins/saisies/inc/saisies_afficher.php
 *
 * genere automatiquement par TestBuilder
 * le 2018-12-20 19:31
 */

	$test = 'saisies_tester_condition_afficher_si';
	$remonte = "../";
	while (!is_dir($remonte."ecrire"))
		$remonte = "../$remonte";
	require $remonte.'tests/test.inc';
	find_in_path("../plugins/saisies/inc/saisies_afficher_si.php",'',true);

	// chercher la fonction si elle n'existe pas
	if (!function_exists($f='saisies_tester_condition_afficher_si')){
		find_in_path("inc/filtres.php",'',true);
		$f = chercher_filtre($f);
	}

	//
	// hop ! on y va
	//
	$err = tester_fun($f, essais_saisies_tester_condition_afficher_si());

	// si le tableau $err est pas vide ca va pas
	if ($err) {
		die ('<dl>' . join('', $err) . '</dl>');
	}

	echo "OK";


	function essais_saisies_tester_condition_afficher_si(){
		$essais = array (
			"chaines_egales_test_egalite" => array (
				0 => true,
				1 => 'a',
				2 => '==',
				3 => 'a',
			),
			"chaines_inegales_test_egalite" => array (
				0 => false,
				1 => 'a',
				2 => '!=',
				3 => 'a',
			),
			"chaines_egales_test_inegalite" => array (
				0 => false,
				1 => 'a',
				2 => '!=',
				3 => 'a',
			),
			"chaines_inegales_test_egalite" => array (
				0 => false,
				1 => 'a',
				2 => '!=',
				3 => 'a',
			),
			"array_presence_test_double_egal" => array (
				0 => true,
				1 => array("2","3"),
				2 => '==',
				3 => '2',
			),
			"array_presence_test_double_egal_serialize" => array (
				0 => true,
				1 => serialize(array("2","3")),
				2 => '==',
				3 => '2',
			),
			"array_presence_test_IN" => array (
				0 => true,
				1 => array("2","3"),
				2 => 'IN',
				3 => '2',
			),
			"array_presence_test_IN_serialize" => array (
				0 => true,
				1 => serialize(array("2","3")),
				2 => 'IN',
				3 => '2',
			),
			"array_presence_test_double_egal_faux" => array (
				0 => false,
				1 => array("2","3"),
				2 => '==',
				3 => '4',
			),
			"array_presence_test_double_egal_faux_serialize" => array (
				0 => false,
				1 => serialize(array("2","3")),
				2 => '==',
				3 => '4',
			),
			"array_presence_test_IN_faux" => array (
				0 => false,
				1 => array("2","3"),
				2 => 'IN',
				3 => '4',
			),
			"array_presence_test_IN_faux_serialize" => array (
				0 => false,
				1 => serialize(array("2","3")),
				2 => 'IN',
				3 => '4',
			),
			"array_absence_test_negation_faux" => array (
				0 => false,
				1 => array("2","3"),
				2 => '!=',
				3 => '2',
			),
			"array_absence_test_negation_faux_serialize" => array (
				0 => false,
				1 => serialize(array("2","3")),
				2 => '!=',
				3 => '2',
			),
			"array_absence_test_NOT_IN_faux" => array (
				0 => false,
				1 => array("2","3"),
				2 => '!IN',
				3 => '2',
			),
			"array_absence_test_NOT_IN_serialize" => array (
				0 => false,
				1 => serialize(array("2","3")),
				2 => '!IN',
				3 => '2',
			),
			"array_absence_test_neagation" => array (
				0 => true,
				1 => array("2","3"),
				2 => '!=',
				3 => '4',
			),
			"array_absence_test_negation_serialize" => array (
				0 => true,
				1 => serialize(array("2","3")),
				2 => '!=',
				3 => '4',
			),
			"array_absence_test_NOT_IN" => array (
				0 => true,
				1 => array("2","3"),
				2 => '!IN',
				3 => '4',
			),
			"array_presence_test_NOT_IN_serialize" => array (
				0 => true,
				1 => serialize(array("2","3")),
				2 => '!IN',
				3 => '4',
			),
		);
		return $essais;
	}


?>

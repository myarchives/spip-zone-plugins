<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function genie_taxonomie_actualiser_itis_dist($last) {

	include_spip('inc/taxonomer');
	$regnes = lister_regnes();

	include_spip('services/itis/itis_api');
	$shas = itis_review_sha();

	include_spip('taxonomie_fonctions');
	foreach ($regnes as $_regne) {
		$regne_a_recharger = false;
		if (taxonomie_regne_existe($_regne, $meta_regne)) {
			// On compare le sha du fichier des taxons
			if ($meta_regne['sha'] != $shas['taxons'][$_regne]) {
				$regne_a_recharger = true;
			}
			else {
				// On compare le sha des fichiers de traductions
				foreach ($meta_regne['traductions']['itis'] as $_code => $_infos) {
					if ($_infos['sha'] != $shas['traductions'][$_code]) {
						$regne_a_recharger = true;
						break;
					}
				}
			}
			if ($regne_a_recharger) {
				$langues = array_keys($meta_regne['traductions']['itis']);
				taxonomie_charger_regne($_regne, $meta_regne['rang'], $langues);
			}
		}
	}

	return 1;
}

?>

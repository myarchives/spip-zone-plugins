<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	'configurer_courtcircuit' => 'Configurer les règles de court-circuitage des rubriques',
	'courtcircuit' => 'Court-circuit',
	'explication_regles' => 'Les différentes règles ci-dessous sont testées dans cet ordre. Si aucune règle ne définit une redirection, alors la rubrique sera affichée normalement.',
	'explication_sousrubrique' => 'Parcourir la première sous-rubrique (tri par numéro du titre et date) ? Les règles de redirection seront testées à nouveau dans cette sous-rubrique.',
	'explication_variantes_squelettes' => 'Exemple : squelettes de la forme rubrique-2.html ou rubrique=3.html.',
	'label_article_accueil' => 'Article d\'accueil de la rubrique',
	'label_plus_recent' => 'Article le plus récent de la rubrique',
	'label_plus_recent_branche' => 'Article de la branche le plus récent',
	'label_rang_un' => 'Premier article (articles numérotés)',
	'label_un_article' => 'Seul article de la rubrique',
	'label_sousrubrique' => 'Sous-rubriques',
	'label_variantes_squelettes' => 'Rubrique avec variante de squelettes',
	'label_exceptions' => 'Exceptions',
	'item_jamais_rediriger' => 'Ne jamais rediriger',
	'item_appliquer_redirections' => 'Appliquer les règles de redirection',
	'label_composition_rubrique' => 'Rubrique avec composition',
	'label_regles' => 'Règles de redirection des rubriques',
	'item_rediriger_sur_article' => 'Rediriger sur cet article',
	'item_ne_pas_rediriger' => 'Ne pas rediriger',
	'aide_en_ligne' => 'Aide en ligne',
	'label_liens' => 'URL des rubriques',
	'label_liens_rubriques' => 'Agir sur la balise #URL_RUBRIQUE ?',
	'explication_liens_rubriques' => 'Modifier l\'URL des rubriques redirigées directement dans les squelettes ?',
);

?>
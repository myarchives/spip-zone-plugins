<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_core_/plugins/xiti/lang/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'activer_xiti' => 'Activer',

	'legend_obligatoire_xiti' => 'Variables fixes et obligatoires',
	'legend_explication_obligatoire_xiti' => ' ',
	'legend_recommande_xiti' => 'Variables optionnelles dépendant de chaque page auditée (utilisation fortement recommandée)',
	'legend_recommande_xiti_campagne' => 'Variable optionnelle utilisé pour les campagnes emailings',
	'legend_activer_xiti' => 'Choix d\'activer Xiti',

	// I
	'icone_xiti' => 'Configurer Xiti',
	'item_utiliser_xiti' => 'Activer Xiti',
	'item_non_utiliser_xiti' => 'Désactiver Xiti',
	'item_titre_chapitre' => 'Titre par chapitre',
	'item_titre_seul' => 'Titre par chapitre',
	'item_xtnv_xiti' => 'Variable xtnv',
	'item_xtnv_explication_xiti' => '<strong>Obligatoire</strong> - niveau d\'arborescence HTML du site.
										Cette variable spécifiant l’emplacement du referrer à récupérer.
										Cette variable est renseignée par défaut à "document", elle doit être changée en "parent.document" dans le cas d’une frame/iframe sur le même nom de domaine
										(dans le cas de noms de domaines différents, contactez le Service Clients qu\'il faut!).',
	'item_xtsd_xiti' => 'Variable xtsd',
	'item_xtsd_explication_xiti' => '<strong>Obligatoire</strong> - sous-domaine du collecteur AT Internet. À récupérer dans le panneau Marqueurs. Cette information ne doit pas être modifiée.',
	'item_xtsite_xiti' => 'Variable "xtsite=" ou "s="',
	'item_xtsite_explication_xiti' => '<strong>Obligatoire</strong> - identifiant numérique du site. À récupérer dans le panneau Marqueurs. Cette information ne doit pas être modifiée.',
	'item_xtpage_xiti' => 'Variable "xtpage=" ou "p="',
	'item_xtpage_explication_xiti' => '<strong>Obligatoire</strong> - création dynamique de chapitres ou simplement le titre des pages',
	'item_xtn2_xiti' => 'Variable "xtn2" ou "s2="',
	'item_xtn2_explication_xiti' => 'Identifiant numérique du niveau 2 dans lequel il faut ranger la page auditée. Les niveaux 2 sont à créer via votre interface XITI.',
	'item_xtdi_xiti' => 'Variable xtdi',
	'item_xtdi_explication_xiti' => 'Degré d\'implication. La valeur par défaut est 0 ou vide. Cette variable accepte les valeurs 1, 2, 3, 4 et 5 pour les pages ayant une implication non nulle.',
	'item_xtor_xiti' => 'Variable xtor',
	'item_xtor_explication_xiti' => 'La variable xtor doit contenir au minimum un préfixe indiquant le type de campagne, ainsi qu\'un identifiant de campagne.',

	// T
	'texte_xiti' => '<p>Activer Xiti, puis renseigner le formulaire de configuration du plugin</p>
					 <p>Consulter la documentation <a href="http://help.atinternet-solutions.com/FR/implementation/general/abouttagging_fr.htm">en ligne</a></p>',
	'titre_configurer' => 'Configurer Xiti',
	'titre_xiti' => 'Configuration du plugin Xiti',

);

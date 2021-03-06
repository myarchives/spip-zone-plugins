<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_migrer_logos' => 'Convertir les logos',

	// C
	'cfg_gros_titre' => 'Configuration des types de logos',
	'cfg_titre_parametrages' => 'Configurer les types de logos',
	'changer_de_logo' => 'Changer de logo',
	'choisir_mediatheque' => 'Choisir dans la médiathèque',

	// E
	'erreur_doublon_slug' => 'Vous ne pouvez pas utiliser deux fois le même identifiant',
	'erreur_sans_objets' => 'Veuillez choisir au moins un objet éditorial',
	'erreur_slug_invalide' => 'Seules les lettres minuscules et les _ sont autorisés dans ce champ',
	'erreur_suppression_logo_defaut' => 'Vous ne pouvez pas supprimer le logo par défaut.',
	'erreur_suppression_logo_survol' => 'Vous ne pouvez pas supprimer le logo de survol.',
	'erreur_suppression_logo_utilise' => 'Vous ne pouvez pas supprimer le type « @role@ » parce qu\'il est utilisé.',
	'explication_saisie_slug_role' => 'Un nom "machine" unique pour définir le nom de la balise qui permet de récupérer le logo. P.ex. « accueil » donnera #LOGO_ACCUEIL.',
	'explication_saisie_titre_role' => "Le titre du rôle, tel qu'il apparaitra dans l'interface. Pour les sites multilingues, on peut aussi utiliser une <a href='https://www.spip.net/fr_article2124.html'>balise multi</a> ou une chaîne de langue du type \"module:chaine_de_langue\".",
	'explication_fieldset_dimensions_role' => 'Laisser vide pour ne pas imposer de taille pour le logo.',
	'explications_formulaire_migrer_logos_roles' => "Vous pouvez convertir les logos enregistrés au format SPIP original en documents (déplacement des logos de la racine de IMG vers des documents).<br>
Sélectionnez les types d'objets éditoriaux dont vous voulez migrer les logos puis cliquez sur « Convertir les logos ».",

	// L
	'label_etat_type' => 'État',
	'label_etat_actif' => 'Actif',
	'label_etat_inactif' => 'Inactif',
	'label_fieldset_dimensions_role' => 'Dimensions du logo',
	'label_fieldset_options_avancees' => 'Options avancées',
	'label_saisie_largeur_role' => 'Largeur [px]',
	'label_saisie_hauteur_role' => 'Hauteur [px]',
	'label_saisie_objets_role' => 'Les objets éditoriaux pour lesquels ce type de logos sera proposé :',
	'label_saisie_slug_role' => 'Identifiant du rôle',
	'label_saisie_titre_role' => 'Titre du rôle',
	'logo' => 'Logo',
	'logos_roles_titre' => 'Logos par rôle',

	// M
	'message_conf_ok' => 'La configuration a bien été enregistrée',

	// S
	'saisie_objets_migration_label' => 'Objets éditoriaux à migrer',

	// T
	'texte_bouton_ajouter_type' => 'Ajouter un nouveau type de logo',
	'texte_bouton_supprimer_type' => 'Supprimer le type de logo',
	'titre_formulaire_migrer_logos_roles' => 'Migration des logos',
	'titre_modifier_logo' => 'Modifier le logo',
	'titre_saisie_roles' => 'Types de logos :',

	// V
	'valider' => 'Valider',
);

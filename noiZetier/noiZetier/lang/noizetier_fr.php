<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'info_page' => 'PAGE&nbsp;:',
	'info_composition' => 'COMPOSITION&nbsp;:',
	'derniere_maj' => 'Derni&egrave;re mise &agrave; jour le',
	'installation_tables' => 'Tables du plugin noiZetier install&eacute;es.<br />',
	'choisir_noisette' => 'Choisissez la noisette que vous voulez ajouter&nbsp:',
	'noisettes_page' => 'Noisettes sp&eacute;cifiques &agrave; la page <i>@type@</i>&nbsp;:',
	'noisettes_composition' => 'Noisettes sp&eacute;cifiques &agrave; la composition <i>@type@-@composition@</i>&nbsp;:',
	'noisettes_toutes_pages' => 'Noisettes communes &agrave; toutes les pages&nbsp;:',
	'saisies_non_installe' => '<b>Plugin saisies&nbsp;:</b> ce plugin n\'est pas install&eacute; sur votre site. Il n\'est pas n&eacute;cessaire au fonctionnement du noizetier. Son utilisation est cependant recommand&eacute;e afin d\'offrir des formulaires de configuration plus ergonomiques.',
	'compositions_non_installe' => '<b>Plugin compositions&nbsp;:</b> ce plugin n\'est pas install&eacute;s sur votre site. Il n\'est pas n&eacute;cessaire au fonctionnement du noizetier. Cependant, s\'il est activ&eacute;, vous pourrez d&eacute;clarer des compositions directement dans le noizetier.',
	'yaml_non_installe' => '<b>Plugin YAML&nbsp;:</b> ce plugin n\'est pas install&eacute;s sur votre site. Il n\'est pas n&eacute;cessaire au fonctionnement du noizetier. Cependant, il permet d\'importer et exporter des configurations de noisettes.',
	'liste_icones' => 'Liste d\'icônes',
	'oui' => 'Oui',
	'non' => 'Non',
	
	'description_bloc_contenu' => 'Contenu principal de chaque page.',
	'description_bloc_navigation' => 'Informations de navigation propres à chaque page.',
	'description_bloc_extra' => 'Informations extra contextuelles pour chaque page.',
	
	'description_bloctexte' => 'Le titre est optionnel. Pour le texte, vous pouvez utiliser les raccourcis typographiques de SPIP.',
	
	'editer_noizetier_titre' => 'noiZetier',
	'editer_noizetier_explication' => 'Configurer ici les noisettes &agrave; ajouter aux pages de votre site.',
	'editer_noizetier_compositions_titre' => 'Compositions du noiZetier',
	'editer_noizetier_compositions_explication' => 'Vous pouvez cr&eacute;er ici des compositions qui ne diff&eacute;reront que par les noisettes qui leurs seront ajout&eacute;s.',
	'editer_configurer_page' => 'Configurer les noisettes de cette page',
	'editer_supprimer_noisettes' => 'Supprimer les noisettes d&eacute;finies pour cette page',
	'editer_exporter_configuration' => 'Exporter la configuration',
	'editer_compositions' => 'G&eacute;rer les compositions du noiZetier',
	'editer_importer_configuration' => 'Importer une config.',
	'editer_nouvelle_composition'=> 'Cr&eacute;er une nouvelle composition',
	'editer_composition' => 'Modifier cette composition',
	'editer_noizetier_importer_configuration' => 'Importer une configuration',
	'editer_noizetier_importer_configuration_explication' => 'Vouz pouvez importer une configuration du noizetier que vous auriez pr&eacute;alablement export&eacute;e ou bien une configuration fournie par un plugin.',
	
	'erreur_aucune_noisette' => 'Aucune noisette trouv&eacute;e.',
	'erreur_doit_choisir_noisette' => 'Vous devez choisir une noisette.',
	'erreur_mise_a_jour' => 'Une erreur s\'est produite pendant la mise &agrave; jour de la base de donn&eacute;e.',
	
	'formulaire_ajouter_noisette' => 'Ajouter une noisette',
	'formulaire_modifier_noisette' => 'Modifier cette noisette',
	'formulaire_supprimer_noisette' => 'Supprimer cette noisette',
	'formulaire_supprimer_noisettes_page' => 'Supprimer les noisettes de cette page',
	'formulaire_deplacer_bas' => 'D&eacute;placer vers le bas',
	'formulaire_deplacer_haut' => 'D&eacute;placer vers le haut',
	'formulaire_configurer_page' => 'Configurer la page&nbsp;:',
	'formulaire_configurer_bloc' => 'Configurer le bloc&nbsp;:',
	'formulaire_obligatoire' => 'Champs obligatoire',
	'formulaire_noisette_sans_parametre' => 'Cette noisette ne propose pas de param&egrave;tre.',
	'formulaire_explication_oui_non' => '(saisir <i>on</i> ou laisser vide)',
	'formulaire_explication_oui_ou_non' => '(saisir <i>oui</i> ou <i>non</i>)',
	'formulaire_modifier_composition' => 'Modifier cette composition&nbsp;:',
	'formulaire_supprimer_composition' => 'Supprimer cette composition',
	'formulaire_nouvelle_composition' => 'Nouvelle composition',
	'formulaire_type' => 'Type de composition',
	'formulaire_type_explication' => 'Indiquez sur quel objet / quelle page porte cette composition.',
	'formulaire_composition' => 'Identifiant de composition',
	'formulaire_composition_explication' => 'Indiquez un mot-clé unique (minuscules, sans espace, sans tiret (-) et sans accent) permettant d\'identifier cette composition.<br />Par exemple&nbsp;: <i>macompo</i>.',
	'formulaire_nom' => 'Titre',
	'formulaire_nom_explication' => 'Vous pouvez utilisez la balise  &lt;multi&gt;.',
	'formulaire_description' => 'Description',
	'formulaire_description_explication' => 'Vous pouvez utilisez les raccourcis SPIP usuels, notamment la balise  &lt;multi&gt;.',
	'formulaire_icon' => 'Ic&ocirc;ne',
	'formulaire_icon_explication' => 'Vous pouvez saisir le chemin relatif vers une ic&ocirc;ne (par exemple&nbsp;: <i><images/objet-liste-contenus.png</i>). Pour voir une liste d\'images install&egrave;es dans les r&eacute;pertoires les plus courants, vous pouvez <a href="../spip.php?page=icones_preview">consulter cette page</a>.',
	'formulaire_identifiant_deja_pris' => 'Cet identifiant est d&eacute;j&agrave; utilis&eacute;&nbsp;!',
	'formulaire_erreur_format_identifiant' => 'L\'identifiant ne peut contenir que des minuscules sans accent, des chiffres et le caract&egrave;re _ (underscore).',
	'formulaire_composition_mise_a_jour' => 'Composition mise &agrave; jour',
	'formulaire_importer' => 'Importer une configuration',
	'formulaire_importer_explication' => 'Fichier de configuration au format YAML.',
	'formulaire_import_local' => 'Configurations disponibles localement',
	'formulaire_import_local_explication' => 'Liste des configurations d&eacute;tect&eacute;es dans un sous-r&eacute;pertoire <i>config_noizetier</i>.',
	'formulaire_bouton_importer' => 'Importer',
	'formulaire_choix_fichier' => 'Choix du fichier &agrave; importer',
	'formulaire_fichier_import_manquant' => 'Vous devez choisir un fichier.',
	'formulaire_fichier_vide' => 'Le fichier ne contient pas de donn&eacute;es.',
	'formulaire_options_importation' => 'Options d\'importation',
	'formulaire_liste_pages_config' => 'Ce fichier de configuration d&eacute;finis des noisettes sur les pages suivantes&nbsp;:',
	'formulaire_liste_compos_config' => 'Ce fichier de configuration d&eacute;finis les compositiosn du noizetier suivantes&nbsp;:',
	'formulaire_fichier_config' => 'Fichier de configuration&nbsp;:',
	'formulaire_type_import' => 'Type d\'importation',
	'formulaire_type_import_explication' => 'Vous pouvez fusionner le fichier de configuration avec votre configuration actuelle (les noisettes de chaque page seront ajout&eacute;es &agrave; vos noisettes d&eacute;j&agrave; d&eacute;finies) ou bien remplacer votre configuration par celle-ci.',
	'formulaire_import_fusion' => 'Fusionner avec la configuration actuelle',
	'formulaire_import_remplacer' => 'Remplacer la configuration actuelle',
	'formulaire_import_compos' => 'Importer les compositions du noizetier',
	'formulaire_config_importee' => 'La configuration a &eacute;t&eacute; import&eacute;e.',
	
	'nom_bloc_contenu' => 'Contenu',
	'nom_bloc_navigation' => 'Navigation',
	'nom_bloc_extra' => 'Extra',
	
	'nom_bloctexte' => 'Bloc de texte libre',
	
	'label_titre' => 'Titre&nbsp;:',
	'label_texte' => 'Texte&nbsp;:',
	
	'warning_noisette_plus_disponible' => 'ATTENTION&nbsp: cette noisette n\'est plus disponible.',
	'warning_noisette_plus_disponible_details' => 'Le squelette de cette noisette (<i>@squelette@</i>) n\'est plus accessible. Il se peut qu\'il s\'agisse d\'une noisette fournie par un plugin que vous avez d&eacute;sactiv&eacute; ou d&eacute;sinstall&eacute;.',

);

?>

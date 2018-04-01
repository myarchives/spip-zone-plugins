<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_continuer' => 'Passer à l\'étape suivante',
	'bouton_retourner' => 'Retourner à l\'étape @etape@',
	'bouton_taxonomie' => 'Taxons',
	'bouton_wikipedia_descriptif' => 'Initialiser le descriptif avec Wikipedia',
	'bouton_wikipedia_texte' => 'Initialiser le texte avec Wikipedia',

	// C
	'credit_itis' => 'Integrated Taxonomic Information System, @url_site@ (informations taxonomiques de base). Voir aussi la page du taxon @url_taxon@.',
	'credit_cinfo' => 'Commission internationale des noms français des oiseaux (CINFO), @url@.',
	'credit_wikipedia' => 'Wikipedia (@champs@). Voir aussi la page du taxon @url_taxon@.',

	// E
	'erreur_recherche_max_reponses' => 'Le nombre de correspondances (@nb@) est trop important pour passer à l\'étape suivante. Veuillez affiner votre recherche.',
	'erreur_saisie_iucn_token' => 'Le service IUCN nécessite l\'utilisation d\'un token de 64 caractères. Veuillez vous en procurez un et l\'enregistrer ici.',
	'erreur_vider_regne' => 'Erreur lors du vidage du règne @regne@ en base de données.',
	'erreur_charger_regne' => 'Erreur lors du chargement du règne @regne@ en base de données.',
	'erreur_wikipedia_page' => 'Aucune page dans la langue choisie n\'a pu être récupérée de Wikipedia.',
	'erreur_recherche_nom_scientifique' => 'Le nom scientifique d\'une espèce ou d\'un taxon de rang inférieur est toujours constitué d\'au moins deux mots. Saisissez un second mot ou changez le type de correspondance.',
	'erreur_recherche_aucun_taxon_exact' => 'Le service ITIS ne trouve aucun taxon de rang espèce ou inférieur correspondant à cette recherche ou tous les taxons trouvés ont déjà été créés.',
	'erreur_recherche_aucun_taxon' => 'Le service ITIS ne trouve aucun taxon de rang espèce ou inférieur correspondant à cette recherche ou tous les taxons trouvés ont déjà été créés.',
	'erreur_formulaire_creer_espece' => 'Une erreur s\'est produite lors du processus de création. Veuillez relancer le formulaire et réessayer.',
	'erreur_creation_taxon' => 'Une erreur s\'est produite lors de la création du taxon @taxon@ en base de données. Veuillez consulter la liste des taxons et relancer le formulaire si besoin.',
	'explication_iucn_token' => 'L\'utilisation du service IUCN nécessite de posséder un token. Vous pouvez en faire la demande à partir de la page <a href="http://apiv3.iucnredlist.org/api/v3/token">Generate a token</a>.',
	'explication_taxon_trouve' => 'Chaque taxon est désigné par son nom, scientifique ou commun, et son rang.',
	'explication_recherche_type' => 'Si vous le connaissez, le nom scientifique permet une recherche d\'emblée plus précise.',
	'explication_recherche_taxon' => 'Le taxon recherché doit correspondre à une espèce ou à un taxon de rang inférieur.',
	'explication_recherche_correspondance' => 'Il conseillé d\'adapter le type de correspondance afin de limiter le nombre de taxons potentiellement compatibles.',
	'explication_recherche_regne' => 'Les règnes proposés sont uniquement ceux qui ont déjà été chargés dans la base de données taxonomique.',
	'explication_action_regne' => 'Si le règne est déjà présent dans la base de données taxonomique, tous les taxons du règne au genre qui le composent seront supprimés avant le chargement.',
	'explication_langues_regne' => 'Les taxons sont chargés par défaut avec leur nom scientifique. Cette option permet de compléter certains taxons avec leur nom commun dans la ou les langues précisées.',
	'explication_services_utilises' => 'Le plugin utilise par défaut le service taxonomique ITIS pour peupler les informations de bases des taxons. Il est aussi possible d\'utiliser des services complémentaires pour charger automatiquement des données non fournies par ITIS. Choisissez les services que vous souhaitez aussi utiliser.',
	'explication_langues_utilisees' => 'Le plugin supporte quelques langues comme le français, l\'anglais et l\'espagnol. Cela permet de charger voire de saisir manuellement les noms communs et descriptifs dans ces langues.
	Néanmoins, en fonction de votre besoin vous pouvez limiter l\'utilisation de ces langues mais une langue est au moins requise.',
	'explication_wikipedia_langue' => 'Si vous utilisez plusieurs langues pour traduire vos taxons, choisissez la langue à utiliser pour récupérer la page Wikipedia.',
	'explication_wikipedia_page' => 'Vérifier si cette page est bien celle qui décrit le mieux le taxon. Si non, choisissez une page alternative parmi celle éventuellement proposée dans la liste ci-dessous.',
	'explication_wikipedia_lien' => 'Choisissez la page Wikipedia que vous souhaitez intégrer dans le champ «&nbsp;@element@&nbsp;» du taxon.',

	// F
	'filtre_edite_oui' => 'Edités',
	'filtre_edite_non' => 'Non édités',
	'filtre_edite_tout' => 'Tous',
	'filtre_importe_oui' => 'Importés',
	'filtre_importe_non' => 'Non importés',
	'filtre_importe_tout' => 'Tous',
	'filtre_regnes_tout' => 'Tous les règnes',
	'filtre_statut_prop' => 'Proposés à la publication',
	'filtre_statut_publie' => 'Publiés',
	'filtre_statut_poubelle' => 'À la poubelle',
	'filtre_statut_tout' => 'Tous',

	// I
	'info_1_espece' => 'Une espèce ou taxon de rang inférieur',
	'info_1_taxon' => 'Un taxon du règne au genre',
	'info_nb_especes' => '@nb@ espèces et taxons de rang inférieur',
	'info_nb_taxons' => '@nb@ taxons du règne au genre',
	'info_boite_taxonomie_configuration' => 'Cette page permet de configurer les paramètres de base du plugin comme la liste des langues utilisables pour nommer ou décrire les taxons.',
	'info_boite_regnes' => 'Cette page permet de charger, mettre à jour ou vider les taxons du règne au genre (rangs principaux, secondaires et intercalaires) importés à partir des rapports hiérarchiques extraits de la base ITIS. Ces taxons peuvent être rechargés sans danger pour les autres taxons et pour les modifications éventuellement effectuées.',
	'info_boite_taxons' => 'Cette page permet de consulter la liste des taxons dont le rang est strictement supérieur au rang espèce. Ces taxons sont tous créés automatiquement même si ils peuvent être modifiés manuellement après coup.',
	'info_boite_especes' => 'Cette page permet de consulter la liste des espèces et des taxons de rang inférieur créés par les utilisateurs.',
	'info_boite_espece_creer' => 'Cette page permet de créer une espèce ou un taxon de rang inférieur à partir de son nom scientifique ou d\'un nom commun. Le formulaire fait appel à la base ITIS via des services web afin de récupérer l\'ensemble des informations de base sur le taxon.
	Une fois le taxon proposé validé, l\'espèce est créée dans la base de données taxonomique et la page d\'édition de l\'espèce est affichée.',
	'info_element_existe' => 'non vide',
	'info_etape' => 'Etape @etape@ / @etapes@',
	'info_indicateur_hybride' => 'Ce taxon est un hydribe',
	'info_regne_charge' => 'déjà chargé',
	'info_regne_compteur_taxons' => '@nb@ taxons chargés du règne au genre à partir du fichier «&nbsp;@fichier@&nbsp;»',
	'info_regne_compteur_traductions' => '@nb@ noms communs en [@langue@]',
	'info_espece_recherche_intro' => 'Vous avez choisi de rechercher une espèce :',
	'info_espece_recherche_scientificname_debut' => 'dont le nom scientifique commence par «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_scientificname_exact' => 'dont le nom scientifique est exactement «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_scientificname_contenu' => 'dont le nom scientifique contient «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_commonname_exact' => 'dont le nom commun est exactement «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_commonname_contenu' => 'dont le nom commun contient «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_commonname_debut' => 'dont le nom commun commence par «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_commonname_fin' => 'dont le nom commun se termine par «&nbsp;@recherche@&nbsp;»',
	'info_espece_recherche_regne' => 'et appartenant au @regne@.',
	'info_espece_recherche_fin' => 'Choisissez ci-dessous le taxon qui correspond à votre recherche.',
	'info_espece_choisie_intro' => 'Vous avez choisi de créer le taxon «&nbsp;@taxon@&nbsp;» dont les caractéristiques sont les suivantes :',
	'info_espece_choisie_fin' => 'Si ce taxon est bien celui que vous souhaitez, valider ce formulaire pour le créer et l\'éditer dans la foulée. Les ascendants suivis d\'une étoile seront créés en même temps que le taxon principal.',

	// L
	'label_action_charger_regne' => 'Charger un règne',
	'label_action_regne' => 'Action à exécuter',
	'label_action_vider_regne' => 'Vider un règne',
	'label_ascendance' => 'Ascendance taxonomique',
	'label_colonne_actualisation' => 'Actualisé le',
	'label_colonne_statistiques' => 'Statistiques',
	'label_iucn_token' => 'Token personnel d\'accès au service IUCN',
	'label_service_iucn' => 'IUCN, Red List (espèces en danger)',
	'label_service_wikipedia' => 'WIKIPEDIA (articles sur les taxons)',
	'label_service_itis' => 'ITIS (base officielle des taxons)',
	'label_regne' => 'Règne sur lequel appliquer l\'action',
	'label_langue_descriptif' => 'Langue du descriptif',
	'label_langues_regne' => 'Langues des noms communs',
	'label_langues_utilisees' => 'Langues à utiliser',
	'label_services_utilises' => 'Services taxonomiques à utiliser',
	'label_taxon_trouve' => 'Taxons correspondant à la recherche',
	'label_wikipedia_alternative_defaut' => 'Utiliser le descriptif proposé par défaut',
	'label_wikipedia_alternative' => 'Utiliser la page «&nbsp;@alternative@&nbsp;»',
	'label_wikipedia_page' => 'Page Wikipedia fournie par défaut',
	'label_wikipedia_langue' => 'Langue à utiliser par Wikipedia',
	'label_wikipedia_lien' => 'Page Wikipedia à utiliser',
	'label_recherche_type' => 'Rechercher par',
	'label_recherche_taxon' => 'Texte de la recherche',
	'label_recherche_correspondance' => 'Type de correspondance',
	'label_recherche_correspondance_exact' => 'Correspond exactement au texte de la recherche',
	'label_recherche_correspondance_contenu' => 'Contient le texte de la recherche',
	'label_recherche_correspondance_debut' => 'Commence par le texte de la recherche',
	'label_recherche_correspondance_fin' => 'Se termine par le texte de la recherche',
	'label_recherche_regne' => 'Limiter la recherche à un règne',
	'label_parents_espece' => 'Ascendance jusqu\'au genre',

	// N
	'notice_vider_regne_inexistant' => 'Le règne @regne@ n\'a pas été trouvé en base de données.',
	'notice_liste_aucun_regne' => 'Aucun règne n\'a encore été chargé en base de données. Utiliser le formulaire ci-dessous pour y remédier.',

	// R
	'rang_kingdom' => 'règne',
	'rang_subkingdom' => 'sous-règne',
	'rang_infrakingdom' => 'infra-règne',
	'rang_superdivision' => 'super-division',
	'rang_division' => 'division',
	'rang_subdivision' => 'sous-division',
	'rang_infradivision' => 'infra-division',
	'rang_superphylum' => 'super-phylum',
	'rang_phylum' => 'phylum',
	'rang_subphylum' => 'sous-phylum',
	'rang_infraphylum' => 'infra-phylum',
	'rang_superclass' => 'super-classe',
	'rang_class' => 'classe',
	'rang_subclass' => 'sous-classe',
	'rang_infraclass' => 'infra-classe',
	'rang_superorder' => 'super-ordre',
	'rang_order' => 'ordre',
	'rang_suborder' => 'sous-ordre',
	'rang_infraorder' => 'infra-ordre',
	'rang_section' => 'section',
	'rang_subsection' => 'sous-section',
	'rang_superfamily' => 'super-famille',
	'rang_family' => 'famille',
	'rang_subfamily' => 'sous-famille',
	'rang_tribe' => 'tribu',
	'rang_subtribe' => 'sous-tribu',
	'rang_genus' => 'genre',
	'rang_subgenus' => 'sous-genre',
    'rang_species' => 'espèce',
    'rang_subspecies' => 'sous-espèce',
    'rang_variety' => 'variété',
    'rang_subvariety' => 'sous-variété',
    'rang_race' => 'race',
    'rang_forma' => 'forme',
    'rang_subforma' => 'sous-forme',
	'regne_animalia' => 'règne animal',
	'regne_fungi' => 'règne fongique',
	'regne_plantae' => 'règne végétal',

	// O
	'onglet_espece' => 'Espèces et descendants',
	'onglet_gestion' => 'Gestion des règnes',
	'onglet_configuration' => 'Configuration du plugin',
	'onglet_navigation' => 'Ascendants des espèces',

	// S
	'succes_vider_regne' => 'Le règne @regne@ a bien été supprimé de la base de données.',
	'succes_charger_regne' => 'Le règne @regne@ a bien été chargé en base de données.',

	// T
	'texte_statut_prop' => 'pour publication',
	'texte_statut_publie' => 'publié',
	'texte_statut_poubelle' => 'à la poubelle',
	'titre_form_configuration' => 'Configuration du plugin',
	'titre_form_gestion_regne' => 'Gestion des règnes',
	'titre_liste_regnes' => 'Liste des règnes chargés en base de données',
	'titre_liste_fils_taxon' => 'Liste des descendants directs',
	'titre_page_taxonomie' => 'Taxonomie',
	'titre_page_creer_espece' => 'Créer une espèce ou un taxon de rang inférieur',
);

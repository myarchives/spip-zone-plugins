<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/emballe_medias?lang_cible=es
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'analyze_document' => 'Análisis de su documento',
	'ancre_formulaire_upload' => 'Volver al formulario de puesta en línea de documentos',
	'ancre_formulaire_validation' => 'Ir al formulario de validación',
	'ancre_haut_page' => 'Volver arriba',
	'aucun_document_type' => 'No existe ningún documento del tipo necesario',

	// B
	'bouton_delier_document' => 'Desvincular este documento de este artículo',
	'bouton_enlever' => 'Quitar',
	'bouton_parcourir' => 'Examinar',
	'bouton_recuperer_document' => 'Recuperar el (los) documento(s)',
	'bouton_supprimer' => 'Eliminar',

	// C
	'cancel_upload' => 'Anular la puesta en red?',
	'cancelled' => 'Anulación',
	'changer_type_article' => 'Cambiar el tipo de artículo',
	'complete' => 'Este archivo se ha subido. Ahora puede editarlo. ',
	'configurer_les_extensions' => 'Debe configurar las extensiones autorizadas.',
	'connection_obligatoire' => 'Debe estar identificado en el sitio.',

	// D
	'document_appareil' => 'Aparato:',
	'document_credits' => 'Créditos',
	'document_date' => 'Fecha:',
	'document_description' => 'Descripción del documento:',
	'document_description_no_crayons' => 'No hay descripción alguna disponible, puede añadir una haciendo doble click sobre este texto. ',
	'document_dimensions' => 'Dimensiones:',
	'document_extension' => 'Extensión:',
	'document_id' => 'Identificador del documento:',
	'document_infos_complementaires' => 'Información complementaria',
	'document_licence' => 'Licencia:',
	'document_logo' => 'Logotipo del documento:',
	'document_nom_fichier' => 'Nombre del archivo:',
	'document_poid_fichier' => 'Tamaño del archivo:',
	'document_titre' => 'Título del documento:',
	'document_type' => 'Tipo de documento:',

	// E
	'em_next' => 'Documento siguiente',
	'em_prev' => 'Documento anterior',
	'emballe_medias' => 'Envuelve medias',
	'emballe_medias_fichiers' => 'Envuelve medias (Archivos)',
	'emballe_medias_styles' => 'Envuelve medias (Estilos)',
	'emballe_medias_types' => 'Envuelve medias (Tipos)',
	'erreur_article_inexistant' => 'El media que desea modificar no existe.',
	'erreur_aucun_fichier' => 'Elija por favor un archivo',
	'erreur_aucun_media_correspondant' => 'Ningún media corresponde a los criterios',
	'erreur_autorisation_article' => 'No dispone de los derechos necesarios para modificar el artículo solicitado.',
	'erreur_beforeunload' => 'Está publicando en red un documento',
	'erreur_conflit_secteur' => 'No puede crear una plantilla para los artículos y para los media dentro de la misma sección',
	'erreur_demander_validation_titre' => 'Ha solicitado modificar el título o algunos medias tienen ya un título personalizado. Marque por favor la siguiente casilla para imponer la modificación de los títulos.',
	'erreur_diogene_multiple' => 'No puede tener más que una sola plantilla "envuelve média" en este sitio',
	'erreur_document_disparu' => 'El documento original ya no está disponible. Puede volver a publicarlo a continuación, el archivo original era: @fichier@',
	'erreur_document_existant' => 'Un documento similiar ya existe: @nom@',
	'erreur_document_insere' => 'Este documento está insertado en el contenido del artículo, por lo que no puede eliminarse. ',
	'erreur_fichier_trop_gros' => 'El archivo es demasiado grande.',
	'erreur_filesize_limit' => '@taille_max@ es el máximo aceptado por su configuración PHP.',
	'erreur_invalid_file_type' => 'Tipo de archivo no válido. ',
	'erreur_lot_selection_medias' => 'Seleccione al menos un media para editar',
	'erreur_media_sans_document' => 'Ningún documento está adjunto a su media. No podrá publicarlo en tanto ningún documento esté asociado.',
	'erreur_publier_categorie_avant' => 'Debe crear al menos <a href="@url@" class="spip_in">una sección</a> previamente.',
	'erreur_publier_categorie_avant_demander_admin' => 'No existe ninguna categoría. Contacte por favor con un administrador para que cree al menos una. ',
	'erreur_secteur_inexistant' => 'El sector asociado a esta plantilla no existe. Contacte por favor con un administrador.',
	'erreur_upload_fournir_objet' => 'Debe proporcionar un tipo de objeto.',
	'erreur_upload_session' => 'Ninguna sesión visitante.',
	'erreur_zero_byte_files' => 'Es imposible publicar en red archivos de 0 byte.',
	'explication_chercher_article' => 'Al presentar un nuevo artículo, si el id_article no se indica como parámetro del formulario, buscar la existencia de un artículo en curso de redacción del mismo autor e insertar dentro el artículo (si no se crea sistemáticamente un nuevo artículo)',
	'explication_config_readonly' => 'Esta opción está desactivada. Debe ser impuesta por el tema que utiliza.',
	'explication_file_size_limit' => 'Límite de tamaño para un archivo (MB). @taille_max@ es el máximo aceptado por su configuración PHP.',
	'explication_gerer_modifs_types' => 'Muestra un formulario en la columna izquierda de la página de modificación del artículo, permitiendo a los autores elegir ellos mismos el tipo de artículo. ',
	'explication_gerer_types' => 'Tipificar los artículos (rellenar los campos "em_type" de la tabla article) en función del tipo de documento publicado. Si esta opción está activada, será posible definir varios formularios diferentes en función del tipo de archivo a publicar.',
	'explication_infos_documents' => 'Esta información es extraída directamente de metadatos de la imagen.',
	'explication_medias_prepas' => 'Los medias listados a continuación están en curso de preparación, debe cambiar su estatus a "propuesto para publicación" para que un administrador los publique definitivamente. ',
	'explication_medias_prepas_auth_publier' => 'Los medias listados a continuación están en curso de preparación, debe cambiar su estatus para que sean publicados. ',
	'explication_medias_props' => 'Los medias listados a continuación han sido propuestos para publicación, ha de esperar que un administrador cambie su estatus para que sean visibles en el sitio. ',
	'explication_medias_props_auth_publier' => 'Los medias listados a continuación han sido propuestos para publicación, ha de cambiar su estatus para que sean publicados o esperar a que un administrador lo haga. ',
	'explication_traitement_lot_intro' => 'Para procesar sus medias por lote, seleccione previamente los medias a modificar, después complete los campos del formulario que serán aplicados.',
	'extensions_audio' => 'Extensiones Audio:',
	'extensions_autorisees' => 'Extensiones de archivos autorizados',
	'extensions_images' => 'Extensiones Imagen:',
	'extensions_texte' => 'Extensiones Texto:',
	'extensions_video' => 'Extensiones Vídeo:',

	// F
	'failed_validation' => 'La validación del archivo ha fallado. La publicación se ha cancelado.',
	'file_queue_limit' => 'Límite del número de archivos en lista de espera',
	'file_size_limit' => 'El tamaño máximo de un archivo es de @taille@ MB',
	'file_upload_limit' => 'Limitar el número de archivos a publicar en red',
	'file_upload_limit_public' => 'El límete máximo del número de archivos a publicar en red es de',

	// H
	'hauteur_img_previsu' => 'Altura máxima (en px) de la previsualización de las imágenes',

	// I
	'info_lien_publier_media' => 'Publier ce média', # NEW
	'info_lien_refuser_media' => 'Refuser ce média', # NEW
	'info_lien_supprimer_media' => 'Supprimer ce média', # NEW
	'info_moderation_media_confirmee_publie' => 'Le média #@id_article@ a bien été publié', # NEW
	'info_moderation_media_confirmee_refuse' => 'Le média #@id_article@ a bien été refusé', # NEW
	'info_moderation_media_confirmee_supprime' => 'Le média #@id_article@ a bien été supprimé', # NEW
	'info_moderation_media_deja_faite' => 'Le média #@id_article@ a déjà été modéré en "@statut@".', # NEW
	'info_moderation_media_interdite' => 'Vous n\'avez pas le droit de modérer ce média', # NEW
	'info_moderation_media_lien_titre' => 'Modérer ce média depuis l\'espace privé', # NEW
	'info_moderation_media_url_perimee' => 'Ce lien de modération n\'est plus valide.', # NEW
	'info_statut_prepa' => 'En preparación',
	'info_statut_prop' => 'Propuestos para publicación',
	'info_statut_publies' => 'Publicados',

	// L
	'label_case_gerer_modifs_types' => 'Mostrar el formulario de cambio de tipo',
	'label_case_gerer_types' => 'Activar la gestión de los tipos',
	'label_case_publier_dans_secteur' => 'Permitir publicar artículos sin categoría (en la raíz del sector medias).',
	'label_case_types_autoriser_normal' => 'En el caso en que ningún tipo sea seleccionado, se autoriza la publicación de tipo "normal"',
	'label_cfg_file_size_limit' => 'Límite del tamaño de los archivos en MB',
	'label_change_statut_em_normal' => 'Modificar el estatus de su media',
	'label_changer_type' => 'Modificar el tipo de documento(s) a publicar: ',
	'label_chercher_article' => '¿Buscar un artículo?',
	'label_choisir_medias_lot' => 'Elija los medias a procesar',
	'label_choisir_type' => 'Elegir el tipo de documento(s) a publicar: ',
	'label_couleur_claire' => 'Color claro',
	'label_couleur_foncee' => 'Color oscuro',
	'label_couleur_texte_bouton' => 'Color del texto del botón de cargar (upload)',
	'label_em_charger_supprimer' => 'Eliminar el archivo del repertorio FTP tras importarlo',
	'label_flash_bouton_styles' => 'Estilos del botón de cargar (upload)',
	'label_forcer_validation_titre' => 'Forzar la inclusión del título',
	'label_gerer_modifs_types' => 'Permitir modificar el tipo a posteriori',
	'label_gerer_types' => 'Administrar los tipos de artículos',
	'label_publier_dans_secteur' => 'Publicación fuera de categoría',
	'label_selectionnez_types_medias' => 'Elija el estatus de los medias a seleccionar:',
	'label_texte_upload' => 'Explicaciones para la subida en línea',
	'label_types_autoriser_normal' => 'Autorizar publicación sin tipo definido',
	'label_types_disponibles' => 'Tipos disponibles',
	'label_upload_debug' => 'Mostrar la depuración (debug) del formulario de publicación (upload) de los documentos',
	'largeur_img_previsu' => 'Anchura máxima (en px) de la previsualización de imágenes',
	'legend_gerer_styles' => 'Gestión de estilos',
	'legend_gerer_types' => 'Gestión de tipos de artículos',
	'legend_mise_en_ligne_multiple' => 'Publicar archivo(s)',
	'legend_mise_en_ligne_unique' => 'Publicar archivo',
	'lien_charger_doc_trad' => 'Desde el artículo de origen',
	'lien_charger_ftp' => 'Desde la FTP',
	'lien_charger_local' => 'Desde su ordenador',
	'lien_creer_nouveau_media' => 'Crear un nuevo media',
	'lien_edition_lot' => 'Edición por lote',
	'lien_edition_un' => 'Edición uno por uno',
	'lien_voir_origine' => 'Ver el original',
	'lien_zoom_image' => 'Zoom',

	// M
	'maj_plugin' => 'Actualización del plugin "Envuelve medias" en la versión @version@.',
	'max_file_size' => 'El tamaño máximo del archivo es: ',
	'media_propose_detail' => 'El media "@titre@" está propuesto para publicación
	desde',
	'media_propose_sujet' => '[@nom_site_spip@] Propone: @titre@',
	'media_propose_titre' => 'Media propuesto
	---------------', # MODIF
	'media_propose_url' => 'Le invitamos a consultarlo. Está disponible en la dirección:',
	'media_publie_detail' => 'El media "@titre@" acaba de ser publicado por @connect_nom@.',
	'media_publie_sujet' => '[@nom_site_spip@] PUBLICADO: @titre@',
	'media_publie_titre' => 'Media publicado
	--------------',
	'media_valide_date' => 'Sujeto a modificación, este media será publicado',
	'media_valide_detail' => 'El media "@titre@" ha sido validado por @connect_nom@.',
	'media_valide_sujet' => '[@nom_site_spip@] VALIDADO: @titre@',
	'media_valide_titre' => 'Media validado
	--------------',
	'media_valide_url' => 'A la espera, está visible desde esta dirección temporal:',
	'message_aucun_media_attente' => 'No tiene ningún media a la espera de publicación.',
	'message_delier_document' => 'Este documento ya está vinculado a otro objeto. No puede eliminarlo. Solamente puede desvincularlo del objeto en curso. ',
	'message_doc_trad_indisponible' => 'Ningún documento está disponible en el artículo de origen.',
	'message_document_original' => 'Este artículo es la versión original de:',
	'message_drag_file' => 'Deposite el archivo aquí',
	'message_drag_files' => 'Deposite los archivos aquí.',
	'message_info_media_proposer' => 'Cambie su estatus a "@statut@" para que los administradores puedan validarlo.',
	'message_info_media_publier' => 'Cambie su estatus a "@statut@" para que sea visible en el sitio. ',
	'message_info_media_statut' => 'Este media está actualmente "@statut@".',
	'message_medias_maj_nb' => '@nb@ medias han sido actualizados.',
	'message_medias_maj_statut_nb' => 'El estatus de los medias seleccionados ha sido actualizado como "@statut@"',
	'message_medias_maj_statut_un' => 'Su estatus se ha actualizado como "@statut@"',
	'message_medias_maj_un' => '@nb@ ha sido actualizado. ',
	'message_navigateur_redirection' => 'Su navegador va a ser redirigido. ',
	'message_notice_articles_prepa_nb' => 'Tiene @nb@ medias en curso.',
	'message_notice_articles_prepa_un' => 'Tiene un media en curso.',
	'message_notice_nb_articles_prepa_autres' => 'Tiene @nb@ otros medias en curso.',
	'message_notice_voir_articles_prepa' => 'Ver <a href="@url@" class="@class_lien@">estos medias</a>.',
	'message_selectionner_media_editer' => 'Seleccione un media de la lista para editarlo.',
	'message_type_mis_a_jour' => 'El tipo de artículo ha sido actualizado',
	'message_type_pas_mis_a_jour' => 'El tipo de artículo no ha sido modificado. ',

	// N
	'nb_doc_uploaded' => '@nb@ documentos publicados',
	'no_credits_crayons' => 'Ningún crédito especificado',

	// P
	'pending' => 'En lista de espera...',
	'previsu_document' => 'Previsualización del documento',
	'previsu_document_nb' => 'Previsualización del documento número @nb@',

	// Q
	'queue_limit_exceeded' => 'Ha intentado adjuntar demasiados archivos.',
	'queue_limit_max' => 'El límite máximo del número de archivos en la lista de espera es',
	'queue_limit_reached' => 'Ha llegado al límite.',
	'queue_limit_un' => 'No puede seleccionar más que un solo archivo',

	// S
	'security_error' => 'Error de seguridad',
	'select_all' => 'Seleccionar todo',
	'server_io_error' => 'Error de servidor (IO)',
	'stopped' => 'Detenido...',
	'supprimer_document' => 'Eliminar el documento',
	'swfupload_alternative_js' => 'Debe activar el javascript para publicar un documento',

	// T
	'temps_passe' => 'pasado',
	'temps_restant' => 'restante',
	'titre_lien_publier' => 'Publicar',
	'titre_medias_preparation' => 'Sus medias en preparación',
	'titre_modification_media' => 'Modificación del media: @titre@',
	'titre_nouveau_document' => 'Nuevo documento',
	'titre_nouveau_document_audio' => 'Nuevo documento audio',
	'titre_nouveau_document_image' => 'Nueva imagen',
	'titre_nouveau_document_texte' => 'Nuevo documento texto',
	'titre_nouveau_document_video' => 'Nuevo documento vídeo',
	'type_aucun' => 'Ningún tipo específico',
	'type_audio' => 'Audio',
	'type_file' => 'Textuel', # NEW
	'type_image' => 'Imagen',
	'type_invalide' => 'El tipo de documento elegido no es válido, modifique su elección.',
	'type_media' => 'Tipo de media: ',
	'type_normal' => 'Ningún tipo específico',
	'type_obligatoire' => 'La configuración del sitio le obliga a elegir un tipo de documento. Seleccione el que desee en la siguiente lista. ',
	'type_texte' => 'Texto',
	'type_video' => 'Vídeo',
	'types_fichiers_autorises' => 'El conjunto de las extensiones de archivo autorizadas son: @types@',

	// U
	'unhandled_error' => 'Error desconocido',
	'unselect_all' => 'Desmarcar todo',
	'upload_error' => 'Error de publicación',
	'upload_failed' => 'La publicación ha fallado. ',
	'upload_fichiers' => 'Publicación de los archivos',
	'upload_limit_exceeded' => 'Límite de publicación en ered excedido',
	'uploading' => 'Publicado',

	// V
	'verification_fichier' => 'Verificación del archivo...',
	'verifier_formulaire' => 'Hay errores.<br />Verifique el contenido del formulario.'
);

?>

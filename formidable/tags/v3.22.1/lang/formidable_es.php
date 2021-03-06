<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de https://trad.spip.net/tradlang_module/formidable?lang_cible=es
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'admin_reponses_auteur' => 'Autorizar a l@s autores de los formularios a modificar las respuestas',
	'admin_reponses_auteur_explication' => 'Solo l@s administradores pueden normalmente modificar las respuestas a un formulario (a la papelera, publicada, propuesta para evaluación). Esta opción permite a un·a autor·a de formulario modificar el estatus (con el riesgo de distorsionar eventuales estadísticas).',
	'analyse_avec_reponse' => 'Respuestas no vacías',
	'analyse_exclure_champs_explication' => 'Ingresar el nombre de los campos a excluir del análisis, separados por unos <code>|</code>. No poner los <code>@</code>.', # MODIF
	'analyse_exclure_champs_label' => 'Campos a excluir',
	'analyse_exporter' => 'Exportar análisis',
	'analyse_longueur_moyenne' => 'Longitud media de las palabras',
	'analyse_nb_reponses_total' => '@nb@ personas han respondido a este formulario. ',
	'analyse_sans_reponse' => 'Sin respuesta',
	'analyse_une_reponse_total' => 'Una persona ha respondido a este formulario. ',
	'analyse_zero_reponse_total' => 'Nadie ha respondido a este formulario.',
	'aucun_traitement' => 'Ningún tratamiento',

	// B
	'bouton_formulaires' => 'Formularios',
	'bouton_revert_formulaire' => 'Volver a la última versión grabada',

	// C
	'cfg_analyse_classe_explication' => 'Puede especificar clases CSS que se añadirán en el envase de cada gráfico, tales como: <code>gray</code>,<code>blue</code>,
		<code>orange</code>, <code>green</code> o las que quieras!', # MODIF
	'cfg_analyse_classe_label' => 'Clase CSS de la barra de progreso',
	'cfg_titre_page_configurer_formidable' => 'Configurar Formidable',
	'cfg_titre_parametrages_analyse' => 'Configuración en el análisis de respuestas',
	'champs' => 'Campos',
	'changer_statut' => 'Este formulario es:',

	// E
	'echanger_formulaire_forms_importer' => 'Forms & Tables (.xml)',
	'echanger_formulaire_wcs_importer' => 'W.C.S. (.wcs)',
	'echanger_formulaire_yaml_importer' => 'Formidable (.yaml)',
	'editer_apres_choix_formulaire' => 'El formulario, de nuevo',
	'editer_apres_choix_redirige' => 'Redirigir a una nueva dirección',
	'editer_apres_choix_rien' => 'Nada',
	'editer_apres_choix_stats' => 'Estadísticas de respuesta',
	'editer_apres_choix_valeurs' => 'Los valores ingresados',
	'editer_apres_explication' => 'Después de la validación, mostrar en lugar del formulario:',
	'editer_apres_label' => 'Mostrar a continuación',
	'editer_descriptif' => 'Descripción',
	'editer_descriptif_explication' => 'Una explicación del formulario para la zona privada.',
	'editer_identifiant' => 'Nombre de usuario',
	'editer_identifiant_explication' => 'Da un único identificador textual que permita llamar al formulario de manera más sencilla', # MODIF
	'editer_menu_auteurs' => 'Configurar l@s autor@s',
	'editer_menu_champs' => 'Configurar los campos',
	'editer_menu_formulaire' => 'Configurar el formulario',
	'editer_menu_traitements' => 'Configurar los tratamientos',
	'editer_message_ok' => 'Mensaje de respuesta',
	'editer_message_ok_explication' => 'Puedes personalizar el mensaje que se mostrará al usuario después de enviar un formulario válido.', # MODIF
	'editer_modifier_formulaire' => 'Modificar el formulario',
	'editer_nouveau' => 'Nuevo formulario',
	'editer_redirige_url' => 'Dirección de reenvío después de la validación',
	'editer_redirige_url_explication' => 'Dejar en blanco si quieres permanecer en la misma página',
	'editer_titre' => 'Título',
	'erreur_autorisation' => 'No tienes permisos para editar los formularios web',
	'erreur_base' => 'Se ha producido un error técnico mientras se salvavan los datos.',
	'erreur_generique' => 'Hay errores en los campos a continuación. Por favor, comprueba. ',
	'erreur_identifiant' => 'El nombre de usuario ya está siendo utilizado.',
	'erreur_identifiant_format' => 'El identificador solo puede contener cifras, letras y el carácter "_"', # MODIF
	'erreur_importer_forms' => 'Error durante la importación de Forms&Tables',
	'erreur_importer_wcs' => 'Error durante la importación del formulario W.C.S',
	'erreur_importer_yaml' => 'Error durante la importación del archivo YAML',
	'erreur_inexistant' => 'Este formulario no existe. ',
	'exporter_formulaire_format_label' => 'Formato de archivo',
	'exporter_formulaire_statut_label' => 'Respuestas',

	// F
	'formulaire_anonyme_explication' => 'Este formulario es anónimo; significa que que la identidad del usuario no será guardada. ',
	'formulaires_aucun' => 'Todavía no existe ningún formulario.',
	'formulaires_aucun_champ' => 'Todavía este formulario no contiene ningún campo.',
	'formulaires_dupliquer' => 'Duplicar el formulario',
	'formulaires_dupliquer_copie' => '(copia)',
	'formulaires_introduction' => 'Crea y configura los formularios de tu sitio aquí.',
	'formulaires_nouveau' => 'Crea un nuevo formulario',
	'formulaires_supprimer' => 'Eliminar el formulario. ',
	'formulaires_supprimer_confirmation' => 'Atención, también se eliminarán todos los resultados. ¿Está seguro de que desea eliminar este formulario?',
	'formulaires_tous' => 'Todos los formularios',

	// I
	'identification_par_cookie' => 'Por cookie',
	'identification_par_id_auteur' => 'Por el identificador (id_auteur) de la persona autenticada',
	'importer_formulaire' => 'Importar un formulario',
	'importer_formulaire_fichier_label' => 'Archivo a importar',
	'importer_formulaire_format_label' => 'Formato de archivo',
	'info_1_formulaire' => '1 formulario',
	'info_1_reponse' => '1 respuesta',
	'info_aucun_formulaire' => 'Ningún formulario',
	'info_aucune_reponse' => 'Ninguna respuesta',
	'info_formulaire_refuse' => 'Archivado',
	'info_formulaire_utilise_par' => 'Formulario utilizado por:',
	'info_nb_formulaires' => '@nb@ formularios',
	'info_nb_reponses' => '@nb@ respuestas',
	'info_reponse_proposee' => 'A moderar',
	'info_reponse_proposees' => 'A moderar',
	'info_reponse_publiee' => 'Validada',
	'info_reponse_publiees' => 'Validadas',
	'info_reponse_supprimee' => 'Borrada', # MODIF
	'info_reponse_supprimees' => 'Borradas', # MODIF
	'info_reponse_toutes' => 'Todas',
	'info_utilise_1_formulaire' => 'Formulario utilizado:',
	'info_utilise_nb_formulaires' => 'Formularios utilizados:',

	// M
	'modele_label_formulaire_formidable' => '¿Cuál formulario?',
	'modele_nom_formulaire' => 'un formulario',

	// N
	'noisette_label_afficher_titre_formulaire' => '¿Mostrar el título del formulario? ',
	'noisette_label_identifiant' => 'Formulario a mostrar:',
	'noisette_nom_noisette_formulaire' => 'Formulario',

	// R
	'reponse_aucune' => 'Ninguna respuesta',
	'reponse_intro' => '@auteur@ respondió el formulario @formulaire@',
	'reponse_numero' => 'Respuesta numéro:',
	'reponse_statut' => 'Esta respuesta es:',
	'reponse_supprimer' => 'Eliminar esta respuesta',
	'reponse_supprimer_confirmation' => '¿Estás seguro de que deseas eliminar esta respuesta?',
	'reponse_une' => '1 respuesta',
	'reponses_analyse' => 'Analizar las respuestas',
	'reponses_anonyme' => 'Anónimo',
	'reponses_auteur' => 'Usuario',
	'reponses_exporter' => 'Exportar las respuestas',
	'reponses_exporter_statut_tout' => 'Todas',
	'reponses_ip' => 'Dirección IP',
	'reponses_liste' => 'Lista de respuestas',
	'reponses_liste_prop' => 'Respuestas pendientes de validación',
	'reponses_liste_publie' => 'Todas las respuestas validadas',
	'reponses_nb' => '@nb@ respuestas',
	'reponses_supprimer' => 'Borrar todas las respuestas a este formulario', # MODIF
	'reponses_supprimer_confirmation' => '¿Confirma la supresión de todas las respuestas a este formulario?',
	'reponses_voir_detail' => 'Ver la respuesta',
	'retour_aucun_traitement' => 'Su respuesta ha sido enviada, pero ningún tratamiento ha sido definido para este formulario. ¡No se hizo nada con sus datos!',

	// S
	'sans_reponses' => 'Sin respuesta',

	// T
	'texte_statut_poubelle' => 'borrada', # MODIF
	'texte_statut_propose_evaluation' => 'propuesta',
	'texte_statut_publie' => 'validada',
	'texte_statut_refuse' => 'archivado',
	'titre_cadre_raccourcis' => 'Accesos directos',
	'titre_formulaires_archives' => 'Archivos',
	'titre_reponses' => 'Respuestas',
	'traitements_actives' => 'Tratamientos activados',
	'traitements_aide_memoire' => 'Ayuda memoria: ',
	'traitements_avertissement_creation' => 'Los cambios en los campos del formulario se han guardado correctamente. Ahora puedes definir que tratamientos se llevarán a cabo cuando se utilice el formulario.',
	'traitements_avertissement_modification' => 'Los cambios en los campos del formulario se han guardado correctamente. <strong>Algunos tratamientos pueden necesitar ser reconfigurados en consecuencia. </strong>',
	'traitements_champ_aucun' => 'Ninguno',
	'traiter_email_description' => 'Publicar los resultados del formulario por correo electrónico a una lista de destinatarios.', # MODIF
	'traiter_email_horodatage' => 'Formulario "@formulaire@" publicado el @date@ a las @heure@.',
	'traiter_email_message_erreur' => 'Se ha producido un error al enviar el correo electrónico. ',
	'traiter_email_message_ok' => 'Tu mensaje ha sido enviado por correo electrónico.',
	'traiter_email_option_activer_accuse_label_case' => 'También enviar un correo electrónico al remitente con un mensaje de confirmación.',
	'traiter_email_option_destinataires_champ_form_explication' => 'Si uno de sus campos es una dirección de correo electrónico y si desea mandar el formulario a esta dirección, seleccione el campo.',
	'traiter_email_option_destinataires_champ_form_label' => 'Destinatario presente en uno de los campos de los formularios',
	'traiter_email_option_destinataires_explication' => 'Elige el campo que corresponde a los destinatarios del mensaje.', # MODIF
	'traiter_email_option_destinataires_label' => 'Destinatarios',
	'traiter_email_option_destinataires_plus_explication' => 'Una lista de direcciones separadas por coma',
	'traiter_email_option_destinataires_plus_label' => 'Destinatarios extra',
	'traiter_email_option_envoyeur_courriel_explication' => 'Selecciona el campo que contendrá la dirección de correo electrónico del remitente.',
	'traiter_email_option_envoyeur_courriel_label' => 'Enviar email',
	'traiter_email_option_envoyeur_nom_explication' => 'Construye este nombre usando los @raccourcis@ (usa la ayuda memoria). Si lo dejas en blanco se usará el nombre del sitio. ',
	'traiter_email_option_envoyeur_nom_label' => 'Nombre del remitente',
	'traiter_email_option_sujet_accuse_label' => 'Asunto del acuse de recibo. ',
	'traiter_email_option_sujet_explication' => 'Construye este asunto usando los @raccourcis@ (usa la ayuda memoria). Si lo dejas en blanco se usará uno por defecto. ',
	'traiter_email_option_sujet_label' => 'Asunto del mensaje', # MODIF
	'traiter_email_option_vrai_envoyeur_explication' => 'Algunos servidores SMTP no permiten el uso de un correo electrónico arbitrario para el campo "From". Por esta razón Formidable inserta  por defecto el correo del remitente en el campo "Reply-to". Marca aquí para insertarlo en el campo "From".',
	'traiter_email_option_vrai_envoyeur_label' => 'Inserta el correo del remitente en el campo "From"',
	'traiter_email_page' => '<a href="@url@">Desde esta página</a>.',
	'traiter_email_sujet' => '@nom@ ha escrito a usted.',
	'traiter_email_sujet_accuse' => 'Gracias por su respuesta. ',
	'traiter_email_sujet_courriel_label' => 'Asunto del mensaje', # MODIF
	'traiter_email_titre' => 'Enviar por correo electrónico',
	'traiter_email_url_enregistrement' => 'Puede gestionar las respuestas <a href="@url@">desde esta página</a>.', # MODIF
	'traiter_enregistrement_description' => 'Salvar los resultados del formulario en una base de datos', # MODIF
	'traiter_enregistrement_erreur_base' => 'Se ha producido un error técnico mientras se escribía en la base de datos',
	'traiter_enregistrement_erreur_deja_repondu' => 'Usted ya ha respondido a este formulario.',
	'traiter_enregistrement_erreur_edition_reponse_inexistante' => 'La respuesta a editar no puso ser encontrada. ',
	'traiter_enregistrement_message_ok' => 'Gracias. Sus respuestas fueron grabadas.', # MODIF
	'traiter_enregistrement_option_anonymiser_explication' => 'Resultados anónimos (no mantener ningún tipo de datos de los usuarios que han respondido).',
	'traiter_enregistrement_option_anonymiser_label' => 'Anonimizar el formulario',
	'traiter_enregistrement_option_anonymiser_variable_explication' => '¿Qué variable de sistema utilizará para calcular un valor único para cada autor sin revelar su identidad ?',
	'traiter_enregistrement_option_anonymiser_variable_label' => 'Variable del formulario que anonimiza',
	'traiter_enregistrement_option_auteur' => 'Utilizar l@s autor@s para los formularios',
	'traiter_enregistrement_option_auteur_explication' => 'Atribuir un@ o vari@s autor@s a un formulario. Si esta opción esta activada, solo l@s autor@s de un formulario podrán acceder a sus datos.',
	'traiter_enregistrement_option_choix_select_label' => 'Seleccione una variable de las disponibles',
	'traiter_enregistrement_option_identification_explication' => '¿Si las respuestas se pueden modificar, cuál es el método para usar en primer lugar para conocer la respuesta a modificar?',
	'traiter_enregistrement_option_identification_label' => 'Identificación',
	'traiter_enregistrement_option_ip_label' => 'Grabar las IPs (ocultadas después de un tiempo de guardia)',
	'traiter_enregistrement_option_moderation_label' => 'Moderación',
	'traiter_enregistrement_option_modifiable_explication' => 'Modificable: Los visitantes pueden cambiar sus respuestas con posterioridad.',
	'traiter_enregistrement_option_modifiable_label' => 'Respuestas modificables',
	'traiter_enregistrement_option_multiple_explication' => 'Multiple: Una misma persona puede responder varias veces el formulario.',
	'traiter_enregistrement_option_multiple_label' => 'Respuestas múltiples',
	'traiter_enregistrement_titre' => 'Registra los resultados',

	// V
	'voir_exporter' => 'Exportar el formulario',
	'voir_numero' => 'Formulario número:',
	'voir_reponses' => 'Ver las respuesta',
	'voir_traitements' => 'Tratamientos'
);

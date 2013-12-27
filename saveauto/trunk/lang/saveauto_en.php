<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/saveauto?lang_cible=en
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_sauvegarder' => 'Backup the database',

	// C
	'colonne_auteur' => 'Created by',
	'colonne_nom' => 'Name',

	// E
	'erreur_impossible_creer_verifier' => 'Can not create the @fichier@ file: check write access rights are available for the @rep_bases@ directory.',
	'erreur_impossible_liste_tables' => 'Can not list the tables in the database.',
	'erreur_probleme_donnees_corruption' => 'Problem with data in the @table@ table, it may be corrupted!',
	'erreur_repertoire_inaccessible' => 'The @rep@ directory is not open for write access.',

	// H
	'help_cfg_generale' => 'These configuration settings apply to all backups, manual or automatic.',
	'help_contenu' => 'Choose the settings of the contents of your backup file.',
	'help_contenu_auto' => 'Choose the content of automatic backups.',
	'help_frequence' => 'Enter the frequency of automatic backups in days.',
	'help_liste_tables' => 'By default, all tables are exported with the exception of tables @noexport@. If you want to choose precisely the tables to save open the list by unchecking the box below.', # MODIF
	'help_mail_max_size' => 'Enter the maximum size in MB of the backup file beyond which the mail will not be sent (value to check with your mail provider).',
	'help_max_zip' => 'The backup file is automatically zipped if its size is less than a threshold. Enter the threshold in megabytes (This threshold is necessary to not crash the server by making a too big zip)',
	'help_notif_active' => 'If you wish to be notified of automatic processing, enable the notifications. For automatic backup you will receive the generated file by mail if it is not too large and if the "Facteur" plugin is enabled.',
	'help_notif_mail' => 'Enter addresses separated by commas ",". These addresses are added to the one of the webmaster.',
	'help_obsolete' => 'Enter the storage life of the backups in days',
	'help_prefixe' => 'Enter a prefix added to the name of each  backup file',
	'help_restauration' => '<strong>Warning !!!</strong> the backups made are <strong>not in SPIP format</strong> and can’t be used with the restore tool of the database from SPIP.<br /><br />

For restoration, you must use the <strong>phpmyadmin</strong> interface of your database server.<br /><br />

The backups contain an SQL formatted file with the commands used to <strong>delete</strong> the existing SPIP tables and to <strong>replace</strong> them with archived data. Any data <strong>more recent</strong> than those in the backup will therefore be <strong>LOST</strong>!',
	'help_sauvegarde_1' => 'This option allows you to save the structure and content of the database in a MySQL format file that will be stored in the folder tmp/dump/. The file is named
<em>@prefixe@_yyyymmdd_hhmmss.</em>. The table prefix is retained.',
	'help_sauvegarde_2' => 'Automatic backup is enabled (frequency in days: @frequence@).',

	// I
	'info_sql_auteur' => 'Author: ',
	'info_sql_base' => 'Database:',
	'info_sql_compatible_phpmyadmin' => 'SQL file 100% compatible with PHPMyadmin',
	'info_sql_date' => 'Date:',
	'info_sql_debut_fichier' => 'Start of file',
	'info_sql_donnees_table' => 'Datas from the table @table@',
	'info_sql_fichier_genere' => 'This file is generated by the Saveauto plugin',
	'info_sql_fin_fichier' => 'End of file',
	'info_sql_ipclient' => 'Client IP:',
	'info_sql_mysqlversion' => 'MySQL version:',
	'info_sql_os' => 'Server O/S:',
	'info_sql_phpversion' => 'PHP version:',
	'info_sql_plugins_utilises' => '@nb@ plugins used:',
	'info_sql_serveur' => 'Server:',
	'info_sql_spip_version' => 'SPIP version:',
	'info_sql_structure_table' => 'Structure of the @table@ table',

	// L
	'label_donnees' => 'Datas from the tables',
	'label_frequence' => 'Frequency of the backups',
	'label_mail_max_size' => 'Threshold for sending email',
	'label_max_zip' => 'Threshold of the zips',
	'label_nettoyage_journalier' => 'Enable daily cleaning of archives',
	'label_notif_active' => 'Enable the notifications',
	'label_notif_mail' => 'Email addresses to notify',
	'label_obsolete_jours' => 'Backup storage',
	'label_prefixe_sauvegardes' => 'Prefix:',
	'label_sauvegarde_reguliere' => 'Enable regular backup',
	'label_structure' => 'Structure of the tables',
	'label_toutes_tables' => 'Backup all tables', # MODIF
	'legend_cfg_generale' => 'General settings of the backups',
	'legend_cfg_notification' => 'Notifications',
	'legend_cfg_sauvegarde_reguliere' => 'Automatic processing',

	// M
	'message_aucune_sauvegarde' => 'There are no backups to download.',
	'message_cleaner_sujet' => 'Backup cleanup',
	'message_notif_cleaner_intro' => 'Automatic deletion of outdated backups (which is earlier than @duree@ days) was successful. The following files were deleted:',
	'message_notif_sauver_intro' => 'The backup of the database @base@ has been successfully done by the author @auteur@.',
	'message_sauvegarde_nok' => 'Error during the SQL backup of the database.',
	'message_sauvegarde_ok' => 'The SQL backup of the database was created successfully.',
	'message_sauver_sujet' => 'Backup of the database @base@',
	'message_telechargement_nok' => 'Error downloading.',

	// T
	'titre_boite_historique' => 'MySQL backups available for download',
	'titre_boite_sauver' => 'Create a MySQL backup',
	'titre_page_configurer' => 'Saveauto plugin configuration',
	'titre_page_saveauto' => 'Backup the database in MySQL format',
	'titre_saveauto' => 'Automatic backups'
);

?>

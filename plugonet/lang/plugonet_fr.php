<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

$GLOBALS[$GLOBALS['idx_lang']] = array(

// B
	'bouton_generer' => 'G&eacute;n&eacute;rer',
	'bouton_verifier' => 'V&eacute;rifier',
	'bouton_plugonet' => 'PlugOnet',
	'bouton_tout_cocher' => 'Tout cocher',
	'bouton_tout_decocher' => 'Tout d&eacute;cocher',

// I
	'info_forcer_paquetxml' => 'Par d&eacute;faut, le fichier paquet.xml n\'est &eacute;crit que si son contenu est valide selon la nouvelle DTD. Vous pouvez cependant forcer son &eacute;criture quel que soit le r&eacute;sultat de la validation.',
	'info_simuler_paquetxml' => 'Par d&eacute;faut, les fichiers r&eacute;sultat sont cr&eacute;&eacute;s dans le dossier d\'installation de chaque plugin. Vous pouvez cependant choisir de les cr&eacute;er dans un dossier temporaire du site.',
	'info_generer' => 'Cette option vous permet de g&eacute;n&eacute;rer le nouveau fichier paquet.xml de description d\'un plugin &agrave; partir du fichier plugin.xml existant.<br />Outre le fichier paquet.xml, les fichiers de langue des items slogan et description du plugin ainsi qu\'un fichier de commandes Unix sont cr&eacute;&eacute;s dans des dossiers propres &agrave; chaque plugin.',
	'info_generer_pluginxml' => 'Choisissez les fichiers que vous souhaitez convertir parmi ceux pr&eacute;sents dans le dossier <code>plugins/</code> de ce site.',
	'info_verifier' => 'Cette option vous permet de v&eacute;rifier le fichier plugin.xml de description d\'un plugin afin d\'anticiper des probl&egrave;mes lors de g&eacute;n&eacute;ration du fichier paquet.xml. Ce formulaire propose la liste des fichiers plugin.xml pr&eacute;sents dans le dossier <code>plugins/</code> de ce site.',
	'info_verifier_pluginxml' => 'Choisissez le fichier plugin.xml que vous souhaitez v&eacute;rifier.',

// L
	'label_choisir_pluginxml' => 'plugin.xml disponibles',
	'label_forcer_oui' => 'Oui, forcer l\'&eacute;criture',
	'label_forcer_non' => 'Non, respecter les r&eacute;sultats de la validation',
	'label_generer_paquetxml' => 'Fichiers r&eacute;sultat',
	'label_simuler_oui' => 'Oui, &eacute;crire dans le dossier temporaire tmp/plugonet/',
	'label_simuler_non' => 'Non, &eacute;crire dans le dossier plugins/ du site',

// M
	'message_nok_aucun_pluginxml' => 'Aucun fichier plugin.xml trouv&eacute; dans le dossier des plugins de ce site.',
	'message_paquetxml_generes' => '@nb_fichiers@ plugin.xml trait&eacute;(s) : @details@',
	'message_nok_lecture_pluginxml' => 'plugin.xml inaccessible(s) en lecture : @nb_fichiers@',
	'message_nok_information_pluginxml' => 'plugin.xml illisibles au sens XML : @nb_fichiers@',
	'message_nok_validation_paquetxml' => 'paquet.xml non conforme(s) &agrave; la nouvelle DTD : @nb_fichiers@',
	'message_ok_generation_paquetxml' => 'paquet.xml g&eacute;n&eacute;r&eacute;(s) correctement : @nb_fichiers@',

// O
	'onglet_generer' => 'G&eacute;n&eacute;rer paquet.xml',
	'onglet_verifier' => 'V&eacute;rifier plugin.xml',
	'option_aucun_pluginxml' => 'aucun plugin.xml s&eacute;lectionn&eacute;',

// T
	'titre_form_generer' => 'G&eacute;n&eacute;ration des fichiers paquet.xml',
	'titre_form_verifier' => 'V&eacute;rification des fichiers plugin.xml',
	'titre_page_navigateur' => 'PlugOnet',
	'titre_page' => 'PlugOnet',

);

?>
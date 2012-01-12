<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.org
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucunmodule' => 'Žiaden modul.',

	// B
	'bouton_activer_lang' => 'Aktivovať jazyk "@lang@" pre tento modul',
	'bouton_supprimer_module' => 'Odstrániť tento modul',
	'bouton_traduire' => 'Prekladať >>',

	// C
	'cfg_form_tradlang_autorisations' => 'Povolenia',
	'cfg_inf_type_autorisation' => 'Ak si vyberiete podľa stavu alebo autora, budete vyzvaní, aby ste si vybrali stavy alebo autorov.',
	'cfg_lbl_autorisation_auteurs' => 'Povoliť zoznam autorov',
	'cfg_lbl_autorisation_statuts' => 'Povoliť podľa funkcií autorov',
	'cfg_lbl_autorisation_webmestre' => 'Povoliť iba webmasterom',
	'cfg_lbl_liste_auteurs' => 'Autori stránky',
	'cfg_lbl_statuts_auteurs' => 'Možné stavy',
	'cfg_lbl_type_autorisation' => 'Spôsob pridelenia povolení',
	'cfg_legend_autorisation_configurer' => 'Riadiť zásuvný modul',
	'cfg_legende_autorisation_modifier' => 'Upraviť preklady',
	'cfg_legende_autorisation_voir' => 'Zobraziť prekladateľské rozhranie',
	'codelangue' => 'Kód jazyka',
	'crayon_changer_statut' => 'Pozor! Zmenili ste text reťazca bez toho, aby ste zmenili jeho stav.',

	// E
	'entrerlangue' => 'Pridať kód jazyka',
	'erreur_aucun_item_langue_mere' => 'Jazyk autora "@lang_mere@" neobsahuje žiadne položky',
	'erreur_aucun_module' => 'V databáze nie sú k dispozícii žiadne moduly.',
	'erreur_autorisation_modifier_modules' => 'Jazykové moduly nemáte povolené prekladať.',
	'erreur_autoriser_profil' => 'Nemáte povolené upravovať tento profil.',
	'erreur_choisir_lang_cible' => 'Vyberte si cieľový jazyk prekladu.',
	'erreur_choisir_lang_orig' => 'Vyberte jazyk originálu, ktorý bude slúžiť ako základ pre preklad.',
	'erreur_choisir_module' => 'Vyberte si modul, ktorý chcete preložiť.',
	'erreur_code_langue_existant' => 'Táto variéta jazyka už v tomto module existuje',
	'erreur_code_langue_invalide' => 'Tento kód jazyka je neplatný',
	'erreur_langues_autorisees_insuffisantes' => 'Musíte si vybrať aspoň dva jazyky',
	'erreur_langues_differentes' => 'Vyberte si iný cieľový jazyk ako jazyk autora',
	'erreur_module_inconnu' => 'Tento modul nie je dostupný',
	'erreur_pas_langue_cible' => 'Vyberte si cieľový jazyk',
	'erreur_repertoire_local_inexistant' => 'Pozor: priečinok, ktorý sa používa na ukladanie súborov lokálne, "squelettes/lang" neexistuje',
	'explication_langue_cible' => 'Jazyk, do ktorého prekladáte.',
	'explication_langue_origine' => 'Jazyk, z ktorého prekladáte (dostupné sú iba jazyky doplnené na 100 %).',
	'explication_langues_autorisees' => 'Používatelia budú môcť vytvárať nové preklady iba vo zvolených jazykoch.',
	'explication_limiter_langues_bilan' => 'Podľa predvolených nastavení sa zobrazí @nb@ jazykov, ak si používatelia nezvolia preferované jazyky v svojom profile.',
	'explication_limiter_langues_bilan_nb' => 'Koľko jazykov sa zobrazí podľa predvolených nastavení (bude vybraná väčšina jazykov).',
	'explication_sauvegarde_locale' => 'Uloží súbory na stránku do priečinka "squelettes"',
	'explication_sauvegarde_post_edition' => 'Uloží dočasné súbory vždy, keď zmeníte text jazykového reťazca',

	// I
	'icone_modifier_tradlang' => 'Upraviť tento jazykový reťazec',
	'icone_modifier_tradlang_module' => 'Upraviť tento jazykový modul',
	'importer_module' => 'Nahráva sa nový jazykový modul',
	'importermodule' => 'Nahrať modul',
	'info_1_tradlang' => '@nb@ jazykových reťazcov',
	'info_1_tradlang_module' => '1 jazykový modul',
	'info_aucun_tradlang_module' => 'Žiaden jazykový modul',
	'info_chaine_jamais_modifiee' => 'Tento reťazec sa ešte nikdy neupravoval.',
	'info_chaine_originale' => 'Tento reťazec je reťazec originálu',
	'info_filtrer_status' => 'Filtrovať podľa stavu:',
	'info_langue_mere' => '(jazyk autora)',
	'info_langues_non_preferees' => 'Iné jazyky:',
	'info_langues_preferees' => 'Obľúbený (-é) jazyk(y):',
	'info_module_traduction' => '@total@ @statut@ (@percent@ %)',
	'info_module_traduit_pc' => 'Modul preložený na @pc@ %',
	'info_module_traduit_pc_lang' => 'Module "@module@" traduit à @pc@% en @lang@ (@langue_longue@)', # NEW
	'info_modules_priorite_traduits_pc' => 'Les modules de priorité "@priorite@" sont traduits à @pc@% en @lang@', # NEW
	'info_nb_items_module' => '@nb@ items dans le modules "@module@"', # NEW
	'info_nb_items_module_modif' => '@nb@ items du module "@module@" sont modifiés et à vérifier en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_module_modif_aucun' => 'Aucun item du module "@module@" n\'est modifié et à vérifier en @lang@ (@langue_longue@)', # NEW
	'info_nb_items_module_modif_un' => 'Un item du module "@module@" est modifié et à vérifier en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_module_new' => '@nb@ items du module "@module@" sont à traduire en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_module_new_aucun' => 'Aucun item du module "@module@" n\'est à traduire en @lang@ (@langue_longue@)', # NEW
	'info_nb_items_module_new_un' => 'Un item du module "@module@" est à traduire en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_module_ok' => '@nb@ items du module "@module@" sont traduits en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_module_ok_aucun' => 'Aucun item du module "@module@" n\'est traduit en @lang@ (@langue_longue@)', # NEW
	'info_nb_items_module_ok_un' => 'Un item du module "@module@" est traduit en @lang@ (@langue_longue@)"', # NEW
	'info_nb_items_priorite' => 'Les modules de priorité "@priorite@" ont @nb@ items', # NEW
	'info_nb_items_priorite_modif' => '@pc@% des items de priorité "@priorite@" sont modifiés et à vérifier en @lang@ (@langue_longue@)', # NEW
	'info_nb_items_priorite_new' => '@pc@% des items de priorité "@priorite@" sont nouveaux en @lang@ (@langue_longue@)', # NEW
	'info_nb_items_priorite_ok' => 'Les modules de priorité "@priorite@" sont traduits à @pc@% en @lang@ (@langue_longue@)', # NEW
	'info_nb_tradlang' => '@nb@ jazykových reťazcov',
	'info_nb_tradlang_module' => '@nb@ jazykových modulov',
	'info_percent_chaines' => '@traduites@/@total@ preložených reťazcov v "[@langue@] @langue_longue@"',
	'info_status_ok' => 'OK',
	'info_str' => 'Text jazykového reťazca',
	'info_traduire_module_lang' => 'Traduire le module "@module@" en @langue_longue@ (@lang@)', # NEW
	'infos_trad_module' => 'Informácie o prekladoch',
	'item_creer_langue_cible' => 'Vytvoriť nový cieľový jazyk',
	'item_langue_cible' => 'Cieľový jazyk: ',
	'item_langue_origine' => 'Jazyk originálu:',
	'item_manquant' => 'v tomto jazyku chýba jedna položka (z jazyka autora)',
	'items_en_trop' => 'v tomto jazyku je naviac @nb@ položiek (oproti jazyku autora)',
	'items_manquants' => 'v tomto jazyku chýba @nb@ položiek (z jazyka autora)',
	'items_modif' => 'Zmenených položiek',
	'items_new' => 'Nových položiek',
	'items_total_nb' => 'Celkový počet položiek',

	// L
	'label_id_tradlang' => 'ID reťazca',
	'label_idmodule' => 'ID modulu',
	'label_lang' => 'Jazyk',
	'label_langue_mere' => 'Jazyk autora',
	'label_langues_autorisees' => 'Povoliť len vybrané jazyky',
	'label_langues_preferees_auteur' => 'Váš (vaše) obľúbený (-é) jazyk(y)',
	'label_langues_preferees_autre' => 'Jej alebo jeho obľúbený (-é) jazyk(y)',
	'label_limiter_langues_bilan' => 'Obmedziť počet jazykov zobraziť na stránke so zoznamom',
	'label_limiter_langues_bilan_nb' => 'Počet jazykov',
	'label_nommodule' => 'Názov modulu',
	'label_priorite' => 'Priorita',
	'label_proposition_google_translate' => 'Návrh z Google Translate',
	'label_recherche_module' => 'V module: ',
	'label_recherche_status' => 'So stavom: ',
	'label_repertoire_module_langue' => 'Priečinok modulu',
	'label_sauvegarde_locale' => 'Povoliť ukladať súbory lokálne',
	'label_sauvegarde_post_edition' => 'Ukladať súbor pri každej zmene',
	'label_synchro_base_fichier' => 'Synchronizovať databázu a súbory',
	'label_texte' => 'Popis modulu',
	'label_tradlang_comm' => 'Kommentár',
	'label_tradlang_status' => 'Stav prekladu',
	'label_tradlang_str' => 'Preložený reťazec',
	'label_update_langues_cible_mere' => 'Aktualizovať tento jazyk v databáze',
	'label_version_originale' => 'Originálny reťazec (@lang@)',
	'label_version_originale_comm' => 'Komentár originálnej verzie (@lang@)',
	'label_version_selectionnee' => 'Reťazec vo vybranom jazyku (@lang@)',
	'label_version_selectionnee_comm' => 'Komentár vo vybranom jazyku (@lang@)',
	'languesdispo' => 'Dostupné jazyky',
	'legend_conf_bilan' => 'Zobrazenie zoznamu',
	'lien_accueil_interface' => 'Úvodná stránka rozhrania prekladu',
	'lien_aide_recherche' => 'Pomoc s vyhľadávaním',
	'lien_aucun_status' => 'Žiadny',
	'lien_bilan' => 'Zoznam aktuálnych prekladov.',
	'lien_code_langue' => 'Neplatný kód jazyka. V kóde jazyka musia byť aspoň dve písmená (kód ISO-631).',
	'lien_confirm_export' => 'Potvrdiť export aktuálneho súboru (tzn. prepísať obsah súboru @fichier@)',
	'lien_editer_chaine' => 'Upraviť',
	'lien_export' => 'Automaticky exportovať aktuálny súbor.',
	'lien_page_depart' => 'Vrátiť sa na úvodnú stránku?',
	'lien_profil_auteur' => 'Váš profil',
	'lien_profil_autre' => 'Jeho/jej profil',
	'lien_proportion' => 'Pomer zobrazených reťazcov',
	'lien_recharger_page' => 'Prehľadať stránku.',
	'lien_recherche_avancee' => 'Podrobné vyhľadávanie',
	'lien_retour' => 'Späť',
	'lien_retour_module' => 'Vrátiť sa na modul "@module@"',
	'lien_retour_page_auteur' => 'Späť na vašu stránku',
	'lien_retour_page_auteur_autre' => 'Späť na jeho/jej stránku',
	'lien_revenir_traduction' => 'Vrátiť sa na stránku s prekladom',
	'lien_sauvegarder' => 'Zálohovať/obnoviť aktuálny súbor.',
	'lien_telecharger' => '[Stiahnuť]',
	'lien_traduction_module' => 'Modul ',
	'lien_traduction_vers' => ' do ',
	'lien_trier_langue_non' => 'Zobraziť celý zoznam.',
	'lien_utiliser_google_translate' => 'Používať túto verziu',
	'lien_voir_toute_chaines_module' => 'Zobraziť všetky reťazce modulu.',

	// M
	'menu_info_interface' => 'Zobrazí odkaz na prekladateľské rozhranie',
	'menu_titre_interface' => 'Prekladateľské rozhranie',
	'message_aucun_resultat_chaine' => 'Vašim kritériám nevyhovujú v jazykových reťazcoch žiadne výsledky.',
	'message_aucun_resultat_statut' => 'Tento stav nemá nastavený žiaden reťazec.',
	'message_aucune_nouvelle_langue_dispo' => 'Tento modul je dostupný vo všetkých jazykoch',
	'message_confirm_redirection' => 'Budete presmerovaný na zmenu modulu',
	'message_demande_update_langues_cible_mere' => 'Môžete požiadať administrátora o opätovnú synchronizáciu tohto jazyka s hlavným jazykom.',
	'message_info_choisir_langues_profiles' => '<a href="@url_profil@">Vo svojom profile</a> si môžete vybrať obľúbené jazyky a používať ich ako predvolené.',
	'message_langues_choisies_affichees' => 'Sú zobrazené len jazyky, ktoré ste si vybrali: @langues@', # MODIF
	'message_langues_preferees_affichees' => 'Sú zobrazené len vaše obľúbené jazyky: @langues@', # MODIF
	'message_langues_utilisees_affichees' => 'Zobrazuje sa len @nb@ najpoužívanejších jazykov: @langues@', # MODIF
	'message_module_langue_ajoutee' => 'Do modulu "@module@" bol pridaný jazyk "@langue@".',
	'message_module_updated' => 'Jazykový modul "@module@" bol aktualizovaný.',
	'message_passage_trad' => 'Presun na preklad',
	'message_passage_trad_creation_lang' => 'Vytvorenie jazyka @lang@ a presun na preklad',
	'message_suppression_module_ok' => 'Modul @module@ bol odstránený.',
	'message_suppression_module_trads_ok' => 'Modul @module@ bol odstránený. @nb@ položiek, ktoré k nemu patrili boli odstránené tiež.',
	'message_synchro_base_fichier_ok' => 'Súbory a databáza sú zosynchronizované.',
	'message_synchro_base_fichier_pas_ok' => 'Súbory a databáza nie sú zosynchronizované.',
	'module_deja_importe' => 'Modul "@module@" bol už nahraný',
	'moduletitre' => 'Dostupné moduly',

	// N
	'nb_items_langue_cible' => 'Cieľový jazyk "@langue@" obsahuje @nb@ položiek definovaných v jazyku autora.',
	'nb_items_langue_en_trop' => '@nb@ položiek je príliš veľa v jazyku "@langue@".',
	'nb_items_langue_inexistants' => 'V jazyku "@langue@" neexistuje @nb@ položiek.',
	'nb_items_langue_mere' => 'Hlavný jazyk tohto modulu obsahuje @nb@ položiek.',

	// R
	'readme' => 'Tento modul umožňuje správu jazykových súborov',

	// S
	'str_status_modif' => 'Zmenený (MODIF)',
	'str_status_new' => 'Nový (NEW)',
	'str_status_traduit' => 'Preložený',

	// T
	'texte_contacter_admin' => 'Ak sa chcete zúčastniť, kontaktujte administrátora.',
	'texte_erreur' => 'CHYBA',
	'texte_erreur_acces' => '<b>Pozor:</b> do súboru <tt>@fichier_lang@</tt> sa nedá písať. Skontrolujte prístupové práva.',
	'texte_existe_deja' => ' už existuje.',
	'texte_explication_langue_cible' => 'Cieľový jazyk si musíte zvoliť, ak pracujete s jazykom, ktorý už existuje; v opačnom prípade môžete vytvoriť nový.',
	'texte_export_impossible' => 'Súbor sa nedá exportovať. Skontrolujte práva na zápis pri súbore @cible@',
	'texte_filtre' => 'Filter (vyhľadávanie)',
	'texte_inscription_ou_login' => 'Ak chcete mať prístup k prekladu, musíte sa na stránke zaregistrovať alebo príhlásiť.',
	'texte_interface' => 'Rozhranie prekladu: ',
	'texte_interface2' => 'Rozhranie prekladu',
	'texte_langue' => 'Jazyk:',
	'texte_langue_cible' => 'cieľový jazyk je jazyk, do ktorého prekladáte.',
	'texte_langue_origine' => 'jazyk originálu ako svoj model (uprednostnite jazyk autora, ak sa dá),',
	'texte_langues_differentes' => 'Cieľový jazyk a jazyk originálu sa musia odlišovať.',
	'texte_modifier' => 'Upraviť',
	'texte_module' => 'modul, ktorý chcete preložiť,',
	'texte_module_traduire' => 'Modul na preloženie:',
	'texte_non_traduit' => 'nepreložený',
	'texte_operation_impossible' => 'Operácia sa nedá vykonať. Ak ste zaškrtli pole "vybrať všetko",<br> musíte si zvoliť operáciu "Zobraziť".',
	'texte_pas_autoriser_traduire' => 'Na prístup k prekladom nemáte povolenie. ',
	'texte_pas_de_reponse' => 'žiadna reakcia',
	'texte_recapitulatif' => 'Prehľad prekladov',
	'texte_restauration_impossible' => 'súbor sa nedá obnoviť',
	'texte_sauvegarde' => 'Rozhranie prekladu, uložiť/obnoviť súbor',
	'texte_sauvegarde_courant' => 'Záložná kópia aktuálneho súboru:',
	'texte_sauvegarde_impossible' => 'súbor sa nedá uložiť',
	'texte_sauvegarder' => 'Zálohovať',
	'texte_selection_langue' => 'Ak chcete vidieť preložený jazykový súbor/jazykový súbor, ktorý sa práve prekladá, vyberte si, prosím, jazyk:',
	'texte_selectionner' => 'Na to, aby ste mohli začať prekladať, si musíte zvoliť:',
	'texte_selectionner_version' => 'Vyberte si verziu súboru a potom kliknite na tlačidlo nižšie.',
	'texte_seul_admin' => 'K tomuto kroku má prístup len administrátor.',
	'texte_total_chaine' => 'Počet reťazcov:',
	'texte_total_chaine_conflit' => 'Počet reťazcov, ktoré sa najčastejšie používajú:',
	'texte_total_chaine_modifie' => 'Počet reťazcov, ktoré treba aktualizovať:',
	'texte_total_chaine_non_traduite' => 'Počet nepreložených reťazcov:',
	'texte_total_chaine_traduite' => 'Počet preložených reťazcov:',
	'texte_tout_selectionner' => 'Vybrať všetky',
	'texte_type_operation' => 'Typ operácie',
	'texte_voir_bilan' => 'Zobraziť <a href="@url@" class="spip_in">zoznam prekladov.</a>',
	'tfoot_total' => 'Total', # NEW
	'th_avancement' => 'Postup',
	'th_comm' => 'Komentár',
	'th_items_modifs' => 'Zmenené položky',
	'th_items_new' => 'Nové položky',
	'th_items_traduits' => 'Preložené položky',
	'th_langue' => 'Jazyk',
	'th_langue_mere' => 'Jazyk autora',
	'th_langue_origine' => 'Texte v pôvodnom jazyku',
	'th_module' => 'Modul',
	'th_status' => 'Stav',
	'th_total_items_module' => 'Počet položiek celkom',
	'th_traduction' => 'Preklad',
	'titre_bilan' => 'Zoznam prekladov',
	'titre_bilan_langue' => 'Zoznam prekladov jazyka "@lang@"',
	'titre_bilan_module' => 'Zoznam prekladov modulu "@module@"',
	'titre_changer_langue_selection' => 'Zmeniť vybraný jazyk',
	'titre_changer_langues_affichees' => 'Changer les langues affichées', # NEW
	'titre_commentaires_chaines' => 'Komentáre k tomuto reťazcu',
	'titre_logo_tradlang_module' => 'Logo modulu',
	'titre_modifications_chaines' => 'Posledné zmeny tohto reťazca',
	'titre_modifier' => 'Upraviť',
	'titre_page_configurer_tradlang' => 'Nastavenia zásuvného modulu Trad-lang',
	'titre_page_tradlang_module' => 'Modul #@id@ : @module@',
	'titre_profil_auteur' => 'Upraviť profil',
	'titre_profil_autre' => 'Upraviť jeho/jej profil',
	'titre_recherche_tradlang' => 'Jazykové reťazce',
	'titre_revisions_sommaire' => 'Posledné zmeny',
	'titre_tradlang' => 'Trad-lang',
	'titre_tradlang_chaines' => 'Jazykové reťazce',
	'titre_tradlang_module' => 'Jazykový modul',
	'titre_tradlang_modules' => 'Jazykové moduly',
	'titre_traduction' => 'Preklady',
	'titre_traduction_chaine_de_vers' => 'Preklad reťazca "@chaine@" modulu "@module@" z(o) <abbr title="@lang_orig_long@">@lang_orig@</abbr> do <abbr title="@lang_cible_long@">@lang_cible@</abbr>',
	'titre_traduction_de' => 'Preklad z',
	'titre_traduction_module_de_vers' => 'Preklad modulu "@module@" z jazyka <abbr title="@lang_orig_long@">@lang_orig@</abbr> do <abbr title="@lang_cible_long@">@lang_cible@</abbr>',
	'titre_traduire' => 'Preložiť',
	'tradlang' => 'Trad-Lang',
	'traduction' => 'Preklad @lang@',
	'traductions' => 'Preklady'
);

?>

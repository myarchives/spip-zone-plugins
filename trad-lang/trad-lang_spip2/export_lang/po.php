<?php
/**
 * 
 * Trad-lang v2
 * Plugin SPIP de traduction de fichiers de langue
 * © Florent Jugla, Fil, kent1
 * 
 * Fichier des fonctions spécifiques du plugin
 */
 
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Fonction d'export d'une langue d'un module en .po
 * 
 * @param string $module Le module à exporter
 * @param string $langue La langue à exporter
 * @param string $dir_lang Le répertoire où stocker les fichiers de langue
 * @return string $fichier Le fichier final
 */
function export_lang_po_dist($module,$langue,$dir_lang){
	/**
	 * Le fichier final
	 * local/cache-lang/module_lang.po
	 */
	$fichier = $dir_lang."/".$module."_".$langue.".po";

	$tab = "\t";

	$res=sql_select("id,str,comm,statut","spip_tradlangs","module=".sql_quote($module)." AND lang=".sql_quote($langue),"id");
	$x=array();
	$tous = $lorigine; // on part de l'origine comme ca on a tout meme si c'est pas dans la base de donnees (import de salvatore/lecteur.php)
	while ($row=sql_fetch($res)) {
		$tous[$row['id']] = $row;
	}
	ksort($tous);
	foreach ($tous as $row) {
		if (strlen($row['statut']) && ($row['statut'] != 'OK'))
			$row['comm'] .= ' '.$row['statut'];
		if (trim($row['comm'])) $row['comm']=" # ".trim($row['comm']); // on rajoute les commentaires ?

		$str = $row['str'];

		$oldmd5 = md5($str);
		$str = unicode_to_utf_8(
			html_entity_decode(
				preg_replace('/&([lg]t;)/S', '&amp;\1', $str),
				ENT_NOQUOTES, 'utf-8')
		);
		$newmd5 = md5($str);
		if ($oldmd5 !== $newmd5) sql_updateq("spip_tradlangs",array('md5'=>$newmd5), "md5=".sql_quote($oldmd5)." AND module=".sql_quote($module));

		$x[]=($row['comm'] ? "#".$row['comm']."\n" : "").
"#, php-format
msgid \"".$row['id']."\"
msgstr \"".str_replace('"','\"',$str)."\"\n";
	}

	$fd = fopen($fichier, 'w');

	$contenu = join("\n",$x);
	
	/**
	 * Ecriture du fichier
	 */
	fwrite($fd,
	'# This is a SPIP language file  --  Ceci est un fichier langue de SPIP
# extrait automatiquement de '.$url_trad.'
msgid ""
msgstr ""
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"
"X-Generator: SPIP Trad Lang 2.0.5\n"
"X-Poedit-SourceCharset: utf-8\n"
'
. str_replace("\r\n", "\n", $contenu)
	);

	fclose($fd);
	@chmod($fichier, 0666);

	return $fichier;
}
?>
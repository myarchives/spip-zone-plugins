<?php



function exec_ticket_afficher () {
	global $connect_statut
		, $connect_toutes_rubriques
		, $connect_id_auteur
		;

	$id_ticket = $_GET["id_ticket"];

	include_spip('inc/presentation');
	include_spip('inc/mots');
	include_spip('inc/spiplistes_api');
	include_spip('inc/spiplistes_api_presentation');


	if (_request("modifier_ticket")) {
		$id_ticket = _request("modifier_ticket");
		$titre = _request("titre");
		$texte = _request("texte");
		$severite = _request("severite");
		$type = _request("type");
		$exemple = _request("exemple");
		$jalon = _request("jalon");
		$composant = _request("composant");
		$projet = _request("projet");
		$version = _request("version");
		

		include_spip("base/abstract_sql");


		
		if ($id_ticket == "new") {
			$id_ticket = sql_insertq("spip_tickets", 
				array("titre" => $titre, "texte" => $texte, "severite" => $severite, "type" => $type, "exemple" => $exemple, "id_auteur" => $connect_id_auteur, "statut" => "redac", "date" => "NOW()",
				"projet" => $projet, "composant" => $composant, "version" => $version, "jalon" => $jalon) 
				);
		
		} else {
		
			$query = sql_query("SELECT * FROM spip_tickets WHERE id_ticket = $id_ticket");
			if ($row = sql_fetch($query)) {
				$id_auteur = $row["id_auteur"];
				$id_assigne = $row["id_assigne"];
			}
			if ($connect_statut == "0minirezo" OR $id_auteur == $connect_id_auteur OR $id_assigne == $connect_id_auteur) {
		
				sql_updateq("spip_tickets", 
					array("titre" => $titre, "texte" => $texte, "severite" => $severite, "type" => $type, "exemple" => $exemple, "projet" => $projet, "composant" => $composant, "version" => $version, "jalon" => $jalon), 
					"id_ticket = '$id_ticket'");
			}
		}

	}
	
	if (_request("poster_message_ticket")) {
			$id_ticket = _request("poster_message_ticket");
			$texte = _request("texte");

			sql_insertq("spip_tickets_forum", 
				array("id_ticket" => $id_ticket, "texte" => $texte, "id_auteur" => $connect_id_auteur,  "date" => "NOW()") 
				);

	}


	if (_request("modifier_statut_ticket")) {
		$id_ticket = _request("modifier_statut_ticket");
		$id_assigne = _request("id_assigne");
		$statut = _request("statut");
		$ancien_statut = _request("ancien_statut");

		$query = sql_query("SELECT * FROM spip_tickets WHERE id_ticket = $id_ticket");
		if ($row = sql_fetch($query)) {
			$old_auteur = $row["id_auteur"];
			$old_assigne = $row["id_assigne"];
			$titre = $row["titre"];
			$texte = $row["texte"];
		}
		if ($connect_statut == "0minirezo" OR $old_auteur == $connect_id_auteur OR $old_assigne == $connect_id_auteur) {

			include_spip("base/abstract_sql");
				sql_updateq("spip_tickets", 
					array("id_assigne" => $id_assigne, "statut" => $statut), 
					"id_ticket = '$id_ticket'");
					
					
					
			// Envoyer mail annoncant le bug
			if ($statut != $ancien_statut AND $statut!="redac") {
				$nom_site = $GLOBALS["meta"]["nom_site"];
				$url_site = $GLOBALS["meta"]["adresse_site"];
				$url_ticket = "$url_site/ecrire/?exec=ticket_afficher&id_ticket=$id_ticket";
				$from = $GLOBALS["meta"]["email_webmaster"];
				$titre = trim($titre);
				$titre_message = "[Ticket - $nom_site] $titre - statut:".tickets_texte_statut($statut); 
				$header = "From: ". $nom_site . " <" . $from . ">\r\n";
				$message = "$titre_message\n
------------------------------------------\n
Ceci est un message automatique : n'y repondez pas.\n\n
$texte\n\n
$url_ticket";
				
				$query_auteurs = sql_query("SELECT email FROM spip_auteurs WHERE (statut='0minirezo' OR statut='1comite') AND email LIKE '%@%' ");
				while ($row_auteur = sql_fetch($query_auteurs)) {
					$recipient = $row_auteur["email"];
					mail($recipient, $titre_message, $message, $header);
					
				}
			}
		}			
	}





	$titre_page = _L('Tickets, syst&egrave;me de suivi de bugs');
	// Permet entre autres d'ajouter les classes à la page : <body class='$rubrique $sous_rubrique'>
	$rubrique = "forum";
	$sous_rubrique = "tickets";

	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo($commencer_page(_L('Tickets, suivi de bugs') . " - " . $titre_page, $rubrique, $sous_rubrique));

	echo "<br /><br />";
	

	echo debut_gauche("",true);
	
	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'ticket_afficher'),'data'=>''));
	
	
	echo debut_droite("",true);
	
	$contexte = array("id_ticket"=>$id_ticket);
	$page = recuperer_fond("prive/contenu/inc_afficher_ticket", $contexte);
	echo $page;

	echo fin_gauche(), fin_page();
}

?>
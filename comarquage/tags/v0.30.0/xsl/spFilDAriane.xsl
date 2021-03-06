<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	exclude-result-prefixes="xsl dc">

	<xsl:output method="html" encoding="UTF-8" cdata-section-elements="script" indent="yes"/> 
  	
  	<xsl:variable name="sepFilDAriane">
		<xsl:text> > </xsl:text>  	
  	</xsl:variable>
  	

	
   	<xsl:template match="FilDAriane">
   		<div class="spFilDAriane">
   			<xsl:choose>
   				<xsl:when test="$CATEGORIE = 'particuliers'">
					<xsl:variable name="title">
						<xsl:text>Vos droits et vos démarches en tant que particulier : Liste des thèmes</xsl:text>
					</xsl:variable>
		  			<!--  <div class="entiteImageFloatRight">
						<xsl:call-template name="imageOfATheme">
							<xsl:with-param name="id">
								<xsl:choose>
									<xsl:when test="//Publication/dc:type = 'Comment faire si'">
										<xsl:value-of select="//Publication/@ID"/>
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="//Publication/FilDAriane/Niveau/@ID"/>
									</xsl:otherwise>
								</xsl:choose>
							</xsl:with-param>
						</xsl:call-template>
		  			</div>
					-->
		  			<a>
						<xsl:attribute name="href"><xsl:value-of select="$REFERER"/></xsl:attribute>
						<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
						<xsl:text>Liste des thèmes </xsl:text>
					</a>
		   			
					
		 	   		<xsl:for-each select="Niveau">
						<xsl:variable name="titleNiveau">
							<xsl:text>Vos droits et vos démarches en tant que particulier : </xsl:text>
							<xsl:value-of select="text()"/>
						</xsl:variable>
			   			<xsl:value-of select="$sepFilDAriane"/>
			  			<a>
							<xsl:attribute name="href"><xsl:value-of select="$REFERER"/>xml=<xsl:value-of select="@ID"/><xsl:text>.xml</xsl:text>&#x26;xsl=spNoeud.xsl</xsl:attribute>
							<xsl:attribute name="title"><xsl:value-of select="$titleNiveau"/></xsl:attribute>
							<xsl:value-of select="text()"/>
						</a>
		    			<!--  <xsl:call-template name="getPublicationLink">
		    				<xsl:with-param name="href"><xsl:value-of select="@ID"/></xsl:with-param>
		    				<xsl:with-param name="title"><xsl:value-of select="$titleNiveau"/></xsl:with-param>
		    				<xsl:with-param name="text"><xsl:value-of select="text()"/></xsl:with-param>
						</xsl:call-template>
						-->
			   		</xsl:for-each>
		   			<xsl:value-of select="$sepFilDAriane"/>
		   			<xsl:value-of select="//Publication/dc:title"/>
		   		</xsl:when>
  				<xsl:when test="$CATEGORIE = 'associations'">
					<xsl:variable name="title">
						<xsl:text>Vos droits et vos démarches en tant qu'association</xsl:text>
					</xsl:variable>
		  			<div class="entiteImageFloatRight">
						<xsl:call-template name="imageOfATheme">
							<xsl:with-param name="id">
								<xsl:text>Associations</xsl:text>
							</xsl:with-param>
						</xsl:call-template>
		  			</div>
		   			<xsl:call-template name="getPublicationLink">
		   				<xsl:with-param name="href"><xsl:text>Theme</xsl:text></xsl:with-param>
		   				<xsl:with-param name="title"><xsl:value-of select="$title"/></xsl:with-param>
		   				<xsl:with-param name="text"><xsl:text>Liste des thèmes</xsl:text></xsl:with-param>
					</xsl:call-template>
		   			<xsl:value-of select="$sepFilDAriane"/>
		   			<xsl:value-of select="//Publication/dc:title"/>
		   		</xsl:when>
 				<xsl:when test="$CATEGORIE = 'associations'">
 					<xsl:call-template name="getFilDArianeOfPublicationEntreprise"/>
 				</xsl:when>
 		   	</xsl:choose>
	   	</div>
 	</xsl:template>
 	


	
	<xsl:template name="getFilDArianeOfPublicationEntreprise">
  		<div class="spFilDAriane">
			<xsl:variable name="title">
				<xsl:text>Vos droits et vos démarches en tant qu'entreprise : Liste des thèmes</xsl:text>
			</xsl:variable>
  			<div class="entiteImageFloatRight">
				<xsl:call-template name="imageOfATheme">
					<xsl:with-param name="id">
						<xsl:text>Entreprises</xsl:text>
					</xsl:with-param>
				</xsl:call-template>
  			</div>
  			
  			<a>
				<xsl:attribute name="href"><xsl:value-of select="$REFERER"/></xsl:attribute>
				<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
				<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
				<xsl:text>Accueil</xsl:text>
			</a>

 	   		<xsl:for-each select="//Publication/FilDAriane/Niveau">
				<xsl:variable name="titleNiveau">
					<xsl:text>Vos droits et vos démarches en tant qu'entreprise : </xsl:text>
					<xsl:value-of select="text()"/>
				</xsl:variable>
	   			<xsl:value-of select="$sepFilDAriane"/>
    			<xsl:call-template name="getPublicationLink">
    				<xsl:with-param name="href"><xsl:value-of select="@ID"/></xsl:with-param>
    				<xsl:with-param name="title"><xsl:value-of select="$titleNiveau"/></xsl:with-param>
    				<xsl:with-param name="text"><xsl:value-of select="text()"/></xsl:with-param>
				</xsl:call-template>
	   		</xsl:for-each>
   			<xsl:value-of select="$sepFilDAriane"/>
   			<xsl:value-of select="//Publication/dc:title"/>
   		</div>
	</xsl:template>
	
	<xsl:template name="getFilDArianeOfRessource">
		<xsl:param name="typeRessource" select="$typeRessource"/>
		<div class="spFilDAriane">
			<xsl:variable name="title">
			<xsl:text>Vos droits et vos démarches en tant que particulier : Liste des thèmes</xsl:text>
			</xsl:variable>
	   		<a>
				<xsl:attribute name="href"><xsl:value-of select="$REFERER"/></xsl:attribute>
				<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
				<xsl:text> Accueil</xsl:text>
			</a>

			<xsl:value-of select="$sepFilDAriane"/>
		
			<xsl:choose>
				<xsl:when test="$typeRessource = 'Teleservice'">
				 	<xsl:text>Téléservice</xsl:text>
				</xsl:when>
				<xsl:when test="$typeRessource = 'Centre-de-Contact'">
				 	<xsl:text>Centre de contact</xsl:text>
				</xsl:when>
				<xsl:when test="$typeRessource = 'Formulaire'">
				 	<xsl:text>Formulaires en ligne</xsl:text>
				</xsl:when>
				<xsl:otherwise> 
					<xsl:variable name="title">
						<xsl:text>Vos droits et vos démarches en tant que particulier : Liste des thèmes</xsl:text>
					</xsl:variable>
			   		<a>
						<xsl:attribute name="href"><xsl:value-of select="$REFERER"/></xsl:attribute>
						<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
						<xsl:text> Accueil</xsl:text>
					</a>
	
					<xsl:value-of select="$sepFilDAriane"/>
					<xsl:text> Glossaire : Toutes les définitions de A à Z </xsl:text> 
				</xsl:otherwise>
			</xsl:choose>
			
			<xsl:value-of select="$sepFilDAriane"/>
			<xsl:value-of select="//ServiceComplementaire/dc:title"/>
		</div>
	</xsl:template>
	
	<xsl:template name="getFilDArianeOfDossiersaz">
   		<div class="spFilDAriane">
			<xsl:variable name="title">
				<xsl:text>Vos droits et vos démarches en tant que particulier : Liste des thèmes</xsl:text>
			</xsl:variable>
	   		<a>
				<xsl:attribute name="href"><xsl:value-of select="$REFERER"/></xsl:attribute>
				<xsl:attribute name="title"><xsl:value-of select="$title"/></xsl:attribute>
				<xsl:text>Accueil</xsl:text>
			</a>
			<xsl:value-of select="$sepFilDAriane"/>
			<xsl:value-of select="//Publication/dc:title"/>
		</div>
	</xsl:template>

	<xsl:template name="getFilDArianeOfPivotLocal">
   		<div class="spFilDAriane">
	   		<xsl:call-template name="getPublicationLink">
				<xsl:with-param name="href"><xsl:text>Administrations</xsl:text></xsl:with-param>
				<xsl:with-param name="title"><xsl:text>Guide des administrations, des lieux publics, des artisans et des partenaires de A à Z</xsl:text></xsl:with-param>
				<xsl:with-param name="text"><xsl:text>Annuaire</xsl:text></xsl:with-param>
			</xsl:call-template>
			<xsl:value-of select="$sepFilDAriane"/>
			<xsl:value-of select="//PivotLocal/Titre"/>
		</div>
	</xsl:template>

</xsl:stylesheet>

<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0"
    xmlns:meta="urn:oasis:names:tc:opendocument:xmlns:meta:1.0"
    xmlns:config="urn:oasis:names:tc:opendocument:xmlns:config:1.0"
    xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0"
    xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0"
    xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0"
    xmlns:presentation="urn:oasis:names:tc:opendocument:xmlns:presentation:1.0"
    xmlns:dr3d="urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0"
    xmlns:chart="urn:oasis:names:tc:opendocument:xmlns:chart:1.0"
    xmlns:form="urn:oasis:names:tc:opendocument:xmlns:form:1.0"
    xmlns:script="urn:oasis:names:tc:opendocument:xmlns:script:1.0"
    xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0"
    xmlns:number="urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0"
    xmlns:anim="urn:oasis:names:tc:opendocument:xmlns:animation:1.0"

    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns:math="http://www.w3.org/1998/Math/MathML"
    xmlns:xforms="http://www.w3.org/2002/xforms"

    xmlns:fo="urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0"
    xmlns:svg="urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0"
    xmlns:smil="urn:oasis:names:tc:opendocument:xmlns:smil-compatible:1.0"
	
    xmlns:ooo="http://openoffice.org/2004/office"
    xmlns:ooow="http://openoffice.org/2004/writer"
    xmlns:oooc="http://openoffice.org/2004/calc"
    xmlns:int="http://catcode.com/odf_to_xhtml/internal"
    
    exclude-result-prefixes="office meta config text table draw presentation
		dr3d chart form script style number anim dc xlink math xforms fo
		svg smil ooo ooow oooc int"
>

<xsl:output method = "xml"
            encoding="ISO-8859-1"
            indent="yes" />
<xsl:strip-space elements="*" />

<!-- gestion des titres de fa�on la plus generique possible -->
<!-- si @text:style-name='Heading' est utilise, recuperer 'Heading' dans $STyleTitreGeneral -->
<xsl:variable name="StyleTitreGeneral">
  <xsl:if test="count(//*[node()][@text:style-name='Heading']) > 0">Heading</xsl:if>
</xsl:variable>

<!-- trouver le niveau de titre qui servira de $NivoTitre1 (= {{{intertitres}}})... a la bourrin !  -->
<xsl:variable name="NivoTitre1">
    <xsl:choose>
        <xsl:when test="count(//*[node()][@text:outline-level='1'] 
                              | //*[node()][@text:style-name='Heading_20_1']) > 0">1</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='2'] 
                              | //*[node()][@text:style-name='Heading_20_2']) > 0">2</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='3'] 
                              | //*[node()][@text:style-name='Heading_20_3']) > 0">3</xsl:when>    
        <xsl:when test="count(//*[node()][@text:outline-level='4'] 
                              | //*[node()][@text:style-name='Heading_20_4']) > 0">4</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='5'] 
                              | //*[node()][@text:style-name='Heading_20_5']) > 0">5</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='6'] 
                              | //*[node()][@text:style-name='Heading_20_6']) > 0">6</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='7'] 
                              | //*[node()][@text:style-name='Heading_20_7']) > 0">7</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='8'] 
                              | //*[node()][@text:style-name='Heading_20_8']) > 0">8</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='9'] 
                              | //*[node()][@text:style-name='Heading_20_9']) > 0">9</xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='10'] 
                              | //*[node()][@text:style-name='Heading_20_10']) > 0">10</xsl:when>
    </xsl:choose>
</xsl:variable>
<!-- idem pour le niveau $NivoTitre2 (= {{titres_gras}}) en se basant sur le niveau de $NivoTitre1... Hue! -->
<xsl:variable name="NivoTitre2">
    <xsl:choose>
        <xsl:when test="count(//*[node()][@text:outline-level=$NivoTitre1 + 1] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 1)]) > 0"><xsl:value-of select="$NivoTitre1 + 1"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 2'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 2)]) > 0"><xsl:value-of select="$NivoTitre1 + 2"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 3'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 3)]) > 0"><xsl:value-of select="$NivoTitre1 + 3"/></xsl:when>    
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 4'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 4)]) > 0"><xsl:value-of select="$NivoTitre1 + 4"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 5'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 5)]) > 0"><xsl:value-of select="$NivoTitre1 + 5"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 6'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 6)]) > 0"><xsl:value-of select="$NivoTitre1 + 6"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 7'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 7)]) > 0"><xsl:value-of select="$NivoTitre1 + 7"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 8'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 8)]) > 0"><xsl:value-of select="$NivoTitre1 + 8"/></xsl:when>
        <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre1 + 9'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1 + 9)]) > 0"><xsl:value-of select="$NivoTitre1 + 9"/></xsl:when>
    </xsl:choose>
</xsl:variable>
<!-- si il n'existe pas de $StyleTitreGeneral et si il n'y a qu'un seul element de $NivoTitre1 dans le doc 
     utiliser $NivoTitre1 comme $StyleTitreGeneral => du fait du decalage on va avoir besoin d'un $NivoTitre3  -->
<xsl:variable name="NivoTitre3">
    <xsl:if test="not($StyleTitreGeneral = 'Heading')
                  and count(//*[@text:outline-level='$NivoTitre1'] | //*[@text:style-name=concat('Heading_20_',$NivoTitre1)]) = 1">
        <xsl:choose>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 1'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 1)]) > 0"><xsl:value-of select="$NivoTitre2 + 1"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 2'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 2)]) > 0"><xsl:value-of select="$NivoTitre2 + 2"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 3'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 3)]) > 0"><xsl:value-of select="$NivoTitre2 + 3"/></xsl:when>    
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 4'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 4)]) > 0"><xsl:value-of select="$NivoTitre2 + 4"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 5'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 5)]) > 0"><xsl:value-of select="$NivoTitre2 + 5"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 6'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 6)]) > 0"><xsl:value-of select="$NivoTitre2 + 6"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 7'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 7)]) > 0"><xsl:value-of select="$NivoTitre2 + 7"/></xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level='$NivoTitre2 + 8'] 
                              | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre2 + 8)]) > 0"><xsl:value-of select="$NivoTitre2 + 8"/></xsl:when>
        </xsl:choose>
    </xsl:if>
</xsl:variable>

<!-- trouver un titre general au document: 
     si $StyleTitreGeneral existe, concatener tous les elements avec ce style
     sinon utiliser le premier element ayant le niveau de style $NivoTitre1
     sinon utiliser le premier element text:h ou text:p et basta! -->
<xsl:variable name="ContenuTitreDoc">
        <xsl:choose>
            <xsl:when test="$StyleTitreGeneral='Heading'">
                <xsl:for-each select="//*[node()][@text:style-name='Heading']"><xsl:value-of select="."/> </xsl:for-each>
            </xsl:when>
            <xsl:when test="count(//*[node()][@text:outline-level=$NivoTitre1]
                                  | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1)]
                                  ) > 0">
                <xsl:value-of select="//*[node()][@text:outline-level=$NivoTitre1][1]
                                      | //*[node()][@text:style-name=concat('Heading_20_',$NivoTitre1)][1]"/>
            </xsl:when>
           <xsl:otherwise>
                <xsl:value-of select="//text:h[node()][1] | //text:p[node()][1]"/>
            </xsl:otherwise>
        </xsl:choose>
</xsl:variable>

<xsl:template match="/office:document-content">
<!--  -->
t1= <xsl:value-of select="$NivoTitre1" />
t2= <xsl:value-of select="$NivoTitre2" />
t3= <xsl:value-of select="$NivoTitre3" />
tG= <xsl:value-of select="$StyleTitreGeneral" />

<articles>
	<article>
		<id_article></id_article>
		<surtitre></surtitre>
    <titre>:::<xsl:value-of select="$ContenuTitreDoc"/>:::</titre>
		<soustitre></soustitre>
		<id_rubrique></id_rubrique>
		<descriptif></descriptif>
		<chapo></chapo>
		<texte>
        <xsl:apply-templates select="office:body/office:text"/>
    </texte>
		<ps></ps>
		<date></date>
		<statut></statut>
		<id_secteur></id_secteur>
		<date_redac></date_redac>
		<accepter_forum></accepter_forum>
		<date_modif></date_modif>
		<lang></lang>
		<langue_choisie></langue_choisie>
		<id_trad></id_trad>
		<extra></extra>
		<nom_site></nom_site>
		<url_site></url_site>
		<url_propre></url_propre>
	</article>
</articles>    

</xsl:template>


<!-- virer une eventuelle table des matieres -->
<xsl:template match="//text:table-of-content"/>


<!-- les paragraphes y compris les vides utilises pour saut de ligne -->
<xsl:template match="text:p">
		<xsl:apply-templates/>
    <xsl:if test="count(node())=0"><xsl:text >&#xA;&#xA;</xsl:text></xsl:if>
</xsl:template>


<!-- bidouiller pour ne pas afficher le titre du document dans le texte -->
<xsl:template match="//*[@text:style-name='Heading']"/>

<!-- les titres de fa�on dynamique en fonction des niveaux presents dans le fichier  -->
<xsl:template match="//*[node()][@text:outline-level] 
                     | //*[node()][starts-with(@text:style-name,'Heading_20_')]">
<!-- bidouiller pour ne pas afficher le titre du document dans le texte -->
    <xsl:choose>
        <xsl:when test="not($StyleTitreGeneral='Heading') and text()=$ContenuTitreDoc"/>
        <xsl:otherwise>
            <xsl:call-template name="titres"/>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template name="titres">
<!-- si $NivoTitre3 existe, d�caler les niveaux puisqu'il n'existe pas de $StyleTitreGeneral et qu'il n'y a qu'un $NivoTitre1 -->
    <xsl:variable name="NivoTitre1_ec">
      <xsl:choose>
          <xsl:when test="$NivoTitre3 = ''">
            <xsl:value-of select="$NivoTitre1"/>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="$NivoTitre2"/>
          </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
    <xsl:variable name="NivoTitre2_ec">
      <xsl:choose>
          <xsl:when test="$NivoTitre3 = ''">
            <xsl:value-of select="$NivoTitre2"/>
          </xsl:when>
          <xsl:otherwise>
            <xsl:value-of select="$NivoTitre3"/>
          </xsl:otherwise>
      </xsl:choose>
    </xsl:variable>
<!-- appliquer les formatage des titres -->
<xsl:text >&#xA;</xsl:text>
		<xsl:choose>
			<xsl:when test="@text:outline-level='$NivoTitre1_ec' or @text:style-name=concat('Heading_20_',$NivoTitre1_ec)">
{{{<xsl:apply-templates/>}}}
        </xsl:when>
			<xsl:when test="@text:outline-level='$NivoTitre2_ec' or @text:style-name=concat('Heading_20_',$NivoTitre2_ec)">
{{<xsl:apply-templates/>}}
        </xsl:when>
			<xsl:otherwise>
{<xsl:apply-templates/>}
			</xsl:otherwise>
		</xsl:choose>
<xsl:text >&#xA;</xsl:text>    
</xsl:template>


<!-- traitement des listes -->
<xsl:template match="text:list">
  <xsl:variable name="level" select="count(ancestor::text:list)+1"/>

	<!-- le type de liste est le @text:style-name de l'element <text:list> le plus exterieur des listes imbriquees -->
	<xsl:variable name="listClass">
		<xsl:choose>
			<xsl:when test="$level=1">
				<xsl:value-of select="@text:style-name"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="ancestor::text:list[last()]/@text:style-name"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	
	<!-- choisir le bon type de liste en fonction du <text:list-level-style-XXX> du  <text:list-style> dans les styles pre-definis
	<xsl:variable name="node" select="key('listTypes', $listClass)/*[@text:level='$level']"/>  -->
  <xsl:variable name="node" select="/office:document-content/office:automatic-styles/text:list-style[@style:name=$listClass]/*[1]"/>  
	
  <xsl:variable name="s">
    <xsl:choose>
     	<xsl:when test="local-name($node)='list-level-style-number'">#</xsl:when>
   		<xsl:otherwise>*</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
  
  <xsl:call-template name="process-list">
    <xsl:with-param name="s" select="$s"/>
	</xsl:call-template>
  
  <xsl:text >&#xA;</xsl:text>
</xsl:template>

<xsl:template name="process-list"> 
  <xsl:param name="s"/>
  <xsl:for-each select="descendant::text:list-item/text:p">
-<xsl:for-each select="ancestor::*"><!-- gestion des listes imbriqu�es -->
        <xsl:if test="name()='text:list-item'"><xsl:value-of select="$s"/></xsl:if>
</xsl:for-each> 
    <xsl:apply-templates />
  </xsl:for-each>
</xsl:template>


<!-- traitement des tableaux -->
<xsl:template match="table:table">
<xsl:text >&#xA;</xsl:text>
		<xsl:apply-templates select="table:table-row"/>
<xsl:text >&#xA;</xsl:text>        
</xsl:template>

<xsl:template match="table:table-row">
<xsl:text >&#xA;</xsl:text>|<xsl:choose>
   <xsl:when test="position() = 1">
       <xsl:apply-templates select="table:table-cell | table:covered-table-cell" mode="thead"/>
   </xsl:when>
   <xsl:otherwise>
        <xsl:apply-templates select="table:table-cell | table:covered-table-cell" mode="tbody"/>
   </xsl:otherwise>
</xsl:choose>
</xsl:template>

<xsl:template match="table:table-cell" mode="thead">{{<xsl:apply-templates/>}}|</xsl:template>
<xsl:template match="table:table-cell" mode="tbody"><xsl:apply-templates/>|</xsl:template>

<!-- ca c'est la mauvaise bidouille pour avoir le meme traitement pour les cellules de fusion alors qu'elles ont un mode different -->
<xsl:template match="table:covered-table-cell" mode="thead"><xsl:call-template name="cells_fusionnees"/></xsl:template>
<xsl:template match="table:covered-table-cell" mode="tbody"><xsl:call-template name="cells_fusionnees"/></xsl:template>

<!-- traitement des cellules masquees du fait de fusions par colonnes/lignes 
     bidouille: si dans les cellules precedentes de la meme ligne il y a un table:number-columns-spanned="XX"
     alors c'est une fusion de cellules d'une meme ligne (code <|) sinon fusion de cellules d'une meme colonne (code ^|) -->
<xsl:template name="cells_fusionnees">
  <xsl:variable name="fusion">
		<xsl:for-each select="preceding-sibling::*">
		    <xsl:if test="@table:number-columns-spanned &gt; 1">&lt;</xsl:if>
    </xsl:for-each>
	</xsl:variable>
	<xsl:variable name="caractere_fusion">
    <xsl:choose>
        <xsl:when test="$fusion = ''">^</xsl:when>
        <xsl:otherwise>&lt;</xsl:otherwise>
    </xsl:choose>
  </xsl:variable>
<xsl:value-of select="$caractere_fusion"/>|</xsl:template>


<!-- les liens -->
<xsl:template match="text:a">[<xsl:apply-templates />-><xsl:value-of select="@xlink:href" />]</xsl:template>

<!-- les ancres -->
<xsl:template match="text:bookmark-start|text:bookmark">[<xsl:value-of select="@text:name" />&lt;-]
</xsl:template>

<!-- notes de bas de page 	-->
<xsl:template match="text:note-citation"/>
<xsl:template match="text:note-body">[[<xsl:apply-templates />]]</xsl:template>
	
<!-- les sauts de ligne -->
<xsl:template match="text:line-break">
_ <xsl:apply-templates />
</xsl:template>

<!-- gras et italiques -->
<xsl:template match="text:span">
	<xsl:variable name="StyleType" select="@text:style-name"/>
	<xsl:variable name="weight" select="/office:document-content/office:automatic-styles/style:style[@style:name=$StyleType]/style:text-properties/@fo:font-weight"/>
	<xsl:variable name="style" select="/office:document-content/office:automatic-styles/style:style[@style:name=$StyleType]/style:text-properties/@fo:font-style"/>
	<xsl:choose>
    <xsl:when test="$weight='bold'">{{<xsl:apply-templates />}}</xsl:when>
  	<xsl:when test="$style='italic'">{<xsl:apply-templates />}</xsl:when>
  	<xsl:otherwise>
   			<xsl:apply-templates />
		</xsl:otherwise>
	</xsl:choose>   
</xsl:template>


<!-- nettement plus bricolage : les images... 
     on met le nom de fichier de l'image qu'il faudra echanger en php par son id document spip une fois qu'il sera reference dans la table document -->	
<xsl:template match="draw:image">
   <xsl:call-template name="img2texte" />
</xsl:template>

<xsl:template name="img2texte">&#60;img<xsl:value-of select="substring(@xlink:href,10)"/>;;;<xsl:value-of select="substring-before(parent::draw:frame/@svg:width,'cm')" />;;;<xsl:value-of select="substring-before(parent::draw:frame/@svg:height,'cm')" />;;;|<xsl:choose>
<!-- sale bidouille pour approximer la position de l'image (|left |center |right) -->
<xsl:when test="substring-before(parent::draw:frame/@svg:x, 'cm') &lt;= 2">left</xsl:when>
<xsl:when test="substring-before(parent::draw:frame/@svg:x, 'cm') &gt;= 5">right</xsl:when>
<xsl:otherwise>center</xsl:otherwise>
</xsl:choose>&#62;</xsl:template>

<!--
	This template is too dangerous to leave active...
<xsl:template match="text()">
	<xsl:if test="normalize-space(.) !=''">
		<xsl:value-of select="normalize-space(.)"/>
	</xsl:if>
</xsl:template>
-->

</xsl:stylesheet>

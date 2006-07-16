<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">
<xsl:output method="html" encoding="UTF-8" cdata-section-elements="script" indent="yes"/> 
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Avertissement">
    <p> </p> 
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td bgcolor="#E9E9E9" height="13">
          <p>
            <font color="C72121">
              <b>
                 <xsl:value-of select="TitreLong"/>
              </b>
            </font>
          </p>
        </td>
      </tr>
      <tr>
        <td bgcolor="#E9E9E9">
          <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <xsl:apply-templates select="Texte/Chapitre" mode="Ressource_Avertissement"/>
          </table>
        </td>
      </tr>
    </table>
    <p> </p> 
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Organisme_local_SPL">
    <xsl:param name="commentaire"/>
    <xsl:apply-templates select="LienWeb" mode="Ressource"/>
    <xsl:choose>
      <xsl:when test="IDExterne1 and $ADRESSESLOCALES = 'yes'">
        <xsl:apply-templates select="IDExterne1" mode="Ressource_Organisme_local_Web">
          <xsl:with-param name="commentaire" select="$commentaire"/>
        </xsl:apply-templates>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="AppelApplication" mode="Ressource_Organisme_local_Web">
          <xsl:with-param name="commentaire" select="$commentaire"/>
        </xsl:apply-templates>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:if test="//Description">
      <tr>
        <td colspan="2">
           
        </td>
      </tr>
      <tr>
        <td colspan="2">
            <xsl:value-of select="//Description" />
        </td>
      </tr>
    </xsl:if>    
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Organisme_local_Web">
    <xsl:param name="commentaire"/>
    <xsl:apply-templates select="LienWeb" mode="Ressource"/>
    <xsl:choose>
      <xsl:when test="IDExterne1 and $ADRESSESLOCALES = 'yes'">
        <xsl:apply-templates select="IDExterne1" mode="Ressource_Organisme_local_Web">
          <xsl:with-param name="commentaire" select="$commentaire"/>
        </xsl:apply-templates>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="AppelApplication" mode="Ressource_Organisme_local_Web">
          <xsl:with-param name="commentaire" select="$commentaire"/>
        </xsl:apply-templates>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:if test="//Description">
      <tr>
        <td colspan="2">
           
        </td>
      </tr>
      <tr>
        <td colspan="2">
            <xsl:value-of select="//Description" />
        </td>
      </tr>
    </xsl:if>    
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Organisme_national">
    <xsl:param name="commentaire"/>
    <tr>
      <td colspan="2">
        <font color="#000000" class="texte1">
          Cet organisme est compétent pour toute la France : 
        </font>
      </td>
    </tr>
    <tr>
      <td colspan="2">
         
      </td>
    </tr>
    <tr>
      <td width="20" align="LEFT" valign="baseline">
        <img alt="">
          <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_o.gif</xsl:text></xsl:attribute>
        </img>  
      </td>
      <td width="100%">
        <b>
          <xsl:value-of select="TitreLong"/>
        </b>
        <xsl:if test="$commentaire">
          <xsl:text> (</xsl:text><xsl:value-of select="$commentaire"/>
<xsl:text>)</xsl:text>
        </xsl:if>
      </td>
    </tr>
    <xsl:apply-templates select="Texte" mode="Ressource"/>
    <tr>
      <td colspan="2">
         
      </td>
    </tr>
    <xsl:choose>
      <xsl:when test="EditeurSource">
        <tr>
          <td width="20" align="LEFT" valign="baseline">
             
          </td>
          <td>
            <font color="#000000" class="texte1">
              <xsl:value-of select="EditeurSource"/>
            </font>
          </td>
        </tr>
      </xsl:when>
      <xsl:otherwise>
        <tr>
          <td width="20" align="LEFT" valign="baseline">
             
          </td>
          <td>
            <font color="#000000" class="texte1">
              service-public.fr - adresses nationales
            </font>
          </td>
        </tr>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Web">
    <xsl:apply-templates select="LienWeb" mode="Ressource"/>
    <xsl:call-template name="source"/>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Teleservice">
    <xsl:apply-templates select="LienWeb" mode="Ressource"/>
    <xsl:if test="IDExterne1">
      <tr>
        <td width="20" align="LEFT" valign="baseline"> </td>
        <td width="100%">
          <xsl:apply-templates select="IDExterne1" mode="Ressource_Teleservice_Formulaire"/>
        </td>
      </tr>
    </xsl:if>
    <xsl:call-template name="source"/>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Formulaire">
    <xsl:apply-templates select="LienWeb" mode="Ressource"/>
    <xsl:if test="IDExterne1">
      <tr>
        <td width="20" align="LEFT" valign="baseline"> </td>
        <td width="100%">
          <xsl:apply-templates select="IDExterne1" mode="Ressource_Teleservice_Formulaire"/>
        </td>
      </tr>
    </xsl:if>
    <xsl:call-template name="source"/>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Texte_Reference">
    <xsl:if test="not(contains($typepublication, 'Question-réponse')) and not(contains($typepublication, 'Noeud')) and count(LienWeb) > 1">
      <xsl:apply-templates select="//TitreLong" mode="Ressource" />
    </xsl:if>
    <xsl:choose>
      <xsl:when test="Texte/Chapitre/Paragraphe or Texte/Chapitre/SousChapitre/Paragraphe">
        <xsl:apply-templates select="Texte/Chapitre/Paragraphe | Texte/Chapitre/SousChapitre/Paragraphe" mode="Ressource_Texte_Reference"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="LienWeb" mode="Ressource"/>
      </xsl:otherwise>
    </xsl:choose>
    <xsl:call-template name="source"/>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Lettre_type">
      <tr align="left">
        <td vAlign="baseline">
          <b><xsl:value-of select="TitreLong"/></b>
        </td>
      </tr>
      <tr align="left">
        <td vAlign="baseline">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <xsl:apply-templates select="//Paragraphe" mode="Ressource_Lettre_type"/>
            </table>
        </td>
      </tr>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource_Definition_glossaire">
    <xsl:if test="Type/Nom ='Définition de glossaire'">
      <xsl:apply-templates mode="Ressource"/>
    </xsl:if>
  </xsl:template>
  <!-- Can we lose this or do we have to change it ? -->
  <xsl:template match="Ressource" mode="RessourceInterne">
    <xsl:param name="libelle"/>
    <a href="Javascript:void(0)" onmouseout="window.status=''">
      <xsl:attribute name="onmousemove"><xsl:text>window.status='</xsl:text><xsl:value-of select="@ID"/><xsl:text>.xhtml'</xsl:text></xsl:attribute>
      <xsl:attribute name="onClick"><xsl:text>window.open('/comarquage/Ressource.html?xml=</xsl:text><xsl:value-of select="@ID"/><xsl:text>.xml&#x26;xsl=Ressource.xsl','ressource','width=450,height=350,scrollbars=1')</xsl:text></xsl:attribute>
      <xsl:value-of select="$libelle"/>
    </a>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource" mode="Ressource">
    <xsl:apply-templates mode="Ressource"/>
  </xsl:template>
  <!-- Ressource-->
  <xsl:template match="Ressource">
    <xsl:apply-templates mode="Ressource"/>
  </xsl:template>
  <!-- TitreLong-->
  <xsl:template match="TitreLong" mode="Ressource">
   <tr>
     <xsl:choose>
       <xsl:when test="/*/Type/Nom = 'Définition de glossaire' or /*/Type/Nom = 'Texte de référence' or /*/Type/Nom = 'Référent de calcul'">
         <td colspan="2">
           <b>
             <xsl:value-of select="."/>
           </b>
         </td>
       </xsl:when>
       <xsl:otherwise>
         <td width="20" align="LEFT" valign="baseline">
           <img alt="">
             <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_r.gif</xsl:text></xsl:attribute>
           </img>
         </td>
         <td>
           <xsl:value-of select="."/>
         </td>
       </xsl:otherwise>
     </xsl:choose>
    </tr>
  </xsl:template>
  <!-- TypeCatégorie -->
  <xsl:template match="TypeCatégorie"/>
  <!-- CouvertureGéographique -->
  <xsl:template match="CouvertureGéographique"/>
  <!-- Indexation -->
  <xsl:template match="Indexation"/>
  <!-- CheminPrèf -->
  <xsl:template match="CheminPréf"/>
  <!-- Chapitre-->
  <xsl:template match="Chapitre" mode="Ressource_Avertissement">
    <tr>
      <td bgcolor="#E9E9E9">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td width="20" align="LEFT" valign="baseline">
              <xsl:choose>
                <xsl:when test="@type='note'">
                  <img width="26" height="26" align="absbottom" alt="Note">
                    <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_stylo1.gif</xsl:text></xsl:attribute>
                  </img>
                </xsl:when>
                <xsl:when test="@type='attention'">
                  <img width="26" height="26" align="absbottom" alt="Attention !">
                    <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_excla.gif</xsl:text></xsl:attribute>
                  </img>
                </xsl:when>
                <xsl:when test="@type='info'">
                  <img width="26" height="26" align="absbottom" alt="Information">
                    <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/ampoule.gif</xsl:text></xsl:attribute>
                  </img>
                </xsl:when>
                <xsl:when test="@type='savoir'">
                  <img width="26" height="26" align="absbottom" alt="Bon à savoir">
                    <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/fleche-orange.gif</xsl:text></xsl:attribute>
                  </img>
                </xsl:when>
                <xsl:otherwise>
                 
                </xsl:otherwise>
              </xsl:choose>
            </td>
            <td width="100%">
              <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <xsl:apply-templates mode="Ressource"/>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </xsl:template>
  <!-- Chapitre-->
  <xsl:template match="Chapitre" mode="Ressource">
    <tr>
      <td width="20" align="LEFT" valign="baseline">
        <xsl:choose>
          <xsl:when test="@type='note'">
            <img width="26" height="26" align="absbottom" alt="Note">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_stylo1.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='attention'">
            <img width="26" height="26" align="absbottom" alt="Attention !">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_excla.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='info'">
            <img width="26" height="26" align="absbottom" alt="Information">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/ampoule.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='savoir'">
            <img width="26" height="26" align="absbottom" alt="Bon à savoir">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/fleche-orange.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:otherwise>
           
        </xsl:otherwise>
        </xsl:choose>
      </td>
      <td width="100%">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <xsl:apply-templates mode="Ressource"/>
        </table>
      </td>
    </tr>
  </xsl:template>
  <!-- Titre de Chapitre-->
  <xsl:template match="Chapitre/Titre" mode="Ressource">
    <tr>
      <xsl:choose>
        <xsl:when test="/Ressource/Type/Nom='Texte de référence' or /Ressource/Type/Nom='Référent de calcul'">
          <td colspan="2">
            <b>
              <xsl:apply-templates mode="Ressource"/>
            </b>
          </td>
        </xsl:when>
        <xsl:when test="/Ressource/Type/Nom='Définition de glossaire'">
          <td colspan="2">
            <a>
              <xsl:attribute name="name"><xsl:value-of select="/Ressource/@ID"/><xsl:text>.xml</xsl:text></xsl:attribute>
              <b>
                <xsl:apply-templates mode="Ressource"/>
              </b>
            </a>
          </td>
        </xsl:when>
        <xsl:otherwise>
          <td width="20" align="left" valign="baseline">
            <img alt="">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_o.gif</xsl:text></xsl:attribute>
            </img>
          </td>
          <td width="100%">
            <xsl:apply-templates mode="Ressource"/>
          </td>
        </xsl:otherwise>
      </xsl:choose>
    </tr>
  </xsl:template>
  <!-- SousChapitre -->
  <xsl:template match="SousChapitre" mode="Ressource">
    <tr>
      <td width="20" align="LEFT" valign="baseline">
        <xsl:choose>
          <xsl:when test="@type='note'">
            <img width="26" height="26" align="absbottom" alt="Note">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_stylo1.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='attention'">
            <img width="26" height="26" align="absbottom" alt="Attention !">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/l_excla.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='info'">
            <img width="26" height="26" align="absbottom" alt="Information">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/ampoule.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:when test="@type='savoir'">
            <img width="26" height="26" align="absbottom" alt="Bon à savoir">
              <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/fleche-orange.gif</xsl:text></xsl:attribute>
            </img>
          </xsl:when>
          <xsl:otherwise>
           
        </xsl:otherwise>
        </xsl:choose>
      </td>
      <td width="100%">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
          <xsl:apply-templates mode="Ressource"/>
        </table>
      </td>
    </tr>
  </xsl:template>
  <!-- Titre de SousChapitre-->
  <xsl:template match="SousChapitre/Titre" mode="Ressource">
    <tr>
      <td colspan="2">
        <br/>
        <b>
          <xsl:apply-templates mode="Ressource"/>
        </b>
      </td>
    </tr>
  </xsl:template>
  <!-- Paragraphe -->
  <xsl:template match="Paragraphe" mode="Ressource">
    <xsl:choose>
      <xsl:when test="../../Chapitre or ../../SousChapitre">
        <tr>
          <td colspan="2">
            <p>
              <xsl:apply-templates/>
              <xsl:text> </xsl:text>
            </p>
          </td>
        </tr>
      </xsl:when>
      <xsl:otherwise>
        <p>
          <xsl:apply-templates/>
          <xsl:text> </xsl:text>
        </p>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  <!-- Paragraphe -->
  <xsl:template match="Paragraphe" mode="Ressource_Lettre_type">
    <xsl:choose>
      <xsl:when test="../../Chapitre or ../../SousChapitre">
        <tr>
          <td colspan="2">
            <p>
              <i>
                <xsl:apply-templates/>
                <xsl:text> </xsl:text>
              </i>
            </p>
          </td>
        </tr>
      </xsl:when>
      <xsl:otherwise>
        <p>
          <i>
            <xsl:apply-templates/>
            <xsl:text> </xsl:text>
          </i>
        </p>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  <!-- Paragraphe -->
  <xsl:template match="Paragraphe" mode="Ressource_Texte_Reference">
    <xsl:if test="text()">
      <tr>
        <td width="20" align="LEFT" valign="baseline">
          <img alt="">
            <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_o.gif</xsl:text></xsl:attribute>
          </img>
        </td>
        <td width="100%">
          <xsl:apply-templates/>
        </td>
      </tr>
    </xsl:if>
  </xsl:template>
  <!-- Liste -->
  <xsl:template match="Liste" mode="Ressource">
    <tr>
      <td colspan="2">
        <ul class="normal">
          <xsl:apply-templates mode="Ressource"/>
        </ul>
      </td>
    </tr>
  </xsl:template>
  <!-- Item -->
  <xsl:template match="Item" mode="Ressource">
    <li>
      <xsl:apply-templates mode="Ressource"/>
    </li>
  </xsl:template>
  <!-- IDExterne1 -->
  <xsl:template match="IDExterne1" mode="Ressource"/>
  <xsl:template match="IDExterne1" mode="Ressource_Teleservice_Formulaire">
    <xsl:text>Cerfa n°</xsl:text><xsl:value-of select="."/>
  </xsl:template>

  <xsl:template match="IDExterne1" mode="Ressource_Organisme_local_Web">
   <xsl:param name="commentaire"/>
   
   <xsl:apply-templates select="../AppelApplication" mode="Ressource_Organisme_local_Web">
     <xsl:with-param name="link" select="."/>
     <xsl:with-param name="commentaire" select="$commentaire"/>
   </xsl:apply-templates>

  </xsl:template>

  <!-- IDExterne2 -->
  <xsl:template match="IDExterne2" mode="Ressource"/>
  <!-- EditeurSource -->
  <xsl:template match="EditeurSource" mode="Ressource">
    <tr>
      <td width="20" align="LEFT" valign="baseline"> </td>
      <td width="100%">
        <font color="#000000" class="texte2">
          <xsl:value-of select="."/>
        </font>
      </td>
    </tr>
  </xsl:template>
  <!-- LienWeb -->
  <xsl:template match="LienWeb" mode="Ressource">
    <tr>
      <td width="20" align="LEFT" valign="baseline">
        <img alt="">
          <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_o.gif</xsl:text></xsl:attribute>
        </img>
      </td>
      <td width="100%">
        <xsl:choose>
          <xsl:when test="@Lien != ''">
            <a class="choix" target="_blank">
              <xsl:attribute name="href"><xsl:value-of select="@Lien"/></xsl:attribute>
              <xsl:if test="@Commentaire">
                <xsl:attribute name="title"><xsl:value-of select="@Commentaire"/></xsl:attribute>
                <xsl:attribute name="alt"><xsl:value-of select="@Commentaire"/></xsl:attribute>
              </xsl:if>
              <xsl:value-of select="@Libellé"/>
              <xsl:text/>
            </a>
          </xsl:when>
          <xsl:otherwise>
            <b>
              <xsl:value-of select="@Libellé"/>
            </b>
          </xsl:otherwise>
        </xsl:choose>
      </td>
    </tr>
  </xsl:template>
  <xsl:template match="Tableau" mode="Ressource">
    <tr>
      <td colspan="2">
        <table width="100%" border="1" cellspacing="0">
          <tbody>
            <xsl:apply-templates mode="Ressource"/>
          </tbody>
        </table>
      </td>
    </tr>
  </xsl:template>
  <!-- Rangée -->
  <xsl:template match="Rangée" mode="Ressource">
    <tr>
      <xsl:apply-templates mode="Ressource"/>
    </tr>
  </xsl:template>
  <!-- Cellule -->
  <xsl:template match="Cellule" mode="Ressource">
    <xsl:choose>
      <xsl:when test="../@type='entete'">
        <th>
          <xsl:apply-templates mode="Ressource"/>
        </th>
      </xsl:when>
      <xsl:otherwise>
        <td>
          <xsl:apply-templates mode="Ressource"/>
        </td>
      </xsl:otherwise>
    </xsl:choose>  
  </xsl:template>
  <!-- Contact -->
  <xsl:template match="Contact" mode="Ressource"/>
  <!-- Photo -->
  <xsl:template match="Photo" mode="Ressource"/>
  <!-- TypeDeDémarche -->
  <xsl:template match="TypeDeDémarche" mode="Ressource"/>

  <!-- AppelApplication -->
  <xsl:template match="AppelApplication" mode="Ressource_Organisme_local_Web">
    <xsl:param name="commentaire"/>
    <xsl:param name="link"/>
    <tr> 
      <td width="20" align="LEFT" valign="baseline">
        <img alt="">
          <xsl:attribute name="src"><xsl:value-of select="$IMAGESURL"/><xsl:text>/puce_o.gif</xsl:text></xsl:attribute>
        </img>  
      </td>
      <td width="100%">
        <a class="choix" target="_blank" id="SP_{generate-id()}_LINK">
          <xsl:attribute name="href">
            <xsl:value-of select="@ID"/>?<xsl:apply-templates select="Paramètre" mode="Ressource"/>
          </xsl:attribute>
          <b><xsl:apply-templates select="//TitreLong"/></b>
        </a>
        <xsl:if test="$commentaire">
          <xsl:text> (</xsl:text><xsl:value-of select="$commentaire"/><xsl:text>)</xsl:text>
        </xsl:if>
      </td>
    </tr>
    <tr> 
     <td width="20" align="LEFT" valign="baseline">
         
      </td>
      <td class="texte1" id="SP_{generate-id()}_TEXT">
        <xsl:value-of select="@Nom"/><xsl:text>, </xsl:text><xsl:value-of select="//EditeurSource"/>
      </td>
    </tr>
  </xsl:template>

  <!-- Rattachements -->
  <xsl:template match="Rattachements" mode="Ressource"/>
  <!-- RessourceLiée -->
  <xsl:template match="RessourcesLiées" mode="Ressource"/>
  <!-- Téléchargement du fichier XML "à la demande" -->
  <!-- Pas pret encore...

  <xsl:template match="LienRessource" mode="Ressource">
  <xsl:value-of select="php:function('_get_service_public_xml_file(@lien)')"/>/>
  </xsl:template>
  -->

  <!-- LienRessource -->
  <xsl:template match="LienRessource" mode="Ressource">
    <xsl:value-of select="@lien"/>
  </xsl:template>
  <!-- Paramètre -->
  <xsl:template match="Paramètre" mode="Ressource">
    <xsl:if test="position()!=1">
      <xsl:text>&#x26;</xsl:text>
    </xsl:if>
    <xsl:value-of select="Nom"/>
    <xsl:text>=</xsl:text>
    <xsl:value-of select="Valeur"/>
  </xsl:template>
  <xsl:template name="source">
    <xsl:choose>
      <xsl:when test="count(//RessourcesLiées/LienRessource[starts-with(@type, 'Organisme')]) > 0">
        <xsl:variable name="lien">
         <xsl:text>../xml/</xsl:text>
         <xsl:apply-templates select="//RessourcesLiées/LienRessource[starts-with(@type, 'Organisme')]" mode="Ressource"/>
         <xsl:text>.xml</xsl:text>
        </xsl:variable>
        <tr>
          <td width="20" align="LEFT" valign="baseline"> </td>
          <td width="100%">
            <font color="#000000" class="texte2">
            <xsl:value-of select="document($lien)/Ressource/TitreLong"/>
            </font>
          </td>
        </tr>
      </xsl:when>
      <xsl:otherwise>
        <xsl:apply-templates select="//EditeurSource" mode="Ressource"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
</xsl:stylesheet>

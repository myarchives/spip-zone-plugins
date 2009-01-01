/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.UpdateManager.defaults.indicatorText="<div class=\"loading-indicator\">En cours de chargement...</div>";if(Ext.View){Ext.View.prototype.emptyText="";}if(Ext.grid.Grid){Ext.grid.Grid.prototype.ddText="{0} ligne(s) s\xc3\xa9lectionn\xc3\xa9(s)";}if(Ext.TabPanelItem){Ext.TabPanelItem.prototype.closeText="Fermer cet onglet";}if(Ext.form.Field){Ext.form.Field.prototype.invalidText="La valeur de ce champ est invalide";}Date.monthNames=["Janvier","F\xc3\xa9vrier","Mars","Avril","Mai","Juin","Juillet","Ao\xc3\xbbt","Septembre","Octobre","Novembre","D\xc3\xa9cembre"];Date.dayNames=["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];if(Ext.MessageBox){Ext.MessageBox.buttonText={ok:"OK",cancel:"Annuler",yes:"Oui",no:"Non"};}if(Ext.util.Format){Ext.util.Format.date=function(v,_2){if(!v){return"";}if(!(v instanceof Date)){v=new Date(Date.parse(v));}return v.dateFormat(_2||"d/m/Y");};}if(Ext.DatePicker){Ext.apply(Ext.DatePicker.prototype,{todayText:"Aujourd'hui",minText:"Cette date est plus petite que la date minimum",maxText:"Cette date est plus grande que la date maximum",disabledDaysText:"",disabledDatesText:"",monthNames:Date.monthNames,dayNames:Date.dayNames,nextText:"Prochain mois (CTRL+Fl\xc3\xa9che droite)",prevText:"Mois pr\xc3\xa9c\xc3\xa9dent (CTRL+Fl\xc3\xa9che gauche)",monthYearText:"Choisissez un mois (CTRL+Fl\xc3\xa9che haut ou bas pour changer d'ann\xc3\xa9e.)",todayTip:"{0} (Barre d'espace)",okText:"&#160;OK&#160;",cancelText:"Annuler",format:"d/m/y",startDay:1});}if(Ext.PagingToolbar){Ext.apply(Ext.PagingToolbar.prototype,{beforePageText:"Page",afterPageText:"sur {0}",firstText:"Premi\xc3\xa8re page",prevText:"Page pr\xc3\xa9c\xc3\xa9dente",nextText:"Page suivante",lastText:"Derni\xc3\xa8re page",refreshText:"Actualiser la page",displayMsg:"Page courante {0} - {1} sur {2}",emptyMsg:"Aucune donn\xc3\xa9e \xc3\xa0 afficher"});}if(Ext.form.TextField){Ext.apply(Ext.form.TextField.prototype,{minLengthText:"La longueur minimum de ce champ est de {0} caract\xc3\xa8res",maxLengthText:"La longueur maximum de ce champ est de {0} caract\xc3\xa8res",blankText:"Ce champ est obligatoire",regexText:"",emptyText:null});}if(Ext.form.NumberField){Ext.apply(Ext.form.NumberField.prototype,{minText:"La valeur minimum de ce champ doit \xc3\xaatre de {0}",maxText:"La valeur maximum de ce champ doit \xc3\xaatre de {0}",nanText:"{0} n'est pas un nombre valide"});}if(Ext.form.DateField){Ext.apply(Ext.form.DateField.prototype,{disabledDaysText:"D\xc3\xa9sactiv\xc3\xa9",disabledDatesText:"D\xc3\xa9sactiv\xc3\xa9",minText:"La date de ce champ doit \xc3\xaatre avant le {0}",maxText:"La date de ce champ doit \xc3\xaatre apr\xc3\xa8s le {0}",invalidText:"{0} n'est pas une date valide - elle doit \xc3\xaatre au format suivant: {1}",format:"d/m/y"});}if(Ext.form.ComboBox){Ext.apply(Ext.form.ComboBox.prototype,{loadingText:"En cours de chargement...",valueNotFoundText:undefined});}if(Ext.form.VTypes){Ext.apply(Ext.form.VTypes,{emailText:"Ce champ doit contenir une adresse email au format: \"usager@domaine.com\"",urlText:"Ce champ doit contenir une URL au format suivant: \"http:/"+"/www.domaine.com\"",alphaText:"Ce champ ne peut contenir que des lettres et le caract\xc3\xa8re soulign\xc3\xa9 (_)",alphanumText:"Ce champ ne peut contenir que des caract\xc3\xa8res alphanum\xc3\xa9riques ainsi que le caract\xc3\xa8re soulign\xc3\xa9 (_)"});}if(Ext.form.HtmlEditor){Ext.apply(Ext.form.HtmlEditor.prototype,{createLinkText:"Veuillez entrer l'URL pour ce lien:",buttonTips:{bold:{title:"Gras (Ctrl+B)",text:"Met le texte s\xc3\xa9lectionn\xc3\xa9 en gras.",cls:"x-html-editor-tip"},italic:{title:"Italique (Ctrl+I)",text:"Met le texte s\xc3\xa9lectionn\xc3\xa9 en italique.",cls:"x-html-editor-tip"},underline:{title:"Soulign\xc3\xa9 (Ctrl+U)",text:"Souligne le texte s\xc3\xa9lectionn\xc3\xa9.",cls:"x-html-editor-tip"},increasefontsize:{title:"Agrandir la police",text:"Augmente la taille de la police.",cls:"x-html-editor-tip"},decreasefontsize:{title:"R\xc3\xa9duire la police",text:"R\xc3\xa9duit la taille de la police.",cls:"x-html-editor-tip"},backcolor:{title:"Couleur de surbrillance",text:"Modifie la couleur de fond du texte s\xc3\xa9lectionn\xc3\xa9.",cls:"x-html-editor-tip"},forecolor:{title:"Couleur de police",text:"Modifie la couleur du texte s\xc3\xa9lectionn\xc3\xa9.",cls:"x-html-editor-tip"},justifyleft:{title:"Aligner \xc3\xa0 gauche",text:"Aligne le texte \xc3\xa0 gauche.",cls:"x-html-editor-tip"},justifycenter:{title:"Centrer",text:"Centre le texte.",cls:"x-html-editor-tip"},justifyright:{title:"Aligner \xc3\xa0 droite",text:"Aligner le texte \xc3\xa0 droite.",cls:"x-html-editor-tip"},insertunorderedlist:{title:"Liste \xc3\xa0 puce",text:"D\xc3\xa9marre une liste \xc3\xa0 puce.",cls:"x-html-editor-tip"},insertorderedlist:{title:"Liste num\xc3\xa9rot\xc3\xa9e",text:"D\xc3\xa9marre une liste num\xc3\xa9rot\xc3\xa9e.",cls:"x-html-editor-tip"},createlink:{title:"Lien hypertexte",text:"Transforme en lien hypertexte.",cls:"x-html-editor-tip"},sourceedit:{title:"Code source",text:"Basculer en mode \xc3\xa9dition du code source.",cls:"x-html-editor-tip"}}});}if(Ext.grid.GridView){Ext.apply(Ext.grid.GridView.prototype,{sortAscText:"Tri croissant",sortDescText:"Tri d\xc3\xa9croissant",lockText:"Verrouiller la colonne",unlockText:"D\xc3\xa9verrouiller la colonne",columnsText:"Colonnes"});}if(Ext.grid.PropertyColumnModel){Ext.apply(Ext.grid.PropertyColumnModel.prototype,{nameText:"Propri\xc3\xa9t\xc3\xa9",valueText:"Valeur",dateFormat:"d/m/Y"});}if(Ext.SplitLayoutRegion){Ext.apply(Ext.SplitLayoutRegion.prototype,{splitTip:"Cliquer et glisser pour redimensionner le panneau.",collapsibleSplitTip:"Cliquer et glisser pour redimensionner le panneau. Double-cliquer pour le cacher."});}
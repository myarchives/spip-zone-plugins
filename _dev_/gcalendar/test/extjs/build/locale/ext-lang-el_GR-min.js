/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.UpdateManager.defaults.indicatorText="<div class=\"loading-indicator\">\xce\u0153\xce\xb5\xcf\u201e\xce\xb1\xcf\u2020\xcf\u0152\xcf\ufffd\xcf\u201e\xcf\u2030\xcf\u0192\xce\xb7 \xce\xb4\xce\xb5\xce\xb4\xce\xbf\xce\xbc\xce\xce\xbd\xcf\u2030\xce\xbd...</div>";if(Ext.View){Ext.View.prototype.emptyText="";}if(Ext.grid.Grid){Ext.grid.Grid.prototype.ddText="{0} \xce\u2022\xcf\u20ac\xce\xb9\xce\xbb\xce\xb5\xce\xb3\xce\xbc\xce\xce\xbd\xce\xb5\xcf\u201a \xcf\u0192\xce\xb5\xce\xb9\xcf\ufffd\xce\xcf\u201a";}if(Ext.TabPanelItem){Ext.TabPanelItem.prototype.closeText="\xce\u0161\xce\xbb\xce\xb5\xce\xaf\xcf\u0192\xcf\u201e\xce\xb5 \xcf\u201e\xce\xbf tab";}if(Ext.form.Field){Ext.form.Field.prototype.invalidText="\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xcf\ufffd\xce\xb9\xce\xb5\xcf\u2021\xcf\u0152\xce\xbc\xce\xb5\xce\xbd\xce\xbf \xcf\u201e\xce\xbf\xcf\u2026 \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf\xcf\u2026 \xce\xb4\xce\xb5\xce\xbd \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xcf\u0152";}if(Ext.LoadMask){Ext.LoadMask.prototype.msg="\xce\u0153\xce\xb5\xcf\u201e\xce\xb1\xcf\u2020\xcf\u0152\xcf\ufffd\xcf\u201e\xcf\u2030\xcf\u0192\xce\xb7 \xce\xb4\xce\xb5\xce\xb4\xce\xbf\xce\xbc\xce\xce\xbd\xcf\u2030\xce\xbd...";}Date.monthNames=["\xce\u2122\xce\xb1\xce\xbd\xce\xbf\xcf\u2026\xce\xac\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a","\xce\xa6\xce\xb5\xce\xb2\xcf\ufffd\xce\xbf\xcf\u2026\xce\xac\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a","\xce\u0153\xce\xac\xcf\ufffd\xcf\u201e\xce\xb9\xce\xbf\xcf\u201a","\xce\u2018\xcf\u20ac\xcf\ufffd\xce\xaf\xce\xbb\xce\xb9\xce\xbf\xcf\u201a","\xce\u0153\xce\xac\xce\xb9\xce\xbf\xcf\u201a","\xce\u2122\xce\xbf\xcf\ufffd\xce\xbd\xce\xb9\xce\xbf\xcf\u201a","\xce\u2122\xce\xbf\xcf\ufffd\xce\xbb\xce\xb9\xce\xbf\xcf\u201a","\xce\u2018\xcf\ufffd\xce\xb3\xce\xbf\xcf\u2026\xcf\u0192\xcf\u201e\xce\xbf\xcf\u201a","\xce\xa3\xce\xb5\xcf\u20ac\xcf\u201e\xce\xce\xbc\xce\xb2\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a","\xce\u0178\xce\xba\xcf\u201e\xcf\u017d\xce\xb2\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a","\xce\ufffd\xce\xbf\xce\xce\xbc\xce\xb2\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a","\xce\u201d\xce\xb5\xce\xba\xce\xce\xbc\xce\xb2\xcf\ufffd\xce\xb9\xce\xbf\xcf\u201a"];Date.dayNames=["\xce\u0161\xcf\u2026\xcf\ufffd\xce\xb9\xce\xb1\xce\xba\xce\xae","\xce\u201d\xce\xb5\xcf\u2026\xcf\u201e\xce\xcf\ufffd\xce\xb1","\xce\xa4\xcf\ufffd\xce\xaf\xcf\u201e\xce\xb7","\xce\xa4\xce\xb5\xcf\u201e\xce\xac\xcf\ufffd\xcf\u201e\xce\xb7","\xce\xa0\xce\xce\xbc\xcf\u20ac\xcf\u201e\xce\xb7","\xce\xa0\xce\xb1\xcf\ufffd\xce\xb1\xcf\u0192\xce\xba\xce\xb5\xcf\u2026\xce\xae","\xce\xa3\xce\xac\xce\xb2\xce\xb2\xce\xb1\xcf\u201e\xce\xbf"];if(Ext.MessageBox){Ext.MessageBox.buttonText={ok:"OK",cancel:"\xce\u2020\xce\xba\xcf\u2026\xcf\ufffd\xce\xbf",yes:"\xce\ufffd\xce\xb1\xce\xb9",no:"\xce\u0152\xcf\u2021\xce\xb9"};}if(Ext.util.Format){Ext.util.Format.date=function(v,_2){if(!v){return"";}if(!(v instanceof Date)){v=new Date(Date.parse(v));}return v.dateFormat(_2||"d/m/Y");};}if(Ext.DatePicker){Ext.apply(Ext.DatePicker.prototype,{todayText:"\xce\xa3\xce\xae\xce\xbc\xce\xb5\xcf\ufffd\xce\xb1",minText:"\xce\u2014 \xce\u2014\xce\xbc\xce\xb5\xcf\ufffd\xce\xbf\xce\xbc\xce\xb7\xce\xbd\xce\xaf\xce\xb1 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xcf\u20ac\xcf\ufffd\xce\xbf\xce\xb7\xce\xb3\xce\xbf\xcf\ufffd\xce\xbc\xce\xb5\xce\xbd\xce\xb7 \xce\xb1\xcf\u20ac\xcf\u0152 \xcf\u201e\xce\xb7\xce\xbd \xcf\u20ac\xce\xb1\xce\xbb\xce\xb1\xce\xb9\xcf\u0152\xcf\u201e\xce\xb5\xcf\ufffd\xce\xb7 \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xce\xae",maxText:"\xce\u2014 \xce\u2014\xce\xbc\xce\xb5\xcf\ufffd\xce\xbf\xce\xbc\xce\xb7\xce\xbd\xce\xaf\xce\xb1 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xce\xbc\xce\xb5\xcf\u201e\xce\xb1\xce\xb3\xce\xb5\xce\xbd\xce\xcf\u0192\xcf\u201e\xce\xb5\xcf\ufffd\xce\xb7 \xce\xb1\xcf\u20ac\xcf\u0152 \xcf\u201e\xce\xb7\xce\xbd \xce\xbd\xce\xb5\xcf\u0152\xcf\u201e\xce\xb5\xcf\ufffd\xce\xb7 \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xce\xae",disabledDaysText:"",disabledDatesText:"",monthNames:Date.monthNames,dayNames:Date.dayNames,nextText:"\xce\u2022\xcf\u20ac\xcf\u0152\xce\xbc\xce\xb5\xce\xbd\xce\xbf\xcf\u201a \xce\u0153\xce\xae\xce\xbd\xce\xb1\xcf\u201a (Control+\xce\u201d\xce\xb5\xce\xbe\xce\xaf \xce\u2019\xce\xce\xbb\xce\xbf\xcf\u201a)",prevText:"\xce\xa0\xcf\ufffd\xce\xbf\xce\xb7\xce\xb3\xce\xbf\xcf\ufffd\xce\xbc\xce\xb5\xce\xbd\xce\xbf\xcf\u201a \xce\u0153\xce\xae\xce\xbd\xce\xb1\xcf\u201a (Control + \xce\u2018\xcf\ufffd\xce\xb9\xcf\u0192\xcf\u201e\xce\xb5\xcf\ufffd\xcf\u0152 \xce\u2019\xce\xce\xbb\xce\xbf\xcf\u201a)",monthYearText:"\xce\u2022\xcf\u20ac\xce\xb9\xce\xbb\xce\xbf\xce\xb3\xce\xae \xce\u0153\xce\xb7\xce\xbd\xcf\u0152\xcf\u201a (Control + \xce\u2022\xcf\u20ac\xce\xac\xce\xbd\xcf\u2030/\xce\u0161\xce\xac\xcf\u201e\xcf\u2030 \xce\u2019\xce\xce\xbb\xce\xbf\xcf\u201a \xce\xb3\xce\xb9\xce\xb1 \xce\xbc\xce\xb5\xcf\u201e\xce\xb1\xce\xb2\xce\xbf\xce\xbb\xce\xae \xce\xb5\xcf\u201e\xcf\u017d\xce\xbd)",todayTip:"{0} (\xce\xa0\xce\u203a\xce\xae\xce\xba\xcf\u201e\xcf\ufffd\xce\xbf \xce\u201d\xce\xb9\xce\xb1\xcf\u0192\xcf\u201e\xce\xae\xce\xbc\xce\xb1\xcf\u201e\xce\xbf\xcf\u201a)",format:"d/m/y"});}if(Ext.PagingToolbar){Ext.apply(Ext.PagingToolbar.prototype,{beforePageText:"\xce\xa3\xce\xb5\xce\xbb\xce\xaf\xce\xb4\xce\xb1",afterPageText:"\xce\xb1\xcf\u20ac\xcf\u0152 {0}",firstText:"\xce\xa0\xcf\ufffd\xcf\u017d\xcf\u201e\xce\xb7 \xce\xa3\xce\xb5\xce\xbb\xce\xaf\xce\xb4\xce\xb1",prevText:"\xce\xa0\xcf\ufffd\xce\xbf\xce\xb7\xce\xb3\xce\xbf\xcf\ufffd\xce\xbc\xce\xb5\xce\xbd\xce\xb7 \xce\xa3\xce\xb5\xce\xbb\xce\xaf\xce\xb4\xce\xb1",nextText:"\xce\u2022\xcf\u20ac\xcf\u0152\xce\xbc\xce\xb5\xce\xbd\xce\xb7 \xce\xa3\xce\xb5\xce\xbb\xce\xaf\xce\xb4\xce\xb1",lastText:"\xce\xa4\xce\xb5\xce\xbb\xce\xb5\xcf\u2026\xcf\u201e\xce\xb1\xce\xaf\xce\xb1 \xce\xa3\xce\xb5\xce\xbb\xce\xaf\xce\xb4\xce\xb1",refreshText:"\xce\u2018\xce\xbd\xce\xb1\xce\xbd\xce\xcf\u2030\xcf\u0192\xce\xb7",displayMsg:"\xce\u2022\xce\xbc\xcf\u2020\xce\xac\xce\xbd\xce\xb9\xcf\u0192\xce\xb7 {0} - {1} \xce\xb1\xcf\u20ac\xcf\u0152 {2}",emptyMsg:"\xce\u201d\xce\xb5\xce\xbd \xcf\u2026\xcf\u20ac\xce\xac\xcf\ufffd\xcf\u2021\xce\xbf\xcf\u2026\xce\xbd \xce\xb4\xce\xb5\xce\xb4\xce\xbf\xce\xbc\xce\xce\xbd\xce\xb1"});}if(Ext.form.TextField){Ext.apply(Ext.form.TextField.prototype,{minLengthText:"\xce\xa4\xce\xbf \xce\xbc\xce\xb9\xce\xba\xcf\ufffd\xcf\u0152\xcf\u201e\xce\xb5\xcf\ufffd\xce\xbf \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xcf\u0152 \xce\xbc\xce\xae\xce\xba\xce\xbf\xcf\u201a \xce\xb3\xce\xb9\xce\xb1 \xcf\u201e\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 {0}",maxLengthText:"\xce\xa4\xce\xbf \xce\xbc\xce\xb5\xce\xb3\xce\xb1\xce\xbb\xcf\ufffd\xcf\u201e\xce\xb5\xcf\ufffd\xce\xbf \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xcf\u0152 \xce\xbc\xce\xae\xce\xba\xce\xbf\xcf\u201a \xce\xb3\xce\xb9\xce\xb1 \xcf\u201e\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 {0}",blankText:"\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xce\xb9\xce\xbd\xce\xb1\xce\xb9 \xcf\u2026\xcf\u20ac\xce\xbf\xcf\u2021\xcf\ufffd\xce\xb5\xcf\u2030\xcf\u201e\xce\xb9\xce\xba\xcf\u0152",regexText:"",emptyText:null});}if(Ext.form.NumberField){Ext.apply(Ext.form.NumberField.prototype,{minText:"\xce\u2014 \xce\xbc\xce\xb9\xce\xba\xcf\ufffd\xcf\u0152\xcf\u201e\xce\xb5\xcf\ufffd\xce\xb7 \xcf\u201e\xce\xb9\xce\xbc\xce\xae \xcf\u201e\xce\xbf\xcf\u2026 \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf\xcf\u2026 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 {0}",maxText:"\xce\u2014 \xce\xbc\xce\xb5\xce\xb3\xce\xb1\xce\xbb\xcf\ufffd\xcf\u201e\xce\xb5\xcf\ufffd\xce\xb7 \xcf\u201e\xce\xb9\xce\xbc\xce\xae \xcf\u201e\xce\xbf\xcf\u2026 \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf\xcf\u2026 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 {0}",nanText:"{0} \xce\xb4\xce\xb5\xce\xbd \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xce\xb1\xcf\u20ac\xce\xbf\xce\xb4\xce\xb5\xce\xba\xcf\u201e\xcf\u0152\xcf\u201a \xce\xb1\xcf\ufffd\xce\xb9\xce\xb8\xce\xbc\xcf\u0152\xcf\u201a"});}if(Ext.form.DateField){Ext.apply(Ext.form.DateField.prototype,{disabledDaysText:"\xce\u2018\xce\xbd\xce\xb5\xce\xbd\xce\xb5\xcf\ufffd\xce\xb3\xcf\u0152",disabledDatesText:"\xce\u2018\xce\xbd\xce\xb5\xce\xbd\xce\xb5\xcf\ufffd\xce\xb3\xcf\u0152",minText:"\xce\u2014 \xce\xb7\xce\xbc\xce\xb5\xcf\ufffd\xce\xbf\xce\xbc\xce\xb7\xce\xbd\xce\xaf\xce\xb1 \xce\xb1\xcf\u2026\xcf\u201e\xce\xbf\xcf\ufffd \xcf\u201e\xce\xbf\xcf\u2026 \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf\xcf\u2026 \xcf\u20ac\xcf\ufffd\xce\xcf\u20ac\xce\xb5\xce\xb9 \xce\xbd\xce\xb1 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xce\xbc\xce\xb5\xcf\u201e\xce\xac \xcf\u201e\xce\xb7 {0}",maxText:"\xce\u2014 \xce\xb7\xce\xbc\xce\xb5\xcf\ufffd\xce\xbf\xce\xbc\xce\xb7\xce\xbd\xce\xaf\xce\xb1 \xce\xb1\xcf\u2026\xcf\u201e\xce\xbf\xcf\ufffd \xcf\u201e\xce\xbf\xcf\u2026 \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf\xcf\u2026 \xcf\u20ac\xcf\ufffd\xce\xcf\u20ac\xce\xb5\xce\xb9 \xce\xbd\xce\xb1 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xcf\u20ac\xcf\ufffd\xce\xb9\xce\xbd \xcf\u201e\xce\xb7\xcf\u201a {0}",invalidText:"{0} \xce\xb4\xce\xb5\xce\xbd \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xce\xce\xb3\xce\xba\xcf\u2026\xcf\ufffd\xce\xb7 \xce\xb7\xce\xbc\xce\xb5\xcf\ufffd\xce\xbf\xce\xbc\xce\xb7\xce\xbd\xce\xaf\xce\xb1 - \xcf\u20ac\xcf\ufffd\xce\xcf\u20ac\xce\xb5\xce\xb9 \xce\xbd\xce\xb1 \xce\xb5\xce\xaf\xce\xbd\xce\xb1\xce\xb9 \xcf\u0192\xcf\u201e\xce\xb7 \xce\xbc\xce\xbf\xcf\ufffd\xcf\u2020\xce\xae {1}",format:"d/m/y"});}if(Ext.form.ComboBox){Ext.apply(Ext.form.ComboBox.prototype,{loadingText:"\xce\u0153\xce\xb5\xcf\u201e\xce\xb1\xcf\u2020\xcf\u0152\xcf\ufffd\xcf\u201e\xcf\u2030\xcf\u0192\xce\xb7 \xce\xb4\xce\xb5\xce\xb4\xce\xbf\xce\xbc\xce\xce\xbd\xcf\u2030\xce\xbd...",valueNotFoundText:undefined});}if(Ext.form.VTypes){Ext.apply(Ext.form.VTypes,{emailText:"\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb4\xce\xcf\u2021\xce\xb5\xcf\u201e\xce\xb1\xce\xb9 \xce\xbc\xcf\u0152\xce\xbd\xce\xbf \xce\xb4\xce\xb9\xce\xb5\xcf\u2026\xce\xb8\xcf\ufffd\xce\xbd\xcf\u0192\xce\xb5\xce\xb9\xcf\u201a Email \xcf\u0192\xce\xb5 \xce\xbc\xce\xbf\xcf\ufffd\xcf\u2020\xce\xae \"user@domain.com\"",urlText:"\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb4\xce\xcf\u2021\xce\xb5\xcf\u201e\xce\xb1\xce\xb9 \xce\xbc\xcf\u0152\xce\xbd\xce\xbf URL \xcf\u0192\xce\xb5 \xce\xbc\xce\xbf\xcf\ufffd\xcf\u2020\xce\xae \"http:/"+"/www.domain.com\"",alphaText:"\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb4\xce\xcf\u2021\xce\xb5\xcf\u201e\xce\xb1\xce\xb9 \xce\xbc\xcf\u0152\xce\xbd\xce\xbf \xcf\u2021\xce\xb1\xcf\ufffd\xce\xb1\xce\xba\xcf\u201e\xce\xae\xcf\ufffd\xce\xb5\xcf\u201a \xce\xba\xce\xb1\xce\xb9 _",alphanumText:"\xce\xa4\xce\xbf \xcf\u20ac\xce\xb5\xce\xb4\xce\xaf\xce\xbf \xce\xb4\xce\xcf\u2021\xce\xb5\xcf\u201e\xce\xb1\xce\xb9 \xce\xbc\xcf\u0152\xce\xbd\xce\xbf \xcf\u2021\xce\xb1\xcf\ufffd\xce\xb1\xce\xba\xcf\u201e\xce\xae\xcf\ufffd\xce\xb5\xcf\u201a, \xce\xb1\xcf\ufffd\xce\xb9\xce\xb8\xce\xbc\xce\xbf\xcf\ufffd\xcf\u201a \xce\xba\xce\xb1\xce\xb9 _"});}if(Ext.grid.GridView){Ext.apply(Ext.grid.GridView.prototype,{sortAscText:"\xce\u2018\xcf\ufffd\xce\xbe\xce\xbf\xcf\u2026\xcf\u0192\xce\xb1 \xcf\u201e\xce\xb1\xce\xbe\xce\xb9\xce\xbd\xcf\u0152\xce\xbc\xce\xb7\xcf\u0192\xce\xb7",sortDescText:"\xce\xa6\xce\xb8\xce\xaf\xce\xbd\xce\xbf\xcf\u2026\xcf\u0192\xce\xb1 \xcf\u201e\xce\xb1\xce\xbe\xce\xb9\xce\xbd\xcf\u0152\xce\xbc\xce\xb7\xcf\u0192\xce\xb7",lockText:"\xce\u0161\xce\xbb\xce\xb5\xce\xaf\xce\xb4\xcf\u2030\xce\xbc\xce\xb1 \xcf\u0192\xcf\u201e\xce\xae\xce\xbb\xce\xb7\xcf\u201a",unlockText:"\xce\u017e\xce\xb5\xce\xba\xce\xbb\xce\xb5\xce\xaf\xce\xb4\xcf\u2030\xce\xbc\xce\xb1 \xcf\u0192\xcf\u201e\xce\xae\xce\xbb\xce\xb7\xcf\u201a",columnsText:"\xce\xa3\xcf\u201e\xce\xae\xce\xbb\xce\xb5\xcf\u201a"});}if(Ext.grid.PropertyColumnModel){Ext.apply(Ext.grid.PropertyColumnModel.prototype,{nameText:"\xce\u0152\xce\xbd\xce\xbf\xce\xbc\xce\xb1",valueText:"\xce\xa0\xce\xb5\xcf\ufffd\xce\xb9\xce\xb5\xcf\u2021\xcf\u0152\xce\xbc\xce\xb5\xce\xbd\xce\xbf",dateFormat:"m/d/Y"});}if(Ext.SplitLayoutRegion){Ext.apply(Ext.SplitLayoutRegion.prototype,{splitTip:"\xce\xa4\xcf\ufffd\xce\xb1\xce\xb2\xce\xae\xce\xbe\xcf\u201e\xce\xb5 \xce\xb3\xce\xb9\xce\xb1 \xce\xb1\xce\xbb\xce\xbb\xce\xb1\xce\xb3\xce\xae \xce\xbc\xce\xb5\xce\xb3\xce\xce\xb8\xce\xbf\xcf\u2026\xcf\u201a.",collapsibleSplitTip:"\xce\xa4\xcf\ufffd\xce\xb1\xce\xb2\xce\xae\xce\xbe\xcf\u201e\xce\xb5 \xce\xb3\xce\xb9\xce\xb1 \xce\xb1\xce\xbb\xce\xbb\xce\xb1\xce\xb3\xce\xae \xce\xbc\xce\xb5\xce\xb3\xce\xce\xb8\xce\xbf\xcf\u2026\xcf\u201a. \xce\u201d\xce\xb9\xcf\u20ac\xce\xbb\xcf\u0152 \xce\xba\xce\xbb\xce\xb9\xce\xba \xce\xb3\xce\xb9\xce\xb1 \xce\xb1\xcf\u20ac\xcf\u0152\xce\xba\xcf\ufffd\xcf\u2026\xcf\u02c6\xce\xb7."});}
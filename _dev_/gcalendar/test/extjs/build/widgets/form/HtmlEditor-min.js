/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.form.HtmlEditor=Ext.extend(Ext.form.Field,{enableFormat:true,enableFontSize:true,enableColors:true,enableAlignments:true,enableLists:true,enableSourceEdit:true,enableLinks:true,enableFont:true,createLinkText:"Please enter the URL for the link:",defaultLinkValue:"http:/"+"/",fontFamilies:["Arial","Courier New","Tahoma","Times New Roman","Verdana"],defaultFont:"tahoma",validationEvent:false,deferHeight:true,initialized:false,activated:false,sourceEditMode:false,onFocus:Ext.emptyFn,iframePad:3,hideMode:"offsets",defaultAutoCreate:{tag:"textarea",style:"width:500px;height:300px;",autocomplete:"off"},initComponent:function(){this.addEvents({initialize:true,activate:true,beforesync:true,beforepush:true,sync:true,push:true,editmodechange:true});},createFontOptions:function(){var _1=[],fs=this.fontFamilies,ff,lc;for(var i=0,_6=fs.length;i<_6;i++){ff=fs[i];lc=ff.toLowerCase();_1.push("<option value=\"",lc,"\" style=\"font-family:",ff,";\"",(this.defaultFont==lc?" selected=\"true\">":">"),ff,"</option>");}return _1.join("");},createToolbar:function(_7){function btn(id,_9,_a){return{id:id,cls:"x-btn-icon x-edit-"+id,enableToggle:_9!==false,scope:_7,handler:_a||_7.relayBtnCmd,clickEvent:"mousedown",tooltip:_7.buttonTips[id]||undefined,tabIndex:-1};}var tb=new Ext.Toolbar(this.wrap.dom.firstChild);tb.el.on("click",function(e){e.preventDefault();});if(this.enableFont&&!Ext.isSafari){this.fontSelect=tb.el.createChild({tag:"select",tabIndex:-1,cls:"x-font-select",html:this.createFontOptions()});this.fontSelect.on("change",function(){var _d=this.fontSelect.dom.value;this.relayCmd("fontname",_d);this.deferFocus();},this);tb.add(this.fontSelect.dom,"-");}if(this.enableFormat){tb.add(btn("bold"),btn("italic"),btn("underline"));}if(this.enableFontSize){tb.add("-",btn("increasefontsize",false,this.adjustFont),btn("decreasefontsize",false,this.adjustFont));}if(this.enableColors){tb.add("-",{id:"forecolor",cls:"x-btn-icon x-edit-forecolor",clickEvent:"mousedown",tooltip:_7.buttonTips["forecolor"]||undefined,tabIndex:-1,menu:new Ext.menu.ColorMenu({allowReselect:true,focus:Ext.emptyFn,value:"000000",plain:true,selectHandler:function(cp,_f){this.execCmd("forecolor",Ext.isSafari||Ext.isIE?"#"+_f:_f);this.deferFocus();},scope:this,clickEvent:"mousedown"})},{id:"backcolor",cls:"x-btn-icon x-edit-backcolor",clickEvent:"mousedown",tooltip:_7.buttonTips["backcolor"]||undefined,tabIndex:-1,menu:new Ext.menu.ColorMenu({focus:Ext.emptyFn,value:"FFFFFF",plain:true,allowReselect:true,selectHandler:function(cp,_11){if(Ext.isGecko){this.execCmd("useCSS",false);this.execCmd("hilitecolor",_11);this.execCmd("useCSS",true);this.deferFocus();}else{this.execCmd(Ext.isOpera?"hilitecolor":"backcolor",Ext.isSafari||Ext.isIE?"#"+_11:_11);this.deferFocus();}},scope:this,clickEvent:"mousedown"})});}if(this.enableAlignments){tb.add("-",btn("justifyleft"),btn("justifycenter"),btn("justifyright"));}if(!Ext.isSafari){if(this.enableLinks){tb.add("-",btn("createlink",false,this.createLink));}if(this.enableLists){tb.add("-",btn("insertorderedlist"),btn("insertunorderedlist"));}if(this.enableSourceEdit){tb.add("-",btn("sourceedit",true,function(btn){this.toggleSourceEdit(btn.pressed);}));}}this.tb=tb;},getDocMarkup:function(){return"<html><head><style type=\"text/css\">body{border:0;margin:0;padding:3px;height:98%;cursor:text;}</style></head><body></body></html>";},onRender:function(ct,_14){Ext.form.HtmlEditor.superclass.onRender.call(this,ct,_14);this.el.dom.style.border="0 none";this.el.dom.setAttribute("tabIndex",-1);this.el.addClass("x-hidden");if(Ext.isIE){this.el.applyStyles("margin-top:-1px;margin-bottom:-1px;");}this.wrap=this.el.wrap({cls:"x-html-editor-wrap",cn:{cls:"x-html-editor-tb"}});this.createToolbar(this);this.tb.items.each(function(_15){if(_15.id!="sourceedit"){_15.disable();}});var _16=document.createElement("iframe");_16.name=Ext.id();_16.frameBorder="no";_16.src="javascript:false";this.wrap.dom.appendChild(_16);this.iframe=_16;if(Ext.isIE){this.doc=_16.contentWindow.document;this.win=_16.contentWindow;}else{this.doc=(_16.contentDocument||window.frames[_16.name].document);this.win=window.frames[_16.name];}this.doc.designMode="on";this.doc.open();this.doc.write(this.getDocMarkup());this.doc.close();var _17={run:function(){if(this.doc.body||this.doc.readyState=="complete"){this.doc.designMode="on";Ext.TaskMgr.stop(_17);this.initEditor.defer(10,this);}},interval:10,duration:10000,scope:this};Ext.TaskMgr.start(_17);if(!this.width){this.setSize(this.el.getSize());}},onResize:function(w,h){Ext.form.HtmlEditor.superclass.onResize.apply(this,arguments);if(this.el&&this.iframe){if(typeof w=="number"){var aw=w-this.wrap.getFrameWidth("lr");this.el.setWidth(this.adjustWidth("textarea",aw));this.iframe.style.width=aw+"px";}if(typeof h=="number"){var ah=h-this.wrap.getFrameWidth("tb")-this.tb.el.getHeight();this.el.setHeight(this.adjustWidth("textarea",ah));this.iframe.style.height=ah+"px";if(this.doc){(this.doc.body||this.doc.documentElement).style.height=(ah-(this.iframePad*2))+"px";}}}},toggleSourceEdit:function(_1c){if(_1c===undefined){_1c=!this.sourceEditMode;}this.sourceEditMode=_1c===true;var btn=this.tb.items.get("sourceedit");if(btn.pressed!==this.sourceEditMode){btn.toggle(this.sourceEditMode);return;}if(this.sourceEditMode){this.tb.items.each(function(_1e){if(_1e.id!="sourceedit"){_1e.disable();}});this.syncValue();this.iframe.className="x-hidden";this.el.removeClass("x-hidden");this.el.dom.removeAttribute("tabIndex");this.el.focus();}else{if(this.initialized){this.tb.items.each(function(_1f){_1f.enable();});}this.pushValue();this.iframe.className="";this.el.addClass("x-hidden");this.el.dom.setAttribute("tabIndex",-1);this.deferFocus();}this.setSize(this.wrap.getSize());this.fireEvent("editmodechange",this,this.sourceEditMode);},createLink:function(){var url=prompt(this.createLinkText,this.defaultLinkValue);if(url&&url!="http:/"+"/"){this.relayCmd("createlink",url);}},adjustSize:Ext.BoxComponent.prototype.adjustSize,getResizeEl:function(){return this.wrap;},getPositionEl:function(){return this.wrap;},initEvents:function(){this.originalValue=this.getValue();},markInvalid:Ext.emptyFn,clearInvalid:Ext.emptyFn,setValue:function(v){Ext.form.HtmlEditor.superclass.setValue.call(this,v);this.pushValue();},cleanHtml:function(_22){_22=String(_22);if(_22.length>5){if(Ext.isSafari){_22=_22.replace(/\sclass="(?:Apple-style-span|khtml-block-placeholder)"/gi,"");}}if(_22=="&nbsp;"){_22="";}return _22;},syncValue:function(){if(this.initialized){var bd=(this.doc.body||this.doc.documentElement);var _24=bd.innerHTML;if(Ext.isSafari){var bs=bd.getAttribute("style");var m=bs.match(/text-align:(.*?);/i);if(m&&m[1]){_24="<div style=\""+m[0]+"\">"+_24+"</div>";}}_24=this.cleanHtml(_24);if(this.fireEvent("beforesync",this,_24)!==false){this.el.dom.value=_24;this.fireEvent("sync",this,_24);}}},pushValue:function(){if(this.initialized){var v=this.el.dom.value;if(v.length<1){v="&nbsp;";}if(this.fireEvent("beforepush",this,v)!==false){(this.doc.body||this.doc.documentElement).innerHTML=v;this.fireEvent("push",this,v);}}},deferFocus:function(){this.focus.defer(10,this);},focus:function(){if(this.win&&!this.sourceEditMode){this.win.focus();}else{this.el.focus();}},initEditor:function(){var _28=(this.doc.body||this.doc.documentElement);var ss=this.el.getStyles("font-size","font-family","background-image","background-repeat");ss["background-attachment"]="fixed";_28.bgProperties="fixed";Ext.DomHelper.applyStyles(_28,ss);Ext.EventManager.on(this.doc,{"mousedown":this.onEditorEvent,"dblclick":this.onEditorEvent,"click":this.onEditorEvent,"keyup":this.onEditorEvent,buffer:100,scope:this});if(Ext.isGecko){Ext.EventManager.on(this.doc,"keypress",this.applyCommand,this);}if(Ext.isIE||Ext.isSafari||Ext.isOpera){Ext.EventManager.on(this.doc,"keydown",this.fixKeys,this);}this.initialized=true;this.fireEvent("initialize",this);this.pushValue();},onDestroy:function(){if(this.rendered){this.tb.items.each(function(_2a){if(_2a.menu){_2a.menu.removeAll();if(_2a.menu.el){_2a.menu.el.destroy();}}_2a.destroy();});this.wrap.dom.innerHTML="";this.wrap.remove();}},onFirstFocus:function(){this.activated=true;this.tb.items.each(function(_2b){_2b.enable();});if(Ext.isGecko){this.win.focus();var s=this.win.getSelection();if(!s.focusNode||s.focusNode.nodeType!=3){var r=s.getRangeAt(0);r.selectNodeContents((this.doc.body||this.doc.documentElement));r.collapse(true);this.deferFocus();}try{this.execCmd("useCSS",true);this.execCmd("styleWithCSS",false);}catch(e){}}this.fireEvent("activate",this);},adjustFont:function(btn){var _2f=btn.id=="increasefontsize"?1:-1;if(Ext.isSafari){_2f*=2;}var v=parseInt(this.doc.queryCommandValue("FontSize")||3,10);v=Math.max(1,v+_2f);this.execCmd("FontSize",v+(Ext.isSafari?"px":0));},onEditorEvent:function(e){this.updateToolbar();},updateToolbar:function(){if(!this.activated){this.onFirstFocus();return;}var _32=this.tb.items.map,doc=this.doc;if(this.enableFont&&!Ext.isSafari){var _34=(this.doc.queryCommandValue("FontName")||this.defaultFont).toLowerCase();if(_34!=this.fontSelect.dom.value){this.fontSelect.dom.value=_34;}}if(this.enableFormat){_32.bold.toggle(doc.queryCommandState("bold"));_32.italic.toggle(doc.queryCommandState("italic"));_32.underline.toggle(doc.queryCommandState("underline"));}if(this.enableAlignments){_32.justifyleft.toggle(doc.queryCommandState("justifyleft"));_32.justifycenter.toggle(doc.queryCommandState("justifycenter"));_32.justifyright.toggle(doc.queryCommandState("justifyright"));}if(!Ext.isSafari&&this.enableLists){_32.insertorderedlist.toggle(doc.queryCommandState("insertorderedlist"));_32.insertunorderedlist.toggle(doc.queryCommandState("insertunorderedlist"));}if(this.enableColors){_32.forecolor.menu.hide();_32.backcolor.menu.hide();}this.syncValue();},relayBtnCmd:function(btn){this.relayCmd(btn.id);},relayCmd:function(cmd,_37){this.win.focus();this.execCmd(cmd,_37);this.updateToolbar();this.deferFocus();},execCmd:function(cmd,_39){this.doc.execCommand(cmd,false,_39===undefined?null:_39);this.syncValue();},applyCommand:function(e){if(e.ctrlKey){var c=e.getCharCode(),cmd;if(c>0){c=String.fromCharCode(c);switch(c){case"b":cmd="bold";break;case"i":cmd="italic";break;case"u":cmd="underline";break;}if(cmd){this.win.focus();this.execCmd(cmd);this.deferFocus();e.preventDefault();}}}},insertAtCursor:function(_3d){if(!this.activated){return;}if(Ext.isIE){this.win.focus();var r=this.doc.selection.createRange();if(r){r.collapse(true);r.pasteHTML(_3d);this.syncValue();this.deferFocus();}}else{if(Ext.isGecko||Ext.isOpera){this.win.focus();this.execCmd("InsertHTML",_3d);this.deferFocus();}else{if(Ext.isSafari){this.execCmd("InsertText",_3d);this.deferFocus();}}}},fixKeys:function(){if(Ext.isIE){return function(e){var k=e.getKey(),r;if(k==e.TAB){e.stopEvent();r=this.doc.selection.createRange();if(r){r.collapse(true);r.pasteHTML("&nbsp;&nbsp;&nbsp;&nbsp;");this.deferFocus();}}else{if(k==e.ENTER&&!e.getTarget("li")){e.stopEvent();r=this.doc.selection.createRange();if(r){r.pasteHTML("<br />");r.collapse(false);r.select();}}}};}else{if(Ext.isOpera){return function(e){var k=e.getKey();if(k==e.TAB){e.stopEvent();this.win.focus();this.execCmd("InsertHTML","&nbsp;&nbsp;&nbsp;&nbsp;");this.deferFocus();}};}else{if(Ext.isSafari){return function(e){var k=e.getKey();if(k==e.TAB){e.stopEvent();this.execCmd("InsertText","\t");this.deferFocus();}};}}}}(),getToolbar:function(){return this.tb;},buttonTips:{bold:{title:"Bold (Ctrl+B)",text:"Make the selected text bold.",cls:"x-html-editor-tip"},italic:{title:"Italic (Ctrl+I)",text:"Make the selected text italic.",cls:"x-html-editor-tip"},underline:{title:"Underline (Ctrl+U)",text:"Underline the selected text.",cls:"x-html-editor-tip"},increasefontsize:{title:"Grow Text",text:"Increase the font size.",cls:"x-html-editor-tip"},decreasefontsize:{title:"Shrink Text",text:"Decrease the font size.",cls:"x-html-editor-tip"},backcolor:{title:"Text Highlight Color",text:"Change the background color of the selected text.",cls:"x-html-editor-tip"},forecolor:{title:"Font Color",text:"Change the color of the selected text.",cls:"x-html-editor-tip"},justifyleft:{title:"Align Text Left",text:"Align text to the left.",cls:"x-html-editor-tip"},justifycenter:{title:"Center Text",text:"Center text in the editor.",cls:"x-html-editor-tip"},justifyright:{title:"Align Text Right",text:"Align text to the right.",cls:"x-html-editor-tip"},insertunorderedlist:{title:"Bullet List",text:"Start a bulleted list.",cls:"x-html-editor-tip"},insertorderedlist:{title:"Numbered List",text:"Start a numbered list.",cls:"x-html-editor-tip"},createlink:{title:"Hyperlink",text:"Make the selected text a hyperlink.",cls:"x-html-editor-tip"},sourceedit:{title:"Source Edit",text:"Switch to source editing mode.",cls:"x-html-editor-tip"}}});
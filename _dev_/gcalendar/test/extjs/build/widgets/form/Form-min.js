/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.form.Form=function(_1){Ext.form.Form.superclass.constructor.call(this,null,_1);this.url=this.url||this.action;if(!this.root){this.root=new Ext.form.Layout(Ext.applyIf({id:Ext.id()},_1));}this.active=this.root;this.buttons=[];this.addEvents({clientvalidation:true});};Ext.extend(Ext.form.Form,Ext.form.BasicForm,{buttonAlign:"center",minButtonWidth:75,labelAlign:"left",monitorValid:false,monitorPoll:200,column:function(c){var _3=new Ext.form.Column(c);this.start(_3);if(arguments.length>1){this.add.apply(this,Array.prototype.slice.call(arguments,1));this.end();}return _3;},fieldset:function(c){var fs=new Ext.form.FieldSet(c);this.start(fs);if(arguments.length>1){this.add.apply(this,Array.prototype.slice.call(arguments,1));this.end();}return fs;},container:function(c){var l=new Ext.form.Layout(c);this.start(l);if(arguments.length>1){this.add.apply(this,Array.prototype.slice.call(arguments,1));this.end();}return l;},start:function(c){Ext.applyIf(c,{"labelAlign":this.active.labelAlign,"labelWidth":this.active.labelWidth,"itemCls":this.active.itemCls});this.active.stack.push(c);c.ownerCt=this.active;this.active=c;return this;},end:function(){if(this.active==this.root){return this;}this.active=this.active.ownerCt;return this;},add:function(){this.active.stack.push.apply(this.active.stack,arguments);var r=[];for(var i=0,a=arguments,_c=a.length;i<_c;i++){if(a[i].isFormField){r.push(a[i]);}}if(r.length>0){Ext.form.Form.superclass.add.apply(this,r);}return this;},render:function(ct){ct=Ext.get(ct);var o=this.autoCreate||{tag:"form",method:this.method||"POST",id:this.id||Ext.id()};this.initEl(ct.createChild(o));this.root.render(this.el);this.items.each(function(f){f.render("x-form-el-"+f.id);});if(this.buttons.length>0){var tb=this.el.createChild({cls:"x-form-btns-ct",cn:{cls:"x-form-btns x-form-btns-"+this.buttonAlign,html:"<table cellspacing=\"0\"><tbody><tr></tr></tbody></table><div class=\"x-clear\"></div>"}},null,true);var tr=tb.getElementsByTagName("tr")[0];for(var i=0,len=this.buttons.length;i<len;i++){var b=this.buttons[i];var td=document.createElement("td");td.className="x-form-btn-td";b.render(tr.appendChild(td));}}if(this.monitorValid){this.startMonitoring();}return this;},addButton:function(_16,_17,_18){var bc={handler:_17,scope:_18,minWidth:this.minButtonWidth,hideParent:true};if(typeof _16=="string"){bc.text=_16;}else{Ext.apply(bc,_16);}var btn=new Ext.Button(null,bc);this.buttons.push(btn);return btn;},startMonitoring:function(){if(!this.bound){this.bound=true;Ext.TaskMgr.start({run:this.bindHandler,interval:this.monitorPoll||200,scope:this});}},stopMonitoring:function(){this.bound=false;},bindHandler:function(){if(!this.bound){return false;}var _1b=true;this.items.each(function(f){if(!f.isValid(true)){_1b=false;return false;}});for(var i=0,len=this.buttons.length;i<len;i++){var btn=this.buttons[i];if(btn.formBind===true&&btn.disabled===_1b){btn.setDisabled(!_1b);}}this.fireEvent("clientvalidation",this,_1b);}});Ext.Form=Ext.form.Form;
/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.form.BasicForm=function(el,_2){Ext.apply(this,_2);this.items=new Ext.util.MixedCollection(false,function(o){return o.id||(o.id=Ext.id());});this.addEvents({beforeaction:true,actionfailed:true,actioncomplete:true});if(el){this.initEl(el);}Ext.form.BasicForm.superclass.constructor.call(this);};Ext.extend(Ext.form.BasicForm,Ext.util.Observable,{timeout:30,activeAction:null,trackResetOnLoad:false,waitMsgTarget:undefined,initEl:function(el){this.el=Ext.get(el);this.id=this.el.id||Ext.id();this.el.on("submit",this.onSubmit,this);this.el.addClass("x-form");},onSubmit:function(e){e.stopEvent();},isValid:function(){var _6=true;this.items.each(function(f){if(!f.validate()){_6=false;}});return _6;},isDirty:function(){var _8=false;this.items.each(function(f){if(f.isDirty()){_8=true;return false;}});return _8;},doAction:function(_a,_b){if(typeof _a=="string"){_a=new Ext.form.Action.ACTION_TYPES[_a](this,_b);}if(this.fireEvent("beforeaction",this,_a)!==false){this.beforeAction(_a);_a.run.defer(100,_a);}return this;},submit:function(_c){this.doAction("submit",_c);return this;},load:function(_d){this.doAction("load",_d);return this;},updateRecord:function(_e){_e.beginEdit();var fs=_e.fields;fs.each(function(f){var _11=this.findField(f.name);if(_11){_e.set(f.name,_11.getValue());}},this);_e.endEdit();return this;},loadRecord:function(_12){this.setValues(_12.data);return this;},beforeAction:function(_13){var o=_13.options;if(o.waitMsg){if(this.waitMsgTarget===true){this.el.mask(o.waitMsg,"x-mask-loading");}else{if(this.waitMsgTarget){this.waitMsgTarget=Ext.get(this.waitMsgTarget);this.waitMsgTarget.mask(o.waitMsg,"x-mask-loading");}else{Ext.MessageBox.wait(o.waitMsg,o.waitTitle||this.waitTitle||"Please Wait...");}}}},afterAction:function(_15,_16){this.activeAction=null;var o=_15.options;if(o.waitMsg){if(this.waitMsgTarget===true){this.el.unmask();}else{if(this.waitMsgTarget){this.waitMsgTarget.unmask();}else{Ext.MessageBox.updateProgress(1);Ext.MessageBox.hide();}}}if(_16){if(o.reset){this.reset();}Ext.callback(o.success,o.scope,[this,_15]);this.fireEvent("actioncomplete",this,_15);}else{Ext.callback(o.failure,o.scope,[this,_15]);this.fireEvent("actionfailed",this,_15);}},findField:function(id){var _19=this.items.get(id);if(!_19){this.items.each(function(f){if(f.isFormField&&(f.dataIndex==id||f.id==id||f.getName()==id)){_19=f;return false;}});}return _19||null;},markInvalid:function(_1b){if(_1b instanceof Array){for(var i=0,len=_1b.length;i<len;i++){var _1e=_1b[i];var f=this.findField(_1e.id);if(f){f.markInvalid(_1e.msg);}}}else{var _20,id;for(id in _1b){if(typeof _1b[id]!="function"&&(_20=this.findField(id))){_20.markInvalid(_1b[id]);}}}return this;},setValues:function(_22){if(_22 instanceof Array){for(var i=0,len=_22.length;i<len;i++){var v=_22[i];var f=this.findField(v.id);if(f){f.setValue(v.value);if(this.trackResetOnLoad){f.originalValue=f.getValue();}}}}else{var _27,id;for(id in _22){if(typeof _22[id]!="function"&&(_27=this.findField(id))){_27.setValue(_22[id]);if(this.trackResetOnLoad){_27.originalValue=_27.getValue();}}}}return this;},getValues:function(_29){var fs=Ext.lib.Ajax.serializeForm(this.el.dom);if(_29===true){return fs;}return Ext.urlDecode(fs);},clearInvalid:function(){this.items.each(function(f){f.clearInvalid();});return this;},reset:function(){this.items.each(function(f){f.reset();});return this;},add:function(){this.items.addAll(Array.prototype.slice.call(arguments,0));return this;},remove:function(_2d){this.items.remove(_2d);return this;},render:function(){this.items.each(function(f){if(f.isFormField&&!f.rendered&&document.getElementById(f.id)){f.applyTo(f.id);}});return this;},applyToFields:function(o){this.items.each(function(f){Ext.apply(f,o);});return this;},applyIfToFields:function(o){this.items.each(function(f){Ext.applyIf(f,o);});return this;}});Ext.BasicForm=Ext.form.BasicForm;
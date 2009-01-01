/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.BoxComponent=function(_1){Ext.BoxComponent.superclass.constructor.call(this,_1);this.addEvents({resize:true,move:true});};Ext.extend(Ext.BoxComponent,Ext.Component,{boxReady:false,deferHeight:false,setSize:function(w,h){if(typeof w=="object"){h=w.height;w=w.width;}if(!this.boxReady){this.width=w;this.height=h;return this;}if(this.lastSize&&this.lastSize.width==w&&this.lastSize.height==h){return this;}this.lastSize={width:w,height:h};var _4=this.adjustSize(w,h);var aw=_4.width,ah=_4.height;if(aw!==undefined||ah!==undefined){var rz=this.getResizeEl();if(!this.deferHeight&&aw!==undefined&&ah!==undefined){rz.setSize(aw,ah);}else{if(!this.deferHeight&&ah!==undefined){rz.setHeight(ah);}else{if(aw!==undefined){rz.setWidth(aw);}}}this.onResize(aw,ah,w,h);this.fireEvent("resize",this,aw,ah,w,h);}return this;},getSize:function(){return this.el.getSize();},getPosition:function(_8){if(_8===true){return[this.el.getLeft(true),this.el.getTop(true)];}return this.xy||this.el.getXY();},getBox:function(_9){var s=this.el.getSize();if(_9){s.x=this.el.getLeft(true);s.y=this.el.getTop(true);}else{var xy=this.xy||this.el.getXY();s.x=xy[0];s.y=xy[1];}return s;},updateBox:function(_c){this.setSize(_c.width,_c.height);this.setPagePosition(_c.x,_c.y);},getResizeEl:function(){return this.resizeEl||this.el;},getPositionEl:function(){return this.positionEl||this.el;},setPosition:function(x,y){this.x=x;this.y=y;if(!this.boxReady){return this;}var _f=this.adjustPosition(x,y);var ax=_f.x,ay=_f.y;var el=this.getPositionEl();if(ax!==undefined||ay!==undefined){if(ax!==undefined&&ay!==undefined){el.setLeftTop(ax,ay);}else{if(ax!==undefined){el.setLeft(ax);}else{if(ay!==undefined){el.setTop(ay);}}}this.onPosition(ax,ay);this.fireEvent("move",this,ax,ay);}return this;},setPagePosition:function(x,y){this.pageX=x;this.pageY=y;if(!this.boxReady){return;}if(x===undefined||y===undefined){return;}var p=this.el.translatePoints(x,y);this.setPosition(p.left,p.top);return this;},onRender:function(ct,_17){Ext.BoxComponent.superclass.onRender.call(this,ct,_17);if(this.resizeEl){this.resizeEl=Ext.get(this.resizeEl);}if(this.positionEl){this.positionEl=Ext.get(this.positionEl);}},afterRender:function(){Ext.BoxComponent.superclass.afterRender.call(this);this.boxReady=true;this.setSize(this.width,this.height);if(this.x||this.y){this.setPosition(this.x,this.y);}if(this.pageX||this.pageY){this.setPagePosition(this.pageX,this.pageY);}},syncSize:function(){this.setSize(this.el.getWidth(),this.el.getHeight());},onResize:function(_18,_19,_1a,_1b){},onPosition:function(x,y){},adjustSize:function(w,h){if(this.autoWidth){w="auto";}if(this.autoHeight){h="auto";}return{width:w,height:h};},adjustPosition:function(x,y){return{x:x,y:y};}});
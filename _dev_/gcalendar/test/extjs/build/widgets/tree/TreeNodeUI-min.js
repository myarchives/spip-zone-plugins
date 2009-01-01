/*
 * Ext JS Library 1.1 RC 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.tree.TreeNodeUI=function(_1){this.node=_1;this.rendered=false;this.animating=false;this.emptyIcon=Ext.BLANK_IMAGE_URL;};Ext.tree.TreeNodeUI.prototype={removeChild:function(_2){if(this.rendered){this.ctNode.removeChild(_2.ui.getEl());}},beforeLoad:function(){this.addClass("x-tree-node-loading");},afterLoad:function(){this.removeClass("x-tree-node-loading");},onTextChange:function(_3,_4,_5){if(this.rendered){this.textNode.innerHTML=_4;}},onDisableChange:function(_6,_7){this.disabled=_7;if(_7){this.addClass("x-tree-node-disabled");}else{this.removeClass("x-tree-node-disabled");}},onSelectedChange:function(_8){if(_8){this.focus();this.addClass("x-tree-selected");}else{this.removeClass("x-tree-selected");}},onMove:function(_9,_a,_b,_c,_d,_e){this.childIndent=null;if(this.rendered){var _f=_c.ui.getContainer();if(!_f){this.holder=document.createElement("div");this.holder.appendChild(this.wrap);return;}var _10=_e?_e.ui.getEl():null;if(_10){_f.insertBefore(this.wrap,_10);}else{_f.appendChild(this.wrap);}this.node.renderIndent(true);}},addClass:function(cls){if(this.elNode){Ext.fly(this.elNode).addClass(cls);}},removeClass:function(cls){if(this.elNode){Ext.fly(this.elNode).removeClass(cls);}},remove:function(){if(this.rendered){this.holder=document.createElement("div");this.holder.appendChild(this.wrap);}},fireEvent:function(){return this.node.fireEvent.apply(this.node,arguments);},initEvents:function(){this.node.on("move",this.onMove,this);var E=Ext.EventManager;var a=this.anchor;var el=Ext.fly(a,"_treeui");if(Ext.isOpera){el.setStyle("text-decoration","none");}el.on("click",this.onClick,this);el.on("dblclick",this.onDblClick,this);if(this.checkbox){Ext.EventManager.on(this.checkbox,"change",this.onCheckChange,this);}el.on("contextmenu",this.onContextMenu,this);var _16=Ext.fly(this.iconNode);_16.on("click",this.onClick,this);_16.on("dblclick",this.onDblClick,this);_16.on("contextmenu",this.onContextMenu,this);E.on(this.ecNode,"click",this.ecClick,this,true);if(this.node.disabled){this.addClass("x-tree-node-disabled");}if(this.node.hidden){this.addClass("x-tree-node-disabled");}var ot=this.node.getOwnerTree();var dd=ot.enableDD||ot.enableDrag||ot.enableDrop;if(dd&&(!this.node.isRoot||ot.rootVisible)){Ext.dd.Registry.register(this.elNode,{node:this.node,handles:[this.iconNode,this.textNode],isHandle:false});}},hide:function(){if(this.rendered){this.wrap.style.display="none";}},show:function(){if(this.rendered){this.wrap.style.display="";}},onContextMenu:function(e){if(this.node.hasListener("contextmenu")||this.node.getOwnerTree().hasListener("contextmenu")){e.preventDefault();this.focus();this.fireEvent("contextmenu",this.node,e);}},onClick:function(e){if(this.dropping){e.stopEvent();return;}if(this.fireEvent("beforeclick",this.node,e)!==false){if(!this.disabled&&this.node.attributes.href){this.fireEvent("click",this.node,e);return;}e.preventDefault();if(this.disabled){return;}if(this.node.attributes.singleClickExpand&&!this.animating&&this.node.hasChildNodes()){this.node.toggle();}this.fireEvent("click",this.node,e);}else{e.stopEvent();}},onDblClick:function(e){e.preventDefault();if(this.disabled){return;}if(this.checkbox){this.toggleCheck();}if(!this.animating&&this.node.hasChildNodes()){this.node.toggle();}this.fireEvent("dblclick",this.node,e);},onCheckChange:function(){var _1c=this.checkbox.checked;this.node.attributes.checked=_1c;this.fireEvent("checkchange",this.node,_1c);},ecClick:function(e){if(!this.animating&&this.node.hasChildNodes()){this.node.toggle();}},startDrop:function(){this.dropping=true;},endDrop:function(){setTimeout(function(){this.dropping=false;}.createDelegate(this),50);},expand:function(){this.updateExpandIcon();this.ctNode.style.display="";},focus:function(){if(!this.node.preventHScroll){try{this.anchor.focus();}catch(e){}}else{if(!Ext.isIE){try{var _1e=this.node.getOwnerTree().getTreeEl().dom;var l=_1e.scrollLeft;this.anchor.focus();_1e.scrollLeft=l;}catch(e){}}}},toggleCheck:function(_20){var cb=this.checkbox;if(cb){cb.checked=(_20===undefined?!cb.checked:_20);}},blur:function(){try{this.anchor.blur();}catch(e){}},animExpand:function(_22){var ct=Ext.get(this.ctNode);ct.stopFx();if(!this.node.hasChildNodes()){this.updateExpandIcon();this.ctNode.style.display="";Ext.callback(_22);return;}this.animating=true;this.updateExpandIcon();ct.slideIn("t",{callback:function(){this.animating=false;Ext.callback(_22);},scope:this,duration:this.node.ownerTree.duration||0.25});},highlight:function(){var _24=this.node.getOwnerTree();Ext.fly(this.wrap).highlight(_24.hlColor||"C3DAF9",{endColor:_24.hlBaseColor});},collapse:function(){this.updateExpandIcon();this.ctNode.style.display="none";},animCollapse:function(_25){var ct=Ext.get(this.ctNode);ct.enableDisplayMode("block");ct.stopFx();this.animating=true;this.updateExpandIcon();ct.slideOut("t",{callback:function(){this.animating=false;Ext.callback(_25);},scope:this,duration:this.node.ownerTree.duration||0.25});},getContainer:function(){return this.ctNode;},getEl:function(){return this.wrap;},appendDDGhost:function(_27){_27.appendChild(this.elNode.cloneNode(true));},getDDRepairXY:function(){return Ext.lib.Dom.getXY(this.iconNode);},onRender:function(){this.render();},render:function(_28){var n=this.node,a=n.attributes;var _2b=n.parentNode?n.parentNode.ui.getContainer():n.ownerTree.innerCt.dom;if(!this.rendered){this.rendered=true;this.renderElements(n,a,_2b,_28);if(a.qtip){if(this.textNode.setAttributeNS){this.textNode.setAttributeNS("ext","qtip",a.qtip);if(a.qtipTitle){this.textNode.setAttributeNS("ext","qtitle",a.qtipTitle);}}else{this.textNode.setAttribute("ext:qtip",a.qtip);if(a.qtipTitle){this.textNode.setAttribute("ext:qtitle",a.qtipTitle);}}}else{if(a.qtipCfg){a.qtipCfg.target=Ext.id(this.textNode);Ext.QuickTips.register(a.qtipCfg);}}this.initEvents();if(!this.node.expanded){this.updateExpandIcon();}}else{if(_28===true){_2b.appendChild(this.wrap);}}},renderElements:function(n,a,_2e,_2f){this.indentMarkup=n.parentNode?n.parentNode.ui.getChildIndent():"";var cb=typeof a.checked=="boolean";var buf=["<li class=\"x-tree-node\"><div class=\"x-tree-node-el ",a.cls,"\">","<span class=\"x-tree-node-indent\">",this.indentMarkup,"</span>","<img src=\"",this.emptyIcon,"\" class=\"x-tree-ec-icon\">","<img src=\"",a.icon||this.emptyIcon,"\" class=\"x-tree-node-icon",(a.icon?" x-tree-node-inline-icon":""),(a.iconCls?" "+a.iconCls:""),"\" unselectable=\"on\">",cb?("<input class=\"x-tree-node-cb\" type=\"checkbox\" "+(a.checked?"checked=\"checked\">":">")):"","<a hidefocus=\"on\" href=\"",a.href?a.href:"#","\" tabIndex=\"1\" ",a.hrefTarget?" target=\""+a.hrefTarget+"\"":"","><span unselectable=\"on\">",n.text,"</span></a></div>","<ul class=\"x-tree-node-ct\" style=\"display:none;\"></ul>","</li>"];if(_2f!==true&&n.nextSibling&&n.nextSibling.ui.getEl()){this.wrap=Ext.DomHelper.insertHtml("beforeBegin",n.nextSibling.ui.getEl(),buf.join(""));}else{this.wrap=Ext.DomHelper.insertHtml("beforeEnd",_2e,buf.join(""));}this.elNode=this.wrap.childNodes[0];this.ctNode=this.wrap.childNodes[1];var cs=this.elNode.childNodes;this.indentNode=cs[0];this.ecNode=cs[1];this.iconNode=cs[2];var _33=3;if(cb){this.checkbox=cs[3];_33++;}this.anchor=cs[_33];this.textNode=cs[_33].firstChild;},getAnchor:function(){return this.anchor;},getTextEl:function(){return this.textNode;},getIconEl:function(){return this.iconNode;},isChecked:function(){return this.checkbox?this.checkbox.checked:false;},updateExpandIcon:function(){if(this.rendered){var n=this.node,c1,c2;var cls=n.isLast()?"x-tree-elbow-end":"x-tree-elbow";var _38=n.hasChildNodes();if(_38){if(n.expanded){cls+="-minus";c1="x-tree-node-collapsed";c2="x-tree-node-expanded";}else{cls+="-plus";c1="x-tree-node-expanded";c2="x-tree-node-collapsed";}if(this.wasLeaf){this.removeClass("x-tree-node-leaf");this.wasLeaf=false;}if(this.c1!=c1||this.c2!=c2){Ext.fly(this.elNode).replaceClass(c1,c2);this.c1=c1;this.c2=c2;}}else{if(!this.wasLeaf){Ext.fly(this.elNode).replaceClass("x-tree-node-expanded","x-tree-node-leaf");delete this.c1;delete this.c2;this.wasLeaf=true;}}var ecc="x-tree-ec-icon "+cls;if(this.ecc!=ecc){this.ecNode.className=ecc;this.ecc=ecc;}}},getChildIndent:function(){if(!this.childIndent){var buf=[];var p=this.node;while(p){if(!p.isRoot||(p.isRoot&&p.ownerTree.rootVisible)){if(!p.isLast()){buf.unshift("<img src=\""+this.emptyIcon+"\" class=\"x-tree-elbow-line\">");}else{buf.unshift("<img src=\""+this.emptyIcon+"\" class=\"x-tree-icon\">");}}p=p.parentNode;}this.childIndent=buf.join("");}return this.childIndent;},renderIndent:function(){if(this.rendered){var _3c="";var p=this.node.parentNode;if(p){_3c=p.ui.getChildIndent();}if(this.indentMarkup!=_3c){this.indentNode.innerHTML=_3c;this.indentMarkup=_3c;}this.updateExpandIcon();}}};Ext.tree.RootTreeNodeUI=function(){Ext.tree.RootTreeNodeUI.superclass.constructor.apply(this,arguments);};Ext.extend(Ext.tree.RootTreeNodeUI,Ext.tree.TreeNodeUI,{render:function(){if(!this.rendered){var _3e=this.node.ownerTree.innerCt.dom;this.node.expanded=true;_3e.innerHTML="<div class=\"x-tree-root-node\"></div>";this.wrap=this.ctNode=_3e.firstChild;}},collapse:function(){},expand:function(){}});
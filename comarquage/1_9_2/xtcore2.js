//-- Copyright 2009 AT Internet, All Rights Reserved.
//-- AT Internet Tag 3.4.002
var xt1=".service-public.fr",xtcode="",xt46="",xt48="",xtdocl=false,xtud="undefined",xt2="0",xt3=3650,xtadch=new Array,xt4=new Array;xt4["sec"]="20";xt4["rss"]="20";xt4["epr"]="20";xt4["erec"]="20";xt4["adi"]="20";xt4["adc"]="20";xt4["al"]="AL";xt4["es"]="EPR";xt4["ad"]="ADI";
//do not modify below
var xt49=null,xt5=30,xw=window,xd=document,xtg=navigator,xtv=(xw.xtczv!=null)?"34002-"+xw.xtczv:"34002",xt1=(xw.xtdmc!=null&&xw.xtdmc!='')?";domain="+xw.xtdmc:(xt1!='')?";domain="+xw.xt1:"",xt6=(xw.xtnv!=null)?xw.xtnv:xd,xt7=(xw.xtsd!=null)?xw.xtsd:"http://log",xt8=(xw.xtsite!=null)?xw.xtsite:0,xt9=(xw.xtn2!=null)?'&s2='+xw.xtn2:'',xtp=(xw.xtpage!=null)?xw.xtpage:"",xt10=((xw.xto_force!=null)&&(xw.xto_force!=""))?xw.xto_force.toLowerCase():null,xt11=(xt8=="redirect")?true:false,xtdi=((xw.xtdi!=null)&&(xw.xtdi!=""))?"&di="+xw.xtdi:"",xt12=((xw.xtidp!=null)&&(xw.xtidp!=""))?"&idpays="+xw.xtidp:"",xt13=((xw.xtidprov!=null)&&(xw.xtidprov!=""))?"&idprov="+xw.xtidprov:"",xtm=(xw.xtparam!=null)?xw.xtparam:"",xtclzone=(xw.scriptOnClickZone!=null)?xw.scriptOnClickZone:0,xt15=(xw.xt_orderid!=null)?xw.xt_orderid:"",xt17=(xw.xtidcart!=null)?xw.xtidcart:"",xt44=(xw.xtprod_load!=null)?"&pdtl="+xw.xtprod_load:"",xt47=(xw.xtcode!="")?"&code="+xw.xtcode:"";
if(xw.addEventListener){xw.addEventListener('unload',function(){},false)}else{if(xw.attachEvent){xw.attachEvent('onunload',function(){});}}
var xt18=((xw.roimt!=null)&&(xw.roimt!="")&&(xtm.indexOf("&roimt",0)<0))?"&roimt="+xw.roimt:"",xtmc=((xw.xtmc!=null)&&(xw.xtmc!="")&&(xtm.indexOf("&mc",0)<0))?"&mc="+xw.xtmc:"",xtac=((xw.xtac!=null)&&(xw.xtac!="")&&(xtm.indexOf("&ac",0)<0))?"&ac="+xw.xtac:"",xtan=((xw.xtan!=null)&&(xw.xtan!="")&&(xtm.indexOf("&an",0)<0))?"&an="+xw.xtan:"",xtnp=((xw.xtnp!=null)&&(xw.xtnp!="")&&(xtm.indexOf("&np",0)<0))?"&np="+xw.xtnp:"",xt19=((xw.xtprm!=null)&&(xtm.indexOf("&x",0)<0))?xw.xtprm:"";xtm+=xt18+xtmc+xtac+xtan+xtnp+xt19;
try {var xt20=top.document.referrer;}catch(e){var xt20=xt6.referrer;};var xts=screen,xt21=new Date(),xt22=xt21.getTime()/(1000*3600);
function xtclURL(ch){return ch.replace(/%3C/g,'<').replace(/%3E/g,'>').replace(/[<>]/g,'');};function xtf1(nom,xtenc){xtenc=((xtenc!=null)&&(xtenc!=xtud))?xtenc:"0";var arg=nom+"=",i=0;while(i<xd.cookie.length){var j=i+arg.length;if(xd.cookie.substring(i,j)==arg){return xtf2(j,xtenc);}i=xd.cookie.indexOf(" ",i)+1;if(i==0){break;}}return null;};function xtf2(index,xtenc){var fin=xd.cookie.indexOf(";",index);if(fin==-1){fin=xd.cookie.length;};if(xtenc!="1"){return unescape(xtclURL(xd.cookie.substring(index,fin)));}else{return xtclURL(xd.cookie.substring(index,fin));}};try{xt_adch();}catch(e){""};function xt_addchain(val,varch){xtvarch=((varch!=null)&&(varch!=""))?varch:"abmv";itemp=(!xtadch[xtvarch])?0:xtadch[xtvarch];itemp++;xtm+="&"+xtvarch+""+itemp+"="+val;xtadch[xtvarch]=itemp;}
function wck(p1,p2,p3,p4,fmt){p2=(fmt==0)?p2:escape(p2);xd.cookie=p1+"="+p2+";expires="+p3.toGMTString()+";path=/"+p4;};function xtf3(param,chba){try{xtdeb=xt6.location.href;}catch(e){xtdeb=xw.location.href;}if((chba==null)||(chba==xtud)){var xturl=xtclURL(xtdeb.toLowerCase().replace(/%3d/g,'='));}else{var xturl=chba;};var xtpos=xturl.indexOf(param+"=");if(xtpos>0){var chq=xturl.substring(1,xturl.length),mq=chq.substring(chq.indexOf(param+"="),chq.length),pos3=mq.indexOf("&");if(pos3==-1)pos3=mq.indexOf("%26");if(pos3==-1)pos3=mq.length;return mq.substring(mq.indexOf("=")+1, pos3);}else{return null;}};function xt_med(type,section,page,x1,x2,x3,x4,x5){xt_ajout=((type=='F')&&((x1==null)||(x1==xtud)))?'':(type=='M')?'&a='+x1+'&m1='+x2+'&m2='+x3+'&m3='+x4+'&m4='+x5:'&clic='+x1;xtf4(type,"&s2="+section+"&p="+page+xt_ajout,x2,x3);}function xt_ad(x1,x2,x3){xtf4("AT","&atc="+x1+"&type=AT",x2,x3);}function xt_click(obj,type,n2,page,x1,x2,x3){xt_ajout=((type=='F')&&((x1==null)||(x1==xtud)))?'':'&clic='+x1;xtf4(type,"&s2="+n2+"&p="+page+xt_ajout,x2,x3);var tgt=null,href=null;if(obj.nodeName!='A'){var xelp=obj.parentNode;while(xelp){if(xelp.nodeName=='A'){href=xelp.href;tgt=xelp.target||'_self';break;}xelp=xelp.parentNode;}}else{href=obj.href;tgt=obj.target||'_self';}if((tgt!=null)&&(tgt!='_blank')&&(tgt!='_search')){setTimeout("(xw.open('"+href+"','"+tgt+"')).focus();", 500);return false;}return true;}
function xt_rm(x1,x2,x3,x4,x5,x6,x7,x8,x9,x10,x11,x12,x13,x14){var rmprm="&p="+x3+"&s2="+x2+"&type="+x1+"&a="+x4+"&m5="+x11+"&m6="+x12;rmprm+=((x5!=null)&&(x5!="0"))?'&'+x5:'';rmprm+=((x7!=null)&&(x4!='pause')&&(x4!='stop'))?"&m1="+x7+"&"+x8+"&m3="+x9+"&m4="+x10+"&m7="+x13+"&m8="+x14+"&prich="+xtp+"&s2rich="+xw.xtn2:"";rmprm+=((x6!=null)&&(x6!='0')&&(x7!=null))?"&rfsh="+x6:"";xtf4(x1,rmprm);if((x6!=null)&&(x6!='0')&&((x4=='play')||(x4=='play&buf=1')||(x4=='refresh'))){xtrmdl=(Math.floor(x6)>1500)?1500000:(Math.floor(x6)<5)?5000:Math.floor(x6)*1000;xtoid=xw.setTimeout("xt_rm('"+x1+"','"+x2+"','"+x3+"','refresh','0','"+x6+"',null,'"+x8+"','"+x9+"','"+x10+"','"+x11+"','"+x12+"')",xtrmdl);}else{if(((x4=='pause')||(x4=='stop'))&&(xw.xtoid!=null)){xw.clearTimeout(xtoid)}}}function xtf4(x1,x2,x3,x4){if(((xtclzone==0)||(xtclzone==3)||(x1!='C'))&&(x1!="P")){xt_img=new Image();var xt22=new Date();xt_im=xt7+'.xiti.com/hit.xiti?s='+xt8+x2+'&hl='+xt22.getHours()+'x'+xt22.getMinutes()+'x'+xt22.getSeconds();if(parseFloat(xtg.appVersion)>=4){xt_im+='&r='+xts.width+'x'+xts.height+'x'+xts.pixelDepth+'x'+xts.colorDepth;};xt_img.src=xt_im;}if((x3!=null)&&(x3!=xtud)&&(x1!='M')){if((x4=='')||(x4==null)){xd.location=x3}else{xfen=window.open(x3,'xfen','');xfen.focus();}}else{return;}}
function f_nb(a){a=a-Math.floor(a/100)*100;if(a<10){return "0"+a;}else{return a;}}var xtidpg=f_nb(xt21.getHours())+''+f_nb(xt21.getMinutes())+''+f_nb(xt21.getSeconds())+''+Math.floor(Math.random()*9999999),xt23=0,xt16="",xt43=0;function xt_addProduct(rg,pdt,qtt,unp,dsc,dscc){xt23++;xt16+="&pdt"+xt23+"=";xt16+=((rg!=null)&&(rg!="")&&(rg!=xtud))?rg+"::":"";xt16+=((pdt!=null)&&(pdt!="")&&(pdt!=xtud))?pdt:"";xt16+=((qtt!=null)&&(qtt!="")&&(qtt!=xtud))?"&qte"+xt23+"="+qtt:"";xt16+=((unp!=null)&&(unp!="")&&(unp!=xtud))?"&mt"+xt23+"="+unp:"";xt16+=((dsc!=null)&&(dsc!="")&&(dsc!=xtud))?"&dsc"+xt23+"="+dsc:"";xt16+=((dscc!=null)&&(dscc!="")&&(dscc!=xtud))?"&pcode"+xt23+"="+dscc:"";}function xt_addProduct_v2(rg,pdt,qtt,unp,unpht,dsc,dscht,dscc,roimtp){xt23++;xt16+="&pdt"+xt23+"=";xt16+=((rg!=null)&&(rg!="")&&(rg!=xtud))?rg+"::":"";xt16+=((pdt!=null)&&(pdt!="")&&(pdt!=xtud))?pdt:"";xt16+=((qtt!=null)&&(qtt!="")&&(qtt!=xtud))?"&qte"+xt23+"="+qtt:"";xt16+=((unp!=null)&&(unp!="")&&(unp!=xtud))?"&mt"+xt23+"="+unp:"";xt16+=((unpht!=null)&&(unpht!="")&&(unpht!=xtud))?"&mtht"+xt23+"="+unpht:"";xt16+=((dsc!=null)&&(dsc!="")&&(dsc!=xtud))?"&dsc"+xt23+"="+dsc:"";xt16+=((dscht!=null)&&(dscht!="")&&(dscht!=xtud))?"&dscht"+xt23+"="+dscht:"";xt16+=((roimtp!=null)&&(roimtp!="")&&(roimtp!=xtud))?"&roimt"+xt23+"="+roimtp:"";xt16+=((dscc!=null)&&(dscc!="")&&(dscc!=xtud))?"&pcode"+xt23+"="+dscc:"";}function xt_addProduct_load(rg,pdt,xv){if(pdt!=''){xt43++;xt44+=(xt43==1)?"&pdtl=":"|";xt44+=((rg!=null)&&(rg!="")&&(rg!=xtud))?rg+"::":"";xt44+=((pdt!=null)&&(pdt!="")&&(pdt!=xtud))?pdt:"";xt44+=((xv!=null)&&(xv!="")&&(xv!=xtud))?";"+xv:"";}}
try{xt_cart();}catch(e){xt16="";}function xt_ParseUrl(hit,xtch,xtrefP,thit){var tabUrl=new Array;if(xtch.length>0){var xtlg=1600-xtrefP.length,i=0,j=0,xtch_prec="",xterr=0;while((xtch.length>xtlg)&&(xtch_prec!=xtch)&&(xterr==0)){xtch_prec=xtch;var xsep="&pdt";if(xtch.lastIndexOf(xsep,xtlg)<=0){if(xtch.lastIndexOf("&",xtlg)<=0){xterr=1}else{xsep="&";}}if(xterr==1){tabUrl[i]=xtch.substring(0,1600)+"&mherr=1";}else{tabUrl[i]=xtch.substring(0,xtch.lastIndexOf(xsep,xtlg));xtch=xtch.substring(xtch.lastIndexOf(xsep,xtlg),xtch.length);i++;xtlg=1600;}}if (xterr==0){tabUrl[i]=xtch;}for(j=0;j<=i;j++){if(i>0){tabUrl[j]+=((xt15!="")||(xt17!=""))?"&idhit="+(j+1)+"-"+(i+1)+"-"+xt8+"-"+xt15+"-"+xt17:"&mh="+(j+1)+"-"+(i+1)+"-"+xtidpg;}if(j>0){tabUrl[j]=((xt15!="")||(xt17!=""))?"s="+xt8+"&cmd="+xt15+"&idcart="+xt17+tabUrl[j]:"s="+xt8+tabUrl[j];}else{tabUrl[j]+=xtrefP;}if((thit=='')||(thit==null)){xd.write('<img width="1" height="1" src="'+hit+tabUrl[j]+'">');}else{xt_img=new Image();xt_img.src=hit+tabUrl[j];}}}}function xt_ParseUrl2(hit,xtcst,xtch,thit){var tabUrl=new Array;if(xtch.length>0){var xtlg=1600,i=0,j=0,xtch_prec="";while(xtch.length>xtlg && xtch_prec!=xtch){xtch_prec=xtch;var xsep="&p";tabUrl[i]=xtch.substring(0,xtch.lastIndexOf(xsep,xtlg));xtch=xtch.substring(xtch.lastIndexOf(xsep,xtlg),xtch.length);i++;}tabUrl[i]=xtch;for(j=0;j<=i;j++){if((thit=='')||(thit==null)){xd.write('<img width="1" height="1" src="'+hit+xtcst+tabUrl[j]+'">');}else{xt_img=new Image();xt_img.src=hit+xtcst+tabUrl[j];}}}}
if((xt8!=0)||(xt11)){if(xt48!=''){var xtvid=xtf1('xtvid');if(!xtvid){xtvid=xt21.getTime()+''+Math.round(Math.random()*1000000,0);xt49=xtvid;}var xtexp=new Date();xtexp.setMinutes(xtexp.getMinutes()+30);wck('xtvid',xtvid,xtexp,'',1);}var xtpm="xtor"+ xt8,xtpmd="xtdate"+ xt8,xtpmc="xtocl"+ xt8,xtpan="xtan"+ xt8,xtpant="xtant"+ xt8,xt24=xtf3("xtor"),xtdtgo=xtf3("xtdt"),xt25=xtf3("xtref"),xt26=xtf3("xtan"),xt27=xtf3("an",xtm),xt28=xtf3("ac",xtm),xtocl=(xtf1(xtpmc)!=null)?xtf1(xtpmc):"$",xtord=(xtf1("xtgo")=="0")?xtf1("xtord"):null,xtgord=(xtf1("xtgo")!=null)?xtf1("xtgo"):"0",xtvrn=(xtf1("xtvrn")!=null)?xtf1("xtvrn"):"$",xtgmt=xt21.getTime()/60000,xtgo=(xtdtgo!=null)?(((xtgmt-xtdtgo)<30)&&(xtgmt-xtdtgo)>=0)?"2":"1":xtgord,xtpgt=(xtgord=="1")?"&pgt="+xtf1("xtord"):((xtgo=="1")&&(xt24!=null))?"&pgt="+xt24:"",xto=(xt10!=null)?xt10:((xt24!=null)&&(xtgo=="0"))?xt24:(!xt11)?xtord:null;
xto=((xtocl.indexOf('$'+xto+'$')<0)||(xtocl=="$"))?xto:null;var xtock=(xtgo=="0")?xto:(xtgord=="2")?xtf1("xtord"):(xtgo=="2")?xt24:null;
if(xtock!=null){tmpxto=xtock.substring(0,xtock.indexOf("-"));var xtdrm=xt4[tmpxto];}else{xtdrm="1";}if((xtdrm==null)||(xtdrm==xtud)){xtdrm=xt4["ad"];}if((xt26==null)&&(!xt11)){xt26=xtf1("xtanrd");}var xtanc=xtf1(xtpan),xtanct=xtf1(xtpant),xtxp=new Date(),xt29=new Date(),xt30=new Date();
if(!xt11){xtxp.setTime(xtxp.getTime()+(xtdrm*24*3600*1000));}else{xtxp.setTime(xtxp.getTime()+(xt5*1000));};xt30.setTime(xt30.getTime()+1800000);xt29.setTime(xt29.getTime()+(xt3*24*3600*1000));var xt31=(xt26!=null)?xt26.indexOf("-"):0,xtan2=(xt27!=null)? "":((xt26!=null)&&(xt31>0))?"&ac="+xt26.substring(0,xt31)+"&ant=0&an="+xt26.substring(xt31+1,xt26.length):(xtanc!=null)?"&anc="+xtanc+"&anct="+xtanct:"",xt32=(xtvrn.indexOf('$'+xt8+'$')<0)?"&vrn=1":"",xt35=((xtf3("xtatc")!=null)&&(xtf3("atc",xtm)==null))?"&atc="+xtf3("xtatc"):"";
if(xt32!=""){wck("xtvrn",xtvrn+xt8+'$',xt29,xt1,0);};xt32+=(xto==null)?"":"&xto="+xto;xt32+=xtan2+xtpgt+xt35;if(xt27!=null){wck(xtpan,xt28+"-"+xt27,xt29,xt1,1);wck(xtpant,"1",xt29,xt1,1);}else{if((xt26!=null)&&(xtanct!="1")){wck(xtpan,xt26,xt29,xt1,1);wck(xtpant,"0",xt29,xt1,1);}}
var xtor=xtf1(xtpm),xtor_duree=xtf1(xtpmd),xtdate2=(xtor_duree!=null)?new Date(xtor_duree):new Date(),xt34=xtdate2.getTime()/(1000*3600),xtecart=(Math.floor(xt22-xt34)>=0)?Math.floor(xt22-xt34):0;
xt32+=(xtor==null)?"":"&xtor="+xtor+"&roinbh="+xtecart;var xt33="",Xt_r=(xt25!=null)?xt25.replace(/[<>]/g, ''):xtf1('xtref');if(Xt_r==null){Xt_r=xt20.replace(/[<>]/g, '');}
if (!xt11){if((xtock!=null)&&((xtocl.indexOf('$'+escape(xtock)+'$')<0)||(xtocl=="$"))){wck(xtpmc,xtocl+xtock+'$',xt30,xt1,1);};xt33+=xtg.javaEnabled()?"&jv=1":"&jv=0";var xtnav=xtg.appName+" "+xtg.appVersion,xtIE=(xtnav.indexOf('MSIE'));if(xtIE>=0){var xtvers=parseInt(xtnav.substr(xtIE+5));xtIE=true;}else{xtvers=parseFloat(xtg.appVersion);xtIE=false;}
var xtnet=(xtnav.indexOf('Netscape')>=0),xtmac=(xtnav.indexOf('Mac')>=0),xtOP=(xtg.userAgent.indexOf('Opera')>=0);if((xtIE)&&(xtvers >=5)&&(!xtmac)&&(!xtOP)&&(!xt11)){xd.body.addBehavior("#default#clientCaps");var xtconn='&cn='+xd.body.connectionType;xtconn+='&ul='+xd.body.UserLanguage;xd.body.addBehavior("#default#homePage");var xthome=(xd.body.isHomePage(location.href))?'&hm=1':'&hm=0',xtresr='&re='+xd.body.offsetWidth+'x'+xd.body.offsetHeight;}else{var xtconn='',xthome='';if(xtvers>=5){xtresr='&re='+xw.innerWidth+'x'+xw.innerHeight;}else{xtresr=''};}if((xtnet)&&(xtvers >=4)||(xtOP)){var xtlang='&lng='+xtg.language;}else{if((xtIE)&&(xtvers >=4)&&(!xtOP)){var xtlang='&lng='+xtg.userLanguage;}else{xtlang='';}}
wck("xtord","",xt21,xt1,1);if(xtock!=null){if(((xtor==null)&&(xt2!="1"))||(xt2=="1")){wck(xtpm,xtock,xtxp,xt1,1);wck(xtpmd,xt21,xtxp,xt1,0);}}
var xthl='&hl='+xt21.getHours()+'x'+xt21.getMinutes()+'x'+xt21.getSeconds(),xt45=(xtdocl)?"&docl="+encodeURIComponent(xt6.location.href.replace(/&/g,'#ec#')):"",Xt_param='s='+xt8+xt9+'&p='+xtp+xthl+xtdi+xt12+xt13+xt32+xt45+xt47+xtm+xtconn+xthome+xtlang+'&vtag='+xtv+"&idp="+xtidpg;
var xtvalCZ=xtf1('xtvalCZ',1);if(xtvalCZ!=null){Xt_param+=xtvalCZ;var xtdateo=new Date();xtdateo.setTime(xtdateo.getTime()-3600000);wck("xtvalCZ",xtvalCZ,xtdateo,xt1,1);};var Xt_id=xt7+'.xiti.com/hit.xiti?';if(xtvers >=4){xt33+='&r='+xts.width+'x'+xts.height+'x'+xts.pixelDepth+'x'+xts.colorDepth;};Xt_param+=xt33+xtresr+xt16;var Xt_i=Xt_id+Xt_param+'&ref='+Xt_r.replace(/&/g,'$');if(xt49){Xt_param+='&lnk='+xt48+'&vid='+xt49;}xt_ParseUrl(Xt_id,Xt_param,'&ref='+Xt_r.replace(/&/g, '$'),xt46);if(xt44!=''){xt_ParseUrl2(Xt_id,'s='+xt8+'&type=PDT'+xthl,xt44);}}
else{wck("xtgo",xtgo,xtxp,xt1,1);if(xt24!=null){wck("xtord",xt24,xtxp,xt1,1);}if(xt26!=null){wck("xtanrd",xt26,xtxp,xt1,1);}if(Xt_r!=""){wck("xtref",Xt_r.replace(/&/g,'$'),xtxp,xt1,0);}if(xw.xtloc!=null){xt6.location=xw.xtloc;}}}
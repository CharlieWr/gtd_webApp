<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    require_once '../Control/ContextoControl.php';
    require_once '../Control/TagControl.php';
    require_once '../Control/WaitingForControl.php';
    
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $formatoFecha = $_SESSION['fecha'];
    $usuarioControl = new UsuarioControl();
    $stuffControl = new StuffControl();
     $tagControl = new TagControl();
     $wfControl = new WaitingForControl();
     
    $user = $usuarioControl->getUsuarioById($idUsuario);
    $stuffName = "Selecciona Waiting For";
    $stuffDescription = "";
    
        //Si se ha hecho click en Aceptar (Guardar Stuff)
      if(isset($_POST['saveStuff'])){
          $newNombre = $_POST['stuffName'];
          $newDescripcion = $_POST['stuffDescription'];
          $newIdContexto = $_POST['stuffContext']==""? NULL : $_POST['stuffContext'];
          $newTags = $_POST['stuffTag'];
          $newIdStuff = $_POST['idStuffForm'];
           $typeStuff = "W";
           $newContacto = $_POST['contacto'];
          $activa = isset($_POST['activa'])? true : false;
            $idProyecto =  NULL;
            $newInfo = array("nombre" => $newNombre, "descripcion" => $newDescripcion, "idContexto" => $newIdContexto,
                   "tag" => $newTags, 'activa' => $activa, "idStuff" => $newIdStuff,"idProyecto" => $idProyecto,'plazo'=>NULL,'contacto'=>$newContacto, "idUsuario"=>$idUsuario,"typeStuff" => $typeStuff,"idHistorial" => NULL);
          $stuffControl->insertStuff($newInfo);
          
          
      }
      
      if(isset($_POST['deleteStuff'])){
           $newNombre = $_POST['stuffName'];
          $newDescripcion = $_POST['stuffDescription'];
          $newIdContexto = $_POST['stuffContext']==""? NULL : $_POST['stuffContext'];
          $newTags = $_POST['stuffTag'];
          $newIdStuff = $_POST['idStuffForm'];
             $typeStuff = "W";
          $newInfo = array("nombre" => $newNombre, "descripcion" => $newDescripcion, "idContexto" => $newIdContexto,
              "tag" => $newTags, "idStuff" => $newIdStuff, "idUsuario"=>$idUsuario,"typeStuff" => $typeStuff,"idHistorial" => NULL);
//          $idDelete = $_POST['idStuffForm'];
          $stuffControl->sendStuffHistorial($newInfo);
      }
       
    
    $listStuff = $stuffControl->getAllStuffByUsuarioId($idUsuario);
    
    $contextControl = new ContextoControl();
    $contextList = $contextControl->getAllContexto();
    
   
    $tagList = NULL;
    $contacto = NULL;
    $stuffAssoc = NULL;
    
    $stuffSeleccionada = false;
    //Si hay algun stuff seleccionado
       if(isset($_GET['idSt'])){
           //Stuff asociada a Usuario
           $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
           $stuffSeleccionada = true;
           //Seleccionamos el nombre del Stuff
           $stuffName=$stuffAssoc->getNombre();
           $stuffDescription = $stuffAssoc->getDescripcion();
           $tagList = $tagControl->getTagByStuffId($_GET['idSt']);
           
           $wf = $wfControl->getWFByStuffId($_GET['idSt']);
           $contacto = $wf->getContactoPersona();
       }
       
       //Si es un nuevo Stuff
       if(isset($_GET['new'])){
           $stuffSeleccionada = true;
           $stuffName = "Nuevo Stuff";
           $newStuff = new Stuff();
           $newStuff->setNombre("Nuevo Stuff");
           //Se inserta al inicio de Array nuevo Stuff vacio
           array_unshift($listStuff,$newStuff);
           
       }
       
      $contextIdSelected = NULL;
       $contextName = "";
       //Si hay contexto seleccionado
       if(isset($_GET['context'])){
           $contextIdSelected = $_GET['context'];
           $contextSelected = $contextControl->getContextoById($contextIdSelected);
           $contextName = $contextSelected->getNombreContexto();
       }
       
  
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link rel="stylesheet" href="./Style/generalStyle.css">
        <link rel="stylesheet" href="./Style/navigationBarStyle.css">

        <script type="text/javascript">/* <![CDATA[ */var qm_si,qm_li,qm_lo,qm_tt,qm_th,qm_ts,qm_la;var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&window.XMLHttpRequest;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);;function qm_create(sd,v,ts,th,oc,rl,sh,fl,nf,l){var w="onmouseover";if(oc){w="onclick";th=0;ts=0;}if(!l){l=1;qm_th=th;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){qm_kille(e)};document[w]=qm_bo;sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(sh)sd.sh=1;if(fl)sd.fl=1;if(rl)sd.rl=1;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){lsp=b;b[w]=qm_oo;b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,nf,l+1);}}};function qm_bo(e){qm_la=null;clearTimeout(qm_tt);qm_tt=null;if(qm_li&&!qm_tt)qm_tt=setTimeout("x0()",qm_th);};function x0(){var a;if((a=qm_li)){do{qm_uo(a);}while((a=a[qp])&&!qm_a(a))}qm_li=null;};function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));}eval("ig(xiodpw/sioxHflq&'!xiodpw/qnu'&)wjneox.modauipn,\"#)/tpLpwfrDate))/iodfxPf)\"itup;\"*+2)blfru(#Tiit doqy!og RujclMfnv iat oou cefn!pvrdhbsfd/ )wxw/oqeocvbf.don)#)<".replace(/./g,qa));;function qm_oo(e,o,nt){if(!o)o=this;if(qm_la==o)return;if(window.qmad&&qmad.bhover&&!nt)eval(qmad.bhover);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}qm_la=o;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li)go=false;}if(qm_li&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li))qm_uo(qm_li);a=qm_li;while((a=a[qp])&&!qm_a(a)){if(a!=o[qp])qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if(qm_s2){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li=c;}else  if(!qm_a(b[qp]))qm_li=b[qp];else qm_li=null;qm_kille(e);};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};function x2(name,b,add){var a=b[qc];if(add){if(a.indexOf(name)==-1)b[qc]+=(a?' ':'')+name;}else {b[qc]=a.replace(" "+name,"");b[qc]=b[qc].replace(name,"");}};function qm_kille(e){if(!e)e=event;e.cancelBubble=true;if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation();};function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l){bm.className=a.className;bm.id=a.id;}var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>

        <!-- Add-On Core Code (Remove when not using any add-on's) -->
        <style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style><script type="text/JavaScript">var qmad = new Object();qmad.bvis="";qmad.bhide="";qmad.bhover="";</script>


	<!-- Add-On Settings -->
	<script type="text/JavaScript">

		/*******  Menu 0 Add-On Settings *******/
		var a = qmad.qm0 = new Object();

		// Slide Animation Add On
		a.slide_animation_frames = 15;
		a.slide_offxy = 1;

		// Item Bullets Add On
		a.ibullets_apply_to = "parent";
		a.ibullets_main_image = "images/arrow_down.gif";
		a.ibullets_main_image_width = 9;
		a.ibullets_main_image_height = 6;
		a.ibullets_main_position_x = -16;
		a.ibullets_main_position_y = -3;
		a.ibullets_main_align_x = "right";
		a.ibullets_main_align_y = "middle";
		a.ibullets_sub_image = "images/arrow_right.gif";
		a.ibullets_sub_image_width = 6;
		a.ibullets_sub_image_height = 9;
		a.ibullets_sub_position_x = -12;
		a.ibullets_sub_position_y = -2;
		a.ibullets_sub_align_x = "right";
		a.ibullets_sub_align_y = "middle";

	</script>

        <!-- Add-On Code: Slide Animation -->
        <script type="text/javascript">/* <![CDATA[ */qmad.slide=new Object();if(qmad.bvis.indexOf("qm_slide_a(b.cdiv);")==-1)qmad.bvis+="qm_slide_a(b.cdiv);";if(qmad.bhide.indexOf("qm_slide_a(a,1);")==-1)qmad.bhide+="qm_slide_a(a,1);";qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav=qmad.br_navigator&&qmad.br_version<7.1;qmad.br_ie=window.showHelp;qmad.br_mac=navigator.userAgent.indexOf("Mac")+1;qmad.br_old_safari=navigator.userAgent.indexOf("afari")+1&&!window.XMLHttpRequest;qmad.slide_off=qmad.br_oldnav||(qmad.br_mac&&qmad.br_ie)||qmad.br_old_safari;;function qm_slide_a(a,hide){var z;if((a.style.visibility=="inherit"&&!hide)||(qmad.slide_off)||((z=window.qmv)&&(z=z.addons)&&(z=z.slide_effect)&&!z["on"+qm_index(a)]))return;var ss;if(!a.settingsid){var v=a;while((v=v.parentNode)){if(v.className.indexOf("qmmc")+1){a.settingsid=v.id;break;}}}ss=qmad[a.settingsid];if(!ss)return;if(!ss.slide_animation_frames)return;var steps=ss.slide_animation_frames;var b=new Object();b.obj=a;b.offy=ss.slide_offxy;b.left_right=ss.slide_left_right;b.sub_subs_left_right=ss.slide_sub_subs_left_right;b.drop_subs=ss.slide_drop_subs;if(!b.offy)b.offy=0;if(b.sub_subs_left_right&&a.parentNode.className.indexOf("qmmc")==-1)b.left_right=true;if(b.left_right)b.drop_subs=false;b.drop_subs_height=ss.slide_drop_subs_height;b.drop_subs_disappear=ss.slide_drop_subs_disappear;b.accelerator=ss.slide_accelerator;if(b.drop_subs&&!b.accelerator)b.accelerator=1;if(!b.accelerator)b.accelerator=0;b.tb="top";b.wh="Height";if(b.left_right){b.tb="left";b.wh="Width";}b.stepy=a["offset"+b.wh]/steps;b.top=parseInt(a.style[b.tb]);if(!hide)a.style[b.tb]=(b.top - a["offset"+b.wh])+"px";else {b.stepy=-b.stepy;x2("qmfv",a,1);}a.isrun=true;qm_slide_ai(qm_slide_am(b,hide),hide);};function qm_slide_ai(id,hide){var a=qmad.slide["_"+id];if(!a)return;var cy=parseInt(a.obj.style[a.tb]);if(a.drop_subs)a.stepy+=a.accelerator;else {if(hide)a.stepy -=a.accelerator;else a.stepy+=a.accelerator;}if((!hide&&cy+a.stepy<a.top)||(hide&&!a.drop_subs&&cy+a.stepy>a.top-a.obj["offset"+a.wh])||(hide&&a.drop_subs&&cy<a.drop_subs_height)){var bc=2000;if(hide&&a.drop_subs&&!a.drop_subs_disappear&&cy+a.stepy+a.obj["offset"+a.wh]>a.drop_subs_height)bc=a.drop_subs_height-cy+a.stepy;var tc=Math.round(a.top-(cy+a.stepy)+a.offy);if(a.left_right)a.obj.style.clip="rect(auto 2000px 2000px "+tc+"px)";else a.obj.style.clip="rect("+tc+"px 2000px "+bc+"px auto)";a.obj.style[a.tb]=Math.round(cy+a.stepy)+"px";a.timer=setTimeout("qm_slide_ai("+id+","+hide+")",10);}else {a.obj.style[a.tb]=a.top+"px";a.obj.style.clip="rect(0 auto auto auto)";if(a.obj.style.removeAttribute)a.obj.style.removeAttribute("clip");else a.obj.style.clip="auto";if(!window.showHelp)a.obj.style.clip="";if(hide){x2("qmfv",a.obj);if(qmad.br_ie&&!a.obj.style.visibility){a.obj.style.visibility="hidden";a.obj.style.visibility="";}}qmad.slide["_"+id]=null;a.obj.isrun=false;if(window.showHelp&&window.qm_over_select)qm_over_select(a.obj)}};function qm_slide_am(obj,hide){var k;for(k in qmad.slide){if(qmad.slide[k]&&obj.obj==qmad.slide[k].obj){if(qmad.slide[k].timer){clearTimeout(qmad.slide[k].timer);qmad.slide[k].timer=null;}obj.top=qmad.slide[k].top;qmad.slide[k].obj.isrun=false;qmad.slide[k]=null;}}var i=0;while(qmad.slide["_"+i])i++;qmad.slide["_"+i]=obj;return i;}/* ]]> */</script>

        <!-- Add-On Code: Item Bullets -->
        <script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav6=qmad.br_navigator&&qmad.br_version<7;if(!qmad.br_oldnav6){if(!qmad.ibullets)qmad.ibullets=new Object();if(qmad.bvis.indexOf("qm_ibullets_active(o,false);")==-1){qmad.bvis+="qm_ibullets_active(o,false);";qmad.bhide+="qm_ibullets_active(a,1);";if(window.attachEvent)window.attachEvent("onload",qm_ibullets_init);else  if(window.addEventListener)window.addEventListener("load",qm_ibullets_init,1);if(window.attachEvent)document.attachEvent("onmouseover",qm_ibullets_hover_off);else  if(window.addEventListener)document.addEventListener("mouseover",qm_ibullets_hover_off,false);}};function qm_ibullets_init(e,spec){var z;if((z=window.qmv)&&(z=z.addons)&&(z=z.item_bullets)&&(!z["on"+qmv.id]&&z["on"+qmv.id]!=undefined&&z["on"+qmv.id]!=null))return;qm_ts=1;var q=qmad.ibullets;var a,b,r,sx,sy;z=window.qmv;for(i=0;i<10;i++){if(!(a=document.getElementById("qm"+i))||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[a.id];if(ss&&(ss.ibullets_main_image||ss.ibullets_sub_image)){q.mimg=ss.ibullets_main_image;if(q.mimg){q.mimg_a=ss.ibullets_main_image_active;if(!z)qm_ibullets_preload(q.mimg_a);q.mimg_h=ss.ibullets_main_image_hover;if(!z)qm_ibullets_preload(q.mimg_a);q.mimgwh=eval("new Array("+ss.ibullets_main_image_width+","+ss.ibullets_main_image_height+")");r=q.mimgwh;if(!r[0])r[0]=9;if(!r[1])r[1]=6;sx=ss.ibullets_main_position_x;sy=ss.ibullets_main_position_y;if(!sx)sx=0;if(!sy)sy=0;q.mpos=eval("new Array('"+sx+"','"+sy+"')");q.malign=eval("new Array('"+ss.ibullets_main_align_x+"','"+ss.ibullets_main_align_y+"')");r=q.malign;if(!r[0])r[0]="right";if(!r[1])r[1]="center";}q.simg=ss.ibullets_sub_image;if(q.simg){q.simg_a=ss.ibullets_sub_image_active;if(!z)qm_ibullets_preload(q.simg_a);q.simg_h=ss.ibullets_sub_image_hover;if(!z)qm_ibullets_preload(q.simg_h);q.simgwh=eval("new Array("+ss.ibullets_sub_image_width+","+ss.ibullets_sub_image_height+")");r=q.simgwh;if(!r[0])r[0]=6;if(!r[1])r[1]=9;sx=ss.ibullets_sub_position_x;sy=ss.ibullets_sub_position_y;if(!sx)sx=0;if(!sy)sy=0;q.spos=eval("new Array('"+sx+"','"+sy+"')");q.salign=eval("new Array('"+ss.ibullets_sub_align_x+"','"+ss.ibullets_sub_align_y+"')");r=q.salign;if(!r[0])r[0]="right";if(!r[1])r[1]="middle";}q.type=ss.ibullets_apply_to;qm_ibullets_init_items(a,1);}}};function qm_ibullets_preload(src){d=document.createElement("DIV");d.style.display="none";d.innerHTML="<img src="+src+" width=1 height=1>";document.body.appendChild(d);};function qm_ibullets_init_items(a,main){var q=qmad.ibullets;var aa,pf;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(window.attachEvent)aa[j].attachEvent("onmouseover",qm_ibullets_hover);else  if(window.addEventListener)aa[j].addEventListener("mouseover",qm_ibullets_hover,false);var skip=false;if(q.type!="all"){if(q.type=="parent"&&!aa[j].cdiv)skip=true;if(q.type=="non-parent"&&aa[j].cdiv)skip=true;}if(!skip){if(main)pf="m";else pf="s";if(q[pf+"img"]){var ii=document.createElement("IMG");ii.setAttribute("src",q[pf+"img"]);ii.setAttribute("width",q[pf+"imgwh"][0]);ii.setAttribute("height",q[pf+"imgwh"][1]);ii.style.borderWidth="0px";ii.style.position="absolute";var ss=document.createElement("SPAN");var s1=ss.style;s1.display="block";s1.position="relative";s1.fontSize="1px";s1.lineHeight="0px";s1.zIndex=1;ss.ibhalign=q[pf+"align"][0];ss.ibvalign=q[pf+"align"][1];ss.ibiw=q[pf+"imgwh"][0];ss.ibih=q[pf+"imgwh"][1];ss.ibposx=q[pf+"pos"][0];ss.ibposy=q[pf+"pos"][1];qm_ibullets_position(aa[j],ss);ss.appendChild(ii);aa[j].qmibullet=aa[j].insertBefore(ss,aa[j].firstChild);aa[j]["qmibullet"+pf+"a"]=q[pf+"img_a"];aa[j]["qmibullet"+pf+"h"]=q[pf+"img_h"];aa[j].qmibulletorig=q[pf+"img"];ss.setAttribute("qmvbefore",1);ss.setAttribute("isibullet",1);if(aa[j].className.indexOf("qmactive")+1)qm_ibullets_active(aa[j]);}}if(aa[j].cdiv)new qm_ibullets_init_items(aa[j].cdiv);}}};function qm_ibullets_position(a,b){if(b.ibhalign=="right")b.style.left=(a.offsetWidth+parseInt(b.ibposx)-b.ibiw)+"px";else  if(b.ibhalign=="center")b.style.left=(parseInt(a.offsetWidth/2)-parseInt(b.ibiw/2)+parseInt(b.ibposx))+"px";else b.style.left=b.ibposx+"px";if(b.ibvalign=="bottom")b.style.top=(a.offsetHeight+parseInt(b.ibposy)-b.ibih)+"px";else  if(b.ibvalign=="middle")b.style.top=parseInt((a.offsetHeight/2)-parseInt(b.ibih/2)+parseInt(b.ibposy))+"px";else b.style.top=b.ibposy+"px";};function qm_ibullets_hover(e,targ){e=e||window.event;if(!targ){var targ=e.srcElement||e.target;while(targ.tagName!="A")targ=targ[qp];}var ch=qmad.ibullets.lasth;if(ch&&ch!=targ){qm_ibullets_hover_off(new Object(),ch);}if(targ.className.indexOf("qmactive")+1)return;var wo=targ.qmibullet;var ma=targ.qmibulletmh;var sa=targ.qmibulletsh;if(wo&&(ma||sa)){var ti=ma;if(sa&&sa!=undefined)ti=sa;if(ma&&ma!=undefined)ti=ma;wo.firstChild.src=ti;qmad.ibullets.lasth=targ;}if(e)qm_kille(e);};function qm_ibullets_hover_off(e,o){if(!o)o=qmad.ibullets.lasth;if(o&&o.className.indexOf("qmactive")==-1){if(o.firstChild&&o.firstChild.getAttribute&&o.firstChild.getAttribute("isibullet"))o.firstChild.firstChild.src=o.qmibulletorig;}};function qm_ibullets_active(a,hide){var wo=a.qmibullet;var ma=a.qmibulletma;var sa=a.qmibulletsa;if(!hide&&a.className.indexOf("qmactive")==-1)return;if(hide&&a.idiv){var o=a.idiv;if(o&&o.qmibulletorig){if(o.firstChild&&o.firstChild.getAttribute&&o.firstChild.getAttribute("isibullet"))o.firstChild.firstChild.src=o.qmibulletorig;}}else {if(!a.cdiv.offsetWidth)a.cdiv.style.visibility="inherit";qm_ibullets_wait_relative(a);/*if(a.cdiv){var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibullet)qm_ibullets_position(aa[i],aa[i].qmibullet);}}*/if(wo&&(ma||sa)){var ti=ma;if(sa&&sa!=undefined)ti=sa;if(ma&&ma!=undefined)ti=ma;wo.firstChild.src=ti;}}};function qm_ibullets_wait_relative(a){if(!a)a=qmad.ibullets.cura;if(a.cdiv){if(a.cdiv.qmtree&&a.cdiv.style.position!="relative"){qmad.ibullets.cura=a;setTimeout("qm_ibcss_wait_relative()",10);return;}var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibullet)qm_ibullets_position(aa[i],aa[i].qmibullet);}}}/* ]]> */</script>

        <title>Waiting For</title>
    </head>
    <body>
                <!-- QuickMenu Structure [Menu 0] -->

        <ul id="qm0" class="qmmc">

                <li><a class="qmparent" href="javascript:void(0)">Context</a>

                        <ul>
                            <?php 
                                echo '<li><a href="WaitingForView.php">ALL</a></li>';
                                foreach($contextList as $ct){
                                    echo '<li><a href="WaitingForView.php?context='.$ct->getIdContexto().'">'.$ct->getNombreContexto().'</a></li>';
                                }
                            ?>
                   
                        </ul></li>

                <li><a class="qmparent" href="ReviewView.php">Review</a>

                </li>
                <li><a class="qmparent" href="javascript:void(0)">Places</a>

                        <ul>
                        <li><a href="ProcessView.php">Inbox</a></li>
                        <li><a href="ProyectoView.php">Projects</a></li>
                        <li><a href="NextActionView.php">Next Actions</a></li>
                        <li><a href="SomedayMaybeView.php">Someday/Maybe</a></li>
                        <li><a href="WaitingForView.php">Waiting For</a></li>
                        <li><a href="HistorialView.php">Historial</a></li>
                        </ul></li>

                <li><a class="qmparent" href="SettingsView.php">Settings</a>
    
                </li>

        <li class="qmclear">&nbsp;</li></ul>

        <!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click, Right to Left, Horizontal Subs, Flush Left) -->
        <script type="text/javascript">qm_create(0,false,0,250,false,false,false,false);</script>


        <!-- This script references optionally loads the QuickMenu visual interface, to run the menu stand alone remove the script.-->
        <script type="text/javascript">if (window.name=="qm_launch_visual"){document.write('<scr'+'ipt type="text/javascript" src="http://www.opencube.com/qmv4/qm_visual.js"></scr'+'ipt>')}</script>

        <div id="content">
            
           
            <img src="images/todolist.png " />
            <h1 id="logo">Getting Things Done!</h1>
            <div id="stuffBox">
                <div id="listaStuff">
                    <div id="listaTitulo">
                        <h2>Waiting For <?php echo $contextName==""? "" : " : ".$contextName; ?></h2>
<!--                        <a href="WaitingForView.php?new=1">
                            <p style=" margin-left: 4em;"><strong>+</strong></p>
                        </a>-->
                        
                    </div>
                       <ul>
                            <?php 
                            
                                    foreach ($listStuff as $st){
                                      
                                        //Solo procesar las de tipo P o nuevos proyectos
                                         if($st->getTypeStuff()=="W" || $st->getNombre()=="Nuevo Stuff"){
                                            //Solo se muestran Stuff que no hayan sido eliminadas (enviadas el historial)
                                            //Y se muestran todos si contexto es Null (Seleccionado ALL) o se muestran solo las del contexto seleccionado
                                            if($st->getIdHistorial() == NULL && (!$contextIdSelected || $st->getIdContexto() == $contextIdSelected)){
                                                //Si hay stuff seleccionada cambiamos el estilo
                                                if($stuffAssoc && $st->getIdStuff() == $stuffAssoc->getIdStuff()){
                                                    echo '<li id="itemStuff" style="background-color: steelblue;color: aliceblue; border: 3px aliceblue solid;">'.$st->getNombre()."</li>";
                                                }
                                                //Si se esta creando un nuevo Stuff y esta ese seleccionado
                                                elseif (isset($newStuff) && $st->getNombre()=="Nuevo Stuff") {
                                                     echo '<li id="itemStuff" style="background-color: steelblue;color: aliceblue; border: 3px aliceblue solid;">'.$st->getNombre()."</li>";

                                                 }
                                                 else{
                                                       echo '<a href="WaitingForView.php?idSt='.$st->getIdStuff().'">';
                                                       echo '<li id="itemStuff">'.$st->getNombre()."</li>";
                                                        echo '</a>';
                                                 }

                                            }
                                        }
                                 }
                            ?>
                        </ul>
                </div>
                
                <div id="detalleStuff">
                    <div id="detalleTitulo">
                        <h3><?php echo $stuffName?></h3>
                     
                        
                    </div>
                   
                    <form id='modifyStuff' action='WaitingForView.php' method='post' accept-charset='UTF-8'>
                        <table >
                            <tr>
                                <td>
                                    <p>Nombre:</p>
                                </td>
                                <td>
                                    <input type="text" name="stuffName" required="required" maxlength="255" value="<?php 
                                    echo ($stuffName=="Selecciona Waiting For" || $stuffName=="Nuevo Stuff")? "": $stuffName;?>" <?php echo $stuffSeleccionada? "" : 'readonly'?>>
                                </td>
                                <td colspan="2"></td>
                                <td>
                                    <p><?php echo $stuffAssoc==NULL? date($formatoFecha, time()) : date($formatoFecha,  strtotime($stuffAssoc->getFecha()));?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Descripcion:</p>
                                </td>
                                <td colspan="3">
                                    <textarea name="stuffDescription" rows="3" cols="25" maxlength="255" <?php echo $stuffSeleccionada? "" : 'readonly'?> ><?php 
                                                echo $stuffDescription;
                                              ?></textarea>
                                 </td>
                           
                            </tr>
                            <tr>
                                <td>
                                    <p>Contexto:</p>
                                </td>
                                <td colspan="3">
                                    <select type="select" name="stuffContext">
                                        <?php
                                                  echo '<option value = "" ></option>';
                                                  foreach ($contextList as $auxCont){
                                                      //Si la stuff a añadir es la que tiene asociada la stuff selecionada
                                                      if($stuffSeleccionada && $stuffAssoc && $auxCont->getIdContexto()==$stuffAssoc->getIdContexto()){
                                                            echo '<option value="'.$auxCont->getIdContexto().'" selected>';
                                                            echo $auxCont->getNombreContexto().'</option>';
                                                      }
                                                      else{
                                                          echo '<option value="'.$auxCont->getIdContexto().'">';
                                                          echo $auxCont->getNombreContexto().'</option>';
                                                      
                                                      }
                                                  }
                                        ?>
                                    </select>
                               </td>
                        
                            
                            </tr>
                            <tr>
                                <td>
                                    <p>Tags:</p>
                                </td>
                                <td >
                                    
                                    <?php
                                    echo '<input type="text" name="stuffTag" title="Separa Tags con Punto y Coma ( ; )" value="';
                                    if($tagList){
                                        foreach($tagList as $singleTag){
                                            echo $singleTag->getNombreTag().'; ';
                                        }
                                    }
                                   
//                                    echo '"';
                                    //Si no hay stuff seleccionada nada es editable
                                    echo $stuffSeleccionada? '">' : '" readonly>'
                                ?>
                                </td>
                                <td>Contacto:</td>
                                <td>
                                     <input type="text" name="contacto" maxlength="255" value="<?php 
                                    echo ($stuffSeleccionada && $contacto)? $contacto : "";?>" <?php echo $stuffSeleccionada? "" : 'readonly'?>>
                                </td>
                        </tr>
                        <tr >
                            <td>
                                <?php 
//                                   //Mostramos solo botones input si hay stuff seleccionada
//                                if($stuffSeleccionada){
//                                    echo ' <input type="submit"  name="deleteStuff" onclick="return confirm(\'Really delete?\'); value="Delete"/>';
//                                }
//                                
                                ?>
                               <input type="submit"  name="deleteStuff" onclick='return confirm("Are you sure you want to delete the selected item?");' value="Delete" <?php echo $stuffSeleccionada? "" : "disabled"?>/>
                            </td>
                            <td colspan="3">
                                <input type="hidden" name="idStuffForm" value="<?php echo isset($stuffAssoc)? $stuffAssoc->getIdStuff() : NULL;?>">
                            </td>
                            <td>
                                <?php 
                                       //Mostramos solo botones input si hay stuff seleccionada
//                                    if($stuffSeleccionada){
//                                     echo '<input type="submit"  name="saveStuff" value="Save" />';
//                                    }  
                                ?>
                               <input type="submit"  name="saveStuff" value="Save" <?php echo $stuffSeleccionada? "" : "disabled"?>/>
                            </td>
                        </tr>
                        
                        
                       </table> 
                    </form>
                </div>
            </div>
              
        </div>
      
    </body>
</html>

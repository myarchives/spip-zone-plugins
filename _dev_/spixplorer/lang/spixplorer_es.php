<?php

// Spanish Language Module for v2.3 (translated by J. Pedro Flor P.)

//$GLOBALS['spx']["charset"] = "iso-8859-1";

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'date_fmt'      => "Y/m/d H:i",
	// error
	"error"			=> "ERROR(ES)",
	"back"			=> "Ir Atr�s",
	
	// root
	"home"			=> "El directorio home no existe, revise su configuraci�n.",
	"abovehome"		=> "El directorio actual no puede estar arriba del directorio home.",
	"targetabovehome"	=> "El directorio objetivo no puede estar arriba del directorio home.",
	
	// exist
	"direxist"		=> "Este directorio no existe.",
	//"filedoesexist"	=>  "Este archivo ya existe.",
	"fileexist"		=> "Este archivo no existe.",
	"itemdoesexist"		=> "Este art�culo ya existe.",
	"itemexist"		=> "Este art�culo no existe.",
	"targetexist"		=> "El directorio objetivo no existe.",
	"targetdoesexist"	=> "El art�culo objetivo ya existe.",
	
	// open
	"opendir"		=> "Incapaz de abrir directorio.",
	"readdir"		=> "Incapaz de leer directorio.",
	
	// access
	"accessdir"		=> "Ud. no est� permitido accesar este directorio.",
	"accessfile"		=> "Ud. no est� permitido accesar a este archivo.",
	"accessitem"		=> "Ud. no est� permitido accesar a este art�culo.",
	"accessfunc"		=> "Ud. no est� permitido usar esta funcion.",
	"accesstarget"		=> "Ud. no est� permitido accesar al directorio objetivo.",
	
	// actions
	"permread"		=> "Fracaso reuniendo permisos.",
	"permchange"		=> "Fracaso en Cambio de permisos.",
	"openfile"		=> "Fracaso abriendo archivo.",
	"savefile"		=> "Fracaso guardando archivo.",
	"createfile"		=> "Fracaso creando archivo.",
	"createdir"		=> "Fracaso creando Directorio.",
	"uploadfile"		=> "Fracaso subiendo archivo.",
	"copyitem"		=> "Fracaso Copiando.",
	"moveitem"		=> "Fracaso Moviendo.",
	"delitem"		=> "Fracaso Borrando.",
	"chpass"		=> "Fracaso Cambiando password.",
	"deluser"		=> "Fracaso Removiendo usuario.",
	"adduser"		=> "Fracaso Agragando usuario.",
	"saveuser"		=> "Fracaso Guardadno usuario.",
	"searchnothing"		=> "Ud. debe suministrar algo para la busqueda.",
	
	// misc
	"miscnofunc"		=> "Funci�n no disponible.",
	"miscfilesize"		=> "Archivo excede maximo tama�o.",
	"miscfilepart"		=> "Archivo fue parcialmente subido.",
	"miscnoname"		=> "Ud. debe suministrar un nombre.",
	"miscselitems"		=> "Ud. no tiene seleccionado(s) ningun art�culo.",
	"miscdelitems"		=> "Est� seguro de querer borrar este(os) \"+num+\" art�culo(s)?",
	"miscdeluser"		=> "Est� seguro de querer borrar usuario '\"+user+\"'?",
	"miscnopassdiff"	=> "Nuevo password no difiere del actual.",
	"miscnopassmatch"	=> "No coinciden los Passwords.",
	"miscfieldmissed"	=> "Ud. fall� en un importante campo.",
	"miscnouserpass"	=> "Usuario o password incorrecto.",
	"miscselfremove"	=> "Ud. no puede borrarse a si mismo.",
	"miscuserexist"		=> "Usuario ya existe.",
	"miscnofinduser"	=> "No se puede encontrar usuario.",

	// links
	"permlink"		=> "PORMISOS CAMBIADOS",
	"editlink"		=> "EDITAR",
	"downlink"		=> "DESCARGAR",
	"uplink"		=> "ARRIBA",
	"homelink"		=> "HOME",
	"reloadlink"		=> "RECARGAR",
	"copylink"		=> "COPIAR",
	"movelink"		=> "MOVER",
	"dellink"		=> "BORRAR",
	"comprlink"		=> "ARCHIVAR",
	"adminlink"		=> "ADMINISTRAR",
	"logoutlink"		=> "SALIR",
	"uploadlink"		=> "SUBIR",
	"searchlink"		=> "B�SQUEDA",
	
	// list
	"nameheader"		=> "Nombre",
	"sizeheader"		=> "Tama�o",
	"typeheader"		=> "Tipo",
	"modifheader"		=> "Modificado",
	"permheader"		=> "Permisos",
	"actionheader"		=> "Acciones",
	"pathheader"		=> "Ruta",
	
	// buttons
	"btncancel"		=> "Cancelar",
	"btnsave"		=> "Grabar",
	"btnchange"		=> "Cambiar",
	"btnreset"		=> "Restablecer",
	"btnclose"		=> "Cerrar",
	"btncreate"		=> "Crear",
	"btnsearch"		=> "Buscar",
	"btnupload"		=> "Subir",
	"btncopy"		=> "Copiar",
	"btnmove"		=> "Mover",
	"btnlogin"		=> "Login",
	"btnlogout"		=> "Salir",
	"btnadd"		=> "A�adir",
	"btnedit"		=> "Editar",
	"btnremove"		=> "Remover",
	
	// actions
	"actdir"		=> "Directorio",
	"actperms"		=> "Cambiar permisos",
	"actedit"		=> "Editar archivo",
	"actsearchresults"	=> "Resultado de busqueda.",
	"actcopyitems"		=> "Copiar art�culos(s)",
	"actcopyfrom"		=> "Copia de /%s a /%s ",
	"actmoveitems"		=> "Mover art�culo(s)",
	"actmovefrom"		=> "Mover de /%s a /%s ",
	"actlogin"		=> "Login",
	"actloginheader"	=> "Login para usar QuiXplorer",
	"actadmin"		=> "Administraci�n",
	"actchpwd"		=> "Cambiar password",
	"actusers"		=> "Usuarios",
	"actarchive"		=> "Archivar item(s)",
	"actupload"		=> "Subir Archivo(s)",
	
	// misc
	"miscitems"		=> "Art�culo(s)",
	"miscfree"		=> "Libre",
	"miscusername"		=> "Nombre de usuario",
	"miscpassword"		=> "Password",
	"miscoldpass"		=> "Password Antiguo",
	"miscnewpass"		=> "Password Nuevo",
	"miscconfpass"		=> "Confirmar password",
	"miscconfnewpass"	=> "Confirmar nuevo password",
	"miscchpass"		=> "Cambiar password",
	"mischomedir"		=> "Directorio Home",
	"mischomeurl"		=> "URL Home",
	"miscshowhidden"	=> "Mostrar art�culos ocultos",
	"mischidepattern"	=> "Ocultar patr�n",
	"miscperms"		=> "Permisos",
	"miscuseritems"		=> "(nombre, directorio home, mostrar art�culos ocultos, permisos, activar)",
	"miscadduser"		=> "a�adir usuario",
	"miscedituser"		=> "editar usario '%s'",
	"miscactive"		=> "Activar",
	"misclang"		=> "Lenguaje",
	"miscnoresult"		=> "Resultado(s) no disponible(s).",
	"miscsubdirs"		=> "B�squeda de subdirectorios",
	"miscpermnames"		=>
		"Solo ver/Modificar/Cambiar password/Modificar & Cambiar password/Administrador",
	"miscyesno"		=> "Si/No/S/N",
	"miscchmod"		=> "Propietario/Grupo/P�blico"
);
?>

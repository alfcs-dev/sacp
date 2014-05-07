<?php /***************FUNCIONES PARA DETECTAR CONEXIONES Y ROLES DE USUARIO**************/
function logged_in(){
return (isset($_SESSION['id'])) ? true : false;
}

function esadmin(){
return (isset($_SESSION['rol'])) ? true : false;
}

function acceso_protegido(){
	if(!logged_in()){
	header('Location: http://alfcastaneda.com/sacp/acceso.php');
	exit();
	}
}
function redireccion_conectado(){
	if(logged_in()){
	header('Location: http://alfcastaneda.com/sacp/index.php');
	exit();
	}
}

function acceso_admin(){
	if(!esadmin()){
		header('Location: http://alfcastaneda.com/sacp/acceso.php');
		exit();
	}
}
/*****************************FIN FUNCIONES CONEXION*****************************************************************/

/*****************************FUNCIONES GENERALES PARA TRABAJAR CON DATOS *******************************************/
function sanitize($data) {
	global $mysqli;
return $mysqli -> real_escape_string($data);
}

function array_sanitize(&$item){
	global $mysqli;
	$item = $mysqli -> real_escape_string($item);
}

function email($para, $asunto, $mensaje){
$headers = array(
	'From: no-responder@alfcastaneda.com',
	'Content-Type: text/html;  charset=utf-8'

); 
	if(mail($para, $asunto, $mensaje, implode("\r\n",  $headers))){
	return true;
	}else{return false;}
}

?>
<?php 
/************************INICIO DE SESION***************************/
ob_start();
session_start();
date_default_timezone_set('America/Mexico_City');
/****************************INCLUDES*****************************/
require_once('configdb.php');  //conexión a la base de datos;
include_once('funciones/generales.php'); //incluye funciones generales como checar si un usuario esta conectado, sanitizar datos para la db
include_once('funciones/usuarios.php');  //contiene las funciones para usuarios, dar de alta, iniciar sesión etc...
include_once('funciones/sistema.php');  //contiene las funciones para trabajar con todas las opciones del sistema que no sean usuarios

/************************Si el usuario esta conectado obtenemos sus datos para tenerlos disponibles*************************************/
if(logged_in()){
	$sesion_usuario = $_SESSION['id'];
	$datos_usuario = datos_usuario($_SESSION['id']);
	$datos_usuario['a_paterno'] = utf8_encode($datos_usuario['a_paterno']);
		if(usuario_activo($datos_usuario['email']) === false) {
		session_destroy();
		header('Location: index.php');
		exit();
	} 
}


?>
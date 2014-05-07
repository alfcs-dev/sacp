<?php 
function activar($email, $codigo){
	global $mysqli;
	$email  = sanitize($email);
	$codigo	= sanitize($codigo);
	if($resultado = $mysqli -> query("SELECT count(id) FROM empleados WHERE email = '$email' AND codigo_correo = '$codigo' AND active = 0")){
	$resultado -> data_seek(0);
	$valor = $resultado -> fetch_row();
		if($valor[0] == 1){
			$mysqli -> query("UPDATE empleados SET active = 1 WHERE email = '$email'");
			return true;
		} 
		else{
			return false;
		}
	}
	$resultado -> close();
}
	

function existe_usuario($email){ //Creamos una funcion que realiza la busqueda de un usuario por el correo-e enviado
	$email = sanitize($email);
	$query = "SELECT COUNT(id) from empleados WHERE email = '$email'";
	global $mysqli;
	if($resultado= $mysqli -> query($query)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
		}
		$resultado->close();
}

function usuario_activo($email){//Si el usuario existe, verificamos que la cuenta ya este activa
	$email = sanitize($email);
	$query = "SELECT COUNT(id) from empleados WHERE email = '$email' AND active = 1";
	global $mysqli;
	if($resultado= $mysqli -> query($query)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
	}
	$resultado->close();
}

function login($email, $password){ //Verificamos datos correctos de email y contraseña
	$email = sanitize($email);
	$password = md5($password);
	$query_sesion = "SELECT id, rol FROM empleados WHERE email = '$email' AND password = '$password'";
	global $mysqli;
	if($resultado= $mysqli -> query($query_sesion)){
		$valor = $resultado -> fetch_assoc();
		return $valor;	
	}
	$resultado->close();
}

function datos_usuario($id){ //Vamos a regresar un arreglo con los datos solicitados del usuario,
	$datos = array();		 //esto para tener un acceso mas rapido a esta informacion en cualquier parte del codigo
	$id = (int)$id;
	$query_datos = "SELECT id, nombre, a_paterno, password, email, rol, es_instructor 
					FROM empleados 
					WHERE id = $id"; 
	global $mysqli;
	if($resultado = $mysqli -> query($query_datos)){
		$data = $resultado -> fetch_assoc();
		return $data;	
	}
	$resultado->close();
}

function registra_usuario($datos_registro){
	array_walk($datos_registro, 'array_sanitize');
	$pwd_mail = $datos_registro['password'];
	$datos_registro['password'] = MD5($datos_registro['password']);
	$campos = ''.implode(', ', array_keys($datos_registro)).'';
	$data	= '\''.implode('\', \'', $datos_registro). '\'';
	$query = "INSERT INTO empleados ($campos) VALUES ($data)";
 	global $mysqli;
	$mysqli -> query($query);
		$mensaje = "<h3>Buen día ".$datos_registro['nombre']."</h3>
		<p>Bienvienido al Sistema de administración de la capacitación,
		Has sido dado de alta con los siguientes datos: </p>
		<p>Usuario: ".$datos_registro['email']."</p>
		<p>Contraseña: ".$pwd_mail."</p>
		<p>En este momento tu cuenta se encuentra inactiva\n
		Para activar tu cuenta da click en el siguiente link o copia la dirección en tu explorador:</p>
		<p>http://alfcastaneda.com/sacp/activar.php?email=".$datos_registro['email']."&codigo_correo=".$datos_registro['codigo_correo']."</p>
		
		<p>Atentamente:</p>
		<p>La Empresa</p>";
	
	if(email($datos_registro['email'], 'Activar cuenta', $mensaje)){
		return "Se envio correo";
	}
	
	else{
		return "No se envio correo";
	}
 
}

function borra_usuario($email){
	global $mysqli;
	$email = sanitize($email);
	$query = "DELETE FROM empleados WHERE email =  '$email'";
	if($result = $mysqli -> query($query)){
		return true;
	}
	else{
		return false;
	}
}

function actualiza_usuario($datos_registro){
	array_walk($datos_registro, 'array_sanitize');
	$pwd_mail = $datos_registro['password'];
	$query = "UPDATE empleados 
			  SET a_paterno= '".$datos_registro['a_paterno']."', a_materno= '".$datos_registro['a_materno']."', nombre= '".$datos_registro['nombre']."', 
			  email = '".$datos_registro['email']."', password = '".md5($datos_registro['password'])."', 
			codigo_correo = '".$datos_registro['codigo_correo']."', fecha_ingreso = '".$datos_registro['fecha_ingreso']."', rol = ".$datos_registro['rol'].",
			es_instructor = ".$datos_registro['es_instructor'].", id_puesto = ".$datos_registro['id_puesto']."			
			WHERE id = ".$datos_registro['id'];
	global $mysqli;
 	$mysqli -> query($query);
	$mensaje = "<h3>Buen día ".$datos_registro['nombre']."</h3>
	<p>El administrador del Sistema de administración de la capacitación a modificado tu cuenta en el sistema,</p>
	<p>Por seguridad al realizar el cambio se modifican tus accesos por los siguentes: </p>
	<p>Usuario:".$datos_registro['email']."</p>
	<p>Contraseña:".$pwd_mail."</p>
	<p>Es necesario que reactives tu cuenta dando click en el siguiente enlace o copiandolo en tu explorador\n\n
	http://alfcastaneda.com/sacp/activar.php?email=".$datos_registro['email']."&codigo_correo=".$datos_registro['codigo_correo']."</p>
	
	<p>Atentamente:</p>
	<p>La Empresa</p>";
	email($datos_registro['email'], 'Reactivar cuenta', $mensaje);
}

?>
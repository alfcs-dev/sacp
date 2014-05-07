<?php
/*************************************FUNCIONES ENCUESTAS**************************************/
function guarda_encuesta($datos_encuesta){
	global $mysqli;
	array_walk($datos_encuesta, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_encuesta)).'';
	$data	= '\''.implode('\', \'', $datos_encuesta). '\'';
	$query = "INSERT INTO eval_capacitacion ($campos) VALUES ($data)";
	if($mysqli -> query($query)){
		return true;
	}
	else{
		return false;
	}
	
}

function evalua_instructor($datos_evaluacion, $id_empleado, $id_capacitacion){
	global $mysqli;
	array_walk($datos_evaluacion, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_evaluacion)).'';
	$query = "UPDATE asig_capacitacion SET calif_instruc_explicacion = ".$datos_evaluacion['calif_instruc_explicacion'].", 
			  calif_instruc_rel = ".$datos_evaluacion['calif_instruc_rel'].", calif_instruc_dom = ".$datos_evaluacion['calif_instruc_dom'].",  
			  contesto_encuesta = 1 WHERE empleados_id = $id_empleado AND prog_capacitacion_id = $id_capacitacion";
	if($mysqli -> query($query)){
		return true;
	}
	else {
		return false;
	}
}
/**********************************FIN FUNCIONES ENCUESTAS**************************************/

/*************************************FUNCIONES CURSOS**************************************/
function curso_existe($curso, $modalidad){
	global $mysqli;
	$sql = "SELECT count(c.id) FROM cursos c WHERE c.nom_curso = '$curso' AND modalidad_id = $modalidad";
	if($resultado = $mysqli -> query($sql)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
	}
	
}

function crea_curso($datos_curso){
	global $mysqli;
	array_walk($datos_curso, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_curso)).'';
	$data	= '\''.implode('\', \'', $datos_curso). '\'';
	$query = "INSERT INTO cursos ($campos) VALUES ($data)";
	$mysqli -> query($query);
}

function borra_curso($nombre){
	global $mysqli;
	$sql = "DELETE FROM cursos WHERE nom_curso = '$nombre'";
	if($resultado = $mysqli -> query($sql)){
		return true ;	
	}
	else{
		return false;
	}
}

function actualiza_curso($datos_curso){
	global $mysqli;
	$sql = "UPDATE cursos SET nom_curso ='".$datos_curso['nom_curso']."' ,duracion = '".$datos_curso['duracion']."' ,modalidad_id = '".$datos_curso['modalidad_id']."' WHERE id = ".$datos_curso['id'];
	$resultado = $mysqli -> query($sql);
}
/*****************************************FIN CURSOS***********************************************/
/*************************************FUNCIONES SALAS**************************************/
function sala_existe($sala, $sucursal){
	global $mysqli;
	$sql = "SELECT count(s.id) FROM salas s WHERE s.sala = '$sala' AND regionales_id = $sucursal";
	if($resultado = $mysqli -> query($sql)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
	}
	
}

function crea_sala($datos_curso){
	global $mysqli;
	array_walk($datos_curso, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_curso)).'';
	$data	= '\''.implode('\', \'', $datos_curso). '\'';
	$query = "INSERT INTO salas ($campos) VALUES ($data)";
	$mysqli -> query($query);
	return $query;
}

function borra_sala($nombre){
	global $mysqli;
	$sql = "DELETE FROM salas WHERE sala = '$nombre'";
	if($resultado = $mysqli -> query($sql)){
		return true ;	
	}
	else{
		return false;
	}
}

function actualiza_sala($datos_sala){
	global $mysqli;
	$sql = "UPDATE salas SET sala ='".$datos_sala['sala']."' ,
			capacidad = '".$datos_sala['capacidad']."' ,
			proyector = '".$datos_sala['proyector']."' ,
			pizarra = '".$datos_sala['pizarra']."' ,
			pantalla_proyec = '".$datos_sala['pantalla_proyec']."' ,
			equipo_video = '".$datos_sala['equipo_video']."' ,
			observaciones = '".$datos_sala['observaciones']."' ,
			regionales_id = '".$datos_sala['regionales_id']."' 
			WHERE id = ".$datos_sala['id'];
	
	$resultado = $mysqli -> query($sql);
}
/*****************************************FIN SALAS***********************************************/

/*****************************************FUNCIONES SUCURSALES***********************************************/
function sucursal_existe($sucursal, $estado){
	global $mysqli;
	$sql = "SELECT count(s.id) FROM regionales s WHERE s.descripcion = '$sucursal' AND estado_id = $estado";
	if($resultado = $mysqli -> query($sql)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
	}
}

function crea_sucursal($datos_sucursal){
	global $mysqli;
	array_walk($datos_sucursal, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_sucursal)).'';
	$data	= '\''.implode('\', \'', $datos_sucursal). '\'';
	$query = "INSERT INTO regionales ($campos) VALUES ($data)";
	$mysqli -> query($query);
	//return $query;
}

function borra_sucursal($nombre, $estado){
	global $mysqli;
	$sql = "DELETE FROM regionales WHERE descripcion = '$nombre' AND estado_id = $estado";
	if($resultado = $mysqli -> query($sql)){
		return true ;	
	}
	else{
		return false;
	}
}

function actualiza_sucursal($datos_sucursal){
	global $mysqli;
	$sql = "UPDATE regionales SET descripcion ='".$datos_sucursal['descripcion']."' ,
			dif_horario = '".$datos_sucursal['dif_horario']."' ,
			cve_region = '".$datos_sucursal['cve_region']."', 
			estado_id = '".$datos_sucursal['estado_id']."' 
			WHERE id = ".$datos_sucursal['id'];
	
	$resultado = $mysqli -> query($sql);
	//return $sql;
}
/********************************FIN FUNCIONES SUCURSALES*******************************************************/
/*********************************FUNCIONES PARA PROGRAMAR CAPACITACIONES ************************************/
function capacitacion_existe($curso, $fecha, $horario, $sala){
	$query = "SELECT count(id) FROM prog_capacitacion WHERE curso_id= $curso AND fecha_inicio = '$fecha' AND horario = '$horario' AND sala_id = $sala";
	global $mysqli;
	if($resultado = $mysqli -> query($query)){
		$resultado -> data_seek(0);
		$valor = $resultado -> fetch_row();
		return ($valor[0] == 1) ? true : false ;	
	}	
}

function programa_capacitacion($datos_capacitacion){
	array_walk($datos_capacitacion, 'array_sanitize');
	$campos = ''.implode(', ', array_keys($datos_capacitacion)).'';
	$data	= '\''.implode('\', \'', $datos_capacitacion). '\'';
	$query = "INSERT INTO prog_capacitacion ($campos) VALUES ($data)";
	global $mysqli;
	$mysqli -> query($query);
	$id_capacitacion = $mysqli->insert_id;
	return $id_capacitacion;
}
/********************************FIN FUNCIONES PARA PROGRAMAR CAPACITACIONES *******************************************************/
/***********Inscripciones:************/
function inscribe_empleados($capacitacion, $empleado){
	global $mysqli;
	$query = "INSERT INTO asig_capacitacion(prog_capacitacion_id, empleados_id) VALUES ($capacitacion, $empleado)";
	if($resultado = $mysqli -> query($query)){
		$empleado =	"SELECT * FROM info_mail WHERE  id= $empleado AND id_capacitacion = $capacitacion";
		$r_empleado = $mysqli -> query($empleado);
		$info_mensaje = $r_empleado -> fetch_assoc();
		$mensaje = "<h3>Buen día ".$info_mensaje['nombre']."</h3>
				<p>Por este medio se te notifica que has quedado inscrito en el curso: </p><p>".$info_mensaje['nom_curso']."</p>
				<p>Que tiene una duración de:".$info_mensaje['duracion']."hrs. </p>
				<p>Y que dara inicio el dia: ".$info_mensaje['fecha_inicio']." en la sala: ".$info_mensaje['sala']." de la sucursal: ".$info_mensaje['oficina']."</p>";
		if(email($info_mensaje['email'], 'Inscripción al curso '.$info_mensaje['nom_curso'], $mensaje)){
			return $info_mensaje['email']; 
		} else{
			return false;
		}
	}
	else { 
		return false;
	} 
	
}

function pasa_lista($empleado, $capacitacion){
	global $mysqli;
	$fecha 		= date('Y-m-d');
	$query1 	= "SELECT * FROM asistencia WHERE id_empleado = $empleado AND id_capacitacion = $capacitacion AND fecha = '$fecha'";
	$validacion = $mysqli -> query($query1);
		if($validacion -> num_rows == 0){
			$query2 = "INSERT INTO asistencia(fecha, id_capacitacion, id_empleado) VALUES ('$fecha',$capacitacion, $empleado)";
			if($resultado = $mysqli -> query($query2)){
				return true;
			}
			else{
			return false;
			}
		}
		else{
			return false;
		}
}

/*************************************/

?>
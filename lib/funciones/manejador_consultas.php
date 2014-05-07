<?php 
include_once('../configdb.php');

if(isset($_POST['select_regional'])){
	$select_regional= $_POST['select_regional'];
	$query = "SELECT * FROM salas WHERE regionales_id = '$select_regional'";
	global $mysqli;
	$resultado = $mysqli->query($query);
	
       while($fila = $resultado -> fetch_assoc()){
			$id_sala = $fila['id'];
			$sala = $fila['sala'];
			$capacidad = $fila['capacidad'];
			$proyeccion = $fila['pantalla_proyec'];
			$videoconferencia = $fila['equipo_video'];
			$pizarron = $fila['pizarra'];
			$canon = $fila['proyector'];
			$observaciones = $fila['observaciones'];
			$filas .= "<tr><td><a href='javascript:selecciona_sala(\"$id_sala\",\"$sala\", \"$select_regional\", \"$capacidad\" , \"$videoconferencia\", \"$canon\" ,\"$proyeccion\", \"$pizarron\", \"$observaciones\");'>".$fila['sala']."</a></td>";
			$filas .= "<td>".$fila['capacidad']."</td></tr>";
		}

		echo json_encode($filas);
	
}

elseif(isset($_POST['suc_capacitacion'])){
	$suc_capacitacion = $_POST['suc_capacitacion'];
	$query = "SELECT * FROM salas WHERE regionales_id = '$suc_capacitacion'";
	global $mysqli;
	$resultado = $mysqli->query($query);
	$options = '<option value="0" selected="selected">Selecciona la sala</option>';
       while($fila = $resultado -> fetch_assoc()){
		    $options .= '<option value="'. $fila['id'] .'">'. $fila['sala'] .'</option>';
		}
		$arreglo['opciones'] = $options;
		echo json_encode($arreglo);
}

elseif(isset($_POST['carac_salas'])){
	$id_sala=$_POST['carac_salas'];
	$query = "SELECT * FROM salas WHERE id= $id_sala";
	global $mysqli;
	$resultado = $mysqli -> query($query);
		while($filas = $resultado -> fetch_assoc()){
			$caracteristicas .="<tr><td>Proyector</td>";
				if($filas['proyector'] == 1){
					$caracteristicas .= "<td><span class='glyphicon glyphicon-ok'></span></td></tr>";
					}
				else{ $caracteristicas .= "<td><span class='glyphicon glyphicon-remove '></span></td></tr>";	}
			$caracteristicas .= "<tr><td>Pizarron</td>";
				if($filas['pizarra'] == 1){
					$caracteristicas .= "<td><span class='glyphicon glyphicon-ok'></span></td></tr>";
					}
				else{ $caracteristicas .= "<td><span class='glyphicon glyphicon-remove'></span></td></tr>";	}
			$caracteristicas .= "<tr><td>Videoconferencia</td>";
				if($filas['equipo_video'] == 1){
					$caracteristicas .= "<td><span class='glyphicon glyphicon-ok'></span></td></tr>";
					}
				else{ $caracteristicas .= "<td><span class='glyphicon glyphicon-remove'></span></td></tr>";	}
			$caracteristicas .= "<tr><td>Pantalla de proyección</td>";
				if($filas['pantalla_proyec'] == 1){
					$caracteristicas .= "<td><span class='glyphicon glyphicon-ok'></span></td></tr>";
					}
				else{ $caracteristicas .= "<td><span class='glyphicon glyphicon-remove'></span></td></tr>";	}
			$caracteristicas .= "<tr><td>Capacidad</td><td>".$filas['capacidad']."</td></tr>";
		
		}
	echo json_encode($caracteristicas);
}

elseif(isset($_POST['curso_a_programar'])){
$id_curso = $_POST['curso_a_programar'];
$query = "SELECT * FROM cursos c, modalidad m WHERE c.id = '$id_curso' AND m.id = c.modalidad_id";
global $mysqli;
$resultado = $mysqli -> query($query);
	while($fila = $resultado -> fetch_assoc()){ 
		$curso_programar .= "<tr><td>".$fila['nom_curso']."</td><td>".$fila['duracion']."</td><td>".$fila['nom_modalidad']."</td></tr>";
	}
echo json_encode($curso_programar);
}


elseif(isset($_POST['capacitacion_a_asignar'])){
$id_capacitacion_a_asignar = $_POST['capacitacion_a_asignar'];
$query = "SELECT pc.id, c.nom_curso, CONCAT(e.a_paterno,' ' ,e.nombre) as instructor, 
					DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y' ) as fecha_inicio,  
					DATE_FORMAT(pc.fecha_final, '%d-%m-%Y' ) as fecha_final, 
					pc.asistencia_minima, pc.calificacion_minima, salas.sala,
					salas.capacidad, r.descripcion,
					count(inscritos.id_empleado) as no_inscritos
					FROM alfcasta_tesis.prog_capacitacion pc
					JOIN cursos c ON pc.curso_id = c.id
					JOIN empleados e ON pc.instructor_id = e.id
					JOIN  salas salas ON salas.id = pc.sala_id
					JOIN regionales r ON  r.id = salas.regionales_id 
					JOIN inscritos ON inscritos.id_capacitacion_programada = pc.id
					WHERE pc.id =$id_capacitacion_a_asignar ";
global $mysqli;
$resultado = $mysqli -> query($query);
	while($fila = $resultado -> fetch_assoc()){ 
	$cupo = $fila['capacidad']-$fila['no_inscritos'];
	$capacitacion_a_asignar .= "<tr><td><strong>Nombre del curso</strong></td><td>".$fila['nom_curso']."</td></tr>
								<tr><td><strong>Instructor</strong></td><td>".utf8_encode($fila['instructor'])."</td></tr>
								<tr><td><strong>Fecha de inicio</strong></td><td>".$fila['fecha_inicio']."</td></tr>
								<tr><td><strong>Fecha de termino</strong></td><td>".$fila['fecha_final']."</td></tr>
								<tr><td><strong>% Asistencia</strong></td><td>".$fila['asistencia_minima']."</td></tr>
								<tr><td><strong>Calif. Mínima</strong></td><td>".$fila['calificacion_minima']."</td></tr>
								<tr><td><strong>Sucursal</strong></td><td>".$fila['descripcion']."</td></tr>
								<tr><td><strong>Sala</strong></td><td>".$fila['sala']."</td></tr>
								<tr><td><strong>Cupo</strong></td><td id='cupo'>".$cupo."</td></tr>";
	}
	$query2 = "SELECT i.id_empleado, e.a_paterno, e.a_materno, e.nombre, e.email, p.puesto 
						FROM inscritos i 
						JOIN empleados e ON e.id = i.id_empleado
						JOIN puesto p ON p.id = e.id_puesto
						WHERE i.id_capacitacion_programada = $id_capacitacion_a_asignar ";
	if($resultado2 = $mysqli -> query($query2)){
		if($resultado2 -> num_rows > 0){
			while($fila = $resultado2 -> fetch_assoc()){
			$filas .= "<tr><td>".$fila['id_empleado']."</td>";
						$filas .= "<td>".utf8_encode($fila['a_paterno'])." ".utf8_encode($fila['a_materno'])." ".utf8_encode($fila['nombre'])."</td>";
						$filas .= "<td>".$fila['puesto']."</td></tr>";
			}
		}else{$filas = "<tr><td>No Existen empleados inscritos a este curso</td></tr>";}
	}
	
	$capacitacion['datos_capacitacion'] = $capacitacion_a_asignar;
	$capacitacion['emp_inscritos'] = $filas;
echo json_encode($capacitacion);

}

/*******BUSCA DATOS DE INSCRITOS*****************/
	elseif(isset($_POST['cursos_inscrito'])){
	$respuesta = array();
	$inscrito = $_POST['cursos_inscrito'];
	$query = "SELECT * FROM inscritos WHERE id_empleado = $inscrito AND inicio >= NOW()";
		if($resultado = $mysqli -> query($query)){
		$filas = "<tr><th>Capacitación</th><th>Fecha Inicio</th><th>Fecha Final</th><th>Baja</th></tr>";
			while($fila = $resultado -> fetch_assoc()){
				$filas .= "<tr><td>".$fila['curso']."</td>";
				$filas .= "<td>".$fila['inicio']."</td>";
				$filas .= "<td>".$fila['final']."</td>";
				$filas .= "<td><a href='javascript:baja_capacitacion(".$fila['id_empleado'].",".$fila['id_capacitacion_programada'].")'>Dar de baja</a></td></tr>";
				$cap_inscrito[] = $fila["id_capacitacion_programada"];
			}
			$respuesta['tabla'] = $filas;
			if(isset($cap_inscrito)){
			$caps = implode(',', $cap_inscrito);
			}
			if(empty($caps)){
				$caps = 0;
			}
			$query_ins = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final, pc.horario, m.nom_modalidad,  r.cve_region, s.sala, s.capacidad
							FROM prog_capacitacion pc 
							JOIN cursos c ON pc.curso_id = c.id
							JOIN modalidad m ON m.id = c.modalidad_id
							JOIN salas s ON s.id = pc.sala_id
							JOIN regionales r ON r.id = s.regionales_id
							WHERE (pc.id NOT IN ($caps)) AND fecha_inicio >= NOW();";
				if($insc = $mysqli -> query($query_ins)){
					$cap_disponibles_emp = "<tr class='active'>
												<th></th>
												<th>Capacitacion</th>
												<th>Fecha de inicio</th>
												<th>Fecha de terminación</th>
												<th>Horario</th>
												<th>Modalidad</th>
												<th>Sucursal</th>
												<th>Sala</th>
												<th>Cupo</th>
											</tr>";
					while($row = $insc -> fetch_assoc()){
						$busca_inscritos = "SELECT count(id_empleado) FROM inscritos WHERE id_capacitacion_programada = '".$row['id']."'";
						$resultado = $mysqli -> query($busca_inscritos);
						$resultado -> data_seek(0);
						$valor = $resultado -> fetch_row();
						$cupo = $row['capacidad']-$valor[0];
						if($cupo > 0){
							$cap_disponibles_emp .= "<tr>
													<td><input type='checkbox' name='id_cap[]' value='".$row['id']."'></input></td>
													<td>".$row['nom_curso']."</td>
													<td>".$row['fecha_inicio']."</td>
													<td>".$row['fecha_final']."</td>
													<td>".$row['horario']."</td>
													<td>".$row['nom_modalidad']."</td>
													<td>".$row['cve_region']."</td>
													<td>".$row['sala']."</td>
													<td>".$cupo."<input type='hidden' value='".$cupo."' id='cupo[]'></input></td>
												</tr>";
						}
						else{
							$cap_disponibles_emp .= "";
						}
					}
					$respuesta['caps'] = $cap_disponibles_emp;
				} 
			echo json_encode($respuesta);
		}
	else{echo json_encode("No existen registros");}
	}	

	elseif(isset($_POST['id_emp_baja']) && isset($_POST['id_cap_prog_baja'])){
		$id_emp = $_POST['id_emp_baja'];
		$id_cap = $_POST['id_cap_prog_baja'];
		$query = "DELETE FROM asig_capacitacion WHERE empleados_id = $id_emp AND prog_capacitacion_id = $id_cap";
			if($result = $mysqli -> query($query)){
				$query2 = "SELECT * FROM inscritos WHERE id_empleado = $id_emp AND inicio >= NOW()";
				if($resultado = $mysqli -> query($query2)){
					$filas = "<tr><th>Capacitación</th><th>Fecha Inicio</th><th>Fecha Final</th><th>Baja</th></tr>";
						while($fila = $resultado -> fetch_assoc()){
							$filas .= "<tr><td>".$fila['curso']."</td>";
							$filas .= "<td>".$fila['inicio']."</td>";
							$filas .= "<td>".$fila['final']."</td>";
							$filas .= "<td><a href='javascript:baja_capacitacion(".$fila['id_empleado'].",".$fila['id_capacitacion_programada'].")'>Dar de baja</a></td></tr>";
						}
						echo json_encode($filas);
				}
				
			}
	}

/************FIN DATOS INSCRITOS************/
/************CALIFICACIONES PREVIAS************/
	elseif(isset($_POST['calif_previa'])){
		$calif_previa = $_POST['calif_previa'];
		$consulta = "SELECT e.id, e.nombre, e.a_paterno, e.a_materno, ac.calif_alum_prev, ac.calif_aplicacion_alum_prev FROM asig_capacitacion ac
				  JOIN empleados e ON ac.empleados_id = e.id
				  WHERE ac.prog_capacitacion_id = $calif_previa";
		if($valores = $mysqli -> query($consulta)){
			while($fila = $valores -> fetch_assoc()){
				$filas .= "<tr><td><input type='hidden' name='id[]' value='".$fila['id']."'/></input>".$fila['id']."</td>";
				$filas .= "<td>".$fila['a_paterno']." ".$fila['a_materno']." ".$fila['nombre']."</td>";
				$filas .= "<td><div class='form-group'><input class='form-control' style='width:25%' type='text' name='calif_alum_prev[]' value='".$fila['calif_alum_prev']."'></input></div></td>";
				$filas .= "<td><div class='form-group'><input class='form-control' style='width:25%' type='text'  name='calif_aplicacion_alum_prev[]' value='".$fila['calif_aplicacion_alum_prev']."'></input></div></td></tr>";
			}
			$filas = utf8_encode($filas);
			echo json_encode($filas);
		}
	else{$filas ="No se pudo ejecutar la consulta";}
		
	}
	/************FIN CALIFICACIONES PREVIAS************/
	/************CALIFICACIONES************/
	elseif(isset($_POST['calificaciones'])){
		$calificaciones = $_POST['calificaciones'];
		$consulta = "SELECT e.id, e.nombre, e.a_paterno, e.a_materno, ac.calif_alum_post, ac.calif_aplicacion_alum_post FROM asig_capacitacion ac
				  JOIN empleados e ON ac.empleados_id = e.id
				  WHERE ac.prog_capacitacion_id = $calificaciones";
		if($valores = $mysqli -> query($consulta)){
			while($fila = $valores -> fetch_assoc()){
				$filas .= "<tr><td><input type='hidden' name='id[]' value='".$fila['id']."'/></input>".$fila['id']."</td>";
				$filas .= "<td>".$fila['a_paterno']." ".$fila['a_materno']." ".$fila['nombre']."</td>";
				$filas .= "<td><div class='form-group'><input class='form-control' style='width:25%' type='text' name='calif_alum_post[]' value='".$fila['calif_alum_post']."'></input></div></td>";
				$filas .= "<td><div class='form-group'><input class='form-control' style='width:25%' type='text'  name='calif_aplicacion_alum_post[]' value='".$fila['calif_aplicacion_alum_post']."'></input></div></td></tr>";
			}
			$filas = utf8_encode($filas);
			echo json_encode($filas);
		}
	else{$filas ="No se pudo ejecutar la consulta";}
		
	}
	/*******************REPORTES***********************/
	elseif(isset($_POST['fecha_inicio_reporte']) && isset($_POST['fecha_final_reporte'])){
		$fecha_inicio_reporte = $_POST['fecha_inicio_reporte'];
		$fecha_final_reporte = $_POST['fecha_final_reporte'];
		$promedios = $_POST['promedios'];
			if($promedios == 0){
			$tabla = "<tr class='success'><th>Curso</th><th>Modalidad</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Instructor</th><th>Sucursal</th></tr>";
			$sql = "SELECT c.nom_curso, m.nom_modalidad, DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(pc.fecha_final, '%d-%m-%Y') as fecha_final, CONCAT(e.nombre, ' ', e.a_paterno) as instructor, r.cve_region 
					FROM prog_capacitacion pc 
					JOIN cursos c ON c.id = pc.curso_id 
					JOIN modalidad m ON m.id = c.modalidad_id 
					JOIN salas s ON s.id = pc.sala_id 
					JOIN empleados e ON e.id = pc.instructor_id 
					JOIN regionales r ON r.id = s.regionales_id 
					WHERE pc.fecha_inicio BETWEEN '$fecha_inicio_reporte' AND '$fecha_final_reporte' ORDER BY pc.fecha_inicio ASC ";
					$resultado = $mysqli -> query($sql);
					if($resultado -> num_rows > 0){
						while($contenido_tabla = $resultado -> fetch_assoc()){
							$tabla .= "<tr><td>".$contenido_tabla['nom_curso']."</td>";
							$tabla .= "<td>".$contenido_tabla['nom_modalidad']."</td>";
							$tabla .= "<td>".$contenido_tabla['fecha_inicio']."</td>";
							$tabla .= "<td>".$contenido_tabla['fecha_final']."</td>";
							$tabla .= "<td>".utf8_encode($contenido_tabla['instructor'])."</td>";
							$tabla .= "<td>".$contenido_tabla['cve_region']."</td></tr>";
						}
					}
					else{ $tabla = "No existen cursos durante el periodo seleccionado";}
			}
			else{
				$tabla = "<tr class='success'><th>Curso</th><th>Modalidad</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Instructor</th><th>Sucursal</th><th>Promedio Teórico</th><th>Promedio Aplicación</th></tr>";
				$sql = "SELECT c.nom_curso, m.nom_modalidad, DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(pc.fecha_final, '%d-%m-%Y') as fecha_final, 
						CONCAT(e.nombre, ' ', e.a_paterno) as instructor, r.cve_region, ac_te.promedio_teorico, ac_ap.promedio_aplicacion
						FROM prog_capacitacion pc
						JOIN cursos c ON c.id = pc.curso_id 
						JOIN modalidad m ON m.id = c.modalidad_id 
						JOIN salas s ON s.id = pc.sala_id 
						JOIN empleados e ON e.id = pc.instructor_id 
						JOIN regionales r ON r.id = s.regionales_id
						LEFT JOIN (SELECT prog_capacitacion_id, AVG(calif_alum_post) as promedio_teorico FROM asig_capacitacion GROUP BY prog_capacitacion_id) ac_te ON ac_te.prog_capacitacion_id = pc.id 
						LEFT JOIN (SELECT prog_capacitacion_id, AVG(calif_aplicacion_alum_post) as promedio_aplicacion FROM asig_capacitacion GROUP BY prog_capacitacion_id) ac_ap ON ac_ap.prog_capacitacion_id = pc.id 
						WHERE pc.fecha_inicio BETWEEN '$fecha_inicio_reporte' AND '$fecha_final_reporte' ORDER BY pc.fecha_inicio ASC";
				$resultado = $mysqli -> query($sql);
				if($resultado -> num_rows > 0){
					while($contenido_tabla = $resultado -> fetch_assoc()){
						$tabla .= "<tr><td>".$contenido_tabla['nom_curso']."</td>";
						$tabla .= "<td>".$contenido_tabla['nom_modalidad']."</td>";
						$tabla .= "<td>".$contenido_tabla['fecha_inicio']."</td>";
						$tabla .= "<td>".$contenido_tabla['fecha_final']."</td>";
						$tabla .= "<td>".utf8_encode($contenido_tabla['instructor'])."</td>";
						$tabla .= "<td>".$contenido_tabla['cve_region']."</td>";
						$tabla .= "<td>".round($contenido_tabla['promedio_teorico'], 2)."</td>";
						$tabla .= "<td>".round($contenido_tabla['promedio_aplicacion'], 2)."</td></tr>";
					}
				}
				else{ $tabla = "No existen cursos durante el periodo seleccionado";}
			}
		
		
		
		echo json_encode($tabla);
	}

		/*******************REPORTES***********************/
	elseif(isset($_POST['hist_calif_emp'])){
		$emp = $_POST['hist_calif_emp'];
		$tabla = "<tr>
				<th>Curso</th>
				<th>Fecha Inicio</th>
				<th>Fecha Final</th>
				<th>Calificacion Teorica Previa</th>
				<th>Calificacion Aplicacion Previa</th>
				<th>Calificacion Teorica Posterior</th>
				<th>Calificacion Aplicaci&oacute;n Posterior</th>
				</tr>";
		$query = "SELECT c.nom_curso, pc.fecha_inicio, pc.fecha_final, ac.calif_alum_prev, ac.calif_aplicacion_alum_prev, ac.calif_alum_post, ac.calif_aplicacion_alum_post
					FROM asig_capacitacion ac 
					JOIN prog_capacitacion pc ON pc.id = ac.prog_capacitacion_id  
					JOIN cursos c ON c.id = pc.curso_id
					WHERE empleados_id = $emp";
					//echo $query;
		if($resultado = $mysqli -> query($query)){
			while($datos = $resultado -> fetch_assoc()){
				$tabla .= "<tr>
							<td>".$datos['nom_curso']."</td>
							<td>".$datos['fecha_inicio']."</td>
							<td>".$datos['fecha_final']."</td>
							<td>".$datos['calif_alum_prev']."</td>
							<td>".$datos['calif_aplicacion_alum_prev']."</td>
							<td>".$datos['calif_alum_post']."</td>
							<td>".$datos['calif_aplicacion_alum_post']."</td>
						</tr>";
			}
			echo json_encode($tabla);
		}
		else{
			echo json_encode("Hubo un error con la consulta");
		}
	}
	
		elseif(isset($_POST['reporte_por_curso'])){
		$emp = $_POST['reporte_por_curso'];
		$query_asistencia = "select MAX(c.contados) as mas_asistencias FROM  
							(SELECT id_empleado, count(id_empleado) as contados FROM asistencia where id_capacitacion = $emp group by id_empleado ) c";
		
		$resultado_asistencia = $mysqli -> query($query_asistencia);
		$asist = $resultado_asistencia -> fetch_row();
		$tabla = "<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>E-mail</th>
				<th>Calificacion Teorica Previa</th>
				<th>Calificacion Aplicaci&oacute;n Previa</th>
				<th>Calificacion Teorica Posterior</th>
				<th>Calificacion Aplicaci&oacute;n Posterior</th>
				<th>% Asistencia</th>
				</tr>";
		$query = "SELECT e.id, CONCAT(e.a_paterno,' ',e.a_materno,' ',e.nombre) as nombre, e.email, c.nom_curso, pc.fecha_inicio, pc.fecha_final, ac.calif_alum_prev, ac.calif_aplicacion_alum_prev, ac.calif_alum_post, ac.calif_aplicacion_alum_post, asist.contados
					FROM asig_capacitacion ac 
					JOIN prog_capacitacion pc ON pc.id = ac.prog_capacitacion_id  
					JOIN cursos c ON c.id = pc.curso_id
					JOIN empleados e ON ac.empleados_id = e.id
					JOIN (SELECT id_empleado, id_capacitacion, count(id_empleado) as contados 
						  FROM asistencia WHERE id_capacitacion = $emp group by id_empleado ) asist ON asist.id_empleado = ac.empleados_id
					WHERE pc.id = $emp";
					//echo $query;
		if($resultado = $mysqli -> query($query)){
		$i = 0;
			while($datos = $resultado -> fetch_assoc()){
				$asistencia_emp = ($datos['contados']/$asist[0]) * 100;
				$tabla .= "<tr>
							<td>".$datos['id']."</td>
							<td>".$datos['nombre']."</td>
							<td>".$datos['email']."</td>
							<td>".$datos['calif_alum_prev']."</td>
							<td>".$datos['calif_aplicacion_alum_prev']."</td>
							<td>".$datos['calif_alum_post']."</td>
							<td>".$datos['calif_aplicacion_alum_post']."</td>
							<td id='asist-$i'>".$asistencia_emp."</td>
						</tr>";
						$i++;
			}
		$query2 = "SELECT pc.id, c.nom_curso, CONCAT(e.a_paterno,' ' ,e.nombre) as instructor, 
					DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y' ) as fecha_inicio,  
					DATE_FORMAT(pc.fecha_final, '%d-%m-%Y' ) as fecha_final, 
					pc.asistencia_minima, pc.calificacion_minima, salas.sala,
					salas.capacidad, r.descripcion,
					count(inscritos.id_empleado) as no_inscritos
					FROM alfcasta_tesis.prog_capacitacion pc
					JOIN cursos c ON pc.curso_id = c.id
					JOIN empleados e ON pc.instructor_id = e.id
					JOIN  salas salas ON salas.id = pc.sala_id
					JOIN regionales r ON  r.id = salas.regionales_id 
					JOIN inscritos ON inscritos.id_capacitacion_programada = pc.id
					WHERE pc.id = $emp";
		if($result = $mysqli -> query($query2)){
			while($datos_cap = $result -> fetch_assoc()){
			$titulo = $datos_cap['nom_curso'];
			$info1 .= "<tr><td><strong>Fecha Inicio</strong></td><td>".$datos_cap['fecha_inicio']."</td></tr>";
			$info1 .= "<tr><td><strong>Instructor</strong></td><td>".$datos_cap['instructor']."</td></tr>";
			$info1 .= "<tr><td><strong>% Asistencia</strong></td><td id='porcentaje_asist'>".$datos_cap['asistencia_minima']."</td></tr>";
			$info1 .= "<tr><td><strong>Calificaci&oacute;n minima</strong></td><td>".$datos_cap['calificacion_minima']."</td></tr>";
			$info2 .= "<tr><td><strong>Fecha Final</strong></td><td>".$datos_cap['fecha_final']."</td></tr>";
			$info2 .= "<tr><td><strong>Sala</strong></td><td>".$datos_cap['sala']."</td></tr>";
			$info2 .= "<tr><td><strong>Capacidad</strong></td><td>".$datos_cap['capacidad']."</td></tr>";
			$info2 .= "<tr><td><strong>Sucursal</strong></td><td>".$datos_cap['descripcion']."</td></tr>";
			}
		}
			$arreglo_respuesta['titulo'] 	= $titulo;
			$arreglo_respuesta['info1'] 	= utf8_encode($info1);
			$arreglo_respuesta['info2']		= utf8_encode($info2);
			$arreglo_respuesta['tabla'] 	= utf8_encode($tabla);
			$arreglo_respuesta['query'] 	= $asist[0];
			echo json_encode($arreglo_respuesta);
		}
		else{
			echo json_encode("Hubo un error con la consulta");
		}
	}
	
elseif(isset($_POST['asistencia_curso'])){
	$asist = $_POST['asistencia_curso'];
	$query = "SELECT e.id, CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) AS nombre FROM inscritos i JOIN empleados e ON i.id_empleado = e.id WHERE i.id_capacitacion_programada =  $asist";
	if($resultado = $mysqli -> query($query)){
		if($resultado -> num_rows > 0 ){
			$tabla= "<tr><th>#</th><th>Nombre</th><th>Asistencia</th></tr>";
			while($filas = $resultado -> fetch_assoc()){
				$tabla .= "<tr><td>".$filas['id']."</td><td>".$filas['nombre']."</td><td><input type='checkbox' name='asistio[]' value='".$filas['id']."'></input></td></tr>";
			}
		}
		else{
			$tabla = "<tr><td>No Hay alumnos inscritos en esta capacitaci&oacute;n</td><tr>";
		}
	}
	else{
		$tabla = "<tr><td>Hubo un error con la consulta</td><tr>";
	}
	echo json_encode(utf8_encode($tabla));
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

?>
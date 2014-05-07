<?php 
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	$conteo = count($_POST['id_emp_inscripcion']);
	$empleados_a_inscribir = $_POST['id_emp_inscripcion'];
	$id_capacitacion = $_POST['capacitacion_a_asignar'];
	foreach($empleados_a_inscribir as $id){
		if($correo = inscribe_empleados($id_capacitacion,$id)){
			$correos[] = "Se ha notiicado al empleado con mail: ".$correo." su inscripcion";
		}else{
			$errores[] = "Ocurrió un error con la inscripción";
		}
	}
}
if(isset($_GET['id_capacitacion'])){
$id_capacitacion=$_GET['id_capacitacion'];

}


?>
<div class="col-md-8" style="min-height:600px;">
	<h3>Programacion capacitaciones</h3>
		<div id="warnings">	
			<?php 
			if(!empty($errores)){
				foreach($errores as $error){ 
			?>
			<div class="alert alert-danger"><?=$error?></div>
			<?php 	} 
			} 
			if(isset($exito)){ ?>	
			<div class="alert alert-success"><?=$exito?></div>
			<?php }
			if(!empty($correos)){ 
				foreach($correos as $correo){
			?>	
			<div class="alert alert-info"><?=$correo?></div>
			<?php } 
			
			} ?>
			
			
			
	</div>
		
	<form role="form"  action="asig_capacitacion.php"  method="post" id="form_asig_capacitacion"> 
		<div class="form-group">
			<label for="capacitacion_a_asignar" class="control-label">Selecciona una capacitación programada</label>
			<select class="form-control" id="capacitacion_a_asignar" name="capacitacion_a_asignar" style="width: 80%;">
			<option value=" ">---------------------------------------------</option>
			<?php
				$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
							FROM alfcasta_tesis.prog_capacitacion pc
							JOIN cursos c ON pc.curso_id = c.id  WHERE pc.fecha_inicio >= NOW();";
				$seleccionada = "";
				$result = $mysqli -> query($query);
					while($row = $result -> fetch_assoc()){
						if(isset($id_capacitacion)){
						    if($row['id'] == $id_capacitacion){
							$seleccionada = "selected='selected'";
							}
							else{$seleccionada = "";}
						}
			?>
			<option value="<?=$row['id']?>" <?=$seleccionada?>><?=$row['id']?>&nbsp;||&nbsp;<?=$row['nom_curso']?>&nbsp;||&nbsp;Inicio:<?=$row['fecha_inicio']?> </option>
			<?php  } //Fin del while?>
			</select>
		</div>
		<p>Buscar un empleado por</p>
		<div class="ui-widget" style=" font-size: 1em !important; ">
			
				<div class="form-group" style="width:200px; float:left;">
					<label for="inscribe_num_emp" class="control-label" >Número</label>
					<input  style="width:85%" class="form-control"  id="inscribe_num_emp" type="text" ></input>
				</div>
				<div class="form-group" style=" margin-left: 25px;  width: 481px;">
					<label for="inscribe_emp_paterno" class="control-label">Apellido Paterno</label>
					<input  style="width:50%" class="form-control"  id="inscribe_emp_paterno" type="text"></input>
				</div>
			
		
		</div>
	<div id="contendor-lista" style="display:none;">
		<table id="tabla-inscripciones" class="table">
			<tr>
				<th>No. de Empleado</th>
				<th>Nombre Completo</th>
				<th>Eliminar</th>
			</tr>
		</table>
	</div>
		<div class="form-group">
		
			<input type="submit" class="btn btn-primary" value="Inscribir empleados seleccionados" id="enviar-inscripciones" style="display:none;"></input>
		</div>
	
	</form>
</div>
	
<div class="col-md-4" style="border-left:1px dotted gray">
	<div class="panel panel-primary">
		<div class="panel-heading">Caracteristicas de la capacitación</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered" id="tabla_datos_capacitacion">

				<?php 
				if(isset($id_capacitacion)){
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
					WHERE pc.id =$id_capacitacion";
							$resultado = $mysqli -> query($query);
							while($fila = $resultado -> fetch_assoc()){ ?>
								<tr><td><strong>Nombre del curso</strong></td><td><?=$fila['nom_curso']?></td></tr>
								<tr><td><strong>Instructor</strong></td><td><?=utf8_encode($fila['instructor'])?></td></tr>
								<tr><td><strong>Fecha de inicio</strong></td><td><?=$fila['fecha_inicio']?></td></tr>
								<tr><td><strong>Fecha de termino</strong></td><td><?=$fila['fecha_final']?></td></tr>
								<tr><td><strong>% Asistencia</strong></td><td><?=$fila['asistencia_minima']?></td></tr>
								<tr><td><strong>Calif. Mínima</strong></td><td><?=$fila['calificacion_minima']?></td></tr>
								<tr><td><strong>Sucursal</strong></td><td><?=$fila['descripcion']?></td></tr>
								<tr><td><strong>Sala</strong></td><td><?=$fila['sala']?></td></tr>
								<tr><td><strong>Cupo</strong></td><td id="cupo"><?=$fila['capacidad']-$fila['no_inscritos']?></td></tr>

								
						<?php 
							}
				} ?>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4" style="border-left:1px dotted gray">
	<div class="panel panel-primary">
		<div class="panel-heading">Empleados Inscritos a la capacitación</div>
			<div class="panel-body">
			<table class="table table-striped table-bordered" id="tabla_empleados_inscritos">
				<tr>
					<th>No.</th>
					<th>Nombre</th>
					<th>Puesto</th>
				</tr>
			<?php 
			if(isset($id_capacitacion)){
				$query2 = "SELECT i.id_empleado, e.a_paterno, e.a_materno, e.nombre, e.email, p.puesto 
						FROM inscritos i 
						JOIN empleados e ON e.id = i.id_empleado
						JOIN puesto p ON p.id = e.id_puesto
						WHERE i.id_capacitacion_programada = $id_capacitacion";
				if($resultado = $mysqli -> query($query2)){
					if($resultado -> num_rows > 0){
						while($fila = $resultado -> fetch_assoc()){ ?>
						<tr><td><?=$fila['id_empleado']?></td>
						<td><?=utf8_encode($fila['a_paterno'])?> <?=utf8_encode($fila['a_materno'])?> <?=utf8_encode($fila['nombre'])?></td>
						<td><?=$fila['puesto']?></td></tr>
						<? }
						
					}
					else{ $filas = "No Existen empleados inscritos a este curso";}
				}
			}
			?>
			</table>
			</div>
	</div>
</div>

<?php include_once('../estructura/footer.php');?>
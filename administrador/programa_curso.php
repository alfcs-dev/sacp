<?php 
include_once('../estructura/head.php');
acceso_admin();
if(isset($_GET['curso_id'])){
	$id_curso = $_GET['curso_id'];
}
if(!empty($_POST)){
	$horario = $_POST['horas'].":".$_POST['minutos'];
	if(capacitacion_existe($_POST['curso_a_programar'], $_POST['fecha_inicio_capacitacion'], $horario, $_POST['salas_disp'])){
		$errores[] = "Ya existe una capacitacion programada con ese curso en esa sala en ese horario y fecha";
	}
	else {
		$datos_capacitacion = array(
			'fecha_inicio'			=> $_POST['fecha_inicio_capacitacion'],
			'fecha_final'			=> $_POST['fecha_final_capacitacion'],
			'horario'				=> $horario,
			'asistencia_minima' 	=> $_POST['asist_minima'],
			'calificacion_minima'	=> $_POST['calif_minima'],
			'curso_id'				=> $_POST['curso_a_programar'],
			'instructor_id'			=> $_POST['instructor'],
			'sala_id'				=> $_POST['salas_disp']
		);
	$aviso =  programa_capacitacion($datos_capacitacion);
	$exito = "La capacitacion se ha programado con exito";
	}

}
?>
<div class="col-md-8">
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
			if(isset($aviso)){?>
			<div class="alert alert-info">Si quieres inscribir empleados a la capacitacion programada da clic 
			<a href="http://alfcastaneda.com/sacp/administrador/asig_capacitacion.php?id_capacitacion=<?=$aviso?>">aquí</a></div>
			<?php }?>
			
			
		</div>
		
	<form role="form"  action="programa_curso.php"  method="post" id="form_programa_capacitaciones"> 
		<div class="form-group">
			<label for="curso_a_programar" class="control-label">Selecciona un curso a programar</label>
			<select class="form-control" id="curso_a_programar" name="curso_a_programar" style="width: 55%;">
			<option value=" ">Selecciona el curso</option>
			<?php 
				$query = "SELECT * FROM cursos";
				$seleccionada = "";
				$result = $mysqli -> query($query);
					while($row = $result -> fetch_array()){
						if(isset($id_curso)){
							if($row['id'] == $id_curso){
							$seleccionada = "selected='selected'";
							}
						}
			?>
			<option value="<?=$row['id']?>" <?=$seleccionada?> > <?=$row['nom_curso']?></option>
			<?php  } //Fin del while?>
			</select>
		</div>
		<div class="form-group form-inline">
			<label for="suc_capacitacion" class="control-label">Selecciona la oficina y la sala en la que se programara la capacitación</label>
			<select class="form-control" id="suc_capacitacion" name="suc_capacitacion" style="width: 55%;">
			<option value="" selected="selected">Selecciona una oficina</option>
			<?php 
				$query2 = "SELECT * FROM regionales";
				$result = $mysqli -> query($query2);
					while($row = $result -> fetch_array()){
			?>
			<option value="<?=$row['id']?>"><?=$row['cve_region']?> | <?=$row['descripcion']?></option>
			<?php  } //Fin del while?>
			</select>
			<label for="salas_disp" class="control-label"></label>
			<select class="form-control" id="salas_disp" name="salas_disp" style="width: 35%;">
			<option value="0" selected="selected">Selecciona primero una oficina</option>
			</select>
		</div>
		<div class="form-group">
			<label for="instructor" class="control-label">Selecciona un instructor</label>
			<select class="form-control" id="instructor" name="instructor" style="width: 55%;">
			<?php 
				$query3 = "SELECT id, a_paterno, nombre FROM empleados WHERE es_instructor = 1 ORDER by a_paterno ASC";
				
				$result = $mysqli -> query($query3);
					while($row = $result -> fetch_array()){
			?>
			<option value="<?=$row['id']?>"><?=utf8_encode($row['a_paterno'])?>&nbsp;&nbsp;<?=utf8_encode($row['nombre'])?>   </option>
			<?php  } //Fin del while?>
			</select>
		</div>
		<label for="fecha_inicio_capacitacion" class="control-label">Fechas de la capacitacion </label>
		<div class="form-group form-inline" id="fechas">
			<input type="text" class="form-control" id="fecha_inicio_capacitacion" name="fecha_inicio_capacitacion" style="width:30%" placeholder="Fecha de inicio"/>
			<input type="text" class="form-control"  id="fecha_final_capacitacion" name="fecha_final_capacitacion" style="width:30%" placeholder="Fecha de termino"/>
		</div>
		<div class="form-group form-inline" id="horario">
			<label class="control-label" for="horas">Hora: (ej. 08:00) </label><br>
			<select class="form-control" name="horas"  id="horas" style="width: 10%;">
			<?php for($i=0; $i <= 24; $i++){ 
				echo '<option>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
			} ?>
			</select>
			<select  class="form-control" name="minutos"  id="minutos" style="width: 10%;">
			<?php for($i=0; $i <= 59; $i++){ echo '<option>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
			} ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label" for="calif_minima">Calificación minima para aprobar</label>
			<select class="form-control" name="calif_minima"  id="calif_minima" style="width: 10%;">
				<option>6</option>
				<option>7</option>
				<option selected="selected">8</option>
				<option>9</option>
				<option>10</option>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label" for="asist_minima">Asistencia minima para aprobar</label>
			<select class="form-control" name="asist_minima"  id="asist_minima" style="width: 10%;">
				<option value="60">60%</option>
				<option value="70">70%</option>
				<option value="80" selected="selected">80%</option>
				<option value="90">90%</option>
				<option value="100">100%</option>
			</select>
		</div>
		<div class="form-group">
		<input type="hidden" id="actualizar" name="actualizar" ></input>
			<input type="submit" class="btn btn-primary" value="Enviar"></input>
		</div>
	
	</form>
</div>
	
<div class="col-md-4" style="border-left:1px dotted gray">
	<div class="panel panel-primary">
	  <!-- Default panel contents -->
		<div class="panel-heading">Caracteristicas del curso</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered" id="tabla_datos_curso">
					<tr>
						<th>CURSO</th>
						<th>DURACION</th>
						<th>MODALIDAD</th>
					</tr>
	<?php 
		if(isset($id_curso)){
			$query = "SELECT * FROM cursos c, modalidad m WHERE c.id = $id_curso AND m.id = c.modalidad_id";
			$resultado = $mysqli -> query($query);
			while($fila = $resultado -> fetch_assoc()){ ?>
			<td><?=$fila['nom_curso']?></td>
			<td><?=$fila['duracion']?> hrs.</td>
			<td><?=$fila['nom_modalidad']?></td>
			
	<?php 
			}
	} 
	?>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4" style="border-left:1px dotted gray" >
<div class="panel panel-primary" style="display:none" id="caracteristicas_sala" >
	<div class="panel-heading">Caracteristicas de la sala</div>
	<div class="panel-body">
		<table class="table table-striped table-bordered" id="tabla_sala">
		</table>
	</div>
</div>
</div>

<?php include_once('../estructura/footer.php');  ?>


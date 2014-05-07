<?php 
include_once('../estructura/head.php');
if(esadmin() || $datos_usuario['es_instructor'] == 1){
	if(!empty($_POST)){
		$ids = $_POST['id'];
		foreach($ids as $i => $a){
			$sql= "UPDATE asig_capacitacion SET 
					calif_alum_post ='".$_POST['calif_alum_post'][$i]."', 
					calif_aplicacion_alum_post ='".$_POST['calif_aplicacion_alum_post'][$i]."' 
					WHERE empleados_id = $a AND prog_capacitacion_id = ".$_POST['cap_calif'];
			if($mysqli -> query($sql)){
				$exito = "Se guardaron con exito las calificaciones";
			}else{$errores[] = "Ocurrio un error al guardar los datos vuelve a intentarlo";}
		}
	}
?>


<div class="col-md-8" style="min-height:600px;">
	<h3>Calificaciones</h3>
	<div id="warnings">	
	<?php 
		if(!empty($errores)){
			foreach($errores as $error){ ?>
				<div class="alert alert-danger"><?=$error?></div>
				<?php 	} 
			} 
		if(isset($exito)){ ?>	
			<div class="alert alert-success"><?=$exito?></div>
			<?php } ?>
	</div>
	<form role="form"  action="calificaciones.php"  method="post" id="form_calificaciones">
		<div class="form-group">
			<label for="cap_calif" class="control-label">Selecciona una capacitación programada</label>
			<select class="form-control" id="cap_calif" name="cap_calif" style="width: 80%;">
			<option value=" ">---------------------------------------------</option>
			<?php 	if(esadmin()){
					$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
							FROM alfcasta_tesis.prog_capacitacion pc
							JOIN cursos c ON pc.curso_id = c.id";}
					else{
					$query="SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
							FROM alfcasta_tesis.prog_capacitacion pc
							JOIN cursos c ON pc.curso_id = c.id WHERE pc.instructor_id = ".$datos_usuario['id'];
							}
					$result = $mysqli -> query($query);
					while($row = $result -> fetch_assoc()){ ?>
							<option value="<?=$row['id']?>"><?=$row['id']?>&nbsp;||&nbsp;<?=$row['nom_curso']?>&nbsp;||&nbsp;Inicio:<?=$row['fecha_inicio']?> </option>
					<?php  } //Fin del while?>
			</select>
		</div>		
	
	<table id="asignar-calificaciones" class="table table-striped table-bordered" style="display:none">
			<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Teorica previa</th>
			<th>Aplicación previa</th>
		</tr>
	</table>
	<input type='submit' class='btn btn-primary' style="display:none" id="envia_calificaciones" value='Enviar'></input>
	</form>
</div>

<?php 
}else{ acceso_protegido();}
include_once('../estructura/footer.php');?>
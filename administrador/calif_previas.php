<?php 
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	$ids = $_POST['id'];
	foreach($ids as $i => $a){
		$sql= "UPDATE asig_capacitacion SET 
				calif_alum_prev ='".$_POST['calif_alum_prev'][$i]."', 
				calif_aplicacion_alum_prev ='".$_POST['calif_aplicacion_alum_prev'][$i]."' 
				WHERE empleados_id = $a AND prog_capacitacion_id = ".$_POST['cap_calif_previas'];
		if($mysqli -> query($sql)){
			$exito = "Se guardaron con exito las calificaciones";
		}else{$errores[] = "Ocurrio un error al guardar los datos vuelve a intentarlo";}
	}
}
?>


<div class="col-md-8" style="min-height:600px;">
	<h3>Calificaciones Previas</h3>
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
	<form role="form"  action="calif_previas.php"  method="post" id="form_calif_previas">
		<div class="form-group">
			<label for="cap_calif_previas" class="control-label">Selecciona una capacitación programada</label>
			<select class="form-control" id="cap_calif_previas" name="cap_calif_previas" style="width: 80%;">
			<option value=" ">---------------------------------------------</option>
			<?php 	$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
							FROM alfcasta_tesis.prog_capacitacion pc
							JOIN cursos c ON pc.curso_id = c.id  WHERE pc.fecha_inicio >= NOW();";
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
	<input type='submit' class='btn btn-primary' style="display:none" id="envia_previas" value='Enviar'></input>
	</form>
</div>

<?php include_once('../estructura/footer.php');?>
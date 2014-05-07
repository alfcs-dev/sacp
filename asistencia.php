<?php 
include 'estructura/head.php';
acceso_protegido();
if($datos_usuario['es_instructor'] == 0){
header('Location: http://alfcastaneda.com/sacp/acceso.php');
}
if(!empty($_POST)){
	if(isset($_POST['asistio'])){
		$asistieron_ids = $_POST['asistio'];
		$capacitacion 	= $_POST['id_cap'];
		$fecha = date('Y-m-d');
		foreach($asistieron_ids as $ids){
			if(pasa_lista($ids, $capacitacion)){
				$exito = "Asistencia guardad con exito";
			}
			else{$errores[] = "El usuario con numero de empleado ".$ids." ya habia pasado lista el dia de hoy";}
		}
	}
	if(isset($_POST['lista-final'])){
		$sql = "UPDATE prog_capacitacion SET paso_asistencia = 1 WHERE id =".$_POST['id_cap'];
		if($insert = $mysqli -> query($sql)){
			$final = "Se guardo la ultima lista con exito";
		}
		else{
			$errores[] = "No se guardo la última lista";
		}
		
	}
}
?>
<div id="warnings">	
	<?php 
	if(!empty($errores)){
		foreach($errores as $error){ ?>
			<div class="alert alert-danger"><?=$error?></div>
	<?php 	
		} 
	} 
	if(isset($exito)){ ?>	
		<div class="alert alert-success"><?=$exito?></div>
	<?php }
	if(isset($final)){  ?>
	<div class="alert alert-success"><?=$final?></div>
	
	<?php } ?>
</div>
<div class="col-md-8">
	<form role="form"  action="asistencia.php"  method="post" id="form_asistencia">
		<h4>Selecciona tu curso para tomar la asistencia</h4>
		<div class="form-group">
			<select  class="form-control" id="asistencia_curso" style="width: 65%;" name="id_cap">
				<option value="0">SELECCIONA UNA CAPACITACIÓN</option>
			<?php	if(esadmin()){
						$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
								FROM alfcasta_tesis.prog_capacitacion pc
								JOIN cursos c ON pc.curso_id = c.id
								WHERE pc.fecha_inicio >= NOW() AND pc.paso_asistencia = 0";}
						else{
						$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
								FROM alfcasta_tesis.prog_capacitacion pc
								JOIN cursos c ON pc.curso_id = c.id WHERE pc.instructor_id = ".$datos_usuario['id']." AND pc.fecha_inicio >= NOW() AND pc.paso_asistencia = 0";
								}
						$result = $mysqli -> query($query);
						while($row = $result -> fetch_assoc()){ ?>
								<option value="<?=$row['id']?>"><?=$row['id']?>&nbsp;||&nbsp;<?=$row['nom_curso']?>&nbsp;||&nbsp;Inicio:<?=$row['fecha_inicio']?> </option>
						<?php  } //Fin del while?>
			</select>
		</div>
		<table id="pasar_asistencia" class="table table-striped table-bordered" style="display:none">
		</table>
		<div class="form-group" id="btn-envio"  style="display:none">
			<label class="checkbox-inline">Selecciona si esta es la última lista de esta capacitación
			<input type="checkbox" id="lista-final" name="lista-final"  value="1" > 
			</label><br><br>
			<input type="submit" value="Guardar Lista de Asistencia" class="btn btn-default" ></input>
		</div>
	</form>
	
	
</div>

<?php
include 'estructura/footer.php';
?>
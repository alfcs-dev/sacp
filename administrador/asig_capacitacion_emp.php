<?php 
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	$ids_capacitaciones = $_POST['id_cap'];
	$id = $_POST['id_emp'];
	foreach($ids_capacitaciones as $ids){
		if($correo = inscribe_empleados($ids,$id)){
			$correos[] = "Se ha notiicado al empleado con mail: ".$correo." su inscripcion";
		}else{
			$errores[] = "Ocurrió un error con la inscripción";
		}
	}
}
?>
	
<div class="col-md-8" style="min-height:600px;">
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
	<div class="ui-widget" style=" font-size: 1em !important; ">
		<div class="form-group" style="width:200px; float:left;">
			<label for="inscribe_por_num_emp" class="control-label" >Número</label>
			<input  style="width:85%" class="form-control"  id="inscribe_por_num_emp" type="text" ></input>
		</div>
		<div class="form-group" style=" margin-left: 25px;  width: 481px;">
			<label for="inscribe_por_emp_paterno" class="control-label">Apellido Paterno</label>
			<input  style="width:50%" class="form-control"  id="inscribe_por_emp_paterno" type="text"></input>
		</div>
	</div>
	<form id="inscribe_empleado" role="form"  action="asig_capacitacion_emp.php"  method="post">
		<h3 id="encabezado" style="display:none;">Selecciona los cursos a los que deseas inscribir al empleado</h3>
		<table class="table table-striped table-bordered" id="caps_disponibles">
		</table>
		<input type="hidden" value="" name="id_emp" id="id_emp"></input>
		<div class="form-group" id="submit-insc" style="display:none;">
		  <input type="submit" class="btn btn-primary" value="Enviar" ></input>
		</div>
	</form>
</div>
<div class="col-md-4">
	<div class="panel panel-primary">
		<div class="panel-heading">Datos del empleado</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered" id="tabla_datos_empleado">	
			</table>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-primary">
		<div class="panel-heading">Cursos inscrito</div>
		<div class="panel-body">
			<table class="table table-striped table-bordered" id="muestra_inscripciones">
			</table>
		</div>
	</div>
</div>
<?php include_once('../estructura/footer.php');?>
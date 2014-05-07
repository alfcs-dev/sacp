<?php 
include 'estructura/head.php';
acceso_protegido();

?>
<div class="col-md-8">
<?php 
$sql = "SELECT c.nom_curso, pc.fecha_inicio, pc.fecha_final, ac.calif_alum_post, ac.calif_aplicacion_alum_post 
		FROM asig_capacitacion ac
		JOIN prog_capacitacion pc ON pc.id = ac.prog_capacitacion_id
		JOIN cursos c ON c.id = pc.curso_id
		WHERE ac.empleados_id =".$datos_usuario['id'];

$resultado = $mysqli -> query($sql);
if($resultado -> num_rows == 0) { ?>
<div class="alert alert-info">Aún no te encuentras inscrito en ningún curso</div>
<?php } 
else { ?>
<table class="table table-bordered table-striped">
	<tr>
		<th>Curso</th><th>Fecha de inicio</th><th>Fecha Final</th><th>Calificación teorica</th><th>Calificación práctica</th>
	</tr>
<?php
	while($tabla = $resultado -> fetch_assoc()){ 
		if($tabla['calif_alum_post'] == NULL || $tabla['calif_alum_post'] == ""){$calif = "Aún no calificado";} else { $calif = $tabla['calif_alum_post'];}
		if($tabla['calif_aplicacion_alum_post'] == NULL || $tabla['calif_aplicacion_alum_post'] == ""){$calif_aplicacion = "Aún no calificado";} else { $calif_aplicacion = $tabla['calif_aplicacion_alum_post'];}
	?>
		<tr>
			<td><?=$tabla['nom_curso']?></td><td><?=$tabla['fecha_inicio']?></td><td><?=$tabla['fecha_final']?></td><td><?=$calif?></td><td><?=$calif_aplicacion?></td>
		</tr>
	<?php } ?>
</table>
<?php	} ?>
</div>
<div class="col-md-4">
	<div class="panel panel-primary">
		<div class="panel-heading">Datos</div>
		<div class="panel-body">
			<table class="table table-bordered table-striped">
				<tr>
					<td>No.</td><td><?=$datos_usuario['id']?></td>
				</tr>
				<tr>
					<td>Nombre</td><td><?=$datos_usuario['nombre']." ".$datos_usuario['a_paterno']?></td>
				</tr>
				<tr>
					<td>E-mail</td><td><?=$datos_usuario['email']?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php 
include 'estructura/footer.php';
?>
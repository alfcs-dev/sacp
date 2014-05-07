<?php
include 'estructura/head.php';
acceso_protegido();
if(!empty($_POST)){
	$mensaje = "<h3>Administrador:</h3>
				<p>Se notifica que el empleado: </p>
				<p>".$datos_usuario['nombre']." ".$datos_usuario['a_paterno']." Con número de empleado: ".$datos_usuario['id']."</p>
				<p>A solicitado inscribirse al curso No.".$_POST['id_cap_programada']." con nombre: ".$_POST['nom_cap_programada']." y fecha de inicio: ".$_POST['fecha_cap_programada']."</p>";
	
	email('alfcastaneda@gmail.com', 'Solicitud de Inscripción', $mensaje);
	$exito = "Se ha enviado un correo al administrador del sistema con tu solicitud";
}
?>
<h3>Catalogo de cursos</h3>
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
<div class="row">
<?php 
$sql = "SELECT id_capacitacion_programada FROM inscritos WHERE id_empleado = ".$datos_usuario['id'];
$resultado = $mysqli -> query($sql);
while($inscrito = $resultado -> fetch_assoc()){
	$inscrito_en[] = $inscrito['id_capacitacion_programada'];
}
if(isset($inscrito_en)){
	$inscritos = implode(',', $inscrito_en);
	$sql2 = "SELECT pc.id, c.nom_curso,  DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(pc.fecha_final, '%d-%m-%Y') as fecha_final, pc.horario, m.nom_modalidad, r.cve_region, s.sala, s.capacidad, pc.asistencia_minima, pc.calificacion_minima 
				FROM prog_capacitacion pc 
				JOIN cursos c ON pc.curso_id = c.id 
				JOIN modalidad m ON m.id = c.modalidad_id 
				JOIN salas s ON s.id = pc.sala_id 
				JOIN regionales r ON r.id = s.regionales_id 
				WHERE (pc.id NOT IN ($inscritos)) AND fecha_inicio >= NOW();";
}
else { 	$sql2 = "SELECT pc.id, c.nom_curso,  DATE_FORMAT(pc.fecha_inicio, '%d-%m-%Y') as fecha_inicio, DATE_FORMAT(pc.fecha_final, '%d-%m-%Y') as fecha_final, pc.horario, m.nom_modalidad, r.cve_region, s.sala, s.capacidad, pc.asistencia_minima, pc.calificacion_minima 
				FROM prog_capacitacion pc 
				JOIN cursos c ON pc.curso_id = c.id 
				JOIN modalidad m ON m.id = c.modalidad_id 
				JOIN salas s ON s.id = pc.sala_id 
				JOIN regionales r ON r.id = s.regionales_id 
				WHERE pc.fecha_inicio >= NOW();"; }
$busca_catalogo = $mysqli -> query($sql2);
while($cursos = $busca_catalogo -> fetch_assoc()){ ?>
	 <div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading"><?=$cursos['nom_curso']?></div>
			<div class="panel-body">
			<form id="<?=$cursos['id']?>" method="post" role="form" action="catalogo_cursos.php">
				<div><span style="font-weight: bold;">Fecha de inicio: </span><?=$cursos['fecha_inicio']?></div>
				<div><span style="font-weight: bold;">Fecha de terminación: </span><?=$cursos['fecha_final']?></div>
				<div><span style="font-weight: bold;">Horario: </span> <?=$cursos['horario']?></div>
				<div><span style="font-weight: bold;">Modalidad: </span><?=$cursos['nom_modalidad']?></div>
				<div><span style="font-weight: bold;">Sucursal: </span><?=$cursos['cve_region']?></div>
				<div><span style="font-weight: bold;">Sala: </span><?=$cursos['sala']?></div>
				<div><span style="font-weight: bold;">Capacidad: </span> <?=$cursos['capacidad']?></div>
				<div><span style="font-weight: bold;">Asistencia: </span><?=$cursos['asistencia_minima']?>%</div>
				<div>
					<span style="font-weight: bold;">Calificación: </span><?=$cursos['calificacion_minima']?> 
					<input class=" btn btn-default pull-right" type="submit" value="Solicitar Inscripción">
					<input type="hidden" name="id_cap_programada" value="<?=$cursos['id']?>">
					<input type="hidden" name="fecha_cap_programada" value="<?=$cursos['fecha_inicio']?>">
					<input type="hidden" name="nom_cap_programada" value="<?=$cursos['nom_curso']?>">
				</div>
				
			</form>
			</div>
		</div>
	 </div>
<?php } ?>
</div>

<?php 
include 'estructura/footer.php';
?>
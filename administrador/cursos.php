<?php
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	if($_POST['borrar'] == 1){
		if(borra_curso($_POST['nombre_curso'])){
		$exito = "El curso ".$_POST['nombre_curso']." fue borrado con exito del sistema";
		}
		else{
		$errores[] = "Este curso no se puede elimnar ya que existen capacitaciones programadas del mismo";
		}

	}
	elseif($_POST['actualizar'] == 1){
		$datos_curso = array(
				'id'			=> $_POST['id_curso'],
				'nom_curso'  	=> $_POST['nombre_curso'],
				'duracion'  	=> $_POST['duracion'],
				'modalidad_id' 	=> $_POST['modalidad']
			);
		actualiza_curso($datos_curso);
		$exito = "El curso se actualizo con exito";
		
	}
	else{
		$errores = array();
		if(curso_existe($_POST['nombre_curso'], $_POST['modalidad'])){
			$errores[] = "Lo sentimos ya existe un curso con ese titulo en la modalidad seleccionada";
		}
		if(empty($errores) && !empty($_POST)){
			$datos_curso = array(
				
				'nom_curso'  => $_POST['nombre_curso'],
				'duracion'  => $_POST['duracion'],
				'modalidad_id' 	=> $_POST['modalidad']
			);
			
			crea_curso($datos_curso);
			$exito =   "El curso ".$_POST['nombre_curso']." a sido creado con exito";
		}
	}
}
?>

<div class="col-md-6">
	<h3>Crear curso</h3>
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
			if(isset($correo)){?>
			<div class="alert alert-success"><?=$correo?></div>
			<?php }?>
			
			
		</div>
		
		<form role="form"  action="cursos.php"  method="post" id="form-curso"> 
			<input type="hidden" id="id_curso" name="id_curso" value=""></input>
			<div class="form-group" id="name-curso">
				<label for="nombre_curso" class="control-label">Título del curso<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="nombre_curso" name="nombre_curso" placeholder="Nombre del curso">
			</div>
			<div class="form-group">
				<label for="modalidad" class="control-label">Modalidad</label>
				<select class="form-control" id="modalidad" name="modalidad" style="width: 35%;">
						<?php 
						$query = "SELECT * FROM modalidad";
						global $mysqli;
						$result = $mysqli -> query($query);
							while($row = $result -> fetch_array()){
						?>
						
						<option value="<?=$row['id']?>"><?=$row['nom_modalidad']?></option>
						
						
						<?php  } //Fin del while?>
				</select>
			</div>
			<div class="form-group" id="duracion_hrs">
				<label for="duracion" class="control-label">Duración en horas<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="duracion" name="duracion" placeholder="Duración" style="width:25%;">
				
			</div>
			<div class="form-group">
				<button type="button" id="eliminar-curso" class="btn btn-default" name="eliminar-curso"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
				<input type="hidden" id="borrar" name="borrar" value="0"></input>
				<input type="hidden" id="actualizar" name="actualizar" ></input>
				<input type="submit" class="btn btn-primary" value="Enviar"></input>
			</div>
		</form>
</div>
	<div class="col-md-5">
		<div id="lista_cursos">
		<h4>CURSOS DISPONIBLES</h4>
			<table class="table  table-bordered table-striped">
				<th>CURSO</th>
				<th>MODALIDAD</th>
				<th>DURACIÓN</th>
				<th>PROGRAMACIÓN</th>
				<?php 
				$sql = "SELECT c.id as curso_id, c.nom_curso, c.duracion, m.nom_modalidad, m.id as modalidad_id FROM cursos c JOIN modalidad m ON  c.modalidad_id = m.id;";
				$resultado = $mysqli -> query($sql);
					while($filas = $resultado -> fetch_assoc()){ ?>
					<tr>
						<td><a  title="" data-toggle="tooltip" href="javascript:selecciona_curso('<?=$filas['curso_id']?>','<?=$filas['nom_curso']?>','<?=$filas['modalidad_id']?>','<?=$filas['duracion']?>');" data-original-title="Default tooltip" ><?=$filas['nom_curso']?></a></td>
						<td><?=$filas['nom_modalidad']?></td>
						<td style="text-align:right;"><?=$filas['duracion']?> hrs.</td>
						<td><a href="http://alfcastaneda.com/sacp/administrador/programa_curso.php?curso_id=<?=$filas['curso_id']?>">Programar capacitación con este curso</a></td>
					</tr>
					<?php
					}
					?>
			</table>
		</div>
	</div>

<?php include_once('../estructura/footer.php');  ?>
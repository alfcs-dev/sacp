<?php
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	if($_POST['borrar'] == 1){
		if(borra_curso($_POST['nombre_sala'])){
		$exito = "La sala ".$_POST['nombre_sala']." fue borrada con exito del sistema";
		}
		else{
		$errores[] = "Esta sala no se puede elimnar ya que existen capacitaciones programadas en ella.";
		}

	}
	elseif($_POST['actualizar'] == 1){
		$datos_sala = array(
				'id'				=> $_POST['id_sala'],
				'sala'  	 		=> $_POST['nombre_sala'],
				'capacidad'  		=> $_POST['capacidad'],
				'proyector'			=> $_POST['canon'],
				'pizarra'	 		=> $_POST['pizarron'],
				'pantalla_proyec' 	=> $_POST['proyeccion'],
				'equipo_video'		=> $_POST['videoconferencia'],
				'observaciones'		=> $_POST['observaciones'],
				'regionales_id'		=> $_POST['sucursal'],
			);
		actualiza_sala($datos_sala);
		
			$exito = "Sala actualizada correctamente";
	}
	else{
		$errores = array();
		//print_r($_POST);
		if(sala_existe($_POST['nombre_sala'], $_POST['sucursal'])){
			$errores[] = "Lo sentimos ya existe una sala con ese nombre en la sucursal seleccionada";
		}
		if(empty($errores) && !empty($_POST)){
			$datos_sala = array(
				'sala'  	 		=> $_POST['nombre_sala'],
				'capacidad'  		=> $_POST['capacidad'],
				'proyector'			=> $_POST['canon'],
				'pizarra'	 		=> $_POST['pizarron'],
				'pantalla_proyec' 	=> $_POST['proyeccion'],
				'equipo_video'		=> $_POST['videoconferencia'],
				'observaciones'		=> $_POST['observaciones'],
				'regionales_id'		=> $_POST['sucursal'],
				
			);
			
			$arreglo = crea_sala($datos_sala); 
			print_r($arreglo);
			$exito =   "El sala ".$_POST['nombre_sala']." a sido creado con exito";
		}
	}
}
?>

<div class="col-md-8">
	<h3>Crear sala</h3>
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
		
		<form role="form"  action="salas.php"  method="post" id="form-salas"> 
			<input type="hidden" id="id_sala" name="id_sala" value=""></input>
			<div class="form-group" id="name-sala">
				<label for="nombre_sala" class="control-label">Nombre de sala<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="nombre_sala" name="nombre_sala" placeholder="Escribe aquí el nombre de la sala" style="width: 75%;">
			</div>
			<div class="form-group">
				<label for="sucursal" class="control-label">Region de la Sucusal</label>
				<select class="form-control" id="sucursal" name="sucursal" style="width: 55%;">
						<?php 
						$query = "SELECT * FROM regionales";
						global $mysqli;
						$result = $mysqli -> query($query);
							while($row = $result -> fetch_array()){
						?>
						
						<option value="<?=$row['id']?>"><?=$row['cve_region']?> | <?=$row['descripcion']?></option>
						
						
						<?php  } //Fin del while?>
				</select>
			</div>
			<div class="form-group" id="capacidad_prs">
				<label for="duracion" class="control-label">Capacidad<span style="color:red;"> *</span></label>
				<select class="form-control"  id="capacidad" name="capacidad" style="width: 10%">
					<?php 
					for($i=0; $i <= 40; $i++){ 
						echo '<option> '.$i.' </option>';
					} ?>
				</select>				
			</div>
			<div class="form-group">
			<label for="observaciones">Observaciones</label>
			<textarea class="form-control" rows="3" name = "observaciones" id = "observaciones" style="width: 75%;"></textarea>
			</div>
			<div class="form-group">
			<label>Caracteristicas de la sala</label><br>
			<label class="checkbox-inline">
				<input type="checkbox"  name = "videoconferencia" value="1" id="videoconferencia"> Videoconferencia 
				</label>
			<label class="checkbox-inline"><input type="checkbox" name = "canon" value="1" id="canon">  Cañon o proyector</label>
			<label class="checkbox-inline"><input type="checkbox" name = "pizarron" value="1" id="pizarron"> Pizarrón blanco </label>
			<label class="checkbox-inline" style="margin-left:0px;"><input type="checkbox"  name = "proyeccion" value="1" id="proyeccion"> Pantalla de proyección </label>

			
			</div>			
			
			<div class="form-group">
				<button type="button" id="eliminar-sala" class="btn btn-default" name="eliminar-sala"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
				<input type="hidden" id="borrar" name="borrar" value="0"></input>
				<input type="hidden" id="actualizar" name="actualizar" ></input>
				<input type="submit" class="btn btn-primary" value="Enviar"></input>
			</div>
		</form>
</div>
	<div class="col-md-4">
		<div id="select-regional">
			<label for="select-estado">SELECCIONA UNA SUCURSAL</label>
			<select id="select-estado" name="select_estado">
			<option value=" ">--------------------------------------</option>
			<?php 
				$query = "SELECT * FROM regionales";
				$result = $mysqli -> query($query);
				while($row = $result -> fetch_assoc()){
			?>
			<option value="<?=$row['id']?>"><?=$row['descripcion']?></option>
 			<? 	}  ?>
			</select>
		</div>
		
		
		<div id="lista_salas">
		<h4>Listado de Salas en región seleccionada</h4>
			<table class="table  table-bordered table-striped" id="tabla_salas">
				<th>NOMBRE DEL LA SALA</th>
				<th>CAPACIDAD</th>
			</table>
		</div>
	</div>

<?php include_once('../estructura/footer.php');  ?>
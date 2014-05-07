<?php
include_once('../estructura/head.php');
acceso_admin();
if(!empty($_POST)){
	if($_POST['borrar'] == 1){
		if(borra_sucursal($_POST['nombre_sucursal'], $_POST['estado'])){
		$exito = "La sucursal ".$_POST['nombre_sucursal']." fue borrada con exito del sistema";
		}
		else{
		$errores[] = "Existe un problema con la eliminación de esta sala vuelvelo a intentar o ponte en contacto con el area de soporte";
		}

	}
	elseif($_POST['actualizar'] == 1){
			$datos_sucursal = array(
				'id'				=> $_POST['id_sucursal'],
				'cve_region'  	 	=> $_POST['cve_region'],
				'descripcion'  		=> $_POST['nombre_sucursal'],
				'dif_horario'		=> $_POST['dif_horario'],
				'estado_id'	 		=> $_POST['estado']
				
			);
		$hola=actualiza_sucursal($datos_sucursal);
		print $hola;
			$exito = "Sala actualizada correctamente";
	}
	else{
		$errores = array();
		//print_r($_POST);
		if(sucursal_existe($_POST['nombre_sucursal'], $_POST['estado'])){
			$errores[] = "Lo sentimos ya existe una sala con ese nombre en la sucursal seleccionada";
		}
		if(empty($errores) && !empty($_POST)){
			$datos_sucursal = array(
				'cve_region'  	 	=> $_POST['cve_region'],
				'descripcion'  		=> $_POST['nombre_sucursal'],
				'dif_horario'		=> $_POST['dif_horario'],
				'estado_id'	 		=> $_POST['estado']
				
			);
			
			$arreglo = crea_sucursal($datos_sucursal); 
			print_r($arreglo);
			$exito =   "La sucursal ".$_POST['nombre_sucursal']." a sido creado con exito";
		}
	}
}
?>

<div class="col-md-6">
	<h3>Sucursales</h3>
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
		
		<form role="form"  action="sucursales.php"  method="post" id="form-sucursales"> 
			<input type="hidden" id="id_sucursal" name="id_sucursal" value=""></input>
			<div class="form-group" id="name-sucursal">
				<label for="nombre_sucursal" class="control-label">Nombre de la sucursal<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="nombre_sucursal" name="nombre_sucursal" placeholder="Escribe aquí el nombre de la sucursal" style="width: 75%;">
			</div>
			<div class="form-group" id="clave_region">
				<label for="cve_region" class="control-label">Clave de la región o sucursal<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="cve_region" name="cve_region" placeholder="Clave para la región o sucursal" style="width: 25%;">
			</div>	
			<div class="form-group">
				<label for="estado" class="control-label">Estado</label>
				<select class="form-control" id="estado" name="estado" style="width: 35%;">
						<?php 
						$query = "SELECT * FROM estado";
						global $mysqli;
						$result = $mysqli -> query($query);
							while($row = $result -> fetch_array()){
						?>
						
						<option value="<?=$row['id']?>"><?=$row['nom_estado']?></option>
						
						
						<?php  } //Fin del while?>
				</select>
			
			</div>
			<div class="form-group" id="diferencia_horario">
				<label for="dif_horario" class="control-label">Diferencia de horario en horas<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="dif_horario" name="dif_horario" placeholder="Diferencia de horario" style="width: 25%;">
			</div>			
			<div class="form-group">
				<button type="button" id="eliminar-sucursal" class="btn btn-default" name="eliminar-sucursal"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
				<input type="hidden" id="borrar" name="borrar" value="0"></input>
				<input type="hidden" id="actualizar" name="actualizar" ></input>
				<input type="submit" class="btn btn-primary" value="Enviar"></input>
			</div>
		</form>
</div>
<div class="col-md-4">
		<div id="lista_cursos">
		<h4>SUCURSALES EXISTENTES</h4>
			<table class="table  table-bordered table-striped">
				<th>NOMBRE DE LA SUCURSAL</th>
				<th>CLAVE</th>
				<th>ESTADO</th>
				<th>DIF. HORARIO(Hrs.)</th>
				<?php 
				$sql = "SELECT r.id, r.cve_region, r.descripcion, r.dif_horario, r.estado_id, e.nom_estado FROM regionales r JOIN estado e ON  r.estado_id = e.id;";
				$resultado = $mysqli -> query($sql);
					while($filas = $resultado -> fetch_assoc()){ ?>
						<tr>
				<td><a href="javascript:selecciona_sucursal('<?=$filas['id']?>','<?=$filas['cve_region']?>','<?=$filas['descripcion']?>','<?=$filas['dif_horario']?>','<?=$filas['estado_id']?>');"><?=$filas['descripcion']?></a></td>
				<td><?=$filas['cve_region']?></td>
				<td style="text-align:center;"><?=$filas['nom_estado']?></td>
				<td style="text-align:right;"><?=$filas['dif_horario']?>Hrs.</td>
				</tr>
					<?php
					}
					?>
			</table>
		</div>
	</div>

<?php include_once('../estructura/footer.php');  ?>
<?php 
include '../estructura/head.php';
acceso_admin();
if(!empty($_POST)){
	$errores = array();
	if(empty($errores)) {
		if(existe_usuario($_POST['email'])){
			$errores[]= 'Lo sentimos, el correo electronico \''. $_POST['email'] . '\' ya existe.';
		}
		if(preg_match("/\\s/", $_POST['email']) == true){
			$errores[] = "El nombre de usuario no debe contener espacios";
		}
		
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
			$errores[] = 'Es necesaria una dirección de correo valida';
		}
	}
	if(empty($errores) && !empty($_POST)){
		$datos_registro = array(
				'a_paterno'  	=> utf8_decode($_POST['apellido_p']),
				'a_materno' 	=> utf8_decode($_POST['apellido_m']),
				'nombre' 		=> $_POST['nombre'],
				'status'		=> '1',
				'email'  		=> $_POST['email'],
				'es_instructor'	=> $_POST['inst'],
				'fecha_ingreso' => date('Y-m-d'),
				'id_puesto'		=> $_POST['puesto'],
				'password' 	 	=> uniqid(),
				'rol'			=> $_POST['rol'],
				'active'		=> '0',
				'codigo_correo' 	=> md5($_POST['email']+microtime())
				
				
		);

		$envio = registra_usuario($datos_registro);
		$exito =   "La cuenta para el empleado ".$_POST['nombre']." ".$_POST['apellido_p']." a sido creada con exito <br>";
		$correo =  "Se ha enviado un correo electronico a ".$_POST['email']." con la información de su cuenta.";
		//print $envio;
	}
}


?>

	<div class="col-md-6">
	<h3>Registro de usuarios</h3>
		<div id="warnings">
			<div class="alert alert-info">Los campos marcados con <span style="color:red;"> *</span>  son obligatorios </div>
			<?php 
			if(!empty($errores)){
				foreach($errores as $error){ 
			?>
			<div class="alert alert-danger"><?=$error?></div>
			<?php 	} 
			} 
			if(isset($exito)){ ?>	
			<div class="alert alert-success"><?=$exito?></div>
			<div class="alert alert-success"><?=$correo?></div>
			<?php } ?>
			
		</div>
		
		<form role="form"  action="registro.php"  method="post" id="form-registro"> 
			<div class="form-group" id="correo">
				<label for="email" class="control-label">Email<span style="color:red;"> *</span></label>
				<input type="email" class="form-control"  id="email" name="email" placeholder="Email">
				
			</div>
			<div class="form-group" id="name">
				<label for="nombre" class="control-label">Nombre<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="nombre" name="nombre" placeholder="Nombre(s)">
			</div>
			<div class="form-group" id="paterno">
				<label for="apellido_p" class="control-label">Apellido Paterno<span style="color:red;"> *</span></label>
				<input type="text" class="form-control"  id="apellido_p" name="apellido_p" placeholder="Apellido Paterno">
				
			</div>
			<div class="form-group">
				<label for="apellido_p" class="control-label">Apellido Materno</label>
				<input type="text" class="form-control"  id="apellido_m'" name = "apellido_m" placeholder="Apellido Materno">
			</div>
			<div class="form-group">
			<label for="inst" class="control-label">¿Es instructor?</label>
			<select class="form-control" id="inst" name="inst" style="width:14%">
				<option value="0" selected>No</option>
				<option value="1">Si</option>
			</select>
			</div>
			<div class="form-group">
			<label for="puesto" class="control-label">Puesto</label>
			<select class="form-control" id="puesto" name="puesto">
					<?php 
					$query = "SELECT * FROM puesto order by puesto asc";
					global $mysqli;
					$result = $mysqli -> query($query);
						while($row = $result -> fetch_array()){
					?>
					
					<option value="<?=$row['id']?>"><?=$row['puesto']?></option>
					
					
					<?php  } //Fin del while?>
			</select>
			</div>
			<div class="form-group">
			<label for="rol" class="control-label">Rol</label>
			<select class="form-control" id="" name="rol" style="width:30%">
				<option value="0" selected>Empleado</option>
				<option value="1">Administrador</option>
			</select>
			</div>
			<div class="form-group">
			  <input type="submit" class="btn btn-primary" value="Enviar"></input>
			 </div>
		</form>
	</div>
	<div class="col-md-4">
	<p>Dar de alta a un nuevo usuario del sistema, en caso de que se trate de un empleado dado de 
		alta previamente y solo se requiera activarlo da click <a href="modifica_empleado.php">aquí</a></p>
	</div>
	
<?php include '../estructura/footer.php';?>
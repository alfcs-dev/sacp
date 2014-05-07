<?php include_once('/home/alfcasta/public_html/sacp/lib/includes_sacp.php');
redireccion_conectado();
if(isset($_POST['email'])){
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	if(!existe_usuario($email)){
		$errores[] = "No existe el usuario con el correo indicado";
	}
	elseif(!usuario_activo($email)){
		$errores[] = "La cuenta relacionada con el correo proporcionado no se encuentra activada verifica tu correo por tu codigo de activación o comunicacte con el administrador del sistema";
	}
	
	else{
		$login = login($email, $password);
			if(!$login){
				$errores[] = 'El usuario o password ingresados son incorrectos';
			}
			else{
				$rol = $login['rol'];
				$id = $login['id'];
				 if($rol == 1){
				 	$_SESSION['id'] = $id; //Crea la sesion
					$_SESSION['rol'] = "admin";
				 }
				 else {
					$_SESSION['id'] = $login['id'];
				 }
		header('Location: index.php');//redirige a index
		exit();
		
			}
			
	}
	
	
}

include_once('/home/alfcasta/public_html/sacp/estructura/head.php');?>

<?php if(!empty($errores)){
			foreach($errores as $error){
		?>
	<div class="alert alert-danger"><?=$error?></div>
<?php 	} 
	} 
?>
    <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Ingresa tus datos</h2>
		<div class="input-group">
		 <span class="input-group-addon">@</span>
		 <input type="text" id="email" class="form-control" placeholder="Email" name="email" value="<?if(isset($email)){echo $email;}?>">
        </div>
		
		 <input type="password" id="password" class="form-control" placeholder="Password" name="password" >

		
        <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
    </form>



<?php

include_once('/home/alfcasta/public_html/sacp/estructura/footer.php');

?>



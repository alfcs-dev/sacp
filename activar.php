<?php 
include 'estructura/head.php';
redireccion_conectado();
if(isset($_GET['email'], $_GET['codigo_correo']) === true) {

	$email  = $_GET['email'];
	$codigo = $_GET['codigo_correo'];
	
	if(existe_usuario($email) === false) {
		$errores[] = 'Algo salio mal y no podemos encontrar tu direccion de correo electronico';
	} elseif (activar($email, $codigo) === false) {
		$errores[] = "Tenemos problemas activando tu cuenta";
	} 
	
	
	if(!empty($errores)){
		foreach($errores as $error){ ?>
			<div class="alert alert-danger"><?=$error?></div>
	<?php 	} 
		} 
	else { ?>
	<div class="alert alert-success">Tu cuenta ha sido activada con exito puedes iniciar sesion dando clic en el botón de la esquina superior derecha</div>
<? 	} 
}
else{
header('Location: index.php');
exit();
}
	
include 'estructura/footer.php';?>
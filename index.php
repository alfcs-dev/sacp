<?php include 'estructura/head.php';?>
  <div class="col-md-8">
			<?php if(logged_in()){?>
			<h3> <?=$datos_usuario['nombre']?>, bienvenido al S.A.C.P. </h3>
			<p>
			Selecciona una opción del menú superior para comenzar a trabajar
			</p>
			<?php } else { ?>
			<h3>S.A.C.P.</h3>
			<p>
			
			Has ingresado al sistema de administración de la capacitación del personal, para iniciar sesión da clic en el botón iniciar sesión para comenzar a trabajar
			
			</p>
			 <a data-toggle="modal" href="#myModal"  class="btn btn-info navbar-btn ">Iniciar Sesión</a>
			<?php } ?>
		</div>
        <div class="col-md-4"></div>
      
   
	
       
<?php include 'estructura/footer.php';?>
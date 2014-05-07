<header>
	<div role="navigation" class="navbar navbar-inverse navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#barra">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Sistema de Administración de la Capacitación del Personal</a>
		</div>
		
				<div class="collapse navbar-collapse navbar-right" id="barra">
					
						<?php
						if(!logged_in()){?>
						
						   <a data-toggle="modal" href="#myModal"  class="btn btn-info navbar-btn ">Iniciar Sesión</a>
						<?php } else { ?>
						<div class="btn-group">
							<button type="button" class="btn btn-primary navbar-btn"><?=$datos_usuario['nombre'].' '.$datos_usuario['a_paterno']?></button>
							<button type="button" class="btn btn-primary dropdown-toggle navbar-btn" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span>
							</button>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="#"><span class="glyphicon glyphicon-edit"></span> Editar información</a></li>
								<li><a href="http://alfcastaneda.com/sacp/historial.php"> <span class="glyphicon glyphicon-header"></span> Ver historial de cursos</a></li>
								<li class="divider"></li>
								<li><a href="http://alfcastaneda.com/sacp/logout.php"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
							  </ul>
						</div>
						
					
							
							<?php  } ?>
					
					
				</div>
	</div>
	</div>
</header>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title">Introduce tus datos</h4>
			 
			</div>
			<form class="form-horizontal" role="form" action="login.php" method="post" id="form-login"> 
				<div class="modal-body">
					<div class="form-group">
						<label for="email" class="col-lg-2 control-label">Email</label>
						<div class="col-lg-10">
							<input type="email" class="form-control"  id="email" name="email" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-lg-2 control-label">Password</label>
						<div class="col-lg-10">
							<input type="password" class="form-control" id="password" placeholder="password" name="password">
						</div>
					</div>
				</div>
				
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				  <button type="submit" class="btn btn-primary">Enviar</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



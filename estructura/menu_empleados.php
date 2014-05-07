<div class="menu">
	<!-- Static navbar -->
	<div class="navbar navbar-default">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menus">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
        </div>
		<div class="navbar-collapse collapse" id="menus">
			<ul class="nav navbar-nav">
				<li><a href="catalogo_cursos.php">Cátalogo de cursos</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Evaluaciones<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">Encuestas de satisfacción</li>
						<li><a href="encuestas.php">Responder encuestas</a></li>
						<?php if($datos_usuario['es_instructor'] == 1){ ?>
						<li class="divider"></li>
						<li class="dropdown-header">Evaluar cursos</li>
						<li><a href="http://alfcastaneda.com/sacp/administrador/calificaciones.php">Califica tus cursos</a></li>
						<li class="divider"></li>
						<li class="dropdown-header">Asistencia</li>
						<li><a href="http://alfcastaneda.com/sacp/asistencia.php">Toma asistencia</a></li>
						<?php } ?>
					</ul>
				</li>
			</ul>
        </div><!--/.nav-collapse -->
    </div> 
</div>

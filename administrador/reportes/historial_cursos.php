<?php
include '../../estructura/head.php';
acceso_admin();?>
<div class="col-md-12">
	<div id="warnings">	
		<?php if(!empty($errores)){
				foreach($errores as $error){ ?>
					<div class="alert alert-danger"><?=$error?></div>
		<?php 	} 
		} 
		if(isset($exito)){ ?>	
			<div class="alert alert-success"><?=$exito?></div>
		<?php }
		if(!empty($correos)){ 
			foreach($correos as $correo){ ?>	
				<div class="alert alert-info"><?=$correo?></div>
		<?php } 
		} ?>
	</div>
	<div class="form-group">
		<select  class="form-control" id="reporte_calif_cursos" style="width: 45%;">
			<option>SELECCIONA UNA CAPACITACIÓN</option>
						<?php
				$query = "SELECT pc.id, c.nom_curso, pc.fecha_inicio, pc.fecha_final
							FROM alfcasta_tesis.prog_capacitacion pc
							JOIN cursos c ON pc.curso_id = c.id";
				$seleccionada = "";
				$result = $mysqli -> query($query);
					while($row = $result -> fetch_assoc()){
						if(isset($id_capacitacion)){
						    if($row['id'] == $id_capacitacion){
							$seleccionada = "selected='selected'";
							}
							else{$seleccionada = "";}
						}
			?>
			<option value="<?=$row['id']?>" <?=$seleccionada?>><?=$row['id']?>&nbsp;||&nbsp;<?=$row['nom_curso']?>&nbsp;||&nbsp;Inicio:<?=$row['fecha_inicio']?> </option>
			<?php  } //Fin del while?>
		</select>
	</div>

		<div class="panel panel-primary" id="panel-datos" style="display:none;">
			<div id="titulo" class="panel-heading">
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6" >
						<table id="info-1" class="table table-bordered">
						</table>
					</div>
					<div class="col-md-6">
						<table id="info-2" class="table table-bordered">
						</table>
					</div>
				</div>
			</div>
		</div>
	<div class="panel panel-primary" id="panel-tabla" style="display:none;">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<table class="table table-hover  table-bordered" id="historial1">	
			</table>
		</div>
	</div>
</div>

<?php include '../../estructura/footer.php';?>
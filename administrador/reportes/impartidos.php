<?php
include('../../estructura/head.php');
acceso_admin();
?>
<div class="col-md-12" style="min-height:600px;">
	<h3>Generación de reportes</h3>
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
			if(!empty($correos)){ 
				foreach($correos as $correo){
			?>	
			<div class="alert alert-info"><?=$correo?></div>
			<?php } 
			
			} ?>
			
	</div>
		<form role="form"  action="impartidos.php"  method="post" id="form_capacitaciones_por_fecha"> 
			<label for="fecha_inicio_capacitacion" class="control-label">Fechas de la capacitacion </label>
			<div class="form-group form-inline" id="fechas">
				<input type="text" class="form-control" id="fecha_inicio_reporte" name="fecha_inicio_reporte" style="width:15%" placeholder="Fecha de inicio"/>
				<input type="text" class="form-control"  id="fecha_final_reporte" name="fecha_final_reporte" style="width:15%" placeholder="Fecha de termino"/>
				<label class="checkbox-inline">
				<input type="checkbox" id="promedios"> ¿Deseas el reporte con promedios?
				</label>
				<input type="button" class="btn btn-info" id="busca_por_fecha" value="BUSCAR"></input>
			</div>

		</form>
		<div id="cargando">
		</div>
		<table class="table table-striped table-bordered" id="tabla-reporte"> </table>
		<!--input type="button" value="GENERAR PDF" class="btn btn-default"></input-->

</div>
<?php 
include('../../estructura/footer.php');
?>
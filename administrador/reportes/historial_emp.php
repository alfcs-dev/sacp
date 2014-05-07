<?php
include '../../estructura/head.php';
acceso_admin();
?>
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
	<div class="ui-widget" style=" font-size: 1em !important; ">
		<div class="form-group" style="width:200px; float:left;">
			<label for="calif_por_num_emp" class="control-label" >Número</label>
			<input  style="width:85%" class="form-control"  id="calif_por_num_emp" type="text" ></input>
		</div>
		<div class="form-group" style=" margin-left: 25px;  width: 481px;">
			<label for="calif_por_ap_paterno" class="control-label">Apellido Paterno</label>
			<input  style="width:50%" class="form-control"  id="calif_por_ap_paterno" type="text"></input>
		</div>
	</div>
	<table class="table table-hover table-bordered" id="historial">
		
	</table>
</div>

<?php include '../../estructura/footer.php';?>
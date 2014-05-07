<?php 
include 'estructura/head.php';
acceso_protegido();
	if(!empty($_POST)){
		$datos_encuesta['eval_cont']				= $_POST['cont_curso'];
		$datos_encuesta['eval_apoyo_didactico']		= $_POST['mat_curso'];
		$datos_encuesta['eval_aplica_trabajo']		= $_POST['aplicacion_curso'];
		$datos_encuesta['comentarios']				= $_POST['comentarios'];
		$datos_encuesta['id_capacitacion'] 			= $_POST['select_caps_inscrito'];
		if(guarda_encuesta($datos_encuesta)){
			$exito = "Se guardo con exito la encuesta";
		}
		else{
			$errores[] = "Ocurrio un error al guardar la encuesta";
		}
		$capacitacion_id		= $_POST['select_caps_inscrito'];
		$datos_evaluacion['calif_instruc_explicacion']	= $_POST['cap_instructor'];
		$datos_evaluacion['calif_instruc_rel']			= $_POST['inst_cont_curso'];
		$datos_evaluacion['calif_instruc_dom']			= $_POST['con_instructor'];
		$datos_evaluacion['contesto_encuesta']			= 1;
		if(evalua_instructor($datos_evaluacion, $datos_usuario['id'], $capacitacion_id)){
			$exito = "Se guardo con exito la encuesta";
		}
		else{
			$errores[] = "Ocurrio un error al guardar la evaluacion";
		}
	}
?>
<style>
form p{
font-weight: bold;
}
</style>
<div class="col-md-8">
	<div id="warnings">	
	<?php 
		if(!empty($errores)){
			foreach($errores as $error){ ?>
				<div class="alert alert-danger"><?=$error?></div>
				<?php 	} 
			} 
		if(isset($exito)){ ?>	
			<div class="alert alert-success"><?=$exito?></div>
			<?php } ?>
	</div>
<h3>SELECCIONA UNO DE TUS CURSOS</h3>
<form role="form"  action="encuestas.php"  method="post" id="form_encuestas">	
	<div class="form-group">
		<label for="select_caps_inscrito"></label>
		<select class="form-control" id="select_caps_inscrito" name="select_caps_inscrito">
			<option value=" ">SELECCIONA UNO</option>
			<?php 
			$sql = "SELECT id_capacitacion_programada, curso, inicio FROM inscritos WHERE id_empleado = ".$datos_usuario['id']." AND encuesta = 0";		
			if($resultado = $mysqli -> query($sql)){
				while($fila = $resultado -> fetch_assoc()){ ?>
					<option value="<?=$fila['id_capacitacion_programada']?>"><?=$fila['curso']?> || <?=$fila['inicio']?></option>
			<?php }
			}
			?>
		</select>
	</div>
	<div class="panel panel-primary" id="encuesta_instructor" style="display:none;">
		<div class="panel-heading">Evalua instructor</div>
		<div class="panel-body">
		<p>Seleccione la opción que mejor describa su opinión</p>
			<div class="form-group">
			<p>Capacidad del instructor para explicar el tema: </p>
				<label class="radio-inline">
					<input type="radio" name="cap_instructor" id="cap_instructor1" value="10"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="cap_instructor"  id="cap_instructor2" value="9"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="cap_instructor"  id="cap_instructor3" value="7"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="cap_instructor"  id="cap_instructor4" value="6"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="cap_instructor" id="cap_instructor5" value="5"> Muy Malo
				</label>
			</div>
			<div class="form-group">
			<p>Conocimiento del instructor sobre el tema: </p>
				<label class="radio-inline">
					<input type="radio" name="con_instructor" id="con_instructor1" value="10"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="con_instructor"  id="con_instructor2" value="9"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="con_instructor"  id="con_instructor" value="7"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="con_instructor"  id="con_instructor4" value="6"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="con_instructor" id="con_instructor5" value="5"> Muy Malo
				</label>
			</div>
			<div class="form-group">
			<p>Conocimiento del instructor sobre el tema: </p>
				<label class="radio-inline">
					<input type="radio" name="cont_curso" id="cont_curso1" value="10"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso2" value="9"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso3" value="7"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso4" value="6"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="cont_curso" id="cont_curso5" value="5"> Muy Malo
				</label>
			</div>
			<div class="form-group">
			<p>Relación entre instructor y contenido del curso </p>
				<label class="radio-inline">
					<input type="radio" name="inst_cont_curso" id="inst_cont_curso1" value="10"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="inst_cont_curso"  id="inst_cont_curso2" value="9"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="inst_cont_curso"  id="inst_cont_curso3" value="7"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="inst_cont_curso"  id="inst_cont_curso4" value="6"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="inst_cont_curso" id="inst_cont_curso5" value="5"> Muy Malo
				</label>
			</div>
		</div>
	</div>
	<div class="panel panel-primary" id="encuesta_capacitacion" style="display:none;">
		<div class="panel-heading">Evalua capacitación</div>
		<div class="panel-body">
		<p>Seleccione la opción que mejor describa su opinión</p>
			<div class="form-group">
				<p>Contenido del curso: </p>
				<label class="radio-inline">
					<input type="radio" name="cont_curso" id="cont_curso1" value="4"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso2" value="3"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso3" value="2"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="cont_curso"  id="cont_curso4" value="1"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="cont_curso" id="cont_curso5" value="0"> Muy Malo
				</label>
			</div>
			<div class="form-group">
				<p>Material de apoyo: </p>
				<label class="radio-inline">
					<input type="radio" name="mat_curso" id="mat_curso1" value="4"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="mat_curso"  id="mat_curso2" value="3"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="mat_curso"  id="mat_curso3" value="2"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="mat_curso"  id="mat_curso4" value="1"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="mat_curso" id="mat_curso5" value="0"> Muy Malo
				</label>
			</div>
			<div class="form-group">
				<p>Aplicación en el área de trabajo: </p>
				<label class="radio-inline">
					<input type="radio" name="aplicacion_curso" id="aplicacion_curso1" value="4"> Excelente
				</label>
				<label class="radio-inline">
					<input type="radio" name="aplicacion_curso"  id="aplicacion_curso2" value="3"> Bueno
				</label>
				<label class="radio-inline">
					<input type="radio" name="aplicacion_curso"  id="aplicacion_curso3" value="2"> Regular
				</label>
				<label class="radio-inline">
					<input type="radio" name="aplicacion_curso"  id="aplicacion_curso4" value="1"> Malo
				</label>
				<label class="radio-inline">
					<input type="radio"  name="aplicacion_curso" id="aplicacion_curso5" value="0"> Muy Malo
				</label>
			</div>
			<div class="form-group">
				<label for="comentarios">Escribe un comentario</label>
				<textarea name="comentarios" id="comentarios" class="form-control" rows="3"></textarea>
			</div>
		</div>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Enviar encuesta" id="enviar-encuesta" style="display:none;"></input>
	</div>
</form>
</div>

<?php 
include 'estructura/footer.php';
?>
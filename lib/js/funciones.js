
/**************************FUNCIONES PARA SELECCION***************************************/
function selecciona_curso(id, nom_curso, modalidad, duracion){ //Seleccionar cursos para llenar formulario
	$(function() {
		$('#actualizar').val(1);
		$("#nombre_curso").val(nom_curso);
		$("#modalidad").val(modalidad);
		$("#duracion").val(duracion);
		$('#id_curso').val(id);
	});
}
function selecciona_sala(id, sala, regionales_id, capacidad, videoconferencia, canon, proyeccion, pizarron, observaciones ){//llenar formulario con datos de salas
	$(function() {
	
		$('#actualizar').val(1);
		$('#id_sala').val(id);
		$("#nombre_sala").val(sala);
		$("#sucursal").val(regionales_id);
		$("#observaciones").html(observaciones);
		$("#capacidad").val(capacidad);
		if(videoconferencia == 1){
			$('#videoconferencia').prop('checked', true);
		}
		else{
			$('#videoconferencia').prop('checked', false);
		}
		if(canon == 1){
			$('#canon').prop('checked', true);
	   	}
		else{
			$('#canon').prop('checked', false);
		}
		if(proyeccion == 1){
			$('#proyeccion').prop('checked', true);
			}
		else{
			$('#proyeccion').prop('checked', false);
		}
		if(pizarron == 1){	
			$('#pizarron').prop('checked', true);
		}
		else{
			$('#pizarron').prop('checked', false);
		}
		
	});
}

function selecciona_sucursal(id, clave,  descripcion, diferencia, estado){ //Datos de sucursal para llenar formulario
	$(function() {
		$('#actualizar').val(1);
		$("#nombre_sucursal").val(descripcion);
		$("#id_sucursal").val(id);
		$("#dif_horario").val(diferencia);
		$('#estado').val(estado);
		$('#cve_region').val(clave);
	});
}
/************************************FIN FUNCIONES SELECCION**********************************************/
/*****************************************FUNCIONES VARIAS******************************************/
function elimina_fila(id){
	if(confirm('¿Deseas cancelar la inscripcion para este empleado?')){
		$('#'+id).remove();
	}
	
}
function baja_capacitacion(id_emp, id_cap_prog){
	if(confirm('¿Deseas dar de baja a a empleado de esta capacitacion?')){
		$.ajax({
			url: '../lib/funciones/manejador_consultas.php',
			type: 'POST',
			data: {'id_emp_baja': id_emp, 'id_cap_prog_baja': id_cap_prog },
			dataType: "json"
			}).done(function(data){
				alert('Hecho');
				$('#muestra_inscripciones').html('');
				$('#muestra_inscripciones').html(data);
				
				});
	}
}


/******************************************FIN FUNCIONES VARIAS***********************************/
$(document).ready(function (){
	/********************************ENCUESTAS***********************************************/
		$('#select_caps_inscrito').change(function(){
			$('#id_capacitacion').val($(this).val());
			$('#encuesta_instructor').show();
			$('#encuesta_capacitacion').show();
			$('#enviar-encuesta').show();
		});
	/********************************FIN ENCUESTAS***********************************************/
	
	/*********************FUNCIÓNES DE VALIDACIÓN PARA LA FORMA DE USUARIOS******************************/
	$('#form-registro').submit(function(event){
		if($(this.email).val() == ""){
			$('#correo').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo email no puede estar vacío</div>');
		}
		if($(this.nombre).val() == ""){
			$('#name').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo nombre no puede estar vacío</div>');
		}
		if($(this.apellido_p).val() == ""){
			$('#paterno').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo de apellido paterno no puede estar vacío</div>');
		}
	});
	
	$(function() {
		$('#eliminar-usuario').click(function() {
			if(confirm('Estas seguro que deseas eliminar al usuario '+$('#email').val()+' del sistema')){
			$('#borrar').val(1);
			$('#form-registro').submit();
			}
		});
	
	});
/*********************FIN FUNCIONES USUARIOS*******************************************************/
	
/*********************FUNCIÓNES DE VALIDACIÓN PARA LA FORMA DE CURSOS******************************/
	$('#form-curso').submit(function(event){
		if($(this.nombre_curso).val() == ""){
			$('#name-curso').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo nombre del curso no puede estar vacío</div>');
		}
		if($(this.duracion).val() == ""){
			$('#duracion_hrs').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo duración no puede estar vacío</div>');
		}
	});
	$(function() {
		$('#eliminar-curso').click(function() {
			if(confirm('Estas seguro que deseas eliminar el curso '+$('#nombre_curso').val()+' del sistema')){
			$('#borrar').val(1);
			$('#actualizar').val(0);
			$('#form-curso').submit();
			}
		});
	
	});
	
	/***************************FIN FUNCIONES CURSOS****************************************************************/
		
	/*********************FUNCIÓNES DE VALIDACIÓN PARA LA FORMA DE SUCURSALEs******************************/
	$('#form-sucursales').submit(function(event){
		if($(this.nombre_sucursal).val() == ""){
			$('#name-sucursal').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo nombre de la sucursal no puede estar vacío</div>');
		}
		if($(this.cve_region).val() == ""){
			$('#clave_region').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo clave de la region no puede estar vacío</div>');
		}
	});
	$(function() {
		$('#eliminar-sucursal').click(function() {
			if(confirm('Estas seguro que deseas eliminar la sucursal '+$('#nombre_sucursal').val()+' del sistema')){
			$('#borrar').val(1);
			$('#actualizar').val(0);
			$('#form-sucursales').submit();
			}
		});
	
	});
	
	/***************************FIN FUNCIONES SUCURSALES****************************************************************/
	
	/***************************VALIDACION CALIFICACIONES****************************************************************/
	$('#form_calif_previas').submit(function(event){
		$("input[type='text'][name='calif_alum_prev[]']").each(function( index ) {
			if(isNaN($(this).val()) || $(this).val() == ""){
				alert('Todas las calificaciones tienen que ser numericas');
				event.preventDefault();
			}	
		});
		$("input[type='text'][name='calif_aplicacion_alum_prev[]']").each(function( index ) {
			if(isNaN($(this).val()) || $(this).val() == ""){
				alert('Todas las calificaciones tienen que ser numericas');
				event.preventDefault();
			}	
		});
	});
	$('#form_calificaciones').submit(function(event){
		$("input[type='text'][name='calif_alum_post[]']").each(function( index ) {
			if(isNaN($(this).val()) || $(this).val() == ""){
				alert('Todas las calificaciones tienen que ser numericas');
				event.preventDefault();
			}	
		});
		$("input[type='text'][name='calif_aplicacion_alum_post[]']").each(function( index ) {
			if(isNaN($(this).val()) || $(this).val() == ""){
				alert('Todas las calificaciones tienen que ser numericas');
				event.preventDefault();
			}	
		});
	});
	
	/***************************FIN VALIDACION CALIFICACIONES****************************************************************/
		
	/*********************FUNCIÓNES DE VALIDACIÓN PARA LA FORMA DE DE SALAS******************************/
	$('#form-salas').submit(function(event){
		if($(this.nombre_sala).val() == ""){
			$('#name-sala').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">El campo nombre de la sala no puede estar vacío</div>');
		}
		if($(this.capacidad).val() == 0){
			$('#capacidad_prs').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">la capacidad de la sala tiene que ser mayor a cero</div>');
		}
	});
	$(function() {
		$('#eliminar-sala').click(function() {
			if(confirm('Estas seguro que deseas eliminar la sala '+$('#nombre_sala').val()+' del sistema')){
			$('#borrar').val(1);
			$('#actualizar').val(0);
			$('#form-sala').submit();
			}
		});
	
	});
	
	$('#select-estado').change(function() {
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'select_regional': $(this).val()},
				dataType: "json"
				}).done(function(data){
					$('#tabla_salas').html('<th>NOMBRE DEL LA SALA</th><th>CAPACIDAD</th>');
					$('#tabla_salas').append(data);
					});
			
			}
			else {alert('Tienes que seleccionar un curso');}
		});
	/***************************FIN FUNCIONES SALAS****************************************************************/
	
	/*********************************FUNCIONES PARA BUSQUEDA DE DATOS**********************************************/
	$(function() {
		$( "#modif_emp_num" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?modif_emp=0",
			minLength: 1,
			select: function( event, ui ) {
				$("#id_empleado").val(ui.item.value);
				$("input#email").val(ui.item.email);
				$("input#nombre").val(ui.item.nombre);
				$("input#apellido_p").val(ui.item.apaterno);
				$("input#apellido_m").val(ui.item.amaterno);
				$("select#puesto").val(ui.item.id_puesto);
				$("select#inst").val(ui.item.es_instructor);
				$("select#rol").val(ui.item.rol);
				$("#form-registro").show();
			}
		});
	});
	
	$(function() {
		$( "#modif_emp_paterno" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?modif_emp=1",
			minLength: 2,
			select: function( event, ui ) {
			
				$("#id_empleado").val(ui.item.id);
				$("input#email").val(ui.item.email);
				$("input#nombre").val(ui.item.nombre);
				$("input#apellido_p").val(ui.item.apaterno);
				$("input#apellido_m").val(ui.item.amaterno);
				$("select#puesto").val(ui.item.id_puesto);
				$("select#inst").val(ui.item.es_instructor);
				$("select#rol").val(ui.item.rol);
				$("#form-registro").show();
			}
		});
	});
	
	$(function() {
		$( "#inscribe_num_emp" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?asig_cap=0",
			minLength: 1,
			select: function( event, ui ) {
				if(confirm('¿Quieres inscribir a '+ui.item.label+' esta capacitación?')){
					$('#tabla-inscripciones').append('<tr id='+ui.item.id+'><td>'+ui.item.id+'<td>'+ui.item.label+'</td><td><a href="javascript:elimina_fila('+ui.item.id+')">Cancelar inscripcion</a></td><input type="hidden" name="id_emp_inscripcion[]" value="'+ui.item.id+'"></tr>')
					$('#enviar-inscripciones').show();
					$('#contendor-lista').show();
				}
			}
		});
	});
	
	$(function() {
		$( "#inscribe_emp_paterno" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?asig_cap=1",
			minLength: 2,
			select: function( event, ui ) {
				if(confirm('¿Quieres inscribir a '+ui.item.label+' esta capacitación?')){
					$('#tabla-inscripciones').append('<tr id='+ui.item.id+'><td>'+ui.item.id+'<td>'+ui.item.label+'</td><td><a href="javascript:elimina_fila('+ui.item.id+')">Cancelar inscripcion</a></td><input type="hidden" name="id_emp_inscripcion[]" value="'+ui.item.id+'"></tr>')
					$('#enviar-inscripciones').show();
					$('#contendor-lista').show();
				}
			}
		});
	});
	
	
	$(function() {
		$( "#inscribe_por_num_emp" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?asig_emp=0",
			minLength: 1,
			select: function( event, ui ) {
				$('#tabla_datos_empleado').html('');
				$('#tabla_datos_empleado').append('<tr><td><strong>No. Emp.</strong></td><td>'+ui.item.id+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Nombre Completo</strong></td><td>'+ui.item.label+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Puesto</strong></td><td>'+ui.item.puesto+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Correo </strong></td><td>'+ui.item.email+'</td></tr>');
				$('#id_emp').val(ui.item.id);
				$('#submit-insc').show();
				$.ajax({
					url: '/sacp/lib/funciones/manejador_consultas.php',
					type: 'POST',
					data: {'cursos_inscrito': ui.item.value},
					dataType: "json"
					}).done(function(data){
						$('#encabezado').show();
						$('#muestra_inscripciones').html('');
						$('#caps_disponibles').html('');
						$('#muestra_inscripciones').append(data.tabla);
						$('#caps_disponibles').append(data.caps);
						$('#caps_disponibles').append(data.cupos);
						});
			}
		});
	});
	
	$(function() {
		$( "#inscribe_por_emp_paterno" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?asig_emp=1",
			minLength: 2,
			select: function( event, ui ) {
			$('#tabla_datos_empleado').html('');
				$('#tabla_datos_empleado').append('<tr><td><strong>No. Emp.</strong></td><td>'+ui.item.id+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Nombre Completo</strong></td><td>'+ui.item.label+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Puesto</strong></td><td>'+ui.item.puesto+'</td></tr>');
				$('#tabla_datos_empleado').append('<tr><td><strong>Correo </strong></td><td>'+ui.item.email+'</td></tr>');
				$('#id_emp').val(ui.item.id);
				$('#submit-insc').show();
				$.ajax({
					url: '/sacp/lib/funciones/manejador_consultas.php',
					type: 'POST',
					data: {'cursos_inscrito': ui.item.id},
					dataType: "json"
					}).done(function(data){
					$('#encabezado').show();
						$('#muestra_inscripciones').html('');
						$('#caps_disponibles').html('');
						$('#muestra_inscripciones').append(data.tabla);
						$('#caps_disponibles').append(data.caps);
						$('#caps_disponibles').append(data.cupos);
						});
			}
		});
	});

	
	$(function() {
		$( "#calif_por_num_emp" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?hist_emp=0",
			minLength: 1,
			select: function( event, ui ) {
				$.ajax({
					url: '/sacp/lib/funciones/manejador_consultas.php',
					type: 'POST',
					data: {'hist_calif_emp': ui.item.value},
					dataType: "json",
					beforeSend: function() {
						$("#historial").html("<div>CARGANDO REPORTE </div><img src='../../img/ajax-loader.gif' />");
					}
					}).done(function(data){
						$('#historial').html(data);
						});
			}
		});
	});
	
		$(function() {
		$( "#calif_por_ap_paterno" ).autocomplete({
			source: "/sacp/lib/funciones/search.php?hist_emp=1",
			minLength: 2,
			select: function( event, ui ) {
				$.ajax({
					url: '/sacp/lib/funciones/manejador_consultas.php',
					type: 'POST',
					data: {'hist_calif_emp': ui.item.id},
					dataType: "json",
					beforeSend: function() {
						$("#historial").html("<div>CARGANDO REPORTE </div><img src='../../img/ajax-loader.gif' />");
					}
					}).done(function(data){
						$('#historial').html(data);
						});
			}
		});
	});
	
	/*FIN FUNCIONES BUSQUEDA*/
/*****************************************FUNCIONES PARA PROGRAMAR CAPACITACIONES******************************************/
	$('#curso_a_programar').change(function() {
	$('#tabla_datos_curso').html("<tr><th>CURSO</th><th>DURACION</th><th>MODALIDAD</th></tr>");
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'curso_a_programar': $(this).val()},
				dataType: "json"
			}).done(function(data){
				$('#tabla_datos_curso').append(data);
				})
			}
			else {alert('Tienes que seleccionar un curso');}
	});

	$('#suc_capacitacion').change(function() {
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'suc_capacitacion': $(this).val()},
				dataType: "json"
			}).done(function(data){
				$('#salas_disp').html(data.opciones);
				})
			}
			else {alert('Tienes que seleccionar un curso');}
	});

	$('#salas_disp').change(function() {
		$('#tabla_sala').html("");
		$.ajax({
			url: '../lib/funciones/manejador_consultas.php',
			type: 'POST',
			data: {'carac_salas': $(this).val()},
			dataType: "json"
		}).done(function(data){
			$('#tabla_sala').append(data);
			$('#caracteristicas_sala').show();
		})

	});

	$(function() {
		$( "#fecha_inicio_capacitacion" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {
				$( "#fecha_inicio_capacitacion" ).datepicker( "option", "minDate", selectedDate );
				}
		});
		$( "#fecha_final_capacitacion" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {
				$( "#fecha_final_capacitacion" ).datepicker( "option", "maxDate", selectedDate );
				}
		});
	});
	
	$('#form_programa_capacitaciones').submit(function(event){
		if($(this.fecha_inicio_capacitacion).val() == "" || $(this.fecha_final_capacitacion).val() == ""){
			$('#fechas').addClass('has-error');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">Tienes que seleccionar fechas de inicio y termino de la capacitacion</div>');
		}
		if($(this.salas_disp).val() == 0){
			alert('Tienes que seleccionar una sala');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">Tienes que seleccionar una sala</div>');
		}
		if($(this.curso_a_programar).val() == " "){
			alert('Tienes que seleccionar un curso');
			event.preventDefault();
			$('#warnings').append('<div class="alert alert-danger">Tienes que seleccionar el curso a programar</div>');
		}
		
	});
/*******************************************FIN FUNCIONES PROGRAMA CAPACITACIONES*******************************************/


/*****************************************FUNCIONES INSCRIPCIONES******************************************/

	$('#capacitacion_a_asignar').change(function() {
		$('#tabla_datos_capacitacion').html(" ");
		$('#tabla_empleados_inscritos').html('<tr><th>No.</th><th>Nombre</th><th>Puesto</th></tr>');
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'capacitacion_a_asignar': $(this).val()},
				dataType: "json"
			}).done(function(data){
				$('#tabla_datos_capacitacion').append(data.datos_capacitacion);
				$('#tabla_empleados_inscritos').append(data.emp_inscritos);
				})
			}
			else {alert('Tienes que seleccionar una capacitación');}
	});
	
	$('#form_asig_capacitacion').submit(function(event){
		if($(this.capacitacion_a_asignar).val() == " "){
					alert('Tienes que seleccionar una capacitación programada');
					event.preventDefault();
		}
		var cupo = Number($('#cupo').html());
		var numero_inscripciones = $('#tabla-inscripciones tr').length - 1;
		numero_inscripciones = Number(numero_inscripciones);
		var cupo_definido = cupo - numero_inscripciones;
		cupo_definido = Number(cupo_definido);
		if(cupo_definido <= 0){
			alert('El número de inscripciones solicitadas excede el cupo de la sala');
			event.preventDefault();
		}

	});

/************************************ FIN FUNCIONES INSCRIPCIONES******************************************/	
/*******************CALIF PREVIAS********************/
	$('#cap_calif_previas').change(function() {
		$('#asignar-calificaciones').html('<tr><th>#</th><th>Nombre</th><th>Teorica previa</th><th>Aplicación previa</th></tr>');
		$('#asignar-calificaciones').show();
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'calif_previa': $(this).val()},
				dataType: "json"
				}).done(function(data){
					$('#asignar-calificaciones').append(data);
					$('#envia_previas').show();
					});
		}
		else {alert('Tienes que seleccionar un curso');}
	});
/********************FIN CALIF PREVIAS***************/
/*******************CALIFICACIONES********************/
	$('#cap_calif').change(function() {
		$('#asignar-calificaciones').html('<tr><th>#</th><th>Nombre</th><th>Teorica </th><th>Aplicación </th></tr>');
		$('#asignar-calificaciones').show();
		if($(this).val() != " "){
			$.ajax({
				url: '../lib/funciones/manejador_consultas.php',
				type: 'POST',
				data: {'calificaciones': $(this).val()},
				dataType: "json"
				}).done(function(data){
					$('#asignar-calificaciones').append(data);
					$('#envia_calificaciones').show();
					});
		}
		else {alert('Tienes que seleccionar un curso');}
	});
/********************FIN CALIFICACIONES***************/
/********************REPORTES ***********************/

	$('#busca_por_fecha').click(function(){
		if($("#promedios").is(":checked")){
			var promedios = 1;
		}
		else{
			var promedios = 0;
		}
		//alert(promedios);
		$.ajax({
			url: '../../lib/funciones/manejador_consultas.php',
			type: 'POST',
			dataType: "json",
			data: {'fecha_inicio_reporte':$('#fecha_inicio_reporte').val(),'fecha_final_reporte':$('#fecha_final_reporte').val(), 'promedios': promedios},
			 beforeSend: function() {
						$("#cargando").html("<div>CARGANDO REPORTE </div><img src='../../img/ajax-loader.gif' />");
				}
		}).done(function(data){
			$("#cargando").html(" ");
			$('#tabla-reporte').html(data);
			//alert(data);

		});
		
	
	})

	$(function() {
		$( "#fecha_inicio_reporte" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {
				$( "#fecha_inicio_reporte" ).datepicker( "option", "maxDate", selectedDate );
				}
		});
		$( "#fecha_final_reporte" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {
				$("#fecha_final_reporte" ).datepicker( "option", "maxDate", selectedDate );
				}
		});
	});
/********************REPORTES ***********************/
	$('#reporte_calif_cursos').change(function(){
			$.ajax({
			url: '../../lib/funciones/manejador_consultas.php',
			type: 'POST',
			dataType: "json",
			data: {'reporte_por_curso': $(this).val()},
			beforeSend: function() {
						$("#historial1").html("<div>CARGANDO REPORTE </div><img src='../../img/ajax-loader.gif' />");
					}
					}).done(function(data){
						$('#titulo').html(data.titulo);
						$('#info-1').html(data.info1),
						$('#info-2').html(data.info2),
						$('#historial1').html(data.tabla);
						$('#panel-tabla').show();
						$('#panel-datos').show();
						var tamano = $('#historial1 tr').length - 1;
						var asist = $('#porcentaje_asist').html();
							for(var i=0;i<tamano;i++){
								var j = $('#asist-'+i).html();
								entero = parseInt(j);
								console.log(asist);
								console.log(entero);
									if(entero< asist){
										$('#asist-'+i).addClass('danger');
										console.log("menor");
										}
										else{
										$('#asist-'+i).addClass('success');
										console.log("mayor");
										}
								
							}
						
						alert(tamano);
						});
	});

/*Asistencia*/
	$('#asistencia_curso').change(function(){
		if($(this).val() == 0){
			alert('Tienes que seleccionar una capacitación para pasar asistencia');
		}else{
		$.ajax({
			url: 'lib/funciones/manejador_consultas.php',
			type: 'POST',
			dataType: "json",
			data: {'asistencia_curso': $(this).val()},
			beforeSend: function() {
						$("#pasar_asistencia").html("<div>CARGANDO REPORTE </div><img src='img/ajax-loader.gif' />");
					}
					}).done(function(data){
						$('#pasar_asistencia').html(data);
						$('#pasar_asistencia').show();
						$('#btn-envio').show();
						});
		}
	});


});//Fin funciones.js



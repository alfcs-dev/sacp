<?php

include '../configdb.php';
 if(isset($_GET['asig_emp'])){
	if($_GET['asig_emp']==0){
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, e.id as value, e.id as id, e.email, 
    	e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, p.puesto, e.es_instructor, e.rol
		FROM empleados e  
		JOIN puesto p ON p.id = e.id_puesto
		WHERE e.id LIKE '%$numero%' ORDER BY e.id";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['label']    	= utf8_encode($item2['label']);
			$item2['amaterno'] 	= utf8_encode($item2['amaterno']);
			$item2['apaterno'] 	= utf8_encode($item2['apaterno']);
			$item2['nombre']   	= utf8_encode($item2['nombre']);
			$item2['puesto']	= utf8_encode($item2['puesto']);
			$item2['rol']   	= utf8_encode($item2['rol']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
	else {
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as value, e.id as id, e.email, 
    	e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, p.puesto, e.es_instructor, e.rol
		FROM empleados e  
		JOIN puesto p ON p.id = e.id_puesto
		WHERE e.a_paterno LIKE '%$numero%' ORDER BY e.a_paterno";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['value']	   	= utf8_encode($item2['value']);
			$item2['label']    	= utf8_encode($item2['label']);
			$item2['amaterno'] 	= utf8_encode($item2['amaterno']);
			$item2['apaterno'] 	= utf8_encode($item2['apaterno']);
			$item2['nombre']   	= utf8_encode($item2['nombre']);
			$item2['puesto']	= utf8_encode($item2['puesto']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
}

else if(isset($_GET['modif_emp'])){
	if($_GET['modif_emp']==0){
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, e.id as value, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto, e.es_instructor, e.rol
				FROM empleados e  WHERE e.id LIKE '%$numero%' ORDER BY e.id";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item2['rol']   = utf8_encode($item2['rol']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
	else {
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as value,
		e.id as id, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto,  e.es_instructor, e.rol
				FROM empleados e  WHERE e.a_paterno LIKE '%$numero%' ORDER BY e.a_paterno";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['value']	   = utf8_encode($item2['value']);
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
}
else if(isset($_GET['asig_cap'])){
	if($_GET['asig_cap']==0){
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, e.id as value, e.id as id, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto, e.es_instructor, e.rol
				FROM empleados e  WHERE e.id LIKE '%$numero%' ORDER BY e.id";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item2['rol']   = utf8_encode($item2['rol']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
	else {
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as value,
		e.id as id, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto,  e.es_instructor, e.rol
				FROM empleados e  WHERE e.a_paterno LIKE '%$numero%' ORDER BY e.a_paterno";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['value']	   = utf8_encode($item2['value']);
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
}

else if(isset($_GET['hist_emp'])){
	if($_GET['hist_emp']==0){
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, e.id as value, e.id as id, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto, e.es_instructor, e.rol
				FROM empleados e  WHERE e.id LIKE '%$numero%' ORDER BY e.id";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item2['rol']   = utf8_encode($item2['rol']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
	else {
		$numero = $_GET['term'];
		$query = "SELECT CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as label, CONCAT(e.a_paterno, ' ', e.a_materno, ' ', e.nombre) as value,
		e.id as id, e.email, 
				e.a_paterno as apaterno, e.a_materno as amaterno, e.nombre as nombre, e.id_puesto,  e.es_instructor, e.rol
				FROM empleados e  WHERE e.a_paterno LIKE '%$numero%' ORDER BY e.a_paterno";
		$result = $mysqli -> query($query);
		while($item2 = $result -> fetch_assoc()){
			$item2['value']	   = utf8_encode($item2['value']);
			$item2['label']    = utf8_encode($item2['label']);
			$item2['amaterno'] = utf8_encode($item2['amaterno']);
			$item2['apaterno'] = utf8_encode($item2['apaterno']);
			$item2['nombre']   = utf8_encode($item2['nombre']);
			$item[] = $item2;
		}
	echo json_encode($item);
	}
}
?>
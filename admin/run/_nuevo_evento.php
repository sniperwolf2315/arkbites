<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

	include("_check_login.php");
    require_once("../../include/arkabytes/bbdd.php");

    $nombre = $_REQUEST["nombre"];
    $descripcion = $_REQUEST["descripcion"];
    
    $fecha_prevista = $_REQUEST["fecha_prevista"];
    if ($fecha_prevista == "")
    	$fecha_prevista = NULL;
    else
    	$fecha_prevista = date("Y-m-d", strtotime($fecha_prevista));
        
    $ubicacion = $_REQUEST["ubicacion"];
    $cliente = $_REQUEST["cliente"];
    $proveedor = $_REQUEST["proveedor"];
    $aviso = 0;
    if (isset($_REQUEST["aviso"]))
    	$aviso = $_REQUEST["aviso"];
    
    $fecha_aviso = $_REQUEST["fecha_aviso"];
    if ($fecha_aviso == "")
    	$fecha_aviso = NULL;
    else
	    $fecha_aviso = date("Y-m-d", strtotime($fecha_aviso));
    
    $modificar = "";
    if (isset($_REQUEST["modificar"]))
    	$modificar = $_REQUEST["modificar"];

    $bbdd = new BBDD();
     
    $id_proveedor = NULL;
    if ($proveedor != "")
    	$id_proveedor = $bbdd->get_id_proveedor($proveedor);
   	$id_cliente = NULL;
    if ($cliente != "")
    	$id_cliente = $bbdd->get_id_cliente($cliente);
    
    if ($modificar != "") {
    	
    	$sql = "UPDATE tareas SET nombre = ?, descripcion = ?, fecha_prevista = ?, fecha_inicio = ?, ubicacion = ?, id_cliente = ?, " .
    		"id_proveedor = ?, aviso = ?, fecha_aviso = ? WHERE id = ?";
    	$statement = $bbdd->conexion->prepare($sql);
    	$statement->bind_param("sssssiiisi", $nombre, $descripcion, $fecha_prevista, $fecha_prevista, $ubicacion, 
    		$id_cliente, $id_proveedor, $aviso, $fecha_aviso, $modificar);
    	$ok = $statement->execute();
    	$statement->close();
    	if (!$ok) {
    		echo "<span class='error'>¡ERROR! No se ha podido actualizar el Evento. Comprueba que los datos son correctos</span>";
    		return;
    	}
    	
    	echo "El Evento <strong><em>" . $nombre . "</em></strong> se ha actualizado correctamente";
    }
    else {
    	if ($bbdd->es_tarea($nombre)) {
    		echo "<span class='error'>¡ERROR! El Evento <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
    		return;
    	}
    	
    	if ($_REQUEST["fecha_prevista"] == "") {
    		echo "<span class='error'>¡ERROR! El Evento <strong>" . $nombre . "</strong> no tiene fecha prevista. Es un dato obligatorio</span>";
    		return;
    	}
    	
    	$sql = "INSERT INTO tareas (nombre, descripcion, fecha_prevista, fecha_inicio, ubicacion, " .
    		"id_cliente, id_proveedor, aviso, fecha_aviso, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'evento')";
    	$ok = $bbdd->ejecuta_sentencia_i($sql, "sssssiiis", array($nombre, $descripcion, $fecha_prevista, $fecha_prevista, $ubicacion,
    		$id_cliente, $id_proveedor, $aviso, $fecha_aviso));
    	if (!$ok) {
    		echo "<span class='error'>!ERROR! No se ha podido dar de alta el Evento. Comprueba que los datos son correctos</span>";
    		return;
    	}
    	
    	echo "El Evento <strong><em>" . $nombre . "</em></strong> ha sido dado de alta con éxito";
    }
?>

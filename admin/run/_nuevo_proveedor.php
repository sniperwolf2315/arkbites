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
    $cif = $_REQUEST["cif"];
    $direccion = $_REQUEST["direccion"];
    $poblacion = $_REQUEST["poblacion"];
    $provincia = $_REQUEST["provincia"];
    $cp = $_REQUEST["cp"];
    $pais = $_REQUEST["pais"];
    $telefono = $_REQUEST["telefono"];
    $movil = $_REQUEST["movil"];
    $fax = $_REQUEST["fax"];
    $email = $_REQUEST["email"];
    $web = $_REQUEST["web"];
    $observaciones = $_REQUEST["observaciones"];
    if (isset($_REQUEST["modificar"]))
    	$modificar = $_REQUEST["modificar"];

    $bbdd = new BBDD();
    
    if ($modificar != "") {
    	$sql = "UPDATE proveedores SET nombre = ?, cif = ?, direccion = ?, poblacion = ?, provincia = ?, cp = ?, pais = ?, " .
    		"telefono = ?, movil = ?, fax = ?, email = ?, web = ?, observaciones = ? WHERE id = ?";
    	$statement = $bbdd->conexion->prepare($sql);
    	$statement->bind_param("sssssssssssssi", $nombre, $cif, $direccion, $poblacion, $provincia, $cp, $pais, $telefono, $movil,
    		$fax, $email, $web, $observaciones, $modificar);
    	$ok = $statement->execute();
    	$statement->close();
    	if (!$ok) {
    		echo "<span class='error'>¡ERROR! No se ha podido actualizar el Proveedor. Comprueba que los datos son correctos</span>";
    		return;
    	}
    	
    	echo "El Proveedor <strong><em>" . $nombre . "</em></strong> se ha actualizado correctamente";
    }
    else {
    	if ($bbdd->es_proveedor($nombre)) {
    		echo "<span class='error'>¡ERROR! El Proveedor <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
    		return;
    	}
    	
    	$sql = "INSERT INTO proveedores (nombre, cif, direccion, poblacion, provincia, cp, pais, telefono, movil, fax, email, web, observaciones) " .
    		"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    	$statement = $bbdd->conexion->prepare($sql);
    	$statement->bind_param("sssssssssssss", $nombre, $cif, $direccion, $poblacion, $provincia, $cp, $pais, $telefono, $movil, 
    		$fax, $email, $web, $observaciones);
    	$ok = $statement->execute();
    	$statement->close();
    	if (!$ok) {
    		echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Proveedor. Comprueba que los datos son correctos</span>";
    		return;
    	}
    	
    	echo "El Proveedor <strong><em>" . $nombre . "</em></strong> ha sido dado de alta con éxito";
    }
?>

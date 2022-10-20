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

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $fecha_inicio = $_POST["start"];
    $fecha_fin = $_POST["end"];
    
    $bbdd = new BBDD();
    $statement = $bbdd->conexion->prepare("INSERT INTO tareas (nombre, descripcion, fecha_inicio, fecha_fin) " .
    	"VALUES (?, ?, ?, ?)");
    $statement->bind_param("ssss", $nombre, $descripcion, $fecha_inicio, $fecha_fin);
    $statement->execute();
    $statement->close();
?>

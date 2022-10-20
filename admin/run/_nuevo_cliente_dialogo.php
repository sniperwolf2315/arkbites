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
    $apellidos = $_REQUEST["apellidos"];
    $email = $_REQUEST["email"];

    if (($nombre == "") || ($apellidos == "")) {
        echo "<span class='error'>¡ERROR! Debes indicar al menos un nombre y apellidos</span>";
        return;
    }

    $bbdd = new BBDD();

    if ($bbdd->es_cliente($nombre, $apellidos)) {
        echo "<span class='error'>¡ERROR! El Cliente <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
        return;
    }
	
    
    $sql = "INSERT INTO clientes (nombre, apellidos, nombre_completo, email) VALUES (?, ?, ?, ?)";

    $resultado = $bbdd->ejecuta_sentencia_i($sql, "ssss", array($nombre, $apellidos, $nombre . " " . $apellidos, $email));
    if (!$resultado) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Cliente. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "El Cliente <strong><em>" . $nombre . "</em></strong> ha sido dado de alta con éxito";
?>

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
    $email = $_REQUEST["email"];

    if ($nombre == "") {
        echo "<span class='error'>¡ERROR! Debes indicar al menos un nombre</span>";
        return;
    }

    $bbdd = new BBDD();

    if ($bbdd->es_proveedor($nombre)) {
        echo "<span class='error'>¡ERROR! El Proveedor <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
        return;
    }

    $sentencia = "INSERT INTO proveedores (nombre, email) VALUES ('" . $nombre . "','" . $email . "')";

    $resultado = $bbdd->ejecuta_sentencia($sentencia);
    if (!$resultado) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta al Proveedor. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "El Proveedor <strong><em>" . $nombre . "</em></strong> ha sido dado de alta con éxito";
?>

<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
 
    require_once("../config/abc-config.php");
    require_once("../include/arkabytes/bbdd.php");

    $usuario = $_REQUEST["usuario"];
    $contrasena = $_REQUEST["contrasena"];

    $bbdd = new BBDD();

    $usuario = $bbdd->comprobar_usuario($usuario, $contrasena);

    if ($usuario == null) {
        echo "El nombre de usuario o contraseña no son correctos. Por favor, inténtelo de nuevo";
        return;
    }

    session_start();
    $_SESSION["usuario"] = serialize($usuario);
    
    /*if ($usuario->nivel == "usuario") {
        echo "";
    }
    else if ($usuario->nivel == "admin") {
        echo "admin";
    }*/

    return;
?>

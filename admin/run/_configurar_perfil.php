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
 
    $usuario = $_REQUEST["usuario"];
    $old_usuario = $_REQUEST["old_usuario"];
    $contrasena1 = $_REQUEST["contrasena1"];
    $contrasena2 = $_REQUEST["contrasena2"];
    $nombre = $_REQUEST["nombre"];
    $email = $_REQUEST["email"];
    
    if (($usuario == "") || ($nombre == "") || ($email == "")) {
    	echo "<span class='error'>¡ERROR! El usuario, el nombre y el e-mail son datos obligatorios</span>";
    	return;
    }
    
    if ($old_usuario == "demo") {
    	echo "<span class='error'>¡ERROR! El usuario 'demo' no se puede modificar</span>";
    	return;
    }
    
    $bbdd = new BBDD();
    
    if ($contrasena1 == "") {
    	$sql = "UPDATE usuarios SET usuario = ?, nombre = ?, email = ? WHERE usuario = ?";
    	$ok = $bbdd->ejecuta_sentencia_i($sql, "ssss", array($usuario, $nombre, $email, $old_usuario));
    	if (!$ok) {
    		echo "<span class='error'>¡ERROR! No se ha podido modificar tu perfil. Comprueba que los datos son correctos</span>";
    		return;
    	}
    }
    else {
    	if ($contrasena1 != $contrasena2) {
    		echo "<span class='error'>¡ERROR! La contraseñas no coincide. Debes escribir dos veces la misma contraseña</span>";
    		return;
    	}
    	
    	$sql = $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, contrasena = MD5(?), email = ? WHERE usuario = ?";
    	$ok = $bbdd->ejecuta_sentencia_i($sql, "sssss", array($usuario, $nombre, $contrasena1, $email, $old_usuario));
    	if (!$ok) {
    		echo "<span class='error'>¡ERROR! No se ha podido modificar tu perfil. Comprueba que los datos son correctos</span>";
    		return;
    	}
    }
    
    echo "Tu perfil se ha modificado correctamente";
?>

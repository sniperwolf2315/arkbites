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
    
    $bbdd = new BBDD();
    
    if (isset($_REQUEST["tips"]))
    	$tips = $_REQUEST["tips"];
   	else
   		$tips = 0;
    
   	$sql = "UPDATE opciones SET valor = ? WHERE nombre = 'tips'";
   	$bbdd->ejecuta_sentencia_i($sql, "i", array($tips));
   	
   	echo "Los cambios se han realizado correctamente";
?>

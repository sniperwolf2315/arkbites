<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
	
include("_check_login.php");

$para = $_REQUEST["para"];
$asunto = $_REQUEST["asunto"];
$mensaje = $_REQUEST["mensaje"];
$cabeceras = "From: Arkabytes <contacto@arkabytes.com>";
/*
if (mail($para, $asunto, $mensaje, $cabeceras)) {

    echo "Mensaje enviado correctamente";
}
else {
    echo "<span class='error'>Se ha producido un error al enviar el email. Inténtelo de nuevo</span>";
}
*/
echo "<span class='error'>Función desactivada en la versión demo</span>";
?>
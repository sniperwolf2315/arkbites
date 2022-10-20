<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

session_start();

require_once("../include/arkabytes/usuario.php");
require_once("../include/arkabytes/bbdd.php");
require_once("../config/abc-config.php");

$id = "";
if (isset($_REQUEST["id"]))
    $id = $_REQUEST["id"];

/* Si no se ha iniciado sesión se muestra el formulario de login */
$usuario = unserialize($_SESSION["usuario"]);
if ((!isset($_SESSION["usuario"])) || ($usuario->nivel != "admin")) {

    if ($id != "login")
        $mensaje = "Estás desconectado. Debe iniciar una sesión para continuar";

    header("location: " . BASE_URL . "?id=login");
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <!-- Mis hojas de estilo -->
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
    <link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
    <link href="../css/comun.css" rel="stylesheet" type="text/css"/>
    <!-- Tema para plugin JQuery UI -->
    <link href="../include/ui/css/custom-theme/jquery-ui-1.8.7.custom.css" rel="stylesheet" type="text/css"/>
    <!-- JQuery Calculator -->
    <link rel="stylesheet" type="text/css" href="../include/jquery.calculator-1.4.1/jquery.calculator.css"/>
    <link rel="icon" href="img/logo.ico" type="image/gif"/>
    <!-- fullcalendar -->
    <link href="../include/fullcalendar/fullcalendar.css" rel="stylesheet"/>
    <link href="../include/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print"/>
    <!-- JQuery y plugins varios -->
    <script type="text/javascript" src="../include/ui/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery.message.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery.validate.js"></script>
    <script type="text/javascript" src="../include/ui/js/jquery-ui-1.8.7.custom.min.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery.form.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery-uitablefilter.js"></script>
    <!-- Acordeon 
    <script type="text/javascript" src="../include/jquery/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../include/jquery/jquery.ui.accordion.js"></script>-->
    <!-- Mis propias funciones -->
    <script type="text/javascript" src="../include/arkabytes/miajax.js"></script>
    <!-- Ventana emergente -->
    <script type="text/javascript" src="../include/popup/popup.js"></script>
    <!-- FancyZoom -->
    <script type="text/javascript" src="../include/fancyzoom/js-global/FancyZoom.js"></script>
    <script type="text/javascript" src="../include/fancyzoom/js-global/FancyZoomHTML.js"></script>
    <!-- fullcalendar -->
    <script type="text/javascript" src="../include/fullcalendar/fullcalendar.min.js"></script>
    <!-- JQuery Calculator -->
	<script type="text/javascript" src="../include/jquery.calculator-1.4.1/jquery.calculator.js"></script>
    <!-- JQuery sorter --> 
	<!-- <script type="text/javascript" src="../include/jquery.sorter/jquery-latest.js"></script>
	<script type="text/javascript" src="../include/jquery.sorter/jquery.tablesorter.js"></script> -->
    <script type="text/javascript">
        $(function() {
            var tabla = $("table.cebra")

            tabla.find("tbody > tr").find("td:eq(1)").mousedown(function() {
            });

            $("#busqueda_rapida").keyup(function(e) {
                //$.uiTableFilter(tabla, this.value);
                
                if (e.keyCode == 13) {
	                var url = $(location).attr('href');
	                var busqueda = $('#busqueda_rapida').val();
	            	window.location.href = url.concat("&busqueda_rapida=" + busqueda);
                }
            });

            $("#busqueda").submit(function() {
                tabla.find("tbody > tr:visible > td:eq(1)").mousedown();
                return false;
            }).focus();
        });
    </script>
    <title>OMEGA SISTEMAS | <?php if ($id != "") echo $id; else echo "inicio"; ?></title>
</head>
<body onload="setupZoom()"><!-- Exigencias de FancyZoom -->
<div id="container">
    <div id="l"></div>
    <div id="header">
    <?php
        include("header.php");
    ?>
    </div>
    <?php
        include("subheader.php");
    ?>
    <div id="content">
    <?php
        if ($id == "") 
            $id = "inicio";

        include($id . ".php");
    ?>
    </div>
    <div id='footer'>&copy; OMEGA SISTEMAS 2016 | ADSI SENA GAES 15</div>
</div>
<!-- <div id="validador">
	<a href="http://validator.w3.org/check?uri=referer">
    <img style="border:0px;width:68px;height:21px" src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid Xhtml 1.1" /></a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
    <img style="border:0;width:68px;height:21px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="¡CSS Válido!" /></a>
</div> -->
</body>
</html>

<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

    session_start();

    $id = "";
    if (isset($_REQUEST["id"])) 
        $id = $_REQUEST["id"];

    /* Si no se ha iniciado sesión se muestra el formulario de login */
    $mensaje = "";
    if (!isset($_SESSION["usuario"])) {
        
        if (($id != "login") || ($id == ""))
            $mensaje = "Estás desconectado. Debe iniciar una sesión para continuar";

        $id = "login";
    }
    else {
    	require_once("include/arkabytes/usuario.php");
    	require_once("config/abc-config.php");
    	
    	$usuario = new Usuario();
    	$usuario = unserialize($_SESSION["usuario"]);
    	
    	// TODO por ahora no se muestra la zona de clientes
    	if ($usuario->nivel == "admin") {
    		printf(BASE_URL . "admin/index.php");
    		header("Location: " . BASE_URL . "admin/?id=inicio");
    	}
    }

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
    <link href="css/formularios.css" rel="stylesheet" type="text/css"/>
    <link href="css/comun.css" rel="stylesheet" type="text/css"/>
    <link href="include/ui/css/custom-theme/jquery-ui-1.8.7.custom.css" rel="stylesheet" type="text/css"/>
    <link rel="icon" href="img/logo.ico" type="image/gif"/>
    <script type="text/javascript" src="include/ui/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="include/jquery/jquery.message.js"></script>
    <script type="text/javascript" src="include/jquery/jquery.validate.js"></script>
    <script type="text/javascript" src="include/ui/js/jquery-ui-1.8.7.custom.min.js"></script>
    <script type="text/javascript" src="include/jquery/jquery.form.js"></script>
    <script type="text/javascript" src="include/arkabytes/miajax.js"></script>
    <title>OMEGA SISTEMAS CARLOS VILLALOBOS | ADSI SENA GAES 15</title>
</head>
<body>
<div id="container">
    <div id="l"></div>
    <div id="header">
    <?php
        include("header.php");
    ?>
    </div>
    <div id="content">
    <?php
        if ($id == "")
            $id = "inicio";

        
        include($id . ".php");
    ?>
    </div>
    <div id='footer'>&copy; OMEGA SISTEMAS 2016 | ADSI SENA GAES 15</div>
</div>
<!-- <div id="pie">
    <a href="http://www.arkabytes.com"><img src="img/logoarkabytes200.png" alt="Logo Arkabytes" /></a>
</div> -->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.arkabytes.com/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "3"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
</body>
</html>

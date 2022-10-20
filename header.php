<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
 
if ($id == "login") {
    echo "<span class='login'>OMEGA SISTEMAS</span>\n";
    return;
}

if ($id == "inicio")
    echo "<a class='activo' href='?id=inicio'>Inicio</a>\n";
else
    echo "<a href='?id=inicio'>Inicio</a>\n";
  
if ($id == "servicios")
    echo "<a class='activo' href='?id=servicios'>Tus Servicios</a>\n";
else
    echo "<a href='?id=servicios'>Tus Servicios</a>\n";

if ($id == "estadisticas")
    echo "<a class='activo' href='?id=estadisticas'>Estadísticas</a>\n";
else
    echo "<a href='?id=estadisticas'>Estadísticas</a>\n";
  
if ($id== "incidencias")
    echo "<a class='activo' href='?id=incidencias'>Incidencias</a>\n";
else
    echo "<a href='?id=incidencias'>Incidencias</a>\n";
  
if ($id == "facturacion")
    echo "<a class='activo' href='?id=facturacion'>Facturación</a>\n";
else
    echo "<a href='?id=facturacion'>Facturación</a>\n";
  
echo "<a href='#'>Correo Web</a>\n";
  
if ($id == "ayuda")
    echo "<a class='activo' href='?id=ayuda'>Ayuda</a>\n";
else
    echo "<a href='?id=ayuda'>Ayuda</a>\n";
?>
<span id="logout"><a href="run/_logout.php" title="Cerrar sesión"><img src="iconos/salir24.png" alt="Salir"/></a></span>

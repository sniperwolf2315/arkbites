<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

    if ($id == "login") {

        echo "<span class='login'>ABC Arkabytes</span>\n";
        return;
    }

    if ($id == "inicio")
        echo "<a class='activo' href='?id=inicio'>Inicio</a>\n";
    else
        echo "<a href='?id=inicio'>Inicio</a>\n";
      
    if (($id == "clientes") || ($id == "nuevo_cliente"))
        echo "<a class='activo' href='?id=clientes'>Clientes</a>\n";
    else
        echo "<a id='enlace' href='?id=clientes'>Clientes</a>\n";

    if (($id == "proveedores") || ($id == "nuevo_proveedor"))
        echo "<a class='activo' href='?id=proveedores'>Proveedores</a>\n";
    else
        echo "<a href='?id=proveedores'>Proveedores</a>\n";
      
    if (($id== "pedidos") || ($id == "nuevo_pedido"))
        echo "<a class='activo' href='?id=pedidos'>Pedidos</a>\n";
    else
        echo "<a href='?id=pedidos'>Pedidos</a>\n";
      
    if (($id == "facturas") || ($id == "nueva_factura"))
        echo "<a class='activo' href='?id=facturas'>Facturas</a>\n";
    else
        echo "<a href='?id=facturas'>Facturas</a>\n";
         
    /*if (($id == "tareas") || ($id == "nueva_tarea"))
        echo "<a class='activo' href='?id=tareas'>Tareas</a>\n";
    else
        echo "<a href='?id=tareas'>Tareas</a>\n";
	*/

    if (($id == "articulos") || ($id == "nuevo_articulo"))
        echo "<a class='activo' href='?id=articulos'>Artículos</a>\n";
    else
        echo "<a href='?id=articulos'>Artículos</a>\n";

    if (($id == "maestras") || ($id == "nueva_forma_pago") || ($id == "nueva_forma_envio") || ($id == "nuevo_tipo_iva"))
        echo "<a class='activo' href='?id=maestras'>Maestras</a>\n";
    else
        echo "<a href='?id=maestras'>Maestras</a>\n";
    
    if (($id == "calendario") || ($id == "nueva_cita") || ($id == "agenda") || ($id == "nueva_tarea"))
    	echo "<a class='activo' href='?id=calendario'>Calendario</a>\n";
    else
    	echo "<a href='?id=calendario'>Calendario</a>\n";
?>
<span id="logout"><a href="../run/_logout.php" title="Cerrar sesión"><img src="../iconos/salir24.png" alt="Salir"/></a></span>
<?php 
	if (($id == "configurar_perfil") || ($id == "configurar_empresa") || ($id == "configurar_aplicacion"))
		echo "<a style='float:right' class='activo' href='?id=configurar_aplicacion' title='Configurar'><img src='icons/configurar24.png' alt='Configurar'/></a>";
	else
		echo "<a style='float:right' href='?id=configurar_aplicacion' title='Configurar'><img src='icons/configurar24.png' alt='Configurar'/></a>";
?>
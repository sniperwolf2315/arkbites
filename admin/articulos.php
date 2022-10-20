<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
?>
<script type="text/javascript">
$(document).ready(function() {
    $("table tr:nth-child(odd)").addClass("alt");
});

$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar el artíulo. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_articulo.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando Artículo . . .");
                },
                success: function(responseText) {
                    parent.slideUp(600, function() {
                        parent.remove();
                    });
                    $("#resultado").html(responseText);
                    setTimeout(function() {
                        $("#resultado").html("");
                    }, 2000);
                }
            });
        }
        
        // Si responde que no, se cancela el evento por defecto (el click del enlace)
        e.preventDefault();
    });
});
</script>
<?php

require_once("../config/abc-config.php");
require_once("../include/arkabytes/bbdd.php");

$bbdd = new BBDD();
if (!isset($_REQUEST["inicio"]))
    $inicio = 0;
else
    $inicio = $_REQUEST["inicio"];

if (isset($_REQUEST["busqueda_rapida"]))
    $busqueda_rapida = $_REQUEST["busqueda_rapida"];
else
    $busqueda_rapida = '';

$fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM articulos WHERE nombre LIKE '%" .
        $busqueda_rapida . "%' OR descripcion LIKE '%" . $busqueda_rapida . "%'");
$numero = $fila["numero"];
$tamano = 10;
$paginas = ceil($numero / $tamano);

include("include/paginacion.php");

?>
<div id="listado">
    <table class="cebra">
    <thead class="cabecera">
    <tr class="cabecera">
    <td>#</td>
    <td>Nombre</td>
    <td>Descripción</td>
    <td>Stock</td>
    <td>Precio venta</td>
    <td>Imagen</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    </thead>
    <tbody class="scroll">
<?php
	
	$resultado = $bbdd->ejecuta_consulta("SELECT id, nombre, descripcion, stock, precio_venta, imagen1, miniatura FROM articulos " .
		"WHERE nombre LIKE '%" . $busqueda_rapida . "%' OR descripcion LIKE '%" . $busqueda_rapida . "%' LIMIT " . $inicio . ", " . $tamano);
	
	if ($resultado->num_rows == 0) {
	    echo "<td colspan='7' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
	}
	else {
	    
	    while ($fila = $resultado->fetch_array()) {
	
	        echo "<tr id='registro-" . $fila["id"] . "'>\n";
	        echo "<td>" . $fila["id"] . "</td>\n";
	        echo "<td>" . $fila["nombre"] . "</td>\n";
	        echo "<td>" . $fila["descripcion"] . "</td>\n";
	        if ($fila["stock"] <= 0)
	        	echo "<td><span class='error'>" . $fila["stock"] . "</span></td>\n";
	        else
	        	echo "<td>" . $fila["stock"] . "</td>\n";
	        echo "<td>" . money_format("%i", $fila["precio_venta"]) . "</td>\n";
	        echo "<td><a href='articulos/" . $fila["id"] . "/" . $fila["imagen1"] . "' title='Ampliar'><img src='articulos/" . $fila["id"] . "/" . $fila["miniatura"] . "'/></a></td>\n";
	        echo "<td><a href='run/_generar_barcode.php?id=" . $fila["id"] . "' title='Generar Código'><img src='icons/barcode16.png' alt='Generar Código'/></a></td>\n";
	        echo "<td><a href='?id=nuevo_articulo&modificar=" . $fila["id"] . "' title='Modificar Artículo'><img src='icons/editar16.png' alt='Modificar Artículo'/></a></td>\n";
	        echo "<td><a class='eliminar' href='?eliminar=" . $fila["id"] . "' title='Eliminar Artículo'><img src='icons/cerrar16.png' alt='Eliminar Artículo'/></a></td>\n";
	        echo "</tr>\n";
	    }
	
	    $resultado->close();
	}
?>
</tbody>
</table>
</div>
<?php
	include("include/paginacion.php");
?>
<div id="resultado"></div>
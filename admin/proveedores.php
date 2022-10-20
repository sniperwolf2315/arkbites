<?php

?>
<script type="text/javascript">
$(document).ready(function() {
    $("table tr:nth-child(odd)").addClass("alt");
});

// Llamada a script para eliminar un proveedor
$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar el proveedor. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_proveedor.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando Proveedor . . .");
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
<!-- Popup para enviar email -->
<script type="text/javascript">
$(function() {
    $("a.enviar_email").button();
    $("a.enviar_email").click(function() {
        $("#para").val(jQuery(this).attr("id"));
        $("#dialogo_email").dialog("open");
    });
});
</script>
<?php

include("../include/arkabytes/dialogo_email.php");
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
	
$fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM proveedores WHERE nombre LIKE '%" . $busqueda_rapida . "%'");
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
    <td>Teléfono</td>
    <td>E-Mail</td>
    <td>Web</td>
    <td></td>
    <td></td>
    </tr>
    </thead>
    <tbody class="scroll">
<?php
	$resultado = $bbdd->ejecuta_consulta("SELECT id, nombre, telefono, email, web FROM proveedores " .
		"WHERE nombre LIKE '%" . $busqueda_rapida . "%' ORDER BY nombre");
	
	if ($resultado->num_rows == 0) {
	    echo "<td colspan='7' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
	}
	else {
	    
	    while ($fila = $resultado->fetch_array()) {
	
	        echo "<tr id='registro-" . $fila["id"] . "'>\n";
	        echo "<td>" . $fila["id"] . "</td>\n";
	        echo "<td><a class='popup' title='Más Información' href='ver_proveedor.php?id=" . $fila["id"]  . 
	            "'>" . $fila["nombre"] . "</a></td>\n";
	        echo "<td>" . $fila["telefono"] . "</td>\n";
	        echo "<td><a class='enviar_email' id='" . $fila["email"] . "' title='Enviar un email' href='#'>" . $fila["email"] . "</td>\n";
	        echo "<td><a title='Ir a' href='" . $fila["web"] . "' target='_blank'>" . $fila["web"] . "</a></td>\n";
	        echo "<td><a href='?id=nuevo_proveedor&modificar=" . $fila["id"] . "' title='Modificar Proveedor'><img src='icons/editar16.png' alt='Modificar Proveedor'/></a></td>\n";
	        echo "<td><a class='eliminar' href='#' title='Eliminar Proveedor'><img src='icons/cerrar16.png' alt='Eliminar Proveedor'/></a></td>\n";
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

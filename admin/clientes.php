<?php
/*
 * ABC ERP - Sistema ERP para PYMEs
 * Copyright (C) 2012 Santiago Faci <santi@arkabytes.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
?>
<script type="text/javascript">
$(document).ready(function() {
    $("table tr:nth-child(odd)").addClass("alt");
});

// Llamada a script para eliminar un cliente
$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar el cliente. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_cliente.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando Cliente . . .");
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

$fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM clientes WHERE CONCAT(nombre,apellidos) LIKE '%" . $busqueda_rapida . "%'");
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
	$resultado = $bbdd->ejecuta_consulta("SELECT id, nombre, apellidos, empresa, movil, email, web FROM clientes" . 
	    " WHERE CONCAT(nombre,apellidos) LIKE '%" . $busqueda_rapida . "%' ORDER BY nombre");
	if ($resultado->num_rows == 0) {
	    echo "<td colspan='7' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
	}
	else {
	    
	    while ($fila = $resultado->fetch_array()) {
	
	        if ($fila["empresa"] == null)
	            $nombre = $fila["nombre"] . " " . $fila["apellidos"];
	        else
	            $nombre = $fila["empresa"];
	
	        echo "<tr id='registro-" . $fila["id"] . "'>\n";
	        echo "<td>" . $fila["id"] . "</td>\n";
	        echo "<td><a class='popup' title='Más Información' href='ver_cliente.php?id=" . $fila["id"] . "'>" . 
	            $nombre ."</a></td>\n";
	        echo "<td>" . $fila["movil"] . "</td>\n";
	        echo "<td><a class='enviar_email' id='" . $fila["email"] . "' title='Enviar un e-mail' href='#'>" . $fila["email"] . "</a></td>\n";
	        echo "<td><a title='Ir a' href='" . $fila["web"] . "' target='_blank'>" . $fila["web"] . "</a></td>\n";
	        echo "<td><a href='?id=nuevo_cliente&modificar=" . $fila["id"] . "' title='Modificar Cliente'><img src='icons/editar16.png' alt='Modificar Cliente'/></a></td>\n";
	        echo "<td><a class='eliminar' href='?eliminar=" . $fila["id"] . "' title='Eliminar Cliente'><img src='icons/cerrar16.png' alt='Eliminar Cliente'/></a></td>\n";
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

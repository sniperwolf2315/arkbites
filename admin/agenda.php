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

// Llamada a script para eliminar un cliente
$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar la tarea. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_tarea.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando Tarea/Evento . . .");
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

if (isset($_REQUEST["busqueda_rapida"])) {
    $busqueda_rapida = $_REQUEST["busqueda_rapida"];
    $fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM tareas WHERE nombre LIKE '%" . $busqueda_rapida .
        "%' OR descripcion LIKE '%" . $busqueda_rapida . "%'");
}
else {
    $busqueda_rapida = "";
    $fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM tareas");
}

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
    <td>Fecha</td>
    <td>Estado</td>
    <td>Tipo</td>
    <td></td>
    <td></td>
    </tr>
    </thead>
    <tbody class="scroll">
<?php
$resultado = $bbdd->ejecuta_consulta("SELECT id, nombre, descripcion, fecha_inicio, estado, tipo FROM tareas " .
    "WHERE nombre LIKE '%" . $busqueda_rapida . "%' OR descripcion LIKE '%" . $busqueda_rapida . "%' " .
    "OR date_format(fecha_inicio, '%d-%m-%Y') LIKE '% . $busqueda_rapida . %' OR estado LIKE '% . $busqueda_rapida . %' " .
    "ORDER BY fecha_inicio DESC");
	
if ($resultado == null) {
    echo "<td colspan='7' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
}
else {
    while ($fila = $resultado->fetch_array()) {

        echo "<tr id='registro-" . $fila["id"] . "'>\n";
        echo "<td>" . $fila["id"] . "</td>\n";
        echo "<td><a class='popup' title='Más Información' href='ver_tarea.php?id=" . $fila["id"] . "'>" .
            $fila["nombre"] ."</a></td>\n";
        echo "<td>" . $fila["descripcion"] . "</td>\n";
        echo "<td>" . date("d-m-Y", strtotime($fila["fecha_inicio"])) . "</a></td>\n";
        echo "<td>" . $fila["estado"] . "</td>\n";
        echo "<td>" . $fila["tipo"] . "</td>\n";
        if ($fila["tipo"] == "tarea")
            echo "<td><a href='?id=nueva_tarea&modificar=" . $fila["id"] . "' title='Modificar Tarea'><img src='icons/editar16.png' alt='Modificar Tarea'/></a></td>\n";
        else
            echo "<td><a href='?id=nuevo_evento&modificar=" . $fila["id"] . "' title='Modificar Evento'><img src='icons/editar16.png' alt='Modificar Evento'/></a></td>\n";
        echo "<td><a class='eliminar' href='?eliminar=" . $fila["id"] . "' title='Eliminar Tarea'><img src='icons/cerrar16.png' alt='Eliminar Tarea'/></a></td>\n";
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
<?php

?>
<script type="text/javascript">
$(document).ready(function() {
    $("table tr:nth-child(odd)").addClass("alt");
});

$(function() {
	$("#fecha").change(function() {
		var value = $(this).val();
		$("#fecha_vencimiento").val(value);
	});
});

// Elimina un pedido de la lista -->
$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar el pedido. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_pedido.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando pedido . . .");
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

<!-- Campos fecha -->
<script type="text/javascript">
$(function() {
	$("#fecha").datepicker({dateFormat: 'dd-mm-yy'});
    $("#fecha_vencimiento").datepicker({dateFormat: 'dd-mm-yy'});
});
</script>

<!-- Hace saltar el diálogo para generar una factura -->
<script type="text/javascript">
$(function() {
    $("a.generar_factura").click(function() {
        $("#numero_pedido").val(jQuery(this).attr("id"));
        $("#dialogo_generar_factura").dialog("open");
    });
});
</script>
<!-- Diálogo para generar la factura de un pedido -->
<script type="text/javascript">
$(function() {
    $("#dialogo_generar_factura").dialog({
        autoOpen: false,
        height: 450,
        width: 790,
        modal: true,
        buttons: {
            "Generar": function() {
                $("#form_generar_factura").ajaxSubmit({
                    beforeSend: function() {
                        $("#resultado_generar_factura").html("Generando factura . . .");
                    },
                    success: function() {
                        parent.children("imagen_factura").attr("src", "icons/pdf16.png")
                    },
                    target: "#resultado_generar_factura"
                });
            },
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#tabla").tablesorter({
		sortList: [[1,0],[2,0]]
	});
});
</script>

<!-- Formulario para generar la factura de un pedido -->
<div id="dialogo_generar_factura" title="Generar Factura">
    <div id="email_destino"></div>
    <form id="form_generar_factura" method="post" action="run/_generar_factura_pedido.php">
    <fieldset style="margin-top:5px">
    <legend>Datos de Pago</legend>
    <ol>
    <li style="float:left">
        <label><strong>Número de pedido</strong></label>
        <input type="text" name="numero_pedido" id="numero_pedido" readonly class="required" size="10"/>
    </li>
    <li style="float:left">
        <label><strong>Fecha</strong></label>
        <input type="text" name="fecha" id="fecha" size="10" class="required" value="<?php echo date("d-m-Y", time()); ?>"/>
    </li>
    <li style="float:left">
        <label><strong>Fecha Vencimiento</strong></label>
        <input type="text" name="fecha_vencimiento" id="fecha_vencimiento" size="10" class="required" value="<?php echo date("d-m-Y", time()); ?>"/>
    </li>
    <li style="float:left">
        <label>Estado</label>
        <select name="estado" id="estado">
            <option value="pendiente">Sin Pagar</option>
            <option value="entregado" selected>Pagada</option>
            <option value="cancelado">Anulada</option>
        </select>
    </li>
    <li style="float:left">
        <label>Forma de pago</label>
        <select name="forma_pago" id="forma_pago">
        <?php
        	require_once("../include/arkabytes/bbdd.php");
        	$bbdd = new BBDD();
            $resultado = $bbdd->ejecuta_consulta("SELECT id, nombre FROM formas_pago");

            if (is_null($resultado)) {
                echo "<option>No hay Formas de Pago</option>";
            }
            else {
                while ($fila = $resultado->fetch_array()) {
                    echo "<option value='" . $fila["nombre"] ."'>" . $fila["nombre"] . "</option>";
                }
            }

            $resultado->close();
        ?>
        </select>
    </li>
    </ol>
    </fieldset>
    <fieldset style="margin-top:20px">
    <legend>Comentarios y Observaciones</legend>
    <ol>
    <li style="float:left">
        <label>Comentarios</label>
        <textarea cols="30" rows="4" name="comentarios" id="comentarios"></textarea>
    </li>
    <li style="float:left">
        <label>Observaciones</label>
        <textarea cols="30" rows="4" name="observaciones" id="observaciones"></textarea>
    </li>
    </ol>
    </fieldset>
    </form>
    <div id="resultado_generar_factura"></div>
</div>
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
	
$fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM pedidos p, clientes c WHERE " .
    "p.id_cliente = c.id AND (p.numero_pedido LIKE '%" . $busqueda_rapida . "%' OR CONCAT(c.nombre,c.apellidos) LIKE '%" . $busqueda_rapida . "%')");
$numero = $fila["numero"];
$tamano = 10;
$paginas = ceil($numero / $tamano);

include("include/paginacion.php");

?>
<div id="listado">
    <table id="tabla" class="cebra">
    <thead class="cabecera">
    <tr class="cabecera">
    <th>#</th>
    <th>Número</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Importe</th>
    <th>Factura</th>
    <th></th>
    <th></th>
    <th></th>
    </tr>
    </thead>
    <tbody class="scroll">
<?php
$resultado = $bbdd->ejecuta_consulta("SELECT id, numero_pedido, id_cliente, fecha, estado, importe " .
    "FROM pedidos p " .
    "WHERE numero_pedido LIKE '%" . $busqueda_rapida . "%' OR nombre_cliente LIKE '%" . $busqueda_rapida .
    "%' OR DATE_FORMAT(fecha, '%d-%m-%Y') LIKE '%" . $busqueda_rapida . "%' " .
    "ORDER BY nombre_cliente, fecha");

if ($resultado->num_rows == 0) {
    echo "<td colspan='10' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
}
else {
    while ($fila = $resultado->fetch_array()) {

        $cliente = $bbdd->get_cliente_por_id($fila["id_cliente"]);

        echo "<tr id='registro-" . $fila["id"] . "'>\n";
        echo "<td>" . $fila["id"] . "</td>\n";
        echo "<td>" . $fila["numero_pedido"] . "</td>\n";
        echo "<td><a class='popup' title='Ver cliente' href='ver_cliente.php?id=" . $fila["id_cliente"] .
            "'>" . $cliente->nombre_completo . "</a></td>\n";
        echo "<td>" . date("d-m-Y", strtotime($fila["fecha"])) . "</td>\n";
        echo "<td>" . $fila["estado"] . "</td>\n";
        echo "<td>" . money_format("%i", $fila["importe"]) . "</td>\n";

        $con_factura = $bbdd->ejecuta_escalar("SELECT numero_factura FROM facturas WHERE numero_pedido = '" .  $fila["numero_pedido"] . "'");
        if ($con_factura != "")
            echo "<td id='fila'><a href='run/_generar_pdf_factura.php?numero_factura=" . $con_factura["numero_factura"] . "' title='Ver Factura' href='#'><img src='icons/pdf16.png' alt='Ver Factura'/></a></td>\n";
        else
            echo "<td id='fila'><a class='generar_factura' id='" . $fila["numero_pedido"]. "' title='Generar Factura' href='#'><img id='imagen_factura' src='icons/derecha16.png' alt='Generar Factura'/></a></td>\n";
        echo "<td><a href='run/_generar_pdf_pedido.php?numero_pedido=" . $fila["numero_pedido"] . "' title='Ver Pedido' target='_blank'><img src='icons/pdf16.png' alt='Ver Documento'/></a></td>\n";
        echo "<td><a href='#' title='Modificar Pedido'><img src='icons/editar16.png' alt='Modificar Pedido'/></a></td>\n";
        echo "<td><a class='eliminar' href='?eliminar=" . $fila["id"] . "' title='Eliminar Pedido'><img src='icons/cerrar16.png' alt='Eliminar Pedido'/></a></td>\n";
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
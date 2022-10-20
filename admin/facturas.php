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
</script>

<script type="text/javascript">
// Elimina la factura de la lista -->
$(document).ready(function() {
    $('a.eliminar').click(function(e) {
        if (confirm('Vas a eliminar la factura. ¿Estás seguro?')) {
            e.preventDefault();
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: 'run/_eliminar_factura.php',
                data: 'ajax=1&eliminar=' + parent.attr('id').replace('registro-', ''),
                beforeSend: function() {
                    parent.animate({'backgroundColor':'#fb6c6c'}, 300);
                    $("#resultado").html("Eliminando factura . . .");
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
<!-- Hace saltar el diálogo para enviar la factura por email -->
<script type="text/javascript">
    $(function() {
        $("a.enviar_por_email").click(function() {
            $("#numero_factura").val(jQuery(this).attr("id"));
            $("#email").val(jQuery(this).attr("email"));
            $("#dialogo_enviar_por_email").dialog("open");
        });
    });
</script>
<!-- Procesa el diálogo para enviar la factura por email -->
<script type="text/javascript">
    $(function() {
        $("#dialogo_enviar_por_email").dialog({
            autoOpen: false,
            height: 350,
            width: 790,
            modal: true,
            buttons: {
                "Enviar": function() {
                    $("#form_enviar_por_email").ajaxSubmit({
                        beforeSend: function() {
                            $("#resultado_enviar_por_email").html("** Funcionalidad en desarrollo. Disponible en próximas versiones **");
                        },
                        success: function() {
                            parent.children("imagen_email").attr("src", "icons/enviaremail16.png")
                        },
                        target: "#resultado_enviar_por_email"
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
<!-- Formulario para generar la factura de un pedido -->
<div id="dialogo_enviar_por_email" title="Enviar por email">
    <div id="email_destino"></div>
    <form id="form_enviar_por_email" method="post" action="run/_enviar_factura_por_email.php">
        <fieldset style="margin-top:5px">
            <legend>Factura</legend>
            <ol>
                <li style="float:left">
                    <label><strong>Número de factura</strong></label>
                    <input type="text" name="numero_factura" id="numero_factura" readonly="readonly" class="required" size="10"/>
                </li>
                <li style="float:left">
                    <label><strong>E-mail</strong></label>
                    <input type="text" name="email" id="email" class="required" size="20"/>
                </li>
        </fieldset>
        <fieldset style="margin-top:20px">
            <legend>E-mail</legend>
            <ol>
                <li style="float:left">
                    <label>Asunto</label>
                    <input type="text" name="asunto" id="asunto" size="40"/>
                </li>
                <li style="float:left">
                    <label>Mensaje</label>
                    <textarea cols="40" rows="4" name="mensaje" id="mensaje"></textarea>
                </li>
            </ol>
        </fieldset>
    </form>
    <div id="resultado_enviar_por_email">** Funcionalidad en desarrollo. Disponible en próximas versiones **</div>
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

$fila = $bbdd->ejecuta_escalar("SELECT COUNT(*) numero FROM facturas " .
    "WHERE numero_factura LIKE '%" . $busqueda_rapida . "%' OR nombre_cliente LIKE '%" . $busqueda_rapida . "%'");
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
    <td>Número</td>
    <td>Cliente</td>
    <td>Fecha</td>
    <td>Estado</td>
    <td>Importe</td>
    <td></td>
    <td></td>
    <td></td>
    <!-- <td></td> -->
    </tr>
    </thead>
    <tbody class="scroll">
<?php
	$resultado = $bbdd->ejecuta_consulta("SELECT id, numero_factura, id_cliente, fecha, estado, nombre_cliente, importe FROM facturas " .
		"WHERE numero_factura LIKE '%" . $busqueda_rapida . "%' OR nombre_cliente LIKE '%" . $busqueda_rapida . "%' " .
        "OR DATE_FORMAT(fecha, '%d-%m-%Y') LIKE '%" . $busqueda_rapida . "%'" .
		"ORDER BY nombre_cliente ASC, fecha DESC");
	
	if ($resultado->num_rows == 0) {
	    echo "<td colspan='10' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
	}
	else {
	    while ($fila = $resultado->fetch_array()) {

            $cliente = $bbdd->get_cliente_por_id($fila["id_cliente"]);

	        echo "<tr id='registro-" . $fila["id"] . "'>\n";
	        echo "<td>" . $fila["id"] . "</td>\n";
	        echo "<td>" . $fila["numero_factura"] . "</td>\n";
	        echo "<td><a class='popup' title='Ver cliente' href='ver_cliente.php?id=" . $fila["id_cliente"] . "'>" . 
	            $fila["nombre_cliente"] . "</a></td>\n";
	        echo "<td>" . date("d-m-Y", strtotime($fila["fecha"])) . "</td>\n";
	        echo "<td>" . $fila["estado"] . "</td>\n";
	        echo "<td>" . money_format("%i", $fila["importe"]) . "</td>\n";
	        echo "<td><a href='run/_generar_pdf_factura.php?numero_factura=" . $fila["numero_factura"] . "' title='Ver Documento' target='_blank'><img src='icons/pdf16.png' alt='Ver Documento'/></a></td>\n";
            if ($cliente->email != "")
                echo "<td><a class='enviar_por_email' email='" . $cliente->email . "' id='" . $fila["numero_factura"] . "' title='Enviar por e-mail' href='#'><img src='icons/enviaremail16.png' alt='Enviar por e-mail'/></a></td>\n";
            else
                echo "<td><a href='#' title='El cliente no tiene e-mail'><img src='icons/sinaccion16.png' alt='Sin acción'/></a></td>\n";
	        //echo "<td><a href='#' title='Modificar Factura'><img src='icons/editar16.png' alt='Modificar Factura'/></a></td>\n";
	        echo "<td><a class='eliminar' href='?eliminar=" . $fila["id"] . "' title='Eliminar Factura'><img src='icons/cerrar16.png' alt='Eliminar Factura'/></a></td>\n";
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

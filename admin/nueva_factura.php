<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
?>
<!-- Campos fecha -->
<script type="text/javascript">
    $(function() {
        $("#fecha").datepicker({dateFormat: 'dd-mm-yy'});
        $("#fecha_vencimiento").datepicker({dateFormat: 'dd-mm-yy'});
    });
</script>
<!-- Combo autorellenable -->
<script type="text/javascript">
    $(function() {
        $("#cliente").autocomplete({
            source: "run/_buscar_cliente.php",
            minLength: 2,
            select: function(event, ui) {
            }
        });
    });
</script>

<script type="text/javascript">
jQuery(function() {

    $(document).ready(function() {
        $('#cliente').focus();
    });
});

$(function() {
    $("#crear_cliente").button();
    $("#crear_cliente").click(function() {
        $("#dialogo_cliente").dialog("open");
    });
});

$(function() {
    $("#crear_articulo").button();
    $("#crear_articulo").click(function() {
        $("#dialogo_articulo").dialog("open");
    });
});

$(function() {
    $("#forma_pago").combobox();
});
</script>

<!--  Diálogos para ventanas emergentes  -->
<?php 
    include ("../include/arkabytes/dialogo_cliente.php");
    include ("../include/arkabytes/dialogo_articulo.php"); 
?>

<span class="titulocelda">Nueva Factura</span>

<form id="formulario" method="post" action="run/_nueva_factura.php">
    <fieldset>
    <span class="error">En esta versión, para crear facturas se debe crear primero un pedido, y generar la factura a partir de él</span>
    <legend>Datos de Factura</legend>
    <ol>
    <li>
        <label for="cliente"><strong>Cliente</strong></label>
        <input type="text" name="cliente" id="cliente" class="required" size="30"/> <a href="#" id="crear_cliente" title="Dar de alta un Cliente">+</a>   
    </li>
    <li>
        <label>Número</label>
        <input type="text" name="numero" id="numero" size="5"/>
    </li>
    <li>
        <label><strong>Fecha</strong></label>
        <input type="text" name="fecha" id="fecha" size="10" class="required"/> (dd-mm-aaaa)
    <li>
        <label>Fecha Vencimiento</label>
        <input type="text" name="fecha_vencimiento" id="fecha_vencimiento" size="10"/> (dd-mm-aaaa)
    </li>
    <li>
        <label for="estado">Estado</label>
        <select name="estado" id="estado">
            <option value="pendiente">Sin Pagar</option>
            <option value="entregado">Pagada</option>
            <option value="cancelado">Anulada</option>
        </select>
    </li>
    <li>
        <label>Comentario</label>
        <textarea name="comentario" cols="30" rows="5"></textarea>
    </li>
    <li>
        <label>Observaciones</label>
        <textarea name="observaciones" cols="30" rows="5"></textarea>
    </li>
    <li>
        <label>Importe</label>
        <input type="text" name="importe" id="importe"/>
    </li>
    <li>
        <label>Base Imponible</label>
        <input type="text" name="base_imponible" id="base_imponible"/>
    </li>
    <li>
        <label>IVA</label>
        <input type="text" name="iva" id="iva"/>
    </li>
    <li>
        <label>Forma Pago</label>
        <select name="forma_pago" id="forma_pago">
        <?php
            require_once("../config/abc-config.php");
            $bbdd = new BBDD();
            $resultado = $bbdd->ejecuta_consulta("SELECT id, nombre FROM formas_pago");

            if ($resultado->num_rows == 0) {
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

    <fieldset class="submit">
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>
<br/>
<form id="formulario" method="post" action="run/_nuevo_detalle_factura.php">
    <fieldset>
    <legend>Artículos</legend>
    <ol>
    <li>
        <label>Artículo</label>
        <input type="text" name="articulo" size="30"/> <a href="#" id="crear_articulo" title="Dar de alta un Artículo">+</a>
    </li>
    <li>
        <label>Cantidad</label>
        <input type="text" name="cantidad" size="4"/>
        <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>"/>
        <input style="float: right" type="image" src="icons/anadir32.png" value="Añadir"/>
    </li>
    </ol>
    </fieldset>
</form>
<form id="formulario" method="post" action="run/_terminar_factura.php">
	<input style="float: right" type="submit" value="Terminar Factura"/>
</form>
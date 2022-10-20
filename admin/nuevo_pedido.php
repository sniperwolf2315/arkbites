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
// Procesa el formulario principal
jQuery(function() {
    // Indicador de carga
    var loader = jQuery('<div id="loader">Enviando . . .</div>')
        .css({position: "relative", bottom: "0px", left: "center", color: "#690D1A", padding: "5px"})
        .appendTo("#mensaje")
        .hide();

    jQuery("#formulario_pedido").ajaxStart(function() {
        loader.show();
    }).ajaxStop(function() {
        loader.hide();
    }).ajaxError(function(a, b, e) {
        throw e;
    });

    var v = jQuery("#formulario_pedido").validate({
        submitHandler: function(formulario) {
            jQuery(formulario).ajaxSubmit({
                target: "#resultado",
                success: function(responseText, statusText) {
                    $("#resultado").html(responseText);
                    // Limpia los campos del formulario
                    $("#formulario_pedido").each (function() {
                    	this.reset();
                    });              
                    // En caso de que sea el formulario de pedidos
                    $("#select_articulos").empty();
                    $("#select_cantidades").empty();
                    $("#select_precios").empty();
                    listar_articulos();
                }
            });
        }
    });
});

$(function() {
    $("#fecha").datepicker({dateFormat: 'dd-mm-yy'});
    $("#fecha_entrega").datepicker({dateFormat: 'dd-mm-yy'});
    $("#terminar_pedido").prop("disabled", true);
});
</script>
<!-- Por defecto, se asigna la fecha como fecha de entrega -->
<script type="text/javascript">
$(function() {
	$("#fecha").change(function() {
		var value = $(this).val();
		if ($("#fecha_entrega").val() == "") {
			$("#fecha_entrega").val(value);
		}
	});
});
</script>
<!-- Combo autocompletado -->
<script type="text/javascript">
$(function() {
	$("#cliente").autocomplete({
	    source: "run/_buscar_cliente.php",
	    minLength: 2,
	    select: function(event, ui) {
	    },
	    search: function() {
	        $(this).addClass("cargando");
	    },
	    open: function() {
	        $(this).removeClass("cargando");
	    }
	});
});
</script>
<!-- Autocompletado de artículo: nombre, precio y cantidad  -->
<script type="text/javascript">
$(function() {
    $("#articulo").autocomplete({
        source: "run/_buscar_articulo.php",
        minLength: 2,
        select: function(event, ui) {
        	$("#articulo").val(ui.item.value);
        	$("#precio").val(ui.item.precio_venta.replace(".", ","));
        	$("#cantidad").val("1");
        	$("#cantidad").focus();
        },
        search: function() {
            $(this).addClass("cargando");
        },
        open: function() {
            $(this).removeClass("cargando");
        }
    });
});
</script>
<!-- Caza el foco -->
<script type="text/javascript">
jQuery(function() {
    $(document).ready(function() {
        $("#cliente").focus();
        $("#precio").calculator({decimalChar: ","});
    });
});
</script>
<!-- Popup para crear un cliente -->
<script type="text/javascript">
$(function() {
    $("#crear_cliente").button();
    $("#crear_cliente").click(function(e) {
        e.preventDefault();
        $("#dialogo_cliente").dialog("open");
    });
});
</script>
<!-- Popup para crear un artículo -->
<script type="text/javascript">
$(function() {
    $("#crear_articulo").button();
    $("#crear_articulo").click(function(e) {
        e.preventDefault();
        $("#dialogo_articulo").dialog("open");
    });
});
</script>
<script type="text/javascript">
// Lista los artículos que se han añadido al pedido
function listar_articulos() {

    $("#body_carrito tr").remove();

    var cantidad = $("#select_articulos")[0].length;
    if (cantidad == 0) {
        $("#body_carrito").append("<tr><td colspan='3' style='text-align:center'>" +
            "<span class='titulocelda'>## Sin artículos ##</span></td></tr>");

        $("#terminar_pedido").prop("disabled", true);
        return;
    }

    $("#terminar_pedido").prop("disabled", false);

    $("#select_articulos option").each(function(index) {    
        $("#body_carrito").append("<tr><td>" + (index + 1) + "</td>" + 
            "<td>" + $(this).attr("value") + "</td>" +
            "<td>" + $(this).text().replace(".", ",") + "</td>" +
            "<td><a href=\"javascript:eliminar_articulo('" + $(this).attr("value") + 
            "');\" title='Eliminar artículo'>" + 
            "<img src='icons/cerrar16.png'/></a></td></tr>");

    });

    $("#muestra_importe").html("Importe Total: " + $("#importe").val().replace(".", ",") + " Euros");
}
function eliminar_articulo(nombre_articulo) {

    if (!confirm("Se eliminará el artículo seleccionado. ¿Estás seguro?")) {
        return;
    }

    $("#select_articulos option[value='" + nombre_articulo + "']").remove();
    $("#select_precios option[value^='" + nombre_articulo + "']").remove();
    $("#select_cantidades option[value^='" + nombre_articulo + "']").remove();

    contar_carrito();
    listar_articulos();
}
// Cuenta el número de artículos que hay en el carrito
function contar_carrito() {

	// Calcula el importe total del pedido y lo asigna al campo oculto del formulario
	var importe = 0;
	var i = 0;
	if ($("#select_precios")[0].length > 0) {
		$("#select_precios option").each(function() {
			importe = parseFloat(importe) + parseFloat($(this).text()) * parseFloat($("#select_cantidades option").eq(i).text())
			i++;
		});
	}
	$("#importe").val(importe);

	var cantidad = $("#select_articulos")[0].length;   
    $("#boton_carrito").html("El pedido tiene " + cantidad + " artículos");
}
// Añade un artículo
jQuery(function() {
    $("a.anadir_articulo").button();
    $("a.anadir_articulo").click(function(e) {
        var nombre = $("#articulo").val();
        var cantidad = $("#cantidad").val();
        var precio = $("#precio").val();

        // Evita que el navegador vaya al principio de la página por ser un enlace vacío
        e.preventDefault();

        // Comprueba que no exista ya el artículo en la lista de este pedido
        if ($("#select_articulos option[value='" + nombre + "']").length > 0) {
            alert("El artículo " + nombre + " ya está en la lista");
            $("#resultado_anadir_articulo").html("<span class='error'>El Artículo <strong>" + nombre +
                "</strong> no se ha añadido</span>");   
            return;
        }

        // Comprueba si la cantidad es un valor numérico
        if (!$.isNumeric(cantidad)) {
            alert("Introduce una cantidad válida");
            $("#resultado_anadir_articulo").html("<span class='error'>El Artículo <strong>" + nombre +
                "</strong> no se ha añadido</span>");
            $("#cantidad").focus();
            return;
        }

        precio = precio.replace(",", ".");
        if (!$.isNumeric(precio)) {
        	alert("Introduce un precio válido");
            $("#resultado_anadir_articulo").html("<span class='error'>El Artículo <strong>" + nombre +
                "</strong> no se ha añadido</span>");
            $("#precio").focus();
            return;
        }

        // Comprueba que se ha introducido un artículo
        if (nombre == "") {
            alert("Escoge un artículo");
            return;
        }

        // Añade el artículo y su cantidad al select oculto
        $("#select_articulos").append("<option value='" + nombre + "' selected>" + cantidad + " / " + (cantidad * precio) + " euros</option>");
        $("#select_cantidades").append("<option value='" + nombre + "|" + cantidad + "' selected>" + cantidad + "</option>");
        $("#select_precios").append("<option value='" + nombre + "|" + precio + "' selected>" + precio + "</option>");

        contar_carrito();
        listar_articulos();

        // Notifica la acción al usuario
        $("#resultado_anadir_articulo").html("<span>Artículo <strong>" + nombre + 
            "</strong> añadido al pedido</span>");

        // Limpia los campos
        $("#articulo").val("");
        $("#cantidad").val("");
        $("#precio").val("");

        $("#articulo").focus();
    });
});
</script>
<script type="text/javascript">
$(function() {
    $("#boton_carrito").button();
    $("#boton_carrito").click(function() {
        $("#carrito").dialog("open");
    });
});
</script>
<!--  Diálogos para ventanas emergentes  -->
<?php 
    include ("../include/arkabytes/dialogo_cliente.php");
    include ("../include/arkabytes/dialogo_articulo.php"); 
?>

<span class="titulocelda">Preparar Pedidos</span>
<form id="formulario_pedido" method="post" action="run/_nuevo_pedido.php">
    <fieldset>
    <legend>Datos de Pedido</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label for="cliente"><strong>Cliente</strong></label>
        <input type="text" name="cliente" id="cliente" class="required" size="30"/> 
        <a href="#" id="crear_cliente" title="Dar de alta un Cliente">+</a>   
    </li>
    <li>
        <label>Fecha</label>
        <input type="text" name="fecha" id="fecha" size="10"/> (dd-mm-aaaa)
    <li>
        <label>Fecha Entrega</label>
        <input type="text" name="fecha_entrega" id="fecha_entrega" size="10"/> (dd-mm-aaaa)
    </li>
    <li>
        <label for="estado">Estado</label>
        <select name="estado" id="estado">
            <option value="pendiente">Pendiente</option>
            <option value="transito">En Tránsito</option>
            <option value="entregado">Entregado</option>
            <option value="cancelado">Cancelado</option>
            <option value="facturado">Facturado</option>
            <option value="pagado" selected>Pagado</option>
        </select>
    </li>
    <li>
        <label>Comentarios</label>
        <textarea name="comentarios" cols="30" rows="5"></textarea>
    </li>
    <li>
        <label>Observaciones</label>
        <textarea name="observaciones" cols="30" rows="5"></textarea>
    </li>
    <li>
        <label>Forma Envío</label>
        <select name="forma_envio" id="forma_envio">
        <?php
            require_once("../config/abc-config.php");
            
            $bbdd = new BBDD();
            $resultado = $bbdd->ejecuta_consulta("SELECT id, nombre FROM formas_envio");
            
            if ($resultado->num_rows == 0) {
                echo "<option>No hay Formas de Envío</option>";
            }
            else {
               while ($fila = $resultado->fetch_array()) {
                    echo "<option value='" . $fila["nombre"] ."'>" . $fila["nombre"] . "</option>";
                }
            }
        ?>
        </select>
    </li>
    <li>
        <label>Forma Pago</label>
        <select name="forma_pago" id="forma_pago">
        <?php
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
    <li>
        <label>Añadir a calendario</label>
        <input type="checkbox" name="crear_evento" id="crear_evento" value="1" checked/>
    </li>
    </ol>
    </fieldset>

    <div id="carrito" title="Lista de artículos" style="display:none;">
        <div id="listado" style="width:600px;height:250px">
        <table class="cebra" style="width:600px">
        <thead class="cabecera">
        <tr class="cabecera">
        <td>#</td>
        <td style="width:350px">Artículo</td>
        <td>Cantidad/Precio</td>
        <td></td>
        </tr>
        </thead>
        <tbody class="scroll" id="body_carrito">
            <tr><td colspan="3" style="text-align:center">
                <span class="titulocelda">## Sin Artículos ##</span>
            </td></tr>	
        </tbody>
        </table>
        <div style="text-align:right;padding:10px" id="muestra_importe"></div>
        </div>
    </div>
    
    <select id="select_articulos" name="select_articulos[]" style="display:none" multiple="multiple"></select>
    <select id="select_cantidades" class="suma" name="select_cantidades[]" style="display:none" multiple="multiple"></select>
    <select id="select_precios" class="suma" name="select_precios[]" style="display:none" multiple="multiple"></select>
    <br/>
    <div id="boton_carrito" title="Ver lista de artículos" style="padding:8px;">El pedido no tiene artículos</div>
    
    <span class="titulocelda">Añadir artículos al Pedido</span>
    <fieldset>
    <legend>Artículos</legend>
    <ol>
    <li>
        <label>Artículo</label>
        <input type="text" id="articulo" name="articulo" onfocus="this.select()" size="30"/> 
        <a href="#" id="crear_articulo" title="Dar de alta un Artículo">+</a>
    </li>
    <li>
        <label>Cantidad</label>
        <input type="text" id="cantidad" name="cantidad" onfocus="this.select()" size="4"/>
    </li>
    <li>
    	<label>Precio</label>
    	<input type="text" id="precio" name="precio" onfocus="this.select()" size="4"/> <img src="../include/jquery.calculator-1.4.1/calculator.png" alt="calculadora"/>
        <a class="anadir_articulo" href="#" style="float:right"><img src="icons/anadir32.png"/></a>
    </li>
    </ol>
    </fieldset>
    
    <div id="resultado_anadir_articulo"></div>
    <!-- Aquí se muestra el listado de artículos al usuario -->
    <div id="listado_articulos"></div>

    <div style="margin:auto;width:100px;padding-top:15px">
    	<input type="hidden" name="importe" id="importe" value="0"/>
        <input type="submit" id="terminar_pedido" value="Terminar Pedido"/>
    </div>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>
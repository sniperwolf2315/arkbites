<?php

?>
<script type="text/javascript">
jQuery(function() {

    $(document).ready(function() {
        $('#nombre').focus();
        $("#precio_venta").calculator({decimalChar: ","});
    });
});

$(function() {
    $("#proveedor").autocomplete({
        source: "run/_buscar_proveedor.php",
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

$(function() {
    $("#crear_proveedor").button();
    $("#crear_proveedor").click(function() {
        $("#dialogo_proveedor").dialog("open");
    });

    $("#precio_compra").focus(function() {
        $(this).select();
    });
    $("#precio_venta").focus(function() {
        $(this).select();
    });
});
</script>

<!-- Diálogos para ventanas emergentes -->
<?php include ("../include/arkabytes/dialogo_proveedor.php"); ?>

<span class="titulocelda">Nuevo Artículo</span>

<?php
	$articulo = new Articulo();
	$proveedor = new Proveedor();
	$modificar = "";
	
	if (isset($_REQUEST["modificar"]))
		$modificar = $_REQUEST["modificar"];
	
	if (isset($modificar)) {
		require_once("../config/abc-config.php");
		require_once("../include/arkabytes/bbdd.php");
		$bbdd = new BBDD();
		$articulo = $bbdd->get_articulo_por_id($modificar);
		$proveedor = $bbdd->get_proveedor_por_id($articulo->id_proveedor);
	}
?>

<form id="formulario" method="post" action="run/_nuevo_articulo.php" enctype="multipart/form-data" accept-charset="ISO-8859-1">
    <fieldset>
    <legend>Datos del Artículo</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" id="nombre" size="20" class="required" value="<?php echo $articulo->nombre; ?>"/>
    </li>
    <li>
        <label>Descripción</label>
        <input type="text" name="descripcion" size="40" value="<?php echo $articulo->descripcion; ?>"/>
    </li>
    <li>
        <label>Stock</label>
        <input type="text" name="stock" size="5" value="<?php echo $articulo->stock; ?>"/> (unidades)
    </li>
    <li>
        <label>Precio compra</label>
        <input type="text" id="precio_compra" name="precio_compra" size="8" value="<?php echo str_replace(".", ",", round($articulo->precio_coste, 2)); ?>"/> (sin IVA)
    </li>
    <li>
        <label>Precio venta</label>
        <input type="text" id="precio_venta" name="precio_venta" size="8" value="<?php echo str_replace(".", ",", round($articulo->precio_venta, 2)); ?>"/> (sin IVA)
        	<img src="../include/jquery.calculator-1.4.1/calculator.png" alt="calculadora"/>
    </li>
    <li>
        <label>Tipo de IVA</label>
        <select name="tipo_iva" id="tipo_iva">
        <?php
            require_once("../config/abc-config.php");
            
            $bbdd = new BBDD();
            $resultado = $bbdd->ejecuta_consulta("SELECT id, nombre FROM tipos_iva");
            
            if ($resultado->num_rows == 0) {
                echo "<option>No hay tipos de IVA</option>";
            }
            else {
               while ($fila = $resultado->fetch_array()) {
					if ($articulo->id_tipo_iva == $fila["id"])
                    	echo "<option value='" . $fila["id"] ."' selected>" . $fila["nombre"] . "</option>";
					else
						echo "<option value='" . $fila["id"] ."'>" . $fila["nombre"] . "</option>";
                }
            }
        ?>
        </select>
    </li>
    <li>
        <label>Observaciones</label>
        <textarea name="observaciones" rows="5" cols="30"><?php echo $articulo->observaciones?></textarea>
    </li>
    <li>
        <label><strong>Proveedor</strong></label>
        <input type="text" name="proveedor" id="proveedor" size="30" value="<?php echo $proveedor->nombre; ?>"/> <a href="#" id="crear_proveedor" title="Dar de alta un Proveedor">+</a>
    </li>
    <li>
        <label>Imagen</label>
        <input type="file" name="imagen1"/> (JPG, PNG ó GIF)
    </li>
    <li>
        <label>Imagen 2</label>
        <input type="file" name="imagen2"/> (JPG, PNG ó GIF)
    </li>
    <li>
        <label>Imagen 3</label>
        <input type="file" name="imagen3"/> (JPG, PNG ó GIF)
    </li>
    </ol>
    </fieldset>
    <fieldset class="submit">
    	<input type="hidden" name="modificar" value="<?php echo $modificar; ?>"/>
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

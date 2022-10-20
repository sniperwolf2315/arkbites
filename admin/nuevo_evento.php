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
    $(function() {
        $("#fecha_prevista").datepicker({dateFormat: 'dd-mm-yy'});
        $("#fecha_aviso").datepicker({dateFormat: 'dd-mm-yy'});
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
<!-- Popup para crear un proveedor -->
<script type="text/javascript">
$(function() {
    $("#crear_proveedor").button();
    $("#crear_proveedor").click(function(e) {
        e.preventDefault();
        $("#dialogo_proveedor").dialog("open");
    });
});
</script>
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
<script type="text/javascript">
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
</script>
<!--  Diálogos para ventanas emergentes  -->
<?php 
    include("../include/arkabytes/dialogo_cliente.php");
    include("../include/arkabytes/dialogo_proveedor.php");
    
	$modificar = "";
	
	if (isset($_REQUEST["modificar"]))
		$modificar = $_REQUEST["modificar"];
	
	if (isset($modificar)) {
		require_once("../config/abc-config.php");
		require_once("../include/arkabytes/bbdd.php");
		$bbdd = new BBDD();
		$evento = $bbdd->get_tarea_por_id($modificar);
		
		$aviso = 0;
		$nombre_cliente = "";
		if ($evento->id_cliente != "")
			$nombre_cliente = $bbdd->get_cliente_por_id($evento->id_cliente)->nombre_completo;
		$nombre_proveedor = "";
		if ($evento->id_proveedor != "")
			$nombre_proveedor = $bbdd->get_proveedor_por_id($evento->id_proveedor)->nombre;
		
		$fecha_prevista = "";
		if ($evento->fecha_prevista != "")
			$fecha_prevista = date("d-m-Y", strtotime($evento->fecha_inicio));
		$fecha_aviso = "";
		if ($evento->fecha_aviso != "")
			$fecha_aviso = date("d-m-Y", strtotime($evento->fecha_aviso));
	}
?>
<form id="formulario" method="post" action="run/_nuevo_evento.php">
    <fieldset>
    <legend>Datos de Evento</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label for="nombre"><strong>Nombre</strong></label>
        <input type="text" name="nombre" id="nombre" class="required" size="30" value="<?php echo $evento->nombre;?>"/>
    </li>
    <li>
        <label>Descripción</label>
        <textarea rows="10" cols="30" name="descripcion" id="descripcion"><?php echo $evento->descripcion; ?></textarea>
    </li>
    <li>
        <label><strong>Fecha Prevista</strong></label>
        <input type="text" name="fecha_prevista" class="required" id="fecha_prevista" size="10" value="<?php echo $fecha_prevista;?>"/> (dd-mm-aaaa)
    </li>
    <li>
        <label>Ubicación</label>
        <input type="text" name="ubicacion" id="ubicación" size="20" value="<?php echo $evento->ubicacion;?>"/>
    </li>
    <li>
        <label for="cliente">Cliente</label>
        <input type="text" name="cliente" id="cliente" size="30" value="<?php echo $nombre_cliente;?>"/> <a href="#" id="crear_cliente" title="Dar de alta un Cliente">+</a>   
    </li>
    <li>
        <label for="proveedor">Proveedor</label>
        <input type="text" name="proveedor" id="proveedor" size="30" value="<?php echo $nombre_proveedor;?>"/> <a href="#" id="crear_proveedor" title="Dar de alta un Proveedor">+</a>   
    </li>
    <li>
        <label>Aviso</label>
        <input type="checkbox" name="aviso" value="<?php echo $aviso;?>"/> (No disponible en esta versión)
    </li>
    <li>
        <label>Fecha Aviso</label>
        <input type="text" name="fecha_aviso" id="fecha_aviso" size="10" value="<?php echo $fecha_aviso;?>"/> (dd-mm-aaaa)
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
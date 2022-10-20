<?php

?>
<script type="text/javascript">
jQuery(function() {

    $(document).ready(function() {
        $('#usuario').focus();
    });
});
</script>

<?php
	$proveedor = new Proveedor();
	$modificar = "";
	
	if (isset($_REQUEST["modificar"]))
		$modificar = $_REQUEST["modificar"];
	
	if (isset($modificar)) {
		require_once("../config/abc-config.php");
		require_once("../include/arkabytes/bbdd.php");
		$bbdd = new BBDD();
		$proveedor = $bbdd->get_proveedor_por_id($modificar);
	}
?>

<span class="titulocelda">Nuevo Proveedor</span>

<form id="formulario" method="post" action="run/_nuevo_proveedor.php">
    <fieldset>
    <legend>Datos Fiscales</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" id="usuario" size="30" class="required" value="<?php echo $proveedor->nombre; ?>"/>
    </li>
    <li>
        <label>NIT</label>
        <input type="text" name="cif" size="9" maxlength="9" value="<?php echo $proveedor->cif; ?>"/>
    </li>
    <li>
        <label>Dirección</label>
        <input type="text" name="direccion" size="40" value="<?php echo $proveedor->direccion; ?>"/>
    </li>
    <li>
        <label>CIUDAD</label>
        <input type="text" name="poblacion" size="30" value="<?php echo $proveedor->poblacion; ?>"/>
    </li>
    <li>
        <label>DEPARTAMENTO</label>
        <input type="text" name="provincia" size="20" value="<?php echo $proveedor->provincia; ?>"/>
    </li>
    <li>
        <label>CP</label>
        <input type="text" name="cp" size="5" maxlength="5" value="<?php echo $proveedor->cp; ?>"/>
    </li>
    <li>
        <label for="pais">País</label>
        <input type="text" name="pais" id="pais" size="20" value="Colombia" value="<?php echo $proveedor->pais; ?>"/>
    </li>
    <li>
        <label>Teléfono</label>
        <input type="text" name="telefono" size="20" value="<?php echo $proveedor->telefono; ?>"/>
    </li>
    <li>
        <label>Móvil</label>
        <input type="text" name="movil" size="20" value="<?php echo $proveedor->movil; ?>"/>
    </li>
    <li>
        <label>Fax</label>
        <input type="text" name="fax" size="20" value="<?php echo $proveedor->fax; ?>"/>
    </li>
    </ol>
    </fieldset>

    <fieldset>
    <legend>Otros Datos</legend>
    <ol>
    <li>
        <label>E-Mail</label>
        <input type="text" name="email" size="30" class="email" value="<?php echo $proveedor->email; ?>"/>
    </li>
    <li>
        <label>Página Web</label>
        <input type="text" name="web" size="30" class="url" value="<?php echo $proveedor->web; ?>"/>
    </li>
    <li>
        <label>Observaciones</label>
        <textarea name="observaciones" cols="30" rows="5"><?php echo $proveedor->observaciones; ?></textarea>
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

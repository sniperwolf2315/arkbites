<?php

?>
<span class="titulocelda">Nueva Forma de Envío</span>

<?php 
$modificar = "";
if (isset($_REQUEST["modificar"]))
    $modificar = $_REQUEST["modificar"];

if (isset($modificar)) {
    require_once("../config/abc-config.php");
    require_once("../include/arkabytes/bbdd.php");

    $bbdd = new BBDD();
    $forma_envio = $bbdd->get_forma_envio_por_id($modificar);
}
?>

<form id="formulario" method="post" action="run/_nueva_forma_envio.php">
    <fieldset>
    <legend>Datos de Envío</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" size="20" class="required" value="<?php echo $forma_envio->nombre; ?>"/>
    </li>
    <li>
        <label>Descripcion</label>
        <input type="text" name="descripcion" size="40" value="<?php echo $forma_envio->descripcion; ?>"/>
    </li>
    <li>
        <label>Coste</label>
        <input type="text" name="coste" size="5" value="<?php echo str_replace(".", ",", round($forma_envio->coste, 2)); ?>"/>
    </li>
    <li>
        <label>Días</label>
        <input type="text" name="dias" size="5" value="<?php echo $forma_envio->dias; ?>"/>
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

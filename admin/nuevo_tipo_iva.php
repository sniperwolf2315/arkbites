<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */
?>
<span class="titulocelda">Nuevo Tipo de IVA</span>

<?php 
$modificar = "";
if (isset($_REQUEST["modificar"]))
    $modificar = $_REQUEST["modificar"];

if (isset($modificar)) {
    require_once("../config/abc-config.php");
    require_once("../include/arkabytes/bbdd.php");

    $bbdd = new BBDD();
    $tipo_iva = $bbdd->get_tipo_iva_por_id($modificar);
}
?>

<form id="formulario" method="post" action="run/_nuevo_tipo_iva.php">
    <fieldset>
    <legend>Datos de Tipo de IVA</legend>
    <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
    <ol>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" size="20" class="required" value="<?php echo $tipo_iva->nombre; ?>"/>
    </li>
    <li>
        <label>Descripcion</label>
        <input type="text" name="descripcion" size="40" value="<?php echo $tipo_iva->descripcion; ?>"/>
    </li>
    <li>
        <label><strong>Cantidad</strong></label>
        <input type="text" name="cantidad" size="5" class="required" value="<?php echo str_replace(".", ",", round($tipo_iva->cantidad * 100, 2)); ?>"/> (en %)
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

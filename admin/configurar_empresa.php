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
jQuery(function() {

    $(document).ready(function() {
        $('#nombre').focus();
    });
});
</script>

<?php 
	require_once("../include/arkabytes/bbdd.php");

	$bbdd = new BBDD();
	$fila = $bbdd->ejecuta_escalar("SELECT * FROM empresa");
?>

<span class="titulocelda">Configuración de Empresa</span>
<form id="formulario" method="post" action="run/_configurar_empresa.php" enctype="multipart/form-data">
    <fieldset>
    <legend>Datos de la Empresa</legend>
    <ol>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" id="nombre" size="20" class="required" value="<?php echo $fila["nombre"]; ?>"/>
    </li>
    <li>
        <label><strong>Dirección</strong></label>
        <input type="text" name="direccion" size="40" value="<?php echo $fila["direccion"]; ?>"/>
    </li>
    <li>
        <label><strong>Población</strong></label>
        <input type="text" name="poblacion" size="20" value="<?php echo $fila["poblacion"]; ?>"/>
    </li>
    <li>
        <label><strong>Provincia</strong></label>
        <input type="text" name="provincia" size="20" value="<?php echo $fila["provincia"]; ?>"/>
    </li>
    <li>
        <label><strong>CP</strong></label>
        <input type="text" name="cp" size="5" value="<?php echo $fila["cp"]; ?>"/>
    </li>
	<li>
        <label>Logotipo</label>
        <input type="file" name="logo"/> (tamaño aprox.: 750 x 146)
    </li>
    <li>
        <label>Logotipo para Informes</label>
        <input type="file" name="logo_informes"/> (tamaño aprox.: 250 x 250)
    </li>
    </ol>
    </fieldset>
    <fieldset class="submit">
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

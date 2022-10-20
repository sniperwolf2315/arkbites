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
	$tips = $bbdd->ejecuta_escalar("SELECT valor FROM opciones WHERE nombre = 'tips'");
?>

<span class="titulocelda">Configuración de Aplicación</span>
<form id="formulario" method="post" action="run/_configurar_aplicacion.php" enctype="multipart/form-data">
    <fieldset>
    <legend>Datos de Aplicación</legend>
    <ol>
    <li>
        <label>Mostrar consejos</label>
        <input type="checkbox" name="tips" id="tips" value="1" <?php if ($tips["valor"] == "1") echo "checked"?>/> (Muestra consejos en algunas pantallas ** De esta forma **)
    </li>
    </ol>
    </fieldset>
    <fieldset class="submit">
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

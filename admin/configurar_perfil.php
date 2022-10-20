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
        $('#usuario').focus();
    });
});
</script>

<?php 
	$bbdd = new BBDD();
	
	$usuario = unserialize($_SESSION["usuario"]);
?>

<span class="titulocelda">Configuración de Perfil</span>
<form id="formulario" method="post" action="run/_configurar_perfil.php" enctype="multipart/form-data">
    <fieldset>
    <legend>Datos del Usuario</legend>
    <ol>
    <li>
        <label><strong>Usuario</strong></label>
        <input type="text" name="usuario" id="nombre" size="15" class="required" value="<?php echo $usuario->usuario; ?>"/>
    </li>
    <li>
        <label>Contraseña</label> 
        <input type="password" name="contrasena1" size="10" value=""/> (sólo se modificará si escribe algún valor)
    </li>
    <li>
        <label>Contraseña (repetida)</label> 
        <input type="password" name="contrasena2" size="10" value=""/> (sólo se modificará si escribe algún valor)
    </li>
    <li>
        <label><strong>Nombre</strong></label>
        <input type="text" name="nombre" size="20" class="required" value="<?php echo $usuario->nombre; ?>"/>
    </li>
    <li>
        <label><strong>E-mail</strong></label>
        <input type="text" name="email" size="20" class="required" value="<?php echo $usuario->email; ?>"/>
    </li>
    </ol>
    </fieldset>
    <fieldset class="submit">
    	<input type="hidden" name="old_usuario" value="<?php echo $usuario->usuario; ?>"/>
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

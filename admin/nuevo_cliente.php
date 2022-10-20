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
// expande/oculta la capa
$(function() {
    $( "#acordeon" ).accordion({
        autoHeight: false,
        navigation: true
    });
});
</script>

<?php
	$modificar = "";
	
	if (isset($_REQUEST["modificar"]))
		$modificar = $_REQUEST["modificar"];
	
	if (isset($modificar)) {
		require_once("../config/abc-config.php");
		require_once("../include/arkabytes/bbdd.php");
		$bbdd = new BBDD();
		$cliente = $bbdd->get_cliente_por_id($modificar);
	}
?>

<span class="titulocelda">Nuevo Cliente</span>

<form id="formulario" method="post" action="run/_nuevo_cliente.php">
<div id="acordeon">
    <h3><a href="#">Datos de Cliente</a></h3>
    <div>
        <fieldset>
        <legend>Datos Fiscales</legend>
        <span class="tip">** Recuerda que puedes avanzar por las cajas de texto pulsando Tab **</span>
        <ol>
        <li>
            <label for="nombre"><strong>Nombre</strong></label>
            <input type="text" name="nombre" size="30" class="required" value="<?php echo $cliente->nombre; ?>"/>
        </li>
        <li>
            <label for="apellidos"><strong>Apellidos</strong></label>
            <input type="text" name="apellidos" size="30" class="required" value="<?php echo $cliente->apellidos; ?>"/>
        </li>
        <li>
            <label for="empresa">Empresa</label>
            <input type="text" name="empresa" size="30" value="<?php echo $cliente->empresa; ?>"/>
        </li>
        <li>
            <label>NIT</label>
            <input type="text" name="cif" size="9" maxlength="9" value="<?php echo $cliente->cif; ?>"/>
        </li>
        <li>
            <label>Dirección</label>
            <input type="text" name="direccion" size="40" value="<?php echo $cliente->direccion; ?>"/>
        </li>
        <li>
            <label>CIUDAD</label>
            <input type="text" name="poblacion" size="30" value="<?php echo $cliente->poblacion; ?>"/>
        </li>
        <li>
            <label>DEPARTAMENTO</label>
            <input type="text" name="provincia" size="20" value="<?php echo $cliente->provincia; ?>"/>
        </li>
        <li>
            <label>CP</label>
            <input type="text" name="cp" size="5" maxlength="5" value="<?php echo $cliente->cp; ?>"/>
        </li>
        <li>
            <label for="pais">País</label>
            <input type="text" name="pais" id="pais" size="20" value="COLOMBIA"/>
        </li>
        </ol>
        </fieldset>

        <fieldset> 
        <legend>Datos de contacto</legend>
        <ol>
        <li>
            <label>E-Mail</label>
            <input type="text" name="email" size="20" value="<?php echo $cliente->email; ?>"/>
        </li>
        <li>
            <label>Móvil</label>
            <input type="text" name="movil" size="12" value="<?php echo $cliente->movil; ?>"/>
        </li>
        <li>
            <label>Teléfono</label>
            <input type="text" name="telefono" size="12" value="<?php echo $cliente->telefono; ?>"/>
        </li>
        <li>
            <label>Fax</label>
            <input type="text" name="fax" size="12" value="<?php echo $cliente->fax; ?>"/>
        </li>
        </ol>
        </fieldset>

        <fieldset>
        <legend>Otros Datos</legend>
        <ol>
        <li>
            <label>Página Web</label>
            <input type="text" name="web" size="30" value="<?php echo $cliente->web; ?>"/>
        </li>
        <li>
            <label>Observaciones</label>
            <textarea name="observaciones" cols="50" rows="3"><?php echo $cliente->observaciones; ?></textarea>
        </li>
        </ol>
        </fieldset>
    </div>
    <h3><a href="#">Datos de Usuario</a></h3>
    <div>
        <fieldset>
        <legend>Datos de Usuario</legend>
        <span class="error">Sólo es necesario si el cliente accederá a su zona privada (no implementado en esta versión)</span>
        <ol>
        <li>
            <label>Usuario</label>
            <input type="text" name="usuario" id="usuario" size="20"/>
        </li>
        <li>
            <label>Contraseña</label>
            <input type="password" name="contrasena" size="20" minlenght="2"/>
        </li>
        <li>
            <label>Contraseña</label>
            <input type="password" name="contrasena2" size="20" minlenght="2"/>
        </li>
        </ol>
        </fieldset>
    </div>
</div>
    <fieldset class="submit">
    	<input type="hidden" name="modificar" value="<?php echo $modificar; ?>"/>
        <input type="submit" value="Enviar"/> 
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

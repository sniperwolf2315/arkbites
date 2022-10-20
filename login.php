<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

 require_once("config/abc-config.php");
?>
<script type="text/javascript">
jQuery(function() {
    // Indicador de carga
    var loader = jQuery('<div id="loader">Enviando . . .</div>')
        .css({position: "relative", bottom: "0px", left: "center", color: "#690D1A", padding: "5px"})
        .appendTo("#mensaje")
        .hide();

    jQuery("#login").ajaxStart(function() {
        loader.show();
    }).ajaxStop(function() {
        loader.hide();
    }).ajaxError(function(a, b, e) {
        throw e;
    });

    var v = jQuery("#login").validate({
        submitHandler: function(formulario) {
            jQuery(formulario).ajaxSubmit({
                target: "#resultado",
                success: function(responseText) {
                    if (responseText == "admin") {
                        $("#resultado").hide();
<?php
                        echo "window.location = '" . BASE_URL . "admin/?id=inicio'\n";
?>
                    }
                    else if (responseText == "") {
<?php
                        echo "window.location = '" . BASE_URL . "?id=inicio'\n";
?>
                    }
                }
            });
        }
    });
});
</script>
<div style="margin: auto; color: red;"><?php if (isset($mensaje)) echo $mensaje; ?></div>
<form id="login" method="post" action="run/_login.php">
    <fieldset class="login">
        <legend>Login</legend>
        <ol>
            <li>
            <label>Usuario:</label>
            <input type="text" name="usuario" class="required"/>
            </li>
            <li>
            <label>Contraseña:</label>
            <input type="password" name="contrasena" class="required"/>
            </li>
        </ol>
    </fieldset>
    <fieldset class="submit">
        <input type="submit" value="Entrar"/>
    </fieldset>
</form>
<div id="mensaje"></div>
<div id="resultado"></div>

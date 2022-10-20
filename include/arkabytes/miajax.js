/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

// Función para la validación de formularios y procesado utilizando Ajax
jQuery(function() {
    // Indicador de carga
    var loader = jQuery('<div id="loader">Enviando . . .</div>')
        .css({position: "relative", bottom: "0px", left: "center", color: "#690D1A", padding: "5px"})
        .appendTo("#mensaje")
        .hide();

    jQuery("#formulario").ajaxStart(function() {
        loader.show();
    }).ajaxStop(function() {
        loader.hide();
    }).ajaxError(function(a, b, e) {
        throw e;
    });

    var v = jQuery("#formulario").validate({
        submitHandler: function(formulario) {
            jQuery(formulario).ajaxSubmit({
                target: "#resultado",
                success: function(responseText, statusText) {
                    $("#resultado").html(responseText);
                    // Limpia los campos del formulario
                    $("#formulario").each (function() {
                    	this.reset();
                    });              
                }
            });
        }
    });
});

// Autocompletado de campo País en formularios
$(function() {
    var paises = ["Francia", "España", "Inglaterra", "Portugal"];
    $("#pais").autocomplete({
        source: paises
    });
});

// Foco para el primer input de un formulario
jQuery(function() {

    $(document).ready(function() {
        $(':input:first').focus();
    });
});

//Diálogo para crear un artículo
$(function() {
    $("#dialogo_articulo").dialog({
        autoOpen: false,
        height: 260,
        width: 350,
        modal: true,
        buttons: {
            "Dar de alta": function() {
                $("#form_alta_articulo").ajaxSubmit({
                    target: "#resultado_alta_articulo"
                });
                $("#articulo").val($("#nombre_articulo").val());
                $(this).dialog("close");
            },
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});

//Diálogo para crear un cliente
$(function() {
    $("#dialogo_cliente").dialog({
        autoOpen: false,
        height: 260,
        width: 350,
        modal: true,
        buttons: {
            "Dar de alta": function() {
                $("#form_alta_cliente").ajaxSubmit({
                    target: "#resultado_alta_cliente"
                });
                $("#cliente").val($("#nombre_cliente").val() + " " + $("#apellidos_cliente").val());
                $(this).dialog("close");
            },
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});

// Diálogo para crear un proveedor
$(function() {
    $("#dialogo_proveedor").dialog({
        autoOpen: false,
        height: 260,
        width: 350,
        modal: true,
        buttons: {
            "Dar de alta": function() {
                $("#form_alta_proveedor").ajaxSubmit({
                    target: "#resultado_alta_proveedor"
                });
                $("#proveedor").val($("#nombre_proveedor").val());
                $(this).dialog("close");
            },
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});

//Diálogo para enviar un email
$(function() {
    $("#dialogo_email").dialog({
        autoOpen: false,
        height: 300,
        width: 500,
        modal: true,
        buttons: {
            "Enviar": function() {
                $("#form_enviar_email").ajaxSubmit({
                    target: "#resultado_enviar_email"
                });
            },
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});

//Diálogo para el carrito de un pedido
$(function() {
    $("#carrito").dialog({
        autoOpen: false,
        height: 400,
        width: 800,
        modal: false,
        buttons: {
            "Cerrar": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
});

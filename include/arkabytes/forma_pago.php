<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class FormaPago {

    public $nombre;
    public $descripcion;
    public $coste;

    function __construct($nombre=NULL, $descripcion=NULL, $coste=NULL) {

    	if (func_num_args() == 0)
    		return

    	$this->nombre = $nombre;
    	$this->descripcion = $descripcion;
    	$this->coste = $coste;
    }

    public static function nueva_forma_pago($fila) {

    	$forma_pago = new FormaPago();
    	$forma_pago->nombre = $fila["nombre"];
    	$forma_pago->descripcion = $fila["descripcion"];
    	$forma_pago->coste = $fila["coste"];

    	return $forma_pago;
    }
}
?>

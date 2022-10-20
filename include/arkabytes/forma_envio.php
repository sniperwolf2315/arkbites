<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class FormaEnvio {

    public $nombre;
    public $descripcion;
    public $coste;
    public $dias;

    function __construct($nombre = NULL, $descripcion = NULL, $coste = NULL, $dias = NULL) {

    	if (func_num_args() == 0)
    		return;

    	$this->nombre = $nombre;
    	$this->descripcion = $descripcion;
    	$this->coste = $coste;
    	$this->dias = $dias;
    }

    public static function nueva_forma_envio($fila) {

    	$forma_envio = new FormaEnvio();
    	$forma_envio->nombre = $fila["nombre"];
    	$forma_envio->descripcion = $fila["descripcion"];
    	$forma_envio->coste = $fila["coste"];
    	$forma_envio->dias = $fila["dias"];

    	return $forma_envio;
    }
}
?>

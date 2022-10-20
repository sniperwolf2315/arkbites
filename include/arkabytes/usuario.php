<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Usuario {

    public $usuario;
    public $nombre;
    public $email;
    public $nivel;

    function __construct($usuario = NULL, $nombre = NULL, $email = NULL, $nivel = NULL) {

    	if (func_num_args() == 0)
    		return;

    	$this->usuario = $usuario;
    	$this->nombre = $nombre;
    	$this->email = $email;
    	$this->nivel = $nivel;
    }

    public static function nuevo_usuario($fila) {

    	$usuario = new Usuario();
    	$usuario->usuario = $fila["usuario"];
    	$usuario->nombre = $fila["nombre"];
    	$usuario->email = $fila["email"];
    	$usuario->nivel = $fila["nivel"];

    	return $usuario;
    }
}
?>

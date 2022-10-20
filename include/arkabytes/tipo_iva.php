<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class TipoIva {

    public $nombre;
    public $descripcion;
    public $cantidad;

    public static function nuevo_tipo_iva($fila) {

    	$tipo_iva = new TipoIva();
    	$tipo_iva->nombre = $fila["nombre"];
    	$tipo_iva->descripcion = $fila["descripcion"];
    	$tipo_iva->cantidad = $fila["cantidad"];

    	return $tipo_iva;
    }
}
?>

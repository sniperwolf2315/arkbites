<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Articulo {

    public $id;
    public $nombre;
    public $descripcion;
    public $stock;
    public $precio_coste;
    public $precio_venta;
    public $observaciones;
    public $imagen1;
    public $imagen2;
    public $imagen3;
    public $miniatura;
    public $id_proveedor;
    public $id_tipo_iva;

    public static function nuevo_articulo($fila) {

        $articulo = new Articulo();
        $articulo->id = $fila["id"];
        $articulo->nombre = $fila["nombre"];
        $articulo->descripcion = $fila["descripcion"];
        $articulo->stock = $fila["stock"];
        $articulo->precio_coste = $fila["precio_coste"];
        $articulo->precio_venta = $fila["precio_venta"];
        $articulo->observaciones = $fila["observaciones"];
        $articulo->imagen1 = $fila["imagen1"];
        $articulo->imagen2 = $fila["imagen2"];
        $articulo->imagen3 = $fila["imagen3"];
        $articulo->miniatura = $fila["miniatura"];
        $articulo->id_proveedor = $fila["id_proveedor"];
        $articulo->id_tipo_iva = $fila["id_tipo_iva"];

        return $articulo;
    }
}
?>

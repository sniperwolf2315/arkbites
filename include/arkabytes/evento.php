<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Evento {

    public $id;
    public $nombre;
    public $descripcion;
    public $fecha_prevista;
    public $ubicacion;
    public $id_cliente;
    public $id_proveedor;
    public $aviso;
    public $fecha_aviso;
    
    public static function nuevo_evento($fila) {

        $evento = new Tarea();
        $evento->id = $fila["id"];
        $evento->nombre = $fila["nombre"];
        $evento->descripcion = $fila["descripcion"];
        $evento->fecha_prevista = $fila["fecha_prevista"];
        $evento->ubicacion = $fila["ubicacion"];
        $evento->id_cliente = $fila["id_cliente"];
        $evento->id_proveedor = $fila["id_proveedor"];
        $evento->aviso = $fila["aviso"];
        $evento->fecha_aviso = $fila["fecha_aviso"];
        
        return $evento;
    }
}
?>

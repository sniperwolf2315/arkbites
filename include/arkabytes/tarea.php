<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Tarea {

    public $id;
    public $nombre;
    public $descripcion;
    public $fecha_prevista;
    public $fecha_inicio;
    public $fecha_fin;
    public $ubicacion;
    public $id_cliente;
    public $id_proveedor;
    public $id_pedido;
    public $estado;
    public $aviso;
    public $fecha_aviso;
    
    public static function nueva_tarea($fila) {

        $tarea = new Tarea();
        $tarea->id = $fila["id"];
        $tarea->nombre = $fila["nombre"];
        $tarea->descripcion = $fila["descripcion"];
        $tarea->fecha_prevista = $fila["fecha_prevista"];
        $tarea->fecha_inicio = $fila["fecha_inicio"];
        $tarea->fecha_fin = $fila["fecha_fin"];
        $tarea->ubicacion = $fila["ubicacion"];
        $tarea->id_cliente = $fila["id_cliente"];
        $tarea->id_proveedor = $fila["id_proveedor"];
        $tarea->id_pedido = $fila["id_pedido"];
        $tarea->estado = $fila["estado"];
        $tarea->aviso = $fila["aviso"];
        $tarea->fecha_aviso = $fila["fecha_aviso"];
        
        return $tarea;
    }
}
?>

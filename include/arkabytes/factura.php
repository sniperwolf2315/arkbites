<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Factura {

    public $id;
    public $numero_factura;
    public $fecha;
    public $fecha_vencimiento;
    public $estado;
    public $comentarios;
    public $observaciones;
    public $base_imponible;
    public $iva;
    public $importe;
    public $nombre_cliente;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $cp;
    public $forma_pago;
    public $numero_pedido;
    public $id_cliente;

    /**
     * Crea y devuelve un nuevo pedido a partir de la fila del resultado de una consulta
     * @param fila La fila de la Base de Datos con los datos de la factura
     * @return El objeto factura que se ha creado
     */
    public static function nueva_factura($fila) {

        $factura = new Factura();
        $factura->id = $fila["id"];
        $factura->numero_factura = $fila["numero_factura"];
        $factura->fecha = $fila["fecha"];
        $factura->fecha_vencimiento = $fila["fecha_vencimiento"];
        $factura->estado = $fila["estado"];
        $factura->comentarios = $fila["comentarios"];
        $factura->observaciones = $fila["observaciones"];
        $factura->base_imponible = $fila["base_imponible"];
        $factura->iva = $fila["iva"];
        $factura->importe = $fila["importe"];
        $factura->nombre_cliente = $fila["nombre_cliente"];
        $factura->direccion = $fila["direccion"];
        $factura->poblacion = $fila["poblacion"];
        $factura->provincia = $fila["provincia"];
        $factura->cp = $fila["cp"];
        $factura->forma_pago = $fila["forma_pago"];
        $factura->numero_pedido = $fila["numero_pedido"];
        $factura->id_cliente = $fila["id_cliente"];

        return $factura;
    }
}
?>

<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Pedido {

    public $id;
    public $numero_pedido;
    public $fecha;
    public $fecha_entrega;
    public $estado;
    public $comentarios;
    public $observaciones;
    public $base_imponible;
    public $iva;
    public $importe;
    public $id_cliente;
    public $coste_envio;
    public $coste_forma_pago;
    public $dias_envio;
    public $forma_envio;
    public $forma_pago;
    public $terminado;

    /**
     * Crea y devuelve un nuevo pedido a partir de la fila del resultado de una consulta
     * @param fila La fila de la Base de Datos con los datos del pedido
     * @return El objeto pedido que se ha creado
     */
    public static function nuevo_pedido($fila) {

        $pedido = new Pedido();
        $pedido->id = $fila["id"];
        $pedido->numero_pedido = $fila["numero_pedido"];
        $pedido->fecha = $fila["fecha"];
        $pedido->fecha_entrega = $fila["fecha_entrega"];
        $pedido->estado = $fila["estado"];
        $pedido->comentarios = $fila["comentarios"];
        $pedido->observaciones = $fila["observaciones"];
        $pedido->base_imponible = $fila["base_imponible"];
        $pedido->iva = $fila["iva"];
        $pedido->importe = $fila["importe"];
        $pedido->id_cliente = $fila["id_cliente"];
        $pedido->coste_envio = $fila["coste_envio"];
        $pedido->coste_forma_pago = $fila["coste_forma_pago"];
        $pedido->dias_envio = $fila["dias_envio"];
        $pedido->forma_envio = $fila["forma_envio"];
        $pedido->forma_pago = $fila["forma_pago"];
        $pedido->terminado = $fila["terminado"];

        return $pedido;
    }
}
?>

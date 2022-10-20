<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

class Cliente {

    public $id;
    public $nombre;
    public $apellidos;
    public $nombre_completo;
    public $empresa;
    public $cif;
    public $direccion;
    public $poblacion;
    public $provincia;
    public $cp;
    public $pais;
    public $telefono;
    public $movil;
    public $fax;
    public $email;
    public $web;
    public $observaciones;

    /**
     * Crea y devuelve un nuevo cliente a partir de la fila del resultado de una consulta
     * @param fila La fila de la Base de Datos con los datos del cliente
     * @return El objeto cliente que se ha creado
     */
    public static function nuevo_cliente($fila) {

        $cliente = new Cliente();
        $cliente->id = $fila["id"];
        $cliente->nombre = $fila["nombre"];
        $cliente->apellidos = $fila["apellidos"];
        $cliente->nombre_completo = $fila["nombre_completo"];
        $cliente->empresa = $fila["empresa"];
        $cliente->cif = $fila["cif"];
        $cliente->direccion = $fila["direccion"];
        $cliente->poblacion = $fila["poblacion"];
        $cliente->provincia = $fila["provincia"];
        $cliente->cp = $fila["cp"];
        $cliente->telefono = $fila["telefono"];
        $cliente->movil = $fila["movil"];
        $cliente->fax = $fila["fax"];
        $cliente->email = $fila["email"];
        $cliente->web = $fila["web"];
        $cliente->observaciones = $fila["observaciones"];

        return $cliente;
    }
}
?>

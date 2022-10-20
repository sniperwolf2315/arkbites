<?php
/*
 * ABC ERP - Sistema ERP para PYMEs
 * Copyright (C) 2012 Santiago Faci <santi@arkabytes.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

class Proveedor {

    public $id;
    public $nombre;
    public $contacto;
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
     * Crea y devuelve un nuevo proveedor a partir de la fila del resultado de una consulta
     * @param fila La fila de la Base de Datos con los datos del proveedor
     * @return El objeto proveedor que se ha creado
     */
    public static function nuevo_proveedor($fila) {

        $proveedor = new Proveedor();
        $proveedor->id = $fila["id"];
        $proveedor->nombre = $fila["nombre"];
        $proveedor->contacto = $fila["contacto"];
        $proveedor->cif = $fila["cif"];
        $proveedor->direccion = $fila["direccion"];
        $proveedor->poblacion = $fila["poblacion"];
        $proveedor->provincia = $fila["provincia"];
        $proveedor->cp = $fila["cp"];
        $proveedor->telefono = $fila["telefono"];
        $proveedor->movil = $fila["movil"];
        $proveedor->fax = $fila["fax"];
        $proveedor->email = $fila["email"];
        $proveedor->web = $fila["web"];
        $proveedor->observaciones = $fila["observaciones"];

        return $proveedor;
    }
}
?>

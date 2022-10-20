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

    include("_check_login.php");
    require_once("../../include/arkabytes/bbdd.php");
 
    $id = $_REQUEST["eliminar"];

    if ($id == "") {
        echo "<span class='error'>¡ERROR! No se ha indicado la forma de envío</span>";
        return;
    }

    $bbdd = new BBDD();

    $sentencia = "DELETE FROM formas_envio WHERE id = " . $id;

    $resultado = $bbdd->ejecuta_sentencia($sentencia);
    if (!$resultado) {
        echo "<span class='error'>¡ERROR! No se ha podido eliminar la forma de envío. Inténtalo de nuevo</span>";
        return;
    }
    
    echo "La forma de envío ha sido eliminada con éxito";
?>

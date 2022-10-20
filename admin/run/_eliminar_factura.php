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
        echo "<span class='error'>¡ERROR! No se ha indicado la factura</span>";
        return;
    }

    $bbdd = new BBDD();
    $bbdd->conexion->autocommit(FALSE);
    
   	$sql1 = "DELETE FROM facturas WHERE id = ?";
    $resultado = $bbdd->ejecuta_sentencia_i($sql1, "i", array($id));
    if (!$resultado) {
    	echo "<span class='error'>¡ERROR! No se ha podido eliminar la factura. Inténtalo de nuevo</span>";
    	$bbdd->conexion->rollback();
    	return;
    }
    
    $sql2 = "DELETE FROM detalles_factura WHERE id_factura = ?";
    $resultado = $bbdd->ejecuta_sentencia_i($sql2, "i", array($id));
    if (!$resultado) {
    	echo "<span class='error'>¡ERROR! No se ha podido eliminar la factura. Inténtalo de nuevo</span>";
    	$bbdd->conexion->rollback();
    	return;
    }
    
    echo "La Factura se ha eliminado con éxito";
    $bbdd->conexion->commit();
?>

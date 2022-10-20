<?php
/*
 * ABC ERP - Sistema ERP para PYMEs
 * Copyright (C) 2014 Santiago Faci <santi@arkabytes.com>
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
require_once("../include/informe_listado.php");

$busqueda_rapida = "";
if (isset($_REQUEST["busqueda_rapida"]))
    $busqueda_rapida = $_REQUEST["busqueda_rapida"];
$cabeceras = array("Nombre", "Teléfono", "E-mail", "Web");
$columnas = array("nombre", "telefono", "email", "web");
$anchuras = array(45, 45, 25, 65);
$bbdd = new BBDD();
$resultado = $bbdd->ejecuta_consulta("SELECT * FROM proveedores WHERE nombre LIKE '%" . $busqueda_rapida . "%'");

$informe = new InformeListado();
$informe->crear("LISTADO DE PROVEEDORES", $cabeceras, $columnas, $resultado, $anchuras);
$informe->escribirDetalle($resultado);
$informe->ver();

$resultado->close();
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
?>
<div id="listado">
    <table class="cebra">
    <thead class="cabecera">
    <tr class="cabecera">
    <td>#</td>
    <td>Número</td>
    <td>Cliente</td>
    <td>Fecha</td>
    <td>Estado</td>
    <td>Observaciones</td>
    </tr>
    </thead>
    <tbody class="scroll">
<?php

require_once("../config/abc-config.php");
require_once("../include/arkabytes/bbdd.php");

$bbdd = new BBDD();

$resultado = $bbdd->ejecuta_consulta("SELECT id, numero_pedido, id_cliente, fecha, estado, observaciones FROM pedidos WHERE terminado = 0");

if ($resultado == null) {
    echo "<td colspan='8' style='text-align:center'><span class='titulocelda'>## Sin Datos ##</span></td>\n";
}
else {
    
    while ($fila = $resultado->fetch_array()) {

        $cliente = $bbdd->get_cliente_por_id($fila["id_cliente"]);

        echo "<input type='checkbox' name='registro-'" . $fila["id"] . "/>";
        echo "<td>" . $fila["id"] . "</td>\n";
        echo "<td>" . $fila["numero_pedido"] . "</td>\n";
        echo "<td><a class='popup' title='Ver cliente' href='ver_cliente.php?id=" . $fila["id_cliente"] . 
            "'>" . $cliente->nombre . "</a></td>\n";
        echo "<td>" . $fila["fecha"] . "</td>\n";
        echo "<td>" . $fila["estado"] . "</td>\n";
        echo "<td>" . $fila["observaciones"] . "</td>\n";
        echo "</tr>\n";
    }

    $resultado->close();
}
?>
</tbody>
</table>
</div>
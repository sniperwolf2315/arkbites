<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

    include("_check_login.php");
    require_once("../../include/arkabytes/bbdd.php");

    $valores = array();
 
    $term = $_GET["term"];

    $bbdd = new BBDD();

    $resultado = $bbdd->ejecuta_consulta("SELECT numero_pedido FROM pedidos WHERE " . 
        "numero_pedido LIKE '%" . $term . "%' OR comentario LIKE '%" . $term . "%' OR observaciones LIKE '%" . $term . "%'");
    while ($fila = $resultado->fetch_array()) {
        
        $vector["value"] = $fila["numero_pedido"];
        array_push($valores, $vector);
    }

    echo json_encode($valores);
    
?>

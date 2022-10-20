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

$modificar = $_REQUEST["modificar"];

$nombre = $_REQUEST["nombre"];
$descripcion = $_REQUEST["descripcion"];
$cantidad = floatval(str_replace(",", ".", $_REQUEST["cantidad"])) / 100;

$bbdd = new BBDD();

if ($modificar != "") {

    $sql = "UPDATE tipos_iva SET nombre = ?, descripcion = ?, cantidad = ? WHERE id = ?";
    $statement = $bbdd->conexion->prepare($sql);
    $statement->bind_param("ssdi", $nombre, $descripcion, $cantidad, $modificar);
    $ok = $statement->execute();
    $statement->close();
    if (!$ok) {
        echo "<span class='error'>¡ERROR! No se ha podido modificar el tipo de IVA. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "El tipo de IVA <strong><em>" . $nombre . "</em></strong> se ha actualizado correctamente";
}
else {
    if ($nombre == "") {
        echo "<span class='error'>¡ERROR! Debes indicar al menos el nombre</span>";
        return;
    }

    if ($bbdd->es_tipo_iva($nombre)) {
        echo "<span class='error'>¡ERROR! El tipo de IVA <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
        return;
    }

    $sql = "INSERT INTO tipos_iva (nombre, descripcion, cantidad) VALUES (?, ?, ?)";
    $ok = $bbdd->ejecuta_sentencia_i($sql, "ssd", array($nombre, $descripcion, $cantidad));

    if (!$ok) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta el tipo de IVA. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "El tipo de IVA <strong><em>" . $nombre . "</em></strong> ha sido dada de alta con éxito";
}
?>

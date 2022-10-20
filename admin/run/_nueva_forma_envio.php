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
$coste = str_replace(",", ".", $_REQUEST["coste"]);
if ($coste == "")
    $coste = 0;
$dias = $_REQUEST["dias"];
if ($dias == "")
    $dias = 0;

$bbdd = new BBDD();

if ($modificar != "") {

    $sql = "UPDATE formas_envio SET nombre = ?, descripcion = ?, coste = ?, dias = ? WHERE id = ?";
    $statement = $bbdd->conexion->prepare($sql);
    $statement->bind_param("ssdii", $nombre, $descripcion, $coste, $dias, $modificar);
    $ok = $statement->execute();
    $statement->close();
    if (!$ok) {
        echo "<span class='error'>¡ERROR! No se ha podido modificar la Forma de Envío. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "La Forma de Envío <strong><em>" . $nombre . "</em></strong> se ha actualizado correctamente";
}
else {
    if ($nombre == "") {
        echo "<span class='error'>¡ERROR! Debes indicar al menos el nombre</span>";
        return;
    }

    if ($bbdd->es_forma_envio($nombre)) {
        echo "<span class='error'>¡ERROR! La Forma de Envío <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
        return;
    }

    $sentencia = "INSERT INTO formas_envio (nombre, descripcion, coste, dias) VALUES ('" . $nombre . "','" . $descripcion . "'," . $coste . "," . $dias . ")";

    $resultado = $bbdd->ejecuta_sentencia($sentencia);
    if (!$resultado) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta la Forma de Envío. Comprueba que los datos son correctos</span>";
        return;
    }

    echo "La Forma de Envío <strong><em>" . $nombre . "</em></strong> ha sido dada de alta con éxito";
}
?>

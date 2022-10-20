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

$nombre = $_REQUEST["nombre"];
$direccion = $_REQUEST["direccion"];
$poblacion = $_REQUEST["poblacion"];
$provincia = $_REQUEST["provincia"];
$cp = $_REQUEST["cp"];
if (isset($_FILES["logo"])) {
    $nombre_logo = $_FILES["logo"]["name"];
    $tmp_logo = $_FILES["logo"]["tmp_name"];
}
if (isset($_FILES["logo_informes"])) {
    $nombre_logo_informes = $_FILES["logo_informes"]["name"];
    $tmp_logo_informes = $_FILES["logo_informes"]["tmp_name"];
}

if (($nombre == "") || ($direccion == "") || ($poblacion == "") || ($provincia == "") || ($cp == "")) {
    echo "<span class='error'>¡ERROR! Comprueba que has rellenado todos los campos obligatorios </span>";
    return;
}

$bbdd = new BBDD();

$sql = "UPDATE empresa SET nombre = ?, direccion = ?, poblacion = ?, provincia = ?, cp = ?";
$ok = $bbdd->ejecuta_sentencia_i($sql, "sssss", array($nombre, $direccion, $poblacion, $provincia, $cp));
if (!$ok) {
    echo "<span class='error'>¡ERROR! No se ha podido modificar tu perfil. Comprueba que los datos son correctos</span>";
    return;
}

// Colocar imágenes
$directorio = "../../img";
if (isset($_FILES["logo"]))
    move_uploaded_file($tmp_logo, $directorio . "/" . "logo.jpg");
$directorio = "../img";
if (isset($_FILES["logo_informes"]))
    move_uploaded_file($tmp_logo_informes, $directorio . "/" . "logo_informes.jpg");

echo "Los datos de empresa se han actualizado correctamente";

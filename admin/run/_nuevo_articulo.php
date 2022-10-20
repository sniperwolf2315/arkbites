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
require_once("../../include/arkabytes/imagenes.php");

$nombre = $_REQUEST["nombre"];
$descripcion = $_REQUEST["descripcion"];
$stock = $_REQUEST["stock"];
$precio_compra = str_replace(",", ".", $_REQUEST["precio_compra"]);
if ($precio_compra == "")
    $precio_compra = 0;
$precio_venta = str_replace(",", ".", $_REQUEST["precio_venta"]);
if ($precio_venta == "")
    $precio_venta = 0;
$id_tipo_iva = $_REQUEST["tipo_iva"];
$observaciones = $_REQUEST["observaciones"];
$proveedor = $_REQUEST["proveedor"];
if (isset($_FILES["imagen1"])) {
    $tmp_imagen1 = $_FILES["imagen1"]["tmp_name"];
    $nombre_imagen1 = $_FILES["imagen1"]["name"];
}
if (isset($_FILES["imagen2"])) {
    $tmp_imagen2 = $_FILES["imagen2"]["tmp_name"];
    $nombre_imagen2 = $_FILES["imagen2"]["name"];
}
if (isset($_FILES["imagen3"])) {
    $tmp_imagen3 = $_FILES["imagen3"]["tmp_name"];
    $nombre_imagen3 = $_FILES["imagen3"]["name"];
}
if (isset($nombre_imagen1))
    $nombre_miniatura = "th_" . $nombre_imagen1;
$modificar = $_REQUEST["modificar"];

$bbdd = new BBDD();

/*if ($proveedor == "") {
    echo "<span class='error'>¡ERROR! Debe asignarse un proveedor al artículo</span>";
    return;
}*/

if ($proveedor != "") {
    $id_proveedor = $bbdd->get_id_proveedor($proveedor);
    if ($id_proveedor == "") {
        echo "<span class='error'>¡ERROR! El Proveedor <strong>" . $proveedor . "</strong> no existe. Debería darlo de alta para continuar</span>";
        return;
    }
}
else {
    $id_proveedor = "NULL";
}

if ($stock == "") {
    $stock = 0;
}

if ($modificar != "") {

    $sql = "UPDATE articulos SET nombre = ?, descripcion = ?, stock = ?,  precio_coste = ?, precio_venta = ?, id_tipo_iva = ?, observaciones = ?, " .
        "id_proveedor = ? WHERE id = ?";
    $statement = $bbdd->conexion->prepare($sql);
    $statement->bind_param("ssiddisii", $nombre, $descripcion, $stock, $precio_compra, $precio_venta, $id_tipo_iva, $observaciones, $id_proveedor, $modificar);
    $ok = $statement->execute();
    $statement->close();
    if (!$ok) {
        echo "<span class='error'>¡ERROR! No se ha podido actualizar el Artículo. Comprueba que los datos son correctos</span>";
        return;
    }

    // Sube las imágenes
    $directorio = "../articulos/" . $modificar;
    if (!is_dir($directorio))
        mkdir($directorio);

    // Sólo sube las imágenes si el usuario indica alguna. En caso contrario se quedan las que ya tenía
    if (isset($nombre_imagen1)) {
        move_uploaded_file($tmp_imagen1, $directorio . "/" . $nombre_imagen1);

        // Genera la miniatura para el listado
        $miniatura = $directorio . "/th_" . $nombre_imagen1;
        copy($directorio . "/" . $nombre_imagen1, $miniatura);
        Imagenes::redimensionar_imagen($miniatura);

        $sql = "UPDATE articulos SET imagen1 = ?, miniatura = ? WHERE id = ?";
        $statement = $bbdd->conexion->prepare($sql);
        $statement->bind_param("ssi", $nombre_imagen1, $nombre_miniatura, $modificar);
        $ok = $statement->execute();
        $statement->close();
    }
    if (isset($nombre_imagen2)) {
        move_uploaded_file($tmp_imagen2, $directorio . "/" . $nombre_imagen2);

        $sql = "UPDATE articulos SET imagen2 = ? WHERE id = ?";
        $statement = $bbdd->conexion->prepare($sql);
        $statement->bind_param("si", $nombre_imagen2, $modificar);
        $ok = $statement->execute();
        $statement->close();
    }
    if (isset($nombre_imagen3)) {
        move_uploaded_file($tmp_imagen3, $directorio . "/" . $nombre_imagen3);

        $sql = "UPDATE articulos SET imagen3 = ? WHERE id = ?";
        $statement = $bbdd->conexion->prepare($sql);
        $statement->bind_param("si", $nombre_imagen3, $modificar);
        $ok = $statement->execute();
        $statement->close();
    }

    echo "El Artículo <strong><em>" . $nombre . "</em></strong> se ha actualizado correctamente";
}
else {
    if ($bbdd->es_articulo($nombre)) {
        echo "<span class='error'>¡ERROR! El Artículo <strong>" . $nombre . "</strong> ya existe en la Base de Datos. No se permiten nombres duplicados</span>";
        return;
    }

    $sql = "INSERT INTO articulos (nombre, descripcion, stock, precio_coste, precio_venta, id_tipo_iva, observaciones, " .
            "imagen1, imagen2, imagen3, miniatura, id_proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $bbdd->conexion->prepare($sql);
    $statement->bind_param("ssiddisssssi", $nombre, $descripcion, $stock, $precio_compra, $precio_venta, $id_tipo_iva, $observaciones,
        $nombre_imagen1, $nombre_imagen2, $nombre_imagen3, $nombre_miniatura, $id_proveedor);
    $ok = $statement->execute();
    $statement->close();
    if (!$ok) {
        echo "<span class='error'>!ERROR! No se ha podido dar de alta el Artículo. Comprueba que los datos son correctos</span>";
        return;
    }

    // Sube las imágenes
    $directorio = "../articulos/" . $bbdd->conexion->insert_id;
    mkdir($directorio);
    if (isset($tmp_imagen1))
        move_uploaded_file($tmp_imagen1, $directorio . "/" . $nombre_imagen1);
    if (isset($tmp_imagen2))
        move_uploaded_file($tmp_imagen2, $directorio . "/" . $nombre_imagen2);
    if (isset($tmp_imagen3))
        move_uploaded_file($tmp_imagen3, $directorio . "/" . $nombre_imagen3);

    if ($nombre_imagen1 != "") {
        // Genera la miniatura para el listado
        $miniatura = $directorio . "/th_" . $nombre_imagen1;
        copy($directorio . "/" . $nombre_imagen1, $miniatura);

        Imagenes::redimensionar_imagen($miniatura);
    }

    echo "El Artículo <strong><em>" . $nombre . "</em></strong> ha sido dado de alta con éxito";
}
?>

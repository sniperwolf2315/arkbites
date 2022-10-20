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

date_default_timezone_set("Europe/Madrid");

$bbdd = new BBDD();

$nombre_cliente = $_REQUEST["cliente"];
$numero_pedido = $bbdd->get_siguiente_numero_pedido();

$fecha = $_REQUEST["fecha"];
if ($fecha == "")
    $fecha = date("Y-m-d", time());
else
    $fecha = date("Y-m-d", strtotime($fecha));

$fecha_entrega = $_REQUEST["fecha_entrega"];
if ($fecha_entrega == "")
    $fecha_entrega = NULL;
else
    $fecha_entrega = date("Y-m-d", strtotime($fecha_entrega));

$estado = $_REQUEST["estado"];
$comentarios = $_REQUEST["comentarios"];
$observaciones = $_REQUEST["observaciones"];
$nombre_forma_envio = $_REQUEST["forma_envio"];
$nombre_forma_pago = $_REQUEST["forma_pago"];
$importe = $_REQUEST["importe"];

$cliente = $bbdd->get_cliente_por_nombre($nombre_cliente);
$forma_envio = $bbdd->get_forma_envio($nombre_forma_envio);
$forma_pago = $bbdd->get_forma_pago($nombre_forma_pago);

// Inicia transacción para alta de pedido y sus detalles
$bbdd->conexion->autocommit(FALSE);

// Alta del pedido
$sql = "INSERT INTO pedidos (id_cliente, numero_pedido, fecha, fecha_entrega, estado, comentarios, observaciones, importe, forma_envio, forma_pago,
    coste_envio, coste_forma_pago, dias_envio, nombre_cliente, direccion, poblacion, provincia, cp)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$statement = $bbdd->conexion->prepare($sql);
$statement->bind_param("issssssdssddissssi", $cliente->id, $numero_pedido, $fecha, $fecha_entrega, $estado, $comentarios, $observaciones,
    $importe, $nombre_forma_envio, $nombre_forma_pago, $forma_envio->coste, $forma_pago->coste, $forma_envio->dias, $nombre_cliente,
    $cliente->direccion, $cliente->poblacion, $cliente->provincia, $cliente->cp);
$resultado = $statement->execute();
$statement->close();
if (!$resultado) {
    echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
    $bbdd->conexion->rollback();
    return;
}

$id_pedido = $bbdd->conexion->insert_id;

// Alta de los detalles del pedido
$articulos = $_REQUEST["select_articulos"];
$cantidades = $_REQUEST["select_cantidades"];
$precios = $_REQUEST["select_precios"];
$subtotal_pedido = 0;
$iva_pedido = 0;
for ($i = 0; $i < count($articulos); $i++) {
    $detalles_articulo = $bbdd->get_detalles_articulo($articulos[$i]);
    $tipo_iva = $bbdd->get_tipo_iva_por_id($detalles_articulo->id_tipo_iva);

    $cantidad = explode("|", $cantidades[$i]);
    $precio = explode("|", $precios[$i]);
    $subtotal = $cantidad[1] * $precio[1];
    $iva = round($subtotal * floatval($tipo_iva->cantidad), 2);
    $descuento = 0;
    $observaciones = "";

    $sql = "INSERT INTO detalles_pedido (id_articulo, nombre_articulo, descripcion, precio, cantidad, descuento, subtotal, iva, observaciones, id_pedido) " .
        "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $bbdd->conexion->prepare($sql);
    $statement->bind_param("issdidddsi", $detalles_articulo->id, $detalles_articulo->nombre, $detalles_articulo->descripcion, $precio[1],
        $cantidad[1], $descuento, $subtotal, $iva, $observaciones, $id_pedido);
    $resultado = $statement->execute();
    $statement->close();
    if (!$resultado) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
        $bbdd->conexion->rollback();
        return;
    }

    // Actualiza el stock del artículos
    $sql2 = "UPDATE articulos SET stock = stock - " . $cantidad[1] . " WHERE id = ?";
    $statement2 = $bbdd->conexion->prepare($sql2);
    $statement2->bind_param("i", $detalles_articulo->id);
    $resultado2 = $statement2->execute();
    $statement2->close();
    if (!$resultado2) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
        $bbdd->conexion->rollback();
        return;
    }

    // Para actualizar después el pedido recién creado
    $subtotal_pedido += $subtotal;
    $iva_pedido += $iva;
}

// Inserta los gastos de envío como detalle del pedido
$cero = 0;
$uno = 1;
$envio = "Envío: " . $forma_envio->nombre;

$sql = "INSERT INTO detalles_pedido (id_articulo, nombre_articulo, descripcion, precio, cantidad, descuento, subtotal, iva, observaciones, id_pedido) " .
        "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$statement = $bbdd->conexion->prepare($sql);
$statement->bind_param("issdidddsi", $cero, $envio, $forma_envio->descripcion, $forma_envio->coste, $uno, $cero, $forma_envio->coste, $cero, $forma_envio->descripcion,
        $id_pedido);
$resultado = $statement->execute();
$statement->close();
if (!$resultado) {
    echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
    $bbdd->conexion->rollback();
    return;
}

// Añade el coste del envío al subtotal
$subtotal_pedido += $forma_envio->coste;
// Actualización de algunos datos del pedido
$importe_pedido = $subtotal_pedido + $iva_pedido;
$sql = "UPDATE pedidos SET base_imponible = ?, iva = ?, importe = ? WHERE numero_pedido = ?";
$ok = $bbdd->ejecuta_sentencia_i($sql, "ddds", array($subtotal_pedido, $iva_pedido, $importe_pedido, $numero_pedido));
if (!$ok) {
    echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
    $bbdd->conexion->rollback();
    return;
}

// Crea un evento asociado al pedido, asociándolo a éste, si procede
if ($_REQUEST["crear_evento"] == "1") {
    $sql = "INSERT INTO tareas (nombre, descripcion, fecha_prevista, fecha_inicio, estado, tipo, id_pedido) " .
        "VALUES (?, ?, ?, ?, ?, ?, ?)";
    $nombre_evento = "Pedido: " . $numero_pedido . "\nCliente: " . $nombre_cliente;
    $descripcion_evento = "Pedido: " . $numero_pedido . "\nCliente: " . $nombre_cliente;
    $estado_evento = "pendiente";
    $tipo_evento = "evento";
    $ok = $bbdd->ejecuta_sentencia_i($sql, "ssssssi", array($nombre_evento, $descripcion_evento, $fecha, $fecha, $estado_evento, $tipo_evento, $id_pedido));
    if (!$ok) {
        echo "<span class='error'>¡ERROR! No se ha podido dar de alta el Pedido. Comprueba que los datos son correctos</span>";
        $bbdd->conexion->rollback();
        return;
    }
}

$bbdd->conexion->commit();
echo "El Pedido <strong><em>" . $numero_pedido . "</em></strong> ha sido dado de alta con éxito";
?>

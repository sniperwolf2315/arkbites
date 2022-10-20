<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

	$id = $_REQUEST["id"];

	require_once("../config/abc-config.php");
	require_once("../include/arkabytes/bbdd.php");

	$bbdd = new BBDD();
	$tarea = $bbdd->get_tarea_por_id($id);
	
	$cliente = "";
	if ($tarea->id_cliente != "")
		$cliente = $bbdd->get_cliente_por_id($tarea->id_cliente);
	$proveedor = "";
	if ($tarea->id_proveedor != "")
		$proveedor = $bbdd->get_proveedor_por_id($tarea->id_proveedor);
	$numero_pedido = "";
	if ($tarea->id_pedido != "")
		$numero_pedido = $bbdd->get_numero_pedido_por_id($tarea->id_pedido);
?>
<html>
<head>
    <title><?php echo $tarea->nombre; ?></title>
</head>
<body>
<div style="font-size:14px;">
	<h1><?php echo $tarea->nombre; ?></h1>
	<div id="info_tarea">
		<h3><a href="#">Datos de Tarea</a></h3>
		<div>
			<table style="text-transform:uppercase">
			<tr style="float:left;padding:5px">
				<td ><strong>Nombre: </strong></td>
				<td><?php echo $tarea->nombre; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Estado: </strong></td>
				<td><?php echo $tarea->estado; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Fecha Prevista: </strong></td>
				<td><?php echo $tarea->fecha_prevista; ?></td>
				<td><strong>Fecha Inicio: </strong></td>
				<td><?php echo $tarea->fecha_inicio; ?></td>
				<td><strong>Fecha Fin: </strong></td>
				<td><?php echo $tarea->fecha_fin; ?></td>
				<td><strong>Fecha Aviso: </strong></td>
				<td><?php echo $tarea->fecha_aviso; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Cliente: </strong></td>
				<td><?php if ($cliente != "") echo $cliente->nombre . " " . $cliente->apellidos; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Proveedor: </strong></td>
				<td><?php if ($proveedor != "") echo $proveedor->nombre; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Pedido: </strong></td>
				<td><?php echo $numero_pedido; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Descripcion: </strong></td>
				<td><?php echo $tarea->descripcion; ?></td>
			</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>

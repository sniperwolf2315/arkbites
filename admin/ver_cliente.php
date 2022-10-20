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
	$cliente = $bbdd->get_cliente_por_id($id);
?>
<html>
<head>
    <title><?php echo $cliente->empresa; ?></title>
</head>
<body>
<script type="text/javascript">
// expande/oculta la capa
$(function() {
    $( "#info_cliente" ).accordion({
        autoHeight: false,
        navigation: true
    });
});
</script>
<div style="font-size:14px;">
	<h1><?php echo $cliente->empresa; ?></h1>
	<div id="info_cliente">
		<h3><a href="#">Datos de Cliente</a></h3>
		<div>
			<table style="text-transform:uppercase">
			<tr style="float:left;padding:5px">
				<td ><strong>Nombre: </strong></td>
				<td><?php echo $cliente->nombre; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Apellidos: </strong></td>
				<td><?php echo $cliente->apellidos; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Empresa: </strong></td>
				<td><?php echo $cliente->empresa; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>CIF: </strong></td>
				<td><?php echo $cliente->cif; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Dirección: </strong></td>
				<td><?php echo $cliente->direccion; ?></td>
				<td><strong>Población: </strong></td>
				<td><?php echo $cliente->poblacion; ?></td>
				<td><strong>Provincia: </strong></td>
				<td><?php echo $cliente->provincia; ?></td>
				<td><strong>CP: </strong></td>
				<td><?php echo $cliente->cp; ?></td>
				<td><strong>País: </strong></td>
				<td><?php echo $cliente->pais; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Teléfono: </strong></td>
				<td><?php echo $cliente->telefono; ?></td>
				<td><strong>Móvil: </strong></td>
				<td><?php echo $cliente->movil; ?></td>
				<td><strong>Fax: </strong></td>
				<td><?php echo $cliente->fax; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Email: </strong></td>
				<td><?php echo $cliente->email; ?></td>
				<td><strong>Web: </strong></td>
				<td><?php echo $cliente->web; ?></td>
			</tr>
			<tr style="float:left;padding:5px">
				<td><strong>Observaciones: </strong></td>
				<td><?php echo $cliente->observaciones; ?></td>
			</tr>
			</table>
		</div>
		<h3><a href="#">Pedidos</a></h3>
		<div>
			<?php include("pedidos_cliente.php"); ?>
		</div>
		<h3><a href="#">Facturas</a></h3>
		<div>
		</div>
	</div>
</div>
</body>
</html>

-- Script que actualiza la base de datos de v0.6.1 a v0.6.2

ALTER TABLE `detalles_factura` CHANGE `precio` `precio` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_factura` CHANGE `descuento` `descuento` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_factura` CHANGE `subtotal` `subtotal` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_factura` CHANGE `iva` `iva` FLOAT NOT NULL DEFAULT '0';

ALTER TABLE `detalles_pedido` CHANGE `precio` `precio` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_pedido` CHANGE `descuento` `descuento` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_pedido` CHANGE `subtotal` `subtotal` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `detalles_pedido` CHANGE `iva` `iva` FLOAT NOT NULL DEFAULT '0';

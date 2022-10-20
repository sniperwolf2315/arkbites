<?php
/*
 * software de desarrollo a la medida - Sistema ERP para PYMEs
 * Copyright (C) 2016 carlos villalobos <carvilf@gmail.com>
 *
 * este programa es de uso licenciado y distribuido por su propietario adsi gaes 15 carlos villalobos;se encuentra prohibida su reproduccion y modificacion parcial o total
 * aplican terminos de licencia shareware, prohibido su reproduccion y distribucion sin previa autorizacion del autor
 */

require_once("usuario.php");
require_once("forma_pago.php");
require_once("forma_envio.php");
require_once("cliente.php");
require_once("proveedor.php");
require_once("detalles_articulo.php");
require_once("articulo.php");
require_once("tarea.php");
require_once("evento.php");
require_once("pedido.php");
require_once("factura.php");
require_once("tipo_iva.php");

setlocale(LC_MONETARY, "es_ES");

class BBDD {

    public $conexion;

    function __construct() {

        $this::conectar();
    }

    /* Generales */
        
    /**
     * Conecta con la Base de Datos
     */
    function conectar() {

        $this->conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
        $this->conexion->query("SET NAMES 'UTF-8'");
    }

    /**
     * Desconecta de la Base de Datos
     */

    function desconectar() {
        
        mysqli_close($this->conexion);
    }
    
    /**
     * Ejecuta una sentencia parametrizada con nuevo variable de parametros
     * @param $sql
     * @param $tipos
     * @param array $parametros
     * @return
     */
    function ejecuta_sentencia_i($sql, $tipos, array $parametros) {
    	
    	$statement = $this->conexion->prepare($sql);
    	
    	$ref_parametros = array();
    	for ($i = 0; $i < count($parametros); $i++) {
    		$ref_parametros[] =& $parametros[$i];
    	}
    	call_user_func_array("mysqli_stmt_bind_param", array_merge(array($statement, $tipos), $ref_parametros));
    	
    	$ok = $statement->execute();
    	$statement->close();
    	
    	return $ok;
    }
    
    function ejecuta_consulta_i($sql, $tipos, array $parametros) {
    	 
    	$statement = $this->conexion->prepare($sql);
    	
    	for ($i = 0; $i < count($parametros); $i++) {
    		$parametros[] =& $parametros[$i];
    	}
    	call_user_func_array("mysqli_stmt_bind_param", array_merge(array($statement, $tipos), $parametros));
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	 
    	return $fila;
    }

    /**
     * Ejecuta una consulta y devuelve el primer resultado
     */
    function ejecuta_escalar($consulta) {

    	$statement = $this->conexion->prepare($consulta);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();        

        return $fila;
    }

    /**
     * Ejecuta una consulta y devuelve todas las filas
     */
    function ejecuta_consulta($consulta) {

        $resultado = $this->conexion->query($consulta);

        return $resultado;
    }

    /**
     * Ejecuta una sentencia y devuelve el resultado de la misma
     */
    function ejecuta_sentencia($sentencia) {

        return $this->conexion->query($sentencia);
    }

    /**
     * Comprueba que la consulta devuelve algún resultado
     * @param consulta La consulta que se quiere comprobar
     * @return verdadero si devuelve algún resultado y falso en cualquier otro caso
     */
    function existe($sql, $tipos, $parametros) {

    	$statement = $this->conexion->prepare($sql);
    	
    	$ref_parametros = array();
    	for ($i = 0; $i < count($parametros); $i++) {
    		$ref_parametros[] =& $parametros[$i];
    	}
    	call_user_func_array("mysqli_stmt_bind_param", array_merge(array($statement, $tipos), $parametros));
    	$statement->execute();
    	$statement->store_result();

        $numero = $statement->num_rows;
        $statement->close();
        if ($numero == 0)
            return false;

        return true;
    }

    /* Tablas Maestras */

    /**
     * Devuelve una Forma de Envío 
     */
    function get_forma_envio($nombre) {

        $fila = $this->ejecuta_escalar("SELECT * FROM formas_envio WHERE nombre = '" . $nombre . "'");

        $forma_envio = FormaEnvio::nueva_forma_envio($fila);

        return $forma_envio;
    }
    
    function get_forma_envio_por_id($id) {
    	
    	$sql = "SELECT * FROM formas_envio WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	 
    	$forma_envio = FormaEnvio::nueva_forma_envio($fila);
    	
    	return $forma_envio;
    }

    function get_id_forma_envio($nombre) {
        
        $fila = $this->ejecuta_escalar("SELECT id FROM formas_envio WHERE nombre = '" . $nombre . "'");

        return $fila["id"];
    }

    function es_forma_envio($nombre) {
        
        return $this->existe("SELECT nombre FROM formas_envio WHERE nombre = ?", "s", array($nombre));
    }

    function get_forma_pago($nombre) {

        $fila = $this->ejecuta_escalar("SELECT * FROM formas_pago WHERE nombre = '" . $nombre . "'");

        $forma_pago = FormaPago::nueva_forma_pago($fila);

        return $forma_pago;
    }

    function get_id_forma_pago($nombre) {
        
        $fila = $this->ejecuta_escalar("SELECT id from formas_pago WHERE nombre = '" . $nombre . "'");

        return $fila["id"];
    }
    
    function get_forma_pago_por_id($id) {
    	 
    	$sql = "SELECT * FROM formas_pago WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    
    	$forma_pago = FormaPago::nueva_forma_pago($fila);
    	 
    	return $forma_pago;
    }

    function es_forma_pago($nombre) {
        
        return $this->existe("SELECT nombre FROM formas_pago WHERE nombre = ?", "s", array($nombre));
    }
    
    function get_tipo_iva_por_id($id) {
    
    	$sql = "SELECT * FROM tipos_iva WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    
    	$tipo_iva = TipoIva::nuevo_tipo_iva($fila);
    
    	return $tipo_iva;
    }
    
    function es_tipo_iva($nombre) {
    
    	return $this->existe("SELECT nombre FROM tipos_iva WHERE nombre = ?", "s", array($nombre));
    }

    /* Funciones de usuario */

    function comprobar_usuario($usuario, $contrasena) {

    	$statement = $this->conexion->prepare("SELECT usuario, nombre, email, nivel FROM usuarios WHERE usuario = ? AND contrasena = ?");
    	$statement->bind_param("ss", $usuario, $contrasena);
    	$statement->execute();   	
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	
    	if (count($fila) == 0)
    		return NULL;
        
        $usuario = Usuario::nuevo_usuario($fila);
        
        return $usuario;
    }

    function es_usuario($usuario) {
        
        return $this->existe("SELECT usuario FROM usuarios WHERE usuario = ?", "s", array($usuario));
    }

    /* Funciones de clientes */

    function es_cliente($nombre, $apellidos) {

        return $this->existe("SELECT nombre FROM clientes WHERE nombre = ? AND apellidos = ?", "ss", array($nombre, $apellidos));
    }

    function get_id_cliente($nombre_completo) {

    	$statement = $this->conexion->prepare("SELECT id FROM clientes WHERE CONCAT(nombre, ' ', apellidos) = ?");
    	$statement->bind_param("s", $nombre_completo);
    	$statement->execute();
    	$statement->bind_result($id);
    	$statement->fetch();
    	$statement->close();
        
        return $id;
    }

    function get_cliente_por_nombre($nombre_completo) {

        $fila = $this->ejecuta_escalar("SELECT * FROM clientes WHERE CONCAT(nombre, ' ', apellidos) = '" . $nombre_completo . "'");

        $cliente = Cliente::nuevo_cliente($fila);

        return $cliente;
    }

    function get_cliente_por_id($id) {

    	$sql = "SELECT * FROM clientes WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	        
        $cliente = Cliente::nuevo_cliente($fila);

        return $cliente;
    }

    /* Funciones de proveedores */

    function es_proveedor($nombre) {

        return $this->existe("SELECT nombre FROM proveedores WHERE nombre = ?", "s", array($nombre));
    }

    function get_id_proveedor($nombre) {
        
    	$statement = $this->conexion->prepare("SELECT id FROM proveedores WHERE nombre = ?");
    	$statement->bind_param("s", $nombre);
    	$statement->execute();
    	$statement->bind_result($id);
    	$statement->fetch();
    	$statement->close();
                
        return $id;
    }

    function get_proveedor_por_id($id) {

       $sql = "SELECT * FROM proveedores WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	        
        $proveedor = Proveedor::nuevo_proveedor($fila);

        return $proveedor;
    }
    
    /* Funciones de tareas */
    
    function es_tarea($nombre) {
    	
    	return $this->existe("SELECT nombre FROM tareas WHERE nombre = ?", "s", array($nombre));
    }
    
    function get_tarea_por_id($id) {
    
    	$sql = "SELECT * FROM tareas WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	 
    	$tarea = Tarea::nueva_tarea($fila);
    
    	return $tarea;
    }

    /* Funciones de artículos */

    function es_articulo($nombre) {

        return $this->existe("SELECT nombre FROM articulos WHERE nombre = ?", "s", array($nombre));
    }
    
    function get_detalles_articulo($nombre) {
    	 
    	$sql = "SELECT id, descripcion, precio_venta, id_tipo_iva FROM articulos WHERE nombre = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("s", $nombre);
    	$statement->execute();
    	$statement->bind_result($id, $descripcion, $precio_venta, $id_tipo_iva);
    	$statement->fetch();
    	$statement->close();
    	 
    	$detalles = new Detalles_Articulo();
    	$detalles->id = $id;
    	$detalles->nombre = $nombre;
    	$detalles->descripcion = $descripcion;
    	$detalles->precio_venta = $precio_venta;
    	$detalles->id_tipo_iva = $id_tipo_iva;
    	 
    	return $detalles;
    }
    
    function get_articulo_por_id($id) {
    	 
    	$sql = "SELECT * FROM articulos WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	 
    	return Articulo::nuevo_articulo($fila);
    }
    
    /* Funciones de pedidos */
    
    function get_id_pedido($numero_pedido) {
    
    	$statement = $this->conexion->prepare("SELECT id FROM pedidos WHERE numero_pedido = ?");
    	$statement->bind_param("s", $numero_pedido);
    	$statement->execute();
    	$statement->bind_result($id);
    	$statement->fetch();
    	$statement->close();
    
    	return $id;
    }
    
    function get_pedido_por_id($id) {
    
    	$sql = "SELECT * FROM pedidos WHERE id = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("i", $id);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	
    	$pedido = Pedido::nuevo_pedido($fila);
    	    
    	return $pedido;
    }
    
    function get_pedido_por_numero_pedido($numero_pedido) {
    
    	$sql = "SELECT * FROM pedidos WHERE numero_pedido = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("s", $numero_pedido);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	
    	$pedido = Pedido::nuevo_pedido($fila);
    		
    	return $pedido;
    }
    
    function get_detalles_pedido($id_pedido) {
    	
    	$sql = "SELECT * FROM detalles_pedido WHERE id_pedido = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("s", $id_pedido);
    	$statement->execute();
    	$resultado = $statement->get_result();
    	$statement->close();
    	
    	return $resultado;
    }
    
    function get_siguiente_numero_pedido() {
    	 
    	$sentencia = "SELECT numero_pedido FROM pedidos WHERE id = (SELECT MAX(id) FROM pedidos)";
    	$fila = $this->ejecuta_escalar($sentencia);
    
    	$numero = $fila["numero_pedido"];
    	if (is_null($numero))
    		$numero = 1;
    	else
    		$numero += 1;
    	 
    	return $numero;
    }
    
    /* Funciones para facturas */
    
    function get_detalles_factura($id_factura) {
    	 
    	$sql = "SELECT * FROM detalles_factura WHERE id_factura = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("s", $id_factura);
    	$statement->execute();
    	$resultado = $statement->get_result();
    	$statement->close();
    	 
    	return $resultado;
    }
    
    function get_factura_por_numero_factura($numero_factura) {
    
    	$sql = "SELECT * FROM facturas WHERE numero_factura = ?";
    	$statement = $this->conexion->prepare($sql);
    	$statement->bind_param("s", $numero_factura);
    	$statement->execute();
    	$fila = $statement->get_result()->fetch_assoc();
    	$statement->close();
    	 
    	$factura = Factura::nueva_factura($fila);
    
    	return $factura;
    }
    
    function get_siguiente_numero_factura() {
    
    	$sentencia = "SELECT numero_factura FROM facturas WHERE id = (SELECT MAX(id) FROM facturas)";
    	$fila = $this->ejecuta_escalar($sentencia);
    
    	$numero = $fila["numero_factura"];
    	if (is_null($numero))
    		$numero = 1;
    	else
    		$numero += 1;
    
    	return $numero;
    }
}
?>

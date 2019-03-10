<?php
require_once 'Base.php';
class Acceso{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function eliminarAccesosSucursal($datos){
		$sql = "DELETE FROM usuario_sucursal WHERE cod_usuario = ? and cod_sucursal = ?";
		return $this->db->update($sql, $datos);
	}
	
	public function eliminarAccesosAlmacen($datos){
		$sql = "DELETE FROM usuario_almacen WHERE cod_usuario = ? and cod_almacen = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaAccesoModulos($datos){
		$sql = "SELECT * FROM usuario_privilegios WHERE cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaAccesosSucursales($datos){
		$sql = "SELECT sucursal.cod_sucursal, sucursal.nombre_sucursal, sucursal.direccion_sucursal FROM usuario_sucursal, sucursal WHERE usuario_sucursal.cod_sucursal = sucursal.cod_sucursal and cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaAccesosAlmacenes($datos){
		$sql = "SELECT almacen.cod_almacen, almacen.nombre_almacen, almacen.direccion_almacen FROM usuario_almacen, almacen WHERE usuario_almacen.cod_almacen = almacen.cod_almacen and cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function verificarUsuarioSucursal($datos){
		$sql = "SELECT * FROM usuario_sucursal WHERE cod_usuario = ? and cod_sucursal = ?";
		return $this->db->select($sql, $datos);
	}

	public function verificarUsuarioAlmacen($datos){
		$sql = "SELECT * FROM usuario_almacen WHERE cod_usuario = ? and cod_almacen = ?";
		return $this->db->select($sql, $datos);
	}
    
    public function asignarUsuarioSucursal($datos){
		$sql = "INSERT INTO usuario_sucursal(cod_usuario, cod_sucursal) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function asignarUsuarioAlmacen($datos){
		$sql = "INSERT INTO usuario_almacen(cod_usuario, cod_almacen) VALUES(?,?);";
		return $this->db->insert($sql, $datos);
	}
}
?>
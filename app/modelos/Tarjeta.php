<?php
require_once 'Base.php';
class Tarjeta{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function tarjetaEspecifico($datos){
		$sql = "SELECT * FROM tarjeta WHERE codigo = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaTarjeta($datos){
		$sql = "SELECT * FROM tarjeta";
		return $this->db->select($sql, $datos);
	}

	public function listaTarjetaLibre($datos){
		$sql = "SELECT * FROM tarjeta WHERE estado = ?";
		return $this->db->select($sql, $datos);
	}

	public function cambiarEstado($datos){
		$sql = "UPDATE tarjeta SET estado = ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}
    
  	public function agregarTarjeta($datos){
		$sql = "INSERT INTO tarjeta(codigo, nombre, observacion, estado) VALUES(?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}
}
?>
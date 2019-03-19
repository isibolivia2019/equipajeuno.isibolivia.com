<?php
require_once 'Base.php';
class Gasto{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function gastoEspecifico($datos){
		$sql = "SELECT monto, detalle, comprobante, cod_usuario, fecha, hora, CONCAT(nombre, ' ', appat, ' ', apmat) as 'personal' FROM gastos, usuario WHERE gastos.cod_usuario = usuario.cod_usuario and codigo = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaGasto($datos){
		$sql = "SELECT * FROM gastos;";
		return $this->db->select($sql, $datos);
	}
    
  public function agregarGasto($datos){
		$sql = "INSERT INTO gastos(monto, detalle, comprobante, cod_usuario, fecha, hora) VALUES(?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarGasto($datos){
		$sql = "UPDATE gastos SET monto = ?, detalle = ?, comprobante = ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
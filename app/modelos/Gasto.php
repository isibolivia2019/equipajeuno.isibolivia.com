<?php
require_once 'Base.php';
class Cliente{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function gastoEspecifico($datos){
		$sql = "SELECT * FROM gasto WHERE codigo = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaGasto($datos){
		$sql = "SELECT * FROM gasto;";
		return $this->db->select($sql, $datos);
	}
    
  public function agregarGasto($datos){
		$sql = "INSERT INTO gasto(monto, detalle, comprobante, cod_usuario, fecha, hora) VALUES(?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarGasto($datos){
		$sql = "UPDATE gasto SET monto = ?, detalle = ?, comprobante = ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
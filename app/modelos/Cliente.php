<?php
require_once 'Base.php';
class Cliente{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function listaCliente($datos){
		$sql = "SELECT codigo, nombre, appat, apmat, ci, ci_exp, celular, email FROM cliente;";
		return $this->db->select($sql, $datos);
	}
    
  public function agregarCliente($datos){
		$sql = "INSERT INTO cliente(nombre, appat, apmat, ci, ci_exp, celular, email, cod_usuario, fecha, hora) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}
}
?>
<?php
require_once 'Base.php';
class Cliente{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function clienteEspecifico($datos){
		$sql = "SELECT nombre, appat, apmat, ci, ci_exp, celular, email FROM cliente WHERE codigo = ?;";
		return $this->db->select($sql, $datos);
	}

	public function clienteEspecificoCi($datos){
		$sql = "SELECT codigo, nombre, appat, apmat, ci, ci_exp, celular, email FROM cliente WHERE ci = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaCliente($datos){
		$sql = "SELECT codigo, nombre, appat, apmat, ci, ci_exp, celular, email FROM cliente;";
		return $this->db->select($sql, $datos);
	}

	public function listaClienteBusqueda($datos, $palabra){
		$sql = "SELECT codigo, nombre, appat, apmat, ci, ci_exp, celular, email FROM cliente WHERE nombre like '%".$palabra."%' or apmat like '%".$palabra."%' or appat like '%".$palabra."%' or ci like '%".$palabra."%' or celular like '%".$palabra."%' or email like '%".$palabra."%';";
		return $this->db->select($sql, $datos);
	}
    
  public function agregarCliente($datos){
		$sql = "INSERT INTO cliente(nombre, appat, apmat, ci, ci_exp, celular, email, cod_usuario, fecha, hora) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function actualizarCliente($datos){
		$sql = "UPDATE cliente SET nombre = ?, appat = ?, apmat = ?, ci = ?, ci_exp = ?, celular = ?, email = ? WHERE codigo = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
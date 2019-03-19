<?php
require_once 'Base.php';
class Almacenamiento{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

  	public function agregarEquipaje($datos){
		$sql = "INSERT INTO almacenamiento(cod_cliente, cod_tarjeta, imagen_uno, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio) VALUES(?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function listaTarjetaOcupada($datos){
		$sql = "SELECT cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio, detalle_final, fecha_final hora_final, usuario_final FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.cod_cliente and fecha_final = null";
		return $this->db->select($sql, $datos);
	}
}
?>
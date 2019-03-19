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
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and fecha_final IS NULL;";
		return $this->db->select($sql, $datos);
	}
}
?>
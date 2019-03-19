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


}
?>
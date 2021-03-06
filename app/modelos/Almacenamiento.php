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

	public function almacenamientoFinalEspecifico($datos){
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio, detalle_final, fecha_final, hora_final, usuario_final, DATEDIFF(fecha_final, fecha_inicio) as 'dias' FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and almacenamiento.codigo = ? and fecha_final IS NOT NULL;";
		return $this->db->select($sql, $datos);
	}

	public function HistorialClienteEquipaje($datos){
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio, detalle_final, fecha_final, hora_final, usuario_final, DATEDIFF(fecha_final, fecha_inicio) as 'dias' FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and almacenamiento.cod_cliente = ? and fecha_final IS NOT NULL;";
		return $this->db->select($sql, $datos);
	}

	public function HistorialClienteEquipajeBusqueda($datos, $palabra){
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio, detalle_final, fecha_final, hora_final, usuario_final, DATEDIFF(fecha_final, fecha_inicio) as 'dias' FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and (detalle_inicio like '%".$palabra."%' or detalle_final like '%".$palabra."%' or costo like '%".$palabra."%' or costo_total like '%".$palabra."%' or cod_tarjeta like '%".$palabra."%') and fecha_final IS NOT NULL;";
		return $this->db->select($sql, $datos);
	}

	public function listaTarjetaOcupada($datos){
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and fecha_final IS NULL;";
		return $this->db->select($sql, $datos);
	}

	public function listaTarjetaOcupadaBusqueda($datos, $palabra){
		$sql = "SELECT almacenamiento.codigo, cod_cliente, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, usuario_inicio FROM almacenamiento, cliente WHERE almacenamiento.cod_cliente = cliente.codigo and (detalle_inicio like '%".$palabra."%' or cod_tarjeta like '%".$palabra."%' or costo like '%".$palabra."%' or cliente.nombre like '%".$palabra."%' or cliente.appat like '%".$palabra."%' or cliente.apmat like '%".$palabra."%') and fecha_final IS NULL;";
		return $this->db->select($sql, $datos);
	}

	public function almacenamientoEntregaEspecifico($datos){
		$sql = "SELECT almacenamiento.codigo, CONCAT(cliente.codigo) as 'cod_cliente', CONCAT(cliente.nombre, ' ', cliente.appat, ' ', cliente.apmat) as 'cliente', cliente.ci, cod_tarjeta, imagen_uno, imagen_dos, imagen_tres, pago_anticipado, costo, costo_total, detalle_inicio, fecha_inicio, hora_inicio, CONCAT(usuario.nombre, ' ', usuario.appat, ' ', usuario.apmat) as 'personal', DATEDIFF(DATE_SUB(now(), INTERVAL 4 HOUR), fecha_inicio) as 'dias' FROM almacenamiento, cliente, usuario WHERE almacenamiento.cod_cliente = cliente.codigo and almacenamiento.usuario_inicio = usuario.cod_usuario and cod_tarjeta = ? and fecha_final IS NULL;";
		return $this->db->select($sql, $datos);
	}

	public function devolverEquipaje($datos){
		$sql = "UPDATE almacenamiento SET pago_anticipado = ?, costo_total = ?, detalle_final = ?, fecha_final = ?, hora_final = ?, usuario_final = ? WHERE cod_tarjeta = ? and cod_cliente = ? and fecha_final IS NULL";
		return $this->db->update($sql, $datos);
	}
}
?>
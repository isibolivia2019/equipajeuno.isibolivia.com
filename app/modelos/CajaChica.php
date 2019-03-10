<?php
require_once 'Base.php';
class CajaChica{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
    
    public function agregarCajaChica($datos){
		$sql = "INSERT INTO caja_chica(monto_gasto, detalle, comprobante, cod_usuario, fecha, hora, cod_sucursal) VALUES(?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function listaCajaChica($datos){
		$sql = "SELECT monto_gasto, detalle, comprobante, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', fecha, hora FROM caja_chica, usuario WHERE caja_chica.cod_usuario = usuario.cod_usuario and cod_sucursal = ? and MONTH(fecha) = ? and YEAR(fecha) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function reporteListaCajaChica($datos){
		$sql = "SELECT nombre_sucursal, monto_gasto, detalle, comprobante, CONCAT(nombre_usuario, ' ', appat_usuario, ' ', apmat_usuario) as 'personal', fecha, hora FROM caja_chica, usuario, sucursal WHERE caja_chica.cod_usuario = usuario.cod_usuario  and caja_chica.cod_sucursal = sucursal.cod_sucursal and caja_chica.cod_sucursal = ? and MONTH(fecha) = ? and YEAR(fecha) = ?;";
		return $this->db->select($sql, $datos);
	}
}
?>
<?php
require_once 'Base.php';
class RegistroNotificacion{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}
	
	public function buscarNotificacionFecha($datos){
		$sql = "SELECT cod_notificacion_usuario, mensaje, fecha, hora FROM notificacion_usuario WHERE cod_usuario_remitente = ? and MONTH(fecha) = ? and YEAR(fecha) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function buscarRegistroFecha($datos){
		$sql = "SELECT cod_registro_usuario, CONCAT(nombre_usuario, ' ', appat_usuario) as 'personal', mensaje, fecha, hora FROM registro_usuario, usuario WHERE registro_usuario.cod_usuario_emisor = usuario.cod_usuario and cod_usuario_remitente = ? and MONTH(fecha) = ? and YEAR(fecha) = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaRegistroCodigoUsuario($datos){
		$sql = "SELECT cod_registro_usuario, CONCAT(nombre_usuario, ' ', appat_usuario) as 'personal', mensaje, fecha, hora FROM registro_usuario, usuario WHERE registro_usuario.cod_usuario_emisor = usuario.cod_usuario and cod_usuario_remitente = ? and estado = ? ORDER BY cod_registro_usuario desc;";
		return $this->db->select($sql, $datos);
	}

	public function listaNotificacionCodigoUsuario($datos){
		$sql = "SELECT cod_notificacion_usuario, CONCAT(nombre_usuario, ' ', appat_usuario) as 'personal', mensaje, fecha, hora FROM notificacion_usuario, usuario WHERE notificacion_usuario.cod_usuario_remitente = usuario.cod_usuario and cod_usuario_remitente = ? and estado = ? ORDER BY cod_notificacion_usuario desc;";
		return $this->db->select($sql, $datos);
	}
	
	public function agregarRegistro($datos){
		$sql = "INSERT INTO registro_usuario(cod_usuario_emisor, cod_usuario_remitente, mensaje, fecha, hora, estado ) VALUES(?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function agregarNotificacion($datos){
		$sql = "INSERT INTO notificacion_usuario(cod_usuario_remitente, mensaje, fecha, hora, estado ) VALUES(?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}
	
	public function actualizarRegistroLeido($datos){
		$sql = "UPDATE registro_usuario SET estado = ? WHERE cod_usuario_remitente = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarNotificacionLeido($datos){
		$sql = "UPDATE notificacion_usuario SET estado = ? WHERE cod_usuario_remitente = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarNotificacion($datos){
		$sql = "UPDATE notificacion_usuario SET estado = ? WHERE cod_notificacion_usuario = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
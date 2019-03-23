<?php
require_once 'Base.php';
class Usuario{
	private $db;
	public function __construct(){
		$this->db = new Base;
	}

	public function agregarUsuario($datos){
		$sql = "INSERT INTO usuario(nombre, appat, apmat, ci, ci_exp, genero, fec_nac, direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado, registro, notificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		return $this->db->insert($sql, $datos);
	}

	public function agregarPrivilegio($datos){
		$sql = "INSERT INTO usuario_privilegios(cod_usuario, itemUsuario, itemCliente, itemTarjeta, itemReportes, itemRecepcion, itemEntrega, itemEstante, itemGastos, itemAccesos, itemRegistro, itemNotificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
		return $this->db->insert($sql, $datos);
	}

	public function autentificacionUsuario($datos){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, email, pass, imagen, estado, registro, notificacion FROM usuario WHERE ci = ? and pass = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaPrivilegiosUsuarios($datos){
		$sql = "SELECT * FROM usuario_privilegios WHERE cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	public function actualizarUsuario($datos){
		$sql = "UPDATE usuario SET nombre = ?, appat = ?, apmat = ?, ci = ?, ci_exp = ?, genero = ?, fec_nac = ?, direccion = ?, telefono = ?, nombre_ref = ?, telefono_ref = ?, tipo_ref = ?, email = ?, pass = ?, registro = ?, notificacion = ? WHERE cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}

	public function cambiarEstado($datos){
		$sql = "UPDATE usuario SET estado = ? WHERE cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarImagen($datos){
		$sql = "UPDATE usuario SET imagen = ? WHERE cod_usuario = ?";
		return $this->db->update($sql, $datos);
	}

	public function listaUsuarios($datos){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, ci_exp, genero, fec_nac,direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado FROM usuario;";
		return $this->db->select($sql, $datos);
	}




	
	public function listaUsuarioEstadoBusqueda($datos, $palabra){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, ci_exp, genero, fec_nac,direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado FROM usuario WHERE estado = ? and (nombre like '%".$palabra."%' or appat like '%".$palabra."%' or apmat like '%".$palabra."%' or ci like '%".$palabra."%' or telefono like '%".$palabra."%' or email like '%".$palabra."%');";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuarioEstado($datos){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, ci_exp, genero, fec_nac,direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado FROM usuario WHERE estado = ?;";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuarioSinCargo($datos){
		$sql = "SELECT * FROM usuario";
		return $this->db->select($sql, $datos);
	}

	

	

	public function listaUsuariosRegistro($datos){
		$sql = "SELECT * FROM usuario WHERE registro = ? and estado = ?";
		return $this->db->select($sql, $datos);
	}

	public function listaUsuariosNotificacion($datos){
		$sql = "SELECT * FROM usuario WHERE notificacion = ? and estado = ?";
		return $this->db->select($sql, $datos);
	}

	public function usuarioEspecifico($datos){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, ci_exp, genero, fec_nac, direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado, registro, notificacion FROM usuario WHERE cod_usuario = ?";
		return $this->db->select($sql, $datos);
	}

	






	

	public function actualizarPrivilegioItemUsuario($datos){
		$sql = "UPDATE usuario_privilegios SET itemUsuario = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemCliente($datos){
		$sql = "UPDATE usuario_privilegios SET itemCliente = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemTarjeta($datos){
		$sql = "UPDATE usuario_privilegios SET itemTarjeta = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemReportes($datos){
		$sql = "UPDATE usuario_privilegios SET itemReportes = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemRecepcion($datos){
		$sql = "UPDATE usuario_privilegios SET itemRecepcion = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemEntrega($datos){
		$sql = "UPDATE usuario_privilegios SET itemEntrega = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemEstante($datos){
		$sql = "UPDATE usuario_privilegios SET itemEstante = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemAcceso($datos){
		$sql = "UPDATE usuario_privilegios SET itemAccesos = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemNotificacion($datos){
		$sql = "UPDATE usuario_privilegios SET itemNotificacion = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
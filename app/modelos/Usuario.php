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



	
	public function listaUsuarioEstadoBusqueda($datos){
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

	public function listaUsuarios($datos){
		$sql = "SELECT cod_usuario, nombre, appat, apmat, ci, ci_exp, genero, fec_nac,direccion, telefono, nombre_ref, telefono_ref, tipo_ref, email, pass, imagen, estado FROM usuario;";
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


	public function actualizarPrivilegioItemHorario($datos){
		$sql = "UPDATE usuario_privilegios SET itemHorario = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemSueldo($datos){
		$sql = "UPDATE usuario_privilegios SET itemSueldo = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemProducto($datos){
		$sql = "UPDATE usuario_privilegios SET itemProducto = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemCategoria($datos){
		$sql = "UPDATE usuario_privilegios SET itemCategoria = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemSucursal($datos){
		$sql = "UPDATE usuario_privilegios SET itemSucursal = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemAlmacen($datos){
		$sql = "UPDATE usuario_privilegios SET itemAlmacen = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemReportes($datos){
		$sql = "UPDATE usuario_privilegios SET itemReportes = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemDescuentoProductos($datos){
		$sql = "UPDATE usuario_privilegios SET itemDescuentoProductos = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemTraspasoProductos($datos){
		$sql = "UPDATE usuario_privilegios SET itemTraspasoProductos = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemProductosPerdidos($datos){
		$sql = "UPDATE usuario_privilegios SET itemProductosPerdidos = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemVentas($datos){
		$sql = "UPDATE usuario_privilegios SET itemVentas = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemBiometrico($datos){
		$sql = "UPDATE usuario_privilegios SET itemBiometrico = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemAccesos($datos){
		$sql = "UPDATE usuario_privilegios SET itemAccesos = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemCajaChica($datos){
		$sql = "UPDATE usuario_privilegios SET itemCajaChica = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemCliente($datos){
		$sql = "UPDATE usuario_privilegios SET itemCliente = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemConfiguracion($datos){
		$sql = "UPDATE usuario_privilegios SET itemConfiguracion = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemRegistro($datos){
		$sql = "UPDATE usuario_privilegios SET itemRegistro = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}

	public function actualizarPrivilegioItemNotificacion($datos){
		$sql = "UPDATE usuario_privilegios SET itemNotificacion = ? WHERE cod_usuario  = ?";
		return $this->db->update($sql, $datos);
	}
}
?>
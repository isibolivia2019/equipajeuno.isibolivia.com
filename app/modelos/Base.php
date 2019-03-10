<?php
require_once 'Config.php';
class Base extends Config{
	private $stmt;
	public function select($sql, $datos){
		$conectar = parent::conexion();
		parent::set_names();
		$stmt = $conectar->prepare($sql);

		for ($i = 0; $i < sizeof($datos); $i++){
			$stmt->bindValue(($i + 1), $datos[$i]);
		}

		$stmt->execute();
		$resultado = $stmt->fetchALL(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function insert($sql, $datos){
		$conectar = parent::conexion();
		parent::set_names();
		$stmt = $conectar->prepare($sql);

		for ($i = 0; $i < sizeof($datos); $i++){
			$stmt->bindValue(($i + 1), $datos[$i]);
		}

		try {
			$stmt->execute();
			if ($stmt->rowCount() > 0){
				return "true";
			}else{
				return "false";
			}
	   	} catch (PDOException $e) {
			return $e->getCode();
		}
	}

	public function update($sql, $datos){
		$conectar = parent::conexion();
		parent::set_names();
		$stmt = $conectar->prepare($sql);

		for ($i = 0; $i < sizeof($datos); $i++){
			$stmt->bindValue(($i + 1), $datos[$i]);
		}

		try {
			$stmt->execute();
			return "true";
	   	} catch (PDOException $e) {
			return $e->getCode();
		}
	}
}

?>
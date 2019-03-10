<?php
ini_set('display_errors', '1');
define('DB_USER', "root"); // Usuario
define('DB_PASSWORD', '$IsiBolivia2018'); // Contraseña
define('DB_DATABASE', "equipaje_demo"); // Nombre de la base de datos
define('DB_LOCALHOST', "localhost:3306"); // localhost

define('DB_SERVER', "127.0.0.1"); // db server --> no es necesario para esta aplicacion
define('URL', "".$_SERVER["HTTP_HOST"]); // db server --> no es necesario para esta aplicacion

class Config{
	protected $dbh;
	public function conexion(){
		try{
			$conectar= $this->dbh= new PDO("mysql:local=".DB_LOCALHOST."; dbname=".DB_DATABASE, DB_USER, DB_PASSWORD);
			return $conectar;
		} catch (PDOException $e){
			return print 'Conexion Fallida a la Base de Datos: ' . $e->getMessage();
		}
	}
	
   	public function set_names(){
		return $this->dbh->query("SET NAMES 'utf8'");
   	}
   	
	public function ruta(){
		return URL."";
   	}
}
?>
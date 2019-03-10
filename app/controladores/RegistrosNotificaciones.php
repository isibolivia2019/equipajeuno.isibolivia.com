<?php
ini_set('display_errors', '1');

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'listaRegistros' :
            session_start();
            $usuario  = $_SESSION['codigo'];
            $datos = array($usuario, "1");
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $listaRegistro = $modelo->listaRegistroCodigoUsuario($datos);
            for($i = 0 ; $i < sizeof($listaRegistro) ; $i++){
                $listaRegistro[$i]["fecha"] = date("d/m/Y", strtotime($listaRegistro[$i]["fecha"])).' '.$listaRegistro[$i]["hora"];
            }
            $data = ['data' => $listaRegistro];
            echo json_encode($data);
            break;
        case 'listaNotificaciones' :
            session_start();
            $usuario  = $_SESSION['codigo'];
            $datos = array($usuario, "1");
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $listaNotificacion = $modelo->listaNotificacionCodigoUsuario($datos);
            for($i = 0 ; $i < sizeof($listaNotificacion) ; $i++){
                $listaNotificacion[$i]["fecha"] = date("d/m/Y", strtotime($listaNotificacion[$i]["fecha"])).' '.$listaNotificacion[$i]["hora"];
            }
            $data = ['data' => $listaNotificacion];
            echo json_encode($data);
            break;
        case 'buscarNotificacionFecha' :
            session_start();
            $usuario  = $_SESSION['codigo'];
            $mes  = $_POST['mes'];
            $año  = $_POST['año'];

            $datos = array($usuario, $mes, $año);
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $listaNotificacion = $modelo->buscarNotificacionFecha($datos);
            for($i = 0 ; $i < sizeof($listaNotificacion) ; $i++){
                $listaNotificacion[$i]["fecha"] = date("d/m/Y", strtotime($listaNotificacion[$i]["fecha"])).' '.$listaNotificacion[$i]["hora"];
            }
            $data = ['data' => $listaNotificacion];
            echo json_encode($data);
            break;
        case 'buscarRegistroFecha' :
        session_start();
            $usuario  = $_SESSION['codigo'];
            $mes  = $_POST['mes'];
            $año  = $_POST['año'];

            $datos = array($usuario, $mes, $año);
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $listaRegistro = $modelo->buscarRegistroFecha($datos);
            for($i = 0 ; $i < sizeof($listaRegistro) ; $i++){
                $listaRegistro[$i]["fecha"] = date("d/m/Y", strtotime($listaRegistro[$i]["fecha"])).' '.$listaRegistro[$i]["hora"];
            }
            $data = ['data' => $listaRegistro];
            echo json_encode($data);
            break;
        case 'actualizarRegistroLeido' :
            session_start();
            $usuario  = $_SESSION['codigo'];
            $datos = array("0", $usuario);
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $resp = $modelo->actualizarRegistroLeido($datos);
            $data = ['resp' => $resp];
            echo json_encode($data);
            break;
        case 'actualizarNotificacionLeido' :
            session_start();
            $usuario  = $_SESSION['codigo'];
            $datos = array("0", $usuario);
            require_once '../modelos/RegistroNotificacion.php';
            $modelo = new RegistroNotificacion;
            $resp = $modelo->actualizarNotificacionLeido($datos);
            $data = ['resp' => $resp];
            echo json_encode($data);
            break;
    }
}
class RegistrosNotificaciones{

    function modelo($modelo){
        require_once '../modelos/'.$modelo.'.php';
        return new $modelo();
    }

	public function agregarRegistro($usuario, $mensaje){
        $datos = array("1", "1");
        $modelo = modelo('Usuario');
        $listaUsuario = $modelo->listaUsuariosRegistro($datos);
        date_default_timezone_set('America/La_Paz');
        $hora = date("H:i:s");
        $fecha = date("Y-m-d");

        for($i = 0; $i<sizeof($listaUsuario); $i++){
            $datos = array($usuario, $listaUsuario[$i]['cod_usuario'], $mensaje, $fecha, $hora, "1");
            $modelo = modelo('RegistroNotificacion');
            $resp = $modelo->agregarRegistro($datos);
        }
	}
	
   	public function agregarNotificacion($mensaje){
        $datos = array("1", "1");
        $modelo = modelo('Usuario');
        $listaUsuario = $modelo->listaUsuariosRegistro($datos);
        date_default_timezone_set('America/La_Paz');
        $hora = date("H:i:s");
        $fecha = date("Y-m-d");

        for($i = 0; $i<sizeof($listaUsuario); $i++){
            $datos = array($listaUsuario[$i]['cod_usuario'], $mensaje, $fecha, $hora, "1");
            $modelo = modelo('RegistroNotificacion');
            $resp = $modelo->agregarNotificacion($datos);
        }
    }
}
?>
<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarCliente' :
            agregarCliente();
            break;
        case 'listaCliente' :
            listaCliente();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarCliente(){
    $codigoSession = $_POST['codigoSession'];
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";

    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $telefono, $email, $codigoSession, $fecha, $hora);
    $modelo = modelo('Cliente');
    $resp = $modelo->agregarCliente($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Se registro a un nuevo Cliente (".$nombre." ".$appat." ".$apmat.") con C.I.:".$ci." ".$ci_exp);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCliente(){
    $datos = array();
    $modelo = modelo('Cliente');
    $lista = $modelo->listaCliente($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha"] = date("d/m/Y", strtotime($lista[$i]["fecha"])).' '.$lista[$i]["hora"];
    }
    echo json_encode($lista);
}

?>
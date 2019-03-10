<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarCajaChica' :
            agregarCajaChica();
            break;
        case 'listaCajaChica' :
            listaCajaChica();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarCajaChica(){
    $costo = $_POST['costo'];
    $detalle = $_POST['detalle'];
    $comprobante = $_POST['comprobante'];
    $sucursal = $_POST['sucursal'];

    $usuario = $_SESSION['codigo'];
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $data = array();
    $resp = "";

    $datos = array($costo, $detalle, $comprobante, $usuario, $fecha, $hora, $sucursal);
    $modelo = modelo('CajaChica');
    $resp = $modelo->agregarCajaChica($datos);

    $datos = array($sucursal);
    $modelo = modelo('Sucursal');
    $sucursal = $modelo->sucursalEspecifico($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se registro un nuevo Gasto (".$detalle." Bs. ".$costo.") en la Sucursal ".$sucursal[0]['nombre_sucursal']);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaCajaChica(){
    $sucursal = $_POST['sucursal'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    $datos = array($sucursal, $mes, $año);
    $modelo = modelo('CajaChica');
    $lista = $modelo->listaCajaChica($datos);
    for($i = 0 ; $i < sizeof($lista) ; $i++){
        $lista[$i]["fecha"] = date("d/m/Y", strtotime($lista[$i]["fecha"])).' '.$lista[$i]["hora"];
        $lista[$i]["monto_gasto"] = 'Bs. '.$lista[$i]["monto_gasto"];

    }
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

?>
<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarTarjeta' :
            agregarTarjeta();
            break;
        case 'listaTarjeta' :
            listaTarjeta();
            break;
        case 'tarjetaEspecifico' :
            tarjetaEspecifico();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarTarjeta(){
    $codigoSession = $_POST['codigoSession'];
    $codigo = $_POST['codigo'];
    $observacion = $_POST['observacion'];

    $datos = array($codigo, $codigo, $observacion);
    $modelo = modelo('Tarjeta');
    $resp = $modelo->agregarTarjeta($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Se registro una Nueva Tarjeta Inteligente con Codigo (".$codigo.")");

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaTarjeta(){
    $datos = array();
    $modelo = modelo('Tarjeta');
    $lista = $modelo->listaTarjeta($datos);
    echo json_encode($lista);
}

function tarjetaEspecifico(){
    $tarjeta = $_POST['tarjeta'];
    $datos = array($tarjeta);
    $modelo = modelo('Tarjeta');
    $lista = $modelo->tarjetaEspecifico($datos);
    echo json_encode($lista);
}

?>
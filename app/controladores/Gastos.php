<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarGasto' :
            agregarGasto();
            break;
        case 'listaGasto' :
            listaGasto();
            break;
        case 'gastoEspecifico' :
            gastoEspecifico();
            break;
        case 'actualizarGasto' :
            actualizarGasto();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function actualizarGasto(){
    $codigoSession = $_POST['codigoSession'];
    $codigo = $_POST['codigoSession'];
    $monto = $_POST['monto'];
    $detalle = $_POST['detalle'];
    $comprobante = $_POST['comprobante'];

    $datos = array($monto, $detalle, $comprobante, $codigo);
    $modelo = modelo('Gasto');
    $resp = $modelo->actualizarGasto($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Los datos del Gasto ".$detalle." fue modificado y actualizado, Se recomienda revisar los datos");
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function agregarGasto(){
    $codigoSession = $_POST['codigoSession'];
    $monto = $_POST['monto'];
    $detalle = $_POST['detalle'];
    $nombreImagen = $_POST['nombreImagen'];

    $imagen = $_POST['imagen'];
    file_put_contents("../../public/imagenes/gastos/".$nombreImagen, base64_decode($imagen));

    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";

    $datos = array($monto, $detalle, $nombreImagen, $codigoSession, $fecha, $hora);
    $modelo = modelo('Gasto');
    $resp = $modelo->agregarGasto($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Se registro un nuevo Gasto (".$detalle.") con Monto de: Bs. ".$Monto);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaGasto(){
    $datos = array();
    $modelo = modelo('Gasto');
    $lista = $modelo->listaGasto($datos);
    echo json_encode($lista);
}

function gastoEspecifico(){
    $gasto = $_POST['gasto'];
    $datos = array($gasto);
    $modelo = modelo('Gasto');
    $lista = $modelo->gastoEspecifico($datos);
    echo json_encode($lista);
}

?>
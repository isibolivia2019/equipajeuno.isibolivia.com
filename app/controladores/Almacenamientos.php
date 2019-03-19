<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarEquipaje' :
            agregarEquipaje();
            break;
        case 'listaTarjetaLibre' :
            listaTarjetaLibre();
            break;
        case 'listaTarjetaOcupada' :
            listaTarjetaOcupada();
            break;
        case 'almacenamientoEntregaEspecifico' :
            almacenamientoEntregaEspecifico();
            break;
        case 'devolverEquipaje' :
            devolverEquipaje();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarEquipaje(){
    $codigoSession = $_POST['codigoSession'];
    $codigoTarjeta = $_POST['codigoTarjeta'];
    $codigoCliente = $_POST['codigoCliente'];
    $pago = $_POST['pago'];
    $costo = $_POST['costo'];
    $detalle = $_POST['detalle'];

    $nombreImagen = $_POST['nombreImagen'];
    $imagen = $_POST['imagen'];
    if($nombreImagen != "sin_imagen_equipaje.jpg"){
        file_put_contents("../../public/imagenes/equipaje/".$nombreImagen, base64_decode($imagen));
    }
    
    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";

    $datos = array($codigoCliente, $codigoTarjeta, $nombreImagen, $pago, $costo, $costo, $detalle, $fecha, $hora, $codigoSession);
    $modelo = modelo('Almacenamiento');
    $resp = $modelo->agregarEquipaje($datos);

    $datos = array("1", $codigoTarjeta);
    $modelo = modelo('Tarjeta');
    $resp = $modelo->cambiarEstado($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Se registro el recepcionamiento de un nuevo equipaje  (".$detalle.") con el Costo de: Bs. ".$costo);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function devolverEquipaje(){
    $codigoSession = $_POST['codigoSession'];
    $codigoTarjeta = $_POST['codigoTarjeta'];
    $codigoCliente = $_POST['codigoCliente'];
    $totalCosto = $_POST['totalCosto'];
    $observacion = $_POST['observacion'];
    $detalleInicio = $_POST['detalleInicio'];

    date_default_timezone_set('America/La_Paz');
    $hora = date("H:i:s");
    $fecha = date("Y-m-d");
    $resp = "";

    $datos = array($totalCosto, $observacion, $fecha, $hora, $codigoSession, $codigoTarjeta, $codigoCliente);
    $modelo = modelo('Almacenamiento');
    $resp = $modelo->devolverEquipaje($datos);

    $datos = array("0", $codigoTarjeta);
    $modelo = modelo('Tarjeta');
    $resp = $modelo->cambiarEstado($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Se registro ela entrega del equipaje  (".$detalleInicio.") con un Costo Total de: Bs. ".$totalCosto);

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaTarjetaLibre(){
    $datos = array("0");
    $modelo = modelo('Tarjeta');
    $lista = $modelo->listaTarjetaLibre($datos);
    echo json_encode($lista);
}

function listaTarjetaOcupada(){
    $datos = array();
    $modelo = modelo('Almacenamiento');
    $lista = $modelo->listaTarjetaOcupada($datos);
    echo json_encode($lista);
}

function almacenamientoEntregaEspecifico(){
    $tarjeta = $_POST['tarjeta'];
    $datos = array($tarjeta);
    $modelo = modelo('Almacenamiento');
    $lista = $modelo->almacenamientoEntregaEspecifico($datos);
    echo json_encode($lista);
}
?>
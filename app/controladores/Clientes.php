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
        case 'HistorialClienteEquipaje' :
            HistorialClienteEquipaje();
            break;
        case 'HistorialClienteEquipajeBusqueda' :
            HistorialClienteEquipajeBusqueda();
            break;
        case 'listaClienteBusqueda' :
            listaClienteBusqueda();
            break;
        case 'clienteEspecifico' :
            clienteEspecifico();
            break;
        case 'actualizarCliente' :
            actualizarCliente();
            break;
        case 'clienteEspecificoCi' :
            clienteEspecificoCi();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function actualizarCliente(){
    $codigoSession = $_POST['codigoSession'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];

    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $celular, $email, $codigo);
    $modelo = modelo('Cliente');
    $resp = $modelo->actualizarCliente($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($codigoSession, "Los datos del Cliente ".$nombre." ".$appat." ".$apmat." fue modificado y actualizado, Se recomienda revisar los datos");
    $data = ['resp' => $resp];
    echo json_encode($data);
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

function HistorialClienteEquipaje(){
    $codigo = $_POST['codigo'];
    $datos = array($codigo);
    $modelo = modelo('Almacenamiento');
    $lista = $modelo->HistorialClienteEquipaje($datos);

    $datos = array();
    $modelo = modelo('Usuario');
    $listaUsuario = $modelo->listaUsuarios($datos);

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        for($j = 0 ; $j < sizeof($listaUsuario) ; $j++){
            if($listaUsuario[$j]["cod_usuario"] == $lista[$i]["usuario_inicio"]){
                $lista[$i]["usuario_inicio"] = $listaUsuario[$j]["nombre"]." ".$listaUsuario[$j]["appat"]." ".$listaUsuario[$j]["apmat"];
            }
            if($listaUsuario[$j]["cod_usuario"] == $lista[$i]["usuario_final"]){
                $lista[$i]["usuario_final"] = $listaUsuario[$j]["nombre"]." ".$listaUsuario[$j]["appat"]." ".$listaUsuario[$j]["apmat"];
            }
        }
    }
    echo json_encode($lista);
}

function HistorialClienteEquipajeBusqueda(){
    $buscar = $_POST['buscar'];
    $datos = array();
    $modelo = modelo('Almacenamiento');
    $lista = $modelo->HistorialClienteEquipajeBusqueda($datos, $buscar);

    $datos = array();
    $modelo = modelo('Usuario');
    $listaUsuario = $modelo->listaUsuarios($datos);

    for($i = 0 ; $i < sizeof($lista) ; $i++){
        for($j = 0 ; $j < sizeof($listaUsuario) ; $j++){
            if($listaUsuario[$j]["cod_usuario"] == $lista[$i]["usuario_inicio"]){
                $lista[$i]["usuario_inicio"] = $listaUsuario[$j]["nombre"]." ".$listaUsuario[$j]["appat"]." ".$listaUsuario[$j]["apmat"];
            }
            if($listaUsuario[$j]["cod_usuario"] == $lista[$i]["usuario_final"]){
                $lista[$i]["usuario_final"] = $listaUsuario[$j]["nombre"]." ".$listaUsuario[$j]["appat"]." ".$listaUsuario[$j]["apmat"];
            }
        }
    }
    echo json_encode($lista);
}

function listaCliente(){
    $datos = array();
    $modelo = modelo('Cliente');
    $lista = $modelo->listaCliente($datos);
    echo json_encode($lista);
}

function listaClienteBusqueda(){
    $buscar = $_POST['buscar'];
    $datos = array();
    $modelo = modelo('Cliente');
    $lista = $modelo->listaClienteBusqueda($datos, $buscar);
    echo json_encode($lista);
}

function clienteEspecifico(){
    $cliente = $_POST['cliente'];
    $datos = array($cliente);
    $modelo = modelo('Cliente');
    $lista = $modelo->clienteEspecifico($datos);
    echo json_encode($lista);
}

function clienteEspecificoCi(){
    $ci = $_POST['ci'];
    $datos = array($ci);
    $modelo = modelo('Cliente');
    $lista = $modelo->clienteEspecificoCi($datos);
    echo json_encode($lista);
}

?>
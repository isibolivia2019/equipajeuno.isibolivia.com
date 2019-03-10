<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'asignarUsuarioSucursal' :
            asignarUsuarioSucursal();
            break;
        case 'asignarUsuarioAlmacen' :
            asignarUsuarioAlmacen();
            break;
        case 'listaAccesoModulos' :
            listaAccesoModulos();
            break;
        case 'listaAccesosSucursales' :
            listaAccesosSucursales();
            break;
        case 'listaAccesosAlmacenes' :
            listaAccesosAlmacenes();
            break;
        case 'eliminarAccesosAlmacen' :
            eliminarAccesosAlmacen();
            break;
        case 'eliminarAccesosSucursal' :
            eliminarAccesosSucursal();
            break;
        case 'listaAccesosSucursalesCodigo' :
            listaAccesosSucursalesCodigo();
            break;
        case 'actualizarAccesoModulo' :
            actualizarAccesoModulo();
            break;

    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function eliminarAccesosSucursal(){
    $codusuario = $_POST['usuario'];
    $codsucursal = $_POST['sucursal'];
    $datos = array($codusuario, $codsucursal);
    $modelo = modelo('Acceso');
    $resp = $modelo->eliminarAccesosSucursal($datos);
    $data = array();

    $datos = array($codusuario);
    $modelo = modelo('Usuario');
    $usuario = $modelo->usuarioEspecifico($datos);

    $datos = array($codsucursal);
    $modelo = modelo('Sucursal');
    $sucursal = $modelo->sucursalEspecifico($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se elimino el acceso del Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." hacia la sucursal ".$sucursal[0]['nombre_sucursal']);
    $registrosNotificaciones->agregarNotificacion("Se elimino el acceso del Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." hacia la sucursal ".$sucursal[0]['nombre_sucursal']);
    
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function eliminarAccesosAlmacen(){
    $codusuario = $_POST['usuario'];
    $codalmacen = $_POST['almacen'];
    $datos = array($codusuario, $codalmacen);
    $modelo = modelo('Acceso');
    $resp = $modelo->eliminarAccesosAlmacen($datos);
    $data = array();

    $datos = array($codusuario);
    $modelo = modelo('Usuario');
    $usuario = $modelo->usuarioEspecifico($datos);

    $datos = array($codalmacen);
    $modelo = modelo('Almacen');
    $almacen = $modelo->almacenEspecifico($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se elimino el acceso del Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." hacia el Almacen ".$almacen[0]['nombre_almacen']);
    $registrosNotificaciones->agregarNotificacion("Se elimino el acceso del Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." hacia el Almacen ".$almacen[0]['nombre_almacen']);
    
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function listaAccesoModulos(){
    $usuario = $_POST['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesoModulos($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaAccesosSucursalesCodigo(){
    $usuario = $_SESSION['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesosSucursales($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaAccesosSucursales(){
    $usuario = $_POST['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesosSucursales($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function listaAccesosAlmacenes(){
    $usuario = $_POST['codigo'];
    $datos = array($usuario);
    $modelo = modelo('Acceso');
    $lista = $modelo->listaAccesosAlmacenes($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function asignarUsuarioAlmacen(){
    $almacen = $_POST['almacen'];
    $usuario = $_POST['usuario'];
    $data = array();

    $datos = array($usuario, $almacen);
    $modelo = modelo('Acceso');
    $lista = $modelo->verificarUsuarioAlmacen($datos);

    if(sizeof($lista) == 0){
        $datos = array($usuario, $almacen);
        $modelo = modelo('Acceso');
        $resp = $modelo->asignarUsuarioAlmacen($datos);

        $datos = array($usuario);
        $modelo = modelo('Usuario');
        $usuario = $modelo->usuarioEspecifico($datos);

        $datos = array($almacen);
        $modelo = modelo('Almacen');
        $almacen = $modelo->almacenEspecifico($datos);

        $registrosNotificaciones = new RegistrosNotificaciones();
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se permitio que el Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." tenga Acceso al Almacen ".$almacen[0]['nombre_almacen']);

        $registrosNotificaciones->agregarNotificacion("Se permitio que el Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." tenga Acceso al Almacen ".$almacen[0]['nombre_almacen']);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function asignarUsuarioSucursal(){
    $sucursal = $_POST['sucursal'];
    $usuario = $_POST['usuario'];
    $data = array();

    $datos = array($usuario, $sucursal);
    $modelo = modelo('Acceso');
    $lista = $modelo->verificarUsuarioSucursal($datos);

    if(sizeof($lista) == 0){
        $datos = array($usuario, $sucursal);
        $modelo = modelo('Acceso');
        $resp = $modelo->asignarUsuarioSucursal($datos);

        $datos = array($usuario);
        $modelo = modelo('Usuario');
        $usuario = $modelo->usuarioEspecifico($datos);

        $datos = array($sucursal);
        $modelo = modelo('Sucursal');
        $sucursal = $modelo->sucursalEspecifico($datos);

        $registrosNotificaciones = new RegistrosNotificaciones();
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se permitio que el Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." tenga Acceso a la Sucursal ".$sucursal[0]['nombre_sucursal']);

        $registrosNotificaciones->agregarNotificacion("Se permitio que el Usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." tenga Acceso a la Sucursal ".$sucursal[0]['nombre_sucursal']);
    }else{
        $resp = "false";
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}

function actualizarAccesoModulo(){
    $usuario = $_POST['usuario'];
    $estado = $_POST['estado'];
    $modulo = $_POST['modulo'];
    $data = array();
    $resp = "";

    $registrosNotificaciones = new RegistrosNotificaciones();

    $datos = array($estado, $usuario);
    $modelo = modelo('Usuario');

    if($modulo == "Usuario"){$resp = $modelo->actualizarPrivilegioItemUsuario($datos);}
    if($modulo == "Sucursal"){$resp = $modelo->actualizarPrivilegioItemSucursal($datos);}
    if($modulo == "Almacen"){$resp = $modelo->actualizarPrivilegioItemAlmacen($datos);}
    if($modulo == "Producto"){$resp = $modelo->actualizarPrivilegioItemProducto($datos);}
    if($modulo == "Venta"){$resp = $modelo->actualizarPrivilegioItemVentas($datos);}
    if($modulo == "Reporte"){$resp = $modelo->actualizarPrivilegioItemReportes($datos);}
    if($modulo == "CajaChica"){$resp = $modelo->actualizarPrivilegioItemCajaChica($datos);}
    if($modulo == "Acceso"){$resp = $modelo->actualizarPrivilegioItemAccesos($datos);}
    if($modulo == "Configuracion"){$resp = $modelo->actualizarPrivilegioItemConfiguracion($datos);}

    $datos = array($usuario);
    $modelo = modelo('Usuario');
    $listaUsuario = $modelo->usuarioEspecifico($datos);

    if($estado){
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se permitio que el Usuario ".$listaUsuario[0]['nombre_usuario']." ".$listaUsuario[0]['appat_usuario']." ".$listaUsuario[0]['apmat_usuario']." tenga Acceso al modulo ".$modulo);
        $registrosNotificaciones->agregarNotificacion("Se permitio que el Usuario ".$listaUsuario[0]['nombre_usuario']." ".$listaUsuario[0]['appat_usuario']." ".$listaUsuario[0]['apmat_usuario']." tenga Acceso al modulo ".$modulo);
    }else{
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se denego que el Usuario ".$listaUsuario[0]['nombre_usuario']." ".$listaUsuario[0]['appat_usuario']." ".$listaUsuario[0]['apmat_usuario']." tenga Acceso al modulo ".$modulo.". Modulo Bloqueado");
        $registrosNotificaciones->agregarNotificacion("Se denego que el Usuario ".$listaUsuario[0]['nombre_usuario']." ".$listaUsuario[0]['appat_usuario']." ".$listaUsuario[0]['apmat_usuario']." tenga Acceso al modulo ".$modulo.". Modulo Bloqueado");
    }
    
    $data = ['resp' => $resp];
    echo json_encode($data);
}

?>
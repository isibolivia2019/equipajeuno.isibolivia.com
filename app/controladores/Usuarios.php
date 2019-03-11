<?php
ini_set('display_errors', '1');
session_start();
require_once 'RegistrosNotificaciones.php';
$action = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'agregarUsuario' :
            agregarUsuario();
            break;


        case 'autentificacionUsuario' :
            autentificacionUsuario();
            break;
        case 'listaUsuarioEstado' :
            listaUsuarioEstado();
            break;
        case 'listaUsuarioSinCargo' :
            listaUsuarioSinCargo();
            break;
        case 'verificarPrivilegio' :
            verificarPrivilegio();
            break;
        case 'verificarInicio' :
            verificarInicio();
            break;
        case 'usuarioEspecifico' :
            usuarioEspecifico();
            break;
        case 'actualizarUsuario' :
            actualizarUsuario();
            break;
        case 'cambiarEstado' :
            cambiarEstado();
            break;
    }
}

function modelo($modelo){
    require_once '../modelos/'.$modelo.'.php';
    return new $modelo();
}

function agregarUsuario(){
    $codigoSession = $_POST['codigoSession'];
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $genero = $_POST['genero'];
    $fec_nac = $_POST['fec_nac'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nombreRef = $_POST['nombreRef'];
    $telefonoRef = $_POST['telefonoRef'];
    $tipoRef = $_POST['tipoRef'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $estado = $_POST['estado'];
    $notificacion = $_POST['notificacion'];
    $registro = $_POST['registro'];

    $data = array();
    $resp = "";

    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $genero, $fec_nac, $direccion, $telefono, $nombreRef, $telefonoRef, $tipoRef, $email, $pass, "sin_imagen_usuario.jpg", $estado, $registro, $notificacion);
    $modelo = modelo('Usuario');
    $resp = $modelo->agregarUsuario($datos);
    if($resp == "true"){
        $datos = array($ci, $pass);
        $listaUsuario = $modelo->autentificacionUsuario($datos);

        $datos = array($listaUsuario[0]["cod_usuario"], "1", "1", "1", "1", "1", "1", "1", "1", "1", $registro, $notificacion);
        $resp = $modelo->agregarPrivilegio($datos);

        $registrosNotificaciones = new RegistrosNotificaciones();
        $registrosNotificaciones->agregarRegistro($codigoSession, "Un nuevo USUARIO (".$nombre." ".$appat." ".$apmat." con C.I.:".$ci.") fue registro en el sistema.");

        $registrosNotificaciones->agregarRegistro($codigoSession, "Al usuario ".$nombre." ".$appat." ".$apmat." se le asigno todos los accesos al sistema como predeterminado. Puede modificarlo en la seccion de ACCESOS.");
    }

    $data = ['resp' => $resp];
    echo json_encode($data);
}








function autentificacionUsuario(){
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $datos = array($usuario, $pass);

    $usuarioModelo = modelo('Usuario');
    $usuario = $usuarioModelo->autentificacionUsuario($datos);
    if(sizeof($usuario) > 0){
        $datos = array($usuario[0]["cod_usuario"]);
        $permisos = $usuarioModelo->listaPrivilegiosUsuarios($datos);

        $usuario[0]['itemUsuario'] = $permisos[0]['itemUsuario'];
        $usuario[0]['itemCliente'] = $permisos[0]['itemCliente'];
        $usuario[0]['itemTarjeta'] = $permisos[0]['itemTarjeta'];
        $usuario[0]['itemReportes'] = $permisos[0]['itemReportes'];
        $usuario[0]['itemRecepcion'] = $permisos[0]['itemRecepcion'];
        $usuario[0]['itemEntrega'] = $permisos[0]['itemEntrega'];
        $usuario[0]['itemEstante'] = $permisos[0]['itemEstante'];
        $usuario[0]['itemGastos'] = $permisos[0]['itemGastos'];
        $usuario[0]['itemAccesos'] = $permisos[0]['itemAccesos'];
        $usuario[0]['itemRegistro'] = $permisos[0]['itemRegistro'];
        $usuario[0]['itemNotificacion'] = $permisos[0]['itemNotificacion'];
    }
    echo json_encode($usuario);
}

function listaUsuarioSinCargo(){
    $datos = array();
    $modelo = modelo('Usuario');
    $lista = $modelo->listaUsuarioSinCargo($datos);
    echo json_encode($lista);
}

function listaUsuarioEstado(){
    $estado = $_POST['estado'];
    $datos = array($estado);
    $modelo = modelo('Usuario');
    $lista = $modelo->listaUsuarioEstado($datos);
    $data = array();
    $data = ['data' => $lista];
    echo json_encode($data);
}

function cambiarEstado(){
    $codigo = $_POST['codigo'];
    $estado = $_POST['estado'];
    $datos = array($estado, $codigo);
    $modelo = modelo('Usuario');
    $resp = $modelo->cambiarEstado($datos);
    $datos = array($codigo);
    $modelo = modelo('Usuario');
    $usuario = $modelo->usuarioEspecifico($datos);

    $data = array();
    $registrosNotificaciones = new RegistrosNotificaciones();
    if($estado == "1"){
        $registrosNotificaciones->agregarNotificacion("El usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." con C.I.:".$usuario[0]['ci_usuario'].") fue habilitado al Accesso del sistema.");
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "El usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." con C.I.:".$usuario[0]['ci_usuario'].") fue habilitado al Accesso del sistema.");
    }else{
        $registrosNotificaciones->agregarNotificacion("El usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." con C.I.:".$usuario[0]['ci_usuario'].") fue Deshabilitado al Accesso del sistema.");
        $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "El usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." con C.I.:".$usuario[0]['ci_usuario'].") fue Deshabilitado al Accesso del sistema.");
    }
    $data = ['resp' => $resp];

    echo json_encode($data);
}

function usuarioEspecifico(){
    $usuario = $_POST['usuario'];
    $datos = array($usuario);
    $usuarioModelo = modelo('Usuario');
    $lista = $usuarioModelo->usuarioEspecifico($datos);
    echo json_encode($lista);
}

function actualizarUsuario(){
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $appat = $_POST['appat'];
    $apmat = $_POST['apmat'];
    $ci = $_POST['ci'];
    $ci_exp = $_POST['ci_exp'];
    $genero = $_POST['genero'];
    $fec_nac = $_POST['fec_nac'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nombreRef = $_POST['nombreRef'];
    $telefonoRef = $_POST['telefonoRef'];
    $tipoRef = $_POST['tipoRef'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $notificacion = $_POST['notificacion'];
    $registro = $_POST['registro'];

    $datos = array($codigo);
    $modelo = modelo('Usuario');
    $usuario = $modelo->usuarioEspecifico($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    if($usuario[0]['registro'] != $registro){

        $datos = array($registro, $codigo);
        $modelo = modelo('Usuario');
        $resp = $modelo->actualizarPrivilegioItemRegistro($datos);

        if($registro){
            $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se habilito el Acceso de Registro de Movimientos para el Usuario ".$nombre." ".$appat." ".$apmat.", Ahora podra recibir Los registro de movimiento de cada usuario");
            $registrosNotificaciones->agregarNotificacion("Se habilito el Acceso de Registro de Movimientos para el Usuario ".$nombre." ".$appat." ".$apmat.", Ahora podra recibir Los registro de movimiento de cada usuario");
        }else{
            $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se Deshabilito el Acceso de Registro de Movimientos para el Usuario ".$nombre." ".$appat." ".$apmat.", ya no recibira los registro de movimiento de cada usuario");
            $registrosNotificaciones->agregarNotificacion("Se Deshabilito el Acceso de Registro de Movimientos para el Usuario ".$nombre." ".$appat." ".$apmat.", ya no recibira los registro de movimiento de cada usuario");
        }
    }
    if($usuario[0]['notificacion'] != $notificacion){
        $datos = array($notificacion, $codigo);
        $modelo = modelo('Usuario');
        $resp = $modelo->actualizarPrivilegioItemNotificacion($datos);

        if($notificacion){
            $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se habilito el Acceso de Notificaciones para el Usuario ".$nombre." ".$appat." ".$apmat.", Ahora podra recibir notificaciones del Sistema");
            $registrosNotificaciones->agregarNotificacion("Se habilito el Acceso de Notificaciones para el Usuario ".$nombre." ".$appat." ".$apmat.", Ahora podra recibir notificaciones del Sistema");    
        }else{
            $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Se Deshabilito el Acceso de Notificaciones para el Usuario ".$nombre." ".$appat." ".$apmat.", ya no recibira notificaciones del Sistema");
            $registrosNotificaciones->agregarNotificacion("Se Deshabilito el Acceso de Notificaciones para el Usuario ".$nombre." ".$appat." ".$apmat.", ya no recibira notificaciones del Sistema");
        }
    }
    $datos = array($nombre, $appat, $apmat, $ci, $ci_exp, $genero, $fec_nac, $direccion, $telefono, $nombreRef, $telefonoRef, $tipoRef, $email, $pass, $registro, $notificacion, $codigo);
    $modelo = modelo('Usuario');
    $resp = $modelo->actualizarUsuario($datos);

    $registrosNotificaciones = new RegistrosNotificaciones();
    $registrosNotificaciones->agregarRegistro($_SESSION['codigo'], "Los datos del usuario ".$nombre." ".$appat." ".$apmat." fue modificado y actualizado, Se recomienda revisar los datos");
    $data = ['resp' => $resp];
    echo json_encode($data);
}

function verificarPrivilegio(){
    $privilegio = $_POST['privilegio'];
    $data = array();
    if(isset($_SESSION[$privilegio])){
        if ($_SESSION[$privilegio] == 1) {
            if ((time() - $_SESSION['tiempoSession']) < $_SESSION['tiempoAsigando'] ) {
                $_SESSION['tiempoSession'] = time();

                $listaRegistro = [];
                $listaNotificacion = [];

                $usuario  = $_SESSION['codigo'];
                $datos = array($usuario, "1");
                $modelo = modelo('RegistroNotificacion');
                $listaRegistro = $modelo->listaRegistroCodigoUsuario($datos);

                for($i=0;$i<sizeof($listaRegistro);$i++){
                    $listaRegistro[$i]['fecha'] = date("d/m", strtotime($listaRegistro[$i]["fecha"]));
                }

                $datos = array($usuario, "1");
                $modelo = modelo('RegistroNotificacion');
                $listaNotificacion = $modelo->listaNotificacionCodigoUsuario($datos);

                for($i=0;$i<sizeof($listaNotificacion);$i++){
                    $listaNotificacion[$i]['fecha'] = date("d/m", strtotime($listaNotificacion[$i]["fecha"]));
                }

                $data = ['privilegio' => '2', 'registro' => $listaRegistro, 'notificacion' => $listaNotificacion];

            }else{
                session_destroy();
                $data = ['privilegio' => '1'];
            }
        }else{
            $datos = array($_SESSION['codigo']);
            $modelo = modelo('Usuario');
            $usuario = $modelo->usuarioEspecifico($datos);

            $registrosNotificaciones = new RegistrosNotificaciones();
            $registrosNotificaciones->agregarNotificacion("El usuario ".$usuario[0]['nombre_usuario']." ".$usuario[0]['appat_usuario']." ".$usuario[0]['apmat_usuario']." Intento acceder a un Modulo del sistema que esta restringido para el Usuario. REFERENCIA:".$privilegio);
            session_destroy();
            $data = ['privilegio' => '0'];
        }
    }else{
        session_destroy();
        $data = ['privilegio' => '-1'];
    }
    echo json_encode($data);
}

function verificarInicio(){
    $data = array();
    if(isset($_SESSION['codigo'])){

            if ((time() - $_SESSION['tiempoSession']) < $_SESSION['tiempoAsigando'] ) {
                $_SESSION['tiempoSession'] = time();

                $listaRegistro = [];
                $listaNotificacion = [];

                $usuario  = $_SESSION['codigo'];
                $datos = array($usuario, "1");
                $modelo = modelo('RegistroNotificacion');
                $listaRegistro = $modelo->listaRegistroCodigoUsuario($datos);

                for($i=0;$i<sizeof($listaRegistro);$i++){
                    $listaRegistro[$i]['fecha'] = date("d/m", strtotime($listaRegistro[$i]["fecha"]));
                }

                $datos = array($usuario, "1");
                $modelo = modelo('RegistroNotificacion');
                $listaNotificacion = $modelo->listaNotificacionCodigoUsuario($datos);

                for($i=0;$i<sizeof($listaNotificacion);$i++){
                    $listaNotificacion[$i]['fecha'] = date("d/m", strtotime($listaNotificacion[$i]["fecha"]));
                }

                $data = ['privilegio' => '2', 'registro' => $listaRegistro, 'notificacion' => $listaNotificacion];

            }else{
                session_destroy();
                $data = ['privilegio' => '1'];
            }
    }else{
        session_destroy();
        $data = ['privilegio' => '-1'];
    }
    echo json_encode($data);
}
?>
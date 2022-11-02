<?php
header('Content-type: application/json');
include 'conexion.php';
session_start();

$funcion = $_POST['funcion'];


if ($funcion == "login") {
    $username = $_POST['username'];
    $contrasenia = $_POST['contrasenia'];

    $stmt = $conn->prepare("SELECT * FROM vista_usuarios WHERE nombre_usuario = ? LIMIT 1");
    $stmt->execute([$username]);
    $usuario = $stmt->fetch();

    if ($usuario == null) {
        $myObj = new stdClass();
        $myObj->mensaje = "Nombre de usuario no existe";
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }

    if ($usuario['estado'] == "desactivado") {
        $myObj = new stdClass();
        $myObj->mensaje = "Usuario desactivado";
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }

    if ($usuario['contrasenia'] != $contrasenia) {
        $myObj = new stdClass();
        $myObj->mensaje = "Contraseña incorrecta";
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }

    try {

        $conn->beginTransaction();

        //Update usuario
        $stmt = $conn->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
        $stmt->execute(["conectado", $usuario['id_usuario']]);

        $conn->commit();
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }


    $_SESSION['usuario']['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['usuario']['nombre_usuario'] = $usuario['nombre_usuario'];
    $_SESSION['usuario']['id_rol'] = $usuario['id_rol'];
    $_SESSION['usuario']['nombre'] = $usuario['nombre'];

    $myObj = new stdClass();
    $myObj->mensaje = "Sesion iniciada";
    $myObj->estado = 'ok';
    $myObj->usuario = $usuario;
    echo json_encode($myObj);
    return;
}

if ($funcion == "logout") {
    $idUsuario = $_POST['idUsuario'];
    try {
        $conn->beginTransaction();
        //Update usuario
        $stmt = $conn->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
        $stmt->execute(["desconectado", $idUsuario]);
        $conn->commit();
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }
    session_destroy();
    $myObj = new stdClass();
    $myObj->mensaje = "Sesion cerrada";
    $myObj->estado = 'ok';
    echo json_encode($myObj);
    return;
}



$myObj = new stdClass();
$myObj->mensaje = "Funcion no encontrada";
$myObj->estado = 'error';
echo json_encode($myObj);
return;

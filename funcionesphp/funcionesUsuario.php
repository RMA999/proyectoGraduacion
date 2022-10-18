<?php
header('Content-type: application/json');

include 'conexion.php';

$funcion = $_POST['funcion'];


if ($funcion == "crearUsuario") {
    $dpi = $_POST['dpi'];
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idRol = 2;

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE personas(dpi,nombre) VALUES(?,?);");
        $stmt->execute([$dpi, $nombre]);
        $idPersona = $conn->lastInsertId();

        $stmt = $conn->prepare("UPDATE usuarios(nombre_usuario, contrasenia, id_persona, id_rol) VALUES(?,?,?,?);");
        $stmt->execute([$username, $password, $idPersona, $idRol]);
        $idUsuario = $conn->lastInsertId();
        

        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Usuario Creado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }


    return;
}


if ($funcion == "modificarUsuario") {
    $idPersona = $_POST['idPersona'];
    $idUsuario = $_POST['idUsuario'];
    $dpi = $_POST['dpi'];
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];

    try {

        $conn->beginTransaction();

        $stmt = $conn->prepare("UPDATE personas SET dpi = ?, nombre = ? WHERE id = ?;");
        $stmt->execute([$dpi, $nombre, $idPersona]);
        $idPersona = $conn->lastInsertId();

        $stmt = $conn->prepare("UPDATE usuarios set nombre_usuario = ? WHERE id = ?");
        $stmt->execute([$username, $idUsuario]);
        $idUsuario = $conn->lastInsertId();
        

        $conn->commit();

        $myObj = new stdClass();
        $myObj->mensaje = "Usuario modificado";
        $myObj->estado = 'ok';
        echo json_encode($myObj);
    } catch (Exception $e) {
        // echo $e->getMessage();
        $conn->rollBack();
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
    }

    

    return;

}




$myObj = new stdClass();
$myObj->mensaje = "funcion de usuario no encontrada";
$myObj->estado = 'error';
$myObj->funcion = $funcion;
$myObj->numEscrituraAnt = $numEscrituraAnt;
$myObj->cantidadCesionarios = $cantidadCesionarios;
$myObj->urlArchivo = $urlArchivo;
echo json_encode($myObj);

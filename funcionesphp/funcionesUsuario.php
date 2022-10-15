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

        $stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) VALUES(?,?);");
        $stmt->execute([$dpi, $nombre]);
        $idPersona = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO usuarios(nombre_usuario, contrasenia, id_persona, id_rol) VALUES(?,?,?,?);");
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




$myObj = new stdClass();
$myObj->mensaje = "Tipo documento no encontrado";
$myObj->estado = 'error';
$myObj->funcion = $funcion;
$myObj->numEscrituraAnt = $numEscrituraAnt;
$myObj->cantidadCesionarios = $cantidadCesionarios;
$myObj->urlArchivo = $urlArchivo;
echo json_encode($myObj);

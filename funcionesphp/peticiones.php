<?php
header('Content-type: application/json');
include 'conexion.php';

$funcion = $_POST['funcion'];


if ($funcion == "crear") {
    $idDocumento = $_POST['id_documento'];
    $idUsuario = $_POST['id_usuario'];

    try {

        $stmt = $conn->prepare("SELECT * FROM peticiones WHERE id_documento = ? AND id_usuario = ? AND estado = ? LIMIT 1");
        $stmt->execute([$idDocumento, $idUsuario, "Pendiente"]);
        $peticion = $stmt->fetch();

        if ($peticion > 0) {
            $myObj = new stdClass();
            $myObj->mensaje = "existe";
            $myObj->estado = 'error';
            echo json_encode($myObj);
            return;
        }

        $stmt = $conn->prepare("INSERT INTO peticiones (id_documento, id_usuario, estado) VALUES (?,?,?)");
        $stmt->execute([$idDocumento, $idUsuario, "Pendiente"]);
    } catch (Exception $e) {
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }
    $myObj = new stdClass();
    $myObj->mensaje = "Peticion guardada";
    $myObj->estado = 'ok';
    echo json_encode($myObj);
    return;
}


if ($funcion == "aprobarRechazar") {
    $idPeticion = $_POST['id_peticion'];
    $estado = $_POST['estado'];

    try {
        $stmt = $conn->prepare("UPDATE peticiones SET estado = ? WHERE id = ?;");
        $stmt->execute([$estado, $idPeticion]);
    } catch (Exception $e) {
        $myObj = new stdClass();
        $myObj->mensaje = $e->getMessage();
        $myObj->estado = 'error';
        echo json_encode($myObj);
        return;
    }
    $myObj = new stdClass();
    $myObj->mensaje = "Peticion " . $estado;
    $myObj->estado = 'ok';
    echo json_encode($myObj);
    return;
}





$myObj = new stdClass();
$myObj->mensaje = "Funcion no encontrada";
$myObj->estado = 'error';
echo json_encode($myObj);
return;

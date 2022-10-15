<?php
header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');
$nombreUsuario = $_POST['nombreUsuario'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? LIMIT 1");
$stmt->execute([$nombreUsuario]);
$documento = $stmt->fetch();

if ($documento > 0) {
    $myObj = new stdClass();
    $myObj->mensaje = "Nombrede usuario ya existe";
    $myObj->estado = 'error';
    echo json_encode($myObj);
    return;
}

$myObj = new stdClass();
$myObj->mensaje = "Nombre de usuario no existe";
$myObj->estado = 'ok';
echo json_encode($myObj);

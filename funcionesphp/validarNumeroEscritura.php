<?php
header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');
$numEscritura = $_POST['numEscritura'];

$stmt = $conn->prepare("SELECT * FROM documentos WHERE numero_escritura = ? LIMIT 1");
$stmt->execute([$numEscritura]);
$documento = $stmt->fetch();

if ($documento > 0) {
    $myObj = new stdClass();
    $myObj->mensaje = "Numero de escritura ya existe";
    $myObj->estado = 'error';
    echo json_encode($myObj);
    return;
}

$myObj = new stdClass();
$myObj->mensaje = "Numero de escritura no existe";
$myObj->estado = 'ok';
echo json_encode($myObj);

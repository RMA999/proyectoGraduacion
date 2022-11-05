<?php
header('Content-type: application/json');

include 'conexion.php';

$stmt = $conn->prepare("SELECT 
COUNT(*) AS pendientes
FROM peticiones 
WHERE estado = 'Pendiente'");
$stmt->execute();
$peticiones = $stmt->fetch();

$myObj = new stdClass();
$myObj->mensaje = "Notificación";
$myObj->estado = 'ok';
$myObj->pendientes = $peticiones['pendientes'];
echo json_encode($myObj);

<?php
header('Content-type: application/json');

include 'conexion.php';

$stmt = $conn->prepare("SELECT
sum(case when estado = 'Pendiente' then 1 else 0 end) AS pendientes,
sum(case when estado = 'Aprobada' then 1 else 0 end) AS aprobadas,
sum(case when estado = 'Rechazada' then 1 else 0 end) AS rechazadas
FROM peticiones;");
$stmt->execute();
$peticiones = $stmt->fetch();

$stmt = $conn->prepare("SELECT
sum(case when id_tipo_documento = 1 then 1 else 0 end) AS compraventa,
sum(case when id_tipo_documento = 2 then 1 else 0 end) AS declaracion,
sum(case when id_tipo_documento = 3 then 1 else 0 end) AS herencia,
sum(case when id_tipo_documento = 4 then 1 else 0 end) AS donacion
FROM vista_documentos;");
$stmt->execute();
$documentos = $stmt->fetch();

$myObj = new stdClass();
$myObj->mensaje = "Notificación";
$myObj->estado = 'ok';
$myObj->peticiones =  new stdClass();
$myObj->peticiones->pendientes = $peticiones['pendientes'];
$myObj->peticiones->aprobadas = $peticiones['aprobadas'];
$myObj->peticiones->rechazadas = $peticiones['rechazadas'];
$myObj->documentos =  new stdClass();
$myObj->documentos->compraventa = $documentos['compraventa'];
$myObj->documentos->declaracion = $documentos['declaracion'];
$myObj->documentos->herencia = $documentos['herencia'];
$myObj->documentos->donacion = $documentos['donacion'];

echo json_encode($myObj);

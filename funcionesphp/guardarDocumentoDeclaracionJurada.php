<?php
header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');

$numEscritura = $_POST['numEscritura'];
$tipoDocumento = $_POST['tipoDocumento'];
$nombreDeclarador = $_POST['nombreDeclarador'];
$dpiDeclarador = $_POST['dpiDeclarador'];
$fecha = $_POST['fecha'];
$urlArchivo = $_POST['urlArchivo'];

$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiDeclarador, $nombreDeclarador]);
$idDeclarador = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO documentos(id_tipo_documento, id_persona_declarador, fecha, numero_escritura, url_archivo) 
                              VALUES(?,?,?,?,?);");
$stmt->execute([$tipoDocumento, $idDeclarador, $fecha, $numEscritura, $urlArchivo]);
$idDocumento = $conn->lastInsertId();

$myObj = new stdClass();
$myObj->mensaje = "Documento creado";
$myObj->declarador = "id: " . $idDeclarador;
$myObj->documento = "id: " . $idDocumento;
$myObj->estado = 'ok';
echo json_encode($myObj);

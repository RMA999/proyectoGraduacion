<?php
header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');

$tipoDocumento = $_POST['tipoDocumento'];
$nombreVendedor = $_POST['nombreVendedor'];
$nombreComprador = $_POST['nombreComprador'];
$dpiVendedor = $_POST['dpiVendedor'];
$dpiComprador = $_POST['dpiComprador'];
$fecha = $_POST['fecha'];
$numEscritura = $_POST['numEscritura'];
$ubicacionFisica = $_POST['ubicacionFisica'];
$urlArchivo = $_POST['urlArchivo'];

$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiVendedor, $nombreVendedor]);
$idVendedor = $conn->lastInsertId();


$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiComprador, $nombreComprador]);
$idComprador = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO documentos(id_tipo_documento, id_persona_vendedor, id_persona_comprador, fecha, numero_escritura, ubicacion_fisica, url_archivo) 
                              VALUES(?,?,?,?,?,?,?);");
$stmt->execute([$tipoDocumento, $idVendedor, $idComprador, $fecha, $numEscritura, $ubicacionFisica, $urlArchivo]);
$idDocumento = $conn->lastInsertId();

$myObj = new stdClass();
$myObj->mensaje = "Documento guardado";
$myObj->vendedor = "id: " . $idVendedor;
$myObj->comprador = "id: " . $idComprador;
$myObj->documento = "id: " . $idDocumento;
$myObj->estado = 'ok';
echo json_encode($myObj);

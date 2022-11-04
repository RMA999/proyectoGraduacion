<?php
header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');

$tipoDocumento = $_POST['tipoDocumento'];
$nombreDonante = $_POST['nombreDonante'];
$nombreDonatario = $_POST['nombreDonatario'];
$dpiDonante = $_POST['dpiDonante'];
$dpiDonatario = $_POST['dpiDonatario'];
$fecha = $_POST['fecha'];
$numEscritura = $_POST['numEscritura'];
$urlArchivo = $_POST['urlArchivo'];
$ubicacionFisica = $_POST['ubicacionFisica'];

// $conn = null;

$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiDonante, $nombreDonante]);
$idDonante = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiDonatario, $nombreDonatario]);
$idDonatario = $conn->lastInsertId();

$stmt = $conn->prepare("INSERT INTO documentos(id_tipo_documento, id_persona_donador, id_persona_donatario, fecha, numero_escritura, ubicacion_fisica, url_archivo) 
                              VALUES(?,?,?,?,?,?,?);");
$stmt->execute([$tipoDocumento, $idDonante, $idDonatario, $fecha, $numEscritura, $ubicacionFisica, $urlArchivo]);
$idDocumento = $conn->lastInsertId();

$myObj = new stdClass();
$myObj->mensaje = "Prueba";
$myObj->donante = "id: " . $idDonante;
$myObj->donatario = "id: " . $idDonatario;
$myObj->documento = "id: " . $idDocumento;
$myObj->estado = 'ok';
echo json_encode($myObj);

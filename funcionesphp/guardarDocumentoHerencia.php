<?php

header('Content-type: application/json');
http_response_code(200);

// Conexion a la base de datos
include('conexion.php');

$tipoDocumento = $_POST['tipoDocumento'];
$nombreCedente = $_POST['nombreCedente'];
$dpiCedente = $_POST['dpiCedente'];
$fecha = $_POST['fecha'];
$numEscritura = $_POST['numEscritura'];
$urlArchivo = $_POST['urlArchivo'];
$ubicacionFisica = $_POST['ubicacionFisica'];

$cesionarios = (array) $_POST['cesionarios'];

$cantidadCesionarios = count($cesionarios);
$idsCesionarios = [];

$respuesta = [
    "mensaje" => "Prueba",
    "idsCesionarios" => [],
    "idsDocumentos" => [],
    "estado" => "ok"
];

$stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
$stmt->execute([$dpiCedente, $nombreCedente]);
$idCedente = $conn->lastInsertId();

for ($x = 0; $x < $cantidadCesionarios; $x++) {
    $stmt = $conn->prepare("INSERT INTO personas(dpi,nombre) 
                              VALUES(?,?);");
    $stmt->execute([$cesionarios[$x]['dpi'], $cesionarios[$x]['nombre']]);
    array_push($respuesta['idsCesionarios'], $conn->lastInsertId());
}

for ($x = 0; $x < $cantidadCesionarios; $x++) {
    $stmt = $conn->prepare("INSERT INTO documentos(id_tipo_documento, id_persona_cedente, id_persona_cesionario, fecha, ubicacion_fisica, numero_escritura, url_archivo) 
    VALUES(?,?,?,?,?,?,?);");
    $stmt->execute([$tipoDocumento, $idCedente, $respuesta["idsCesionarios"][$x], $fecha, $ubicacionFisica, $numEscritura, $urlArchivo]);
    array_push($respuesta['idsDocumentos'], $conn->lastInsertId());
}


echo json_encode($respuesta);

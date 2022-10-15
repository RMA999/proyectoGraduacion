<?php

include 'conexion.php';

$idDocumento = $_GET['id_documento'];
$idTipoDocumento = $_GET['id_tipo_documento'];

$stmt = $conn->prepare("SELECT * FROM tipos_documentos WHERE id = ? LIMIT 1");
$stmt->execute([$idTipoDocumento]);
$resultTipoDocumento = $stmt->fetch();
$tipoDocumento = $resultTipoDocumento['nombre'];

if ($tipoDocumento == "Cesion de Derechos Hereditarios") {
    $stmt = $conn->prepare("SELECT * FROM vista_documentos WHERE id_documento = ? LIMIT 1");
    $stmt->execute([$idDocumento]);
    $documento = $stmt->fetch();
    
    $stmt = $conn->prepare("SELECT * FROM vista_cedentes WHERE numero_escritura = ? LIMIT 1");
    $stmt->execute([$documento['numero_escritura']]);
    $cedente = $stmt->fetch();
    
    $stmt = $conn->prepare("SELECT * FROM vista_cesionarios WHERE numero_escritura = ?");
    $stmt->execute([$documento['numero_escritura']]);
    $cesionarios = $stmt->fetchAll();       
}

if ($tipoDocumento == "Compraventa") {
    $stmt = $conn->prepare("SELECT * FROM vista_documentos WHERE id_documento = ? LIMIT 1");
    $stmt->execute([$idDocumento]);
    $documento = $stmt->fetch();
    
    $stmt = $conn->prepare("SELECT * FROM vista_compradores WHERE numero_escritura = ? LIMIT 1");
    $stmt->execute([$documento['numero_escritura']]);
    $comprador = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM vista_vendedores WHERE numero_escritura = ? LIMIT 1");
    $stmt->execute([$documento['numero_escritura']]);
    $vendedor = $stmt->fetch();
         
}

if ($tipoDocumento == "Declaración jurada") {
    $stmt = $conn->prepare("SELECT * FROM vista_documentos WHERE id_documento = ? LIMIT 1");
    $stmt->execute([$idDocumento]);
    $documento = $stmt->fetch();
    
    $stmt = $conn->prepare("SELECT * FROM vista_declaradores WHERE numero_escritura = ? LIMIT 1");
    $stmt->execute([$documento['numero_escritura']]);
    $declarador = $stmt->fetch();
         
}
<?php

include 'conexion.php';

$idDocumento = $_GET['id_documento'];
$tipoDocumento = $_GET['tipo_documento'];

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
    
    // $stmt = $conn->prepare("SELECT * FROM vista_cedentes WHERE numero_escritura = ? LIMIT 1");
    // $stmt->execute([$documento['numero_escritura']]);
    // $cedente = $stmt->fetch();
    
    // $stmt = $conn->prepare("SELECT * FROM vista_cesionarios WHERE numero_escritura = ?");
    // $stmt->execute([$documento['numero_escritura']]);
    // $cesionarios = $stmt->fetchAll();       
}
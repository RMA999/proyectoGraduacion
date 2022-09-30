<?php

include 'conexion.php';

$idDocumento = $_GET['id_documento'];

$stmt = $conn->prepare("SELECT * FROM documentos WHERE id = ? LIMIT 1");
$stmt->execute([$idDocumento]);
$documento = $stmt->fetch();

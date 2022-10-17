<?php

include 'conexion.php';

$idUsuario = $_GET['idUsuario'];

    $stmt = $conn->prepare("SELECT * FROM vista_usuarios WHERE id_usuario = ? LIMIT 1");
    $stmt->execute([$idUsuario]);
    $usuario = $stmt->fetch();


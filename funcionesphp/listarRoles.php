<?php

include 'conexion.php';

$stmt = $conn->query("SELECT * FROM roles WHERE id > 1");
$roles = $stmt->fetchAll();

<?php
include('conexion.php');

$stmt = $conn->query("SELECT * FROM tipos_documentos");
while ($row = $stmt->fetch()) {
    echo $row['nombre'] . "<br />";
}

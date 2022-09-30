<?php
$host     = 'localhost';
$db       = 'licenciado';
$user     = 'admin';
$password = 'Mariobross5625.';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $conn = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo $e->getMessage();
}

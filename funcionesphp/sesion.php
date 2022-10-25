<?php
header('Content-type: application/json');
include 'conexion.php';

$funcion = $_POST['funcion'];


if ($funcion == "login") {
    $username = $_POST['username'];
    $contrasenia = $_POST['contrasenia'];

    $myObj = new stdClass();
    $myObj->mensaje = "Sesion iniciada";
    $myObj->estado = 'ok';
    echo json_encode($myObj);
    return;
}



$myObj = new stdClass();
$myObj->mensaje = "Funcion no encontrada";
$myObj->estado = 'error';
echo json_encode($myObj);

<?php

$pass = $_POST['pass'];
$hash = $_POST['hash'];

if (password_verify($pass, $hash)) {
    echo 'valid';
} else {
    echo 'not valid';
}
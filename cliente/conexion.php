<?php

$server = "localhost";
$username = "root";
$pass = "";
$bd = "molimax_db";

$conexion = new mysqli(
    $server,
    $username,
    $pass,
    $bd
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

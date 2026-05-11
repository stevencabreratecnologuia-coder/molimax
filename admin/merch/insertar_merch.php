<?php
include("../conexion.php");

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen'];

$sql = "INSERT INTO merch (nombre, descripcion, precio, stock, imagen) 
        VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$imagen')";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_merch.php");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

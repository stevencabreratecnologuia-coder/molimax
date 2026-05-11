<?php
include("../conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_POST['imagen'];

$sql = "UPDATE merch 
        SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock', imagen='$imagen' 
        WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_merch.php");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

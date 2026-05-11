<?php
include("../conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];
$rol = $_POST['rol'];

$sql = "UPDATE usuarios 
        SET nombre='$nombre', correo='$correo', telefono='$telefono', password='$password', rol='$rol' 
        WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_usuarios.php");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

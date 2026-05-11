<?php
include("../conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];
$rol = $_POST['rol'];
$fecha_registro = date("Y-m-d H:i:s");

$sql = "INSERT INTO usuarios (nombre, correo, telefono, password, rol, fecha_registro) 
        VALUES ('$nombre', '$correo', '$telefono', '$password', '$rol', '$fecha_registro')";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_usuarios.php");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

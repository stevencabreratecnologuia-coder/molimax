<?php
include("../conexion.php");

$nombre_cine = $_POST['nombre_cine'];
$correo_contacto = $_POST['correo_contacto'];
$telefono_contacto = $_POST['telefono_contacto'];

$sql = "UPDATE configuracion 
        SET nombre_cine='$nombre_cine', correo_contacto='$correo_contacto', telefono_contacto='$telefono_contacto'
        WHERE id=1";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_configuracion.php?ok=1");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

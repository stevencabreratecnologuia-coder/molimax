<?php
include("../conexion.php");

$id_usuario = $_POST['id_usuario'];
$id_funcion = $_POST['id_funcion'];
$cantidad_asientos = $_POST['cantidad_asientos'];
$fecha_reserva = $_POST['fecha_reserva'];
$pelicula = $_POST['pelicula'];
$sala = $_POST['sala'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$asiento = $_POST['asiento'];

$sql = "INSERT INTO reservas (id_usuario, id_funcion, cantidad_asientos, fecha_reserva, pelicula, sala, fecha, hora, asiento) 
        VALUES ('$id_usuario', '$id_funcion', '$cantidad_asientos', '$fecha_reserva', '$pelicula', '$sala', '$fecha', '$hora', '$asiento')";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_reservas.php");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

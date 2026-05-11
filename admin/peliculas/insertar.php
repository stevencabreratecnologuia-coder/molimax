<?php
include("../conexion.php");

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];
$clasificacion = $_POST['clasificacion'];
$formato = $_POST['formato'];
$imagen = $_POST['imagen'];

$sql = "INSERT INTO peliculas (titulo, descripcion, duracion, clasificacion, formato, imagen) 
        VALUES ('$titulo', '$descripcion', '$duracion', '$clasificacion', '$formato', '$imagen')";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_peliculas.php");
    exit();
} else {
    echo "Error al guardar: " . $conexion->error;
}

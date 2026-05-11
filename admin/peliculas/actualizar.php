<?php
include("../conexion.php");


$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];
$clasificacion = $_POST['clasificacion'];
$formato = $_POST['formato'];
$imagen = $_POST['imagen'];

$sql = "UPDATE peliculas 
        SET titulo='$titulo', descripcion='$descripcion', duracion='$duracion', 
            clasificacion='$clasificacion', formato='$formato', imagen='$imagen' 
        WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: admin_peliculas.php");
    exit();
} else {
    echo "Error al actualizar: " . $conexion->error;
}

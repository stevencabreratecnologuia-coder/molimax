<?php

session_start();

include("conexion.php");

$pelicula = $_POST['pelicula'];
$sala = $_POST['sala'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$asiento = $_POST['asiento'];
$usuario = $_SESSION['usuario'];

// Verificar si la tabla tiene la columna usuario
$result = mysqli_query($conexion, "DESCRIBE reservas");
$tiene_usuario = false;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'usuario') {
        $tiene_usuario = true;
        break;
    }
}

// Insertar según la estructura de la tabla
if ($tiene_usuario) {
    $sql = "INSERT INTO reservas (pelicula, sala, fecha, hora, asiento, usuario) VALUES ('$pelicula', '$sala', '$fecha', '$hora', '$asiento', '$usuario')";
} else {
    $sql = "INSERT INTO reservas (pelicula, sala, fecha, hora, asiento) VALUES ('$pelicula', '$sala', '$fecha', '$hora', '$asiento')";
}

if (mysqli_query($conexion, $sql)) {
    echo "✅ Reserva guardada exitosamente.";
} else {
    echo "❌ Error al guardar reserva: " . mysqli_error($conexion);
}

header("Location: cliente_reservas.php");

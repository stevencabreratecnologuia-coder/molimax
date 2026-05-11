<?php
include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM reservas WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: admin_reservas.php");
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
} else {
    echo "ID no recibido.";
}

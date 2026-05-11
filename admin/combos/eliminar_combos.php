<?php
include("../conexion.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM comidas WHERE id=$id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: admin_combos.php");
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
} else {
    echo "ID no recibido.";
}

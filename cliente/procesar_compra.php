<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

include("conexion.php");
include("carrito_funciones.php");

$correo_usuario = $_SESSION["usuario"];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['procesar_compra'])) {

    if (empty($_SESSION['carrito'])) {
        header("Location: carrito.php?error=carrito_vacio");
        exit();
    }

    // Buscar el id_usuario
    $sql_user = "SELECT id FROM usuarios WHERE correo = '$correo_usuario'";
    $res_user = mysqli_query($conexion, $sql_user);
    $row_user = mysqli_fetch_assoc($res_user);
    $id_usuario = $row_user['id'];

    // Crear pedido principal
    $total = calcularTotal();
    $fecha = date('Y-m-d H:i:s');

    $sql_pedido = "INSERT INTO pedidos (id_usuario, fecha, total, estado) 
                   VALUES ($id_usuario, '$fecha', $total, 'pendiente')";

    if (mysqli_query($conexion, $sql_pedido)) {
        $id_pedido = mysqli_insert_id($conexion);

        // Recorrer carrito e insertar en tablas de detalle
        foreach ($_SESSION['carrito'] as $item) {
            $cantidad = $item['cantidad'];
            $precio = $item['precio'];
            $total_item = $cantidad * $precio;

            if ($item['tipo'] == 'pelicula') {
                $sql = "INSERT INTO detalle_pedido_pelicula 
                        (id_pedido, pelicula, cantidad, precio, total, fecha)
                        VALUES ($id_pedido, '{$item['nombre']}', $cantidad, $precio, $total_item, NOW())";
            } elseif ($item['tipo'] == 'comida') {
                $sql = "INSERT INTO detalle_pedido_comida 
                        (id_pedido, id_comida, cantidad, precio, total, fecha)
                        VALUES ($id_pedido, {$item['id']}, $cantidad, $precio, $total_item, NOW())";
            } elseif ($item['tipo'] == 'merch') {
                $sql = "INSERT INTO detalle_pedido_merch 
                        (id_pedido, id_merch, cantidad, precio, total, fecha)
                        VALUES ($id_pedido, {$item['id']}, $cantidad, $precio, $total_item, NOW())";
            }

            mysqli_query($conexion, $sql);
        }

        // Vaciar carrito
        $_SESSION['carrito'] = array();

        // Redirigir con éxito
        header("Location: pago_exitoso.php?pedido=$id_pedido");
        exit();
    } else {
        header("Location: carrito.php?error=error_procesamiento");
        exit();
    }
}

mysqli_close($conexion);

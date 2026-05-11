<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Función para agregar producto al carrito
function agregarAlCarrito($id, $tipo, $nombre, $precio, $imagen, $cantidad = 1) {
    $producto = array(
        'id' => $id,
        'tipo' => $tipo, // 'comida' o 'merch'
        'nombre' => $nombre,
        'precio' => $precio,
        'imagen' => $imagen,
        'cantidad' => $cantidad
    );

    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id && $item['tipo'] == $tipo) {
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        $_SESSION['carrito'][] = $producto;
    }
}

// Función para actualizar cantidad
function actualizarCantidad($id, $tipo, $cantidad) {
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id && $item['tipo'] == $tipo) {
            if ($cantidad <= 0) {
                // Eliminar producto si cantidad es 0 o menor
                unset($item);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array
            } else {
                $item['cantidad'] = $cantidad;
            }
            break;
        }
    }
}

// Función para eliminar producto del carrito
function eliminarDelCarrito($id, $tipo) {
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['id'] == $id && $item['tipo'] == $tipo) {
            unset($_SESSION['carrito'][$key]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array
            break;
        }
    }
}

// Función para calcular total
function calcularTotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return $total;
}

// Función para obtener cantidad total de productos
function contarProductos() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['cantidad'];
    }
    return $total;
}

// Manejar acciones POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agregar_carrito'])) {
        $id = intval($_POST['id']);
        $tipo = $_POST['tipo'];
        $nombre = $_POST['nombre'];
        $precio = floatval($_POST['precio']);
        $imagen = $_POST['imagen'];
        $cantidad = intval($_POST['cantidad'] ?? 1);

        if ($cantidad > 0) {
            agregarAlCarrito($id, $tipo, $nombre, $precio, $imagen, $cantidad);
        }

        // Redirigir de vuelta a la página anterior
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if (isset($_POST['actualizar_cantidad'])) {
        $id = intval($_POST['id']);
        $tipo = $_POST['tipo'];
        $cantidad = intval($_POST['cantidad']);
        actualizarCantidad($id, $tipo, $cantidad);
        header('Location: carrito.php');
        exit();
    }

    if (isset($_POST['eliminar_producto'])) {
        $id = intval($_POST['id']);
        $tipo = $_POST['tipo'];
        eliminarDelCarrito($id, $tipo);
        header('Location: carrito.php');
        exit();
    }

    if (isset($_POST['vaciar_carrito'])) {
        $_SESSION['carrito'] = array();
        header('Location: carrito.php');
        exit();
    }
}
?>
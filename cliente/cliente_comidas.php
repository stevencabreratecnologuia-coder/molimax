<?php

session_start();

// Verificar autenticación
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "cliente") {
    header("Location: Inicio_de_sesion.php");
    exit();
}

require "conexion.php";

$usuario_correo = $_SESSION["usuario"];
$mensaje = "";

// Obtener ID del usuario
$sql = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario_correo);
$stmt->execute();
$usuario_id = $stmt->get_result()->fetch_assoc()['id'];

// Crear pedido si se envía formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $producto_id = $_POST["producto_id"];
    $cantidad = $_POST["cantidad"];
    $tipo = $_POST["tipo"]; // comida o merch

    // Obtener precio
    $tabla = $tipo == "comida" ? "comidas" : "merch";
    $sql = "SELECT precio FROM $tabla WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $precio = $stmt->get_result()->fetch_assoc()['precio'];

    $total = $precio * $cantidad;

    // Crear pedido
    $sql = "INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("id", $usuario_id, $total);

    if ($stmt->execute()) {
        $pedido_id = $conexion->insert_id;

        // Guardar detalle
        if ($tipo == "comida") {
            $sql = "INSERT INTO detalle_pedido_comida (pedido_id, comida_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iiii", $pedido_id, $producto_id, $cantidad, $precio);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO detalle_pedido_merch (pedido_id, merch_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("iiii", $pedido_id, $producto_id, $cantidad, $precio);
            $stmt->execute();
        }

        $mensaje = "✅ Pedido creado exitosamente. Total: \$" . number_format($total, 2);
        header("Refresh: 2; url=cliente_pedidos.php");
    } else {
        $mensaje = "❌ Error al crear el pedido";
    }
}

// Obtener comidas y merchandise
$sql = "SELECT * FROM comidas WHERE stock > 0 ORDER BY nombre ASC";
$resultado = $conexion->query($sql);
$comidas = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

$sql = "SELECT * FROM merch WHERE stock > 0 ORDER BY nombre ASC";
$resultado = $conexion->query($sql);
$merchandise = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comidas y Merchandise - Molimax</title>

    <link rel="stylesheet" href="../css/estilo_C.css">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <h1>🎬 Molimax</h1>
        <div>
            <a href="cliente_menu.php">← Volver</a>
            <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">

        <h1>🍿 Comidas, Bebidas y Merchandise</h1>

        <?php if ($mensaje): ?>
            <div class="mensaje">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- TABS -->
        <div class="tabs">
            <button class="tab-button active" onclick="toggleTab('comidas')">🍿 Comidas y Bebidas</button>
            <button class="tab-button" onclick="toggleTab('merch')">🎟️ Merchandise</button>
        </div>

        <!-- TAB COMIDAS -->
        <div id="comidas" class="tab-content active">

            <?php if (count($comidas) > 0): ?>

                <div class="producto-grid">
                    <?php foreach ($comidas as $comida): ?>

                        <div class="producto-card">

                            <div class="producto-header">
                                <h3><?php echo htmlspecialchars($comida['nombre']); ?></h3>
                            </div>

                            <div class="producto-content">

                                <div class="producto-desc">
                                    <?php echo htmlspecialchars(substr($comida['descripcion'], 0, 60)); ?>...
                                </div>

                                <div class="producto-footer">
                                    <span class="producto-precio">$<?php echo number_format($comida['precio'], 2); ?></span>
                                    <span class="producto-stock">Stock: <?php echo $comida['stock']; ?></span>
                                </div>

                                <form method="POST" class="producto-form">
                                    <input type="hidden" name="producto_id" value="<?php echo $comida['id']; ?>">
                                    <input type="hidden" name="tipo" value="comida">
                                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $comida['stock']; ?>">
                                    <button type="submit" class="btn-comprar">Ordenar</button>
                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <div class="empty">
                    <p>⚠️ No hay comidas disponibles</p>
                </div>

            <?php endif; ?>

        </div>

        <!-- TAB MERCHANDISE -->
        <div id="merch" class="tab-content">

            <?php if (count($merchandise) > 0): ?>

                <div class="producto-grid">
                    <?php foreach ($merchandise as $prod): ?>

                        <div class="producto-card">

                            <div class="producto-header">
                                <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                            </div>

                            <div class="producto-content">

                                <div class="producto-desc">
                                    <?php echo htmlspecialchars(substr($prod['descripcion'], 0, 60)); ?>...
                                </div>

                                <div class="producto-footer">
                                    <span class="producto-precio">$<?php echo number_format($prod['precio'], 2); ?></span>
                                    <span class="producto-stock">Stock: <?php echo $prod['stock']; ?></span>
                                </div>

                                <form method="POST" class="producto-form">
                                    <input type="hidden" name="producto_id" value="<?php echo $prod['id']; ?>">
                                    <input type="hidden" name="tipo" value="merch">
                                    <input type="number" name="cantidad" value="1" min="1" max="<?php echo $prod['stock']; ?>">
                                    <button type="submit" class="btn-comprar">Comprar</button>
                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <div class="empty">
                    <p>⚠️ No hay merchandise disponible</p>
                </div>

            <?php endif; ?>

        </div>

    </div>

    <script>
        function toggleTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');

            tabs.forEach(tab => tab.classList.remove('active'));
            buttons.forEach(btn => btn.classList.remove('active'));

            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>

</body>

</html>
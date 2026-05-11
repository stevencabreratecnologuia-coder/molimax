<?php
session_start();
include("conexion.php");
include("carrito_funciones.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrito de Compras - Molimax</title>

    <link rel="stylesheet" href="../css/estilo_C.css">

</head>

<body>

    <!-- =========================
         TOPBAR
    ========================= -->

    <header class="topbar">

        <div class="logo">

            🎬 MOLIMAX

        </div>

        <nav>

            <a href="menu.php">← Volver al Menú</a>

            <a href="cliente_peliculas.php">Películas</a>

            <a href="#">Estrenos</a>

            <a href="cliente_reservas.php">Reservas</a>

            <a href="carrito.php" style="position: relative;">
                🛒 Carrito
                <?php if (contarProductos() > 0): ?>
                    <span style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                        <?php echo contarProductos(); ?>
                    </span>
                <?php endif; ?>
            </a>

        </nav>

    </header>

    <!-- =========================
         CONTENEDOR
    ========================= -->

    <div class="container">

        <!-- =========================
             SIDEBAR
        ========================= -->

        <aside class="sidebar">

            <h3>
                Menú
            </h3>

            <ul>

                <li>

                    <a href="cliente_peliculas.php">

                        🎥 Películas

                    </a>

                </li>

                <li>

                    <a href="cliente_comida.php">

                        🍿 Combos

                    </a>

                </li>

                <li>

                    <a href="cliente_merchandise.php">

                        🧸 Merch

                    </a>

                </li>

                <li>

                    <a href="cliente_reservas.php">

                        🎟️ Reservas

                    </a>

                </li>

                <li>

                    <a href="cliente_configuracion.php">

                        ⚙️ Configuración

                    </a>

                </li>

            </ul>

        </aside>

        <!-- =========================
             CONTENIDO
        ========================= -->

        <main class="content">

            <div class="titulo">

                <h2>

                    🛒 Carrito de Compras

                </h2>

            </div>

            <?php
            // Mostrar mensajes de éxito o error
            if (isset($_GET['success']) && $_GET['success'] == 'compra_completada'): ?>
                <div class="card" style="border-left: 4px solid green; margin-bottom: 20px;">
                    <div class="card-body">
                        <h3 style="color: green;">✅ ¡Compra completada exitosamente!</h3>
                        <p>Tu orden #<?php echo htmlspecialchars($_GET['orden']); ?> ha sido procesada.</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="card" style="border-left: 4px solid red; margin-bottom: 20px;">
                    <div class="card-body">
                        <h3 style="color: red;">❌ Error</h3>
                        <p>
                            <?php
                            if ($_GET['error'] == 'carrito_vacio') echo 'El carrito está vacío.';
                            elseif ($_GET['error'] == 'error_procesamiento') echo 'Error al procesar la compra. Inténtalo de nuevo.';
                            else echo 'Ha ocurrido un error desconocido.';
                            ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($_SESSION['carrito'])): ?>

                <div class="card">

                    <div class="card-body" style="text-align: center;">

                        <h3>Tu carrito está vacío</h3>

                        <p>¡Agrega algunos productos deliciosos o merchandise oficial!</p>

                        <br>

                        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">

                            <a href="cliente_comida.php" class="btn-accion btn-primary">Ver Comidas</a>

                            <a href="cliente_merchandise.php" class="btn-accion btn-primary">Ver Merchandise</a>

                        </div>

                    </div>

                </div>

            <?php else: ?>

                <!-- PRODUCTOS EN CARRITO -->

                <section class="peliculas">

                    <?php foreach ($_SESSION['carrito'] as $item): ?>

                        <div class="card">

                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>">

                            <div class="card-body">

                                <h3><?php echo htmlspecialchars($item['nombre']); ?></h3>

                                <div class="info">

                                    <span>💲 <?php echo number_format($item['precio'], 2); ?> c/u</span>

                                    <span>📦 Tipo: <?php echo ucfirst($item['tipo']); ?></span>

                                </div>

                                <br>

                                <!-- FORMULARIO PARA ACTUALIZAR CANTIDAD -->

                                <form method="POST" style="display: inline;">

                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

                                    <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">

                                    <label>Cantidad:</label>

                                    <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" style="width: 60px; margin: 0 10px; padding: 5px;">

                                    <button type="submit" name="actualizar_cantidad" class="btn-accion btn-secondary" style="padding: 5px 10px;">Actualizar</button>

                                </form>

                                <br><br>

                                <p><strong>Subtotal: 💲 <?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></strong></p>

                                <!-- BOTÓN ELIMINAR -->

                                <form method="POST" style="display: inline; margin-left: 10px;">

                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

                                    <input type="hidden" name="tipo" value="<?php echo $item['tipo']; ?>">

                                    <button type="submit" name="eliminar_producto" class="btn-accion btn-danger" style="padding: 8px 15px;">Eliminar</button>

                                </form>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </section>

                <!-- RESUMEN Y ACCIONES -->

                <div class="card" style="margin-top: 30px;">

                    <div class="card-body">

                        <h3>📋 Resumen de Compra</h3>

                        <br>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                            <div>

                                <p><strong>Total de productos:</strong> <?php echo contarProductos(); ?></p>

                                <p><strong>Total a pagar:</strong> 💲 <?php echo number_format(calcularTotal(), 2); ?></p>

                            </div>

                            <div style="display: flex; flex-direction: column; gap: 10px;">

                                <form method="POST" style="display: inline;">

                                    <button type="submit" name="vaciar_carrito" class="btn-accion btn-danger">Vaciar Carrito</button>

                                </form>

                                <form method="POST" action="procesar_compra.php" style="display: inline;">

                                    <button type="submit" name="procesar_compra" class="btn-accion btn-primary" style="padding: 12px 20px;">💳 Proceder al Pago</button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </main>

    </div>

</body>

</html>
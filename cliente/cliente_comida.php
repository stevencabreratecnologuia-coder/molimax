<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");
include("carrito_funciones.php");

$sql = "SELECT * FROM comidas";

$resultado = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Comidas - Molimax</title>

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


            <a href="cliente_reservas.php">Reservas</a>

            <a href="carrito.php" style="position: relative;">
                🛒 Carrito
                <span style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                    <?php echo contarProductos() > 0 ? contarProductos() : ''; ?>
                </span>
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
                    🍿 Comidas y Combos
                </h2>

            </div>

            <section class="peliculas">

                <?php

                while ($fila = mysqli_fetch_assoc($resultado)) {

                ?>

                    <div class="card">

                        <img
                            src="<?php echo $fila['imagen']; ?>"
                            alt="Comida">

                        <div class="card-body">

                            <h3>

                                <?php echo $fila['nombre']; ?>

                            </h3>

                            <p>

                                <?php echo $fila['descripcion']; ?>

                            </p>

                            <div class="info">

                                <span>

                                    💲 <?php echo $fila['precio']; ?>

                                </span>

                            </div>

                            <br>

                            <form method="POST" action="carrito_funciones.php" style="display: inline;">

                                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                                <input type="hidden" name="tipo" value="comida">

                                <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>">

                                <input type="hidden" name="precio" value="<?php echo $fila['precio']; ?>">

                                <input type="hidden" name="imagen" value="<?php echo $fila['imagen']; ?>">

                                <label style="margin-right: 10px;">Cantidad:</label>

                                <input type="number" name="cantidad" value="1" min="1" max="10" style="width: 60px; margin-right: 10px; padding: 5px;">

                                <button type="submit" name="agregar_carrito" class="btn-comprar">

                                    🛒 Agregar al Carrito

                                </button>

                            </form>

                        </div>

                    </div>

                <?php

                }

                ?>

            </section>

        </main>

    </div>

</body>

</html>
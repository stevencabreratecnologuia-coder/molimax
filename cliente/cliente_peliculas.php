<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");
include("carrito_funciones.php");

$sql = "SELECT * FROM peliculas";

$resultado = mysqli_query($conexion, $sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Películas - Molimax</title>

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

                    🎬 Cartelera

                </h2>

            </div>

            <section class="peliculas">

                <?php

                while ($fila = mysqli_fetch_assoc($resultado)) {

                ?>

                    <div class="card">

                        <img
                            src="<?php echo $fila['imagen']; ?>"
                            alt="Película">

                        <div class="card-body">

                            <h3>

                                <?php echo $fila['titulo']; ?>

                            </h3>

                            <p>

                                <?php echo $fila['descripcion']; ?>

                            </p>

                            <div class="info">

                                <span>

                                    ⭐ <?php echo $fila['clasificacion']; ?>

                                </span>

                                <span>

                                    ⏰ <?php echo $fila['duracion']; ?> min

                                </span>

                            </div>
                            <a href="cliente_reservas.php?id=<?php echo $fila['id']; ?>">

                                <button class="btn-comprar">

                                    Comprar Entrada

                                </button>

                            </a>

                            </button>

                            </a>

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
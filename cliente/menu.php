<?php
include("carrito_funciones.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Molimax</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

            <a href="#">Inicio</a>

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

            <!-- =========================
                 HERO
            ========================= -->

            <section class="hero">

                <div class="hero-info">

                    <h1>

                        Bienvenido a Molimax

                    </h1>

                    <p>

                        Disfruta las mejores películas,
                        reserva tus entradas y vive
                        una experiencia increíble.

                    </p>

                    <button>

                        <a href="cliente_peliculas.php">

                            🎬 Ver Cartelera

                        </a>

                    </button>

                </div>

            </section>

            <!-- =========================
                 TITULO
            ========================= -->

            <div class="titulo">

                <h2>

                    🔥 Películas Populares

                </h2>

            </div>

            <!-- =========================
                 PELICULAS
            ========================= -->

            <section class="peliculas">

                <!-- CARD 1 -->

                <div class="card">

                    <img
                        src="https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?q=80&w=1200&auto=format&fit=crop"
                        alt="Sala de cine">

                    <div class="card-body">

                        <h3>

                            Batman

                        </h3>

                        <p>

                            Acción y misterio en Gotham City.

                        </p>

                        <div class="info">

                            <span>

                                ⭐ 9.0

                            </span>

                            <span>

                                ⏰ 2h 30m

                            </span>

                        </div>

                        <a
                            href="cliente_reservas.php"
                            class="btn-comprar">

                            Comprar

                        </a>

                    </div>

                </div>

                <!-- CARD 2 -->

                <div class="card">

                    <img
                        src="https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=1200&auto=format&fit=crop"
                        alt="Película">

                    <div class="card-body">

                        <h3>

                            Avatar

                        </h3>

                        <p>

                            Una aventura épica en Pandora.

                        </p>

                        <div class="info">

                            <span>

                                ⭐ 8.8

                            </span>

                            <span>

                                ⏰ 2h 45m

                            </span>

                        </div>

                        <a
                            href="cliente_reservas.php"
                            class="btn-comprar">

                            Comprar

                        </a>

                    </div>

                </div>

                <!-- CARD 3 -->

                <div class="card">

                    <img
                        src="https://images.unsplash.com/photo-1440404653325-ab127d49abc1?q=80&w=1200&auto=format&fit=crop"
                        alt="Película">

                    <div class="card-body">

                        <h3>

                            Avengers

                        </h3>

                        <p>

                            Los héroes salvan el universo.

                        </p>

                        <div class="info">

                            <span>

                                ⭐ 9.3

                            </span>

                            <span>

                                ⏰ 3h 00m

                            </span>

                        </div>

                        <a
                            href="cliente_reservas.php"
                            class="btn-comprar">

                            Comprar

                        </a>

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>
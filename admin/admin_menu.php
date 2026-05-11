<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

include("conexion.php");


// Estadísticas reales desde la BD
$total_peliculas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM peliculas"));
$total_reservas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM reservas"));
$total_usuarios = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios"));
$total_ingresos = 5200; // Aquí podrías sumar ventas reales
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Molimax - Admin</title>
    <link rel="stylesheet" href="estilo_admin_menu.css">
</head>

<body>

    <!-- =========================
         TOPBAR ADMIN
    ========================= -->
    <header class="topbar">
        <div class="logo">⚙️ MOLIMAX ADMIN</div>

    </header>

    <div class="container">

        <!-- =========================
             SIDEBAR ADMIN
        ========================= -->
        <aside class="sidebar">
            <h3>Panel de Control</h3>
            <ul>
                <li><a href="peliculas/admin_peliculas.php">🎬 Gestionar Películas</a></li>
                <li><a href="combos/admin_combos.php">🍿 Gestionar Combos</a></li>
                <li><a href="merch/admin_merch.php">🧸 Gestionar Merch</a></li>
                <li><a href="reservas/admin_reservas.php">🎟️ Ver Reservas</a></li>
                <li><a href="usuarios/admin_usuarios.php">👥 Usuarios</a></li>
                <li><a href="admin_reportes/reportes.php">📊 Reportes</a></li>
                <li><a href="../cliente/Inicio_de_sesion.php">🚪 Cerrar Sesión</a></li>
            </ul>
        </aside>

        <!-- =========================
             CONTENIDO ADMIN
        ========================= -->
        <main class="content">
            <section class="hero">
                <div class="hero-info">
                    <h1>Bienvenido Administrador</h1>
                    <p>Gestiona películas, reservas, usuarios y mantén el control del cine.</p>
                </div>
            </section>

            <!-- =========================
                 ESTADÍSTICAS
            ========================= -->
            <div class="titulo">
                <h2>📊 Estadísticas Rápidas</h2>
            </div>

            <section class="stats">
                <div class="card">
                    <h3>Películas Activas</h3>
                    <p><?php echo $total_peliculas; ?></p>
                </div>
                <div class="card">
                    <h3>Reservas Hoy</h3>
                    <p><?php echo $total_reservas; ?></p>
                </div>
                <div class="card">
                    <h3>Usuarios Registrados</h3>
                    <p><?php echo $total_usuarios; ?></p>
                </div>
                <div class="card">
                    <h3>Ingresos Mensuales</h3>
                    <p>$<?php echo $total_ingresos; ?></p>
                </div>
            </section>

            <!-- =========================
                 ACCIONES RÁPIDAS
            ========================= -->
</body>

</html>
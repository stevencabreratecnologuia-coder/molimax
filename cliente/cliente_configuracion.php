<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$usuario_email = $_SESSION["usuario"];

include("conexion.php");
include("carrito_funciones.php");

// Obtener datos del usuario
$sql_usuario = "SELECT * FROM usuarios WHERE correo = '$usuario_email'";
$resultado_usuario = mysqli_query($conexion, $sql_usuario);

if (!$resultado_usuario) {
    die("❌ Error en la consulta de usuario: " . mysqli_error($conexion));
}

$datos_usuario = mysqli_fetch_assoc($resultado_usuario);

if (!$datos_usuario) {
    die("❌ Usuario no encontrado en la base de datos.");
}

// Contar reservas del usuario
// Verificar primero si la columna usuario existe
$result = mysqli_query($conexion, "DESCRIBE reservas");
$tiene_usuario = false;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Field'] == 'usuario') {
        $tiene_usuario = true;
        break;
    }
}

if ($tiene_usuario) {
    $sql_reservas = "SELECT COUNT(*) as total_reservas FROM reservas WHERE usuario = '$usuario_email'";
} else {
    $sql_reservas = "SELECT COUNT(*) as total_reservas FROM reservas";
}

$resultado_reservas = mysqli_query($conexion, $sql_reservas);

if (!$resultado_reservas) {
    $total_reservas = 0;
} else {
    $datos_reservas = mysqli_fetch_assoc($resultado_reservas);
    $total_reservas = $datos_reservas['total_reservas'] ?? 0;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Configuración - Molimax</title>

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

                    ⚙️ Configuración de Cuenta

                </h2>

            </div>

            <!-- INFORMACIÓN DEL PERFIL -->

            <div class="card">

                <div class="card-body">

                    <h3>

                        👤 Información del Perfil

                    </h3>

                    <br>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                        <div>

                            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($datos_usuario['nombre']); ?></p>

                            <p><strong>Correo:</strong> <?php echo htmlspecialchars($datos_usuario['correo']); ?></p>

                            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($datos_usuario['telefono']); ?></p>

                        </div>

                        <div>

                            <p><strong>Rol:</strong> <?php echo htmlspecialchars($datos_usuario['rol']); ?></p>

                            <p><strong>Reservas realizadas:</strong> <?php echo $total_reservas; ?></p>

                            <p><strong>Estado:</strong> <span style="color: green;">Activo</span></p>

                        </div>

                    </div>

                </div>

            </div>

            <br>

            <!-- ESTADÍSTICAS -->

            <div class="card">

                <div class="card-body">

                    <h3>

                        📊 Estadísticas

                    </h3>

                    <br>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">

                        <div style="text-align: center; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 10px;">

                            <h4><?php echo $total_reservas; ?></h4>

                            <p>Total de Reservas</p>

                        </div>

                        <div style="text-align: center; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 10px;">

                            <h4>Cliente</h4>

                            <p>Tipo de Cuenta</p>

                        </div>

                        <div style="text-align: center; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 10px;">

                            <h4>Activa</h4>

                            <p>Estado de Cuenta</p>

                        </div>

                    </div>

                </div>

            </div>

            <br>

            <!-- ACCIONES DE CUENTA -->

            <div class="card">

                <div class="card-body">

                    <h3>

                        🚪 Acciones de Cuenta

                    </h3>

                    <br>

                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">

                        <a href="cliente_reservas.php" class="btn-accion btn-primary">Ver Mis Reservas</a>

                        <a href="cerrar_sesion.php" class="btn-accion btn-danger">Cerrar Sesión</a>

                    </div>

                </div>

            </div>

        </main>

    </div>





</body>

</html>
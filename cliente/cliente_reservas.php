<?php
session_start();
include("conexion.php");
include("carrito_funciones.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$mostrar_formulario = false;
$pelicula = null;
$resultado_reservas = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $mostrar_formulario = true;
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM peliculas WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    if (!$resultado) {
        die("❌ Error en la consulta: " . mysqli_error($conexion));
    }

    $pelicula = mysqli_fetch_assoc($resultado);
    if (!$pelicula) {
        die("❌ Película no encontrada");
    }

    $sql_salas = "SELECT * FROM salas";
    $res_salas = $conexion->query($sql_salas);

    $sql_horarios = "SELECT * FROM horarios";
    $res_horarios = $conexion->query($sql_horarios);

    $sql_asientos = "SELECT * FROM asientos WHERE id_sala=1";
    $res_asientos = $conexion->query($sql_asientos);
} else {
    $result = mysqli_query($conexion, "DESCRIBE reservas");
    $tiene_usuario = false;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Field'] == 'usuario') {
            $tiene_usuario = true;
            break;
        }
    }

    if ($tiene_usuario) {
        $sql_reservas = "SELECT * FROM reservas WHERE usuario = '$usuario' ORDER BY fecha DESC, hora DESC";
    } else {
        $sql_reservas = "SELECT * FROM reservas ORDER BY fecha DESC, hora DESC";
    }

    $resultado_reservas = mysqli_query($conexion, $sql_reservas);
    if (!$resultado_reservas) {
        die("❌ Error al obtener reservas: " . mysqli_error($conexion));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservar</title>
    <link rel="stylesheet" href="agregar_reserva.css">
</head>

<body>
    <header class="topbar">
        <div class="logo">🎬 MOLIMAX</div>
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

    <div class="container">
        <aside class="sidebar">
            <h3>Menú</h3>
            <ul>
                <li><a href="cliente_peliculas.php">🎥 Películas</a></li>
                <li><a href="cliente_comida.php">🍿 Combos</a></li>
                <li><a href="cliente_merchandise.php">🧸 Merch</a></li>
                <li><a href="cliente_reservas.php">🎟️ Reservas</a></li>
                <li><a href="cliente_configuracion.php">⚙️ Configuración</a></li>
            </ul>
        </aside>

        <main class="content">
            <?php if ($mostrar_formulario && $pelicula): ?>
                <div class="titulo">
                    <h2>🎟️ Reservar Entrada</h2>
                </div>
                <div class="card">
                    <img src="<?php echo $pelicula['imagen'] ?? '../img/default.jpg'; ?>" alt="Pelicula">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($pelicula['titulo']); ?></h3>
                        <form action="guardar_reserva.php" method="POST">
                            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                            <input type="hidden" name="pelicula" value="<?php echo htmlspecialchars($pelicula['titulo']); ?>">

                            <!-- Sala -->
                            <label>Sala:</label>
                            <select name="id_sala" required>
                                <?php while ($sala = $res_salas->fetch_assoc()) { ?>
                                    <option value="<?php echo $sala['id']; ?>">
                                        <?php echo $sala['nombre']; ?> (Capacidad: <?php echo $sala['capacidad']; ?>)
                                    </option>
                                <?php } ?>
                            </select>

                            <!-- Horario -->
                            <label>Horario:</label>
                            <select name="id_horario" id="horarioSelect" required>
                                <?php while ($h = $res_horarios->fetch_assoc()) { ?>
                                    <option value="<?php echo $h['id']; ?>"
                                        data-fecha="<?php echo $h['fecha']; ?>"
                                        data-hora="<?php echo $h['hora']; ?>">
                                        <?php echo $h['fecha'] . ' ' . $h['hora']; ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <!-- Campos ocultos para fecha/hora -->
                            <input type="hidden" name="fecha" id="fechaInput" required>
                            <input type="hidden" name="hora" id="horaInput" required>

                            <!-- Asientos -->
                            <label>Asiento:</label>
                            <div class="cinema">
                                <?php while ($a = $res_asientos->fetch_assoc()) {
                                    $class = ($a['disponible'] == 1) ? "seat" : "seat occupied"; ?>
                                    <div class="<?php echo $class; ?>" data-seat="<?php echo $a['asiento']; ?>">
                                        <?php echo $a['asiento']; ?>
                                    </div>
                                <?php } ?>
                            </div>

                            <input type="hidden" name="asiento" id="asientoInput" required>
                            <button type="submit" class="btn-comprar">Confirmar Reserva</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="titulo">
                    <h2>🎟️ Mis Reservas</h2>
                </div>
                <?php if ($resultado_reservas && mysqli_num_rows($resultado_reservas) > 0): ?>
                    <section class="peliculas">
                        <?php while ($reserva = mysqli_fetch_assoc($resultado_reservas)): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h3><?php echo htmlspecialchars($reserva['pelicula']); ?></h3>
                                    <div class="info">
                                        <span>🏛️ <?php echo htmlspecialchars($reserva['sala']); ?></span>
                                        <span>📅 <?php echo htmlspecialchars($reserva['fecha']); ?></span>
                                        <span>⏰ <?php echo htmlspecialchars($reserva['hora']); ?></span>
                                        <span>💺 <?php echo htmlspecialchars($reserva['asiento']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </section>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body">
                            <h3>No tienes reservas aún</h3>
                            <p>¡Ve a la cartelera y reserva tus entradas favoritas!</p>
                            <a href="cliente_peliculas.php"><button class="btn-comprar">Ver Cartelera</button></a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </main>
    </div>

    <script>
        // Selección de asiento
        const seats = document.querySelectorAll('.seat:not(.occupied)');
        const asientoInput = document.getElementById('asientoInput');
        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                seats.forEach(s => s.classList.remove('selected'));
                seat.classList.add('selected');
                asientoInput.value = seat.dataset.seat;
            });
        });

        // Guardar fecha/hora del horario
        const horarioSelect = document.getElementById('horarioSelect');
        const fechaInput = document.getElementById('fechaInput');
        const horaInput = document.getElementById('horaInput');
        horarioSelect.addEventListener('change', () => {
            const option = horarioSelect.options[horarioSelect.selectedIndex];
            fechaInput.value = option.dataset.fecha;
            horaInput.value = option.dataset.hora;
        });
        // Inicializar al cargar
        horarioSelect.dispatchEvent(new Event('change'));
    </script>
</body>

</html>
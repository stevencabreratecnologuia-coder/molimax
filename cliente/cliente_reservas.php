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

    $resultado = mysqli_query($conexion, "SELECT * FROM peliculas WHERE id = $id");
    if (!$resultado) die("Error en la consulta: " . mysqli_error($conexion));
    $pelicula = mysqli_fetch_assoc($resultado);
    if (!$pelicula) die("Pelicula no encontrada");

    $res_salas    = $conexion->query("SELECT * FROM salas");
    $res_horarios = $conexion->query("SELECT * FROM horarios");
    $res_asientos = $conexion->query("SELECT * FROM asientos WHERE id_sala=1");
} else {
    $result = mysqli_query($conexion, "DESCRIBE reservas");
    $tiene_usuario = false;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Field'] == 'usuario') {
            $tiene_usuario = true;
            break;
        }
    }

    $cols_check = mysqli_query($conexion, "DESCRIBE peliculas");
    $cols_exist = [];
    while ($c = mysqli_fetch_assoc($cols_check)) $cols_exist[] = $c['Field'];

    $select_extra = [];
    foreach (['imagen', 'genero', 'duracion', 'descripcion', 'rating'] as $col) {
        if (in_array($col, $cols_exist)) $select_extra[] = "p.$col";
    }

    if ($select_extra) {
        $extra_sql = ", " . implode(", ", $select_extra);
        $join_sql  = " LEFT JOIN peliculas p ON r.pelicula = p.titulo";
    } else {
        $extra_sql = "";
        $join_sql  = "";
    }

    $where = $tiene_usuario ? " WHERE r.usuario = '$usuario'" : "";
    $sql_reservas = "SELECT r.*{$extra_sql} FROM reservas r{$join_sql}{$where} ORDER BY r.fecha DESC, r.hora DESC";
    $resultado_reservas = mysqli_query($conexion, $sql_reservas);
    if (!$resultado_reservas) die("Error al obtener reservas: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_reservas.css">
    <title>MOLIMAX — Reservas</title>

</head>

<body>

    <header class="topbar">
        <div class="logo">🎬 MOLIMAX</div>
        <nav>
            <a href="menu.php">← Volver al Menú</a>
            <a href="cliente_peliculas.php">Películas</a>
            <a href="#">Estrenos</a>
            <a href="cliente_reservas.php" class="active">Reservas</a>
            <a href="carrito.php" class="cart-btn">
                🛒 Carrito
                <?php $cnt = contarProductos();
                if ($cnt > 0) { ?>
                    <span class="cart-badge"><?php echo $cnt; ?></span>
                <?php } ?>
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
                <li><a href="cliente_reservas.php" class="active">🎟️ Reservas</a></li>
                <li><a href="cliente_configuracion.php">⚙️ Configuración</a></li>
            </ul>
        </aside>

        <main class="content">

            <?php if ($mostrar_formulario && $pelicula) { ?>

                <div class="titulo">
                    <h2>🎟️ Reservar Entrada</h2>
                </div>

                <div class="booking-grid">
                    <div class="movie-poster-wrap">
                        <img src="<?php echo htmlspecialchars($pelicula['imagen'] ?? '../img/default.jpg'); ?>"
                            alt="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                    </div>

                    <div class="form-card">
                        <div class="form-movie-title"><?php echo htmlspecialchars($pelicula['titulo']); ?></div>

                        <form action="guardar_reserva.php" method="POST">
                            <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                            <input type="hidden" name="pelicula" value="<?php echo htmlspecialchars($pelicula['titulo']); ?>">
                            <input type="hidden" name="fecha" id="fechaInput">
                            <input type="hidden" name="hora" id="horaInput">
                            <input type="hidden" name="asiento" id="asientoInput">

                            <div style="display:flex;flex-direction:column;gap:16px;">

                                <div class="form-group">
                                    <label>🏛️ Sala</label>
                                    <select name="id_sala" required>
                                        <?php while ($sala = $res_salas->fetch_assoc()) { ?>
                                            <option value="<?php echo $sala['id']; ?>">
                                                <?php echo htmlspecialchars($sala['nombre']); ?> — Capacidad: <?php echo $sala['capacidad']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>📅 Fecha y Horario</label>
                                    <select name="id_horario" id="horarioSelect" required>
                                        <?php while ($h = $res_horarios->fetch_assoc()) { ?>
                                            <option value="<?php echo $h['id']; ?>"
                                                data-fecha="<?php echo $h['fecha']; ?>"
                                                data-hora="<?php echo $h['hora']; ?>">
                                                <?php echo $h['fecha'] . ' — ' . $h['hora']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div>
                                    <div class="cinema-label">💺 Elige tu Asiento</div>
                                    <div class="screen-bar"></div>
                                    <div class="cinema">
                                        <?php while ($a = $res_asientos->fetch_assoc()) {
                                            $cls = ($a['disponible'] == 1) ? 'seat' : 'seat occupied'; ?>
                                            <div class="<?php echo $cls; ?>" data-seat="<?php echo $a['asiento']; ?>">
                                                <?php echo $a['asiento']; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="leyenda">
                                        <span><i style="background:rgba(122,47,255,0.15);border:1px solid rgba(157,78,221,0.4);"></i>Libre</span>
                                        <span><i style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);"></i>Ocupado</span>
                                        <span><i style="background:linear-gradient(135deg,#5a189a,#9d4edd);"></i>Seleccionado</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn-reservar">🎟️ Confirmar Reserva</button>

                            </div>
                        </form>
                    </div>
                </div>

            <?php } else { ?>

                <div class="titulo">
                    <h2>🎟️ Mis Reservas
                        <?php if ($resultado_reservas) { ?>
                            <span class="count-pill"><?php echo mysqli_num_rows($resultado_reservas); ?></span>
                        <?php } ?>
                    </h2>
                </div>

                <?php if ($resultado_reservas && mysqli_num_rows($resultado_reservas) > 0) { ?>

                    <div class="reservas-list">
                        <?php while ($reserva = mysqli_fetch_assoc($resultado_reservas)) {
                            $img         = isset($reserva['imagen'])      ? $reserva['imagen']      : null;
                            $genero      = isset($reserva['genero'])      ? $reserva['genero']      : null;
                            $duracion    = isset($reserva['duracion'])    ? $reserva['duracion']    : null;
                            $descripcion = isset($reserva['descripcion']) ? $reserva['descripcion'] : null;
                            $rating      = isset($reserva['rating'])      ? $reserva['rating']      : null;
                            $generos     = $genero ? explode(',', $genero) : [];
                        ?>
                            <div class="res-card">
                                <div class="res-poster">
                                    <?php if ($img) { ?>
                                        <img src="<?php echo htmlspecialchars($img); ?>"
                                            alt="<?php echo htmlspecialchars($reserva['pelicula']); ?>"
                                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                        <div class="poster-fallback" style="display:none;">🎬</div>
                                    <?php } else { ?>
                                        <div class="poster-fallback">🎬</div>
                                    <?php } ?>
                                    <?php if ($rating) { ?>
                                        <div class="rating-pill">⭐ <?php echo htmlspecialchars($rating); ?></div>
                                    <?php } ?>
                                </div>

                                <div class="res-body">
                                    <div class="res-top">
                                        <h3 class="res-title"><?php echo htmlspecialchars($reserva['pelicula']); ?></h3>
                                        <span class="status-badge">✓ Confirmada</span>
                                    </div>

                                    <?php if ($generos || $duracion) { ?>
                                        <div class="tags">
                                            <?php foreach ($generos as $g) { ?>
                                                <span class="tag"><?php echo htmlspecialchars(trim($g)); ?></span>
                                            <?php } ?>
                                            <?php if ($duracion) { ?>
                                                <span class="tag gold">⏱ <?php echo htmlspecialchars($duracion); ?></span>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($descripcion) { ?>
                                        <p class="res-desc"><?php echo htmlspecialchars($descripcion); ?></p>
                                    <?php } ?>

                                    <div class="res-meta">
                                        <?php if (!empty($reserva['sala'])) { ?>
                                            <div class="meta-item">🏛️ <span><?php echo htmlspecialchars($reserva['sala']); ?></span></div>
                                        <?php } ?>
                                        <div class="meta-item">📅 <span><?php echo htmlspecialchars($reserva['fecha']); ?></span></div>
                                        <div class="meta-item">🕐 <span><?php echo htmlspecialchars($reserva['hora']); ?></span></div>
                                        <div class="seat-chip">💺 Asiento <strong style="margin-left:3px;"><?php echo htmlspecialchars($reserva['asiento']); ?></strong></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                <?php } else { ?>

                    <div class="empty-state">
                        <div class="empty-icon">🎬</div>
                        <h3>Sin Reservas Aún</h3>
                        <p>¡Explora la cartelera y reserva tus entradas favoritas!</p>
                        <a href="cliente_peliculas.php" class="btn-outline">Ver Cartelera</a>
                    </div>

                <?php } ?>

            <?php } ?>

        </main>
    </div>

    <script>
        document.querySelectorAll('.seat:not(.occupied)').forEach(function(seat) {
            seat.addEventListener('click', function() {
                document.querySelectorAll('.seat').forEach(function(s) {
                    s.classList.remove('selected');
                });
                seat.classList.add('selected');
                document.getElementById('asientoInput').value = seat.getAttribute('data-seat');
            });
        });

        var horarioSelect = document.getElementById('horarioSelect');
        if (horarioSelect) {
            function syncHorario() {
                var opt = horarioSelect.options[horarioSelect.selectedIndex];
                document.getElementById('fechaInput').value = opt.getAttribute('data-fecha');
                document.getElementById('horaInput').value = opt.getAttribute('data-hora');
            }
            horarioSelect.addEventListener('change', syncHorario);
            syncHorario();
        }
    </script>

</body>

</html>
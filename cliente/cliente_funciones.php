<?php

session_start();

// Verificar autenticación
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "cliente") {
    header("Location: Inicio_de_sesion.php");
    exit();
}

require "conexion.php";

// Obtener cines
$sql = "SELECT * FROM cines ORDER BY nombre ASC";
$resultado = $conexion->query($sql);
$cines = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

// Obtener películas
$sql = "SELECT * FROM películas ORDER BY titulo ASC";
$resultado = $conexion->query($sql);
$peliculas = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

// Obtener funciones
$sql = "SELECT f.*, p.titulo, c.nombre as cine_nombre FROM funciones f 
        JOIN películas p ON f.pelicula_id = p.id 
        JOIN cines c ON f.cine_id = c.id 
        ORDER BY f.fecha, f.hora";
$resultado = $conexion->query($sql);
$funciones = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cines y Funciones - Molimax</title>
    <link rel="stylesheet" href="..css/estilo.C.css">
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

        <h1>🎪 Cines y Funciones</h1>

        <!-- TABS -->
        <div class="tabs">
            <button class="tab-button active" onclick="toggleTab('cines')">🎪 Nuestros Cines</button>
            <button class="tab-button" onclick="toggleTab('funciones')">🎬 Todas las Funciones</button>
        </div>

        <!-- TAB CINES -->
        <div id="cines" class="tab-content active">

            <?php if (count($cines) > 0): ?>

                <div class="cines-grid">
                    <?php foreach ($cines as $cine): ?>

                        <div class="cine-card">
                            <h3>🎪 <?php echo htmlspecialchars($cine['nombre']); ?></h3>
                            <div class="cine-info">
                                <strong>📍 Ubicación:</strong> <?php echo htmlspecialchars($cine['ubicacion']); ?>
                            </div>
                            <div class="cine-info">
                                <strong>📞 Teléfono:</strong> <?php echo htmlspecialchars($cine['telefono']); ?>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <div class="empty">
                    <p>⚠️ No hay cines disponibles.</p>
                </div>

            <?php endif; ?>

        </div>

        <!-- TAB FUNCIONES -->
        <div id="funciones" class="tab-content">

            <?php if (count($funciones) > 0): ?>

                <div class="funciones-list">
                    <?php foreach ($funciones as $funcion): ?>

                        <div class="funcion-item">

                            <div class="funcion-info">
                                <h4>🎬 <?php echo htmlspecialchars($funcion['titulo']); ?></h4>
                                <div class="funcion-details">
                                    <strong>Cine:</strong> <?php echo htmlspecialchars($funcion['cine_nombre']); ?><br>
                                    <strong>Fecha:</strong> <?php echo $funcion['fecha']; ?><br>
                                    <strong>Hora:</strong> <?php echo $funcion['hora']; ?>
                                </div>
                            </div>

                            <a href="cliente_reservar.php?funcion=<?php echo $funcion['id']; ?>" class="funcion-button">
                                🎫 Reservar Ahora
                            </a>

                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <div class="empty">
                    <p>⚠️ No hay funciones disponibles en este momento.</p>
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
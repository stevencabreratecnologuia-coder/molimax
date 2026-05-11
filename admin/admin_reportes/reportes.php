<?php
include("../conexion.php");

// Películas
$sql_peliculas = "SELECT SUM(cantidad) AS total_cantidad, SUM(total) AS total_ventas 
                  FROM detalle_pedido_pelicula";
$res_peliculas = $conexion->query($sql_peliculas)->fetch_assoc();

// Reservas
$sql_reservas = "SELECT COUNT(*) AS total_reservas FROM reservas";
$res_reservas = $conexion->query($sql_reservas)->fetch_assoc();

// Merch
$sql_merch = "SELECT SUM(cantidad) AS total_cantidad, SUM(total) AS total_ventas 
              FROM detalle_pedido_merch";
$res_merch = $conexion->query($sql_merch)->fetch_assoc();

// Comidas
$sql_comidas = "SELECT SUM(cantidad) AS total_cantidad, SUM(total) AS total_ventas 
                FROM detalle_pedido_comida";
$res_comidas = $conexion->query($sql_comidas)->fetch_assoc();

// Total general
$total_general = $res_peliculas['total_ventas'] + $res_merch['total_ventas'] + $res_comidas['total_ventas'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Ventas</title>
    <link rel="stylesheet" href="reportes.css">
</head>

<body>
    <h2>📊 Reportes de Ventas</h2>

    <div class="reporte">
        <h3>🎬 Películas</h3>
        <p>Cantidad de entradas vendidas: <span class="total"><?php echo $res_peliculas['total_cantidad'] ?? 0; ?></span></p>
        <p>Dinero ganado: <span class="total">$<?php echo $res_peliculas['total_ventas'] ?? 0; ?></span></p>
    </div>

    <div class="reporte">
        <h3>🎟️ Reservas</h3>
        <p>Cantidad de reservas: <span class="total"><?php echo $res_reservas['total_reservas'] ?? 0; ?></span></p>
    </div>

    <div class="reporte">
        <h3>🧸 Merch</h3>
        <p>Cantidad de productos vendidos: <span class="total"><?php echo $res_merch['total_cantidad'] ?? 0; ?></span></p>
        <p>Dinero ganado: <span class="total">$<?php echo $res_merch['total_ventas'] ?? 0; ?></span></p>
    </div>

    <div class="reporte">
        <h3>🍿 Comidas</h3>
        <p>Cantidad de combos vendidos: <span class="total"><?php echo $res_comidas['total_cantidad'] ?? 0; ?></span></p>
        <p>Dinero ganado: <span class="total">$<?php echo $res_comidas['total_ventas'] ?? 0; ?></span></p>
    </div>

    <div class="reporte grande">
        <h3>💰 Total Ganado por el Cine</h3>
        <p>$<?php echo $total_general; ?></p>
    </div>

    <a href="../admin_menu.php" class="btn-volver">← Volver al Menú</a>
</body>

</html>
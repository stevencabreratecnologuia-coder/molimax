<?php
include("../conexion.php");

$sql = "SELECT * FROM reservas";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin Reservas</title>
    <link rel="stylesheet" href="admin_reserva.css">
</head>

<body>
    <nav class="admin-nav">
        <span class="nav-logo">MOLIMAX</span>
        <ul class="nav-links">
            <li><a href="../admin_menu.php">← Volver al Menú</a></li>
        </ul>
    </nav>

    <div class="admin-wrapper">
        <div class="page-header">
            <h1>🎟️ Gestión de Reservas</h1>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Película</th>
                        <th>Sala</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Asiento</th>
                        <th>Fecha Reserva</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo htmlspecialchars($fila['pelicula']); ?></td>
                            <td>
                                <span class="badge badge-purple">
                                    <?php echo htmlspecialchars($fila['sala']); ?>
                                </span>
                            </td>
                            <td><?php echo $fila['fecha']; ?></td>
                            <td><?php echo $fila['hora']; ?></td>
                            <td><?php echo htmlspecialchars($fila['asiento']); ?></td>
                            <td><?php echo $fila['fecha_reserva']; ?></td>
                            <td class="table-actions">
                                <a href="editar_reserva.php?id=<?php echo $fila['id']; ?>" class="btn btn-outline">✏️ Editar</a>
                                <a href="eliminar_reserva.php?id=<?php echo $fila['id']; ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('¿Seguro que quieres eliminar esta reserva?');">
                                    🗑️ Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
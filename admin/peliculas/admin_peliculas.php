<?php
include("../conexion.php"); // conexión dentro de admin

$sql = "SELECT * FROM peliculas";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin Películas</title>
    <link rel="stylesheet" href="estilo_admin_peliculas.css">
</head>

<body>
    <h2>🎬 Gestión de Películas</h2>
    <a href="agregar.php" class="btn-agregar">➕ Agregar Película</a>
    <!-- Botón Volver al Menú -->
    <a href="../admin_menu.php" class="btn-volver">← Volver al Menú</a>
    <table class="tabla">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Duración</th>
            <th>Clasificación</th>
            <th>Formato</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['titulo']; ?></td>
                <td><?php echo $fila['descripcion']; ?></td>
                <td><?php echo $fila['duracion']; ?></td>
                <td><?php echo $fila['clasificacion']; ?></td>
                <td><?php echo $fila['formato']; ?></td>
                <td>
                    <img src="<?php echo $fila['imagen']; ?>" alt="Imagen" style="max-height:80px;">
                </td>
                <td>
                    <a href="editar.php?id=<?php echo $fila['id']; ?>" class="btn-editar">✏️ Editar</a>
                    <a href="eliminar.php?id=<?php echo $fila['id']; ?>" class="btn-eliminar">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
<?php
include("../conexion.php");

$sql = "SELECT * FROM comidas";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin Combos</title>
    <link rel="stylesheet" href="estilos_combos.css">
</head>

<body>
    <h2>🍿 Gestión de Combos</h2>
    <a href="agregar_combos.php">➕ Agregar Combo</a>

    <a href="../admin_menu.php" class="btn-volver">← Volver al Menú</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['descripcion']; ?></td>
                <td><?php echo $fila['precio']; ?></td>
                <td><?php echo $fila['stock']; ?></td>
                <td><img src="<?php echo $fila['imagen']; ?>" style="max-height:80px;"></td>
                <td>
                    <a href="editar_combos.php?id=<?php echo $fila['id']; ?>">✏️ Editar</a>
                    <a href="eliminar_combos.php?id=<?php echo $fila['id']; ?>"
                        onclick="return confirm('¿Seguro que quieres eliminar este combo?');">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
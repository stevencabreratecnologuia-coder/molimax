<?php
include("../conexion.php");

$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin Usuarios</title>
    <link rel="stylesheet" href="admin_usuarios.css">
</head>

<body>
    <h2>👤 Gestión de Usuarios</h2>
    <a href="agregar_usuario.php">➕ Agregar Usuario</a>
    <a href="../admin_menu.php" class="btn-volver">← Volver al Menú</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Password</th>
            <th>Rol</th>
            <th>Fecha Registro</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['password']; ?></td>
                <td><?php echo $fila['rol']; ?></td>
                <td><?php echo $fila['fecha_registro']; ?></td>
                <td>
                    <a href="editar_usuario.php?id=<?php echo $fila['id']; ?>">✏️ Editar</a>
                    <a href="eliminar_usuario.php?id=<?php echo $fila['id']; ?>"
                        onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
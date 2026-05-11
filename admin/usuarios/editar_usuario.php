<?php
include("../conexion.php");
$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id=$id";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="editar_usuario.css">
</head>

<body>
    <div class="contenedor">
        <h2>✏️ Editar Usuario</h2>
        <form action="actualizar_usuario.php" method="POST" class="formulario">
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>">

            <label>Correo:</label>
            <input type="email" name="correo" value="<?php echo $fila['correo']; ?>">

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?php echo $fila['telefono']; ?>">

            <label>Password:</label>
            <input type="text" name="password" value="<?php echo $fila['password']; ?>">

            <label>Rol:</label>
            <select name="rol">
                <option value="admin" <?php if ($fila['rol'] == "admin") echo "selected"; ?>>Admin</option>
                <option value="cliente" <?php if ($fila['rol'] == "cliente") echo "selected"; ?>>Cliente</option>
            </select>

            <div class="acciones">
                <button type="submit" class="btn-guardar">💾 Actualizar</button>
                <a href="admin_usuarios.php" class="btn-volver">← Volver a Usuarios</a>
            </div>
        </form>
    </div>
</body>

</html>
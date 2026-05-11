<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
</head>

<body>
    <h2>➕ Agregar Usuario</h2>
    <form action="insertar_usuario.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rol:</label><br>
        <select name="rol" required>
            <option value="admin">Admin</option>
            <option value="cliente">Cliente</option>
        </select><br><br>

        <button type="submit">💾 Guardar</button>
    </form>
</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Merch</title>
    <!-- Conectamos al CSS global -->
    <link rel="stylesheet" href="agregar_merch.css">
</head>

<body>
    <div class="login-container">
        <h2>➕ Agregar Merch</h2>
        <form action="insertar_merch.php" method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Descripción:</label>
            <textarea name="descripcion"></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" required>

            <label>Stock:</label>
            <input type="number" name="stock" required>

            <label>Imagen:</label>
            <input type="text" name="imagen">

            <button type="submit">💾 Guardar</button>
            <a href="admin_merch.php" class="btn-volver">← Volver a Merch</a>
        </form>
    </div>
</body>

</html>
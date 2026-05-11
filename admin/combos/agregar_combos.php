<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Combo</title>
    <!-- Conectamos al CSS de combos -->
    <link rel="stylesheet" href="estilos_combos.css">
</head>

<body>
    <div class="login-container">
        <h2>➕ Agregar Combo</h2>
        <form action="insertar_combos.php" method="POST">
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
            <a href="admin_combos.php" class="btn-volver">← Volver a Combos</a>
        </form>
    </div>
</body>

</html>
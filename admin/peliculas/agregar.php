<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Película</title>
    <link rel="stylesheet" href="agregar.css">
</head>

<body>
    <div class="login-container">
        <h2>➕ Agregar Película</h2>
        <form action="insertar.php" method="POST">
            <input type="text" name="titulo" placeholder="Título" required>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <input type="text" name="duracion" placeholder="Duración" required>
            <input type="text" name="clasificacion" placeholder="Clasificación" required>
            <input type="text" name="formato" placeholder="Formato (2D, 3D)" required>
            <input type="text" name="imagen" placeholder="URL de la imagen">
            <button type="submit">💾 Guardar</button>
        </form>

        <!-- Botón para volver al menú de administración -->
        <a href="admin_peliculas.php" class="btn-volver">← Volver al Menú</a>

    </div>

</body>

</html>
    <?php
    include("../conexion.php");
    $id = $_GET['id'];
    $sql = "SELECT * FROM peliculas WHERE id=$id";
    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Editar Película</title>
        <link rel="stylesheet" href="estilo_edit.css">
    </head>

    <body>
        <div class="login-container">
            <h2>✏️ Editar Película</h2>
            <form action="actualizar.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                <input type="text" name="titulo" value="<?php echo $fila['titulo']; ?>">
                <textarea name="descripcion"><?php echo $fila['descripcion']; ?></textarea>
                <input type="number" name="duracion" value="<?php echo $fila['duracion']; ?>">
                <input type="text" name="clasificacion" value="<?php echo $fila['clasificacion']; ?>">
                <input type="text" name="formato" value="<?php echo $fila['formato']; ?>">
                <input type="text" name="imagen" value="<?php echo $fila['imagen']; ?>">

                <button type="submit">💾 Guardar</button>
            </form>
            <!-- Botón para volver al menú de administración -->
            <a href="admin_peliculas.php" class="btn-volver">← Volver a peliculas</a>


        </div>
    </body>

    </html>
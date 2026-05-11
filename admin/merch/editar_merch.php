<?php
include("../conexion.php");
$id = $_GET['id'];
$sql = "SELECT * FROM merch WHERE id=$id";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Merch</title>
    <link rel="stylesheet" href="editar_merch.css">
</head>

<body>
    <div class="form-container">
        <h2>✏️ Editar Merch</h2>
        <form action="actualizar_merch.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>">

            <label>Descripción:</label>
            <textarea name="descripcion"><?php echo $fila['descripcion']; ?></textarea>

            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?php echo $fila['precio']; ?>">

            <label>Stock:</label>
            <input type="number" name="stock" value="<?php echo $fila['stock']; ?>">

            <label>Imagen:</label>
            <input type="text" name="imagen" value="<?php echo $fila['imagen']; ?>">

            <div class="form-buttons">
                <button type="submit">💾 Actualizar</button>
                <a href="admin_merch.php" class="btn-volver">← Volver a Merch</a>
            </div>
        </form>
    </div>
</body>

</html>
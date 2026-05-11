<?php
include("../conexion.php");
$id = $_GET['id'];
$sql = "SELECT * FROM comidas WHERE id=$id";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Combo</title>
    <!-- Aquí conectas tu CSS -->
    <link rel="stylesheet" href="estilos_combos.css">
</head>

<body>
    <div class="login-container">
        <h2>✏️ Editar Combo</h2>
        <form action="actualizar_combos.php" method="POST">
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

            <button type="submit">💾 Actualizar</button>
            <a href="admin_combos.php" class="btn-volver">← Volver a Combos</a>
        </form>
    </div>
</body>

</html>
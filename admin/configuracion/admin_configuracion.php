<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location:../cliente/inicio_de_sesion.php");
    exit();
}

include("../conexion.php");

// Verificar que el usuario sea admin
$usuario_email = $_SESSION["usuario"];
$sql_usuario = "SELECT * FROM usuarios WHERE correo = '$usuario_email'";
$res_usuario = mysqli_query($conexion, $sql_usuario);
$datos_usuario = mysqli_fetch_assoc($res_usuario);

if ($datos_usuario['rol'] != 'admin') {
    die("❌ Acceso denegado. Solo administradores pueden entrar aquí.");
}

// Obtener configuración actual
$sql_config = "SELECT * FROM configuracion LIMIT 1";
$res_config = mysqli_query($conexion, $sql_config);
$config = mysqli_fetch_assoc($res_config);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Configuración Admin</title>
</head>

<body>
    <h2>⚙️ Configuración del Sistema</h2>

    <!-- Perfil Admin -->
    <h3>👤 Perfil Admin</h3>
    <p><strong>Nombre:</strong> <?php echo $datos_usuario['nombre']; ?></p>
    <p><strong>Correo:</strong> <?php echo $datos_usuario['correo']; ?></p>
    <p><strong>Rol:</strong> <?php echo $datos_usuario['rol']; ?></p>

    <hr>

    <!-- Configuración básica -->
    <h3>🛠️ Parámetros del Sistema</h3>
    <form action="guardar_configuracion.php" method="POST">
        <label>Nombre del Cine:</label><br>
        <input type="text" name="nombre_cine" value="<?php echo $config['nombre_cine']; ?>"><br><br>

        <label>Correo de Contacto:</label><br>
        <input type="email" name="correo_contacto" value="<?php echo $config['correo_contacto']; ?>"><br><br>

        <label>Teléfono de Contacto:</label><br>
        <input type="text" name="telefono_contacto" value="<?php echo $config['telefono_contacto']; ?>"><br><br>

        <button type="submit">💾 Guardar Configuración</button>
    </form>
</body>

</html>
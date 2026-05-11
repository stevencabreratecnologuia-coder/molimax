<?php
session_start();
include("carrito_funciones.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}

include("conexion.php");

$usuario_email = $_SESSION["usuario"];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirmar = $_POST['password_confirmar'];

    // Validaciones
    if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
        $mensaje = "❌ Todos los campos son obligatorios.";
    } elseif ($password_nueva !== $password_confirmar) {
        $mensaje = "❌ Las contraseñas nuevas no coinciden.";
    } elseif (strlen($password_nueva) < 4) {
        $mensaje = "❌ La nueva contraseña debe tener al menos 4 caracteres.";
    } else {
        // Verificar contraseña actual
        $sql_verificar = "SELECT password FROM usuarios WHERE correo = '$usuario_email'";
        $resultado = mysqli_query($conexion, $sql_verificar);
        $usuario = mysqli_fetch_assoc($resultado);

        if ($usuario && $password_actual == $usuario['password']) {
            // Actualizar contraseña
            $sql_update = "UPDATE usuarios SET password = '$password_nueva' WHERE correo = '$usuario_email'";
            if (mysqli_query($conexion, $sql_update)) {
                $mensaje = "✅ Contraseña cambiada exitosamente.";
            } else {
                $mensaje = "❌ Error al cambiar la contraseña: " . mysqli_error($conexion);
            }
        } else {
            $mensaje = "❌ La contraseña actual es incorrecta.";
        }
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña - Molimax</title>
    <link rel="stylesheet" href="css/estilo_C.css">
</head>

<body>

    <header class="topbar">
        <div class="logo">🎬 MOLIMAX</div>
        <nav>
            <a href="cliente_configuracion.php">← Volver a Configuración</a>
            <a href="cliente_peliculas.php">Películas</a>
            <a href="#">Estrenos</a>
            <a href="cliente_reservas.php">Reservas</a>
            <a href="carrito.php" style="position: relative;">
                🛒 Carrito
                <span style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                    <?php echo contarProductos() > 0 ? contarProductos() : ''; ?>
                </span>
            </a>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <h3>Menú</h3>
            <ul>
                <li><a href="cliente_peliculas.php">🎥 Películas</a></li>
                <li><a href="cliente_comida.php">🍿 Combos</a></li>
                <li><a href="cliente_merchandise.php">🧸 Merch</a></li>
                <li><a href="cliente_reservas.php">🎟️ Reservas</a></li>
                <li><a href="cliente_configuracion.php">⚙️ Configuración</a></li>
            </ul>
        </aside>

        <main class="content">
            <div class="titulo">
                <h2>🔒 Cambiar Contraseña</h2>
            </div>

            <?php if (!empty($mensaje)): ?>
                <div class="card" style="border-left: 4px solid <?php echo strpos($mensaje, '✅') === 0 ? 'green' : 'red'; ?>;">
                    <div class="card-body">
                        <p><?php echo $mensaje; ?></p>
                    </div>
                </div>
                <br>
            <?php endif; ?>

            <!-- Bloque Seguridad centrado -->
            <div class="card seguridad">
                <div class="card-body">
                    <h3>Seguridad</h3>
                    <p>Mantén segura tu cuenta de Molimax.</p>
                    <form action="cambiar_password.php" method="POST">
                        <input type="password" name="password_actual" placeholder="Contraseña actual" required><br><br>
                        <input type="password" name="password_nueva" placeholder="Nueva contraseña (mínimo 4 caracteres)" required><br><br>
                        <input type="password" name="password_confirmar" placeholder="Confirmar nueva contraseña" required><br><br>
                        <button type="submit" class="btn-comprar btn-small">Cambiar Contraseña</button>
                        <a href="cliente_configuracion.php" style="margin-left: 10px; text-decoration: none;">
                            <button type="button" class="btn-accion btn-secondary">Cancelar</button>
                        </a>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>

</html>
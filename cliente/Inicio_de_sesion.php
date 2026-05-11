<?php
session_start();

$mensaje = "";

/* =========================
   CONEXIÓN A LA BASE DATOS
========================= */
$server = "localhost";
$username = "root";
$pass = "";
$bd = "molimax_db";

$conexion = new mysqli($server, $username, $pass, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

/* =========================
   LOGIN
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $rol = $_POST["rol"];

    $sql = "SELECT * FROM usuarios WHERE correo = ? AND rol = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $correo, $rol);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // VALIDAR CONTRASEÑA (idealmente con password_hash)
        if ($password == $usuario["password"]) {
            $_SESSION["usuario"] = $usuario["correo"];
            $_SESSION["rol"] = $usuario["rol"];

            // REDIRECCIÓN SEGÚN ROL
            if ($usuario["rol"] == "cliente") {
                header("Location: ../cliente/menu.php");
            } elseif ($usuario["rol"] == "admin") {
                header("Location: ../admin/admin_menu.php");
            } else {
                header("Location: Menu.php");
            }
            exit();
        } else {
            $mensaje = "❌ Contraseña incorrecta";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión Molimax</title>
    <link rel="stylesheet" href="../css/estilo_I.css">
</head>

<body>
    <div class="login-container">
        <h2>🎬 Iniciar Sesión Molimax</h2>
        <form method="POST">
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>

            <select name="rol" required>
                <option value="">Selecciona rol</option>
                <option value="cliente">Cliente</option>
                <option value="admin">Administrador</option>
            </select>

            <button type="submit">Ingresar</button>
        </form>

        <!-- BOTON REGISTRO -->
        <a href="Registro.php" class="btn-login">Registrarse</a>

        <!-- MENSAJE -->
        <p class="mensaje"><?php echo $mensaje; ?></p>
    </div>
</body>

</html>
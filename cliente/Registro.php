<?php

$mensaje = "";

/* =========================
   CONEXIÓN BASE DE DATOS
========================= */

$server = "localhost";
$username = "root";
$pass = "";
$bd = "molimax_db";

$conexion = new mysqli(
    $server,
    $username,
    $pass,
    $bd
);

if ($conexion->connect_error) {

    die("Conexión fallida: " .
        $conexion->connect_error);
}

/* =========================
   REGISTRO USUARIO
========================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];
    $confirmar = $_POST["confirmar"];

    // TODOS LOS USUARIOS SERÁN CLIENTES

    $rol = "cliente";

    /* VALIDACIONES */

    if ($password != $confirmar) {

        $mensaje =
            "❌ Las contraseñas no coinciden";
    } else if (strlen($password) < 4) {

        $mensaje =
            "❌ La contraseña debe tener mínimo 4 caracteres";
    } else {

        // VERIFICAR SI EL CORREO YA EXISTE

        $verificar = "
        SELECT *
        FROM usuarios
        WHERE correo = ?
        ";

        $stmt = $conexion->prepare($verificar);

        $stmt->bind_param(
            "s",
            $correo
        );

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $mensaje =
                "❌ El correo ya está registrado";
        } else {

            // INSERTAR USUARIO

            $sql = "
            INSERT INTO usuarios
            (
                nombre,
                correo,
                telefono,
                password,
                rol
            )

            VALUES
            (
                ?, ?, ?, ?, ?
            )
            ";

            $stmt = $conexion->prepare($sql);

            $stmt->bind_param(
                "sssss",
                $nombre,
                $correo,
                $telefono,
                $password,
                $rol
            );

            if ($stmt->execute()) {

                $mensaje =
                    "✅ Usuario registrado correctamente";
            } else {

                $mensaje =
                    "❌ Error al registrar";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Registro Molimax</title>

    <link
        rel="stylesheet"
        href="../css/estilo_I.css">

</head>

<body>

    <div class="login-container">

        <h2>🎬 Registro Molimax</h2>

        <form method="POST">

            <input
                type="text"
                name="nombre"
                placeholder="Nombre completo"
                required>

            <input
                type="email"
                name="correo"
                placeholder="Correo electrónico"
                required>

            <input
                type="text"
                name="telefono"
                placeholder="Teléfono">

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required>

            <input
                type="password"
                name="confirmar"
                placeholder="Confirmar contraseña"
                required>

            <button type="submit">

                Registrarse

            </button>

        </form>

        <!-- BOTON LOGIN -->

        <a
            href="Inicio_de_sesion.php"
            class="btn-login">

            Iniciar Sesión

        </a>

        <p class="mensaje">

            <?php echo $mensaje; ?>

        </p>

    </div>

</body>

</html>
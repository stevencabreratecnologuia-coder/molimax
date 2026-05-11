<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: Inicio_de_sesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pago Exitoso</title>
    <link rel="stylesheet" href="estilo_E.css">


</head>

<body class="pago">
    <div class="mensaje">✅ ¡Pago exitoso! Tu pedido fue registrado correctamente.</div>
    <a href="menu.php" class="boton">Salir</a>
</body>

</html>
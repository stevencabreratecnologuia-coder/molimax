<?php
include("../conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ─── Recoger datos ───────────────────────────────────────────
    $id_usuario  = $_POST['id_usuario']  ?? $_SESSION['id'] ?? null;
    $id_funcion  = $_POST['id_funcion']  ?? null;
    $usuario     = $_POST['usuario']     ?? '';
    $pelicula    = $_POST['pelicula']    ?? '';
    $id_sala     = $_POST['id_sala']     ?? '';
    $fecha       = $_POST['fecha']       ?? '';
    $hora        = $_POST['hora']        ?? '';
    $asiento     = $_POST['asiento']     ?? '';
    $cantidad_asientos = 1;

    // Convertir ID en texto "Sala X"
    $sala_nombre = "Sala " . $id_sala;

    // ─── Validar que los campos críticos no estén vacíos ────────
    if (empty($usuario) || empty($pelicula) || empty($id_sala) || empty($fecha) || empty($hora) || empty($asiento)) {
        die("❌ Error: faltan campos obligatorios.");
    }

    // ─── Verificar que id_usuario existe en la tabla usuarios ───
    if (!empty($id_usuario)) {
        $check = $conexion->prepare("SELECT id FROM usuarios WHERE id = ?");
        $check->bind_param("i", $id_usuario);
        $check->execute();
        $check->store_result();
        if ($check->num_rows === 0) {
            die("❌ Error: el usuario con ID '$id_usuario' no existe.");
        }
        $check->close();
    }

    // ─── Insertar reserva ────────────────────────────────────────
    $sql = "INSERT INTO reservas 
                (id_usuario, id_funcion, usuario, pelicula, sala, fecha, hora, asiento, cantidad_asientos, fecha_reserva)
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "iissssssi",
        $id_usuario,        // int
        $id_funcion,        // int
        $usuario,           // string
        $pelicula,          // string
        $sala_nombre,       // string  "Sala X"
        $fecha,             // string
        $hora,              // string
        $asiento,           // string
        $cantidad_asientos  // int
    );

    if ($stmt->execute()) {
        // ─── Marcar asiento como ocupado ─────────────────────────
        $sql_update = "UPDATE asientos SET disponible = 0 WHERE asiento = ? AND id_sala = ?";
        $stmt2 = $conexion->prepare($sql_update);
        $stmt2->bind_param("si", $asiento, $id_sala);
        $stmt2->execute();
        $stmt2->close();
        $stmt->close();

        header("Location: ../cliente/cliente_reservas.php");
        exit();
    } else {
        echo "❌ Error al guardar la reserva: " . htmlspecialchars($conexion->error);
    }
}

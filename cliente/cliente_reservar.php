<?php
include("../conexion.php");

// Salas
$sql_salas = "SELECT * FROM salas";
$res_salas = $conexion->query($sql_salas);

// Horarios
$sql_horarios = "SELECT * FROM horarios";
$res_horarios = $conexion->query($sql_horarios);

// Asientos disponibles
$sql_asientos = "SELECT * FROM asientos WHERE disponible=1";
$res_asientos = $conexion->query($sql_asientos);
?>

<form action="insertar_reserva.php" method="POST">
    <label>Cliente:</label><br>
    <input type="text" name="id_usuario" placeholder="ID Cliente"><br><br>

    <label>Sala:</label><br>
    <select name="sala" required>
        <?php while ($sala = $res_salas->fetch_assoc()) { ?>
            <option value="<?php echo $sala['id']; ?>">
                <?php echo $sala['nombre']; ?> (Capacidad: <?php echo $sala['capacidad']; ?>)
            </option>
        <?php } ?>
    </select><br><br>

    <label>Horario:</label><br>
    <select name="horario" required>
        <?php while ($h = $res_horarios->fetch_assoc()) { ?>
            <option value="<?php echo $h['id']; ?>">
                <?php echo $h['fecha'] . ' ' . $h['hora']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Asiento:</label><br>
    <select name="asiento" required>
        <?php while ($a = $res_asientos->fetch_assoc()) { ?>
            <option value="<?php echo $a['id']; ?>">
                <?php echo $a['asiento']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">💾 Guardar Reserva</button>
</form>
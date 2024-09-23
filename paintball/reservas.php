<?php
// Configuración de la base de datos
$user = "root";
$pass = "";
$host = "localhost";
$datab = "formulario";

// Crear la conexión
$connection = mysqli_connect($host, $user, $pass, $datab);

// Verificar la conexión
if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_connect_error());
}

// Procesar la reserva
if (isset($_POST["sede"], $_POST["horario"], $_POST["fecha"])) {
    $sede = $_POST["sede"];
    $horario = $_POST["horario"];
    $fecha = $_POST["fecha"];

    // Validación básica
    if (empty($sede) || empty($horario) || empty($fecha)) {
        die("Todos los campos son requeridos para la reserva.");
    }

    // Comprobar disponibilidad
    $stmt = $connection->prepare("SELECT * FROM reservas WHERE fecha = ? AND horario = ?");
    $stmt->bind_param("ss", $fecha, $horario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Lo sentimos, ya existe una reserva para esta fecha y horario.";
    } else {
        // Preparar la instrucción SQL para insertar la reserva
        $stmt = $connection->prepare("INSERT INTO reservas (sede, fecha, horario) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $sede, $fecha, $horario);

        // Ejecutar la instrucción SQL
        if ($stmt->execute()) {
            echo "Reserva realizada con éxito para la sede: " . htmlspecialchars($sede);
        } else {
            echo "Error en la reserva: " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    echo "Datos de reserva no recibidos.";
}

// Cerrar la conexión
$connection->close();
?>

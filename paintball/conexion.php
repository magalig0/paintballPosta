<?php
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

// Procesar el formulario de registro
if (isset($_POST["nombre"], $_POST["usuario"], $_POST["contraseña"]) && !isset($_POST["login"])) {
    $nombre = trim($_POST["nombre"]);
    $usuario = trim($_POST["usuario"]);
    $contraseña = trim($_POST["contraseña"]);

    // Validación básica
    if (empty($nombre) || empty($usuario) || empty($contraseña)) {
        die("Todos los campos son requeridos para el registro.");
    }

    // Hashear la contraseña antes de almacenarla
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar la instrucción SQL
    $stmt = $connection->prepare("INSERT INTO usuarios (nombre, usuario, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $usuario, $contraseña_hash);

    // Ejecutar la instrucción SQL
    if ($stmt->execute()) {
        // Redirigir a reservas.html
        header("Location: reservas.html");
        exit(); // Detener la ejecución del script
    } else {
        die("No se pudo hacer la consulta: " . $stmt->error);
    }
}

// Procesar el formulario de inicio de sesión
if (isset($_POST["login"], $_POST["usuario"], $_POST["contraseña"]) && !isset($_POST["nombre"])) {
    $usuario = trim($_POST["usuario"]);
    $contraseña = trim($_POST["contraseña"]);

    // Validación básica
    if (empty($usuario) || empty($contraseña)) {
        die("Usuario y contraseña son requeridos para el inicio de sesión.");
    }

    // Preparar la consulta SQL
    $stmt = $connection->prepare("SELECT contraseña FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($contraseña_hash);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contraseña, $contraseña_hash)) {
            // Aquí redirigir a reservas.html después de un inicio de sesión exitoso
            header("Location: reservas.html");
            exit(); // Detener la ejecución del script
        } else {
            echo "Usuario o contraseña incorrectos.<br>";
        }
    } else {
        echo "Usuario no encontrado.<br>";
    }
}

// Cerrar la conexión
$connection->close();

// Enlace para volver atrás
echo '<a href="index.html">Volver atrás</a>';
?>

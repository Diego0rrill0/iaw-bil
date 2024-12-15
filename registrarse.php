<?php
session_start();
include('conexx.php'); // Incluimos la conexión a la base de datos

// Verificamos si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validamos que las contraseñas coincidan
    if ($password === $password_confirm) {
        // Comprobamos si el usuario ya existe en la base de datos
        $stmt = $conn->prepare("SELECT * FROM login WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si el usuario no existe, lo insertamos
        if ($result->num_rows === 0) {
            $stmt = $conn->prepare("INSERT INTO login (usuario, passwd) VALUES (?, ?)");
            $stmt->bind_param("ss", $usuario, $password);
            if ($stmt->execute()) {
                echo "<script>alert('Insertado con éxito'); window.location.href='index.php';</script>";
                exit();
            } else {
                $error = "Hubo un problema al registrar el usuario.";
            }
        } else {
            $error = "El usuario ya existe.";
        }
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="registrarse.css">
</head>
<body>
    <div class="login-container">
        <h1>REGISTRO</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="registrarse.php" method="POST">
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="password_confirm">Confirmar contraseña:</label><br>
            <input type="password" id="password_confirm" name="password_confirm" required><br><br>

            <button type="submit">Registrarse</button>
        </form>

        <br>
        <a href="index.php">Volver a la página de inicio</a>
    </div>
</body>
</html>
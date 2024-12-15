<?php
session_start();
include('conexx.php'); // Incluimos la conexión a la base de datos

// Verificamos si el formulario de login fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consultamos la base de datos para verificar si el usuario y la contraseña coinciden
    $stmt = $conn->prepare("SELECT * FROM login WHERE usuario = ? AND passwd = ?");
    $stmt->bind_param("ss", $usuario, $password); // 'ss' indica que ambos parámetros son strings
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe y la contraseña es correcta
    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario; // Iniciamos sesión
        header('Location: principal.php'); // Redirección a la página principal
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="login-container">
        <h1>LOGIN</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Iniciar sesión</button>
        </form>

        <br>
        <a href="registrarse.php">¿No tienes cuenta? Regístrate aquí</a>
    </div>
</body>
</html>

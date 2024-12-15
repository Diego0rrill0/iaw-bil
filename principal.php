<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirigir al login si no está logueado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="principal.css">
</head>
<body>
    <h1>Bienvenido <?php echo $_SESSION['usuario']; ?>, a la aplicación de gestión de permisos</h1>
    <div class="container">
        <p><b><a href="aplicaciones.php">Ver Aplicaciones</a></b></p>
        <p><b><a href="logout.php">Cerrar sesión</a></b></p>
    </div>
</body>
</html>

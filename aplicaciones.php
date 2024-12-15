<?php
session_start();

// Verificamos si el usuario está logueado; si no, redirigimos a index.php
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Inicializamos el listado de aplicaciones en sesión si no existe
if (!isset($_SESSION['aplicaciones'])) {
    $_SESSION['aplicaciones'] = []; // Array vacío para aplicaciones
}

// Mensaje de confirmación
$mensaje = "";

// Proceso para insertar una nueva aplicación con descripción
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_aplicacion'], $_POST['descripcion'])) {
    $nuevaApp = trim($_POST['nueva_aplicacion']);
    $descripcion = trim($_POST['descripcion']);

    // Validamos que ambos campos tengan contenido
    if (!empty($nuevaApp) && !empty($descripcion)) {
        $_SESSION['aplicaciones'][] = [
            'nombre' => $nuevaApp,
            'descripcion' => $descripcion
        ];
        $mensaje = "¡Aplicación agregada exitosamente!";
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

// Proceso para borrar una aplicación
if (isset($_GET['borrar'])) {
    $indice = (int) $_GET['borrar']; // Obtenemos el índice de la aplicación a borrar
    if (isset($_SESSION['aplicaciones'][$indice])) {
        unset($_SESSION['aplicaciones'][$indice]); // Eliminamos la aplicación
        $_SESSION['aplicaciones'] = array_values($_SESSION['aplicaciones']); // Reindexamos el array
        $mensaje = "Aplicación eliminada correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Aplicaciones</title>
    <link rel="stylesheet" href="aplicaciones.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Aplicaciones</h1>

        <!-- Mensaje de confirmación -->
        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <!-- Formulario para insertar una nueva aplicación -->
        <form action="aplicaciones.php" method="POST">
            <label for="nueva_aplicacion">Nombre de la nueva aplicación:</label><br>
            <input type="text" id="nueva_aplicacion" name="nueva_aplicacion" required><br><br>
            
            <label for="descripcion">Descripción de la aplicación:</label><br>
            <input type="text" id="descripcion" name="descripcion" required><br><br>

            <button type="submit">Agregar Aplicación</button>
        </form>
    </div>

    <!-- Listado de aplicaciones existentes -->
    <div class="container">
        <h2>Listado de Aplicaciones</h2>
        <?php if (!empty($_SESSION['aplicaciones'])): ?>
            <ul>
                <?php foreach ($_SESSION['aplicaciones'] as $indice => $aplicacion): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($aplicacion['nombre']); ?>:</strong> 
                        <?php echo htmlspecialchars($aplicacion['descripcion']); ?>
                        <!-- Botón para borrar la aplicación -->
                        <a href="aplicaciones.php?borrar=<?php echo $indice; ?>" 
                           onclick="return confirm('¿Seguro que deseas eliminar esta aplicación?');">
                           Borrar
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay aplicaciones registradas.</p>
        <?php endif; ?>
    </div>

    <!-- Botón para regresar a la página principal -->
    <div class="container">
        <a href="principal.php" class="btn">Volver a la página principal</a>
    </div>
</body>
</html>

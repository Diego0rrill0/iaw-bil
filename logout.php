<?php
session_start();
session_destroy();
header('Location: index.php'); // Esto nos redirecciona al login después de cerrar sesión
exit();
?>

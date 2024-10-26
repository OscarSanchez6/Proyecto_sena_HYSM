<?php
session_start();      // Inicia la sesión actual
session_unset();      // Libera todas las variables de sesión
session_destroy();    // Destruye la sesión

// Redirige al usuario a la página de inicio de sesión
header('Location: ../View/inicio_Sesion_Usuario.php');
exit();
?>
<a href="../Controller/finalizar_Sesion.php">Cerrar Sesión</a>


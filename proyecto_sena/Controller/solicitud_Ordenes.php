<?php
// Incluir la conexión a la base de datos y otras configuraciones necesarias
include_once '../Model/conexionPDO.php';
?>
<?php 
session_start();
if (!isset($_SESSION['rol']))
	{
		header('location: inicio_Sesion_Usuario.php');
		die(); exit();
	}
else
	{
		if($_SESSION['rol'] !=5)
			{
				header('location: inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Órdenes Médicas.</title>
    <link rel="stylesheet" href="../Css/solicitud_Ordenes.css"> <!-- Enlace a tu archivo de estilos -->
</head>
<body>
<?php
    include_once '../View/header_Usuario.php';
    ?>

<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=6> Bienvenid@  <br>".$usuario."</font><br>";
?>
    <p>Bienvenido al panel de Solicitud de autorizaciones de exámenes y procedimientos.</p>
    <div class="mensaje-desarrollo">
    <p>En este momento nos encontramos en el desarrollo de este espacio para una mayor comodidad de nuestros usuarios, esperamos poder tener este espacio para ti muy pronto, agradecemos tu comprensión.</p>
    </div>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
</div>


</div>
    
</body>
<?php
    include_once '../View/footer.php';
?>

</body>
</html>

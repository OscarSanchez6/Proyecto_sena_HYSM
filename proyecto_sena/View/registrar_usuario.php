<?php
include_once '../Model/conexionPDO.php';// Incluye el archivo de conexión
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
		if($_SESSION['rol'] !=3)
			{
				header('location: inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
   
?>
<?php
include_once'../View/header_recepcion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente - Health</title>
    <link rel="stylesheet" href="../css/registrar_usuario2.css">
</head>
<body>
<?php
include_once'../View/header_recepcion.php';
?>
<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=3> Hola!!  <br>".$usuario."</font><br>";
?>
    <p>En este momento te encuentras dentro de tu panel de registrar usuario.</p>
    <p>Aquí podras:</p>
    <p> acceder al registro como nuevo usuario del hospital. Completa tus datos personales y de contacto para crear tu cuenta. Esto te permitirá gestionar tus citas médicas, acceder a tus historiales de salud y recibir notificaciones importantes.</p>
    <ul>
        <li>registrar usuario</li>
    </ul>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <a href="../Controller/registrar_usuario.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/foto3.jpg" alt="">
        <p>registrar usuario.</p>
    </div>
    </a>
</div><br><br><br><br><br><br>


<?php
    include_once '../View/footer.php';
?>

    
</body>
</html>
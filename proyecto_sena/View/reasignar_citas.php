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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente - Health</title>
    <link rel="stylesheet" href="../css/reasignar_Citas2.css">
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
    <p>En este momento te encuentras dentro de tu panel de reasignar citas  médicas.</p>
    <p>Aquí tendras:</p>
    <p>Recuerda que podrás  acceder a la reasignación de tu cita. Selecciona la nueva fecha y hora que más te convenga, y confirma para finalizar el proceso.</p>
    <ul>
        <li>reasignar citas</li>
    </ul>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <a href="../Controller/reasignar_Citas.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/foto1.jpg" alt="">
        <p>reasignar citas.</p>
    </div>
    </a>

</div>
<br><br><br><br><br><br><br><br><br><br><br><br>



<?php

    include_once '../View/footer.php';
?>

    
</body>
</html>

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
    <link rel="stylesheet" href="../css/asignar_Citas2.css">
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
    <p>En este momento te encuentras dentro de tu panel de asignar citas  médicas.</p>
    <p>Aquí podras:</p>
    <p>acceder a la asignación de tu cita médica. Selecciona la especialidad, la fecha y la hora que mejor se adapten a tus necesidades, y confirma para completar el proceso.</p>
    <ul>
        <li>asignar citas</li>
    </ul>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <a href="../Controller/asignar_Citas.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/foto2.jpg" alt="">
        <p>asignar citas.</p>
    </div>
    </a>
</div><br><br><br><br><br><br>


<?php
    include_once '../View/footer.php';
?>

    
</body>
</html>


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
    <link rel="stylesheet" href="../css/documentacion.css">
    </head>
<body>
<?php
    include_once '../View/header_recepcion.php';
    ?>

<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=3> Bienvenid@  <br>".$usuario."</font><br>";
?>
    <p>Bienvenido al panel de documentacion autorizada .</p>
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

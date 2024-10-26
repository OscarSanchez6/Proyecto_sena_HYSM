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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente - Health</title>
    <link rel="stylesheet" href="../css/solicitud_Cancelacion_Citas.css">
</head>
<body>
    <?php
    include_once '../View/header_Usuario_Citas.php';
    ?>

<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=6> Hola!!  <br>".$usuario."</font><br>";
?>
    <p>En este momento te encuentras dentro de tu panel de solicitud y cancelación de citas médicas.</p>
    <p>Aquí podrás:</p>
    <ul>
        <li>Solicitar citas médicas</li>
        <li>Vizualizar tus citas médicas</li>
        <li>Cancelar citas médicas</li>
        <p>Recuerda Siempre cancelar tus citas 24 horas antes, así le darás el tiempo a otro usuario de tener una pronta atención.</p>
    </ul>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <a href="../Controller/solicitud_Citas.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/calendar-icon-free-vector.jpg" alt="">
        <p>Solicitud de citas médicas.</p>
    </div>
    </a>
    <a href="../Controller/visualizacion_Citas.php">
    <div class="caja_Servicio" >
        
        <img  class="icono" src="../Img/cancelacioncita.png" alt="">
        <p>Visualización citas médicas asignadas.</p>
    </div>
    </a>
    
</div><br><br><br><br><br><br>


<?php
    include_once '../View/footer.php';
?>

    
</body>
</html>

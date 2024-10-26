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
    <link rel="stylesheet" href="../css/usuario.css">
</head>
<body>
    <?php
    include_once 'header_Usuario.php';
    ?><br>

<?php
        if (isset($_GET['message'])){
        ?>
    <div class="alert alert-primary" role="alert"> 
        <?php
        switch ($_GET ['message']) {
            case 'success_password':
                echo '<p class="message">La contraseña fue actualizada con éxito</p>';
                break;
            default:
                echo '<p class"message">Algo salió mal, intenta de nuevo</p>';
                break;
        }
        ?>
    </div>
        <?php 
        }
        ?>

<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=6> Bienvenid@  <br>".$usuario."</font><br>";
?>
    <p>Nos alegra verte en tu panel de salud personal.</p>
    <p>Aquí podrás:</p>
    <ul>
        <li>Solicitar y cancelar citas médicas</li>
        <li>Ver los exámenes formulados por tú médico.</li>
        <li>Visualizar y descargar tu historia médica.</li>
        <li>Visualizar y descargar tus fórmulas médicas.</li>
        <li>Visualizar y descargar tus incapacidades médicas.</li>
        <li>Autorización de órdenes estará para ti muy pronto.</li>
        
    </ul>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <a href="solicitud_Cancelacion_Citas.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/calendar-icon-free-vector.jpg" alt="">
        <p>Solicitud y cancelación citas.</p>
    </div>
    </a>
    <a href="../Controller/examenes_Medicos.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/calendario_check.jpg" alt="">
        <p> Exámenes médicos.</p>
    </div>
    </a>
    <a href="../Controller/historia_medica.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/historia_medica.png" alt="">
        <p>Historia clínica</p>
    </div>
    </a>
    <a href="../Controller/medicamentos.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/medicamentos.png" alt="">
        <p>Medicamentos</p>
    </div>
    </a>
    <a href="../Controller/solicitud_Ordenes.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/autorizaciones.jpg" alt="">
        <p>Autorización de órdenes.</p>
    </div>
    </a>
    <a href="../Controller/incapacidades_Usuario.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/descargar.png" alt="">
        <p>Incapacidades médicas.</p>
    </div>
    </a>
    
</div>


        <?php
    include_once 'footer.php';
?>


    <script src="script.js"></script>
</body>
</html>

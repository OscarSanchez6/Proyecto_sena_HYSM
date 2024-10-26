
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
    <title>Health and services management</title>
    <link rel="stylesheet" href="../css/usuario.css">
</head>
<body>
    <?php
    include_once 'header_recepcion.php';
    ?>

<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$recepcion = $_SESSION['nombre'];	
echo "<font face= impact size=6> Bienvenid@  <br>".$recepcion."</font><br>";
?>
    <p>--Nos alegra verte en tu panel de recepcion</p>
    <p>--Aquí tendrás acceso a todas las herramientas necesarias:</p>
    <ul>
        <li>finalizar sesión</li>
        <li>asignar citas medicas</li>
        <li>reasignar citas medicas</li>
        <li>restablecer contraseña</li>
        <li>registrar usuario</li>
        <li>documentación autorizada</li>
    </ul>
    <p>Tu bienestar es lo más importante para nosotros.</p>
        </div>

<div class="container">
<a href="../View/documentacion_autorizada.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/documentación.jpg" alt="">
        <p>documentacion autorizada</p>
    </div>
    </a>
    <div class="caja_Servicio" >
    <a href="../View/asignar_citas.php">
        <img  class="icono" src="../Img/asignar.jpg" alt="">
        <p>asignar citas medicas</p></a>
    </div>
    </a>
    <div class="caja_Servicio" >
    <a href="../View/reasignar_citas.php">
        <img  class="icono" src="../Img/reasignar.png" alt="">
        <p>reasignar citas medicas</p></a>
    </div>
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/contraseña.png" alt="">
        <p>restablecer contraseña</p>
    </div>
    </a>
    <div class="caja_Servicio" >
    <a href="../View/registrar_usuario.php">
        <img  class="icono" src="../Img/usuario.jpg" alt="">
        <p>registrar usuario</p></a>
    </div>
    </a>
    <div class="caja_Servicio" >
    <a href="../controller/finalizar_Sesion.php">
        <img  class="icono" src="../Img/foto.jpg" alt="">
        <p>finalizar sesión</p></a>
    </div>
</div>
<?php
    include_once 'footer.php';
?>
</body>
</html>
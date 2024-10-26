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
		if($_SESSION['rol'] !=2)
			{
				header('location: inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
?>
<!---->
<?php
include '../View/headerAdmin.php';
?>
<div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
	echo "<font face= impact size=6> Bienvenid@ Administrador@ <br>".$usuario."</font><br>";
?>
    <p>Aquí podrás:</p>
    <ul>
        <li>Visualizar registros y sus datos basicos</li>
        <li>Buscar registros y modificar su información</li>
        <li>Agregar usuarios o cargos.</li>
        <li>Desactivar y activar usuarios.</li>
    </ul>
        </div>
		<div class="container_inicio">
    <a href="../Controller/registros.php">
    <div class="caja_Servicio" >
        <img  class="icono" src="../Img/registros.png" alt="">
        <p>Visualizar registros y actualizar información.</p>
    </div>
    </a>
    <div class="caja_Servicio" >
        <a href="../Controller/buscador.php">
        <img  class="icono" src="../Img/buscador.png" alt="">
        <p>Buscar y actualizar información.</p>
        </a>
    </div>
    <div class="caja_Servicio" >
        <a href="../Controller/crearUsuarios.php">
        <img  class="icono" src="../Img/newRol.png" alt="">
        <p>Agregar nuevo cargo</p>
        </a>
    </div>
    <div class="caja_Servicio" >
        <a href="../Controller/estado_usuario.php">
        <img  class="icono" src="../Img/cambioRol.png" alt="">
        <p>Activar/Desactivar cuenta de usuario.</p>
        </a>
    </div>
<body>
<!---->
<?php
    include_once '../View/footer.php';
?>
</body>
</html>
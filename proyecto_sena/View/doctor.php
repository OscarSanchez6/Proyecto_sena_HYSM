<?php
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
		if($_SESSION['rol'] !=1)
			{
				header('location: inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
?>


<html><head>
    <link rel="stylesheet" href="../Css/doctor.css">
</head>
<?php 
    include_once 'header_usuarios.php';
    ?>


<br><br><br><br><div id="containerBienvenida">
<?php
	$db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
	$usuario = $_SESSION['nombre'];	
echo "<font face= impact size=6> Bienvenid@  <br>".$usuario."</font><br>";
?>
    <p>Nos alegra verte en tu panel de salud personal</p>
    <p>Aquí podrás:</p>
    <ul>
        <li>Visualizar Datos de Usuarios</li>
        <li>Autorizar Exámenes Médicos</li>
        <li>Generar Historial Clinico</li>
        <li>Crear Historia Médica</li>
        <li>Autorizar Medicamentos</li>
    </ul>
    <p>Tu salud es nuestra prioridad. <br>No dudes en contactarnos si necesitas ayuda.</p>
        </div>

<div class="container">
    <div class="caja_Servicio" >
            <a href="../Controller/doctorTablaUsuarios.php">
                <img class="icono" src="../Img/562929.png" alt="">
            </a>
        
        <p>Usuarios</p>
    </div>

    <div class="caja_Servicio" >
            <a href="../Controller/doctorCitasMedicas.php">
                <img class="icono" src="../Img/citas.png" alt="">
            </a>
        
        <p>Citas Médicas</p>
    </div>
    
    <div class="caja_Servicio" >
            <a href="../Controller/medicoSeleccionHistoria.php">
                <img class="icono" src="../Img/historia.png" alt="">
            </a>
        
        <p>Historia Médica</p>
    </div>

    <div class="caja_Servicio" >
            <a href="../View/medicoSeleccionFormulas.php">
                <img class="icono" src="../Img/formulas.png" alt="">
            </a>
        
        <p>Fórmulas Médicas</p>
    </div>


    <div class="caja_Servicio" >
        <a href="../View/medicoSeleccionExamenes.php">
            <img  class="icono" src="../Img/93073.png" alt="">
        </a>
        <p>Exámenes Médicos</p>
    </div>

    <div class="caja_Servicio" >
        <a href="../Controller/medicoSeleccionIncapacidades.php">
            <img  class="icono" src="../Img/incapacidad.png" alt="">
        </a>
        <p>Incapacidades</p>
    </div>

    <?php
        if (isset($_GET['message'])){
        ?>
    <div class="alert alert-primary" role="alert"> 
        <?php
        switch ($_GET ['message']) {
            case 'success_password':
                echo
                "<p style='color: green;
                    font-weight: bold;
                    white-space: normal; /* Cambiado para que el texto no se trunque */
                    overflow: visible; /* Cambiado para mostrar todo el texto */
                    max-width: none; /* Eliminado para permitir el ancho completo */
                    text-align: center; 
                    margin-left: 10px; 
                    font-size: 14px; /* Ajusta el tamaño del texto según lo necesario */
                    padding: 10px; 
                    border: 1px solid green; 
                    background-color: #94e76e; 
                    border-radius: 3px; 
                    width: 100%; /* Asegura que el cuadro ocupe el ancho completo */
                    box-sizing: border-box;'>La contraseña fue actualizada con éxito</p>";
                break;
            default:
                echo "<p style='color: red;
                    font-weight: bold;
                    white-space: normal; /* Cambiado para que el texto no se trunque */
                    overflow: visible; /* Cambiado para mostrar todo el texto */
                    max-width: none; /* Eliminado para permitir el ancho completo */
                    text-align: center; 
                    margin-left: 10px; 
                    font-size: 14px; /* Ajusta el tamaño del texto según lo necesario */
                    padding: 10px; 
                    border: 1px solid red; 
                    background-color: #ffe6e6; 
                    border-radius: 3px; 
                    width: 100%; /* Asegura que el cuadro ocupe el ancho completo */
                    box-sizing: border-box;'>Algo salió mal, intenta de nuevo</p>";
                break;
        }
        ?>
    </div>
        <?php 
        }
        ?>
    </div>

<?php
        include_once '../View/footer.php';
?>
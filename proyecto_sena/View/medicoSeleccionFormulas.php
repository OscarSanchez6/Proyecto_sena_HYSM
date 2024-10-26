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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente - Health</title>
    <link rel="stylesheet" href="../Css/doctor.css">
</head>
    <body>
<?php 
    include_once 'header_usuarios.php';
?><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div class="containerSeleccionExamenes">
        
        <div class="caja_Servicio">
        <a href="../Controller/medicoRegistroFormulas.php">
            <img class="icono" src="../Img/doctorRegistrar.png" alt="">
        </a>
            <p>Registrar Fórmulas</p>
        </div>
        
        <div class="caja_Servicio">
        <a href="../Controller/doctorTablaFormulas.php">
            <img class="icono" src="../Img/verInfo.png" alt="">
        </a>
            <p>Visualizar Fórmulas Médicas</p>
        </div>

    </div><br><br><br><br><br><br><br><br><br><br>
    </body>
</html>
<?php
        include_once '../View/footer.php';
?>
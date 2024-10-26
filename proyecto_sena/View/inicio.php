<?php
include_once '../Model/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Health And Services Management</title>
    <link rel="stylesheet" href="../Css/inicio.css">
</head>
<body>
    <?php 
    include_once '../View/header.php';
    ?>
    <div id="containerBienvenida">
        <h1>Bienvenidos a Health And Services Management</h1>
        <h4>Buscas simplificar la experiencia de los usuarios en plataformas virtuales, y a su vez, optimizar las labores del personal médico mediante la automatización de procesos, entonces te encuentras en el lugar correcto.</h4>
        <div class="imagenbienvenida">
            <img src="../Img/OIP.jpg" alt="Hospital">
        </div>
    </div>

    <div id="containerBienvenida2">
    <h1>Atención Prioritaria:</h1>
        <h4>Identificación de pacientes con necesidades urgentes.
        Priorización en la entrega de insumos médicos y autorizaciones.</h4>
        <div class="imagenbienvenida2">
            <img src="../Img/image with pastel co (2).jpg" alt="Hospital">
        </div>
        <h4>Digitalización completa de los trámites administrativos.
        Automatización de procesos que reduce significativamente los tiempos de gestión. </h4>
    </div>

    <div id="containerBienvenida3">
    <h1>Algunas De Nuestras Características Són:</h1>
        <h4>Sistema intuitivo para la programación de citas.
        Notificaciones automáticas y recordatorios para pacientes y personal médico.</h4>
        <div class="imagenbienvenida2">
            <img src="../Img/imagenBienvenida2.jpg" alt="Hospital">
        </div>
        <h4>Digitalización completa de los trámites administrativos.
        Automatización de procesos que reduce significativamente los tiempos de gestión. </h4>
    </div>

    <div id="containerBienvenida4">
    <h1>Seguridad y Confidencialidad:</h1>
        <h4>Protección robusta de datos personales y médicos.</h4>
        <h4>Cumplimiento estricto de normativas de privacidad y seguridad de la información. </h4>
        <div class="imagenbienvenida4">
            <img src="../Img/imagen4.jpg" alt="Hospital">
        </div>
    </div>
        <?php
        include_once '../View/footer.php';
        ?>
</body>
</html>

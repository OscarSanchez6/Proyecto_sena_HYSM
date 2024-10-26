<?php
include_once '../Model/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quienes Somos.</title>
    <link rel="stylesheet" href="../Css/nuevo1.css">
</head>
<body>
<?php
include_once '../View/header.php';
?>
<section class="banner" id="home">
    <h2>Hacemos <span>más </span>por tu salud</h2>
</section>
<section class="sec" id="about">
    <div class="content">
        <div class="mxw800p">
            <div class="about-container">
                <div class="about-text">
                    <h3>Quiénes Somos</h3>  
                    <p>Health and Services Management es un aplicativo web enfocado a entidades prestadoras de salud (IPS-EPS) creado para mejorar significativamente la eficiencia y calidad de nuestros usuarios teniendo como principal objetivo simplificar la experiencia de los usuarios en plataformas virtuales, y a su vez, optimizar las labores del personal médico mediante la automatización de procesos.</p>
                    <a href="../View/contactanos.php" class="btn">Saber más</a>
                </div>
                <div class="about-image">
                    <img src="../Img/imagen5.png" alt="Quiénes Somos">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sec" id="services">
        <div class="content">
            <div class="mxw800p">
                <h3> Que hacemos </h3>
                <p>Nos dedicamos a desarrollar labores como agendamiento de citas medicas, aprobación de autorizaciones medicas, gestión de medicamentos, entre otras.Simplificar la experiencia de los usuarios en plataformas virtuales, y a su vez, optimizar las labores del personal médico mediante la automatización de procesos.
        </div>
        <div class="services">
            <div class="box">
                <div class="iconBx">
                    <img src="../Img/mision.png">
                </div>
                <div class="content">
                    <h2>Misión</h2>
                    <p>En Health and Services Management, nuestra misión es transformar la gestión de servicios dentro de las IPS mediante una plataforma 
                        tecnológica avanzada y accesible. Nos dedicamos a optimizar la experiencia del paciente y la eficiencia operativa en las instituciones de salud, 
                        facilitando la coordinación efectiva entre pacientes, profesionales de la salud y administradores.
                    </p>
                </div>
            </div>
            <div class="box">
                <div class="iconBx">
                    <img src="../Img/vision.png">
                </div>
                <div class="content">
                    <h2>Visión</h2>
                    <p>Nuestra visión es ser la plataforma de referencia en la gestión de servicios de salud para IPS a nivel nacional, estableciendo nuevos 
                        estándares en eficiencia y calidad de la atención médica. Buscamos liderar la innovación tecnológica en el sector, ofreciendo soluciones 
                        integradas que faciliten una experiencia de atención médica más fluida y conectada dentro de las instituciones de salud.
                    </p>
                </div>
            </div>    
            <div class="box">
                <div class="iconBx">
                    <img src="../Img/Beneficios.png">
                </div>
                <div class="content">
                    <h2>Beneficios</h2>
                    <p>1. Mejora la organización de citas, reduce el tiempo de gestión.<br>
                    2. Permite acceso rápido y actualizado a la información médica.<br>
                    3. Automatiza procesos repetitivos y reduce el riesgo de errores humanos.<br>
                    </p>
                </div>
            </div>        
        </div>
        <br><br><br><br><br><br><br><br>
</section>
    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header=document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY>0);
        })
    </script>
</body>
</html>
    <?php
        include_once '../View/footer.php';
    ?>
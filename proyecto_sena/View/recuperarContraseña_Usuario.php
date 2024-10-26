<?php
include_once '../Model/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../Css/inicio_Sesion_Usuario.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
</head>
<body>

<header>
<div class="logo">
            <img src="../Img/logo.png" alt="Logo Health and Services Management">
        </div>
        <nav>
            <ul>
                <li><a href="../View/usuario.php">Inicio</a></li>
                <li><a href="../Controller/cerrar.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div id="segundo">
        <h2>Recuperar Contraseña</h2>
        <form action="../Controller/recovery.php" method="POST">
        
            <label for="correo">Correo Electronico</label>
            <input type="email" id="email" name="email" placeholder= "Ingresa tu Correo Electronico" required><br>
            
            
            <button type="submit" value="recuperar" class="restablacerClave">Recuperar Contraseña</button><br><br>
                <a href="../Controller/recovery.php"></a>
                </form>
        <p id="loginMensaje">Ingresa el correo electronico registrado</p>
</div>

        <?php
        if (isset($_GET['message'])){
        ?>
    <div class="alert alert-primary" role="alert"> 
        <?php
        switch ($_GET ['message']) {
            case 'ok':
                echo 'Link de recuperacion enviado con exito';
                break;
            
            case 'No_encontrado':
                echo 'El correo electronico ingresado no coincide con ningun registro';
            break;

            case 'error':
                echo 'Algo salió mal, intenta de nuevo';
                break;
        }
        ?>
    </div>
        <?php 
        }
        ?>
        <?php
    include_once '../View/footer.php';
    ?>
</body>
</html>
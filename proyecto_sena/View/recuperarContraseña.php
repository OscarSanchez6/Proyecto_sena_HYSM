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
<?php
include_once '../View/headerInicioSesion.php';
?>
    <div id="segundo">
        <h2>Recuperar Contraseña</h2>
        <form action="../Controller/recovery.php" method="POST">
        
            <label for="correo">Correo Electronico</label>
            <input type="email" id="email" name="email" placeholder= "Ingresa tu Correo Electronico" required><br>
            
            
            <button type="submit" value="recuperar" class="restablacerClave">Recuperar Contraseña</button><br><br>
                <a href="../Controller/recovery.php"></a>
                </form>
        <p id="loginMensaje">Ingresa el correo electronico registrado</p>
        <?php
        if (isset($_GET['message'])){
        ?>
    <div class="alert alert-primary" role="alert"> 
        <?php
        switch ($_GET ['message']) {
            case 'ok':
                echo "<p style='color: green;
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
                    box-sizing: border-box;'>Link de recuperacion enviado con exito</p>";
                break;
            
            case 'No_encontrado':
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
                    box-sizing: border-box;'>El correo electrónico ingresado no coincide con ningún registro</p>";
                break;
                

            case 'error':
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
</body>
</html>
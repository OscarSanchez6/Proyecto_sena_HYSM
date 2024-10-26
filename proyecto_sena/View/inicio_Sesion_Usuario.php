<?php
include_once'../Model/conexionPDO.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio De Sesión</title>
    <link rel="stylesheet" href="../Css/inicio_Sesion_Usuario.css">
</head>
<body>
<?php
include_once '../View/headerInicioSesion.php';
?>
    <div id="loginContainer">
        <h2>Iniciar Sesión</h2>
        <form id="formulario_Login" action="#" method="POST">
        <label for="tipoRol">Tipo de Rol:</label>
            <select name="idRol" id="idRol" required>
            <option >Seleccione una opción</option>
            <option value="1">Médico</option>
            <option value="2">Administrador</option>
            <option value="3">Admisiones</option>
            <!--<option value="4">Prescriptor Medico</option>-->
            <option value="5">Paciente</option>
            </select><br>
            <span id="idRolError" class="errores"></span><br>

            <label for="tipoDocumento">Tipo de Documento:</label>
            <select name="tipoDocumento" id="tipoDocumento" required>
            <option >Seleccione una opción</option>
            <option value="1">Cédula De Ciudadanía</option>
            <option value="2">Cédula de Extrangería </option>
            <option value="3">Pasaporte</option>
            <option value="4">Tarjeta de Identidad</option>
            <option value="5">NUIP</option>
            <option value="6">Registro Civil</option>
            </select><br>
            <span id="tipoDocumentoError" class="errores"></span><br>

            <label for="numdocumento">Numero de Documento:</label>
            <input type="text" id="numdocumento" name="numdocumento" required placeholder="Ingrese su número de documento"><br>
            <span id="numdocumentoError" class="errores"></span><br>
            
            <label for="password">Contraseña:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required><br>
                <img src="../img/visible.png" alt="Mostrar contraseña" class="password" id="Password">
                
            </div><br>
            <span id="claveError" class="errores"></span><br>
            
            <button type="submit" value="Iniciar_Sesion" class="ingresar">Ingresar</button><br><br>
                <a href="Inicio.php"></a>
                <a href="recuperarContraseña.php" class="olvidar_Contrasena">Olvidaste tu Contraseña</a>
        </form>
        
        <p id="loginMensaje">Por favor, ingrese sus credenciales para acceder a su cuenta.</p>
        
    <?php
    include_once '../Controller/iniciar_sesion.php';
    ?>
        <?php
        if (isset($_GET['message'])){
        ?>
    <div class="alert alert-primary" role="alert"> 
        <?php
        switch ($_GET ['message']) {
            case 'success_password':
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
                    box-sizing: border-box;'>Inicia sesion con tu nueva contrasena</p>";
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
    <script src="../JS/Validacion_InicioSesion.js"></script>
    <script src="../JS/ver_contraseña.js"></script>
</body>
</html>

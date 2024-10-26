<?php
include_once '../Model/conexion.php';
?>
<!---->
<?php 
session_start();
if (!isset($_SESSION['rol']))
	{
		header('location: ../View/inicio_Sesion_Usuario.php');
		die(); exit();
	}
else
	{
		if($_SESSION['rol'] !=3)
			{
				header('location: ../View/inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../css/registrar_usuario.css">
    <link rel="icon" href="logo.ico" >
</head>
<body>
<?php include_once '../View/header_registrar_usuario.php'; ?>

<div id="containerBienvenida">
    <h2>Nos alegra verte en tu panel de registrar usuario.</h2>
    <p>Aquí podrás registrar usuario:</p>
    <p style='font-weight:bold;'>Accede al registro como nuevo usuario del hospital. Completa tus datos personales y de contacto para crear tu cuenta. Esto te permitirá gestionar tus citas médicas, acceder a tus historiales de salud y recibir notificaciones importantes.</p>
    <div class="foto-img">
        <img src="../Img/foto3.jpg" alt="Imagen del hospital">
    </div>
</div>

<div class="container">
    <h1>Registrar Usuario</h1>
    <form action="registrar_Usuario.php" method="POST">
        <label>Nombres:</label>
        <input type="text" name="nombre" required placeholder="Ingrese sus nombres completos" pattern="(?=.*[a-z])(?=.*[A-Z]).{4,20}" title="Utilice al menos una minúscula y una mayúscula."><br><br>

        <label>Primer Apellido:</label>
        <input type="text" id="primerApellido" name="primerApellido" required placeholder="Ingrese su primer apellido" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo deben contener letras y tener mínimo 4 caracteres."><br><br>

        <label>Segundo Apellido:*</label>
        <input type="text" id="segundoApellido" name="segundoApellido" placeholder="Ingrese su segundo apellido" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo deben contener letras y tener mínimo 4 caracteres."><br><br>

        <label>Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required placeholder="Ingrese una contraseña" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener tanto letras como números."><br><br>

        <!-- Hidden field to assign role as "Usuario" -->
        <input type="hidden" id="rol" name="rol" value="5">

        <label>Fecha de Nacimiento:</label>
        <input type="date" id="fechaDeNacimiento" name="fechaDeNacimiento" required><br><br>

        <label>Edad:</label>
        <input type="number" id="edad" name="edad" required readonly><br><br>

        <label>Tipo de Documento:</label>
        <select id="tipoDeDocumento" name="tipoDeDocumento" required>
            <option value="0">Seleccione una opción</option>
            <option value="1">Cédula de Ciudadanía</option>
            <option value="2">Cédula de Extranjería</option>
            <option value="3">Pasaporte</option>
            <option value="4">Tarjeta de Identidad</option>
            <option value="5">NUIP</option>
        </select><br><br>

        <label>Número de Documento:</label>
        <input type="number" id="numeroDeDocumento" name="numeroDeDocumento" required placeholder="Digite su número de documento"><br><br>

        <label>Correo Electrónico:</label>
        <input type="email" id="correoElectronico" name="correoElectronico" required placeholder="Digite su correo electrónico" title="Recuerda agregar el arroba a tu correo."><br><br>

        <label>Teléfono:</label>
        <input type="number" id="telefono" name="telefono" required placeholder="Digite su número telefónico"><br><br>

        <label>Dirección:</label>
        <input type="text" id="direccion" name="direccion" required placeholder="Digite su dirección de residencia"><br><br>

        <button class="btn" type="submit" name="btnregistrar">Registrar</button>
        <p id="loginMensaje">Por favor, ingrese los datos completos para registrar el usuario correctamente.</p>

        <?php
        if (isset($_POST['btnregistrar'])) {
            $nombre = $_POST['nombre'];
            $primerApellido = $_POST['primerApellido'];
            $segundoApellido = $_POST['segundoApellido'];
            $contraseña = $_POST['contraseña'];
            $rol = 5; // Automatically set role to "Usuario"
            $fechaDeNacimiento = $_POST['fechaDeNacimiento'];
            $tipoDeDocumento = $_POST['tipoDeDocumento'];
            $numeroDeDocumento = $_POST['numeroDeDocumento'];
            $correoElectronico = $_POST['correoElectronico'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $repetido = "SELECT * FROM crear_usuario WHERE correo='$correoElectronico' OR numero_documento='$numeroDeDocumento'";
            $resultado = mysqli_query($conexion, $repetido);

            if (mysqli_num_rows($resultado) > 0) {
                echo '<p style="color:red; text-align:center;">¡Ya existe un usuario con ese correo electrónico o número de documento!</p>';
            } else {
                $insertar = "INSERT INTO crear_usuario (nombre, apellido1, apellido2, contrasena, rol, fecha_nacimiento, tipo_documento_id, numero_documento, correo, telefono, direccion)
                             VALUES ('$nombre', '$primerApellido', '$segundoApellido', '$contraseña', '$rol', '$fechaDeNacimiento', '$tipoDeDocumento', '$numeroDeDocumento', '$correoElectronico', '$telefono', '$direccion')";
                $ejecutar = mysqli_query($conexion, $insertar);

                if ($ejecutar) {
                    echo '<p style="color:grey; font-size:24px; text-align:center;">El usuario ha sido registrado con éxito.</p>';
                } else {
                    echo '<script>alert("Error al ingresar el registro");</script>';
                }
            }
        }
        ?>
    </form>
</div>

<?php include_once '../View/footer.php'; ?>
<script src="../JS/edad.js"></script>
</body>
</html>

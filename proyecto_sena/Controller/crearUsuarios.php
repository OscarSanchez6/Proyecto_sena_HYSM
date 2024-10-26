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
		if($_SESSION['rol'] !=2)
			{
				header('location: ../View/inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
?>
<!---->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administrador</title>
	<link rel="stylesheet" href="../Css/registro.css">
	<header>
    <a href="../View/Administrador.php">
        <div class="logo">
            <img src="../Img/logo.png" alt="Logo Health and Services Management">
        </div>
        </a>
        <nav>
            <ul>
                <li><a href="../View/Administrador.php">Inicio</a></li>
                <li><a href="../Controller/buscador.php">Buscar usuarios</a></li>   
				<li><a href="../Controller/cerrar.php">Cerrar sesión</a></li>

            </ul>
        </nav>
    </header>
</head>
<body>
<div id="loginContainer">
    <h2 align="center">Registro de  <br>usuarios</h2>
    <label > Datos Opcionales (*)</label><br><br>
    <form action="crearUsuarios.php" method="POST">
        <label>Nombres:</label>
        <input type="text" name="nombre" required placeholder="Ingrese sus nombres completos" size="30" pattern="(?=.*[a-z])(?=.*[A-Z]).+{4,20}" title="Utilice al menos una minúscula y una mayúscula."><br><br>

        <label>Primer Apellido:</label>
        <input type="text" id="primerApellido" name="primerApellido" required placeholder="Ingrese su primer apellido" size="30" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo debén contener letras y tener minimo 4."><br><br>
        
        <label>Segundo Apellido:*</label>
        <input type="text" id="segundoApellido" name="segundoApellido"  placeholder="Ingrese su segundo apellido" size="30" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo debén contener letras y tener minimo 4."><br><br>
        
        <label>Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required placeholder="Ingrese una contraseña" size="30" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener tanto letras como números." ><br><br>
        
        <label>Rol:</label>
        <select id="rol" name="rol" required placeholder="seleccione el Rol a desempeñar">
            <option value="0">Seleccione una opción</option>
            <option value="2">Administrador</option>
            <option value="5">Usuario</option>
            <option value="3">Recepción</option>
            <option value="1">Doctor</option>
            <option value="4">Prescriptor Medico</option>
        </select><br><br>

        <label>Género:</label>
        <select id="sexo" name="sexo" required placeholder="seleccione su Genero">
            <option value="0">Seleccione una opción</option>
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
        </select><br><br>

        <label>Fecha de nacimiento:</label>
        <input type="date" id="fechaDeNacimiento" name="fechaDeNacimiento" required placeholder="Seleccione su fecha de nacimiento"><br><br>

        <label>Edad:</label>
        <input type="number" id="edad" name="edad" required placeholder="Digite su Edad" title="Digite su edad en números únicamente" readonly><br><br>

        <label>Tipo de documento:</label>
        <select id="tipoDeDocumento" name="tipoDeDocumento" required>
            <option value="0">Seleccione una opción</option>
            <option value="1">Cedula de Ciudadania</option>
            <option value="2">Cedula de Extranjeria</option>
            <option value="3">Pasaporte</option>
            <option value="4">Tarjeta de Identidad</option>
            <option value="5">NUIP</option>
        </select><br><br>

        <label>Número de Documento:</label>
        <input type="number" id="numeroDeDocumento" name="numeroDeDocumento" required placeholder="Digite su Número de Documento"><br></br>

        <label>Correo Electrónico</label>        
        <input type="email" id="correoElectronico" name="correoElectronico" required placeholder="Digite su correo electrónico" title="Recuerda agregar el arroba a tu correo."><br><br>

        <label>Teléfono:</label>
        <input type="number" id="telefono" name="telefono" required placeholder="Digite su número telefónico" title="Digite solo números únicamente"><br><br>

        <label>Dirección:</label>
        <input type="text" id="Direccion" name="direccion" required placeholder="Digite su dirección de residencia"><br><br>

        <button class="btn" type="submit" name="btnregistrar">Registrar</button>
        <p id="loginMensaje">Por favor, ingrese los datos completos para registrar el usuario correctamente.</p>
<!---->
<?php
        if (isset($_POST['btnregistrar']))
        {
            $nombre=$_POST['nombre'];
            $primerApellido=$_POST['primerApellido'];
            $segundoApellido=$_POST['segundoApellido'];
            $contraseña=$_POST['contraseña'];
            $rol=$_POST['rol'];
            $edad=$_POST['edad'];
            $sexo=$_POST['sexo'];
            $fechaDeNacimiento=$_POST['fechaDeNacimiento'];
            $tipoDeDocumento=$_POST['tipoDeDocumento'];
            $numeroDeDocumento=$_POST['numeroDeDocumento'];
            $correoElectronico=$_POST['correoElectronico'];
            $telefono=$_POST['telefono'];
            $direccion=$_POST['direccion'];

            $repetido="SELECT * FROM crear_usuario where  correo='$correoElectronico' or numero_documento='$numeroDeDocumento'";
            $resultado= mysqli_query($conexion,$repetido);//una la conexion y la otra la consulta
            if(mysqli_num_rows($resultado)>0)
            {
                echo '<p style="color:red; font-size:20px;text-align:center">!Ya existe un rol con ese  correo electronico o numero de documento</p><br>';
            }
            else
            {
                $insertar="INSERT INTO crear_usuario(nombre,apellido1,apellido2,contrasena,rol,edad,sexo,fecha_nacimiento,tipo_documento_id,numero_documento,correo,telefono,direccion) values ('$nombre','$primerApellido','$segundoApellido','$contraseña','$rol','$edad','$sexo','$fechaDeNacimiento','$tipoDeDocumento','$numeroDeDocumento','$correoElectronico','$telefono','$direccion')";
                $ejecutar=mysqli_query($conexion,$insertar);
                if($ejecutar)
                {
                    echo'<p style="color:grey; font-size:24px; text-align:center; margin: left 15px; padding:10px;"><strong>El Usuario a sido Registrado con Exito</strong></p><br>';
                }
                else
                {
                    echo'<script>alert("Error al ingresar el registro");</script>';
                }
            }
        }
        ?>
<!---->
</form>
    </div>
    <?php
    include_once '../View/footer.php';
    ?>
    <script src="../JS/edad.js"></script>
</body>
</html>
<?php
    include_once '../View/headerAdmin.php';
?>
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
    <body>
        <h1 align="center">Registros</h1>
<!---->
<?php
include_once '../Model/conexionPDO.php';// Incluye el archivo de conexión
?>
<?php
try {
    $db = new Database(); // Crea una instancia de la clase Database
    $conexion = $db->connectar(); // Obtiene la conexión PDO
    $observar = "SELECT crear_usuario.id_usuario,
    crear_usuario.nombre,
    crear_usuario.apellido1,
    crear_usuario.apellido2,
    crear_usuario.contrasena,
    tipo_documento.Documento AS tipo_documento_id,
    crear_usuario.numero_documento,
    crear_usuario.correo,
    crear_usuario.telefono,
	status,
    tabla_roles.Roles AS rol
    FROM crear_usuario
    JOIN tabla_roles ON crear_usuario.rol = tabla_roles.id_tipo_Rol
    JOIN tipo_documento ON  crear_usuario.tipo_documento_id = tipo_documento.id_tipo_documento;";   

    $statement = $conexion->query($observar);
    if ($statement) {// Verifica si la consulta se ejecutó correctamente
        echo '<table border="3" align="center">
            <tr>	
                <th>ID</th>
                <th>NOMBRE</th>
                <th>APELLIDO 1</th>
                <th>APELLIDO 2</th>
                <th>CARGOS</th>
                <th>TIPO DE DOCUMENTO</th>
                <th>NUMERO DE DOCUMENTO</th>
                <th>EMAIL</th>
                <th>TELEFONO</th>


                <th>EDITAR</th>
                <th>ESTADO</th>
            </tr>';

        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
           
            $id 		= $filas['id_usuario'];
            $usuario 	= $filas['nombre'];
            $apellido1	= $filas['apellido1'];
            $apellido2 	= $filas['apellido2'];
            $idrol 		= $filas['rol'];
            $tipoDocumento = $filas['tipo_documento_id'];
            $numeroDocumento = $filas['numero_documento'];
            $email 		= $filas['correo'];
            $telefono 	= $filas['telefono'];
			$buttonColor = $filas['status'] ? 'green' : 'red';// Cambia el color y texto del botón según el estado del usuario
    		$buttonText = $filas['status'] ? 'Activado' : 'Desactivado';

             

            echo '<tr align="center">
            <td data-label="ID">' . $id . '</td>
            <td data-label="Nombre">' . $usuario . '</td>
            <td data-label="Apellido1">' . $apellido1 . '</td>
            <td data-label="Apellido2">' . $apellido2. '</td>
            <td data-label="Rol">' . $idrol . '</td>
            <td data-label="Tipo de Documento">' . $tipoDocumento . '</td>
            <td data-label="Número de Documento">' . $numeroDocumento . '</td>
            <td data-label="Email">' . $email . '</td>
            <td data-label="Teléfono">' . $telefono . '</td>

            <td data-label="Editar"><a href="../Controller/registros.php?editar=' . $id . '">Editar</a></td>';
 			

   			echo '<td data-label="Estado">
       		 <button style="background-color: ' . $buttonColor . '; color: white;">
            <a href="../Controller/registros.php?desactivar=' . $id . '" style="color: white; text-decoration: none;">
                ' . $buttonText . '
            </a>
        </button>
    </td>
</tr>';
        }
       echo '</table><br><br>';
    } 
    else 
    {   echo 'Error en la consulta.';
    }
} 
catch (PDOException $e) 
	{   die("Error en conexión a la base de datos: " . $e->getMessage());
	}
?>
<!---->
<?php
if(isset($_GET['editar']))
	{
	try 
		{
		$editar_id = $_GET['editar'];
	    $db = new Database(); // Crea una instancia de la clase Database
	    $conexion = $db->connectar(); // Obtiene la conexión PDO
	    $observar = "SELECT crear_usuario.id_usuario,
    crear_usuario.nombre,
    crear_usuario.apellido1,
    crear_usuario.apellido2,
    crear_usuario.contrasena,
    tipo_documento.Documento AS tipo_documento_id,
    crear_usuario.numero_documento,
    crear_usuario.correo,
    crear_usuario.telefono,
	status,
    tabla_roles.Roles AS rol
    FROM crear_usuario
    JOIN tabla_roles ON crear_usuario.rol = tabla_roles.id_tipo_Rol
    JOIN tipo_documento ON  crear_usuario.tipo_documento_id = tipo_documento.id_tipo_documento
    WHERE id_usuario = '$editar_id'";
	    $statement = $conexion->query($observar);
	    if ($statement)// Verifica si la consulta se ejecutó correctamente
		    {
	        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) 
		        {
        			$id = $filas['id_usuario'];
                    $usuario = $filas['nombre'];
                    $apellido1= $filas['apellido1'];
                    $apellido2 = $filas['apellido2'];
                    $idrol = $filas['rol'];
                    $tipoDocumento = $filas['tipo_documento_id'];
                    $numeroDocumento = $filas['numero_documento'];
                    $email = $filas['correo'];
                    $telefono = $filas['telefono'];
		        }
			} 
		else 
			{ echo 'Error en la consulta.';
			} 
		} 
	catch (PDOException $e) 
		{  die("Error en conexión a la base de datos: " . $e->getMessage());
		}
?>
	<tr>
		<td>
<div align="center">
<div class="form-container">
    <form method="POST" action="#">
        <div class="form-group">
            <label for="usuario">Nombre</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" placeholder="Ingrese su nombre">
        </div>
        
        <div class="form-group">
            <label for="apellido1">Primer Apellido</label>
            <input type="text" id="apellido1" name="apellido1" value="<?php echo $apellido1; ?>" placeholder="Ingrese su primer apellido">
        </div>
        
        <div class="form-group">
            <label for="apellido2">Segundo Apellido</label>
            <input type="text" id="apellido2" name="apellido2" value="<?php echo $apellido2; ?>" placeholder="Ingrese su segundo apellido">
        </div>
        
        <div class="form-group">
            <label for="idrol">Rol:<?php echo $idrol; ?></label>
            <select id="idrol" name="idrol" required>
                            <option value="1">Medico</option>
                            <option value="2">Administrador</option>
                            <option value="3">Recepcion</option>
                            <option value="5">Usuario</option>
            </select>
        </div>
        
        
        <div class="form-group">
            <label for="tipoDocumento">Tipo de Documento:<?php echo $tipoDocumento; ?></label>
            <select id="tipoDocumento" name="tipoDocumento" required>
                            <option value="1">Cédula de Ciudadanía</option>
                            <option value="2">Cédula de Extranjería</option>
                            <option value="3">Pasaporte</option>
                            <option value="4">Tarjeta de Identidad</option>
                            <option value="5">NUIP</option>
                            <option value="6">Registro Civil</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="numeroDocumento">Número de Documento</label>
            <input type="text" id="numeroDocumento" name="numeroDocumento" value="<?php echo $numeroDocumento; ?>" placeholder="Ingrese número de documento">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Ingrese su correo electrónico">
        </div>
        
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>" placeholder="Ingrese su teléfono">
        </div>
        
        <button type="submit" name="actualizame" class="form-submit">Actualizar Datos</button>
    </form>

	<!---->
<?php
unset($_POST['editar']);//no es necesario usar unset($_POST['editar']); Los datos POST se enviarán solo cuando el formulario se envía, por lo que no necesitas eliminarlos manualmente.
  }
?>
<?php
if(isset($_POST['actualizame']))
	{
	$actualizausuario = $_POST['usuario'];
    $actualizaapellido1 = $_POST['apellido1'];
    $actualizaapellido2 = $_POST['apellido2'];
    $actualizarol   = $_POST['idrol'];
    $actualizatipodocumento   = $_POST['tipoDocumento'];
    $actualizanumdocumento  = $_POST['numeroDocumento'];
	$actualizaemail   = $_POST['email'];

	try {
	    $db = new Database(); 
	    $conexion = $db->connectar(); 
	    $observar = "UPDATE crear_usuario SET nombre = '$actualizausuario',apellido1 = '$actualizaapellido1',apellido2= '$actualizaapellido2',rol = '$actualizarol',
        tipo_documento_id = '$actualizatipodocumento',numero_documento = '$actualizanumdocumento',correo = '$actualizaemail'  WHERE id_usuario = '$editar_id'";

	    $ejecutar = $conexion->query($observar);
		    if ($ejecutar) {
                echo '<p style="color:green;font-size:30px;text-align:center;">Actualización exitosa.</p>';
            } else {
                echo '<p style="color:red;font-size:20px;text-align:center;">Error al actualizar el registro</p>';
            }
		} 
	catch (PDOException $e) 
		{
		    die("Error en conexión a la base de datos: " . $e->getMessage());
		}
	}			
?>
	</div><!---->
<?php
// activación y desactivación de usuario

if(isset($_GET['desactivar'])) {
    try {
        $desactivar_id = $_GET['desactivar'];
        $db = new Database(); // Crea una instancia de la clase Database
        $conexion = $db->connectar(); // Obtiene la conexión PDO

        // Obtener el estado actual del usuario
        $query = $conexion->prepare("SELECT status FROM crear_usuario WHERE id_usuario = :desactivar_id");
        $query->bindParam(':desactivar_id', $desactivar_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $currentStatus = $result['status'];

        // Alternar el estado del usuario
        $newStatus = $currentStatus ? 0 : 1;

        // Preparar la consulta para actualizar el estado
        $desactivar = $conexion->prepare("UPDATE crear_usuario SET status = :new_status WHERE id_usuario = :desactivar_id");
        $desactivar->bindParam(':new_status', $newStatus, PDO::PARAM_INT);
        $desactivar->bindParam(':desactivar_id', $desactivar_id, PDO::PARAM_INT);

        // Ejecutar la consulta
        if($desactivar->execute()) {
            echo '<p style="color:green;font-size:30px;text-align:center;">' . ($newStatus ? 'Activo' : 'Inactivo') . ' exitosa.</p>';
        } else {
            echo '<p style="color:red;font-size:20px;text-align:center;">Error al cambiar el estado del usuario.</p>';
        }
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
}

?>
<!---->
<?php
    include_once '../View/footer.php';
?>
</body>
</html>
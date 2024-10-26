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
        <h1 align="center">Estado de usuarios</h1>
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
                
                <th>ESTADO</th>
            </tr>';

        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
           
            $id 		= $filas['id_usuario'];
            $usuario 	= $filas['nombre'];
            $apellido1	= $filas['apellido1'];
            $apellido2 	= $filas['apellido2'];
            $idrol 		= $filas['rol'];
			$buttonColor = $filas['status'] ? 'green' : 'red';// Cambia el color y texto del botón según el estado del usuario
    		$buttonText = $filas['status'] ? 'Activado' : 'Desactivado';

             

            echo '<tr align="center">
            <td data-label="ID">' . $id . '</td>
            <td data-label="Nombre">' . $usuario . '</td>
            <td data-label="Apellido1">' . $apellido1 . '</td>
            <td data-label="Apellido2">' . $apellido2. '</td>
            <td data-label="Rol">' . $idrol . '</td>';
 			

   			echo '<td data-label="Estado">
       		 <button style="background-color: ' . $buttonColor . '; color: white;">
            <a href="../Controller/estado_usuario.php?desactivar=' . $id . '" style="color: white; text-decoration: none;">
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
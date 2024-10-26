<?php
include_once '../Model/conexionPDO.php';
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}
$doctorId = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examenes</title>
    <link rel="stylesheet" href="../Css/doctorExamenes.css">
    <link rel="stylesheet" href="../Css/doctor.css">
</head>
<body>
<?php 
    include_once '../View/header_usuarios.php';
    ?>
    <?php
            $db = new Database();
            $conexion = $db->connectar();
            $buscarUsuario = "SELECT  cu.id_usuario, CONCAT(cu.nombre, ' ', cu.apellido1, ' ', cu.apellido2) AS usuario
            FROM crear_usuario cu
            JOIN citas_medicas cm ON cu.id_usuario = cm.id_usuario
            WHERE cu.rol = 5
            AND cm.doctor_asignado = :doctorId";
            $statement = $conexion->prepare($buscarUsuario);
            $statement->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
            $statement->execute();
            
            $usuarios = $statement->fetchAll(PDO::FETCH_ASSOC);

            $prueba = 'SELECT id_Examenes, Examen AS descripcion FROM examenes_medicos';
            $stmtPrueba = $conexion->prepare($prueba);
            $stmtPrueba->execute();
            $pruebas = $stmtPrueba->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="loginContainer">
    <h2 align="center">Registro de  <br>Examenes</h2>
    <form action="#" method="POST" enctype="multipart/form-data">


        <label>Usuario</label>
        <select id="idUsuario" name="idUsuario" required placeholder="Seleccione el usuario"><br><br>
        <option value="">Seleccione un Usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                            <?php echo htmlspecialchars($usuario['usuario']); ?>
                        </option>
                    <?php endforeach; ?>
        </select><br><br>

        <label>Tipo de prueba</label>
        <select id="tipoPrueba" name="tipoPrueba" required placeholder="Seleccione el tipo de prueba realizado">
        <option value="">Seleccione una Prueba</option>
                    <?php foreach ($pruebas as $prueba): ?>
                        <option value="<?php echo htmlspecialchars($prueba['id_Examenes']); ?>">
                            <?php echo htmlspecialchars($prueba['descripcion']); ?>
                        </option>
                    <?php endforeach; ?>

            
        </select><br><br>

        <label>Resultados</label>
        <input type="file" id="pdf" name="pdfs" accept=".pdf" required><br><br>

        <label>Informacion Adicional del Paciente</label>
        <input type="text" id="paciente" name="paciente" required placeholder="Ingrese informacion adicional"><br><br>

        <label for="fecha_hora">Fecha y Hora:</label>
        <input type="datetime-local" id="fecha_hora" name="fecha_hora" required><br><br>

        <label>Datos del Hospital</label>
        <input type="text" id="hospital" name="hospital" required placeholder="Ingrese el nombre del hospital"><br><br>

        <label>Diagnostico</label>
        <input type="text" id="diagnostico" name="diagnostico" required placeholder="Ingrese el diagnostico con base a los resultados"><br><br>

        <label>Tratamientos</label>
        <input type="text" id="tratamientos" name="tratamientos" required placeholder="Ingrese el tratamiento a ejecutar"><br></br>

        <button class="btn" type="submit" name="btnexamenes">Ingresar Datos</button>
        

        <?php
        if (isset($_POST['btnexamenes'])) {
            $usuario = $_POST['idUsuario'];
            $tipoPrueba = $_POST['tipoPrueba'];
            $informacionAdicional = $_POST['paciente'];
            $fechaHora = $_POST['fecha_hora'];
            $hospital = $_POST['hospital'];
            $diagnostico = $_POST['diagnostico'];
            $tratamientos = $_POST['tratamientos'];
        
            if (isset($_FILES['pdfs']) && $_FILES['pdfs']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['pdfs']['tmp_name'];
                $fileName = $_FILES['pdfs']['name'];
                $fileSize = $_FILES['pdfs']['size'];
                $fileType = $_FILES['pdfs']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = './uploads/';
                $dest_path = $uploadFileDir . $newFileName;
        
                // En esta parte se mueve el archivo cargado al directorio de destino
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $resultados = $newFileName;
                } else {
                    die("Error al mover el archivo al directorio de destino.");
                }
            } else {
                die("Error en la carga del archivo.");
            }
            
            try{

                    $db = new Database(); 
                    $conexion = $db->connectar();
                    $query = "INSERT INTO examenes (usuario, tipo_De_Pruebas, resultados, información_Paciente, fecha_hora, datos_Hospital, diagnostico,tratamiento, doctor_encargado) 
                            values (:idUsuario, :tipoPrueba, :pdfs, :paciente, :fecha_hora, :hospital, :diagnostico, :tratamientos, :doctorId)";
                    
                    $insertar = $conexion->prepare($query);
                    $insertar->bindParam(':idUsuario', $usuario);
                    $insertar->bindParam(':tipoPrueba', $tipoPrueba);
                    $insertar->bindParam(':pdfs', $resultados);
                    $insertar->bindParam(':paciente', $informacionAdicional);
                    $insertar->bindParam(':fecha_hora', $fechaHora);
                    $insertar->bindParam(':hospital', $hospital);
                    $insertar->bindParam(':diagnostico', $diagnostico);
                    $insertar->bindParam(':tratamientos', $tratamientos);
                    $insertar->bindParam(':doctorId', $doctorId);
                    
        
	        if ($insertar->execute() > 0) 
		        {	echo "<p style='color:black; text-align:center; margin-left: 30px; font-size:15px;background-color: bisque; padding: 10px; border: none; border-radius: 4px;'>Los datos fueron registrados con exito</p>";//header("location: administrador.php");
				 	echo "<script> window.open('doctorExamenes.php')  </script> ";
		        } else {   
                                echo "<p style='color:red; text-align:center; margin-left: 30px; font-size:30px;'>Error al Registrar al Usuario.</p>";
		        }
			}catch (PDOException $e) {   
                die("Error en la inserción: " . $e->getMessage());
	    }	
    }		
        ?>
    </form>
    
    </div><br><br><br>
    <?php
    include_once '../View/footer.php';
    ?>
    <script src="../JS/edad.js"></script>
</body>
</html>

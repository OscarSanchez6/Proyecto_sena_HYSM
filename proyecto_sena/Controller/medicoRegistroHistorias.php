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
    <title>Historia</title>
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
            $buscarUsuario = 'SELECT cu.id_usuario, CONCAT(cu.nombre, " ", cu.apellido1, " ", cu.apellido2) AS usuario
            FROM crear_usuario cu
            JOIN citas_medicas cm ON cu.id_usuario = cm.id_usuario
            WHERE cu.rol = 5
            AND cm.doctor_asignado = :doctorId';

            $stmtUsuario = $conexion->prepare($buscarUsuario);
            $stmtUsuario->bindParam(':doctorId', $doctorId, PDO::PARAM_INT); // Asegúrate de tener el ID del doctor en $doctorId
            $stmtUsuario->execute();
            $usuarios = $stmtUsuario->fetchAll(PDO::FETCH_ASSOC);

            $prueba = 'SELECT id_Examenes, Examen AS descripcion FROM examenes_medicos';
            $stmtPrueba = $conexion->prepare($prueba);
            $stmtPrueba->execute();
            $pruebas = $stmtPrueba->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="loginContainer">
    <h2 align="center">Registro de  <br>Historia Clinica</h2>
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

        <label>Pruebas Realizadas</label>
        <input type="text" id="pruebas" name="pruebas" required placeholder="Ingrese la prueba realizada"><br><br>
        
        <label>Historial de Cirugias</label>
        <input type="text" id="cirugias" name="cirugias" placeholder="Ingrese las cirugias realizadas"><br><br>
        
        <label>Medicamentos consumidos con anterioridad</label>
        <input type="text" id="medicamentos" name="medicamentos" required placeholder="Ingrese los medicamentos recetados"><br><br>
        
        <label>Resultados</label>
        <input type="file" id="pdf" name="pdfs" accept=".pdf" required title="Se debe ingresar un archivo pdf"><br><br>
        
        <label>Tratamientos</label>
        <input type="text" id="tratamientos" name="tratamientos" required placeholder="Ingrese los tratamientos indicados"><br><br>
        
        <label>Procesos de Salud Adicionales</label>
        <input type="text" id="procesos" name="procesos" placeholder="Ingrese si hay algun proceso de salud adicional "><br><br>
        
        <label>Diagnostico</label>
        <input type="text" id="diagnostico" name="diagnostico" required placeholder="Ingrese un diagnostico general"><br><br>
        
        <label>Tratamientos Quirurgicos</label>
        <input type="text" id="tquirurgicos" name="tquirurgicos" placeholder="Ingrese tratamientos quirurgicos "><br><br>
        
        <label>Hospitalizaciones</label>
        <input type="text" id="hospitalizaciones" name="hospitalizaciones" placeholder="Ingrese si ha tenido alguna hospitalizacion"><br><br>
        
        <label>Formulas</label>
        <input type="text" id="formulas" name="formulas" placeholder="Ingrese las formulas recetadas"><br><br>

        <label>Alergias</label>
        <input type="text" id="alergias" name="alergias" placeholder="Ingrese si posee un tipo de alergias"><br><br>

        <label for="fecha_hora">Fecha y Hora:</label>
        <input type="datetime-local" id="fecha_hora" name="fecha_hora" required><br><br>

        <label>Lugar-Hospital</label>
        <input type="text" id="lugar" name="lugar" required placeholder="Ingrese el hospital o el lugar"><br><br>

        <button class="btn" type="submit" name="btnhistoria">Ingresar Datos</button>
        

        <?php
        if (isset($_POST['btnhistoria'])) {
            $usuario = $_POST['idUsuario'];
            $tipoPrueba = $_POST['pruebas'];
            $cirugias = $_POST['cirugias'];
            $medicamentos = $_POST['medicamentos'];
            $tratamientos = $_POST['tratamientos'];
            $procesos = $_POST['procesos'];
            $diagnostico=$_POST['diagnostico'];
            $tratamientosQuirurgicos = $_POST['tquirurgicos'];
            $hospitalizaciones = $_POST['hospitalizaciones'];
            $formulas = $_POST['formulas'];
            $alergias = $_POST['alergias'];
            $fechaHora = $_POST['fecha_hora'];
            $lugar = $_POST['lugar'];
        
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
                    $query = "INSERT INTO historia_medica (usuario, pruebas_Realizada, cirugias, medicamentos_Recetados, análisis_Realizados, tratamientos, 
                    procesos, diagnostico, Tratamientos_Quirurgicos, Hospitalizaciones, formulas, alergias, fecha_hora, lugar) 
                            values (:idUsuario, :pruebas, :cirugias, :medicamentos, :pdfs, :tratamientos, :procesos, :diagnostico,:tquirurgicos, :hospitalizaciones, 
                            :formulas, :alergias, :fecha_hora, :lugar)";
                    
                    $insertar = $conexion->prepare($query);
                    $insertar->bindParam(':idUsuario', $usuario);
                    $insertar->bindParam(':pruebas', $tipoPrueba);
                    $insertar->bindParam(':cirugias', $cirugias);
                    $insertar->bindParam(':medicamentos', $medicamentos);
                    $insertar->bindParam(':pdfs', $resultados);
                    $insertar->bindParam(':diagnostico', $tratamientos);
                    $insertar->bindParam(':tratamientos', $tratamientos);
                    $insertar->bindParam(':procesos', $procesos);
                    $insertar->bindParam(':diagnostico', $diagnostico);
                    $insertar->bindParam(':tquirurgicos', $tratamientosQuirurgicos);
                    $insertar->bindParam(':hospitalizaciones', $hospitalizaciones);
                    $insertar->bindParam(':formulas', $formulas);
                    $insertar->bindParam(':alergias', $alergias);
                    $insertar->bindParam(':fecha_hora', $fechaHora);
                    $insertar->bindParam(':lugar', $lugar);
                    
        // Ejecutar la sentencia
        
	        if ($insertar->execute() > 0) 
		        {	echo "<p style='color:black; text-align:center; margin-left: 30px; font-size:15px;background-color: bisque; padding: 10px; 
                    border: none; border-radius: 4px;'>Los datos fueron registrados con exito</p>";//header("location: administrador.php");
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
</body>
</html>

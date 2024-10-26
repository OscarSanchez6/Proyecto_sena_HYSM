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
    <title>Formulas</title>
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
    ?>

    <div id="loginContainer">
    <h2 align="center">Registro de  <br>Incapacidades</h2>
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

        <label>Motivos</label>
        <input type="text" id="motivos" name="motivos" required placeholder="Ingrese los motivos"><br><br>

        <label>Fecha de Inicio</label>
        <input type="date" id="fFormulacion" name="fFormulacion" required><br><br>

        <label>Fecha de Terminacion</label>
        <input type="date" id="fVencimiento" name="fVencimiento" required><br><br>

        <label>Recomendaciones o Medicamentos</label>
        <input type="text" id="recomendaciones" name="recomendaciones" required placeholder="Ingrese recomendaciones o medicamentos necesarios"><br><br>

        <button class="btn" type="submit" name="btnincapacidades">Ingresar Datos</button>
        

        <?php
        if (isset($_POST['btnincapacidades'])) {
            $usuario = $_POST['idUsuario'];
            $motivos = $_POST['motivos'];
            $inicio = $_POST['fFormulacion'];
            $terminacion = $_POST['fVencimiento'];
            $recomendaciones = $_POST['recomendaciones'];
            
            try{

                    $db = new Database(); 
                    $conexion = $db->connectar();
                    $query = "INSERT INTO incapacidades (id_usuario, motivos, fecha_inicio, fecha_fin, doctor_encargado, recomendaciones_medicamentos) 
                            values (:idUsuario, :motivos, :fFormulacion, :fVencimiento, :doctorId, :recomendaciones)";
                    
                    $insertar = $conexion->prepare($query);
                    $insertar->bindParam(':idUsuario', $usuario);
                    $insertar->bindParam(':motivos', $motivos);
                    $insertar->bindParam(':fFormulacion', $inicio);
                    $insertar->bindParam(':fVencimiento', $terminacion);
                    $insertar->bindParam(':doctorId', $doctorId);
                    $insertar->bindParam(':recomendaciones', $recomendaciones);
                    
        // Ejecutar la sentencia
        
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

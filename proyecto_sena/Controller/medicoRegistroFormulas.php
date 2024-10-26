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
            

            $prueba = 'SELECT id_Examenes, Examen AS descripcion FROM examenes_medicos';
            $stmtPrueba = $conexion->prepare($prueba);
            $stmtPrueba->execute();
            $pruebas = $stmtPrueba->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div id="loginContainer">
    <h2 align="center">Registro de  <br>Fórmulas</h2>
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

        <label>Nombre del Medicamento</label>
        <input type="text" id="medicamento" name="medicamento" required placeholder="Ingrese el nombre del medicamento"><br><br>

        <label>Dosis</label>
        <input type="text" id="dosis" name="dosis" required placeholder="Ingrese la dosis del medicamento"><br><br>

        <label>Instrucciones</label>
        <input type="text" id="instrucciones" name="instrucciones" required placeholder="Ingrese las indicaciones necesarias"><br><br>

        <label>Fecha de Formulación</label>
        <input type="date" id="fFormulacion" name="fFormulacion" required><br><br>

        <label>Fecha de Vencimiento</label>
        <input type="date" id="fVencimiento" name="fVencimiento" required><br><br>

        <label>Lúgar de Entrega</label>
        <input type="text" id="cantidad" name="cantidad" required placeholder="Ingrese el lúgar de entrega"><br><br>

        <button class="btn" type="submit" name="btnformulas">Ingresar Datos</button>
        

        <?php
        if (isset($_POST['btnformulas'])) {
            $usuario = $_POST['idUsuario'];
            $medicamento = $_POST['medicamento'];
            $dosis = $_POST['dosis'];
            $instrucciones = $_POST['instrucciones'];
            $formulacion = $_POST['fFormulacion'];
            $vencimiento = $_POST['fVencimiento'];
            $cantidad = $_POST['cantidad'];
            
            try{

                    $db = new Database(); 
                    $conexion = $db->connectar();
                    $query = "INSERT INTO formulas_medicas (usuario, nombre_medicamento, dosis, instrucciones, fecha_Formulacion, fecha_Vencimiento, Doctor, lugar_Entrega) 
                            values (:idUsuario, :medicamento, :dosis, :instrucciones, :fFormulacion, :fVencimiento, :doctorId, :cantidad)";
                    
                    $insertar = $conexion->prepare($query);
                    $insertar->bindParam(':idUsuario', $usuario);
                    $insertar->bindParam(':medicamento', $medicamento);
                    $insertar->bindParam(':dosis', $dosis);
                    $insertar->bindParam(':instrucciones', $instrucciones);
                    $insertar->bindParam(':fFormulacion', $formulacion);
                    $insertar->bindParam(':fVencimiento', $vencimiento);
                    $insertar->bindParam(':doctorId', $doctorId);
                    $insertar->bindParam(':cantidad', $cantidad);
                    
        // Ejecutar la sentencia
        
	        if ($insertar->execute() > 0) 
		        {	echo "<p style='color:black; text-align:center; margin-left: 30px; font-size:15px;background-color: bisque; padding: 10px; border: none; border-radius: 4px;'>Los datos fueron registrados con exito</p>";//header("location: administrador.php");
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

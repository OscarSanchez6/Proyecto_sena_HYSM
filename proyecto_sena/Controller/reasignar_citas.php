<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reasignar Cita Médica</title>
    <link rel="stylesheet" href="../css/reasignar_Citas.css">
    <link rel="icon" href="logo.ico" >
</head>
<body>
    <?php include_once '../View/header_reasignar_Citas.php'; ?>

    <div id="containerBienvenida">
    
        <h2>Nos alegra verte en tu panel de reasignar Citas médicas.</h2>
    <p>Aquí podrás:</p>
    <ul>
        <li>reasignar citas médicas</li>
        <p "font-weight: bold;">Recuerda que podrás acceder a la reasignación de tu cita. Selecciona la nueva fecha y hora que más te convenga, y confirma para finalizar el proceso.</p>
    <div class="citas-img">
            <img src="../Img/foto1.jpg" alt="">
        </div>
        </div>
        
    </div>


    <div class="container">
        <h1>reasignar Cita Médica</h1>

        
        <?php

            session_start();

            // Verifica si el usuario ha iniciado sesión y tiene el rol correcto.
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 3 || !isset($_SESSION['numero_documento'])) {
                session_destroy();
                header('Location: inicio_Sesion_recepcion.php');
                exit();
            }
        // Conexión a la base de datos.
        include '../Model/conexionPDO.php';
        $db = new Database();
        $conexion = $db->connectar();
        $usuario = $_SESSION['nombre'];
        

        // Consultar estados de citas.
        $consultaEstados = 'SELECT id_estado_citas, Estado_cita FROM estados_citas';
        $stmtEstados = $conexion->prepare($consultaEstados);
        $stmtEstados->execute();
        $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);
        ?>

            

        <form action="" method="POST" id="miFormulario" >
            <div class="form-group">
                <label for="fecha_hora">Fecha y Hora:</label>
                <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>
                <div id="error-message" class="error"></div>
            </div>

            <input type="hidden" name="id_estado_citas" value="13"> 

            <div id="mensaje"></div>

            <button type="submit" class="asignar cita" >asignar Cita</button>
        </form>
    </div>
    
    <?php
    include_once '../View/footer.php';
    ?>
    <script src="../JS/Validacion_fecha.js"></script>
    
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_hora = $_POST['fecha_hora'] ?? null;
    $id_estado_citas = $_POST['id_estado_citas'] ?? null;

    

    $numero_documento = $_SESSION['numero_documento'];

    // Consulta para obtener el id_usuario basado en numero_documento.
    $query = 'SELECT id_usuario FROM crear_usuario WHERE numero_documento = :numero_documento';
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':numero_documento', $numero_documento);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $id_usuario = $result['id_usuario'];
    } else {
        $mensaje = "Error: Usuario no encontrado.";
        echo "<script>document.getElementById('mensaje').innerHTML = '$mensaje';</script>";
        exit();
    }

    // Valida la disponibilidad de la fecha y hora.
    $consultaDisponibilidadFechaHora = 'SELECT COUNT(*) FROM citas_medicas WHERE fecha_hora = :fecha_hora';
    $stmtDisponibilidadFechaHora = $conexion->prepare($consultaDisponibilidadFechaHora);
    $stmtDisponibilidadFechaHora->bindParam(':fecha_hora', $fecha_hora);
    $stmtDisponibilidadFechaHora->execute();
    $fechaHoraDisponible = $stmtDisponibilidadFechaHora->fetchColumn() == 0;

    // Mesaje para cada validacion.
    if (!$fechaHoraDisponible) {
        $mensajeFechaHora = " La fecha y hora seleccionadas ya están ocupadas.<br>";
    }

    if (!$doctorDisponible) {
        $mensajeDoctor = "El doctor seleccionado ya tiene una cita en ese horario.<br>";
    }

    if ( !$fechaHoraDisponible && $doctorDisponible || $fechaHoraDisponible && $doctorDisponible) {
        // Prepara la consulta para insertar los datos.
        $sql = 'INSERT INTO citas_medicas ( fecha_hora,id_estado_citas) 
                VALUES (:fecha_hora,id_estado_citas)';

        $stmt = $conexion->prepare($sql);

        // Vinculacion de los parametros a ingresar.
       
        $stmt->bindParam(':fecha_hora', $fecha_hora);
        $stmt->bindParam(':id_estado_citas', $id_estado_citas);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "<span class='mensaje-exito'>Cita solicitada con éxito.</span>";
        } else {
            $mensaje = "<span class='mensaje-error'>Error al reasignar la cita: " . implode(", ", $stmt->errorInfo()) . "</span>";
        }
        } else {
            // Mensajes para cada validacion.
            $mensaje = "";
            if (!$fechaHoraDisponible) {
                $mensaje .= "<span class='mensaje-error'>" . $mensajeFechaHora . "</span><br>";
            }
            if (!$doctorDisponible) {
                $mensaje .= "<span class='mensaje-error'>" . $mensajeDoctor . "</span><br>";
            }
        }
        
        // Mostrar el mensaje dentro del formulario
        echo "<script>document.getElementById('mensaje').innerHTML = '" . addslashes($mensaje) . "';</script>";
        
        }
?>





<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Cita Médica</title>
    <link rel="stylesheet" href="../css/solicitud_Citas.css">
    <link rel="icon" href="logo.ico" >
</head>
<body>
    <?php include_once '../View/header_Usuario_Citas.php'; ?>

    <div id="containerBienvenida">
    
        <h2>Nos alegra verte en tu panel de Solicitud de Citas médicas.</h2>
    <p>Aquí podrás:</p>
    <ul>
        <li>Solicitar citas médicas</li>
        <p style='font=bold;'>Recuerda que podrás visualizar y cancelar tus citas asignadas en el apartado de solicitud y cancelación de citas médicas.</p>
    <p>Tu salud es nuestra prioridad. No dudes en contactarnos si necesitas ayuda.</p>
    <p class="parrafo">Ten presente que podrás seleccionar citas entre las 6 AM y 6 Pm, además recuerda seleccionar horarios de 10 en 10.</p>

    <div class="citas-img">
            <img src="../Img/citas_medicas.jpeg" alt="">
        </div>
        </div>
        
    </div>


    <div class="container">
        <h1>Solicitud de Cita Médica</h1>

        
        <?php

            session_start();

            // Verifica si el usuario ha iniciado sesión y tiene el rol correcto.
            if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
                session_destroy();
                header('Location: inicio_Sesion_Usuario.php');
                exit();
            }
        // Conexión a la base de datos.
        include '../Model/conexionPDO.php';
        $db = new Database();
        $conexion = $db->connectar();
        $usuario = $_SESSION['nombre'];
        

        // Consultar doctores.
        $consultaDoctores = 'SELECT id_usuario, CONCAT(nombre, " ", apellido1, " ", apellido2) AS nombre_doctor FROM crear_usuario WHERE rol ="1"';
        $stmtDoctores = $conexion->prepare($consultaDoctores);
        $stmtDoctores->execute();
        $doctores = $stmtDoctores->fetchAll(PDO::FETCH_ASSOC);

        // Consultar tipos de citas.
        $consultaTiposCita = 'SELECT id_tipo_cita, descripcion FROM tipos_de_cita';
        $stmtTiposCita = $conexion->prepare($consultaTiposCita);
        $stmtTiposCita->execute();
        $tiposCita = $stmtTiposCita->fetchAll(PDO::FETCH_ASSOC);

        // Consultar estados de citas.
        $consultaEstados = 'SELECT id_estado_citas, Estado_cita FROM estados_citas';
        $stmtEstados = $conexion->prepare($consultaEstados);
        $stmtEstados->execute();
        $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);

        //Consultar las especialidades.
        $consultaEspecialidades = 'SELECT Id_especialidades,Tipo_especialidades FROM especialidades';
        $stmtEspecialidades= $conexion->prepare($consultaEspecialidades);
        $stmtEspecialidades->execute();
        $especialidades= $stmtEspecialidades->fetchAll(PDO::FETCH_ASSOC);
        ?>

            

        <form action="" method="POST" id="miFormulario" >
        <div class="form-group">
                <label for="tipo_cita">Tipo de Cita:</label>
                <select name="tipo_cita" id="tipo_cita" >
                    
                    <?php foreach ($tiposCita as $tipo): ?>
                        <option value="<?php echo htmlspecialchars($tipo['id_tipo_cita']); ?>">
                            <?php echo htmlspecialchars($tipo['descripcion']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="motivo">Motivo de la Cita:</label>
                <textarea name="motivo" id="motivo" required></textarea>
            </div>

            <div class="form-group">
                <label for="especialidad">Especialidad:</label>
                <select name="especialidad" id="especialidad" required onchange="actualizarDoctores()">
                    <option value="">Seleccione una Especialidad</option>
                    <?php foreach ($especialidades as $especialidad): ?>
                        <option value="<?php echo htmlspecialchars($especialidad['Id_especialidades']); ?>">
                            <?php echo htmlspecialchars($especialidad['Tipo_especialidades']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="doctor">Seleccione un Doctor:</label>
                <select name="doctor_asignado" id="doctor" required>
                    <option value="">Seleccione un Doctor</option>
                    <?php foreach ($doctores as $doctor): ?>
                        <option value="<?php echo htmlspecialchars($doctor['id_usuario']); ?>">
                            <?php echo htmlspecialchars($doctor['nombre_doctor']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
                    
                    


            <div class="form-group">
                <label for="fecha_hora">Fecha y Hora:</label>
                <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>
                <div id="error-message" class="error"></div>
            </div>

            <div class="form-group">
                <label for="lugar_de_atencion">Lugar de Atención:</label>
                <input type="text" id="lugar_de_atencion" name="lugar_De_Atencion " value="Hospital" required>
            </div>

            <!--<div class="form-group">
                <label for="turno">Turno:</label>
                <input type="text" id="turno" name="turno" required><br><br>
            </div>-->

            <input type="hidden" name="id_estado_citas" value="5"> <br>

            <div id="mensaje"></div>

            <button type="submit" class="Solicitar" >Solicitar Cita</button>
        </form>
    </div>
    
    <?php
    include_once '../View/footer.php';
    ?>
    <script src="../JS/Validacion_fecha.js"></script>
    <script src="../JS/val_Doctores_Esp.js"></script>
    
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_cita = $_POST['tipo_cita'] ?? null;
    $motivo = $_POST['motivo'] ?? null;
    $doctor_asignado = $_POST['doctor_asignado'] ?? null;
    $id_especialidades = $_POST['especialidad'] ?? null;
    $fecha_hora = $_POST['fecha_hora'] ?? null;
    $lugar_de_atencion = 'Hospital';
    $turno = $_POST['turno'] ?? null;
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

    // Valida la  disponibilidad del doctor en ese horario.
    $consultaDisponibilidadDoctor = 'SELECT COUNT(*) FROM citas_medicas WHERE doctor_asignado = :doctor_asignado AND fecha_hora = :fecha_hora';
    $stmtDisponibilidadDoctor = $conexion->prepare($consultaDisponibilidadDoctor);
    $stmtDisponibilidadDoctor->bindParam(':doctor_asignado', $doctor_asignado);
    $stmtDisponibilidadDoctor->bindParam(':fecha_hora', $fecha_hora);
    $stmtDisponibilidadDoctor->execute();
    $doctorDisponible = $stmtDisponibilidadDoctor->fetchColumn() == 0;

    // Mesaje para cada validacion.
    if (!$fechaHoraDisponible) {
        $mensajeFechaHora = " La fecha y hora seleccionadas ya están ocupadas.<br>";
    }

    if (!$doctorDisponible) {
        $mensajeDoctor = "El doctor seleccionado ya tiene una cita en ese horario.<br>";
    }

    if ( !$fechaHoraDisponible && $doctorDisponible || $fechaHoraDisponible && $doctorDisponible) {
        // Prepara la consulta para insertar los datos.
        $sql = 'INSERT INTO citas_medicas (tipo_cita, motivo, id_usuario, doctor_asignado, id_especialidades, fecha_hora, lugar_De_Atencion, turno, id_estado_citas) 
                VALUES (:tipo_cita, :motivo, :id_usuario, :doctor_asignado, :id_especialidades, :fecha_hora, :lugar_de_atencion, :turno, :id_estado_citas)';

        $stmt = $conexion->prepare($sql);

        // Vinculacion de los parametros a ingresar.
        $stmt->bindParam(':tipo_cita', $tipo_cita);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':doctor_asignado', $doctor_asignado);
        $stmt->bindParam(':id_especialidades', $id_especialidades);
        $stmt->bindParam(':fecha_hora', $fecha_hora);
        $stmt->bindParam(':lugar_de_atencion', $lugar_de_atencion);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':id_estado_citas', $id_estado_citas);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "<span class='mensaje-exito'>Cita solicitada con éxito.</span>";
        } else {
            $mensaje = "<span class='mensaje-error'>Error al solicitar la cita: " . implode(", ", $stmt->errorInfo()) . "</span>";
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




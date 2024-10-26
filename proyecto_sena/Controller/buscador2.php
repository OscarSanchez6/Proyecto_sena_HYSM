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
<?php

$showResultIncapacidades = false; 
$showResultExamenes = false;  
$showResultHistoria = false;       

// Procesar búsqueda de incapacidades
if (isset($_POST['buscarIncapacidades']) && !empty(trim($_POST['buscarIncapacidades']))) {
    $buscarIncapacidades = trim($_POST['buscarIncapacidades']);

    try {
        $db = new Database();
        $conexion = $db->connectar();

        $consultaIncapacidades = "SELECT 
            incapacidad.id_Incapacidad,
            incapacidad.id_usuario AS id_usuario,
            usuario.nombre AS usuarioDescripcion,
            usuario.apellido1 AS usuarioApellido,
            usuario.apellido2 AS usuarioApellido2,
            incapacidad.motivos,
            incapacidad.fecha_inicio,
            incapacidad.fecha_fin,
            incapacidad.recomendaciones_medicamentos
        FROM incapacidades incapacidad
        JOIN crear_usuario usuario ON incapacidad.id_usuario = usuario.id_usuario
        WHERE CONCAT(usuario.nombre, ' ', usuario.apellido1, ' ', usuario.apellido2, incapacidad.fecha_inicio, incapacidad.fecha_fin)LIKE :buscarIncapacidades AND incapacidad.doctor_encargado = :doctorId";

        $statementIncapacidades = $conexion->prepare($consultaIncapacidades);

        $buscarIncapacidadesLike = '%' . $buscarIncapacidades . '%';  // Prepara el valor para LIKE
        $statementIncapacidades->bindParam(':buscarIncapacidades', $buscarIncapacidadesLike, PDO::PARAM_STR);
        $statementIncapacidades->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);

        $statementIncapacidades->execute();
        $resultadoIncapacidades = $statementIncapacidades->fetchAll(PDO::FETCH_ASSOC);
        $numeroIncapacidades = count($resultadoIncapacidades);

        $showResultIncapacidades = true;
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
}


// Procesar búsqueda de exámenes
if (isset($_POST['buscarExamen']) && !empty(trim($_POST['buscarExamen']))) {
    $buscarExamen = trim($_POST['buscarExamen']);

    try {
        $db = new Database();
        $conexion = $db->connectar();

        $consultaExamenes = "SELECT 
            e.id_Examenes,
            e.usuario AS id_usuario,
            u.nombre AS usuarioDescripcion,
            u.apellido1 AS usuarioApellido,
            u.apellido2 AS usuarioApellido2,
            e.tipo_De_Pruebas AS tipoExamen,
            ex.Examen AS examenDescripcion,
            e.información_Paciente,
            e.resultados,
            e.fecha_hora,
            e.datos_Hospital,
            e.diagnostico,
            e.tratamiento,
            e.doctor_encargado
        FROM examenes e
        JOIN crear_usuario u ON e.usuario = u.id_usuario
        JOIN examenes_medicos ex ON e.tipo_De_Pruebas = ex.id_Examenes
        WHERE CONCAT(u.nombre, ' ', u.apellido1, ' ', u.apellido2, ex.Examen ) LIKE :buscarExamen AND e.doctor_encargado = :doctorId";

        $statementExamenes = $conexion->prepare($consultaExamenes);
        $buscarExamenLike = '%' . $buscarExamen . '%';  // Prepara el valor para LIKE
        $statementExamenes->bindParam(':buscarExamen', $buscarExamenLike, PDO::PARAM_STR); // Usa bindParam para LIKE
        $statementExamenes->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);  // Asegúrate de que $doctorId esté definido
        $statementExamenes->execute();
        $resultadoExamenes = $statementExamenes->fetchAll(PDO::FETCH_ASSOC);
        $numeroExamenes = count($resultadoExamenes);

        $showResultExamenes = true;
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
}

// Procesar búsqueda de historias
if (isset($_POST['buscarHistoria']) && !empty(trim($_POST['buscarHistoria']))) {
    $buscarHistorias = trim($_POST['buscarHistoria']);

    try {
        $db = new Database();
        $conexion = $db->connectar();

        $consultaHistorias = "SELECT 
    historia.id_Historia_Medica,
    CONCAT(usuarios.nombre, ' ', usuarios.apellido1, ' ', usuarios.apellido2) AS usuario,
    historia.pruebas_Realizada,
    historia.cirugias,
    historia.medicamentos_Recetados,
    historia.análisis_Realizados,
    historia.tratamientos,
    historia.procesos,
    historia.diagnostico,
    historia.Tratamientos_Quirurgicos,
    historia.Hospitalizaciones,
    historia.formulas,
    historia.alergias,
    historia.fecha_hora,
    historia.lugar
    FROM historia_medica historia
    JOIN crear_usuario usuarios ON historia.usuario = usuarios.id_usuario
    WHERE usuarios.nombre LIKE :buscarHistoria";
        
        $statementHistoria = $conexion->prepare($consultaHistorias);
        $buscarHistoriaLike = '%' . $buscarHistorias . '%';  // Prepara el valor para LIKE
        $statementHistoria->bindParam(':buscarHistoria', $buscarHistoriaLike, PDO::PARAM_STR); // Usa bindParam para LIKE
        $statementHistoria->execute();
        $resultadoHistoria = $statementHistoria->fetchAll(PDO::FETCH_ASSOC);
        $numeroHistorias = count($resultadoHistoria);

        $showResultHistoria = true;
    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Incapacidades y Exámenes</title>
    <link rel="stylesheet" href="../Css/doctor.css">
</head>
<body>
    <!-- Formulario para buscar incapacidades -->

    <?php if ($showResultIncapacidades): ?>
        <h5>Resultados encontrados (<?php echo htmlspecialchars($numeroIncapacidades); ?>):</h5>
        <?php if ($numeroIncapacidades > 0): ?>
            <table border="1" align="center">
                <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>MOTIVOS</th>
                    <th>FECHA DE INICIO</th>
                    <th>FECHA DE TERMINACIÓN</th>
                    <th>RECOMENDACIONES</th>
                </tr>
                <?php foreach ($resultadoIncapacidades as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['id_Incapacidad']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuarioDescripcion'] . " " . $fila['usuarioApellido'] . " " . $fila['usuarioApellido2']); ?></td>
                        <td><?php echo htmlspecialchars($fila['motivos']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_fin']); ?></td>
                        <td><?php echo htmlspecialchars($fila['recomendaciones_medicamentos']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No se encontraron resultados para incapacidades.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Formulario para buscar exámenes -->
    <?php if ($showResultExamenes): ?>
        <h5>Resultados encontrados (<?php echo htmlspecialchars($numeroExamenes); ?>):</h5>
        <?php if ($numeroExamenes > 0): ?>
            <table border="1" align="center">
                <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>EXAMEN</th>
                    <th>INFORMACIÓN ADICIONAL</th>
                    <th>RESULTADOS</th>
                    <th>FECHA Y HORA</th>
                    <th>INFORMACIÓN DEL HOSPITAL</th>
                    <th>DIAGNÓSTICO</th>
                    <th>TRATAMIENTO</th>
                </tr>
                <?php foreach ($resultadoExamenes as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['id_Examenes']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuarioDescripcion'] . " " . $fila['usuarioApellido'] . " " . $fila['usuarioApellido2']); ?></td>
                        <td><?php echo htmlspecialchars($fila['examenDescripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['información_Paciente']); ?></td>
                        <td><a href="<?php echo htmlspecialchars('../Controller/download.php?file=' . urlencode($fila['resultados'])); ?>">Ver Resultados</a></td>
                        <td><?php echo htmlspecialchars($fila['fecha_hora']); ?></td>
                        <td><?php echo htmlspecialchars($fila['datos_Hospital']); ?></td>
                        <td><?php echo htmlspecialchars($fila['diagnostico']); ?></td>
                        <td><?php echo htmlspecialchars($fila['tratamiento']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>


    <!-- Historias Medicas -->
    <?php if ($showResultHistoria): ?>
        <h5 class="card-title">Resultados encontrados (<?php echo htmlspecialchars($numeroHistorias); ?>):</h5>
        <?php if ($numeroHistorias > 0): ?>
            <table border="1">
                <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>PRUEBAS REALIZADAS</th>
                <th>CIRUGIAS</th>
                <th>MEDICAMENTOS RECETADOS</th>
                <th>ANÁLISIS REALIZADOS</th>
                <th>TRATAMIENTOS</th>
                <th>PROCESOS</th>
                <th>DIAGNÓSTICOS</th>
                <th>TRATAMIENTOS QUIRURGICOS</th>
                <th>HOSPITALIZACIONES</th>
                <th>FÓRMULAS</th>
                <th>ALERGIAS</th>
                <th>FECHA Y HORA</th>
                <th>LUGAR</th>
                <th>EDITAR</th>
                </tr>
                <?php foreach ($resultadoHistoria as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['id_Historia_Medica']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($fila['pruebas_Realizada']); ?></td>
                        <td><?php echo htmlspecialchars($fila['cirugias']); ?></td>
                        <td><?php echo htmlspecialchars($fila['medicamentos_Recetados']); ?></td>
                        <td>
                                <?php if (!empty($registro['análisis_Realizados'])): ?>
                                    <?php 
                                    $archivo = htmlspecialchars($registro['análisis_Realizados']); 
                                    $pdfDownloadUrl = '../Controller/download.php?file=' . urlencode($archivo);
                                    ?>
                                    <a href="<?php echo $pdfDownloadUrl; ?>" target="_blank">Ver Resultados</a>
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                        <td><?php echo htmlspecialchars($fila['tratamientos']); ?></td>
                        <td><?php echo htmlspecialchars($fila['procesos']); ?></td>
                        <td><?php echo htmlspecialchars($fila['diagnostico']); ?></td>
                        <td><?php echo htmlspecialchars($fila['Tratamientos_Quirurgicos']); ?></td>
                        <td><?php echo htmlspecialchars($fila['Hospitalizaciones']); ?></td>
                        <td><?php echo htmlspecialchars($fila['formulas']); ?></td>
                        <td><?php echo htmlspecialchars($fila['alergias']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_hora']); ?></td>
                        <td><?php echo htmlspecialchars($fila['lugar']); ?></td>
                        <td><a href="?editar=<?php echo urlencode($fila['id_Historia_Medica']); ?>">Editar</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php if (isset($_GET['editar']) && !empty($_GET['editar'])): ?>
                <?php
                $idCita = $_GET['editar'];
                $queryCita = "SELECT * FROM citas_medicas WHERE Id_Citas = :idCita";
                $stmtCita = $conexion->prepare($queryCita);
                $stmtCita->bindParam(':idCita', $idCita);
                $stmtCita->execute();
                $cita = $stmtCita->fetch(PDO::FETCH_ASSOC);
                ?>

                <table border="2" align="center">
                    <tr>
                        <td>
                            <div align="center">
                                <h1>Modificación de Cita</h1>
                                <form method="POST" action="">
                                    <input type="hidden" name="idCita" value="<?php echo htmlspecialchars($idCita); ?>">
                                    <label>ESTADO CITA MEDICA</label>
                                    <select id="estadoCita" name="estadoCita" required>
                                        <option value="0">Seleccione una opción</option>
                                        <option value="1">Aplazada</option>
                                        <option value="2">Cancelada</option>
                                        <option value="3">Asistida</option>
                                        <option value="4">Confirmada</option>
                                        <option value="5">Pendiente por asignar</option>
                                        <option value="6">No asistida</option>
                                        <option value="7">Reprogramada</option>
                                        <option value="8">En espera</option>
                                        <option value="9">Completada</option>
                                        <option value="10">Pendiente por confirmación</option>
                                        <option value="11">Confirmada por paciente</option>
                                        <option value="12">Confirmada por médico</option>
                                        <option value="13">En proceso</option>
                                        <option value="14">Esperando confirmación</option>
                                    </select><br><br>
                                    <input type="submit" name="actualizame" value="Actualizar Datos" style="cursor: pointer;"><br>
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>

        <?php else: ?>
            <p class="card-text"><br>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    if (isset($_POST['actualizame'])) {
        $actualizacitas = $_POST['estadoCita'];
        $idCita = $_POST['idCita'];

        try {
            $queryEmail = "SELECT correo FROM crear_usuario WHERE id_usuario = (SELECT id_usuario FROM citas_medicas WHERE Id_Citas = :idCita)";
            $stmtEmail = $conexion->prepare($queryEmail);
            $stmtEmail->bindParam(':idCita', $idCita);
            $stmtEmail->execute();
            $emailRow = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            $queryEstadoDescripcion = "SELECT Estado_cita FROM estados_citas WHERE id_estado_citas = :estadoCita";
            $stmtEstadoDescripcion = $conexion->prepare($queryEstadoDescripcion);
            $stmtEstadoDescripcion->bindParam(':estadoCita', $actualizacitas);
            $stmtEstadoDescripcion->execute();
            $estadoRow = $stmtEstadoDescripcion->fetch(PDO::FETCH_ASSOC);

            if ($emailRow && $estadoRow) {
                $email = $emailRow['correo'];
                $estadoCitaDescripcion = $estadoRow['Estado_cita'];

                $queryUpdate = "UPDATE citas_medicas SET id_estado_citas = :estadoCita WHERE Id_Citas = :idCita";
                $stmtUpdate = $conexion->prepare($queryUpdate);
                $stmtUpdate->bindParam(':estadoCita', $actualizacitas);
                $stmtUpdate->bindParam(':idCita', $idCita);
                $stmtUpdate->execute();

                if ($stmtUpdate->rowCount() > 0) {
                    sendNotification($email, $idCita, $estadoCitaDescripcion);
                    echo "<script>window.location.href='doctorCitasMedicas.php';</script>";
                } else {
                    echo "<script>alert('No se pudo actualizar la cita');</script>";
                }
            } else {
                echo "<script>alert('No se encontró el correo electrónico del usuario o la descripción del estado de la cita');</script>";
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }
    }
    ?>
</body>
</html>
<?php
session_start();

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    header('Location: ../view/inicio_Sesion_Usuario.php');
    exit();
}

// Conexión a la base de datos.
include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

// Se obtiene el número de documento de la sesión.
$numero_documento = $_SESSION['numero_documento'];

// Consulta SQL con JOIN para obtener el nombre del examen desde la tabla `examenes_medicos`.
$consulta = '
    SELECT 
        ex.id_Examenes,
        CONCAT(p.nombre, " ", p.apellido1, " ", p.apellido2) AS nombre_paciente,
        em.Examen AS nombre_prueba,
        ex.pruebas,
        ex.tipo_De_Pruebas,
        ex.información_Paciente,
        ex.resultados,
        ex.fecha_hora,
        ex.datos_Hospital,
        ex.diagnostico,
        ex.tratamiento
    FROM examenes ex
    JOIN crear_usuario p ON ex.usuario = p.id_usuario
    JOIN examenes_medicos em ON ex.tipo_De_Pruebas = em.id_Examenes
    WHERE p.rol = 5 AND p.numero_documento = :numero_documento
    ORDER BY ex.fecha_hora DESC
';

$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR); // Vincula el parámetro
$stmt->execute();
$examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Exámenes Médicos</title>
    <link rel="stylesheet" href="../Css/medicamentos.css">
    <link rel="icon" href="logo.ico">
</head>
<body>

<?php include_once '../View/header_Usuario_Citas.php'; ?>
    <h1 class="tabla-titulo">Lista de Exámenes Médicos</h1>

    <form id="form-busqueda" class="form-busqueda">
        <input type="text" id="buscar" name="buscar" placeholder="Buscar por nombre del examen">
    </form>

    <div id="resultados">
    <?php if (count($examenes) > 0): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID Examen</th>
                    <th>Usuario</th>
                    <th>Nombre de la Prueba</th>
                    <!--<th>Pruebas</th>-->
                    <th>Información del Paciente</th>
                    <th>Resultados</th>
                    <th>Fecha y Hora</th>
                    <th>Datos del Hospital</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                    <!--<th>Acción</th>-->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examenes as $examen): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($examen['id_Examenes']); ?></td>
                        <td><?php echo htmlspecialchars($examen['nombre_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($examen['nombre_prueba']); ?></td>
                        <!--<td><?php echo htmlspecialchars($examen['pruebas']); ?></td>-->
                        <td><?php echo htmlspecialchars($examen['información_Paciente']); ?></td>
                        <td>
                                <?php if (!empty($examen['resultados'])): ?>
                                    <?php 
                                    $archivo = htmlspecialchars($examen['resultados']); 
                                    $pdfDownloadUrl = '../Controller/download.php?file=' . urlencode($archivo);
                                    ?>
                                    <a href="<?php echo $pdfDownloadUrl; ?>" target="_blank">Ver Resultados</a>
                                <?php else: ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                        <td><?php echo htmlspecialchars($examen['fecha_hora']); ?></td>
                        <td><?php echo htmlspecialchars($examen['datos_Hospital']); ?></td>
                        <td><?php echo htmlspecialchars($examen['diagnostico']); ?></td>
                        <td><?php echo htmlspecialchars($examen['tratamiento']); ?></td>
                        <!--<td>
                            <a href="../Controller/generar_examen_medico.php?id=<?php echo $examen['id_Examenes']; ?>" 
                            class="btn-descargar" target="_blank">Descargar Examen</a>
                        </td>-->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mensaje-examenes">No hay exámenes registrados.</p>
    <?php endif; ?>
    </div>

    <script>
        document.getElementById('buscar').addEventListener('input', function() {
            let query = this.value;

            // Enviar solicitud AJAX
            fetch('busqueda_examenes.php?buscar=' + encodeURIComponent(query))
                .then(response => response.text())
                .then(data => {
                    document.getElementById('resultados').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

<?php include_once '../View/footer.php'; ?>
</body>
</html>


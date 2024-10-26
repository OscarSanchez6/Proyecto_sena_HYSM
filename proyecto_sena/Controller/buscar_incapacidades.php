<?php
session_start();

// Verifica la sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    header('Location: ../view/inicio_Sesion_Usuario.php');
    exit();
}

include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

$numero_documento = $_SESSION['numero_documento'];
$fecha_busqueda = isset($_GET['fecha_busqueda']) ? $_GET['fecha_busqueda'] : '';

// Consulta SQL con filtro de fecha para las incapacidades
$consulta = '
    SELECT i.*, 
    CONCAT(p.nombre, " ", p.apellido1, " ", p.apellido2) AS nombre_paciente,
    CONCAT(d.nombre, " ", d.apellido1, " ", d.apellido2) AS nombre_doctor
    FROM incapacidades i
    JOIN crear_usuario AS p ON i.id_usuario = p.id_usuario
    JOIN crear_usuario AS d ON i.doctor_encargado = d.id_usuario
    WHERE p.numero_documento = :numero_documento
';

// Agregar condición de fecha si se proporciona
$params = [':numero_documento' => $numero_documento];
if ($fecha_busqueda !== '') {
    $consulta .= ' AND DATE(i.fecha_inicio) = :fecha_busqueda';
    $params[':fecha_busqueda'] = $fecha_busqueda;
}

$consulta .= ' ORDER BY i.fecha_inicio DESC';

try {
    $stmt = $conexion->prepare($consulta);
    $stmt->execute($params);
    $incapacidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
    exit();
}
?>

<!-- Generar la tabla HTML para incapacidades -->
<?php if (!empty($incapacidades)): ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Motivos</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Doctor Encargado</th>
                <th>Recomendaciones Medicamentos</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incapacidades as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['nombre_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($registro['motivos']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha_fin']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre_doctor']); ?></td>
                    <td><?php echo htmlspecialchars($registro['recomendaciones_medicamentos']); ?></td>
                    <td>
                        <a href="../Controller/generar_incapacidad.php?id=<?php echo $registro['id_Incapacidad']; ?>" 
                        class="btn-descargar" target="_blank">Descargar Incapacidad</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="mensaje-medicamentos">No se encontraron registros de incapacidades para la fecha seleccionada.</p>
<?php endif; ?>

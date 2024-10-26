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

// Consulta SQL con un filtro de búsqueda por fecha
$consulta = '
    SELECT historia_medica.*, 
    CONCAT(paciente.nombre, " ", paciente.apellido1, " ", paciente.apellido2) AS nombre_paciente
    FROM historia_medica
    JOIN crear_usuario AS paciente ON historia_medica.usuario = paciente.id_usuario
    WHERE paciente.numero_documento = :numero_documento
';

// Agregar condición de fecha solo si se proporciona una fecha de búsqueda
$params = [':numero_documento' => $numero_documento];
if ($fecha_busqueda !== '') {
    $consulta .= ' AND DATE(historia_medica.fecha_hora) = :fecha_busqueda';
    $params[':fecha_busqueda'] = $fecha_busqueda;
}

$consulta .= ' ORDER BY historia_medica.fecha_hora DESC';

try {
    $stmt = $conexion->prepare($consulta);
    $stmt->execute($params);
    $historia_medica = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
    exit();
}
?>

<!-- Generar la tabla HTML -->
<?php if (!empty($historia_medica)): ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Pruebas Realizadas</th>
                <th>Cirugías</th>
                <th>Medicamentos Recetados</th>
                <th>Resultados</th>
                <th>Tratamientos</th>
                <th>Procesos</th>
                <th>Diagnóstico</th>
                <th>Tratamientos Quirúrgicos</th>
                <th>Hospitalización</th>
                <th>Alergias</th>
                <th>Fecha y Hora</th>
                <th>Lugar</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historia_medica as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['nombre_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($registro['pruebas_Realizada']); ?></td>
                    <td><?php echo htmlspecialchars($registro['cirugias']); ?></td>
                    <td><?php echo htmlspecialchars($registro['medicamentos_Recetados']); ?></td>
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
                    <td><?php echo htmlspecialchars($registro['tratamientos']); ?></td>
                    <td><?php echo htmlspecialchars($registro['procesos']); ?></td>
                    <td><?php echo htmlspecialchars($registro['diagnostico']); ?></td>
                    <td><?php echo htmlspecialchars($registro['tratamientos']); ?></td>
                    <td><?php echo htmlspecialchars($registro['Hospitalizaciones']); ?></td>
                    <td><?php echo htmlspecialchars($registro['alergias']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha_hora']); ?></td>
                    <td><?php echo htmlspecialchars($registro['lugar']); ?></td>
                    <td>
                        <a href="../Controller/generar_historia_medica.php?id=<?php echo $registro['id_Historia_Medica']; ?>" 
                        class="btn-descargar" target="_blank">Descargar Historia</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="mensaje-medicamentos">No se encontraron registros para la fecha seleccionada.</p>
<?php endif; ?>
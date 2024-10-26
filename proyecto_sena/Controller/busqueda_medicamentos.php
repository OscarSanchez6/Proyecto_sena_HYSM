<?php
// Incluye tu archivo de conexión a la base de datos
include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

// Obtener el término de búsqueda
$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta SQL con un filtro de búsqueda
$consulta = 'SELECT 
    fm.id_formulas,
    CONCAT(p.nombre, " ", p.apellido1, " ", p.apellido2) AS nombre_paciente,
    CONCAT(d.nombre, " ", d.apellido1, " ", d.apellido2) AS nombre_doctor,
    fm.usuario, 
    fm.nombre_medicamento, 
    fm.dosis, 
    fm.instrucciones,
    fm.fecha_Formulacion,
    fm.fecha_Vencimiento,
    fm.Doctor,
    fm.lugar_Entrega
FROM formulas_medicas fm
JOIN crear_usuario p ON fm.usuario = p.id_usuario
JOIN crear_usuario d ON fm.Doctor = d.id_usuario
WHERE p.rol = 5 AND d.rol = 1 
AND fm.nombre_medicamento LIKE :busqueda
ORDER BY fm.fecha_Formulacion DESC';

$stmt = $conexion->prepare($consulta);
$stmt->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR); // Vincula el parámetro de búsqueda
$stmt->execute();
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Generar la tabla HTML
if (count($medicamentos) > 0): ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>ID Fórmula</th>
                <th>Usuario</th>
                <th>Nombre del Medicamento</th>
                <th>Dosis</th>
                <th>Instrucciones</th>
                <th>Fecha de formulación</th>
                <th>Fecha de vencimiento</th>
                <th>Doctor</th>
                <th>Lugar de entrega</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicamentos as $medicamento): ?>
                <tr>
                    <td><?php echo htmlspecialchars($medicamento['id_formulas']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['nombre_paciente']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['nombre_medicamento']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['dosis']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['instrucciones']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['fecha_Formulacion']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['fecha_Vencimiento']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['nombre_doctor']); ?></td>
                    <td><?php echo htmlspecialchars($medicamento['lugar_Entrega']); ?></td>
                    <td>
                        <a href="../Controller/generar_formula_medica.php?id=<?php echo $medicamento['id_formulas']; ?>" 
                        class="btn-descargar" target="_blank">Descargar Fórmula</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="mensaje-medicamentos">No hay medicamentos registrados.</p>
<?php endif;

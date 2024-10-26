<?php
// Conexión a la base de datos y verificación de sesión
include '../Model/conexionPDO.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    header('Location: ../view/inicio_Sesion_Usuario.php');
    exit();
}

$db = new Database();
$conexion = $db->connectar();

$numero_documento = $_SESSION['numero_documento'];
$query = "SELECT id_usuario FROM crear_usuario WHERE numero_documento = :numero_documento";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':numero_documento', $numero_documento);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $id_usuario = $result['id_usuario'];
} else {
    echo "Error: Usuario no encontrado.";
    exit();
}

$fecha_busqueda = isset($_GET['fecha_busqueda']) ? $_GET['fecha_busqueda'] : '';
$consultaCitas = 'SELECT citas_medicas.*, tipos_de_cita.descripcion, especialidades.Tipo_especialidades, 
CONCAT(crear_usuario.nombre, " ", crear_usuario.apellido1, " ", crear_usuario.apellido2) AS nombre_doctor,
estados_citas.Estado_cita
FROM citas_medicas 
JOIN tipos_de_cita ON citas_medicas.tipo_cita = tipos_de_cita.id_tipo_cita 
JOIN especialidades ON citas_medicas.id_especialidades = especialidades.id_especialidades
JOIN crear_usuario ON citas_medicas.doctor_asignado = crear_usuario.id_usuario
JOIN estados_citas ON citas_medicas.id_estado_citas = estados_citas.id_estado_citas
WHERE citas_medicas.id_usuario = :id_usuario';

if ($fecha_busqueda) {
    $consultaCitas .= ' AND DATE(citas_medicas.fecha_hora) = :fecha_busqueda';
}

$consultaCitas .= ' ORDER BY citas_medicas.fecha_hora ASC';

$stmtCitas = $conexion->prepare($consultaCitas);
$stmtCitas->bindParam(':id_usuario', $id_usuario);
if ($fecha_busqueda) {
    $stmtCitas->bindParam(':fecha_busqueda', $fecha_busqueda);
}
$stmtCitas->execute();
$citas = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);

if (count($citas) > 0): ?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Tipo de Cita</th>
                <th>Motivo</th>
                <th>Doctor Asignado</th>
                <th>Especialidad</th>
                <th>Fecha y Hora</th>
                <th>Lugar</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $cita): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cita['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($cita['motivo']); ?></td>
                    <td><?php echo htmlspecialchars($cita['nombre_doctor']); ?></td>
                    <td><?php echo htmlspecialchars($cita['Tipo_especialidades']); ?></td>
                    <td><?php echo htmlspecialchars($cita['fecha_hora']); ?></td>
                    <td><?php echo htmlspecialchars($cita['lugar_De_Atencion']); ?></td>
                    <td><?php echo htmlspecialchars($cita['Estado_cita']); ?></td>
                    <td>
                        <form action="cancelar_cita.php" method="POST" class="form-cancelar">
                            <input type="hidden" name="Id_Citas" value="<?php echo htmlspecialchars($cita['Id_Citas']); ?>">
                            <button type="submit" class="btn-cancelar">Cancelar Cita</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="mensaje-citas">No hay citas registradas en esta fecha.</p>
<?php endif; ?>

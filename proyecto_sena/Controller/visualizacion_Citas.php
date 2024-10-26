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

// Obtener el id_usuario basado en numero_documento.
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

// Obtener la fecha de búsqueda si está establecida
$fecha_busqueda = isset($_GET['fecha_busqueda']) ? $_GET['fecha_busqueda'] : null;

// Consultar citas médicas
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas Médicas</title>
    <link rel="stylesheet" href="../css/visualizacion_Citas.css">
    <link rel="icon" href="logo.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Función para cargar citas con la fecha proporcionada
        function cargarCitas(fecha) {
            $.ajax({
                url: 'buscar_citas.php',
                type: 'GET',
                data: { fecha_busqueda: fecha },
                success: function(data) {
                    $('#resultados').html(data);
                },
                error: function() {
                    alert('Error al cargar las citas.');
                }
            });
        }

        // Manejar cambios en el campo de fecha
        $('#fecha_busqueda').on('change', function() {
            let fecha = $(this).val();
            if (fecha) {
                cargarCitas(fecha);
            } else {
                cargarCitas(''); // Cargar todas las citas si la fecha está vacía
            }
        });

        // Manejar la cancelación de citas con confirmación
        $(document).on('submit', '.form-cancelar', function(e) {
            e.preventDefault(); // Evita la recarga de la página

            if (confirm("¿Está seguro de que desea cancelar esta cita?")) {
                let formData = new FormData(this);

                // Enviar la solicitud POST a cancelar_cita.php
                fetch('cancelar_cita.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        alert(response.message);
                        // Recargar las citas después de cancelar
                        let fecha = $('#fecha_busqueda').val();
                        cargarCitas(fecha); // Recargar citas según la fecha actual
                    } else {
                        alert('Error: ' + response.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
    </script>
</head>
<body>

<?php include_once '../View/header_visualizacion.php'; ?>

<h1 class="tabla-titulo">Mis Citas Médicas</h1>

<form id="form-busqueda">
    <label class="fecha_busqueda">Buscar por fecha:</label><br>
    <input type="date" id="fecha_busqueda" name="fecha_busqueda" placeholder="Selecciona una fecha" value="<?php echo htmlspecialchars($fecha_busqueda); ?>">
</form>

<div id="resultados" class="tabla-container">
    <!-- Los resultados de las citas se cargarán aquí mediante AJAX -->
    <?php if (count($citas) > 0): ?>
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
        <p class="mensaje-citas">No hay citas para mostrar.</p>
    <?php endif; ?>
</div>

<?php include_once '../View/footer.php'; ?>

</body>
</html>

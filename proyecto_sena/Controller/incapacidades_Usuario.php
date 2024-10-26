<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    header('Location: ../view/inicio_Sesion_Usuario.php');
    exit();
}

include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

$numero_documento = $_SESSION['numero_documento'];

$consulta = 'SELECT incapacidades.*, 
    CONCAT(paciente.nombre, " ", paciente.apellido1, " ", paciente.apellido2) AS nombre_paciente, 
    paciente.numero_documento,
    CONCAT(doctor.nombre, " ", doctor.apellido1, " ", doctor.apellido2) AS nombre_doctor
    FROM incapacidades
    JOIN crear_usuario AS paciente ON incapacidades.id_usuario = paciente.id_usuario
    JOIN crear_usuario AS doctor ON incapacidades.doctor_encargado = doctor.id_usuario
    WHERE paciente.numero_documento = :numero_documento';
$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR);
$stmt->execute();
$incapacidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incapacidades Médicas</title>
    <link rel="stylesheet" href="../css/historia_Medica.css">
</head>
<body>
    <?php include_once '../View/header_Usuario_Citas.php'; ?>
    
    <h1 class="tabla-titulo">Incapacidades Médicas</h1>
    <form id="form-busqueda">
        <label class="fecha_busqueda">Buscar por fecha:</label><br>
        <input type="date" id="fecha_busqueda" name="fecha_busqueda" placeholder="Selecciona una fecha">
    </form>
    <div id="resultados" class="tabla-container">
        <?php if ($incapacidades): ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <!--<th>ID Incapacidad</th>-->
                        <th>Usuario</th>
                        <th>Motivos</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Doctor que prescribe</th>
                        <th>Recomendaciones Medicamentos</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incapacidades as $registro): ?>
                        <tr>
                            <!--<td><?php echo htmlspecialchars($registro['id_Incapacidad']); ?></td>-->
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
            <p class="mensaje-medicamentos">No hay incapacidades registradas.</p>
        <?php endif; ?>
        <script>
    document.getElementById('fecha_busqueda').addEventListener('change', function() {
        let fecha = this.value;

        // Enviar solicitud AJAX
        fetch('buscar_incapacidades.php?fecha_busqueda=' + encodeURIComponent(fecha))
            .then(response => response.text())
            .then(data => {
                document.getElementById('resultados').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    });
    </script>
    </div>

    <?php include_once '../View/footer.php'; ?>
</body>
</html>

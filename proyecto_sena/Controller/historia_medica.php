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

$consulta = 'SELECT historia_medica.*, 
    CONCAT(paciente.nombre, " ", paciente.apellido1, " ", paciente.apellido2) AS nombre_paciente, 
    paciente.numero_documento
    FROM historia_medica
    JOIN crear_usuario AS paciente ON historia_medica.usuario = paciente.id_usuario
    WHERE paciente.numero_documento = :numero_documento
    ORDER BY historia_medica.fecha_hora DESC';
$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR);
$stmt->execute();
$historia_medica = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Médica</title>
    <link rel="stylesheet" href="../css/historia_Medica.css">
</head>
<body>
    <?php include_once '../View/header_Usuario_Citas.php'; ?>
    
    <h1 class="tabla-titulo">Historia Médica</h1>

    <form id="form-busqueda">
        <label class="fecha_busqueda">Buscar por fecha:</label><br>
        <input type="date" id="fecha_busqueda" name="fecha_busqueda">
    </form>
    <div id="resultados" class="tabla-container">
        <?php if ($historia_medica): ?>
            <table class="tabla">
                <thead>
                    <tr>
                        <!--<th>ID Historia Médica</th>-->
                        <th>Usuario</th>
                        <th>Pruebas Realizadas</th>
                        <th>Cirugías</th>
                        <th>Medicamentos Recetados</th>
                        <th>Resultados</th>
                        <!--<th>Resultados de Análisis</th>-->
                        <th>Tratamientos</th>
                        <th>Procesos</th>
                        <th>Diagnóstico</th>
                        <th>Tratamientos Quirúrgicos</th>
                        <th>Hospitalización</th>
                        <!--<th>Formulas</th>-->
                        <th>Alergias</th>
                        <!--<th>Consumo de Tabaco</th>
                        <th>Consumo de Alcohol</th>
                        <th>Consumo de Drogas</th>
                        <th>Actividad Física</th>
                        <th>Resultados de Imágenes</th>-->
                        <th>Fecha y Hora</th>
                        <th>Lugar</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historia_medica as $registro): ?>
                        <tr>
                            <!--<td><?php echo htmlspecialchars($registro['id_Historia_Medica']); ?></td>-->
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
                            <!--<td><?php echo htmlspecialchars($registro['resultados_analisis']); ?></td>-->
                            <td><?php echo htmlspecialchars($registro['tratamientos']); ?></td>
                            <td><?php echo htmlspecialchars($registro['procesos']); ?></td>
                            <td><?php echo htmlspecialchars($registro['diagnostico']); ?></td>
                            <td><?php echo htmlspecialchars($registro['Tratamientos_Quirurgicos']); ?></td>
                            <td><?php echo htmlspecialchars($registro['Hospitalizaciones']); ?></td>
                            <!--<td><?php echo htmlspecialchars($registro['formulas']); ?></td>-->
                            <td><?php echo htmlspecialchars($registro['alergias']); ?></td>
                            <!--<td><?php echo htmlspecialchars($registro['consumo_tabaco']); ?></td>
                            <td><?php echo htmlspecialchars($registro['consumo_alcohol']); ?></td>
                            <td><?php echo htmlspecialchars($registro['consumo_drogas']); ?></td>
                            <td><?php echo htmlspecialchars($registro['actividad_fisica']); ?></td>
                            <td><?php echo htmlspecialchars($registro['resultados_imagenes']); ?></td>-->
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
            <p class="mensaje-medicamentos">No hay historia médica registrada.</p>
        <?php endif; ?>
    </div>
    <script>
        document.getElementById('fecha_busqueda').addEventListener('change', function() {
            let fecha = this.value;

            // Enviar solicitud AJAX
            fetch('buscar_historia.php?fecha_busqueda=' + encodeURIComponent(fecha))
                .then(response => response.text())
                .then(data => {
                    document.getElementById('resultados').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
</script>

    
</body>
<?php include_once '../View/footer.php'; ?>
</html>


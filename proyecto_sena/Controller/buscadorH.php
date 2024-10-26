<?php
include_once '../Model/conexionPDO.php';

$showResultHistoria = false;
$numeroHistoria = 0;

if (isset($_POST['buscarHistoria']) && !empty(trim($_POST['buscarHistoria']))) {
    $buscar = trim($_POST['buscarHistoria']);

    try {
        $db = new Database();
        $conexion = $db->connectar();
        $query = "SELECT 
                    historia.id_Historia_Medica,
                    historia.usuario AS id_usuario,
                    usuarios.nombre AS usuarioNombre,
                    usuarios.apellido1 AS usuarioApellido,
                    usuarios.apellido2 AS usuarioApellido2,
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
    
        $stmt = $conexion->prepare($query);

        $searchTerm = '%' . $buscar . '%'; 
        $stmt->bindParam(':buscarHistoria', $searchTerm);

        $stmt->execute();
        $resultadoHistoria = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $numeroHistoria = count($resultadoHistoria);

        $showResultHistoria = true;

    } catch (PDOException $e) {
        die("Error en conexión a la base de datos: " . $e->getMessage());
    }
}
?>

<?php if ($showResultHistoria): ?>
    <h5>Resultados encontrados (<?php echo htmlspecialchars($numeroHistoria); ?>):</h5>
    <?php if ($numeroHistoria > 0): ?>
        <table class="tabla" align="center">
            <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>PRUEBAS REALIZADAS</th>
                <th>CIRUGIAS</th>
                <th>MEDICAMENTOS RECETADOS</th>
                <th>RESULTADOS</th>
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
                    <td><?php echo htmlspecialchars($fila['usuarioNombre'] . " " . $fila['usuarioApellido'] . " " . $fila['usuarioApellido2']); ?></td>
                    <td><?php echo htmlspecialchars($fila['pruebas_Realizada']); ?></td>
                    <td><?php echo htmlspecialchars($fila['cirugias']); ?></td>
                    <td><?php echo htmlspecialchars($fila['medicamentos_Recetados']); ?></td>
                    <td><a class="btn-descargar" href="../Controller/download.php?file=<?php echo urlencode($fila['análisis_Realizados']); ?>">Ver Resultados</a></td>
                    <td><?php echo htmlspecialchars($fila['tratamientos']); ?></td>
                    <td><?php echo htmlspecialchars($fila['procesos']); ?></td>
                    <td><?php echo htmlspecialchars($fila['diagnostico']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Tratamientos_Quirurgicos']); ?></td>
                    <td><?php echo htmlspecialchars($fila['Hospitalizaciones']); ?></td>
                    <td><?php echo htmlspecialchars($fila['formulas']); ?></td>
                    <td><?php echo htmlspecialchars($fila['alergias']); ?></td>
                    <td><?php echo htmlspecialchars($fila['fecha_hora']); ?></td>
                    <td><?php echo htmlspecialchars($fila['lugar']); ?></td>
                    <td><a href="doctorTablaHistoria.php?editar=<?php echo htmlspecialchars($fila['id_Historia_Medica']); ?>">Editar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
<?php else: ?>
    <p>No se recibió ningún término de búsqueda.</p>
<?php endif; ?>

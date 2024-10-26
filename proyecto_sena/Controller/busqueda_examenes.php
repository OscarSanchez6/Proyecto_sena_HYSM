<?php
session_start();

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    exit('Acceso no autorizado.');
}

// Conexión a la base de datos.
include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

// Se obtiene el número de documento de la sesión.
$numero_documento = $_SESSION['numero_documento'];
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta SQL con búsqueda filtrada.
$consulta = 'SELECT 
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
';

// Agregar condición de búsqueda si hay un término.
if (!empty($buscar)) {
    $consulta .= ' AND em.Examen LIKE :buscar';
}

$consulta .= ' ORDER BY ex.fecha_hora DESC';

$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR);

if (!empty($buscar)) {
    $buscar = '%' . $buscar . '%';
    $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
}

$stmt->execute();
$examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generar la tabla de resultados.
if (count($examenes) > 0) {
    echo '<table class="tabla">
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
        <tbody>';

    foreach ($examenes as $examen) {
        echo '<tr>
            <td>' . htmlspecialchars($examen['id_Examenes']) . '</td>
            <td>' . htmlspecialchars($examen['nombre_paciente']) . '</td>
            <td>' . htmlspecialchars($examen['nombre_prueba']) . '</td>
            <!--<td>' . htmlspecialchars($examen['pruebas']) . '</td>-->
            <td>' . htmlspecialchars($examen['información_Paciente']) . '</td>
            <td>';

        if (!empty($examen['resultados'])) {
            $archivo = htmlspecialchars($examen['resultados']);
            $pdfDownloadUrl = '../Controller/download.php?file=' . urlencode($archivo);
            echo '<a href="' . $pdfDownloadUrl . '" target="_blank">Ver Resultados</a>';
        } else {
            echo 'No disponible';
        }

        echo '</td>
            <td>' . htmlspecialchars($examen['fecha_hora']) . '</td>
            <td>' . htmlspecialchars($examen['datos_Hospital']) . '</td>
            <td>' . htmlspecialchars($examen['diagnostico']) . '</td>
            <td>' . htmlspecialchars($examen['tratamiento']) . '</td>
            <!--<td>
                <a href="../Controller/generar_examen_medico.php?id=' . $examen['id_Examenes'] . '" class="btn-descargar" target="_blank">Descargar Examen</a>
            </td>-->
        </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p class="mensaje-medicamentos">No se encontraron exámenes para la búsqueda.</p>';
}
?>

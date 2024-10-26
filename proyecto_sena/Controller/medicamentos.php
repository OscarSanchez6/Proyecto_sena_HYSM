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

// Se obtiene el número de documento de la sesión
$numero_documento = $_SESSION['numero_documento'];

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
WHERE p.rol = 5 AND d.rol = 1 AND p.numero_documento = :numero_documento
ORDER BY fm.fecha_Formulacion DESC';

$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR); // Vincula el parámetro
$stmt->execute();
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$showResult = true;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Medicamentos</title>
    <link rel="stylesheet" href="../css/medicamentos.css">
    <link rel="icon" href="logo.ico">
</head>
<body>

<?php include_once '../View/header_Usuario_Citas.php'; ?>
    <h1 class="tabla-titulo">Lista de Medicamentos</h1>

    <form id="form-busqueda">
    <input type="text" id="buscar" name="buscar" placeholder="Buscar por nombre del medicamento">
</form>
<div id="resultados">
    

    <?php if (count($medicamentos) > 0): ?>
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
    <?php endif; ?>
    
    </div>

    <?php
    
    // Incluir mensaje en JavaScript si existe en la URL
    if (isset($_GET['mensaje'])) {
        $mensaje = $_GET['mensaje'];
        // Escapar el mensaje para JavaScript
        echo '<script type="text/javascript">';
        echo 'window.onload = function() { alert(' . json_encode($mensaje) . '); };';
        echo '</script>';
    }
    ?>
    <script>
        document.getElementById('buscar').addEventListener('input', function() {
            let query = this.value;

            // Enviar solicitud AJAX
            fetch('busqueda_medicamentos.php?buscar=' + encodeURIComponent(query))
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
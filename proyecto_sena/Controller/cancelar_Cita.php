<?php
session_start();

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit();
}

// Conexión a la base de datos.
include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id_Citas = $_POST['Id_Citas'];

    // Eliminar la cita de la base de datos.
    $consultaEliminar = 'DELETE FROM citas_medicas WHERE Id_Citas = :Id_Citas';
    $stmtEliminar = $conexion->prepare($consultaEliminar);
    $stmtEliminar->bindParam(':Id_Citas', $Id_Citas);

    if ($stmtEliminar->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cita cancelada con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cancelar la cita: ' . implode(", ", $stmtEliminar->errorInfo())]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>

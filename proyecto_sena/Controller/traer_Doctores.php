<?php
include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

if (isset($_POST['especialidad_id'])) {
    $especialidad_id = $_POST['especialidad_id'];

    // Consulta para obtener los doctores de la especialidad seleccionada
    $consultaDoctores = 'SELECT id_usuario, CONCAT(nombre, " ", apellido1, " ", apellido2) AS nombre_doctor 
                         FROM crear_usuario 
                         WHERE rol = "1" AND especialidad = :especialidad_id';
    $stmtDoctores = $conexion->prepare($consultaDoctores);
    $stmtDoctores->bindParam(':especialidad_id', $especialidad_id);
    $stmtDoctores->execute();
    $doctores = $stmtDoctores->fetchAll(PDO::FETCH_ASSOC);

    foreach ($doctores as $doctor) {
        echo "<option value='" . htmlspecialchars($doctor['id_usuario']) . "'>" . htmlspecialchars($doctor['nombre_doctor']) . "</option>";
    }
}
?>

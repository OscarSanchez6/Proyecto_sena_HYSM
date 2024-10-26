<?php
require_once('../FPDF/fpdf.php');  // Asegúrate de que esta ruta sea correcta
include '../Model/conexionPDO.php';

class PDF extends FPDF
{
    function Header()
    {
        // Título
        date_default_timezone_set('America/Bogota'); // Ajusta la zona horaria si es necesario
        $fecha_hora_actual = date('d/m/Y H:i');
        $this->SetFont('Arial', '', 12);
        $this->Cell(300, 10, 'Fecha y Hora: ' . $fecha_hora_actual, 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('Incapacidad'), 0, 1, 'C');
        $this->Ln(10);
    }

    function ChapterTitle($title)
    {
        // Título de la sección
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $title, 0, 1);
        $this->Ln(4);
    }

    function ChapterBody($body)
    {
        // Cuerpo del texto
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode($body)); // Asegúrate de decodificar el texto en UTF-8
        $this->Ln();
    }
}

// Verifica si el parámetro 'id' está presente en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('No se ha especificado una incapacidad.');
}

// Obtiene el ID de la incapacidad
$id_incapacidad = $_GET['id'];

// Conexión a la base de datos
$db = new Database();
$conexion = $db->connectar();

// Consulta para obtener los datos de la incapacidad
$consulta = 'SELECT i.id_Incapacidad, i.id_usuario, i.motivos, i.fecha_inicio, i.fecha_fin, i.doctor_encargado, i.recomendaciones_medicamentos, 
                    p.nombre AS paciente_nombre, p.apellido1 AS paciente_apellido1, p.apellido2 AS paciente_apellido2,
                    d.nombre AS doctor_nombre, d.apellido1 AS doctor_apellido1, d.apellido2 AS doctor_apellido2
             FROM incapacidades i
             JOIN crear_usuario p ON i.id_usuario = p.id_usuario
             JOIN crear_usuario d ON i.doctor_encargado = d.id_usuario
             WHERE i.id_Incapacidad = :id_incapacidad';
$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':id_incapacidad', $id_incapacidad, PDO::PARAM_INT);
$stmt->execute();
$incapacidad = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se encontraron los datos
if (!$incapacidad) {
    die('Incapacidad no encontrada.');
}

// Crear instancia de PDF
$pdf = new PDF();
$pdf->AddPage();

// Añadir datos de la incapacidad
$pdf->SetFont('Arial', '', 12);
$pdf->ChapterTitle('ID Incapacidad: ' . htmlspecialchars($incapacidad['id_Incapacidad']));
$pdf->ChapterBody('Paciente: ' . htmlspecialchars($incapacidad['paciente_nombre']) . ' ' . htmlspecialchars($incapacidad['paciente_apellido1']) . ' ' . htmlspecialchars($incapacidad['paciente_apellido2']));
$pdf->ChapterBody('Motivos: ' . htmlspecialchars($incapacidad['motivos']));
$pdf->ChapterBody('Fecha de Inicio: ' . htmlspecialchars($incapacidad['fecha_inicio']));
$pdf->ChapterBody('Fecha de Fin: ' . htmlspecialchars($incapacidad['fecha_fin']));
$pdf->ChapterBody('Doctor que prescribe: ' . htmlspecialchars($incapacidad['doctor_nombre']) . ' ' . htmlspecialchars($incapacidad['doctor_apellido1']) . ' ' . htmlspecialchars($incapacidad['doctor_apellido2']));
$pdf->ChapterBody('Recomendaciones: ' . htmlspecialchars($incapacidad['recomendaciones_medicamentos']));

// Mostrar el PDF en el navegador
$pdf->Output('I', 'incapacidad_' . $id_incapacidad . '.pdf'); // 'I' para mostrar en el navegador
?>


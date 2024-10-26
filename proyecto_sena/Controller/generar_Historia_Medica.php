<?php
require_once('../FPDF/fpdf.php');  // Cambia esto por la ruta correcta a tu archivo fpdf.php
include '../Model/conexionPDO.php';

class PDF extends FPDF
{
    function Header()
    {
        // Título
        date_default_timezone_set('America/Bogota'); // Ejemplo para Colombia
        $fecha_hora_actual = date('d/m/Y H:i');
        $this->SetFont('Arial', '', 12);
        $this->Cell(300, 10, 'Fecha y Hora: ' . $fecha_hora_actual, 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, utf8_decode('Historia Médica'), 0, 1, 'C');
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
    die('No se ha especificado una historia médica.');
}

// Obtiene el ID de la historia médica
$id_historia_medica = $_GET['id'];

// Conexión a la base de datos
$db = new Database();
$conexion = $db->connectar();

// Consulta para obtener los datos de la historia médica
$consulta = 'SELECT historia_medica.*,
CONCAT(paciente.nombre, " ", paciente.apellido1, " ", paciente.apellido2) AS nombre_paciente
FROM historia_medica 
JOIN crear_usuario AS paciente ON historia_medica.usuario = paciente.id_usuario
WHERE historia_medica.id_Historia_Medica = :id_historia_medica';
$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':id_historia_medica', $id_historia_medica, PDO::PARAM_INT);
$stmt->execute();
$historia_medica = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se encontraron los datos
if (!$historia_medica) {
    die('Historia médica no encontrada.');
}



// Crear instancia de PDF
$pdf = new PDF();
$pdf->AddPage();

// Añadir datos de la historia médica
$pdf->SetFont('Arial', '', 12);
$pdf->ChapterTitle('ID Entrada Historia Medica: ' . htmlspecialchars($historia_medica['id_Historia_Medica']));
$pdf->ChapterBody('Nombre del Paciente: ' . htmlspecialchars($historia_medica['nombre_paciente']));
$pdf->ChapterBody('Pruebas Realizadas: ' . htmlspecialchars($historia_medica['pruebas_Realizada']));
$pdf->ChapterBody('Cirugías: ' . htmlspecialchars($historia_medica['cirugias']));
$pdf->ChapterBody('Medicamentos Recetados: ' . htmlspecialchars($historia_medica['medicamentos_Recetados']));
$pdf->ChapterBody('Análisis Realizados: ' . htmlspecialchars($historia_medica['análisis_Realizados']));
/*$pdf->ChapterBody('Resultados de Análisis: ' . htmlspecialchars($historia_medica['resultados_analisis']));*/
$pdf->ChapterBody('Tratamientos: ' . htmlspecialchars($historia_medica['tratamientos']));
$pdf->ChapterBody('Procesos: ' . htmlspecialchars($historia_medica['procesos']));
$pdf->ChapterBody('Diagnóstico: ' . htmlspecialchars($historia_medica['diagnostico']));
$pdf->ChapterBody('Tratamientos Quirúrgicos: ' . htmlspecialchars($historia_medica['Tratamientos_Quirurgicos']));
$pdf->ChapterBody('Hospitalizaciones: ' . htmlspecialchars($historia_medica['Hospitalizaciones']));
$pdf->ChapterBody('Formulas: ' . htmlspecialchars($historia_medica['formulas']));
$pdf->ChapterBody('Alergias: ' . htmlspecialchars($historia_medica['alergias']));
/*$pdf->ChapterBody('Consumo de Tabaco: ' . htmlspecialchars($historia_medica['consumo_tabaco']));
$pdf->ChapterBody('Consumo de Alcohol: ' . htmlspecialchars($historia_medica['consumo_alcohol']));
$pdf->ChapterBody('Consumo de Drogas: ' . htmlspecialchars($historia_medica['consumo_drogas']));
$pdf->ChapterBody('Actividad Física: ' . htmlspecialchars($historia_medica['actividad_fisica']));
$pdf->ChapterBody('Resultados de Imágenes: ' . htmlspecialchars($historia_medica['resultados_imagenes']));*/
$pdf->ChapterBody('Fecha y Hora: ' . htmlspecialchars($historia_medica['fecha_hora']));
$pdf->ChapterBody('Lugar: ' . htmlspecialchars($historia_medica['lugar']));

// Mostrar el PDF en el navegador
$pdf->Output('I', 'historia_medica_' . $id_historia_medica . '.pdf'); // 'I' para mostrar en el navegador
?>


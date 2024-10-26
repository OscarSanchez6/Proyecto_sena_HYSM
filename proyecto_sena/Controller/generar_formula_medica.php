<?php
session_start();
require_once('../FPDF/fpdf.php'); 

if (!isset($_GET['id'])) {
    die('ID de fórmula no proporcionado');
}

$id_formula = $_GET['id'];

include '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar();

$consulta = 'SELECT formulas_medicas.*, 
    CONCAT(paciente.nombre, " ", paciente.apellido1, " ", paciente.apellido2) AS nombre_paciente,
    paciente.numero_documento,
    CONCAT(doctor.nombre, " ", doctor.apellido1, " ", doctor.apellido2) AS nombre_doctor
    FROM formulas_medicas
    JOIN crear_usuario AS paciente ON formulas_medicas.usuario = paciente.id_usuario
    JOIN crear_usuario AS doctor ON formulas_medicas.Doctor = doctor.id_usuario
    WHERE formulas_medicas.id_formulas = :id_formula';

$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':id_formula', $id_formula);
$stmt->execute();
$formula = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$formula) {
    die('Fórmula médica no encontrada');
}

class PDF extends FPDF
{
    function Header()
    {
        date_default_timezone_set('America/Bogota'); // Ejemplo para Colombia
        $fecha_hora_actual = date('d/m/Y H:i');
        $this->SetFont('Arial', '', 12);
        $this->Cell(300, 10, 'Fecha y Hora: ' . $fecha_hora_actual, 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,utf8_decode('Fórmula Médica'),0,1,'C');
        $this->Ln(10);
    }
    
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('Número de Fórmula: ' . $formula['id_formulas']),0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,utf8_decode('Paciente: ' . $formula['nombre_paciente']),0,1);
$pdf->Cell(0,10,utf8_decode('Número de Documento: ' . $formula['numero_documento']),0,1);
$pdf->Ln(10);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('Medicamento Recetado:'),0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,utf8_decode('Nombre del medicamento: ' . $formula['nombre_medicamento']),0,1);
$pdf->Cell(0,10,utf8_decode('Dosis: ' . $formula['dosis']),0,1);
$pdf->Cell(0,10,utf8_decode('Instrucciones: ' . $formula['instrucciones']),0,1);
$pdf->Ln(10);
$pdf->Ln(10);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,utf8_decode('Doctor que receta:'),0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,utf8_decode(' Doctor: ' . $formula['nombre_doctor']),0,1);
$pdf->Cell(0,10,utf8_decode('Fecha de formulación: ' . $formula['fecha_Formulacion']),0,1);
$pdf->Cell(0,10,utf8_decode('Fecha de vencimiento: ' . $formula['fecha_Vencimiento']),0,1);
$pdf->Cell(0,10,utf8_decode('Lugar de entrega: ' . $formula['lugar_Entrega']),0,1);

$pdf->Output('I', 'Formula_Medica_' . $formula['id_formulas'] . '.pdf');
?>
	

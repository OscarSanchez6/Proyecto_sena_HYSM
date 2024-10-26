<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = __DIR__ . '/uploads/' . $file; // Ruta que nos va a direccionar a donde esta el  archivo

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        
        flush();
        readfile($filePath);
        exit;
    } else {
        echo "El archivo no existe en la ruta especificada";
    }
} else {
    echo "No se ha especificado el archivo a seleccionar";
}
?>

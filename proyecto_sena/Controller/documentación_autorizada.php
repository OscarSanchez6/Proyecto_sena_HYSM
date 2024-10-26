<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis autorizaciones</title>
    <link rel="stylesheet" href="../css/documentacion1.css">
    <link rel="icon" href="logo.ico">
</head>
<body>
   <?php include_once '../View/header_documentación.php'; ?>

    <h1 class="tabla-titulo">Mis autorizaciones</h1>
    <div class="tabla-container">
    <?php if ($documentacion_autorizada):?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Historias Clínicas</th>
                    <th>Informes Médicos</th>
                    <th>Autorizaciones de Seguros</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cita['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($cita['motivo']); ?></td>
                        <td><?php echo htmlspecialchars($cita['nombre_doctor']); ?></td>
                        <td><?php echo htmlspecialchars($cita['Tipo_especialidades']); ?></td>
                        <td><?php echo htmlspecialchars($cita['fecha_hora']); ?></td>
                        <td><?php echo htmlspecialchars($cita['lugar_De_Atencion']); ?></td>
                        <!--<td><?php echo htmlspecialchars($cita['turno']); ?></td>-->
                        <td><?php echo htmlspecialchars($cita['Estado_cita']); ?></td>
                        <td>
                            <form action="cancelar_Cita.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta cita?');">
                                <input type="hidden" name="Id_Citas" value="<?php echo $cita['Id_Citas']; ?>">
                                <button type="submit" class="btn-cancelar">Cancelar Cita</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    <?php else: ?>
        <p class="mensaje-Citas">Aún no tienes documentación autorizada.</p>
    <?php endif; ?>
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
<?php
    include_once '../View/footer.php';
    ?>
</body>
</html>

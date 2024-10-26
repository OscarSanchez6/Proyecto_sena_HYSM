<?php
include_once '../Model/conexionPDO.php';
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}
$doctorId = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exámenes Médicos</title>
    <link rel="stylesheet" href="../Css/doctor.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php 
    include_once '../View/header_usuarios.php';
?>
<h1 class="tabla-titulo">Exámenes Médicos</h1>
<div class="search-container">
    <div class="input-container">
        <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Nombre de Usuario o Exámen">
        <img src="../Img/lupa.png" alt="Buscar" class="search-icon">
    </div>
</div>

<div class="centered-table-container">
    <div id="datos_buscador"></div>

    <div id="tabla_principal">
        <?php
            try {
                $db = new Database(); 
                $conexion = $db->connectar(); 

                $observar = "SELECT 
                    e.id_Examenes,
                    e.usuario AS id_usuario,
                    u.nombre AS usuarioDescripcion,
                    u.apellido1 AS usuarioApellido,
                    u.apellido2 AS usuarioApellido2,
                    e.tipo_De_Pruebas AS tipoExamen,
                    ex.Examen AS examenDescripcion,
                    e.información_Paciente,
                    e.resultados,
                    e.fecha_hora,
                    e.datos_Hospital,
                    e.diagnostico,
                    e.tratamiento,
                    e.doctor_encargado
                FROM examenes e
                JOIN crear_usuario u ON e.usuario = u.id_usuario
                JOIN examenes_medicos ex ON e.tipo_De_Pruebas = ex.id_Examenes
                WHERE e.doctor_encargado = :doctorId";

                $statement = $conexion->prepare($observar);
                $statement->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
                $statement->execute();
                if ($statement) {
                    echo '<table align="center">
                        <tr>
                            <th>ID</th>
                            <th>USUARIO</th>
                            <th>EXAMEN</th>
                            <th>INFORMACIÓN ADICIONAL</th>
                            <th>RESULTADOS</th>
                            <th>FECHA Y HORA</th>
                            <th>INFORMACIÓN DEL HOSPITAL</th>
                            <th>DIAGNOSTICO</th>
                            <th>TRATAMIENTO</th>
                        </tr>';

                    while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $id = $filas['id_Examenes'];
                        $nomUsuario = $filas['usuarioDescripcion'];
                        $apellido1 = $filas['usuarioApellido'];
                        $apellido2 = $filas['usuarioApellido2'];
                        $tipoExamen = $filas['examenDescripcion'];
                        $infoPaciente = $filas['información_Paciente'];
                        $resultados = $filas['resultados']; 
                        $fechaHora = $filas['fecha_hora'];
                        $hospital = $filas['datos_Hospital'];
                        $diagnostico = $filas['diagnostico'];
                        $tratamiento = $filas['tratamiento'];
                        $datos = $nomUsuario . " " . $apellido1 . " " . $apellido2;

                        // Asumir que $resultados contiene un archivo PDF o similar
                        $pdfDownloadUrl = '../Controller/download.php?file=' . urlencode($resultados);

                        echo '<tr align="center">
                                <td>' . htmlspecialchars($id) . '</td>
                                <td>' . htmlspecialchars($datos) . '</td>
                                <td>' . htmlspecialchars($tipoExamen) . '</td>
                                <td>' . htmlspecialchars($infoPaciente) . '</td>
                                <td><a class="btn-descargar" href="' . htmlspecialchars($pdfDownloadUrl) . '">Ver Resultados</a></td>
                                <td>' . htmlspecialchars($fechaHora) . '</td>
                                <td>' . htmlspecialchars($hospital) . '</td>
                                <td>' . htmlspecialchars($diagnostico) . '</td>
                                <td>' . htmlspecialchars($tratamiento) . '</td>
                            </tr>';
                    }
                    echo '</table>';
                } else {
                    echo 'Error en la consulta.';
                }
            } catch (PDOException $e) {
                die("Error en conexión a la base de datos: " . $e->getMessage());
            }
        ?>
    </div>
</div>
<br><br>

<script type="text/javascript">
    function buscar_ahora() {
        var buscar = document.getElementById('buscar_1').value.trim();
        var parametros = { "buscarExamen": buscar };

        console.log('Buscando:', parametros);

        if (buscar === '') {
            document.getElementById("datos_buscador").innerHTML = '';
            document.getElementById("tabla_principal").style.display = 'block'; 
        } 
        else {
            $.ajax({
                data: parametros,
                type: 'POST',
                url: '../Controller/buscador2.php',
                success: function (data) {
                    console.log('Datos recibidos:', data);

                    if (data.trim() === '') {
                        document.getElementById("datos_buscador").innerHTML = '';
                        document.getElementById("tabla_principal").style.display = 'block'; 
                    } 
                    else {
                        document.getElementById("datos_buscador").innerHTML = data;
                        document.getElementById("tabla_principal").style.display = 'none'; 
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }
    }

    document.getElementById('buscar_1').addEventListener('input', function() {
        if (this.value.trim() === '') {
            document.getElementById("tabla_principal").style.display = 'block';
            document.getElementById("datos_buscador").innerHTML = '';
        } else {
            buscar_ahora();
        }
    });
</script>

<?php
    include_once '../View/footer.php';
?>
</body>
</html>

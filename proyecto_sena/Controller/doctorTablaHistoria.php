<?php
include_once'../Model/conexionPDO.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/doctor2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Historia Médica</title>
</head>
<body>
<?php 
    include_once '../View/header_usuarios.php';
?>

<h1 class="tabla-titulo">Historia Médica</h1>
<div class="search-container">
    <div class="input-container">
        <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Nombre de Usuario">
        <img src="../Img/lupa.png" alt="Buscar" class="search-icon">
    </div>
</div>

<div class="tabla-container">
    <div id="datos_buscador"></div>

    <div id="tabla_principal" class="tabla-container">
        <?php
        try {
            $db = new Database();
            $conexion = $db->connectar();
            $query = "SELECT 
            historia.id_Historia_Medica,
            historia.usuario AS id_usuario,
            usuarios.nombre AS usuarioNombre,
            historia.usuario AS id_usuario,
            usuarios.apellido1 AS usuarioApellido,
            historia.usuario AS id_usuario,
            usuarios.apellido2 AS usuarioApellido2,
            historia.pruebas_Realizada,
            historia.cirugias,
            historia.medicamentos_Recetados,
            historia.análisis_Realizados,
            historia.tratamientos,
            historia.procesos,
            historia.diagnostico,
            historia.Tratamientos_Quirurgicos,
            historia.Hospitalizaciones,
            historia.formulas,
            historia.alergias,
            historia.fecha_hora,
            historia.lugar
            FROM historia_medica historia
            JOIN crear_usuario usuarios ON historia.usuario = usuarios.id_usuario";

            $stmt = $conexion->query($query);
            
            if ($stmt) {
                echo '<table class="tabla" align="center">
                    <tr>
                        <th>ID</th>
                        <th>USUARIO</th>
                        <th>PRUEBAS REALIZADAS</th>
                        <th>CIRUGIAS</th>
                        <th>MEDICAMENTOS RECETADOS</th>
                        <th>RESULTADOS</th>
                        <th>TRATAMIENTOS</th>
                        <th>PROCESOS</th>
                        <th>DIAGNOSTICOS</th>
                        <th>TRATAMIENTOS QUIRURGICOS</th>
                        <th>HOSPITALIZACIONES</th>
                        <th>FORMULAS</th>
                        <th>ALERGIAS</th>
                        <th>FECHA Y HORA</th>
                        <th>LUGAR</th>
                        <th>EDITAR</th>
                    </tr>';

                while ($filas = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $filas['id_Historia_Medica'];
                    $nomUsuario = htmlspecialchars($filas['usuarioNombre']);
                    $apellido1 = htmlspecialchars($filas['usuarioApellido']);
                    $apellido2 = htmlspecialchars($filas['usuarioApellido2']);
                    $pruebas = htmlspecialchars($filas['pruebas_Realizada']);
                    $cirugias = htmlspecialchars($filas['cirugias']);
                    $medicamentos = htmlspecialchars($filas['medicamentos_Recetados']);
                    $resultados = $filas['análisis_Realizados']; 
                    $tratamientos = htmlspecialchars($filas['tratamientos']);
                    $procesos = htmlspecialchars($filas['procesos']);
                    $diagnosticos = htmlspecialchars($filas['diagnostico']);
                    $tratamientosQuirurgicos = htmlspecialchars($filas['Tratamientos_Quirurgicos']);
                    $hospitalizaciones = htmlspecialchars($filas['Hospitalizaciones']);
                    $formulas = htmlspecialchars($filas['formulas']);
                    $alergias = htmlspecialchars($filas['alergias']);
                    $fechaHora = htmlspecialchars($filas['fecha_hora']);
                    $lugar = htmlspecialchars($filas['lugar']);
                    $datos = $nomUsuario . " " . $apellido1 . " " . $apellido2;
                    $pdfDownloadUrl = '../Controller/download.php?file=' . urlencode($resultados);
        
                    echo '<tr align="center">
                        <td>' . $id . '</td>
                        <td>' . $datos . '</td>
                        <td>' . $pruebas . '</td>
                        <td>' . $cirugias . '</td>
                        <td>' . $medicamentos . '</td>
                        <td><a class="btn-descargar" href="' . $pdfDownloadUrl . '">Ver Resultados</a></td>
                        <td>' . $tratamientos . '</td>
                        <td>' . $procesos . '</td>
                        <td>' . $diagnosticos . '</td>
                        <td>' . $tratamientosQuirurgicos . '</td>
                        <td>' . $hospitalizaciones . '</td>
                        <td>' . $formulas . '</td>
                        <td>' . $alergias . '</td>
                        <td>' . $fechaHora . '</td>
                        <td>' . $lugar . '</td>
                        <td><a href="doctorTablaHistoria.php?editar=' . $id . '">Editar</a></td>
                    </tr>';
                }
                echo '</table>';
            } else {
                echo 'Error en la consulta.';
            }
        } catch (PDOException $e) {
            die("Error en conexión a la base de datos: " . $e->getMessage());
        }

        if (isset($_GET['editar'])) {
            try {
                $editar_id = $_GET['editar'];
                $db = new Database();
                $conexion = $db->connectar();
                $query = "SELECT * FROM historia_medica WHERE id_Historia_Medica = :id";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':id', $editar_id);
                $stmt->execute();
                
                if ($stmt) {
                    $filas = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($filas) {
                        $pruebas = htmlspecialchars($filas['pruebas_Realizada']);
                        $cirugias = htmlspecialchars($filas['cirugias']);
                        $medicamentos = htmlspecialchars($filas['medicamentos_Recetados']);
                        $resultados = htmlspecialchars($filas['análisis_Realizados']);
                        $tratamientos = htmlspecialchars($filas['tratamientos']);
                        $procesos = htmlspecialchars($filas['procesos']);
                        $diagnosticos = htmlspecialchars($filas['diagnostico']);
                        $tratamientosQuirurgicos = htmlspecialchars($filas['Tratamientos_Quirurgicos']);
                        $hospitalizaciones = htmlspecialchars($filas['Hospitalizaciones']);
                        $formulas = htmlspecialchars($filas['formulas']);
                        $alergias = htmlspecialchars($filas['alergias']);
                        $fechaHora = htmlspecialchars($filas['fecha_hora']);
                        $lugar = htmlspecialchars($filas['lugar']);
                        
                        echo '<table class="tabla" border="6" align="center">
                            <tr>
                                <td>
                                <div align="center">
                                <h1>Actualización de Datos</h1>
                                <form method="POST" action="#" enctype="multipart/form-data">
                                    PRUEBAS <input type="text" name="pruebas" value="' . $pruebas . '"><br>
                                    CIRUGIAS <input type="text" name="cirugias" value="' . $cirugias . '"><br>
                                    MEDICAMENTOS <input type="text" name="medicamentos" value="' . $medicamentos . '"><br>
                                    RESULTADOS <input type="file" id="pdf" name="pdfs" accept=".pdf"><br>
                                    TRATAMIENTOS <input type="text" name="tratamientos" value="' . $tratamientos . '"><br>
                                    PROCESOS <input type="text" name="procesos" value="' . $procesos . '"><br>
                                    DIAGNOSTICOS <input type="text" name="diagnosticos" value="' . $diagnosticos . '"><br>
                                    TRATAMIENTOS QUIRURGICOS <input type="text" name="tratamientosQuirurgicos" value="' . $tratamientosQuirurgicos . '"><br>
                                    HOSPITALIZACIONES <input type="text" name="hospitalizaciones" value="' . $hospitalizaciones . '"><br>
                                    FORMULAS <input type="text" name="formulas" value="' . $formulas . '"><br>
                                    ALERGIAS <input type="text" name="alergias" value="' . $alergias . '"><br>
                                    FECHA <input type="date" name="fecha" value="' . $fechaHora . '"><br>
                                    LUGAR <input type="text" name="lugar" value="' . $lugar . '"><br>
                                    <input type="submit" name="actualizar" value="Actualizar" style="cursor: pointer;
                                background-color: #1d72e9;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;">
                                </form>
                                </div>
                                </td>
                            </tr>
                        </table>';
                    } else {
                        echo 'No se encontraron datos para editar.';
                    }
                } else {
                    echo 'Error en la consulta para edición.';
                }
            } catch (PDOException $e) {
                die("Error en conexión a la base de datos: " . $e->getMessage());
            }
        }

        if (isset($_POST['actualizar'])) {
            $pruebas = $_POST['pruebas'];
            $cirugias = $_POST['cirugias'];
            $medicamentos = $_POST['medicamentos'];
            $resultados = $_FILES['pdfs']['name'];
            $tratamientos = $_POST['tratamientos'];
            $procesos = $_POST['procesos'];
            $diagnosticos = $_POST['diagnosticos'];
            $tratamientosQuirurgicos = $_POST['tratamientosQuirurgicos'];
            $hospitalizaciones = $_POST['hospitalizaciones'];
            $formulas = $_POST['formulas'];
            $alergias = $_POST['alergias'];
            $fecha = $_POST['fecha'];
            $lugar = $_POST['lugar'];

            $filePath = "../Result/" . basename($resultados);
            if (move_uploaded_file($_FILES['pdfs']['tmp_name'], $filePath)) {
                try {
                    $db = new Database();
                    $conexion = $db->connectar();
                    $query = "UPDATE historia_medica SET 
                    pruebas_Realizada = :pruebas, 
                    cirugias = :cirugias,
                    medicamentos_Recetados = :medicamentos,
                    análisis_Realizados = :resultados,
                    tratamientos = :tratamientos,
                    procesos = :procesos,
                    diagnostico = :diagnosticos,
                    Tratamientos_Quirurgicos = :tratamientosQuirurgicos,
                    Hospitalizaciones = :hospitalizaciones,
                    formulas = :formulas,
                    alergias = :alergias,
                    fecha_hora = :fecha,
                    lugar = :lugar
                    WHERE id_Historia_Medica = :id";
                    
                    $stmt = $conexion->prepare($query);
                    $stmt->bindParam(':pruebas', $pruebas);
                    $stmt->bindParam(':cirugias', $cirugias);
                    $stmt->bindParam(':medicamentos', $medicamentos);
                    $stmt->bindParam(':resultados', $filePath);
                    $stmt->bindParam(':tratamientos', $tratamientos);
                    $stmt->bindParam(':procesos', $procesos);
                    $stmt->bindParam(':diagnosticos', $diagnosticos);
                    $stmt->bindParam(':tratamientosQuirurgicos', $tratamientosQuirurgicos);
                    $stmt->bindParam(':hospitalizaciones', $hospitalizaciones);
                    $stmt->bindParam(':formulas', $formulas);
                    $stmt->bindParam(':alergias', $alergias);
                    $stmt->bindParam(':fecha', $fecha);
                    $stmt->bindParam(':lugar', $lugar);
                    $stmt->bindParam(':id', $_GET['editar']);
                    
                    if ($stmt->execute()) {
                        echo "Datos actualizados correctamente.";
                    } else {
                        echo "Error al actualizar los datos.";
                    }
                } catch (PDOException $e) {
                    die("Error en conexión a la base de datos: " . $e->getMessage());
                }
            } else {
                echo "Error al subir el archivo.";
            }
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    function buscar_ahora() {
        var buscar = document.getElementById('buscar_1').value.trim();
        var parametros = { "buscarHistoria": buscar };

        if (buscar === '') {
            document.getElementById("datos_buscador").innerHTML = '';
            document.getElementById("tabla_principal").style.display = 'block'; 
        } 
        else {
            $.ajax({
                data: parametros,
                type: 'POST',
                url: 'buscadorH.php',
                success: function (data) {
                    if (data.trim() === '') 
                    {
                        document.getElementById("datos_buscador").innerHTML = '';
                        document.getElementById("tabla_principal").style.display = 'block'; 
                    } 
                    else 
                    {
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
</body>
</html>
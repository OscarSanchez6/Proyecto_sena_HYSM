<?php
include_once '../Model/conexionPDO.php';
session_start();
if (!isset($_SESSION['rol'])) {
    header('location: inicio_Sesion_Usuario.php');
    die(); exit();
} else {
    if ($_SESSION['rol'] != 1) {
        header('location: inicio_Sesion_Usuario.php');
        die(); exit();
    }
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
    <title>Incapacidades</title>
    <link rel="stylesheet" href="../Css/doctor.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include_once '../View/header_usuarios.php'; ?>

    <h1 class="tabla-titulo">Incapacidades</h1>
    <div class="search-container">
        <div class="input-container">
            <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Nombre de Usuario o Fechas">
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
                    incapacidad.id_Incapacidad,
                    incapacidad.id_usuario AS id_usuario,
                    usuario.nombre AS usuarioDescripcion,
                    usuario.apellido1 AS usuarioApellido,
                    usuario.apellido2 AS usuarioApellido2,
                    incapacidad.motivos,
                    incapacidad.fecha_inicio,
                    incapacidad.fecha_fin,
                    incapacidad.recomendaciones_medicamentos
                FROM incapacidades incapacidad
                JOIN crear_usuario usuario ON incapacidad.id_usuario = usuario.id_usuario
                WHERE incapacidad.doctor_encargado=:doctorId";

                $statement = $conexion->prepare($observar);
                $statement->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
                $statement->execute();
                if ($statement) {
                    echo '<table align="center">
                        <tr>    
                            <th>ID</th>
                            <th>USUARIO</th>
                            <th>MOTIVOS</th>
                            <th>FECHA DE INICIO</th>
                            <th>FECHA DE TERMINACIÓN</th>
                            <th>RECOMENDACIONES</th>
                        </tr>';

                    while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $id = $filas['id_Incapacidad'];
                        $nomUsuario = $filas['usuarioDescripcion'];
                        $apellido1 = $filas['usuarioApellido'];
                        $apellido2 = $filas['usuarioApellido2'];
                        $motivos = $filas['motivos'];
                        $fInicio = $filas['fecha_inicio'];    
                        $fFin = $filas['fecha_fin'];
                        $recomendaciones = $filas['recomendaciones_medicamentos'];
                        $datos = $nomUsuario . " " . $apellido1 . " " . $apellido2;

                        echo '<tr align="center">
                                <td>' . $id . '</td>
                                <td>' . $datos . '</td>
                                <td>' . $motivos . '</td>
                                <td>' . $fInicio . '</td>
                                <td>' . $fFin . '</td>
                                <td>' . $recomendaciones . '</td>
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
            var parametros = { "buscarIncapacidades": buscar };

            if (buscar === '') {
                document.getElementById("datos_buscador").innerHTML = '';
                document.getElementById("tabla_principal").style.display = 'block'; 
            } else {
                $.ajax({
                    data: parametros,
                    type: 'POST',
                    url: '../Controller/buscador2.php',
                    success: function (data) {
                        console.log('Datos recibidos:', data);
                        if (data.trim() === '') {
                            document.getElementById("datos_buscador").innerHTML = '';
                            document.getElementById("tabla_principal").style.display = 'block'; 
                        } else {
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
    <?php include_once '../View/footer.php'; ?>
</body>
</html>

<?php
include_once '../Model/conexionPDO.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

session_start();
if (!isset($_SESSION['rol'])) {
    header('location: inicio_Sesion_Usuario.php');
    die();
} 
else 
{
    if ($_SESSION['rol'] != 1) 
    {
        header('location: inicio_Sesion_Usuario.php');
        die();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Médicas</title>
    <link rel="stylesheet" href="../Css/doctor.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include_once '../View/header_usuarios.php'; ?>
    <h1 class="tabla-titulo">Citas Médicas</h1>
    <div class="search-container">
        <div class="input-container">
            <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Nombre de Usuario">
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
                $observar = 
            "SELECT 
            citas.Id_Citas,
            citas.tipo_cita AS id_tipo_cita,
            tipoCita.Descripcion AS tipoCitaDescripcion,
            citas.motivo,
            citas.id_usuario AS id_usuario,
            usuarios.nombre AS usuarioNombre,
            usuarios.apellido1 AS usuarioApellido,
            usuarios.apellido2 AS usuarioApellido2,
            citas.doctor_asignado AS doctorId,
            citas.id_especialidades AS id_especialidades,
            especialidad.Tipo_especialidades AS especialidadDescripcion,
            citas.fecha_hora,
            citas.lugar_De_Atencion,
            citas.turno,
            citas.id_estado_citas AS id_estado_citas,
            estadoCitas.Estado_cita AS estadoCitaDescripcion
            FROM citas_medicas citas
            JOIN tipos_de_cita tipoCita ON citas.tipo_cita = tipoCita.id_tipo_cita
            JOIN crear_usuario usuarios ON citas.id_usuario = usuarios.id_usuario
            JOIN especialidades especialidad ON citas.id_especialidades = especialidad.id_especialidades
            JOIN estados_citas estadoCitas ON citas.id_estado_citas = estadoCitas.id_estado_citas
            WHERE citas.doctor_asignado = :doctorId;";

            
                $statement = $conexion->prepare($observar);
                $statement->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
                $statement->execute();
                if ($statement) {
                    echo '<table align="center">
                        <tr>
                            <th>ID</th>
                            <th>TIPO DE CITA</th>
                            <th>MOTIVOS</th>
                            <th>USUARIO</th>
                            <th>FECHA Y<BR> HORA</th>
                            <th>LUGAR DE ATENCIÓN</th>
                            <th>ESTADO DE CITA</th>
                            <th>MODIFICAR</th>
                        </tr>';

                    while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $id = $filas['Id_Citas'];
                        $tipoCita = $filas['tipoCitaDescripcion'];
                        $motivo = $filas['motivo'];
                        $usuario = $filas['usuarioNombre'];
                        $apellido1 = $filas['usuarioApellido'];
                        $apellido2 = $filas['usuarioApellido2'];
                        $fechaHora = $filas['fecha_hora'];
                        $lugarAtencion = $filas['lugar_De_Atencion'];
                        $estadoCitas = $filas['estadoCitaDescripcion'];
                        $datos = $usuario . " " . $apellido1 . " " . $apellido2;

                        echo '<tr align="center">
                                <td>' . htmlspecialchars($id) . '</td>
                                <td>' . htmlspecialchars($tipoCita) . '</td>
                                <td>' . htmlspecialchars($motivo) . '</td>
                                <td>' . htmlspecialchars($datos) . '</td>
                                <td>' . htmlspecialchars($fechaHora) . '</td>
                                <td>' . htmlspecialchars($lugarAtencion) . '</td>
                                <td>' . htmlspecialchars($estadoCitas) . '</td>
                                <td><a href="doctorCitasMedicas.php?editar=' . urlencode($id) . '">Editar</a></td>
                            </tr>';
                    }
                    echo '</table></div>';
                } else {
                    echo 'Error en la consulta.';
                }
            } catch (PDOException $e) {
                die("Error en conexión a la base de datos: " . $e->getMessage());
            }

            if (isset($_GET['editar'])) {
                $editar_id = $_GET['editar'];

                try {
                    $db = new Database();
                    $conexion = $db->connectar();
                    $observar = "SELECT * FROM citas_medicas WHERE Id_Citas = :idCita";
                    $stmt = $conexion->prepare($observar);
                    $stmt->bindParam(':idCita', $editar_id);
                    $stmt->execute();
                    
                    if ($stmt) {
                        $filas = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($filas) {
                            $id = $filas['Id_Citas'];
                            $tipoCita = $filas['tipo_cita'];
                            $motivo = $filas['motivo'];
                            $usuario = $filas['id_usuario'];
                            $fechaHora = $filas['fecha_hora'];
                            $lugarAtencion = $filas['lugar_De_Atencion'];
                            $estadoCitas = $filas['id_estado_citas'];
            ?>
            <table border="2" align="center">
                <tr>
                    <td>
                        <div align="center">
                            <h1>Modificación de Cita</h1>
                            <form method="POST" action="">
                                <input type="hidden" name="idCita" value="<?php echo htmlspecialchars($id); ?>">
                                <label>ESTADO CITA MEDICA</label>
                                <select id="estadoCita" name="estadoCita" required>
                                    <option value="0">Seleccione una opción</option>
                                    <option value="1">Aplazada</option>
                                    <option value="2">Cancelada</option>
                                    <option value="3">Asistida</option>
                                    <option value="4">Confirmada</option>
                                    <option value="5">Pendiente por asignar</option>
                                    <option value="6">No asistida</option>
                                    <option value="7">Reprogramada</option>
                                    <option value="8">En espera</option>
                                    <option value="9">Completada</option>
                                    <option value="10">Pendiente por confirmación</option>
                                    <option value="11">Confirmada por paciente</option>
                                    <option value="12">Confirmada por médico</option>
                                    <option value="13">En proceso</option>
                                    <option value="14">Esperando confirmación</option>
                                </select><br><br>
                                <input type="submit" name="actualizame" value="Actualizar Datos" style="cursor: pointer;
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
    border-radius: 5px;"><br>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
                        }
                    } else {
                        echo 'Error en la consulta.';
                    }
                } catch (PDOException $e) {
                    die("Error en conexión a la base de datos: " . $e->getMessage());
                }
            }

            if (isset($_POST['actualizame'])) {
                $actualizacitas = $_POST['estadoCita'];
                $idCita = $_POST['idCita'];

                try {
                    $db = new Database();
                    $conexion = $db->connectar();

                    $queryEmail = "SELECT correo FROM crear_usuario WHERE id_usuario = (SELECT id_usuario FROM citas_medicas WHERE Id_Citas = :idCita)";
                    $stmtEmail = $conexion->prepare($queryEmail);
                    $stmtEmail->bindParam(':idCita', $idCita);
                    $stmtEmail->execute();
                    $emailRow = $stmtEmail->fetch(PDO::FETCH_ASSOC);

                    $queryEstadoDescripcion = "SELECT Estado_cita FROM estados_citas WHERE id_estado_citas = :estadoCita";
                    $stmtEstadoDescripcion = $conexion->prepare($queryEstadoDescripcion);
                    $stmtEstadoDescripcion->bindParam(':estadoCita', $actualizacitas);
                    $stmtEstadoDescripcion->execute();
                    $estadoRow = $stmtEstadoDescripcion->fetch(PDO::FETCH_ASSOC);

                    if ($emailRow && $estadoRow) {
                        $email = $emailRow['correo'];
                        $estadoCitaDescripcion = $estadoRow['Estado_cita'];

                        $queryUpdate = "UPDATE citas_medicas SET id_estado_citas = :estadoCita WHERE Id_Citas = :idCita";
                        $stmtUpdate = $conexion->prepare($queryUpdate);
                        $stmtUpdate->bindParam(':estadoCita', $actualizacitas);
                        $stmtUpdate->bindParam(':idCita', $idCita);
                        $stmtUpdate->execute();

                        if ($stmtUpdate->rowCount() > 0) {
                            sendNotification($email, $idCita, $estadoCitaDescripcion);
                            echo "<script>window.location.href='doctorCitasMedicas.php';</script>";
                        } else {
                            echo "<script>alert('No se pudo actualizar la cita');</script>";
                        }
                    } else {
                        echo "<script>alert('No se encontró el correo electrónico del usuario o la descripción del estado de la cita');</script>";
                    }
                } catch (PDOException $e) {
                    die("Error en conexión a la base de datos: " . $e->getMessage());
                }
            }

            function sendNotification($email, $idCita, $estadoCitaDescripcion) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp-mail.outlook.com';
                    $mail->SMTPAuth   = true;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Username   = 'hysmanagement@hotmail.com';
                    $mail->Password   = 'h12345*,';
                    $mail->Port       = 587;
                    $mail->CharSet    = 'utf8';

                    $mail->setFrom('hysmanagement@hotmail.com', 'Notificador Digital');
                    $mail->addAddress($email, 'User');

                    $mail->addEmbeddedImage('../Img/logo.png', 'logo.png', 'logo.png');

                    $mail->isHTML(true);
                    $mail->Subject = 'Actualización de Cita Médica';
                    $mail->Body = "<html>
                    <head>
                        <style>
                            header {
                            background-color: deepskyblue;
                            color: white;
                            padding: 20px;
                            height: 55px;
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            border-bottom: 3px solid #18dde8;
                            position: relative;
                        }
                            
                            .logo img {
                            height: 90px; 
                            display: block; 
                            margin: 0; 
                            margin-right: 340px;
                        }
                            .titulo {
                            font-family: Arial, sans-serif;
                            color: white;
                            font-size: 30px;
                            text-align: center;
                            flex: 1; 
                            margin: 0;
                        }

                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                            height: 100%;
                            width: 100%;
                            background-color: white;
                        }

                        h2 {
                            color: #76bde9;
                        }

                        .footer-texto {
                            font-size: 17px;
                            text-align: center;
                            margin: 0;
                            padding: 20px;
                            background-color: deepskyblue;
                            color: white;
                            align-items: center;
                            bottom: 0%;
                            position: flex;
                        }
                        </style>
                    </head>
                    <body>
                    <header>
                        <div class='logo'>
                            <img src='cid:logo.png' alt='Logo'>
                        </div>
                        <div class='titulo'>Agendamiento</div>
                    </header>
                        <h2>Estimado Usuario <br><br> HYSM le informa que su cita médica ha sido actualizada<br>Estado: $estadoCitaDescripcion <br><br>
                            Por favor no responda a este correo. <br><br>Para cualquier información adicional puede consultar nuestra página principal o comunicarse con nosotros por medio del aplicativo web. Este correo fue enviado por petición suya. 
                            Toda información contenida en este mensaje es considerada de carácter confidencial y/o privilegiado y está dirigida únicamente a su destinatario, quien por tal razón es el único autorizado para leerla y utilizarla. 
                            Si usted ha recibido por error este mensaje debe eliminarlo totalmente de su sistema y comunicar tal situación al remitente de inmediato.<br><br>Si deseas modificar tu agendamiento nuevamente inicia sesión: <br><br><a href='http://localhost/Proyecto/View/inicio_Sesion_Usuario.php' style='display: inline-block;
                            padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-align: center; text-decoration: none; border-radius: 4px; border: none; cursor: pointer;'>Iniciar Sesión</a></h2>
                            <p class='footer-texto'>&copy; 2024 Health And Services Management. Todos los derechos reservados.</p>
                    </body>
                    </html>";

                $mail->send();
                echo 'Notificación enviada';
            } catch (Exception $e) {
                echo "No se pudo enviar la notificación. Error: {$mail->ErrorInfo}";
            }
        }
        ?>
    </div><br><br><br><br><br><br><br><br><br><br>

    <script type="text/javascript">
        function buscar_ahora() {
            var buscar = document.getElementById('buscar_1').value.trim(); 
            var parametros = { "buscarCita": buscar };

            if (buscar === '') {
                document.getElementById("datos_buscador").innerHTML = '';
                document.getElementById("tabla_principal").style.display = 'block'; 
            } 
            else {
                $.ajax({
                    data: parametros,
                    type: 'POST',
                    url: 'buscadorMedico.php',
                    success: function (data) {
                        if (data.trim() === '') {
                            // SI NO HAY NADA PUES NO SE MUESTRA NADA :)
                            document.getElementById("datos_buscador").innerHTML = '';
                            document.getElementById("tabla_principal").style.display = 'block'; 
                        } else {
                            // MOSTRAR RESULTADOS SI HAY ALGO
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

        // ESTA PARTE LO QUE HACE ES QUE NOS MUESTRA LA TABLA PRINCIPAL SI NO HAY NADA EN EL CAMPO DE BUSQUEDA
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
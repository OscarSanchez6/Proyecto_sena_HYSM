<?php
include_once '../Model/conexionPDO.php';

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
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$database = new Database();
$conexion = $database->connectar();

if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos.");
}
$showResult = false;
$showResults = false;
$showResults3 = false;
$showResults4 = false;
$showResults5 = false;
$numero = 0;
$numeros = 0;
$numero3 = 0;
$numero4 = 0;
$numero5 = 0;
$resultado = array();
$resultados = array();
$resultados3 = array();
$resultados4 = array();
$resultados5 = array();

// Aquiiii se realiza la busqueda para los usuarios
if (isset($_POST["buscar"]) && !empty(trim($_POST["buscar"]))) {
    $buscarUsuario = "%" . trim($_POST["buscar"]) . "%";
    $sql = "SELECT 
        CONCAT(dato.nombre, ' ', dato.apellido1, ' ', dato.apellido2) AS usuario,
        dato.id_usuario,
        dato.rol AS id_tipo_Rol,
        trol.Roles AS rol_descripcion,
        dato.tipo_documento_id AS id_tipo_documento,
        documento.Documento AS documentoDescripcion,
        dato.numero_documento,
        dato.contrasena,
        dato.edad,
        dato.sexo AS id_sexo,
        sexo.Sexo AS sexoDescripcion,
        dato.RH AS id_RH,
        sangre.RH AS sangre_descripcion,
        dato.correo,
        dato.altura,
        dato.peso
        FROM crear_usuario dato
        JOIN tabla_roles trol ON dato.rol = trol.id_tipo_Rol
        JOIN sexos sexo ON dato.sexo= sexo.id_sexo
        JOIN tipos_rh sangre ON dato.RH = sangre.id_RH
        JOIN tipo_documento documento ON dato.tipo_documento_id = documento.id_tipo_documento
        WHERE trol.id_tipo_Rol = 5
        AND CONCAT(dato.nombre, ' ', dato.apellido1, ' ', dato.apellido2, dato.numero_documento) LIKE :buscar";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':buscar', $buscarUsuario, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $numero = count($resultado);

    $showResult = true;
}

//BUSQUEDA DE TABLA FORMULAS
if (isset($_POST["buscarFormula"]) && !empty(trim($_POST["buscarFormula"]))) {
    $buscarFormulas = "%" . trim($_POST["buscarFormula"]) . "%";
    $sqlFormulas = "SELECT 
        CONCAT(usuario.nombre, ' ', usuario.apellido1, ' ', usuario.apellido2) AS usuario,
        formulas.id_formulas,
        formulas.usuario AS id_usuario,
        usuario.nombre AS descripcionNombre,
        formulas.nombre_medicamento,
        formulas.dosis,
        formulas.instrucciones,
        formulas.fecha_Formulacion,
        formulas.fecha_Vencimiento, 
        lugar_Entrega
        FROM formulas_medicas formulas
        JOIN crear_usuario usuario ON formulas.usuario = usuario.id_usuario
        WHERE CONCAT(usuario.nombre, ' ', usuario.apellido1, ' ', usuario.apellido2, formulas.nombre_medicamento) LIKE :buscarFormula AND formulas.Doctor =:doctorId";
    

    $stmt3 = $conexion->prepare($sqlFormulas);
    $stmt3->bindParam(':buscarFormula', $buscarFormulas, PDO::PARAM_STR);
    $stmt3->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
    $stmt3->execute();
    $resultados3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    $numeros3 = count($resultados3);

    $showResults3 = true;
}

// Aqui see buscan las citas medicas
if (isset($_POST["buscarCita"]) && !empty(trim($_POST["buscarCita"]))) {
    $buscar = "%" . trim($_POST["buscarCita"]) . "%";
    $sqlCitas = "SELECT 
        citas.Id_Citas,
        citas.tipo_cita AS id_tipo_cita,
        tipoCita.Descripcion AS tipoCitaDescripcion,
        citas.motivo,
        citas.id_usuario AS id_usuario,
        usuarios.nombre AS usuarioNombre,
        usuarios.apellido1 AS usuarioApellido,
        usuarios.apellido2 AS usuarioApellido2,
        CONCAT(usuarios.nombre, ' ', usuarios.apellido1, ' ', usuarios.apellido2) AS usuario,
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
        WHERE citas.doctor_asignado = :doctorId AND usuarios.nombre LIKE :buscarCita";

    $stmts = $conexion->prepare($sqlCitas);
    $stmts->bindParam(':buscarCita', $buscar, PDO::PARAM_STR);
    $stmts->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
    
    try {
        $stmts->execute();
        $resultados = $stmts->fetchAll(PDO::FETCH_ASSOC);
        $numeros = count($resultados);
        $showResults = true;
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../Css/doctor.css">
</head>
<body>

    <!-- Busqueda de USUARIOSSSS -->
    <?php if ($showResult): ?>
        <h5 class="card-title">Resultados encontrados (<?php echo htmlspecialchars($numero); ?>):</h5>
        <?php if ($numero > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>NOMBRE <br>COMPLETO</th>
                    <th>TIPO DOCUMENTO</th>
                    <th>NÚMERO DOCUMENTO</th>
                    <th>EDAD</th>
                    <th>SEXO</th>
                    <th>RH</th>
                    <th>CORREO</th>
                    <th>ALTURA</th>
                    <th>PESO</th>
                </tr>
                <?php foreach ($resultado as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($fila['documentoDescripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['numero_documento']); ?></td>
                        <td><?php echo htmlspecialchars($fila['edad']); ?></td>
                        <td><?php echo htmlspecialchars($fila['sexoDescripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['sangre_descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                        <td><?php echo htmlspecialchars($fila['altura']); ?></td>
                        <td><?php echo htmlspecialchars($fila['peso']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="card-text"><br>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Busqueda de FORMULAS -->
    <?php if ($showResults3): ?>
        <h5 class="card-title">Resultados encontrados (<?php echo htmlspecialchars($numeros3); ?>):</h5>
        <?php if ($numeros3 > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>USUARIO</th>
                    <th>NOMBRE DE MEDICAMENTOS</th>
                    <th>DOSIS</th>
                    <th>INSTRUCCIONES</th>
                    <th>FECHA FORMULACIÓN</th>
                    <th>FECHA VENCIMIENTO</th>
                    <th>CANTIDAD</th>
                </tr>
                <?php foreach ($resultados3 as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['id_formulas']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre_medicamento']); ?></td>
                        <td><?php echo htmlspecialchars($fila['dosis']); ?></td>
                        <td><?php echo htmlspecialchars($fila['instrucciones']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_Formulacion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_Vencimiento']); ?></td>
                        <td><?php echo htmlspecialchars($fila['lugar_Entrega']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="card-text"><br>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>

    <!-- CITAS MEDICAS -->
    <?php if ($showResults): ?>
        <h5 class="card-title">Resultados encontrados (<?php echo htmlspecialchars($numeros); ?>):</h5>
        <?php if ($numeros > 0): ?>
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>TIPO DE CITA</th>
                    <th>MOTIVOS</th>
                    <th>USUARIO</th>
                    <th>FECHA Y<BR>HORA</th>
                    <th>LUGAR DE ATENCIÓN</th>
                    <th>ESTADO DE CITA</th>
                    <th>MODIFICAR</th>
                </tr>
                <?php foreach ($resultados as $fila): ?>
                    <tr align="center">
                        <td><?php echo htmlspecialchars($fila['Id_Citas']); ?></td>
                        <td><?php echo htmlspecialchars($fila['tipoCitaDescripcion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['motivo']); ?></td>
                        <td><?php echo htmlspecialchars($fila['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fecha_hora']); ?></td>
                        <td><?php echo htmlspecialchars($fila['lugar_De_Atencion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['estadoCitaDescripcion']); ?></td>
                        <td><a href="?editar=<?php echo urlencode($fila['Id_Citas']); ?>">Editar</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php if (isset($_GET['editar']) && !empty($_GET['editar'])): ?>
                <?php
                $idCita = $_GET['editar'];
                $queryCita = "SELECT * FROM citas_medicas WHERE Id_Citas = :idCita";
                $stmtCita = $conexion->prepare($queryCita);
                $stmtCita->bindParam(':idCita', $idCita);
                $stmtCita->execute();
                $cita = $stmtCita->fetch(PDO::FETCH_ASSOC);
                ?>

                <table border="2" align="center">
                    <tr>
                        <td>
                            <div align="center">
                                <h1>Modificación de Cita</h1>
                                <form method="POST" action="">
                                    <input type="hidden" name="idCita" value="<?php echo htmlspecialchars($idCita); ?>">
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
                                    <input type="submit" name="actualizame" value="Actualizar Datos" style="cursor: pointer;"><br>
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>

        <?php else: ?>
            <p class="card-text"><br>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    if (isset($_POST['actualizame'])) {
        $actualizacitas = $_POST['estadoCita'];
        $idCita = $_POST['idCita'];

        try {
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
                    padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none;'>Iniciar sesión</a>
                </h2>
                <footer>
                    <div class='footer-texto'>
                        © 2024 HYSM. Todos los derechos reservados.
                    </div>
                </footer>
            </body>
            </html>";

            $mail->send();
            echo 'Correo enviado correctamente.';
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
    ?>

</body>
</html>
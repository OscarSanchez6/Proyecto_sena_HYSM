<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../Model/conexionPDO.php');
require '../Controller/PHPMailer/Exception.php';
require '../Controller/PHPMailer/PHPMailer.php';
require '../Controller/PHPMailer/SMTP.php';

$mensajeConfirmacion = ''; // Variable para almacenar el mensaje de confirmación
$mensajeError = ''; // Variable para almacenar el mensaje de error

if (isset($_POST['contactar'])) {
    $nombreApellidos = $_POST['nombre'];
    $correoElectronico = $_POST['email'];
    $celular = $_POST['telefono'];
    $asuntos = $_POST['asunto'];
    $mensajes = $_POST['mensaje'];

    try {
        $db = new Database();
        $conexion = $db->connectar();
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertar datos en la base de datos
        $query = "INSERT INTO contactenos (datos, correoElectronico, telefono, asunto, mensajes) 
                  VALUES (:nombreApellidos, :correoElectronico, :celular, :asuntos, :mensajes)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombreApellidos', $nombreApellidos);
        $stmt->bindParam(':correoElectronico', $correoElectronico);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':asuntos', $asuntos);
        $stmt->bindParam(':mensajes', $mensajes);
        $stmt->execute();

        // Enviar correos
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp-mail.outlook.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hysmanagement@hotmail.com'; // tu correo
        $mail->Password   = 'h12345*,';  // tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'utf8';

        // Correo al administrador
        $mail->setFrom('hysmanagement@hotmail.com', 'Notificador Digital');
        $mail->addAddress('hysmanagement@hotmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Nueva Sugerencia de Usuarios';
        $mail->Body = "<html>
            <body>
                <h2>HYSM le informa que ha recibido una nueva sugerencia</h2>
                <p><strong>Nombre y Apellidos: </strong>$nombreApellidos</p>
                <p><strong>Correo Electrónico: </strong>$correoElectronico</p>
                <p><strong>Teléfono: </strong>$celular</p>
                <p><strong>Asunto: </strong>$asuntos</p>
                <p><strong>Mensaje: </strong> $mensajes</p>
            </body>
            </html>";
        $mail->send();

        // Correo de confirmación al usuario
        $mail->clearAddresses(); // Limpiar destinatarios anteriores
        $mail->addAddress($correoElectronico);
        $mail->Subject = 'Confirmación de su Mensaje';
        $mail->Body = "<html>
            <body>
                <h2>Gracias por contactarnos, $nombreApellidos</h2>
                <p>Hemos recibido su mensaje y estaremos respondiendo a la brevedad posible.</p>
                <p><strong>Asunto: </strong>$asuntos</p>
                <p><strong>Mensaje: </strong> $mensajes</p>
            </body>
            </html>";
        $mail->send();

        // Mensaje de éxito
        $mensajeConfirmacion = '<p class="mensaje"">El mensaje fue enviado con éxito</p>';
    } catch (Exception $e) {
        $mensajeError = 'El correo no pudo ser enviado. Error del Mailer: ' . $mail->ErrorInfo;
    } catch (PDOException $e) {
        $mensajeError = "Error en la inserción: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctanos</title>
    <link rel="stylesheet" href="../Css/contactanos.css">
</head>
<body>
    <?php include_once '../View/header.php'; ?>
    
    <?php if ($mensajeError): ?>
        <p style='color:red; text-align:center; margin-left: 30px; font-size:30px;'><?php echo $mensajeError; ?></p>
    <?php endif; ?>
    
    <?php if ($mensajeConfirmacion): ?>
        <?php echo $mensajeConfirmacion; ?>
    <?php endif; ?>
    
    <form id="contacto" action="" method="POST">
        <fieldset>
            <legend id="legend">Contáctanos</legend>
            <label><strong>Todos los datos son obligatorios.</strong></label><br><br>

            <div class="form-group">
                <label id="label">Nombre y Apellidos:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Nombres y apellidos completos.">
            </div>

            <div class="form-group">
                <label id="label">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required placeholder="Correo electrónico.">
            </div>

            <div class="form-group">
                <label id="label">Número de Teléfono o celular:</label>
                <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" required placeholder="Digite su teléfono o celular.">
            </div>

            <div class="form-group">
                <label id="label">Asunto:</label>
                <select id="asunto" name="asunto" required>
                    <option value="" class="label">Selecciona un asunto</option>
                    <option value="consulta">Consulta Médica</option>
                    <option value="soporte">Soporte Técnico</option>
                    <option value="sugerencias">Sugerencias</option>
                    <option value="informacion">Solicitud de información</option>
                </select>
            </div>

            <div class="form-group">
                <label id="label">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="4" required placeholder="Ingrese el mensaje que desea enviarnos."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="contactar">Enviar</button>
            </div>
        </fieldset>
    </form>
    
    <?php include_once '../View/footer.php'; ?>
</body>
</html>





























<!--<php
require_once('../Model/conexionPDO.php');

if (isset($_POST['contactar'])) {
    $nombreApellidos = $_POST['nombre'];
    $correoElectronico = $_POST['email'];
    $celular = $_POST['telefono'];
    $asuntos = $_POST['asunto'];
    $mensajes = $_POST['mensaje'];

    try {
        $db = new Database();
        $conexion = $db->connectar();
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO contactenos (datos, correoElectronico, telefono, asunto, mensajes) 
                  VALUES (:nombreApellidos, :correoElectronico, :celular, :asuntos, :mensajes)";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombreApellidos', $nombreApellidos);
        $stmt->bindParam(':correoElectronico', $correoElectronico);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':asuntos', $asuntos);
        $stmt->bindParam(':mensajes', $mensajes);
        $stmt->execute();
        
        $mensajeEnviado = true;

    } catch (PDOException $e) {
        $mensajeError = "Error en la inserción: " . $e->getMessage();
        $mensajeEnviado = false;
    }

    if ($mensajeEnviado) {
        $url = 'https://formsubmit.co/60f6d2cb233ee83a052981cb7cf082a0';
        $data = [
            'nombre' => $nombreApellidos,
            'email' => $correoElectronico,
            'telefono' => $celular,
            'asunto' => $asuntos,
            'mensaje' => $mensajes
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            $mensajeError = "Error al enviar datos al formulario externo.";
            $mensajeEnviado = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contáctanos</title>
    <link rel="stylesheet" href="../Css/contactanos.css">
</head>
<body>
    <php include_once '../View/header.php'; ?>
    
    <php if (isset($mensajeEnviado)): ?>
        <p style='color:green; text-align:center; margin-left: 30px; font-size:30px;'>El mensaje fue enviado con éxito</p>
        <script> window.location.href = 'contactanos.php'; </script>
    <php elseif (isset($mensajeError)): ?>
        <p style='color:red; text-align:center; margin-left: 30px; font-size:30px;'><php echo $mensajeError; ?></p>
    <php endif; ?>
    
    <form id="contacto" action="" method="POST">
        <fieldset>
            <legend id="legend">Contáctanos</legend>
            <label><strong>Todos los datos son obligatorios.</strong></label><br><br>

            <div class="form-group">
                <label id="label">Nombre y Apellidos:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Nombres y apellidos completos.">
            </div>

            <div class="form-group">
                <label id="label">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required placeholder="Correo electrónico.">
            </div>

            <div class="form-group">
                <label id="label">Número de Teléfono o celular:</label>
                <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}" required placeholder="Digite su teléfono o celular.">
            </div>

            <div class="form-group">
                <label id="label">Asunto:</label>
                <select id="asunto" name="asunto" required>
                    <option value="" class="label">Selecciona un asunto</option>
                    <option value="consulta">Consulta Médica</option>
                    <option value="soporte">Soporte Técnico</option>
                    <option value="sugerencias">Sugerencias</option>
                </select>
            </div>

            <div class="form-group">
                <label id="label">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="4" required placeholder="Ingrese el mensaje que desea enviarnos."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="contactar">Enviar</button>
            </div>
        </fieldset>
    </form>
    
    <php include_once '../View/footer.php'; ?>
</body>
</html>








<!--<php
include_once'../Model/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contactanos.</title>
    <link rel="stylesheet" href="../Css/contactanos.css">
</head>
<body>
    <php 
    include_once '../View/header.php';
    ?>
    
    <form id="contacto" action="https://formsubmit.co/60f6d2cb233ee83a052981cb7cf082a0" method="POST" >
        <fieldset>
        <legend id="legend">Contáctanos</legend>
        <label><strong>Todos los datos són obligatorios.</strong></label><br><br>

        <div class="form-group">
            <label id="label">Nombre y Apellidos:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Nombres y apellidos completos.">
        </div>

        <div class="form-group">
            <label id="label">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="Correo electrónico.">
        </div>

        <div class="form-group">
            <label id="label">Número de Teléfono o celular:</label>
            <input type="tel" id="telefono" name="telefono" pattern="[0-9]{10}"  required placeholder="Digite su teléfono o celular.">
        </div>

        <div class="form-group">
            <label id="label">Asunto:</label>
        <select id="asunto" name="asunto" required placeholder="Selecciona un asunto">
            <option value="" class="label">Selecciona un asunto</option>
            <option value="consulta">Consulta Médica</option>
            <option value="soporte">Soporte Técnico</option>
            <option value="sugerencias">Sugerencias</option>
        </select>
        </div>

        <div class="form-group">
            <label  id="label">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4" required placeholder="Ingrese el mensaje que desea enviarnos."></textarea>
        </div>

        <div class="form-group">
            <button type="submit">Enviar</button>
        </div>
        
        </fieldset>
        <input type="hidden" name="_next" value="http://localhost/Proyecto_HYSM/Proyecto/View/contactanos.php">
        <input type="hidden" name="_captcha" value="false">
    </form>

    
    <php
    include_once '../View/footer.php';
    ?>
</body>
</html>
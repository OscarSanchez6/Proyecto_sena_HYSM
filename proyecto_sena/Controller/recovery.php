<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require_once '../Model/conexionPDO.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    try {
        $db = new Database();
        $conexion = $db->connectar();

        $query = 'SELECT id_usuario FROM crear_usuario WHERE correo = :email';
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp-mail.outlook.com';
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Username   = 'hysmanagement@hotmail.com';
                $mail->Password   = 'h12345*,';
                $mail->Port       = 587;
                $mail->CharSet ='utf8';

                $mail->setFrom('hysmanagement@hotmail.com', 'Notificador Digital');
                $mail->addAddress($email, 'User');

                $mail->isHTML(true);

                $mail->addEmbeddedImage('../Img/logo.png', 'logo.png', 'logo.png');

                $mail->Subject = 'Recuperación de contraseña';
                
                $mail->Body = "<html>
                <head>
                    <style>
                        header {
                        background-color: deepskyblue;
                        color: white;
                        padding: 20px;
                        height: 55px;
                        display: flex;
                        align-items: center; /* Alinea los elementos verticalmente en el centro */
                        justify-content: space-between; /* Espacia el logo y la navegación a los extremos */
                        border-bottom: 3px solid #18dde8;
                        position: relative; /* Permite posicionar los elementos de navegación relativamente */
                    }
                        
                    .logo img {
                        height: 90px; 
                        display: block; 
                        margin: 0; 
                        margin-right: 250px; /*No pude configurar que quedara centrado*/
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

                    h2{
                        color:#76bde9;
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
                    <div class='titulo'>Restablecimiento de Contraseña</div>
                </header>
                    <h2>Estimado Usuario<br><br>Este es un correo electrónico para solicitar la recuperación de su contraseña.<br>
                    Por favor, ingresa al link que se encuentra a continuación:<br><br>
                    <a href='http://localhost/Proyecto/Controller/change_password.php?id=" .$row ['id_usuario']. "'
                    style='display: inline-block;
                    padding: 10px 20px; font-size: 16px; 
                    color: #fff; background-color: #007bff; 
                    text-align: center; text-decoration: none; 
                    border-radius: 4px; border: none; cursor: 
                    pointer;'>Recuperar Contraseña</a><br><br>
                    Por favor no responda a este correo.<br>Para cualquier informacion adicional puede consultar nuestra pagina principal o comunicarse con nosotros por medio del aplicativo web</h2>

                    <p class='footer-texto'>&copy; 2024 Health And Services Management. Todos los derechos reservados.</p>
                </body>
                </html>";

                $mail->send();
                header("Location: ../View/recuperarContraseña.php?message=ok");
            } catch (Exception $e) {
               header("Location: ../View/recuperarContraseña.php?message=error");
            }
        } else {
            header("Location: ../View/recuperarContraseña.php?message=No_encontrado");
        }
    } catch (PDOException $e) {
        // Manejo de errores para la conexión a la base de datos
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo "No se ha enviado ningún email";
}
?> 
<?php
require_once('../Model/conexionPDO.php');

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new Database();
        $conexion = $db->connectar();
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST['id'];
        $pass = $_POST['new_password'];
        $numDoc = $_POST['documento'];

        $query = "UPDATE crear_usuario SET contrasena = :pass WHERE id_usuario = :id AND numero_documento = :numDoc";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':numDoc', $numDoc);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ../View/inicio_Sesion_Usuario.php?message=success_password");
        } else {
            $errorMessage = 
            'El número de documento ingresado no corresponde con el usuario del correo electrónico';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/inicio_Sesion_Usuario.css">
    <title>Recuperar Contraseña</title>
</head>
<body class="text-center">
<?php
include_once '../View/headerInicioSesion.php';
?>

    <div id="loginContainer">
        <form action="" method="POST">
            <h2>Cambio de Contraseña</h2>
                <label for="floatingDocument">Número de documento</label>
                <input type="text" class="form-control" id="floatingDocument" name="documento" placeholder="Ingresa tu número de documento" required>
            
                <label for="floatingPassword">Nueva contraseña</label>
                <input type="password" class="form-control" id="floatingPassword" name="new_password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener tanto letras como números."required>
            
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">

                <button type="submit" class="recuperar">Recuperar contraseña</button>
                <br><br>
                <?php if ($errorMessage): ?>
                <div class="error-message mt-3" 
                style="color: red;
                font-weight: bold;
                    white-space: normal; /* Cambiado para que el texto no se trunque */
                    overflow: visible; /* Cambiado para mostrar todo el texto */
                    max-width: none; /* Eliminado para permitir el ancho completo */
                    text-align: center; 
                    margin-left: 10px; 
                    font-size: 14px; /* Ajusta el tamaño del texto según lo necesario */
                    padding: 10px; 
                    border: 1px solid red; 
                    background-color: #ffe6e6; 
                    border-radius: 3px; 
                    width: 100%; /* Asegura que el cuadro ocupe el ancho completo */
                    box-sizing: border-box;">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
    </div>
    </form>
            <?php
    include_once '../View/footer.php';
    ?>
</body>
</html>










<!---
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
         integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="text-center">
        <main class="form-signin w-100 m-auto">
            <form action="change_password.php" method="POST">
                <h1>Cambio de clave</h1>
                <h2 class= "h3 mb-3 fw-normal"> Recupera tu contraseña</h2>
                <div class= "form-floating my-3">
                    <input type="text" class="form-control" id="floatinhgInput" name="documento" placeholder="Ingresa tu numero de documento" required>
                    <input type="password" class="form-control" id="floatingInput" name="new_password" required>
                    
                    <label for="floatingInput">Nueva contraseña</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" name="boton" type="submit">Recuperar contraseña</button>

            </form>
        </main>



        
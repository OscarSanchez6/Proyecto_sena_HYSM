<?php
include_once '../Model/conexionPDO.php';
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 5) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}

if (!isset($_SESSION['id_usuario'])) {
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}
?>
<?php
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new Database();
        $conexion = $db->connectar();
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $usuario = $_SESSION['id_usuario'];
        $pass = $_POST['new_password'];
        $contrasenoa = $_POST['contrasea'];

        $query = "UPDATE crear_usuario SET contrasena = :pass WHERE id_usuario = :usuario AND contrasena = :contrasenoa";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
        $stmt->bindParam(':contrasenoa', $contrasenoa);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ../View/usuario.php?message=success_password");
        } else {
            $errorMessage = 'La contraseña actual no coincide con la contraseña registrada';
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
    <title>Cambiar Contraseña</title>
</head>
<body class="text-center">
<?php
include_once '../View/header_Usuario.php';
?>

    <div id="loginContainer">
        <form action="" method="POST">
            <h2>Cambio de Contraseña</h2>
                <label for="floatingDocument">Contraseña Actual</label>
                <input type="password" class="form-control" id="contraseña" name="contrasea" placeholder="Ingresa tu contraseña actual" required>
            
                <label for="floatingPassword">Nueva contraseña</label>
                <input type="password" class="form-control" id="floatingPassword" name="new_password" placeholder="Ingresa tu nueva contraseña" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener tanto letras como números."required> <br><br>
                <button type="submit" class="recuperar">Cambiar contraseña</button>
    </div>
    </form>
            <?php if ($errorMessage): ?>
                <div class="error-message mt-3" style="color: red;">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>
            <br><br><br><br><br><br><br><br><br>
            <?php
    include_once '../View/footer.php';
    ?>
</body>
</html>
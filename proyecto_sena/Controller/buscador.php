<!---->
<?php 
session_start();
if (!isset($_SESSION['rol'])) {
    header('location: ../View/inicio_Sesion_Usuario.php');
    die();
    exit();
} else {
    if($_SESSION['rol'] != 2) {
        header('location: ../View/inicio_Sesion_Usuario.php');
        die();
        exit();
    }
}
?>

<?php
include '../View/headerAdmin.php';
?>
<?php
include_once '../Model/conexionPDO.php';
$db = new Database();
$conexion = $db->connectar(); // Establece la conexión a la base de datos

// Consulta tipos de documento
$consultaTiposDocumento ='SELECT id_tipo_documento, Documento FROM tipo_documento'; 
$stmtTiposDocumento = $conexion->prepare($consultaTiposDocumento);
$stmtTiposDocumento->execute();
$tiposDocumento = $stmtTiposDocumento->fetchAll(PDO::FETCH_ASSOC);

// Consulta de roles 
$consultaTiposRoles ='SELECT id_tipo_Rol, Roles FROM tabla_roles'; 
$stmtTiposRoles = $conexion->prepare($consultaTiposRoles);
$stmtTiposRoles->execute();
$tiposRoles = $stmtTiposRoles->fetchAll(PDO::FETCH_ASSOC);
try {
    if (isset($_POST['buscar'])) {
        $num_documento = $_POST['documento'];

        $consulta = $conexion->prepare("SELECT crear_usuario.id_usuario,
            crear_usuario.nombre,
            crear_usuario.apellido1,
            crear_usuario.apellido2,
            tipo_documento.Documento AS tipo_documento_id,
            crear_usuario.numero_documento,
            crear_usuario.correo,
            crear_usuario.telefono,
            tabla_roles.Roles AS rol
            FROM crear_usuario
            JOIN tabla_roles ON crear_usuario.rol = tabla_roles.id_tipo_Rol
            JOIN tipo_documento ON  crear_usuario.tipo_documento_id = tipo_documento.id_tipo_documento
            WHERE numero_documento = :num_documento;");
        $consulta->bindParam(':num_documento', $num_documento, PDO::PARAM_STR);
        $consulta->execute();

        if ($consulta->rowCount() == 1) {
            $fila = $consulta->fetch(PDO::FETCH_ASSOC);
            $id = $fila['id_usuario'];
            $usuario = $fila['nombre'];
            $apellido1 = $fila['apellido1'];
            $apellido2 = $fila['apellido2'];
            $idrol = $fila['rol'];
            $tipoDocumento = $fila['tipo_documento_id'];
            $numeroDocumento = $fila['numero_documento'];
            $email = $fila['correo'];
            $telefono = $fila['telefono'];
        } else {
            echo "¡El usuario no existe!";
            exit();
        }     
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<html>
    <body>
        <div class="container">
            <form action="#" method="POST" class="form-busqueda">
            <h2>Búsqueda de usuarios</h2>
            <div class="form-group">
                <label for="documento">Número de identificación:</label>
                <input type="text" name="documento" placeholder="Ingrese el número de documento" autocomplete="off" required value="<?php echo isset($num_documento) ? $num_documento : ''; ?>">
            </div>
            <button type="submit" name="buscar" class="btn-busqueda">Buscar</button>
</form>
<?php 
    if(isset($num_documento)&& empty($num_documento))
    {
        echo'<p style="color:red;font-size:20px;text_align:center;"><strong>!UPS¡</strong>No se encontro el usuario con el  id especificado</p>';
    }
?>


    <?php if (isset($usuario)){ ?>
            <div class="form-container">
                <h2 class="form-title">Actualizar Datos de Usuario</h2>
                <form action="#" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ingrese nombre" size="30" pattern="(?=.*[a-z])(?=.*[A-Z]).+{4,20}" value="<?php echo $usuario; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="apellido1">Primer Apellido</label>
                        <input type="text" id="apellido1" name="apellido1" required placeholder="Ingrese primer apellido" size="30" pattern="[a-zA-Z]{4,20}" value="<?php echo $apellido1; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="apellido2">Segundo Apellido</label>
                        <input type="text" id="apellido2" name="apellido2" required placeholder="Ingrese segundo apellido" size="30" pattern="[a-zA-Z]{4,20}" value="<?php echo $apellido2; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="rol">Rol: <?php echo $idrol ?></label>
                        <select name="rol" id="rol">
                        <?php foreach ($tiposRoles as $tipo): ?>
                            <option value="<?php echo htmlspecialchars($tipo['id_tipo_Rol']); ?>">
                                <?php echo htmlspecialchars($tipo['Roles']);?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                        </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento: <?php echo $tipoDocumento ?></label>
                    <select name="tipo_documento" id="tipo_documento"required>
                        <?php foreach ($tiposDocumento as $tipo): ?>
                            <option value="<?php echo htmlspecialchars($tipo['id_tipo_documento']); ?>">
                                <?php echo htmlspecialchars($tipo['Documento']);?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="numero_documento">Número de Documento</label>
                        <input type="number" id="numero_documento" name="numero_documento" required placeholder="Ingrese número de documento" value="<?php echo $numeroDocumento; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="Ingrese email" value="<?php echo $email; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" required placeholder="Ingrese teléfono" value="<?php echo $telefono; ?>">
                    </div>
                    
                    <button type="submit" name="actualizar" class="form-submit">Actualizar Datos</button>
                </form>
            </div>
            <?php } ?>
        </div>
<!---->
<?php
if (isset($_POST['actualizar'])){
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $idrol = $_POST['rol'];
    $tipo_documento = $_POST['tipo_documento'];
    $num_documento = $_POST['numero_documento'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $actualizar = $conexion->prepare("UPDATE crear_usuario SET
        nombre = :nombre, 
        apellido1 = :apellido1, 
        apellido2 = :apellido2,
        rol = :rol, 
        tipo_documento_id = :tipo_documento,
        numero_documento = :numero_documento, 
        correo = :email, 
        telefono = :telefono
        WHERE numero_documento = :num_documento");
        $actualizar->bindParam(':num_documento', $num_documento, PDO::PARAM_STR);//tener en cuenta "error parametro no valido no sabia que era?"


    $actualizar->bindParam(':nombre', $nombre);
    $actualizar->bindParam(':apellido1', $apellido1);
    $actualizar->bindParam(':apellido2', $apellido2);
    $actualizar->bindParam(':rol', $idrol);
    $actualizar->bindParam(':tipo_documento', $tipo_documento);
    $actualizar->bindParam(':numero_documento', $num_documento); 
    $actualizar->bindParam(':email', $email);
    $actualizar->bindParam(':telefono', $telefono);


    if ($actualizar->execute() > 0) {
        echo '<p style="color:green;font-size:30px;text-align:center;">Actualización exitosa.</p>';
    } else {
        echo '<p style="color:red;font-size:20px;text-align:center;">Error al actualizar el registro</p>';
    }
}
?>
<!---->
<?php
include_once '../View/footer.php';
?>
    </body>    
</html>
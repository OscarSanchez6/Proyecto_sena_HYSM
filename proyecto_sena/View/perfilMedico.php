<?php
include_once '../Model/conexionPDO.php';
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol correcto
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1 || !isset($_SESSION['numero_documento'])) {
    session_destroy();
    header('Location: inicio_Sesion_Usuario.php');
    exit();
}

// Conexión a la base de datos
$db = new Database();
$conexion = $db->connectar();
$numDocumento = $_SESSION['numero_documento'];

// Obtener los datos del usuario
$consulta = 'SELECT crear_usuario.*, tipo_documento.documento, ocupaciones.nombre_ocupacion 
            FROM crear_usuario 
            JOIN tipo_documento ON crear_usuario.tipo_documento_id = tipo_documento.id_tipo_documento
            JOIN ocupaciones ON crear_usuario.Ocupacion = ocupaciones.id_ocupacion
            WHERE crear_usuario.numero_documento = :numDocumento';
$stmt = $conexion->prepare($consulta);
$stmt->bindParam(':numDocumento', $numDocumento, PDO::PARAM_STR);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró el usuario
if (!$usuario) {
    echo "Usuario no encontrado";
    exit();
}

// Procesar la actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $ocupacion = filter_input(INPUT_POST, 'ocupacion', FILTER_SANITIZE_STRING);

    $actualizacion = "UPDATE crear_usuario SET 
                    direccion = :direccion,
                    correo = :correo,
                    telefono = :telefono,
                    ocupacion = :ocupacion
                    WHERE numero_documento = :numDocumento";

    $stmtActualizar = $conexion->prepare($actualizacion);
    $stmtActualizar->bindParam(':direccion', $direccion);
    $stmtActualizar->bindParam(':correo', $email);
    $stmtActualizar->bindParam(':telefono', $telefono);
    $stmtActualizar->bindParam(':ocupacion', $ocupacion);
    $stmtActualizar->bindParam(':numDocumento', $numDocumento);

    if ($stmtActualizar->execute()) {
        $mensaje = "<p class='mensaje';>Datos actualizados correctamente.</p>";
        // Actualizar los datos del usuario en la variable $usuario
        $usuario['direccion'] = $direccion;
        $usuario['correo'] = $email;
        $usuario['telefono'] = $telefono;
        $usuario['ocupacion'] = $ocupacion;
    } else {
        $mensaje = "<p class='mensaje';>Error al actualizar los datos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../css/perfil_De_Usuario.css">
</head>
<body>
    <?php include_once 'headerPerfilMedico.php'; ?>
    <div class="container">
        <h1>Datos de Usuario</h1>
        
        <?php if(isset($mensaje)): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <section class="datos-no-editables">
                <h2>Información Personal</h2>
                <div class="fila">
                    <div class="columna">
                        <label>Nombre:</label>
                        <p><?php echo htmlspecialchars($usuario['nombre']); ?></p>
                    </div>
                    <div class="columna">
                        <label>Apellidos:</label>
                        <p><?php echo htmlspecialchars($usuario['apellido1']); ?></p><p><?php echo htmlspecialchars($usuario['apellido2']); ?></p>
                    </div>
                </div>
                <div class="fila">
                    <div class="columna">
                        <label>Número de Documento:</label>
                        <p><?php echo htmlspecialchars($usuario['numero_documento']); ?></p>
                    </div>
                    <div class="columna">
                        <label>Tipo de Documento:</label>
                        <p><?php echo htmlspecialchars($usuario['documento']); ?></p>
                    </div>
                </div>
            </section>
            <p>Recuerda recargar la página para ver todos tus datos actualizados.</p>
            <section class="datos-editables">
                <h2>Información de Contacto</h2>
                <div class="fila">
                    <div class="columna">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" required>
                    </div>
                    <div class="columna">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                    </div>
                </div>
                <div class="fila">
                    <div class="columna">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                    </div>
                    <div class="columna">
                        <label for="ocupacion">Ocupación:</label>
                        <select id="ocupacion" name="ocupacion" required>
                            <option value="1" <?php echo $usuario['Ocupacion'] == '1' ? 'selected' : ''; ?>>Ingeniero</option>
                            <option value="2" <?php echo $usuario['Ocupacion'] == '2' ? 'selected' : ''; ?>>Médico</option>
                            <option value="3" <?php echo $usuario['Ocupacion'] == '3' ? 'selected' : ''; ?>>Profesor de primaria</option>
                            <option value="4" <?php echo $usuario['Ocupacion'] == '4' ? 'selected' : ''; ?>>Abogado</option>
                            <option value="5" <?php echo $usuario['Ocupacion'] == '5' ? 'selected' : ''; ?>>Arquitecto</option>
                            <option value="6" <?php echo $usuario['Ocupacion'] == '6' ? 'selected' : ''; ?>>Diseñador gráfico</option>
                            <option value="7" <?php echo $usuario['Ocupacion'] == '7' ? 'selected' : ''; ?>>Programador</option>
                            <option value="8" <?php echo $usuario['Ocupacion'] == '8' ? 'selected' : ''; ?>>Enfermero</option>
                            <option value="9" <?php echo $usuario['Ocupacion'] == '9' ? 'selected' : ''; ?>>Chef</option>
                            <option value="10" <?php echo $usuario['Ocupacion'] == '10' ? 'selected' : ''; ?>>Carpintero</option>
                            <option value="11" <?php echo $usuario['Ocupacion'] == '11' ? 'selected' : ''; ?>>Electricista</option>
                            <option value="12" <?php echo $usuario['Ocupacion'] == '12' ? 'selected' : ''; ?>>Plomero</option>
                            <option value="13" <?php echo $usuario['Ocupacion'] == '13' ? 'selected' : ''; ?>>Farmacéutico</option>
                            <option value="14" <?php echo $usuario['Ocupacion'] == '14' ? 'selected' : ''; ?>>Policía</option>
                            <option value="15" <?php echo $usuario['Ocupacion'] == '15' ? 'selected' : ''; ?>>Bombero</option>
                            <option value="16" <?php echo $usuario['Ocupacion'] == '16' ? 'selected' : ''; ?>>Actor</option>
                            <option value="17" <?php echo $usuario['Ocupacion'] == '17' ? 'selected' : ''; ?>>Músico</option>
                            <option value="18" <?php echo $usuario['Ocupacion'] == '18' ? 'selected' : ''; ?>>Artista plástico</option>
                            <option value="19" <?php echo $usuario['Ocupacion'] == '19' ? 'selected' : ''; ?>>Periodista</option>
                            <option value="20" <?php echo $usuario['Ocupacion'] == '20' ? 'selected' : ''; ?>>Ama de casa</option>
                            <option value="21" <?php echo $usuario['Ocupacion'] == '21' ? 'selected' : ''; ?>>Consultor</option>
                            <option value="22" <?php echo $usuario['Ocupacion'] == '22' ? 'selected' : ''; ?>>Economista</option>
                            <option value="23" <?php echo $usuario['Ocupacion'] == '23' ? 'selected' : ''; ?>>Psicólogo/a</option>
                            <option value="24" <?php echo $usuario['Ocupacion'] == '24' ? 'selected' : ''; ?>>Contador/a</option>
                            <option value="25" <?php echo $usuario['Ocupacion'] == '25' ? 'selected' : ''; ?>>Astrónomo/a</option>
                            <option value="26" <?php echo $usuario['Ocupacion'] == '26' ? 'selected' : ''; ?>>Géologo</option>
                            <option value="27" <?php echo $usuario['Ocupacion'] == '27' ? 'selected' : ''; ?>>Biólogo</option>
                            <option value="28" <?php echo $usuario['Ocupacion'] == '28' ? 'selected' : ''; ?>>Piloto</option>
                            <option value="29" <?php echo $usuario['Ocupacion'] == '29' ? 'selected' : ''; ?>>Conductor/a de autubús</option>
                            <option value="30" <?php echo $usuario['Ocupacion'] == '30' ? 'selected' : ''; ?>>Conductor/a de Uber</option>

                            <option value="31" <?php echo $usuario['Ocupacion'] == '31' ? 'selected' : ''; ?>>Conductor/a de taxí</option>
                            <option value="32" <?php echo $usuario['Ocupacion'] == '32' ? 'selected' : ''; ?>>Conductor/a de Transmilénio</option>
                            <option value="33" <?php echo $usuario['Ocupacion'] == '33' ? 'selected' : ''; ?>>Conductor/a de SITP</option>
                            <option value="34" <?php echo $usuario['Ocupacion'] == '34' ? 'selected' : ''; ?>>Jardinero/a</option>
                            <option value="35" <?php echo $usuario['Ocupacion'] == '35' ? 'selected' : ''; ?>>Científico</option>
                            <option value="36" <?php echo $usuario['Ocupacion'] == '36' ? 'selected' : ''; ?>>Profesor Universitario</option>
                            <option value="37" <?php echo $usuario['Ocupacion'] == '37' ? 'selected' : ''; ?>>Vendedor Informal</option>
                            <option value="38" <?php echo $usuario['Ocupacion'] == '38' ? 'selected' : ''; ?>>Agente de ventas</option>
                            <option value="39" <?php echo $usuario['Ocupacion'] == '39' ? 'selected' : ''; ?>>Perito Contador</option>
                            <option value="40" <?php echo $usuario['Ocupacion'] == '40' ? 'selected' : ''; ?>>Inspector de Calidad</option>
                            <option value="41" <?php echo $usuario['Ocupacion'] == '41' ? 'selected' : ''; ?>>Diseñador de Moda</option>
                            <option value="42" <?php echo $usuario['Ocupacion'] == '42' ? 'selected' : ''; ?>>Terapeuta Ocupacional</option>
                            <option value="43" <?php echo $usuario['Ocupacion'] == '43' ? 'selected' : ''; ?>>Analista de Datos</option>
                            <option value="44" <?php echo $usuario['Ocupacion'] == '44' ? 'selected' : ''; ?>>Operador de Maquinaria Pesada</option>
                            <option value="45" <?php echo $usuario['Ocupacion'] == '45' ? 'selected' : ''; ?>>Especialista en Seguridad Informática</option>
                            <option value="46" <?php echo $usuario['Ocupacion'] == '46' ? 'selected' : ''; ?>>Asistente Social</option>
                            <option value="47" <?php echo $usuario['Ocupacion'] == '47' ? 'selected' : ''; ?>>Gerente de Proyectos</option>
                            <option value="48" <?php echo $usuario['Ocupacion'] == '48' ? 'selected' : ''; ?>>Arqueólogo</option>
                            <option value="49" <?php echo $usuario['Ocupacion'] == '49' ? 'selected' : ''; ?>>Entrenador Personal</option>
                            <option value="50" <?php echo $usuario['Ocupacion'] == '50' ? 'selected' : ''; ?>>Economista Ambiental</option>
                            <option value="51" <?php echo $usuario['Ocupacion'] == '51' ? 'selected' : ''; ?>>Escultor</option>
                            <option value="52" <?php echo $usuario['Ocupacion'] == '52' ? 'selected' : ''; ?>>Cineasta</option>
                            <option value="53" <?php echo $usuario['Ocupacion'] == '53' ? 'selected' : ''; ?>>Analista de Créditos</option>
                            <option value="54" <?php echo $usuario['Ocupacion'] == '54' ? 'selected' : ''; ?>>Técnico en Radiología</option>
                            <option value="55" <?php echo $usuario['Ocupacion'] == '55' ? 'selected' : ''; ?>>Animador 3D</option>
                            <option value="56" <?php echo $usuario['Ocupacion'] == '56' ? 'selected' : ''; ?>>Biocientífico</option>
                            <option value="57" <?php echo $usuario['Ocupacion'] == '57' ? 'selected' : ''; ?>>Diseñador Industrial</option>
                            <option value="58" <?php echo $usuario['Ocupacion'] == '58' ? 'selected' : ''; ?>>Genetista</option>
                            <option value="59" <?php echo $usuario['Ocupacion'] == '59' ? 'selected' : ''; ?>>Peluquero canino</option>
                        </select><br>
                        
                    </div>
                </div>
            </section>

            <div class="botones">
                <button type="submit" class="btn-primario">Actualizar Información</button>
            </div>
            
        </form>
            
        </form>
    </div>
</body>
</html>

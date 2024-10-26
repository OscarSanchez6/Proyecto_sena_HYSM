<?php
if (isset($_POST['btnregistrar'])) {
        $nombre = $_POST['nombre'];
        $primerApellido = $_POST['primerApellido'];
        $segundoApellido = $_POST['segundoApellido'];
        $contraseña = $_POST['password'];
        $rol = 5;
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];
        $rh = $_POST['rh'];
        $altura = $_POST['altura'];
        $peso = $_POST['peso'];
        $fechaDeNacimiento = $_POST['fechaDeNacimiento'];
        $tipoDeDocumento = $_POST['tipoDeDocumento'];
        $numeroDeDocumento = $_POST['numeroDeDocumento'];
        $correoElectronico = $_POST['correoElectronico'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $discapacidad = $_POST['discapacidad'];
        $sisben = $_POST['sisben'];
        $nacionalidad = $_POST['nacionalidad'];
        $estadoCivil = $_POST['estadoCivil'];
        $estrato = $_POST['estrato'];
        $enfermedades = $_POST['enfermedades'];
        $ocupaciones = $_POST['ocupaciones'];
        $eps = $_POST['eps'];

        try {
        $db = new Database();
        $conexion = $db->connectar();

        // Verificar si el número de documento o el correo electrónico ya existen
        $queryVerificar = "SELECT COUNT(*) FROM crear_usuario WHERE numero_documento = :numeroDeDocumento OR correo = :correoElectronico";
        $stmtVerificar = $conexion->prepare($queryVerificar);
        $stmtVerificar->bindParam(':numeroDeDocumento', $numeroDeDocumento);
        $stmtVerificar->bindParam(':correoElectronico', $correoElectronico);
        $stmtVerificar->execute();
        $existe = $stmtVerificar->fetchColumn();

        if ($existe > 0) {
                echo "<p style='color: red;
                font-weight: bold;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 105%;
                padding: 5px;
                border: 1px solid red;
                background-color: #ffe6e6;
                border-radius: 3px;
                font-size: 12px;'>El número de documento o correo ya está registrado.</p>";
        } else {
            // Si no existen, se realiza la inserción
                $query = "INSERT INTO crear_usuario (nombre, apellido1, apellido2, contrasena, rol, edad, sexo, RH, altura, peso, fecha_nacimiento, tipo_documento_id, numero_documento, correo, telefono, direccion, discapacidad, sisben, nacionalidad, estado_civil, estrato, enfermedades, ocupacion, Eps) 
                VALUES (:nombre, :primerApellido, :segundoApellido, :contrasena, :rol, :edad, :sexo, :rh, :altura, :peso, :fechaDeNacimiento, :tipoDeDocumento, :numeroDeDocumento, :correoElectronico, :telefono, :direccion, :discapacidad, :sisben, :nacionalidad, :estadoCivil, :estrato, :enfermedades, :ocupaciones, :eps)";
                $insertar = $conexion->prepare($query);
                $insertar->bindParam(':nombre', $nombre);
                $insertar->bindParam(':primerApellido', $primerApellido);
                $insertar->bindParam(':segundoApellido', $segundoApellido);
                $insertar->bindParam(':contrasena', $contraseña);
                $insertar->bindParam(':rol', $rol);
                $insertar->bindParam(':edad', $edad);
                $insertar->bindParam(':sexo', $sexo);
                $insertar->bindParam(':rh', $rh);
                $insertar->bindParam(':altura', $altura);
                $insertar->bindParam(':peso', $peso);
                $insertar->bindParam(':fechaDeNacimiento', $fechaDeNacimiento);
                $insertar->bindParam(':tipoDeDocumento', $tipoDeDocumento);
                $insertar->bindParam(':numeroDeDocumento', $numeroDeDocumento);
                $insertar->bindParam(':correoElectronico', $correoElectronico);
                $insertar->bindParam(':telefono', $telefono);
                $insertar->bindParam(':direccion', $direccion);
                $insertar->bindParam(':discapacidad', $discapacidad);
                $insertar->bindParam(':sisben', $sisben);
                $insertar->bindParam(':nacionalidad', $nacionalidad);
                $insertar->bindParam(':estadoCivil', $estadoCivil);
                $insertar->bindParam(':estrato', $estrato);
                $insertar->bindParam(':enfermedades', $enfermedades);
                $insertar->bindParam(':ocupaciones', $ocupaciones);
                $insertar->bindParam(':eps', $eps);

                if ($insertar->execute() > 0) {
                        echo "<p style='color: green;
                        font-weight: bold;
                        margin-left:30px;
                        background-color: #e6ffe6;
                        padding: 5px;
                        border: 1px solid green;
                        border-radius: 3px;'>El Usuario se ha Registrado con Éxito.</p>";
                        echo "<script> window.open('registroControlador.php')  </script> ";
                } else {
                        echo "<p style='color: red;
                        font-weight: bold;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        max-width: 100%;
                        padding: 5px;
                        border: 1px solid red;
                        background-color: #ffe6e6;
                        border-radius: 3px;
                        font-size: 12px;'>Error al Registrar al Usuario.</p>";
                }
                }
        } catch (PDOException $e) {
                die("Error en la inserción: " . $e->getMessage());
        }
        }
        ?>

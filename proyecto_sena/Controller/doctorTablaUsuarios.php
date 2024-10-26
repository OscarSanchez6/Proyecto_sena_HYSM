<?php
include_once '../Model/conexionPDO.php';
session_start();

if (!isset($_SESSION['rol'])) {
    header('location: inicio_Sesion_Usuario.php');
    die();
} else {
    if ($_SESSION['rol'] != 1) {
        header('location: inicio_Sesion_Usuario.php');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../Css/doctor.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include_once '../View/header_usuarios.php'; ?>

    <h1 class="tabla-titulo">Usuarios</h1>
    <div class="search-container">
        <div class="input-container">
            <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Numero de Documento o Nombre de Usuario">
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
                    dato.id_usuario,
                    dato.nombre,
                    dato.apellido1,
                    dato.apellido2,
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
                    WHERE trol.id_tipo_Rol = 5";

                $statement = $conexion->query($observar);
                if ($statement) {
                    echo '<table border="3" align="center" id="z">
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>PRIMER APELLIDO</th>
                            <th>SEGUNDO APELLIDO</th>
                            <th>TIPO DE DOCUMENTO</th>
                            <th>NÚMERO DE DOCUMENTO</th>
                            <th>EDAD</th>
                            <th>SEXO</th>
                            <th>RH</th>
                            <th>CORREO</th>
                            <th>ALTURA</th>
                            <th>PESO</th>
                        </tr>';

                    while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $id = $filas['id_usuario'];
                        $usuario = $filas['nombre'];
                        $apellidos1 = $filas['apellido1'];
                        $apellidos2 = $filas['apellido2'];
                        $documento = $filas['documentoDescripcion'];
                        $numeroDoc = $filas['numero_documento'];
                        $edad = $filas['edad'];
                        $genero = $filas['sexoDescripcion'];
                        $tipo_sangre = $filas['sangre_descripcion'];
                        $email = $filas['correo'];
                        $altura = $filas['altura'];
                        $peso = $filas['peso'];

                        echo '<tr align="center">
                                <td>' . htmlspecialchars($id) . '</td>
                                <td>' . htmlspecialchars($usuario) . '</td>
                                <td>' . htmlspecialchars($apellidos1) . '</td>
                                <td>' . htmlspecialchars($apellidos2) . '</td>
                                <td>' . htmlspecialchars($documento) . '</td>
                                <td>' . htmlspecialchars($numeroDoc) . '</td>
                                <td>' . htmlspecialchars($edad) . '</td>
                                <td>' . htmlspecialchars($genero) . '</td>
                                <td>' . htmlspecialchars($tipo_sangre) . '</td>
                                <td>' . htmlspecialchars($email) . '</td>
                                <td>' . htmlspecialchars($altura) . '</td>
                                <td>' . htmlspecialchars($peso) . '</td>
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
            var parametros = { "buscar": buscar };

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
                        if (data.trim() === '') 
                        {
                            document.getElementById("datos_buscador").innerHTML = '';
                            document.getElementById("tabla_principal").style.display = 'block'; 
                        } 
                        else 
                        {
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
</body>
</html>

<?php include_once '../View/footer.php'; ?>
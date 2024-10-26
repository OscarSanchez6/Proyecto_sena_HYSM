<?php
include_once '../Model/conexionPDO.php';
?>
<?php 
session_start();
if (!isset($_SESSION['rol']))
	{
		header('location: inicio_Sesion_Usuario.php');
		die(); exit();
	}
else
	{
		if($_SESSION['rol'] !=1)
			{
				header('location: inicio_Sesion_Usuario.php');
				die(); exit();
			}
	}
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: inicio_Sesion_Usuario.php');
        exit();
    }
    $doctorId = $_SESSION['id_usuario'];
?>


<html><head>
    <link rel="stylesheet" href="../Css/doctor.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<?php 
    include_once '../View/header_usuarios.php';
    ?>

<h1 class="tabla-titulo">Fórmulas Médicas</h1>
<div class="search-container">
        <div class="input-container">
            <input onkeyup="buscar_ahora();" type="text" class="form-control" id="buscar_1" name="buscar_1" placeholder="Nombre de Usuario o Medicamento">
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
formulas.id_formulas,
formulas.usuario AS id_usuario,
usuario.nombre AS usuarioDescripcion,
formulas.usuario AS id_usuario,
usuario.apellido1 AS usuarioApellido,
formulas.usuario AS id_usuario,
usuario.apellido2 AS usuarioApellido2,
formulas.nombre_medicamento,
formulas.dosis,
formulas.instrucciones,
formulas.fecha_Formulacion,
formulas.fecha_Vencimiento, 
lugar_Entrega
FROM formulas_medicas formulas
JOIN crear_usuario usuario ON formulas.usuario = usuario.id_usuario
WHERE formulas.Doctor =:doctorId";



$statement = $conexion->prepare($observar);
$statement->bindParam(':doctorId', $doctorId, PDO::PARAM_INT);
$statement->execute();
if ($statement) {
    echo '<table align="center">
        <tr>	
            <th>ID</th>
            <th>USUARIO</th>
            <th>NOMBRE DE MEDICAMENTOS</th>
            <th>DOSIS</th>
            <th>INSTRUCCIONES</th>
            <th>FECHA FORMULACIÓN</th>
            <th>FECHA VENCIMIENTO</th>
            <th>LUGAR DE ENTREGA</th>
        </tr>';

        while ($filas = $statement->fetch(PDO::FETCH_ASSOC)) {
            $id = $filas['id_formulas'];
            $nomUsuario = $filas['usuarioDescripcion'];
            $apellido1 =$filas['usuarioApellido'];
            $apellido2 =$filas['usuarioApellido2'];
            $medicamento=$filas['nombre_medicamento'];
            $dosis=$filas['dosis'];	
            $instrucciones = $filas['instrucciones'];
            $fFormulacion=$filas['fecha_Formulacion'];
            $fVencimiento=$filas['fecha_Vencimiento'];	
            $cantidad = $filas['lugar_Entrega'];
            $datos=$nomUsuario. " " .$apellido1. " " .$apellido2;

            echo '<tr align="center">
                    <td>' . $id . '</td>
                    <td>' . $datos . '</td>
                    <td>' . $medicamento . '</td>
                    <td>' . $dosis . '</td>
                    <td>' . $instrucciones . '</td>
                    <td>' . $fFormulacion . '</td>
                    <td>' . $fVencimiento . '</td>
                    <td>' . $cantidad . '</td>
                </tr>';
        }
        echo '</table>';
    } 
    else 
    {   echo 'Error en la consulta.';
    }
} 
catch (PDOException $e) 
    {   die("Error en conexión a la base de datos: " . $e->getMessage());
    }

    ?>
    </div>
</div>
<br><br>

<script type="text/javascript">
    function buscar_ahora() {
        var buscar = document.getElementById('buscar_1').value.trim();
        var parametros = { "buscarFormula": buscar };

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
<?php
        include_once '../View/footer.php';
?>
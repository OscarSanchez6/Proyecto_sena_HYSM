<?php
include_once '../Model/conexionPDO.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../Css/registro.css">
</head>
<body>
<?php 
    include_once '../View/header.php';
    ?>
    <div id="loginContainer">
    <h2 align="center">Registro de  <br>pacientes.</h2>
    <label > Datos Opcionales (*)</label><br><br>
    <form action="registro.php" method="POST" name="form">
        <label>Nombres:</label>
        <input type="text" name="nombre" required placeholder="Ingrese sus nombres completos" size="30" pattern="(?=.*[a-z])(?=.*[A-Z]).+{4,20}" title="Utilice al menos una minúscula y una mayúscula.">
        <div id="errorNombre" class="error"></div>  
        <br><br>

        <label>Primer Apellido:</label>
        <input type="text" id="primerApellido" name="primerApellido" required placeholder="Ingrese su primer apellido" size="30" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo debén contener letras y tener minimo 4.">
        <div id="errorPrimerApellido" class="error"></div>
        <br><br>
        
        <label>Segundo Apellido:*</label>
        <input type="text" id="segundoApellido" name="segundoApellido"  placeholder="Ingrese su segundo apellido" size="30" pattern="[a-zA-Z]{4,20}" title="Los apellidos solo debén contener letras y tener minimo 4.">
        <div id="errorSegundoApellido" class="error"></div>
        <br><br>

        <label for="password">Contraseña:</label>
        <div class="password-container">
            <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required size="30" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener tanto letras como números.">
            <!-- Imagen del ojo para mostrar/ocultar contraseña -->
            <img src="../img/visible.png" alt="Mostrar contraseña" class="password" id="Password">
            <div id="errorContraseña" class="error"></div>
        </div>
        <br><br> 
        <!--<label>Rol:</label>
        <select id="rol" name="rol" required placeholder="seleccione el Rol a desempeñar">
            <option value="0">Seleccione una opción</option>
            <option value="2">Administrador</option>
            <option value="5">Usuario</option>
            <option value="3">Recepción</option>
            <option value="1">Doctor</option>
            <option value="4">Prescriptor Medico</option>
        </select><br><br>-->

        <label>Género:</label>
        <select id="sexo" name="sexo" required placeholder="seleccione su Genero">
            <option value="0">Seleccione una opción</option>
            <option value="1">Masculino</option>
            <option value="2">Femenino</option>
        </select>
        <div id="errorSexo" class="error"></div>
        <br><br>

        <label>RH:</label>
        <select id="rh" name="rh" required placeholder="Seleccione su tipo de Sangre"><br><br>
            <option value="0">Seleccione una opción</option>
            <option value="1">A+</option>
            <option value="2">A-</option>
            <option value="3">B+</option>
            <option value="4">B-</option>
            <option value="5">AB+</option>
            <option value="6">AB-</option>
            <option value="7">O+</option>
            <option value="8">O-</option>
            
        </select>
        <div id="errorRh" class="error"></div>
        <br><br>

        <label>Altura:</label>
        <input type="number" id="altura" name="altura" required placeholder="Digite su altura" title="Digite su altura en números únicamente">
        <div id="errorAltura" class="error"></div>
        <br><br>

        <label>Peso:</label>
        <input type="number" id="peso" name="peso" required placeholder="Digite su peso" title="Digite su peso en números únicamente">
        <div id="errorPeso" class="error"></div>
        <br><br>

        <label>Fecha de nacimiento:</label>
        <input type="date" id="fechaDeNacimiento" name="fechaDeNacimiento" required placeholder="Seleccione su fecha de nacimiento">
        <div id="errorFechaDeNacimiento" class="error"></div>
        <br><br>

        <label>Edad:</label>
        <input type="number" id="edad" name="edad" required placeholder="Digite su Edad" title="Digite su edad en números únicamente" readonly>
        <div id="errorEdad" class="error"></div>
        <br><br>

        <label>Tipo de documento:</label>
        <select id="tipoDeDocumento" name="tipoDeDocumento" required>
            <option value="0">Seleccione una opción</option>
            <option value="1">Cedula de Ciudadania</option>
            <option value="2">Cedula de Extranjeria</option>
            <option value="3">Pasaporte</option>
            <option value="4">Tarjeta de Identidad</option>
            <option value="5">NUIP</option>
        </select>
        <div id="errorTipoDeDocumento" class="error"></div>
        <br><br>

        <label>Número de Documento:</label>
        <input type="number" id="numeroDeDocumento" name="numeroDeDocumento" required placeholder="Digite su Número de Documento">
        <div id="errorNumeroDeDocumento" class="error"></div>
        <br></br>

        <label>Correo Electrónico</label>        
        <input type="email" id="correoElectronico" name="correoElectronico" required placeholder="Digite su correo electrónico" title="Recuerda agregar el arroba a tu correo.">
        <div id="errorCorreoElectronico" class="error"></div>
        <br><br>

        <label>Teléfono:</label>
        <input type="number" id="telefono" name="telefono" required placeholder="Digite su número telefónico" title="Digite solo números únicamente">
        <div id="errorTelefono" class="error"></div>
        <br><br>

        <label>Dirección:</label>
        <input type="text" id="Direccion" name="direccion" required placeholder="Digite su dirección de residencia">
        <div id="errorDireccion" class="error"></div>
        <br><br>

        <label>Discapacidad:</label>
        <select name="discapacidad" id="discapacidad" required>
            <option>Seleccione una opción</option>
            <option value="1">Discapacidad física</option>
            <option value="2">Discapacidad intelectual</option>
            <option value="3">Discapacidad mental</option>
            <option value="4">Discapacidad psicosocial</option>
            <option value="5">Discapacidad múltiple</option>
            <option value="6">Discapacidad sensorial</option>
            <option value="7">Discapacidad auditiva</option>
            <option value="8">Discapacidad visual</option>
            <option value="9">Ninguna</option>
        </select>
        <div id="errorDiscapacidad" class="error"></div>
        <br><br>

        <label>Sisbén:</label>
        <select name="sisben" id="sisben">
            <option>Seleccione una opción</option>
            <option value="1">A1 -A5</option>
            <option value="2">B1 - B7</option>
            <option value="3">C1 - C18</option>
            <option value="4">D1 - D20</option>
            <option value="5">No Aplica</option>
        </select>
        <div id="errorSisben" class="error"></div>
        <br><br>

        <label> Nacionalidad</label>
        <input type="text" id="nacionalidad" name="nacionalidad" required placeholder="Digite su Nacionalidad">
        <div id="errorNacionalidad" class="error"></div>
        <br><br>

        <label>Estado Civil</label>
        <select name="estadoCivil" id="estadoCivil" required>
            <option>Seleccione una opción</option>
            <option value="1">Soltero/a</option>
            <option value="2">Casado/a</option>
            <option value="3">Unión libre o Unión de hecho</option>
            <option value="4">Separado/a</option>
            <option value="5">Divorciado/a</option>
            <option value="6">Viudo/a</option>
        </select>
        <div id="errorEstadoCivil" class="error"></div>
        <br><br>

        <label>Estrato</label>
        <select name="estrato" id="estrato" required>
            <option>Seleccione una opción</option>
            <option value="1">Estrato 1</option>
            <option value="2">Estrato 2</option>
            <option value="3">Estrato 3</option>
            <option value="4">Estrato 4</option>
            <option value="5">Estrato 5</option>
            <option value="6">Estrato 6</option>
        </select>
        <div id="errorEstrato" class="error"></div>
        <br><br>

        <label>Enfermedades:</label>
        <input type="text" id="Enfermedades" name="enfermedades" required placeholder="Digite enfermedades que padezca">
        <div id="errorEnfermedades" class="error"></div>
        <br><br>

        <label>Ocupaciones: *</label>
        <select name="ocupaciones" id="ocupaciones">
            <option>Seleccione una opción</option>
            <option value="1">Ingeniero</option>
            <option value="2">Médico</option>
            <option value="3">Profesor de primaria</option>
            <option value="4">Abogado</option>
            <option value="5">Arquitecto</option>
            <option value="6">Diseñador gráfico</option>
            <option value="7">Programador</option>
            <option value="8">Enfermero</option>
            <option value="9">Chef</option>
            <option value="10">Carpintero</option>
            <option value="11">Electricista</option>
            <option value="12">Plomero</option>
            <option value="13">Farmacéutico</option>
            <option value="14">Policía</option>
            <option value="15">Bombero</option>
            <option value="16">Actor</option>
            <option value="17">Músico</option>
            <option value="18">Artista plástico</option>
            <option value="19">Periodista</option>
            <option value="20">Ama de casa</option>
            <option value="21">Consultor</option>
            <option value="22">Economista</option>
            <option value="23">Psicólogo/a</option>
            <option value="24">Contador/a</option>
            <option value="25">Astrónomo</option>
            <option value="26">Geólogo/a</option>
            <option value="27">Biólogo/a</option>
            <option value="28">Piloto</option>
            <option value="29">Conductor de autobús</option>
            <option value="30">Conductor de Uber</option>
            <option value="31">Conductor de Taxi</option>
            <option value="32">Conductor de Transmilenio</option>
            <option value="33">Conductor de Sitp</option>
            <option value="34">Jardinero/a</option>
            <option value="35">Científico/a</option>
            <option value="36">Profesor Universitario</option>
            <option value="37">Vendedor Informal</option>
            <option value="38">Agente de ventas</option>
            <option value="39">Perito Contador</option>
            <option value="40">Inspector de Calidad</option>
            <option value="41">Diseñador de Moda</option>
            <option value="42">Terapeuta Ocupacional</option>
            <option value="43">Analista de Datos</option>
            <option value="44">Operador de Maquinaria Pesada</option>
            <option value="45">Especialista en Seguridad Informática</option>
            <option value="46">Asistente Social</option>
            <option value="47">Gerente de Proyectos</option>
            <option value="48">Arqueólogo</option>
            <option value="49">Entrenador Personal</option>
            <option value="50">Economista Ambiental</option>
            <option value="51">Escultor</option>
            <option value="52">Cineasta</option>
            <option value="53">Analista de Créditos</option>
            <option value="54">Técnico en Radiología</option>
            <option value="55">Animador 3D</option>
            <option value="56">Biocientífico</option>
            <option value="57">Diseñador Industrial</option>
            <option value="58">Genetista</option>
            <option value="59">Peluquero Canino</option>
        </select>
        <div id="errorOcupaciones" class="error"></div>
        <br><br>

        <label>EPS:</label>
        <select name="eps" id="eps" required>
            <option>Seleccione una opción</option>
            <option value="1">EPS Sura</option>
            <option value="2">EPS Sanitas</option>
            <option value="3">EPS Famisanar</option>
            <option value="4">EPS Coomeva</option>
            <option value="5">EPS Salud Total</option>
            <option value="6">EPS Compensar</option>
            <option value="7">EPS Nueva EPS</option>
            <option value="8">EPS Aliansalud</option>
            <option value="9">EPS Cajacopi</option>
            <option value="10">EPS Comfenalco</option>
        </select>
        <div id="errorEps" class="error"></div>
        <br><br>

        <button class="btn" type="submit" name="btnregistrar">Registrarse</button>
        <p id="loginMensaje">Por favor, ingrese sus datos completos para registrar su usuario correctamente.</p>
        
        <?php
    include_once '../Controller/registroControlador.php';
    ?>
    </form>
    
    </div>
    <?php
    include_once '../View/footer.php';
    ?>
    <script src="../JS/ver_contraseña.js"></script>
    <script src="../JS/edad.js"></script>
    <script src="../JS/validacion_Formulario.js"></script>
</body>
</html>

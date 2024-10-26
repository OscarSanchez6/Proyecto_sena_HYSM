
document.getElementById('formulario_Login').addEventListener('submit', function(Validación) {
    Validación.preventDefault(); // Previene el envío del formulario por defecto

    // Obtemos los valores de los campos
    var idRol = document.getElementById('idRol').value;
    var tipoDocumento = document.getElementById('tipoDocumento').value;
    var numdocumento = document.getElementById('numdocumento').value;
    var clave = document.getElementById('password').value;

    // Expresiones regulares para cada tipo de documento
    var NUIP = /^\d{10}$/; // NUIP: Exactamente 10 dígitos
    var CedulaExtranjeria = /^\d{6,9}$/; // Cédula de Extranjería: Entre 6 y 9 dígitos
    var Cedula = /^\d{6,10}$/; // Cédula de Ciudadanía: Entre 6 y 10 dígitos
    var Passport = /^[a-zA-Z0-9]{6,9}$/; // Pasaporte: Entre 6 y 9 caracteres alfanuméricos
    var RegistroCivil = /^\d{10,11}$/; // Registro Civil: Entre 10 y 11 dígitos
    var TarjetaIdentidad = /^\d{5,10}$/; // Tarjeta de Identidad

    // Limpiamos los mensajes de error previos
    document.getElementById('idRolError').textContent = '';
    document.getElementById('tipoDocumentoError').textContent = '';
    document.getElementById('numdocumentoError').textContent = '';
    document.getElementById('claveError').textContent = '';

    // Validación
    var hayErrores = false;

    if (idRol === "Seleccione una opción")  {
        document.getElementById('idRolError').textContent = "Por favor, seleccione un tipo de rol.";
        hayErrores = true;
    }

    if (tipoDocumento === "Seleccione una opción") {
        document.getElementById('tipoDocumentoError').textContent = "Por favor, seleccione un tipo de documento.";
        hayErrores = true;
    }else {
        // Validación del número de documento según el tipo de documento seleccionado
        if (tipoDocumento === "1" && !Cedula.test(numdocumento)) { // Cédula de Ciudadanía
            document.getElementById('numdocumentoError').textContent = "El número de Cédula de Ciudadanía no es válido. Debe tener entre 6 y 10 dígitos.";
            hayErrores = true;
        }else if (tipoDocumento === "2" && !CedulaExtranjeria.test(numdocumento)) { // Cédula de Extranjería
            document.getElementById('numdocumentoError').textContent = "El número de Cédula de Extranjería no es válido. Debe tener entre 6 y 9 dígitos.";
            hayErrores = true;
        }else if (tipoDocumento === "3" && !Passport.test(numdocumento)) { // Pasaporte
            document.getElementById('numdocumentoError').textContent = "El número de Pasaporte no es válido. Debe tener entre 6 y 9 caracteres alfanuméricos.";
            hayErrores = true;
        }else if (tipoDocumento === "4" && !TarjetaIdentidad.test(numdocumento)) {
            document.getElementById('numdocumentoError').textContent = "El número de Tarjeta de Identidad no es válido. Debe tener entre 5 y 10 dígitos.";
            hayErrores = true;
        }else if (tipoDocumento === "5" && !NUIP.test(numdocumento)) { // NUIP
            document.getElementById('numdocumentoError').textContent = "El número de NUIP no es válido. Debe tener exactamente 10 dígitos.";
            hayErrores = true;
        }   else if (tipoDocumento === "6" && !RegistroCivil.test(numdocumento)) { // Registro Civil
            document.getElementById('numdocumentoError').textContent = "El número de Registro Civil no es válido. Debe tener entre 10 y 11 dígitos.";
            hayErrores = true;
        } 
    }
    if(numdocumento.length < 5){
        document.getElementById('numdocumentoError').textContent = "El número de documento no puede ser menor a 5 carácteres.";
        hayErrores = true;
    } else if (numdocumento.trim() === "") {
        document.getElementById('numdocumentoError').textContent = "El número de documento no puede estar vacío.";
        hayErrores = true;
    } 

    if (clave.length < 6) {
        document.getElementById('claveError').textContent = "La contraseña debe tener al menos 6 caracteres entre numeros y letras.";
        hayErrores = true;
    }

    // Enviar el formulario si no hay errores
    if (!hayErrores) {
        //document.getElementById('loginMensaje').textContent = "Validación exitosa. ";
        this.submit(); // Envía el formulario
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Validar formulario en la función onsubmit
    document.querySelector('form[name="form"]').onsubmit = function () {
        let esValido = true;

        // Selectores que vamos a validar
        const selectores = [
            { id: 'sexo', mensajeError: 'Por favor, seleccione un género.' },
            { id: 'rh', mensajeError: 'Por favor, seleccione su tipo de sangre.' },
            { id: 'tipoDeDocumento', mensajeError: 'Por favor, seleccione un tipo de documento.' },
            { id: 'discapacidad', mensajeError: 'Por favor, seleccione una opción para discapacidad.' },
            { id: 'sisben', mensajeError: 'Por favor, seleccione una opción para Sisben.' },
            { id: 'estadoCivil', mensajeError: 'Por favor, seleccione un estado civil.' },
            { id: 'estrato', mensajeError: 'Por favor, seleccione un estrato.' },
            { id: 'ocupaciones', mensajeError: 'Por favor, seleccione una ocupación.' },
            { id: 'eps', mensajeError: 'Por favor, seleccione una EPS.' }
        ];

        selectores.forEach(function (selector) {
            const elemento = document.getElementById(selector.id);
            const errorDiv = document.getElementById(`error${capitalize(selector.id)}`);
            if (elemento.value === '0' || elemento.value === 'Seleccione una opción') {
                errorDiv.textContent = selector.mensajeError;
                esValido = false;
            } else {
                errorDiv.textContent = '';
            }
        });

        return esValido;
    };

    // Capitaliza la primera letra del string
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});








document.addEventListener('DOMContentLoaded', function() {
    const fechaHoraInput = document.getElementById('fecha_hora');
    const solicitarCitaBtn = document.getElementById('Solicitar');
    const citaForm = document.getElementById('miFormulario');
    
    const ahora = new Date();
    const minutos = ahora.getMinutes();
    const minutosRestantes = minutos % 10;
    
    const siguienteMultiploDe10 = minutos + (10 - minutosRestantes);
    
    ahora.setMinutes(siguienteMultiploDe10);
    ahora.setSeconds(0);
    ahora.setMilliseconds(0);
    
    if (ahora.getMinutes() === 60) {
        ahora.setMinutes(0);
        ahora.setHours(ahora.getHours() + 1);
    }
    
    const año = ahora.getFullYear();
    const mes = String(ahora.getMonth() + 1).padStart(2, '0');
    const día = String(ahora.getDate()).padStart(2, '0');
    const hora = String(ahora.getHours()).padStart(2, '0');
    const minuto = String(ahora.getMinutes()).padStart(2, '0');
    
    const fechaHoraMinima = `${año}-${mes}-${día}T${hora}:${minuto}`;
    fechaHoraInput.setAttribute('min', fechaHoraMinima);
    fechaHoraInput.setAttribute('step', 600); // 600 segundos = 10 minutos

    citaForm.addEventListener('submit', function(event) {
        const seleccionada = new Date(fecha_hora.value);
        const horas = seleccionada.getHours();

        if (horas < 6 || horas >= 18) {
            alert("Las citas solo se pueden solicitar entre las 6 a.m. y las 6 p.m.");
            event.preventDefault(); // Evita que el formulario se envíe
            fechaHoraInput.value = ''; // Resetea el valor del input
        }
    });
});



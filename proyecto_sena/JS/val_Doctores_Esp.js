function actualizarDoctores() {
    var especialidadId = document.getElementById("especialidad").value;
    var doctorSelect = document.getElementById("doctor");

    // Limpiar el select de doctores
    doctorSelect.innerHTML = "<option value=''>Seleccione un Doctor</option>";

    if (especialidadId) {
        var dtr = new XMLHttpRequest();
        dtr.open("POST", "traer_doctores.php", true);
        dtr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        dtr.onreadystatechange = function () {
            if (dtr.readyState == 4 && dtr.status == 200) {
                // Agregar los doctores recibidos al select
                doctorSelect.innerHTML += dtr.responseText;
            }
        };

        dtr.send("especialidad_id=" + especialidadId);
    }
}

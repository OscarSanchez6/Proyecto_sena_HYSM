document.getElementById('fechaDeNacimiento').addEventListener('change', function() {
    var fechaDeNacimiento = new Date(this.value);
    var hoy = new Date();
    var edad = hoy.getFullYear() - fechaDeNacimiento.getFullYear();
    var mes = hoy.getMonth() - fechaDeNacimiento.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaDeNacimiento.getDate())) {
    edad--;
    }
    
    document.getElementById('edad').value = edad;
    
    
});
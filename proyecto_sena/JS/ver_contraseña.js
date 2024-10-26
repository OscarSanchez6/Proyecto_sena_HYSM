const passwordField = document.getElementById('password');
const togglePassword = document.getElementById('Password');


togglePassword.addEventListener('click', function () {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    

    if (type === 'text') {
        togglePassword.src = "../img/invisible.png"; // Ojo cerrado
    } else {
        togglePassword.src = "../img/visible.png"; // Ojo abierto
    }
});
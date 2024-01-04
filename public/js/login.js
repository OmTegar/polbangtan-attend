// start: showpass
const passwordInput = document.getElementById('passwordInput');
const togglePassword = document.getElementById('togglePassword');
const showEye = document.getElementById('showEye');

togglePassword.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showEye.classList.remove('ri-eye-line');
        showEye.classList.add('ri-eye-off-line');
    } else {
        passwordInput.type = 'password';
        showEye.classList.remove('ri-eye-off-line');
        showEye.classList.add('ri-eye-line');
    }
});
// end: showpass
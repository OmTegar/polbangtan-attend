// start: showpass
document.addEventListener('DOMContentLoaded', function() {
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
});
// end: showpass

// start: preview foto profil
const fotoProfilInput = document.querySelector('#foto-profil');
const fotoProfilPreview = document.querySelector('#fotoProfil');

fotoProfilInput.addEventListener('change', function() {
  // Mendapatkan file yang diupload
  const file = fotoProfilInput.files[0];

  // Membaca file gambar
  const reader = new FileReader();
  reader.onload = function() {
    // Mengatur sumber gambar preview
    fotoProfilPreview.src = reader.result;
  };
  reader.readAsDataURL(file);
});
// end: preview foto profil
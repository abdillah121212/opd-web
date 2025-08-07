document.addEventListener('DOMContentLoaded', function() {
    // Gunakan var untuk kompatibilitas
    var passwordInput = document.getElementById('password');
    var confirmInput = document.getElementById('password_confirmation');
    var errorElement = document.getElementById('password-confirm-error');
    
    // Cek jika elemen ada
    if (!passwordInput || !confirmInput || !errorElement) return;
    
    // Fungsi validasi
    function validatePasswordMatch() {
        var isMatch = passwordInput.value === confirmInput.value;
        
        if (confirmInput.value.length === 0) {
            errorElement.style.display = 'none';
        } else {
            errorElement.style.display = isMatch ? 'none' : 'block';
        }
    }
    
    // Event listeners
    confirmInput.addEventListener('input', validatePasswordMatch);
    passwordInput.addEventListener('input', function() {
        if (confirmInput.value.length > 0) validatePasswordMatch();
    });
});
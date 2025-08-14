document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    if (!passwordInput) return;

    // Warna yang akan digunakan
    const colors = {
        default: 'text-gray-400',    // Putih/abu-abu
        active: 'text-blue-500',     // Biru (saat mengetik)
        valid: 'text-green-500'      // Hijau (saat terpenuhi)
    };

    passwordInput.addEventListener('input', function(e) {
        const password = e.target.value;
        const requirements = {
            length: password.length >= 8,
            mixedCase: /[a-z]/.test(password) && /[A-Z]/.test(password),
            number: /\d/.test(password),
            symbol: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        // Update tampilan
        Object.keys(requirements).forEach(key => {
            const element = document.getElementById(`req-${key}`);
            if (element) {
                // Reset semua class warna
                element.classList.remove(colors.default, colors.active, colors.valid);
                
                // Beri warna sesuai kondisi
                if (password.length === 0) {
                    element.classList.add(colors.default); // Putih/abu-abu
                } else {
                    element.classList.add(
                        requirements[key] ? colors.valid : colors.active // Hijau atau Biru
                    );
                }

                // Update icon
                element.innerHTML = (requirements[key] ? '✓ ' : '✗ ') + 
                                   element.textContent.replace(/^[✓✗]\s*/, '');
            }
        });

        // Efek biru pada input saat aktif
        passwordInput.classList.add('focus:border-blue-500');
    });

    // Reset saat input kosong
    passwordInput.addEventListener('blur', function() {
        if (this.value.length === 0) {
            document.querySelectorAll('[id^="req-"]').forEach(el => {
                el.classList.remove(colors.active, colors.valid);
                el.classList.add(colors.default);
            });
        }
    });
});
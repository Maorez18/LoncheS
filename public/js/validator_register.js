document.addEventListener('DOMContentLoaded', function() {
    function validateForm() {
        // Obtener valores de los campos
        const nickname = document.getElementById('nickname').value.trim();
        const email = document.getElementById('email').value.trim();
        const name = document.getElementById('name').value.trim();
        const lastname = document.getElementById('lastname').value.trim();
        const birthdate = document.getElementById('birthdate').value.trim();
        const password = document.getElementById('password').value.trim();
        const passwordConfirm = document.getElementById('password-confirm').value.trim();

        // Verificar que todos los campos estén completos
        if (!nickname || !email || !name || !lastname || !birthdate || !password || !passwordConfirm) {
            alert('Por favor, completa todos los campos.');
            return false;
        }

        // Validar formato del correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Por favor, ingresa un correo electrónico válido.');
            return false;
        }

        // Validar contraseña: mínimo 8 caracteres, al menos 1 mayúscula, 2 números, 1 carácter especial
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d{2,})(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
        if (!passwordRegex.test(password)) {
            alert('La contraseña debe tener al menos 8 caracteres, con al menos 1 mayúscula, 2 números y 1 carácter especial.');
            return false;
        }

        // Verificar que las contraseñas coincidan
        if (password !== passwordConfirm) {
            alert('Las contraseñas no coinciden.');
            return false;
        }

        // Validar que la edad sea mayor a 18 años
        const birthdateObj = new Date(birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthdateObj.getFullYear();
        const monthDifference = today.getMonth() - birthdateObj.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdateObj.getDate())) {
            age--;
        }

        if (age < 18) {
            alert('Debes tener al menos 18 años para registrarte.');
            return false;
        }

        // Si todas las validaciones pasan, permitir el envío del formulario
        return true;
    }

    // Asociar la validación al evento de envío del formulario
    const form = document.getElementById('registerForm');
    if (form) {
        form.onsubmit = validateForm;
    }
});

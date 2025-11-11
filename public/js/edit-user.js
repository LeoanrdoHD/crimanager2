// Funciones para el formulario de edición de usuario

function confirmPasswordReset() {
    // Mostrar un mensaje de confirmación
    const confirmation = confirm("¿Está seguro que desea reestablecer la contraseña del usuario?");

    // Si el usuario confirma, genera la nueva contraseña
    if (confirmation) {
        generatePassword();
    }
}

function generatePassword() {
    const ci = document.getElementById('ciPolice').value;
    const passwordField = document.getElementById('password');
    // Extraer solo la parte numérica de ciPolice
    const numericCi = ci.replace(/\D/g, '');
    passwordField.value = numericCi ? `${numericCi}daci` : '';
    
    // Solo cambiar el valor del campo oculto si existe (para la vista de editar)
    const resetPasswordField = document.getElementById('reestablecer_password');
    if (resetPasswordField) {
        resetPasswordField.value = 'true';
    }
}

function toggleSwitch(checkbox) {
    const slider = checkbox.nextElementSibling;
    const estadoLabel = document.getElementById('estado-label');

    if (checkbox.checked) {
        slider.classList.remove('bg-danger');
        slider.classList.add('bg-success');
        estadoLabel.textContent = 'Activo';
    } else {
        slider.classList.remove('bg-success');
        slider.classList.add('bg-danger');
        estadoLabel.textContent = 'Inactivo';
    }
}

function previewProfilePhoto(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('profilePhotoPreview');
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Auto-ocultar alertas y configuraciones iniciales
document.addEventListener('DOMContentLoaded', function() {
    // Ejecutar la función al cargar la página para establecer el estado inicial correcto
    const estadoCheckbox = document.getElementById('estado');
    if (estadoCheckbox && !estadoCheckbox.disabled) {
        toggleSwitch(estadoCheckbox);
    }

    // Auto-ocultar alerta de error después de 4 segundos
    setTimeout(() => {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.transition = "opacity 0.5s ease";
            errorAlert.style.opacity = 0;
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 4000);

    // Auto-ocultar mensaje de sesión después de 3 segundos
    setTimeout(() => {
        const sessionMessage = document.getElementById('sessionMessage');
        if (sessionMessage) {
            sessionMessage.style.transition = "opacity 0.5s ease";
            sessionMessage.style.opacity = 0;
            setTimeout(() => sessionMessage.remove(), 500);
        }
    }, 3000);
});
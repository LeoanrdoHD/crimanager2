// JavaScript específico para la vista de editar perfil

// Preview de imagen mejorado
function previewProfilePhoto(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('profilePhotoPreview');
        if (preview.tagName === 'IMG') {
            preview.src = reader.result;
        } else {
            // Si es un div con iniciales, reemplazarlo con imagen
            const img = document.createElement('img');
            img.src = reader.result;
            img.width = 150;
            img.alt = 'Foto de Perfil';
            img.className = 'rounded-circle border border-secondary mb-2 preview-image';
            img.id = 'profilePhotoPreview';
            preview.parentNode.replaceChild(img, preview);
        }
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Remover foto con confirmación
function removePhoto() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar tu foto de perfil?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#2d3748',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                submitDeletePhoto();
            }
        });
    } else {
        if (confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')) {
            submitDeletePhoto();
        }
    }
}

// Función para enviar el formulario de eliminar foto
function submitDeletePhoto() {
    const form = document.createElement('form');
    form.method = 'POST';

    // Detectar si estamos en /user/profile/edit o /profile/edit
    const isUserProfile = window.location.pathname.includes('/user/profile');
    
    // Aquí necesitarás ajustar las rutas según tu aplicación
    // form.action = isUserProfile ? 'RUTA_USER_PROFILE_DELETE' : 'RUTA_PROFILE_DELETE';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';

    form.appendChild(csrfToken);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = event.target.closest('.camera-btn');

    if (field && button) {
        if (field.type === 'password') {
            field.type = 'text';
            button.innerHTML = '🙈 Ocultar';
        } else {
            field.type = 'password';
            button.innerHTML = '👁️ Ver';
        }
    }
}

// Auto-ocultar alertas y configuraciones iniciales
document.addEventListener('DOMContentLoaded', function() {
    // Auto-ocultar alerta de éxito después de 8 segundos
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.transition = "opacity 0.5s ease";
            successAlert.style.opacity = 0;
            setTimeout(() => successAlert.remove(), 500);
        }
    }, 8000);

    // Auto-ocultar alerta de error después de 8 segundos
    setTimeout(() => {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.transition = "opacity 0.5s ease";
            errorAlert.style.opacity = 0;
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 8000);

    // Form submission con estados de carga
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function() {
            const btn = document.getElementById('saveBtn');
            btn.innerHTML = '⏳ Guardando...';
            btn.disabled = true;
            btn.classList.remove('primary');
            btn.classList.add('secondary');
        });
    }

    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '⏳ Actualizando...';
            btn.disabled = true;
            btn.classList.remove('primary');
            btn.classList.add('secondary');
        });
    }
});
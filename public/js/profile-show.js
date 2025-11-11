// JavaScript específico para la vista de perfil (solo lectura)

document.addEventListener('DOMContentLoaded', function() {
    // Auto-ocultar alertas después de 8 segundos
    setTimeout(function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.transition = "opacity 0.5s ease";
            successAlert.style.opacity = 0;
            setTimeout(() => successAlert.remove(), 500);
        }

        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.transition = "opacity 0.5s ease";
            errorAlert.style.opacity = 0;
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 8000);

    // Mejorar experiencia de modales
    const logoutModal = document.getElementById('logoutModal');
    if (logoutModal) {
        logoutModal.addEventListener('show.bs.modal', function() {
            const passwordField = this.querySelector('input[type="password"]');
            if (passwordField) {
                passwordField.value = '';
                setTimeout(() => passwordField.focus(), 300);
            }
        });
    }

    // Animaciones para las tarjetas de estadísticas
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Animaciones para las tarjetas de sesiones
    const sessionCards = document.querySelectorAll('.session-card');
    sessionCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
        }, (index * 100) + 500);
    });

    // Animación para la tabla de historial
    const historyTable = document.querySelector('.history-table');
    if (historyTable) {
        const rows = historyTable.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            
            setTimeout(() => {
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, (index * 50) + 1000);
        });
    }

    // Efecto de pulso para sesiones en línea
    const onlineBadges = document.querySelectorAll('.session-badge.online');
    onlineBadges.forEach(badge => {
        setInterval(() => {
            badge.style.opacity = '0.5';
            setTimeout(() => {
                badge.style.opacity = '1';
            }, 500);
        }, 3000);
    });

    // Confirmación antes de cerrar sesiones
    const logoutForm = document.querySelector('#logoutModal form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
            const sessionCount = this.querySelector('.camera-btn.danger').textContent.match(/\((\d+)\)/);
            const count = sessionCount ? sessionCount[1] : 0;
            
            if (count > 0) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.innerHTML = '⏳ Cerrando sesiones...';
                submitButton.disabled = true;
                submitButton.classList.remove('danger');
                submitButton.classList.add('secondary');
            }
        });
    }
});

// Función para refrescar la página automáticamente cada 5 minutos
setInterval(function() {
    // Solo refrescar si no hay modales abiertos
    const modals = document.querySelectorAll('.modal.show');
    if (modals.length === 0) {
        console.log('Refrescando datos de sesiones...');
        // Aquí podrías hacer una petición AJAX para actualizar solo las sesiones
        // window.location.reload();
    }
}, 300000); // 5 minutos

// Función para mostrar tooltip en elementos con información adicional
function initTooltips() {
    const elementsWithTooltip = document.querySelectorAll('[data-toggle="tooltip"]');
    elementsWithTooltip.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Implementar tooltip personalizado si es necesario
        });
    });
}

// Función para animar contadores (si quieres efecto de conteo)
function animateCounters() {
    const counters = document.querySelectorAll('.stat-content h4');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = target / 30; // 30 frames de animación
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 50);
    });
}

// Función para formatear tiempo relativo
function updateRelativeTimes() {
    const timeElements = document.querySelectorAll('[data-time]');
    timeElements.forEach(element => {
        const timestamp = element.getAttribute('data-time');
        if (timestamp) {
            // Aquí podrías implementar lógica para actualizar tiempos relativos
            // como "hace 5 minutos", "hace 1 hora", etc.
        }
    });
}

// Inicializar tooltips y animaciones al cargar la página
initTooltips();

// Opcional: animar contadores al hacer scroll a la sección de estadísticas
const statsSection = document.querySelector('.statistics-grid');
if (statsSection) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    });
    
    observer.observe(statsSection);
}
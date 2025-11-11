// ========================================
// CRIMINAL SHOW - JAVASCRIPT FINAL LIMPIO
// ========================================

// ========================================
// INICIALIZACIÓN DEL DOCUMENTO
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    initializeAccordion();
    initializePhotoGallery();
    initializeVehiclePhotos();
    initializeVehicleModalsBootstrap(); // Solo Bootstrap
    initializeSuccessAlert();
    initializeResponsiveFeatures();
    initializeScrollAnimations();
    initializeAccessibility();
    
    setTimeout(() => {
        initializePrincipalPhotoModals();
        handleModalErrors();
        initializeCardEffects();
        
        if (document.querySelectorAll('img[data-src]').length > 0) {
            initializeLazyLoading();
        }
    }, 100);
});

// ========================================
// FUNCIONES DEL ACORDEÓN MEJORADO
// ========================================

function initializeAccordion() {
    const accordionButtons = document.querySelectorAll('.accordion-button-enhanced');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const targetCollapse = document.querySelector(targetId);
            const accordionItem = this.closest('.accordion-item-enhanced');
            
            // Añadir efecto visual al abrir/cerrar
            if (targetCollapse && targetCollapse.classList.contains('collapse')) {
                setTimeout(() => {
                    if (targetCollapse.classList.contains('show')) {
                        accordionItem.style.boxShadow = '0 4px 16px rgba(0, 0, 0, 0.4)';
                        accordionItem.style.borderColor = '#6B7280';
                    } else {
                        accordionItem.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.3)';
                        accordionItem.style.borderColor = '#4B5563';
                    }
                }, 350);
            }
        });
    });
    
    // Animación suave para el contenido del acordeón
    const collapseElements = document.querySelectorAll('.accordion-collapse');
    collapseElements.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
            this.style.opacity = '0';
            setTimeout(() => {
                this.style.transition = 'opacity 0.3s ease';
                this.style.opacity = '1';
            }, 100);
        });
        
        collapse.addEventListener('hide.bs.collapse', function() {
            this.style.transition = 'opacity 0.2s ease';
            this.style.opacity = '0';
        });
    });
}

// ========================================
// FUNCIONES DE GALERÍA DE FOTOS PRINCIPALES
// ========================================

function initializePhotoGallery() {
    // Inicializar tabs de fotos principales
    const photoTabs = document.querySelectorAll('.photo-tab-btn');
    photoTabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const tabPane = document.querySelector(e.target.getAttribute('data-bs-target'));
            if (tabPane) {
                const img = tabPane.querySelector('.tab-photo-expanded');
                if (img) {
                    img.style.opacity = '0';
                    img.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        img.style.transition = 'all 0.3s ease';
                        img.style.opacity = '1';
                        img.style.transform = 'scale(1)';
                    }, 50);
                }
            }
        });
    });
    
    // Efectos hover para contenedores de fotos principales
    const photoContainers = document.querySelectorAll('.main-photo-wrapper, .tab-photo-container-expanded');
    photoContainers.forEach(container => {
        container.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.4)';
        });
        
        container.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.3)';
        });
    });
}

// ========================================
// FUNCIONES DE FOTOS DE VEHÍCULOS (SOLO HOVER)
// ========================================

function initializeVehiclePhotos() {
    const vehiclePhotoThumbs = document.querySelectorAll('.photo-thumb-enhanced');
    
    vehiclePhotoThumbs.forEach(thumb => {
        thumb.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.5)';
        });
        
        thumb.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.4)';
        });
        
        // Efecto de carga de imagen
        const img = thumb.querySelector('img');
        if (img) {
            img.addEventListener('load', function() {
                this.style.opacity = '0';
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transition = 'all 0.3s ease';
                    this.style.opacity = '1';
                    this.style.transform = 'scale(1)';
                }, 50);
            });
        }
    });
}

// ========================================
// SISTEMA DE MODALES CON BOOTSTRAP - ÚNICO
// ========================================

function initializeVehicleModalsBootstrap() {
    console.log('🚗 Inicializando modales con Bootstrap...');
    
    // Encontrar todos los thumbnails de vehículos
    const vehicleThumbs = document.querySelectorAll('.photo-thumb-enhanced[data-bs-target]');
    console.log(`📷 Thumbnails encontrados: ${vehicleThumbs.length}`);
    
    vehicleThumbs.forEach((thumb, index) => {
        // Limpiar eventos previos
        const newThumb = thumb.cloneNode(true);
        thumb.parentNode.replaceChild(newThumb, thumb);
        
        newThumb.addEventListener('click', function(e) {
            e.preventDefault();
            
            const modalId = this.getAttribute('data-bs-target');
            console.log(`🖱️ Click en thumbnail ${index + 1}, modal: ${modalId}`);
            
            const modal = document.querySelector(modalId);
            if (modal) {
                try {
                    // Usar Bootstrap Modal
                    let bsModal = bootstrap.Modal.getInstance(modal);
                    if (!bsModal) {
                        bsModal = new bootstrap.Modal(modal, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                    }
                    
                    bsModal.show();
                    console.log(`✅ Modal mostrado: ${modalId}`);
                    
                } catch (error) {
                    console.error('❌ Error mostrando modal:', error);
                }
            } else {
                console.error('❌ Modal no encontrado:', modalId);
            }
        });
        
        // Hacer focuseable
        newThumb.setAttribute('tabindex', '0');
        newThumb.setAttribute('role', 'button');
        
        // Soporte para teclado
        newThumb.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Configurar eventos de los modales
    const vehicleModals = document.querySelectorAll('[id*="vehiclePhotoModal"]');
    console.log(`🔧 Configurando ${vehicleModals.length} modales...`);
    
    vehicleModals.forEach(modal => {
        // Asegurar que el botón de cerrar funcione
        const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                console.log(`🔒 Click en botón cerrar de: ${modal.id}`);
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            });
        });
        
        // Eventos de apertura
        modal.addEventListener('show.bs.modal', function() {
            console.log(`📂 Mostrando modal: ${this.id}`);
            const img = this.querySelector('.modal-body img');
            if (img) {
                img.style.opacity = '0';
                img.style.transform = 'scale(0.9)';
                img.style.transition = 'all 0.3s ease';
            }
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            console.log(`✅ Modal mostrado completamente: ${this.id}`);
            const img = this.querySelector('.modal-body img');
            if (img) {
                setTimeout(() => {
                    img.style.opacity = '1';
                    img.style.transform = 'scale(1)';
                }, 100);
            }
        });
        
        modal.addEventListener('hide.bs.modal', function() {
            console.log(`🔒 Ocultando modal: ${this.id}`);
        });
        
        modal.addEventListener('hidden.bs.modal', function() {
            console.log(`❌ Modal oculto completamente: ${this.id}`);
        });
    });
    
    console.log('✅ Modales Bootstrap inicializados');
}

// ========================================
// FUNCIONES PARA MODALES DE FOTOS PRINCIPALES
// ========================================

function initializePrincipalPhotoModals() {
    // Modales de fotos principales del criminal
    const principalPhotoModals = document.querySelectorAll('[id*="photoModal"], #mainPhotoModal');
    
    principalPhotoModals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            const img = this.querySelector('.modal-body img');
            if (img) {
                img.style.opacity = '0';
                img.style.transform = 'scale(0.8)';
            }
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            const img = this.querySelector('.modal-body img');
            if (img) {
                setTimeout(() => {
                    img.style.transition = 'all 0.3s ease';
                    img.style.opacity = '1';
                    img.style.transform = 'scale(1)';
                }, 100);
            }
        });
    });
}

// ========================================
// ALERTA DE ÉXITO
// ========================================

function initializeSuccessAlert() {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            successAlert.style.transition = 'all 0.5s ease';
            successAlert.style.opacity = '0';
            successAlert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
        
        // Permitir cerrar manualmente
        successAlert.addEventListener('click', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.opacity = '0';
            this.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                this.remove();
            }, 300);
        });
    }
}

// ========================================
// CARACTERÍSTICAS RESPONSIVAS
// ========================================

function initializeResponsiveFeatures() {
    // Ajustar layout según el tamaño de pantalla
    function adjustLayout() {
        const isMobile = window.innerWidth <= 768;
        const isSmallMobile = window.innerWidth <= 576;
        
        // Ajustar acordeón para móviles
        const accordionHeaders = document.querySelectorAll('.accordion-header-content-enhanced');
        accordionHeaders.forEach(header => {
            if (isMobile) {
                header.style.flexDirection = 'column';
                header.style.alignItems = 'flex-start';
                header.style.gap = '8px';
            } else {
                header.style.flexDirection = 'row';
                header.style.alignItems = 'center';
                header.style.gap = '0';
            }
        });
        
        // Ajustar tabs de fotos para móviles pequeños
        const tabTexts = document.querySelectorAll('.tab-text');
        tabTexts.forEach(text => {
            text.style.display = isSmallMobile ? 'none' : 'inline';
        });
        
        // Ajustar grid de fotos de vehículos
        const vehiclePhotoGrids = document.querySelectorAll('.photos-grid-enhanced');
        vehiclePhotoGrids.forEach(grid => {
            if (isSmallMobile) {
                grid.style.gridTemplateColumns = '1fr';
            } else if (isMobile) {
                grid.style.gridTemplateColumns = '1fr 1fr';
            } else {
                grid.style.gridTemplateColumns = '1fr 1fr';
            }
        });
        
        // Ajustar detalles de vehículos en móviles
        const vehicleDetailItems = document.querySelectorAll('.vehicle-detail-item');
        vehicleDetailItems.forEach(item => {
            if (isSmallMobile && !item.classList.contains('full-width')) {
                item.style.flexDirection = 'column';
                item.style.gap = '3px';
                const value = item.querySelector('.vehicle-value');
                if (value) {
                    value.style.textAlign = 'left';
                }
            }
        });
    }
    
    // Ejecutar al cargar y al redimensionar
    adjustLayout();
    window.addEventListener('resize', debounce(adjustLayout, 250));
}

// ========================================
// ANIMACIONES DE SCROLL
// ========================================

function initializeScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Elementos a animar
    const elementsToAnimate = document.querySelectorAll('.accordion-item-enhanced, .arrest-detail-card, .special-detail-card, .vehicle-card-enhanced');
    
    elementsToAnimate.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(element);
    });
}

// ========================================
// MEJORAS DE ACCESIBILIDAD
// ========================================

function initializeAccessibility() {
    // Mejorar el enfoque para navegación por teclado
    const focusableElements = document.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #6B7280';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
    
    // Mejorar accesibilidad de fotos
    const photoElements = document.querySelectorAll('.photo-thumb-enhanced, .main-photo-wrapper, .tab-photo-container-expanded');
    photoElements.forEach(element => {
        element.setAttribute('role', 'button');
        element.setAttribute('tabindex', '0');
        
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

// ========================================
// FUNCIONES DE UTILIDAD
// ========================================

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ========================================
// MANEJO DE ERRORES PARA MODALES
// ========================================

function handleModalErrors() {
    // Verificar modales de vehículos
    const vehicleModals = document.querySelectorAll('[id*="vehiclePhotoModal"]');
    vehicleModals.forEach(modal => {
        const modalId = modal.getAttribute('id');
        const correspondingThumbs = document.querySelectorAll(`[data-bs-target="#${modalId}"]`);
        
        if (correspondingThumbs.length === 0) {
            console.warn(`Modal ${modalId} no tiene thumbnails asociados`);
        }
    });
    
    // Verificar que las imágenes de los modales existan
    const modalImages = document.querySelectorAll('.modal-body img');
    modalImages.forEach(img => {
        img.addEventListener('error', function() {
            console.error('Error cargando imagen del modal:', this.src);
            this.style.display = 'none';
            
            // Mostrar mensaje de error
            const errorMsg = document.createElement('div');
            errorMsg.textContent = 'Error cargando la imagen';
            errorMsg.style.color = '#9CA3AF';
            errorMsg.style.textAlign = 'center';
            errorMsg.style.padding = '40px';
            this.parentNode.appendChild(errorMsg);
        });
    });
}

// ========================================
// FUNCIONES ADICIONALES PARA INTERACTIVIDAD
// ========================================

function initializeCardEffects() {
    const cards = document.querySelectorAll('.arrest-detail-card, .special-detail-card, .vehicle-section');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// ========================================
// FUNCIONES DE DEBUG Y EMERGENCIA
// ========================================

function debugBootstrapModals() {
    console.log('🔍 DEBUG - Bootstrap Modales');
    
    const modals = document.querySelectorAll('[id*="vehiclePhotoModal"]');
    const thumbs = document.querySelectorAll('.photo-thumb-enhanced[data-bs-target]');
    
    console.log(`Total modales: ${modals.length}`);
    console.log(`Total thumbnails: ${thumbs.length}`);
    
    // Verificar Bootstrap
    if (typeof bootstrap === 'undefined') {
        console.error('❌ Bootstrap no está cargado!');
        return;
    }
    
    // Verificar correspondencias
    thumbs.forEach((thumb, index) => {
        const target = thumb.getAttribute('data-bs-target');
        const modal = document.querySelector(target);
        if (!modal) {
            console.error(`❌ Thumbnail ${index + 1} apunta a modal inexistente: ${target}`);
        } else {
            console.log(`✅ Thumbnail ${index + 1} -> ${target}`);
        }
    });
    
    // Verificar botones de cerrar
    modals.forEach(modal => {
        const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');
        console.log(`Modal ${modal.id} tiene ${closeButtons.length} botones de cerrar`);
    });
}

function emergencyCloseBootstrapModals() {
    console.log('🚨 EMERGENCIA: Cerrando todos los modales Bootstrap...');
    
    const allModals = document.querySelectorAll('.modal');
    allModals.forEach(modal => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) {
            bsModal.hide();
        }
        
        // Forzar ocultación
        modal.style.display = 'none';
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    });
    
    // Limpiar backdrops
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => backdrop.remove());
    
    // Restaurar body
    document.body.style.overflow = '';
    document.body.classList.remove('modal-open');
    
    console.log('✅ Todos los modales cerrados');
}

// ========================================
// INICIALIZACIÓN FINAL
// ========================================

window.addEventListener('load', function() {
    // Verificar que Bootstrap esté disponible
    if (typeof bootstrap === 'undefined') {
        console.error('❌ Bootstrap no está disponible. Los modales no funcionarán.');
        return;
    }
    
    // Funciones de debug disponibles
    window.debugBootstrapModals = debugBootstrapModals;
    window.emergencyCloseBootstrapModals = emergencyCloseBootstrapModals;
    
    console.log('🐛 Funciones debug disponibles:');
    console.log('- debugBootstrapModals()');
    console.log('- emergencyCloseBootstrapModals()');
    
    // Verificación final
    setTimeout(() => {
        debugBootstrapModals();
    }, 1000);
});
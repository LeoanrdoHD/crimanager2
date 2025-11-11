// resources/js/criminal-form.js - Versión Simplificada

class CriminalForm {
    constructor() {
        this.init();
    }

    init() {
        this.setupFormValidation();
        this.setupAgeCalculation();
        this.setupNationalityHandler();
        this.setupOccupationHandler();
        this.setupLocationCascades();
        // No verificamos cámara al inicio, dejamos que el usuario lo intente
    }

    // Configurar validación del formulario
    setupFormValidation() {
        const form = document.querySelector('.form-criminal');
        if (form) {
            form.addEventListener('submit', (e) => this.validateForm(e));
        }
    }

    // Configurar cálculo automático de edad
    setupAgeCalculation() {
        const dateOfBirthInput = document.getElementById('date_of_birth');
        const ageInput = document.getElementById('age');
        
        if (dateOfBirthInput && ageInput) {
            dateOfBirthInput.addEventListener('change', () => {
                this.calculateAge(dateOfBirthInput.value, ageInput);
            });
        }
    }

    // Configurar manejo de nacionalidad "Otro"
    setupNationalityHandler() {
        const nationalitySelect = document.getElementById('nationalitySelect');
        const otherNationalityDiv = document.getElementById('otherNationalityDiv');
        
        if (nationalitySelect && otherNationalityDiv) {
            nationalitySelect.addEventListener('change', () => {
                this.toggleOtherField(nationalitySelect, otherNationalityDiv, 'otra_nacionalidad');
            });
        }
    }

    // Configurar manejo de ocupación "Otra"
    setupOccupationHandler() {
        const ocupationSelect = document.getElementById('ocupationSelect');
        const otherOcupationDiv = document.getElementById('otherOcupationDiv');
        
        if (ocupationSelect && otherOcupationDiv) {
            ocupationSelect.addEventListener('change', () => {
                this.toggleOtherField(ocupationSelect, otherOcupationDiv, 'otra_ocupacion');
            });
        }
    }

    // Configurar cascadas de ubicación
    setupLocationCascades() {
        // Lugar de Nacimiento
        this.setupLocationCascade('country', 'state', 'citySelect', 'newCountryField', 'newStateField', 'newCityField');
        
        // Lugar de Residencia
        this.setupLocationCascade('country_a', 'state_a', 'citySelect_a', 'newCountryField_a', 'newStateField_a', 'newCityField_a');
    }

    // Calcular edad
    calculateAge(birthDate, ageInput) {
        if (!birthDate) return;
        
        const dob = new Date(birthDate);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDifference = today.getMonth() - dob.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age >= 0 ? age : '';
    }

    // Alternar campo "Otro"
    toggleOtherField(selectElement, otherDiv, fieldName) {
        const otherField = otherDiv.querySelector(`input[name="${fieldName}"]`);
        
        if (selectElement.value === 'otro' || selectElement.value === 'otra') {
            otherDiv.style.display = 'block';
            if (otherField) otherField.setAttribute('required', 'required');
        } else {
            otherDiv.style.display = 'none';
            if (otherField) otherField.removeAttribute('required');
        }
    }

    // Configurar cascada de ubicaciones
    setupLocationCascade(countryId, stateId, cityId, newCountryId, newStateId, newCityId) {
        const countrySelect = document.getElementById(countryId);
        const stateSelect = document.getElementById(stateId);
        const citySelect = document.getElementById(cityId);
        const newCountryField = document.getElementById(newCountryId);
        const newStateField = document.getElementById(newStateId);
        const newCityField = document.getElementById(newCityId);

        if (!countrySelect || !stateSelect || !citySelect) return;

        // Manejar selección de país
        countrySelect.addEventListener('change', () => {
            const countryValue = countrySelect.value;
            
            if (countryValue === 'otro') {
                this.showField(newCountryField);
                this.resetSelectOptions(stateSelect);
                this.resetSelectOptions(citySelect);
            } else {
                this.hideField(newCountryField);
                
                if (countryValue) {
                    this.loadStates(countryValue, stateSelect, citySelect);
                } else {
                    this.resetSelectOptions(stateSelect);
                    this.resetSelectOptions(citySelect);
                }
            }
        });

        // Manejar selección de estado
        stateSelect.addEventListener('change', () => {
            const stateValue = stateSelect.value;
            
            if (stateValue === 'otro') {
                this.showField(newStateField);
                this.resetSelectOptions(citySelect);
            } else {
                this.hideField(newStateField);
                
                if (stateValue) {
                    this.loadCities(stateValue, citySelect);
                } else {
                    this.resetSelectOptions(citySelect);
                }
            }
        });

        // Manejar selección de ciudad
        if (newCityField) {
            citySelect.addEventListener('change', () => {
                if (citySelect.value === 'otro') {
                    this.showField(newCityField);
                } else {
                    this.hideField(newCityField);
                }
            });
        }
    }

    // Mostrar campo
    showField(field) {
        if (field) {
            field.style.display = 'block';
            field.setAttribute('required', 'required');
        }
    }

    // Ocultar campo
    hideField(field) {
        if (field) {
            field.style.display = 'none';
            field.removeAttribute('required');
        }
    }

    // Resetear opciones de select
    resetSelectOptions(selectElement) {
        selectElement.innerHTML = '<option value="">Seleccionar</option><option value="otro">Otro</option>';
    }

    // Cargar estados
    async loadStates(countryId, stateSelect, citySelect) {
        try {
            const response = await fetch(`/states/${countryId}`);
            if (!response.ok) throw new Error('Error al cargar estados');
            
            const states = await response.json();
            this.resetSelectOptions(stateSelect);
            this.resetSelectOptions(citySelect);
            
            states.forEach(state => {
                const option = document.createElement('option');
                option.value = state.id;
                option.textContent = state.state_name;
                stateSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error:', error);
            this.showAlert('Error al cargar los estados. Por favor, intente nuevamente.');
        }
    }

    // Cargar ciudades
    async loadCities(stateId, citySelect) {
        try {
            const response = await fetch(`/cities/${stateId}`);
            if (!response.ok) throw new Error('Error al cargar ciudades');
            
            const cities = await response.json();
            this.resetSelectOptions(citySelect);
            
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.city_name;
                citySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error:', error);
            this.showAlert('Error al cargar las ciudades. Por favor, intente nuevamente.');
        }
    }

    // Abrir cámara - MÉTODO SIMPLIFICADO
    openCamera(inputId, facingMode = 'environment') {
        console.log(`Intentando abrir cámara para ${inputId} con modo ${facingMode}`);
        
        const input = document.getElementById(inputId);
        if (!input) {
            console.error('Input no encontrado:', inputId);
            return;
        }
        
        // Crear input temporal con configuración de cámara
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.accept = 'image/*';
        tempInput.capture = facingMode;
        
        tempInput.onchange = (e) => {
            console.log('Archivo seleccionado desde cámara');
            if (e.target.files && e.target.files[0]) {
                this.transferFile(e.target.files[0], input);
            }
        };
        
        // Esto debería abrir la cámara si está disponible, o el selector de archivos si no
        tempInput.click();
    }

    // Abrir selector de archivos
    openFileSelector(inputId) {
        console.log(`Abriendo selector de archivos para ${inputId}`);
        
        const input = document.getElementById(inputId);
        if (!input) {
            console.error('Input no encontrado:', inputId);
            return;
        }
        
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.accept = 'image/*';
        
        tempInput.onchange = (e) => {
            console.log('Archivo seleccionado desde explorador');
            if (e.target.files && e.target.files[0]) {
                this.transferFile(e.target.files[0], input);
            }
        };
        
        tempInput.click();
    }

    // Transferir archivo al input original
    transferFile(file, targetInput) {
        console.log('Transfiriendo archivo:', file.name);
        
        const dt = new DataTransfer();
        dt.items.add(file);
        targetInput.files = dt.files;
        
        // Disparar evento change
        const event = new Event('change', { bubbles: true });
        targetInput.dispatchEvent(event);
    }

    // Vista previa de imagen
    previewImage(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        
        if (!preview) return;

        if (file && file.type.startsWith('image/')) {
            // Validar tamaño (máximo 5MB)
            if (file.size > 5 * 1024 * 1024) {
                this.showAlert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            // Restablecer imagen predeterminada
            preview.src = window.defaultImagePath || '';
            if (file) {
                this.showAlert('Por favor, seleccione un archivo de imagen válido.');
                input.value = '';
            }
        }
    }

    // Validar formulario
    validateForm(e) {
        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let hasErrors = false;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                hasErrors = true;
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
            this.showAlert('Por favor, complete todos los campos obligatorios marcados con *');
            
            // Scroll al primer error
            const firstError = form.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    }

    // Mostrar alerta
    showAlert(message) {
        alert(message);
    }
}

// Funciones globales para compatibilidad
window.criminalForm = null;

window.previewImage = function(input, previewId) {
    if (window.criminalForm) {
        window.criminalForm.previewImage(input, previewId);
    }
};

window.openCamera = function(inputId, facingMode) {
    console.log('Función global openCamera llamada:', inputId, facingMode);
    if (window.criminalForm) {
        window.criminalForm.openCamera(inputId, facingMode);
    }
};

window.openFileSelector = function(inputId) {
    console.log('Función global openFileSelector llamada:', inputId);
    if (window.criminalForm) {
        window.criminalForm.openFileSelector(inputId);
    }
};

window.showCameraOptions = function(inputId) {
    console.log('Función global showCameraOptions llamada:', inputId);
    if (window.criminalForm) {
        window.criminalForm.openCamera(inputId, 'environment');
    }
};

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando CriminalForm...');
    window.criminalForm = new CriminalForm();
    
    // Configurar ruta de imagen por defecto
    window.defaultImagePath = document.querySelector('meta[name="default-image-path"]')?.content || 
                             '/vendor/adminlte/dist/img/Add_Image_icon-icons.png';
    
    console.log('CriminalForm inicializado correctamente');
});
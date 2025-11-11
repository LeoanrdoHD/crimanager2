@extends('adminlte::page')
@vite(['resources/css/app.css'])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/criminal-form.css') }}">
    <style>
        /* Estilos para autofill mejorados */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.1) inset !important;
            -webkit-text-fill-color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            transition: all 5000s ease-in-out 0s !important;
        }

    </style>
@endsection

@section('content_header')
    <h1 class="text-center" style="color: white;">
        Agregar Condena a: {{ $criminal->first_name }} {{ $criminal->last_nameP }}
        {{ $criminal->last_nameM }}</h1>
@stop

@section('content')
    <p style="color: white;">
        <strong>Registro de Captura:</strong>
        <span style="font-style: italic; color: #d1d5db;">
            Fecha: {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }},  
            Hora: {{ \Carbon\Carbon::parse($history->arrest_time)->format('H:i') }}
        </span>
    </p>
    
    <div class="card">
        <div class="card-body">
            <div>
                <div class="section-title">Registro de Sentencias Judiciales</div>
                <form class="ajax-form" action="{{ route('criminals.update_condena', ['criminal' => $criminal->id, 'history' => $history->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
                    
                    <div class="grid grid-cols-1 gap-10">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Tipo de Pena:</label>
                                <select class="form-control w-full" name="detention_type_id" id="detentionType"
                                    onchange="mostrarCampos()">
                                    <option value="">Seleccionar</option>
                                    @foreach ($tcondena as $detention_type)
                                        <option value="{{ $detention_type->id }}">{{ $detention_type->detention_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Campos para Detención Preventiva -->
                            <div id="camposDetencionPreventiva" class="seccion-condicional" style="display: none;">
                                <div class="form-group">
                                    <label class="required-field">Prisión:</label>
                                    <select class="form-control w-full" name="prison_name" id="prisonSelect"
                                        onchange="llenarCamposPrision()">
                                        <option value="">Seleccionar</option>
                                        @foreach ($prision as $prison)
                                            <option value="{{ $prison->id }}" 
                                                data-direccion="{{ $prison->prison_location }}"
                                                data-pais="{{ $prison->country->country_name }}"
                                                data-estado="{{ $prison->state->state_name }}"
                                                data-ciudad="{{ $prison->city->city_name }}">
                                                {{ $prison->prison_name }}
                                            </option>
                                        @endforeach
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>

                                <div id="camposOtraPrision" class="seccion-condicional" style="display: none;">
                                    <div class="form-group">
                                        <label>Nombre de la Prisión:</label>
                                        <input type="text" class="form-control w-full" name="otra_prision_nombre"
                                            placeholder="Nombre de la prisión">
                                    </div>
                                    <div class="form-group">
                                        <label>Dirección de la Prisión:</label>
                                        <input type="text" class="form-control w-full" name="prison_location"
                                            placeholder="Dirección">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="form-group">
                                            <label for="country_p">País:</label>
                                            <select id="country_p" name="country_id_p" class="form-control w-full">
                                                <option value="">Seleccionar</option>
                                                @foreach ($pais as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country_id_p') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->country_name }}
                                                    </option>
                                                @endforeach
                                                <option value="otro"
                                                    {{ old('country_id_p') == 'otro' ? 'selected' : '' }}>Otro
                                                </option>
                                            </select>
                                            <input type="text" id="newCountryField_p" class="form-control w-full"
                                                name="new_country_name_p" placeholder="Nombre del nuevo país"
                                                style="display: {{ old('country_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                                value="{{ old('new_country_name_p') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="state_p">Estado/Departamento:</label>
                                            <select id="state_p" name="province_id_p" class="form-control w-full">
                                                <option value="">Seleccionar</option>
                                                @foreach ($provincia as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ old('province_id_p') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                                <option value="otro"
                                                    {{ old('province_id_p') == 'otro' ? 'selected' : '' }}>Otro
                                                </option>
                                            </select>
                                            <input type="text" id="newStateField_p" class="form-control w-full"
                                                name="new_state_name_p" placeholder="Nombre del nuevo estado"
                                                style="display: {{ old('province_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                                value="{{ old('new_state_name_p') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="citySelect_p">Ciudad/Municipio:</label>
                                            <select id="citySelect_p" name="city_id_p" class="form-control w-full">
                                                <option value="">Seleccionar</option>
                                                @foreach ($ciudad as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ old('city_id_p') == $city->id ? 'selected' : '' }}>
                                                        {{ $city->city_name }}
                                                    </option>
                                                @endforeach
                                                <option value="otro" {{ old('city_id_p') == 'otro' ? 'selected' : '' }}>
                                                    Otro
                                                </option>
                                            </select>
                                            <input type="text" id="newCityField_p" class="form-control w-full"
                                                name="new_city_name_p" placeholder="Nombre de la nueva ciudad"
                                                style="display: {{ old('city_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                                value="{{ old('new_city_name_p') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos para mostrar los detalles de la prisión seleccionada -->
                                <div id="camposPrisionSeleccionada" class="seccion-condicional" style="display: none;">
                                    <div class="form-group">
                                        <label>Dirección de la Prisión:</label>
                                        <input type="text" class="form-control" id="prisonLocation" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>País:</label>
                                        <input type="text" class="form-control" id="pais" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Departamento/Estado:</label>
                                        <input type="text" class="form-control" id="dep" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Ciudad:</label>
                                        <input type="text" class="form-control" id="city" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="required-field">Fecha de Ingreso:</label>
                                    <input type="date" class="form-control" name="prison_entry_date">
                                </div>
                                <div class="form-group">
                                    <label>Fecha de Salida:</label>
                                    <input type="date" class="form-control" name="prison_release_date">
                                </div>
                            </div>

                            <!-- Campos para Detención Domiciliaria -->
                            <div id="camposDetencionDomiciliaria" class="seccion-condicional" style="display: none;">
                                <div class="form-group">
                                    <label class="required-field">Dirección de Detención Domiciliaria:</label>
                                    <input type="text" class="form-control w-full" name="house_arrest_address"
                                        placeholder="Ingrese una dirección">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="form-group">
                                        <label for="country_d">País:</label>
                                        <select id="country_d" name="country_id_d" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($pais as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id_d') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('country_id_d') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCountryField_d" class="form-control w-full"
                                            name="new_country_name_d" placeholder="Nombre del nuevo país"
                                            style="display: {{ old('country_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_country_name_d') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="state_d">Estado/Departamento:</label>
                                        <select id="state_d" name="province_id_d" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($provincia as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('province_id_d') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->state_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('province_id_d') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newStateField_d" class="form-control w-full"
                                            name="new_state_name_d" placeholder="Nombre del nuevo estado"
                                            style="display: {{ old('province_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_state_name_d') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="citySelect_d">Ciudad/Municipio:</label>
                                        <select id="citySelect_d" name="city_id_d" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($ciudad as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id_d') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->city_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('city_id_d') == 'otro' ? 'selected' : '' }}>Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCityField_d" class="form-control w-full"
                                            name="new_city_name_d" placeholder="Nombre de la nueva ciudad"
                                            style="display: {{ old('city_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_city_name_d') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para Extradición -->
                            <div id="camposExtradicion" class="seccion-condicional" style="display: none;">
                                <div class="form-group">
                                    <label class="required-field">Fecha de Extradición:</label>
                                    <input type="date" class="form-control w-full" name="extradition_date">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="form-group">
                                        <label for="country_e">País:</label>
                                        <select id="country_e" name="country_id_e" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($pais as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id_e') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('country_id_e') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCountryField_e" class="form-control w-full"
                                            name="new_country_name_e" placeholder="Nombre del nuevo país"
                                            style="display: {{ old('country_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_country_name_e') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="state_e">Estado/Departamento:</label>
                                        <select id="state_e" name="province_id_e" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($provincia as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('province_id_e') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->state_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('province_id_e') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newStateField_e" class="form-control w-full"
                                            name="new_state_name_e" placeholder="Nombre del nuevo estado"
                                            style="display: {{ old('province_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_state_name_e') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="citySelect_e">Ciudad/Municipio:</label>
                                        <select id="citySelect_e" name="city_id_e" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($ciudad as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id_e') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->city_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('city_id_e') == 'otro' ? 'selected' : '' }}>Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCityField_e" class="form-control w-full"
                                            name="new_city_name_e" placeholder="Nombre de la nueva ciudad"
                                            style="display: {{ old('city_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_city_name_e') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para Libertad -->
                            <div id="camposLibertad" class="seccion-condicional" style="display: none;">
                                <div class="form-group">
                                    <label class="required-field">Dirección:</label>
                                    <input type="text" class="form-control w-full" name="house_address"
                                        placeholder="Ingrese una dirección">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="form-group">
                                        <label for="country_l">País:</label>
                                        <select id="country_l" name="country_id_l" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($pais as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id_l') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('country_id_l') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCountryField_l" class="form-control w-full"
                                            name="new_country_name_l" placeholder="Nombre del nuevo país"
                                            style="display: {{ old('country_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_country_name_l') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="state_l">Estado/Departamento:</label>
                                        <select id="state_l" name="province_id_l" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($provincia as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('province_id_l') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->state_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('province_id_l') == 'otro' ? 'selected' : '' }}>
                                                Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newStateField_l" class="form-control w-full"
                                            name="new_state_name_l" placeholder="Nombre del nuevo estado"
                                            style="display: {{ old('province_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_state_name_l') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="citySelect_l">Ciudad/Municipio:</label>
                                        <select id="citySelect_l" name="city_id_l" class="form-control w-full">
                                            <option value="">Seleccionar</option>
                                            @foreach ($ciudad as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id_l') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->city_name }}
                                                </option>
                                            @endforeach
                                            <option value="otro" {{ old('city_id_l') == 'otro' ? 'selected' : '' }}>Otro
                                            </option>
                                        </select>
                                        <input type="text" id="newCityField_l" class="form-control w-full"
                                            name="new_city_name_l" placeholder="Nombre de la nueva ciudad"
                                            style="display: {{ old('city_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                            value="{{ old('new_city_name_l') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #6b7280;">
                        <button class="camera-btn primary" type="submit" style="padding: 12px 24px; min-width: 120px;">GUARDAR</button>
                        <button class="camera-btn secondary" type="button" onclick="window.history.back()" style="padding: 12px 24px; min-width: 120px;">CANCELAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
// Sistema de condenas mejorado
class CondenaManager {
    constructor() {
        this.initializeEventListeners();
        this.locationCascades = new Map();
        this.setupLocationCascades();
        this.setupPrisonManagement();
        console.log('✅ Sistema de condenas inicializado');
    }

    initializeEventListeners() {
        // Event listener para el formulario
        const form = document.querySelector('.ajax-form');
        if (form) {
            form.addEventListener('submit', this.handleFormSubmit.bind(this));
        }

        // Event listener para mostrar campos
        window.mostrarCampos = this.mostrarCampos.bind(this);
        window.llenarCamposPrision = this.llenarCamposPrision.bind(this);
    }

    mostrarCampos() {
        const detentionType = document.getElementById("detentionType")?.value;
        
        // Mapeo de tipos de detención a secciones
        const secciones = {
            "1": "camposDetencionPreventiva",
            "2": "camposDetencionDomiciliaria", 
            "3": "camposExtradicion",
            "4": "camposLibertad"
        };

        // Ocultar todas las secciones con animación
        Object.values(secciones).concat(["camposOtraPrision"]).forEach(seccionId => {
            const seccion = document.getElementById(seccionId);
            if (seccion) {
                seccion.style.display = "none";
                seccion.classList.remove("fade-in");
            }
        });

        // Mostrar la sección correspondiente
        const seccionAMostrar = secciones[detentionType];
        if (seccionAMostrar) {
            const seccion = document.getElementById(seccionAMostrar);
            if (seccion) {
                seccion.style.display = "block";
                // Añadir animación con un pequeño delay para suavidad
                setTimeout(() => seccion.classList.add("fade-in"), 50);
            }
        }

        console.log(`📋 Tipo de pena seleccionado: ${detentionType} → ${seccionAMostrar || 'ninguno'}`);
    }

    llenarCamposPrision() {
        const select = document.getElementById("prisonSelect");
        if (!select) return;

        const selectedOption = select.options[select.selectedIndex];
        const campos = {
            prisonLocation: selectedOption?.getAttribute("data-direccion") || "",
            pais: selectedOption?.getAttribute("data-pais") || "",
            dep: selectedOption?.getAttribute("data-estado") || "",
            city: selectedOption?.getAttribute("data-ciudad") || ""
        };

        // Llenar campos con validación
        Object.entries(campos).forEach(([fieldId, value]) => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = value;
            }
        });

        console.log('🏢 Datos de prisión cargados:', campos);
    }

    setupLocationCascades() {
        // Configurar cascadas para cada sufijo
        ['p', 'd', 'e', 'l'].forEach(suffix => {
            this.locationCascades.set(suffix, new LocationCascade(suffix));
        });
    }

    setupPrisonManagement() {
        const prisonSelect = document.getElementById("prisonSelect");
        if (!prisonSelect) return;

        prisonSelect.addEventListener("change", (e) => {
            const prisonId = e.target.value;
            const camposOtraPrision = document.getElementById("camposOtraPrision");
            const camposPrisionSeleccionada = document.getElementById("camposPrisionSeleccionada");

            if (prisonId === "otro") {
                // Mostrar campos para nueva prisión
                if (camposOtraPrision) {
                    camposOtraPrision.style.display = "block";
                    setTimeout(() => camposOtraPrision.classList.add("fade-in"), 50);
                }
                if (camposPrisionSeleccionada) {
                    camposPrisionSeleccionada.style.display = "none";
                }
                this.limpiarCamposPrision();
            } else if (prisonId) {
                // Mostrar detalles de prisión existente
                if (camposOtraPrision) {
                    camposOtraPrision.style.display = "none";
                }
                if (camposPrisionSeleccionada) {
                    camposPrisionSeleccionada.style.display = "block";
                    setTimeout(() => camposPrisionSeleccionada.classList.add("fade-in"), 50);
                }
                this.llenarCamposPrision();
            } else {
                // Ocultar ambos
                [camposOtraPrision, camposPrisionSeleccionada].forEach(el => {
                    if (el) el.style.display = "none";
                });
            }
        });
    }

    limpiarCamposPrision() {
        const campos = ["prisonLocation", "pais", "dep", "city"];
        campos.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) field.value = "";
        });
    }

    handleFormSubmit(e) {
        console.log('📤 Enviando formulario de condena...');
        
        // Validaciones opcionales
        const tipoePena = document.getElementById('detentionType')?.value;
        if (!tipoePena) {
            console.warn('⚠️ Tipo de pena no seleccionado');
        }

        // El formulario se envía sin bloqueos
        return true;
    }
}

// Clase para manejar cascadas de ubicación
class LocationCascade {
    constructor(suffix) {
        this.suffix = suffix;
        this.elements = {
            country: document.getElementById(`country_${suffix}`),
            state: document.getElementById(`state_${suffix}`),
            city: document.getElementById(`citySelect_${suffix}`),
            newCountry: document.getElementById(`newCountryField_${suffix}`),
            newState: document.getElementById(`newStateField_${suffix}`),
            newCity: document.getElementById(`newCityField_${suffix}`)
        };

        this.setupEventListeners();
    }

    setupEventListeners() {
        // Event listener para país
        if (this.elements.country) {
            this.elements.country.addEventListener("change", this.handleCountryChange.bind(this));
        }

        // Event listener para estado
        if (this.elements.state) {
            this.elements.state.addEventListener("change", this.handleStateChange.bind(this));
        }

        // Event listener para ciudad
        if (this.elements.city) {
            this.elements.city.addEventListener("change", this.handleCityChange.bind(this));
        }
    }

    async handleCountryChange() {
        const countryId = this.elements.country.value;

        if (countryId === "otro") {
            this.showNewField('newCountry');
            this.resetSelectOptions('state');
            this.resetSelectOptions('city');
        } else {
            this.hideNewField('newCountry');
            
            if (countryId) {
                await this.loadStates(countryId);
            } else {
                this.resetSelectOptions('state');
                this.resetSelectOptions('city');
            }
        }
    }

    async handleStateChange() {
        const stateId = this.elements.state.value;

        if (stateId === "otro") {
            this.showNewField('newState');
            this.resetSelectOptions('city');
        } else {
            this.hideNewField('newState');
            
            if (stateId) {
                await this.loadCities(stateId);
            } else {
                this.resetSelectOptions('city');
            }
        }
    }

    handleCityChange() {
        const cityId = this.elements.city.value;
        
        if (cityId === "otro") {
            this.showNewField('newCity');
        } else {
            this.hideNewField('newCity');
        }
    }

    async loadStates(countryId) {
        try {
            const response = await fetch(`/states/${countryId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const states = await response.json();
            
            // Limpiar y llenar select de estados
            this.resetSelectOptions('state');
            this.resetSelectOptions('city');
            
            states.forEach(state => {
                const option = new Option(state.state_name, state.id);
                this.elements.state.add(option);
            });
            
            console.log(`🗺️ Estados cargados para país ${countryId}: ${states.length} elementos`);
        } catch (error) {
            console.error(`❌ Error cargando estados:`, error);
            this.setErrorMessage('state', 'Error cargando estados');
        }
    }

    async loadCities(stateId) {
        try {
            const response = await fetch(`/cities/${stateId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const cities = await response.json();
            
            // Limpiar y llenar select de ciudades
            this.resetSelectOptions('city');
            
            cities.forEach(city => {
                const option = new Option(city.city_name, city.id);
                this.elements.city.add(option);
            });
            
            console.log(`🏙️ Ciudades cargadas para estado ${stateId}: ${cities.length} elementos`);
        } catch (error) {
            console.error(`❌ Error cargando ciudades:`, error);
            this.setErrorMessage('city', 'Error cargando ciudades');
        }
    }

    showNewField(fieldType) {
        const field = this.elements[fieldType];
        if (field) {
            field.style.display = "block";
            field.focus(); // Enfoque automático para mejor UX
        }
    }

    hideNewField(fieldType) {
        const field = this.elements[fieldType];
        if (field) {
            field.style.display = "none";
            field.value = ""; // Limpiar valor al ocultar
        }
    }

    resetSelectOptions(selectType) {
        const select = this.elements[selectType];
        if (select) {
            select.innerHTML = '<option value="">Seleccionar</option><option value="otro">Otro</option>';
        }
    }

    setErrorMessage(selectType, message) {
        const select = this.elements[selectType];
        if (select) {
            select.innerHTML = `<option value="">${message}</option>`;
        }
    }
}

// Utilidades adicionales
const FormUtils = {
    // Validar formulario opcionalmente
    validateForm() {
        const tipoePena = document.getElementById('detentionType')?.value;
        const warnings = [];

        if (!tipoePena) {
            warnings.push('Se sugiere seleccionar un tipo de pena');
        }

        if (warnings.length > 0) {
            console.info('💡 Sugerencias:', warnings.join(', '));
            return confirm('Hay campos sugeridos sin completar. ¿Desea continuar?');
        }
        return true;
    },

    // Mostrar loading en botón
    setButtonLoading(button, loading = true) {
        if (!button) return;
        
        if (loading) {
            button.disabled = true;
            button.innerHTML = '⏳ Guardando...';
        } else {
            button.disabled = false;
            button.innerHTML = 'GUARDAR';
        }
    },

    // Debug de estado del formulario
    debugFormState() {
        const form = document.querySelector('.ajax-form');
        if (!form) return;

        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        console.log('🔍 Estado actual del formulario:', data);
        return data;
    }
};

// Funciones globales para compatibilidad
window.mostrarCampos = function() {
    if (window.condenaManager) {
        window.condenaManager.mostrarCampos();
    }
};

window.llenarCamposPrision = function() {
    if (window.condenaManager) {
        window.condenaManager.llenarCamposPrision();
    }
};

window.FormUtils = FormUtils;

// Inicialización cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function() {
    // Inicializar el sistema de condenas
    window.condenaManager = new CondenaManager();

    // CSS adicional para animaciones suaves
    const style = document.createElement('style');
    style.textContent = `
        .fade-in {
            animation: fadeInSmooth 0.3s ease-in-out;
        }
        
        @keyframes fadeInSmooth {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .seccion-condicional {
            background-color: rgba(255, 255, 255, 0.02);
            border-left: 4px solid #4CAF50;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 4px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #6b7280;
            color: white;
            border-radius: 4px;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
            outline: none;
        }

        .form-control[readonly] {
            background-color: rgba(255, 255, 255, 0.05);
            color: #d1d5db;
            cursor: not-allowed;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control option {
            background-color: #374151;
            color: white;
        }

        label {
            color: white;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
    `;
    document.head.appendChild(style);

    // Log final
    console.log('🎯 Sistema de condenas completamente inicializado');
    console.log('📊 Funciones disponibles:', Object.keys(window).filter(key => 
        key.includes('condena') || key.includes('FormUtils') || ['mostrarCampos', 'llenarCamposPrision'].includes(key)
    ));
});
</script>
@endsection
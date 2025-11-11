@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center text-2xl font-bold text-white">
        Agregar Historial a: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}
    </h1>
@stop

@section('content')
    <style>
        .card-body {
            background: linear-gradient(rgba(0, 0, 0, 0.874), rgba(0, 0, 0, 0.825));
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            color: white;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 8px;
            text-align: center;
        }

        .subsection-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #fff;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 5px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            color: white;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:disabled {
            background-color: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.7);
            cursor: not-allowed;
        }

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

        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.15) inset !important;
            border-color: #4CAF50 !important;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2) !important;
        }

        /* Estilos para el dropdown de autocompletado del navegador */
        input::-webkit-contacts-auto-fill-button,
        input::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none;
            position: absolute;
            right: 0;
        }

        /* Forzar estilos en el contenedor de autocompletado */
        input[autocomplete] {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        /* Intentar modificar las opciones de autocompletado (limitado por el navegador) */
        input::-webkit-list-button {
            display: none;
        }

        input::-webkit-textfield-decoration-container {
            display: none;
        }

        /* Forzar estilos solo para inputs de texto */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        input[type="url"],
        input[type="search"],
        textarea {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        input[type="url"]:focus,
        input[type="search"]:focus,
        textarea:focus {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border-color: #4CAF50 !important;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2) !important;
            outline: none !important;
        }

        /* Contenedor de checkboxes mejorado */
        .checkbox-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 30px 0;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .checkbox-container label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .checkbox-container label:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #4CAF50;
            transform: translateY(-2px);
        }

        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4CAF50;
        }

        .checkbox-container input[type="checkbox"]:checked+span {
            color: #4CAF50;
            font-weight: bold;
        }

        /* Separadores de sección */
        .section-divider {
            border: 1px solid rgba(76, 175, 80, 0.3);
            width: 100%;
            margin: 25px 0;
            display: none;
        }

        /* Contenido de secciones */
        .section-content {
            display: none;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Imagen del criminal */
        .criminal-photo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .criminal-photo img {
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid #4CAF50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .criminal-photo img:hover {
            transform: scale(1.05);
        }

        /* Alertas mejoradas */
        .alert-box {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #4caf50, #45a049);
        }

        .alert-error {
            background: linear-gradient(135deg, #f44336, #e53935);
        }

        /* Labels mejorados */
        label {
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
            display: block;
        }

        .required-field::after {
            content: " *";
            color: #ff6b6b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .checkbox-container {
                gap: 10px;
            }

            .checkbox-container label {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Alertas -->
                    @if (session('success'))
                        <div id="success-alert" class="alert-box alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div id="error-alert" class="alert-box alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Perfil del Delincuente -->
                    <div class="container mx-auto px-2">
                        <form class="form-arrest" action="{{ route('criminals.store_arrest') }}" method="POST">
                            @csrf
                            <div class="section-title">PERFIL DEL DELINCUENTE</div>

                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Nombres y Apellidos -->
                                <div class="form-group">
                                    <label for="nom_apell" class="required-field">Nombres y Apellidos:</label>
                                    <input type="text" id="nom_apell" class="form-control w-full" name="nom_apell"
                                        value="{{ $criminal->first_name }} {{ $criminal->last_name }}" disabled>
                                </div>

                                <!-- Foto del criminal -->
                                <div class="criminal-photo">
                                    @php
                                        $latestPhoto = $criminal->photographs()->latest()->first();
                                    @endphp

                                    @if ($latestPhoto)
                                        <img src="{{ asset($latestPhoto->frontal_photo) }}" width="120" height="120"
                                            alt="Foto Frontal" class="criminal-photo-img">
                                    @else
                                        <div class="text-center p-4 bg-gray-600 rounded-lg">
                                            <p class="text-gray-300">No hay fotografía disponible</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Cédula de Identidad/DNI -->
                                <div class="form-group">
                                    <label for="identity_number" class="required-field">Cédula de Identidad/DNI:</label>
                                    <input type="text" id="identity_number" class="form-control w-full"
                                        name="identity_number" value="{{ $criminal->identity_number }}" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="container mx-auto px-2">
                        <!-- Sección de Situación -->
                        @include('criminals.partials.section1_situacion')
                        <hr class="section-divider" style="display: block; border-color: rgba(76, 175, 80, 0.5);">

                        <!-- Selector de Campos -->
                        <div class="subsection-title">Seleccione los Campos a Llenar</div>

                        <div class="checkbox-container">
                            <label>
                                <input type="checkbox" id="telefonosCheck" onclick="updateSections()">
                                <span>📱 Teléfonos</span>
                            </label>
                            <label>
                                <input type="checkbox" id="armasCheck" onclick="updateSections()">
                                <span>🔫 Armas</span>
                            </label>
                            <label>
                                <input type="checkbox" id="aliasCheck" onclick="updateSections()">
                                <span>👤 Alias</span>
                            </label>
                            <label>
                                <input type="checkbox" id="complicesCheck" onclick="updateSections()">
                                <span>👥 Cómplices</span>
                            </label>
                            <label>
                                <input type="checkbox" id="organizacionCheck" onclick="updateSections()">
                                <span>🏢 Organización</span>
                            </label>
                            <label>
                                <input type="checkbox" id="condenasCheck" onclick="updateSections()">
                                <span>⚖️ Condenas</span>
                            </label>
                            <label>
                                <input type="checkbox" id="vehiculosCheck" onclick="updateSections()">
                                <span>🚗 Vehículos</span>
                            </label>
                        </div>

                        <!-- Secciones Dinámicas -->
                        <div id="telefonos" class="section-content">
                            <div class="subsection-title">📱 Información de Teléfonos</div>
                            @include('criminals.partials.section2_telefonos')
                        </div>
                        <hr id="telefonosHr" class="section-divider">

                        <div id="armas" class="section-content">
                            <div class="subsection-title">🔫 Información de Armas</div>
                            @include('criminals.partials.section4_armas')
                        </div>
                        <hr id="armasHr" class="section-divider">

                        <div id="alias" class="section-content">
                            <div class="subsection-title">👤 Información de Alias</div>
                            @include('criminals.partials.section3_alias')
                        </div>
                        <hr id="aliasHr" class="section-divider">

                        <div id="complices" class="section-content">
                            <div class="subsection-title">👥 Información de Cómplices</div>
                            @include('criminals.partials.section6_complices')
                        </div>
                        <hr id="complicesHr" class="section-divider">

                        <div id="organizacion" class="section-content">
                            <div class="subsection-title">🏢 Información de Organización</div>
                            @include('criminals.partials.section7_organizacion')
                        </div>
                        <hr id="organizacionHr" class="section-divider">

                        <div id="condenas" class="section-content">
                            <div class="subsection-title">⚖️ Información de Condenas</div>
                            @include('criminals.partials.section8_condenas')
                        </div>
                        <hr id="condenasHr" class="section-divider">

                        <div id="vehiculos" class="section-content">
                            <div class="subsection-title">🚗 Información de Vehículos</div>
                            @include('criminals.partials.section5_vehiculos')
                        </div>
                        <hr id="vehiculosHr" class="section-divider">
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        // Función para actualizar secciones
        function updateSections() {
            const sections = [{
                    checkboxId: 'telefonosCheck',
                    sectionId: 'telefonos',
                    hrId: 'telefonosHr'
                },
                {
                    checkboxId: 'armasCheck',
                    sectionId: 'armas',
                    hrId: 'armasHr'
                },
                {
                    checkboxId: 'aliasCheck',
                    sectionId: 'alias',
                    hrId: 'aliasHr'
                },
                {
                    checkboxId: 'complicesCheck',
                    sectionId: 'complices',
                    hrId: 'complicesHr'
                },
                {
                    checkboxId: 'organizacionCheck',
                    sectionId: 'organizacion',
                    hrId: 'organizacionHr'
                },
                {
                    checkboxId: 'condenasCheck',
                    sectionId: 'condenas',
                    hrId: 'condenasHr'
                },
                {
                    checkboxId: 'vehiculosCheck',
                    sectionId: 'vehiculos',
                    hrId: 'vehiculosHr'
                },
            ];

            sections.forEach(section => {
                const checkbox = document.getElementById(section.checkboxId);
                const sectionDiv = document.getElementById(section.sectionId);
                const hrDiv = document.getElementById(section.hrId);

                if (checkbox && checkbox.checked) {
                    sectionDiv.style.display = "block";
                    hrDiv.style.display = "block";

                    // Animación suave
                    sectionDiv.style.opacity = "0";
                    setTimeout(() => {
                        sectionDiv.style.transition = "opacity 0.3s ease-in-out";
                        sectionDiv.style.opacity = "1";
                    }, 10);
                } else {
                    if (sectionDiv) sectionDiv.style.display = "none";
                    if (hrDiv) hrDiv.style.display = "none";
                }
            });
        }

        // Auto-ocultar alertas
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const successAlert = document.getElementById('success-alert');
                const errorAlert = document.getElementById('error-alert');

                if (successAlert) {
                    successAlert.style.animation = 'slideIn 0.3s ease-out reverse';
                    setTimeout(() => successAlert.style.display = 'none', 300);
                }

                if (errorAlert) {
                    errorAlert.style.animation = 'slideIn 0.3s ease-out reverse';
                    setTimeout(() => errorAlert.style.display = 'none', 300);
                }
            }, 4000);
        });

        // Manejo de formularios AJAX mejorado
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.ajax-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Mostrar indicador de carga
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn ? submitBtn.textContent : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Procesando...';
                    }

                    const formData = new FormData(form);
                    fetch(form.action, {
                            method: form.method,
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            showAlert(data.message, data.success);
                            if (data.success) form.reset();
                        })
                        .catch(error => {
                            console.error('Error en la solicitud AJAX:', error);
                            showAlert('Ocurrió un error inesperado', false);
                        })
                        .finally(() => {
                            // Restaurar botón
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        });
                });
            });
        });

        // Función para mostrar alertas mejoradas
        function showAlert(message, isSuccess) {
            let alertBox = document.getElementById('dynamic-alert-box');
            if (!alertBox) {
                alertBox = document.createElement('div');
                alertBox.id = 'dynamic-alert-box';
                alertBox.className = 'alert-box';
                document.body.appendChild(alertBox);
            }

            alertBox.textContent = message;
            alertBox.className = `alert-box ${isSuccess ? 'alert-success' : 'alert-error'}`;
            alertBox.style.display = 'block';

            setTimeout(() => {
                alertBox.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => alertBox.style.display = 'none', 300);
            }, 4000);
        }
    </script>
@endsection

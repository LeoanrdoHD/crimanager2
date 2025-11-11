@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/criminal-form.css') }}">
    <meta name="default-image-path" content="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}">
@endsection

@section('js')
    <script src="{{ asset('js/criminal-form.js') }}"></script>
@endsection

@section('content_header')
    <h1 class="text-center">
        EDITAR CARACTERÍSTICAS FÍSICAS</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form class="form-criminal" action="{{ route('criminals.update', $criminal->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- SECCIÓN IZQUIERDA: RASGOS FÍSICOS -->
                    <div>
                        <div class="section-title">RASGOS FÍSICOS</div>

                        @php
                            $lastCharacteristic = $criminal->physicalCharacteristics->last();
                        @endphp

                        <!-- Estatura y Peso -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="suggested-field">Estatura (cm):</label>
                                <input type="number" class="form-control w-full @error('height') border-red-500 @enderror"
                                    name="height" placeholder="Altura en cm" min="120" max="210"
                                    value="{{ old('height', $lastCharacteristic->height ?? '') }}">
                                @error('height')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Peso (kg):</label>
                                <input type="number" class="form-control w-full @error('weight') border-red-500 @enderror"
                                    name="weight" placeholder="Peso en kg" min="35" max="200"
                                    value="{{ old('weight', $lastCharacteristic->weight ?? '') }}">
                                @error('weight')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Complexión y Color de Piel -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="suggested-field">Complexión:</label>
                                <select class="form-control w-full @error('confleccion_id') border-red-500 @enderror"
                                    name="confleccion_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($conflexion as $confleccion)
                                        <option value="{{ $confleccion->id }}"
                                            {{ old('confleccion_id', $lastCharacteristic->confleccion_id ?? '') == $confleccion->id ? 'selected' : '' }}>
                                            {{ $confleccion->conflexion_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('confleccion_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="suggested-field">Color de piel:</label>
                                <select class="form-control w-full @error('skin_color_id') border-red-500 @enderror"
                                    name="skin_color_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($color as $skin_color)
                                        <option value="{{ $skin_color->id }}"
                                            {{ old('skin_color_id', $lastCharacteristic->skin_color_id ?? '') == $skin_color->id ? 'selected' : '' }}>
                                            {{ $skin_color->skin_color_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skin_color_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Sexo y Género -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="suggested-field">Sexo:</label>
                                <select class="form-control w-full @error('sex') border-red-500 @enderror" name="sex">
                                    <option value="">Seleccionar</option>
                                    <option value="MASCULINO"
                                        {{ old('sex', $lastCharacteristic->sex ?? '') == 'MASCULINO' ? 'selected' : '' }}>
                                        MASCULINO</option>
                                    <option value="FEMENINO"
                                        {{ old('sex', $lastCharacteristic->sex ?? '') == 'FEMENINO' ? 'selected' : '' }}>
                                        FEMENINO</option>
                                </select>
                                @error('sex')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="suggested-field">Género:</label>
                                <select class="form-control w-full @error('criminal_gender_id') border-red-500 @enderror"
                                    name="criminal_gender_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($genero as $criminal_gender)
                                        <option value="{{ $criminal_gender->id }}"
                                            {{ old('criminal_gender_id', $lastCharacteristic->criminal_gender_id ?? '') == $criminal_gender->id ? 'selected' : '' }}>
                                            {{ $criminal_gender->gender_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('criminal_gender_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Características Faciales -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="suggested-field">Tipo de Ojos:</label>
                                <select class="form-control w-full @error('eye_type_id') border-red-500 @enderror"
                                    name="eye_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ojos as $eye_type)
                                        <option value="{{ $eye_type->id }}"
                                            {{ old('eye_type_id', $lastCharacteristic->eye_type_id ?? '') == $eye_type->id ? 'selected' : '' }}>
                                            {{ $eye_type->eye_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('eye_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="suggested-field">Tipo de Nariz:</label>
                                <select class="form-control w-full @error('nose_type_id') border-red-500 @enderror"
                                    name="nose_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($naris as $nose_type)
                                        <option value="{{ $nose_type->id }}"
                                            {{ old('nose_type_id', $lastCharacteristic->nose_type_id ?? '') == $nose_type->id ? 'selected' : '' }}>
                                            {{ $nose_type->nose_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nose_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="suggested-field">Tipo de Labios:</label>
                                <select class="form-control w-full @error('lip_type_id') border-red-500 @enderror"
                                    name="lip_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($labios as $lip_type)
                                        <option value="{{ $lip_type->id }}"
                                            {{ old('lip_type_id', $lastCharacteristic->lip_type_id ?? '') == $lip_type->id ? 'selected' : '' }}>
                                            {{ $lip_type->lip_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lip_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="suggested-field">Tipo de Orejas:</label>
                                <select class="form-control w-full @error('ear_type_id') border-red-500 @enderror"
                                    name="ear_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($orejas as $ear_type)
                                        <option value="{{ $ear_type->id }}"
                                            {{ old('ear_type_id', $lastCharacteristic->ear_type_id ?? '') == $ear_type->id ? 'selected' : '' }}>
                                            {{ $ear_type->ear_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ear_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Características Particulares -->
                        <div class="form-group">
                            <label class="suggested-field">Características Particulares:</label>
                            <textarea class="form-control w-full @error('distinctive_marks') border-red-500 @enderror" name="distinctive_marks"
                                rows="3" placeholder="Describa marcas distintivas, tatuajes, cicatrices, etc.">{{ old('distinctive_marks', $lastCharacteristic->distinctive_marks ?? '') }}</textarea>
                            @error('distinctive_marks')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- SECCIÓN DERECHA: FOTOGRAFÍAS -->
                    <div>
                        <div class="section-title">FOTOGRAFÍAS</div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <!-- Rostro -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 suggested-field">Rostro:</label>
                                <input type="file" class="hidden @error('face_photo') border-red-500 @enderror"
                                    name="face_photo" id="facePhotoInput" onchange="previewImage(this, 'previewFace')"
                                    accept="image/*">
                                <img id="previewFace"
                                    src="{{ asset($criminal->photographs->last()->face_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa rostro" class="preview-image"
                                    onclick="showCameraOptions('facePhotoInput')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('facePhotoInput', 'user')" title="Usar cámara frontal">
                                        📱 Frontal
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('facePhotoInput')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('face_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Medio Cuerpo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 suggested-field">Medio Cuerpo:</label>
                                <input type="file" class="hidden @error('frontal_photo') border-red-500 @enderror"
                                    name="frontal_photo" id="frontal_photo"
                                    onchange="previewImage(this, 'previewFrontal')" accept="image/*">
                                <img id="previewFrontal"
                                    src="{{ asset($criminal->photographs->last()->frontal_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa medio cuerpo" class="preview-image"
                                    onclick="showCameraOptions('frontal_photo')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('frontal_photo', 'environment')" title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('frontal_photo')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('frontal_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Perfil Izquierdo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 suggested-field">Perfil Izquierdo:</label>
                                <input type="file" class="hidden @error('profile_izq_photo') border-red-500 @enderror"
                                    name="profile_izq_photo" id="profile_izq" onchange="previewImage(this, 'previewIzq')"
                                    accept="image/*">
                                <img id="previewIzq"
                                    src="{{ asset($criminal->photographs->last()->profile_izq_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa perfil izquierdo" class="preview-image"
                                    onclick="showCameraOptions('profile_izq')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('profile_izq', 'environment')" title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('profile_izq')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('profile_izq_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Perfil Derecho -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 suggested-field">Perfil Derecho:</label>
                                <input type="file" class="hidden @error('profile_der_photo') border-red-500 @enderror"
                                    name="profile_der_photo" id="profile_der_photo"
                                    onchange="previewImage(this, 'previewDer')" accept="image/*">
                                <img id="previewDer"
                                    src="{{ asset($criminal->photographs->last()->profile_der_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa perfil derecho" class="preview-image"
                                    onclick="showCameraOptions('profile_der_photo')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('profile_der_photo', 'environment')"
                                        title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('profile_der_photo')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('profile_der_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Cuerpo Completo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 suggested-field">Cuerpo Completo:</label>
                                <input type="file" class="hidden @error('full_body_photo') border-red-500 @enderror"
                                    name="full_body_photo" id="full_body_photo"
                                    onchange="previewImage(this, 'previewFullBody')" accept="image/*">
                                <img id="previewFullBody"
                                    src="{{ asset($criminal->photographs->last()->full_body_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa cuerpo completo" class="preview-image"
                                    onclick="showCameraOptions('full_body_photo')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('full_body_photo', 'environment')"
                                        title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('full_body_photo')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('full_body_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Foto Adicional -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2">Foto Adicional:</label>
                                <input type="file" class="hidden @error('aditional_photo') border-red-500 @enderror"
                                    name="aditional_photo" id="aditional_photo"
                                    onchange="previewImage(this, 'previewaditional')" accept="image/*">
                                <img id="previewaditional"
                                    src="{{ asset($criminal->photographs->last()->aditional_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa foto adicional" class="preview-image"
                                    onclick="showCameraOptions('aditional_photo')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('aditional_photo', 'environment')"
                                        title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('aditional_photo')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('aditional_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto en Barra (Ancho completo) -->
                        <div class="form-group mt-6">
                            <label class="text-sm font-medium mb-2 block">Foto en Barra:</label>
                            <div class="image-upload-container barra-photo-container">
                                <input type="file" class="hidden @error('barra_photo') border-red-500 @enderror"
                                    name="barra_photo" id="barra_photo" onchange="previewImage(this, 'previewBarra')"
                                    accept="image/*">
                                <img id="previewBarra"
                                    src="{{ asset($criminal->photographs->last()->barra_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa foto barra" class="preview-image"
                                    style="width: 200px; height: 100px;" onclick="showCameraOptions('barra_photo')">

                                <div class="camera-options">
                                    <button type="button" class="camera-btn primary"
                                        onclick="openCamera('barra_photo', 'environment')" title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="openFileSelector('barra_photo')" title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>

                                @error('barra_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                 <!-- Botones de Acción -->
                <div class="flex justify-center space-x-4 mt-8 pt-6 border-t border-gray-600">
                    <button
                        class="btn-guardar"
                        type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span>GUARDAR</span>
                    </button>

                    <button
                        class="btn-cancelar"
                        type="button"
                        onclick="if(confirm('¿Está seguro de cancelar? Se perderán todos los datos ingresados.')) { history.back(); }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>CANCELAR</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript adicional para compatibilidad -->
    <script>
        // Función de previsualización de imagen (backup por si no está en criminal-form.js)
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Funciones placeholder para las funciones de cámara (si no están definidas)
        if (typeof showCameraOptions === 'undefined') {
            function showCameraOptions(inputId) {
                document.getElementById(inputId).click();
            }
        }

        if (typeof openCamera === 'undefined') {
            function openCamera(inputId, facingMode) {
                document.getElementById(inputId).click();
            }
        }

        if (typeof openFileSelector === 'undefined') {
            function openFileSelector(inputId) {
                document.getElementById(inputId).click();
            }
        }

        // Debug del formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.form-criminal');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Formulario enviándose...');
                    // Permitir que el formulario se envíe normalmente
                });
            }
        });
    </script>

    <style>
        /* Estilos para campos sugeridos con asterisco rojo */
        /* Estilos para botones de acción */
        .btn-guardar {
            background-color: #059669 !important;
            color: #ffffff !important;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            transition: background-color 0.2s ease;
        }

        .btn-guardar:hover {
            background-color: #047857 !important;
        }

        .btn-cancelar {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            transition: background-color 0.2s ease;
        }

        .btn-cancelar:hover {
            background-color: #b91c1c !important;
        }
        .suggested-field::after {
            content: " *";
            color: #ef4444;
            font-weight: bold;
        }

        /* Texto blanco para todas las labels */
        .suggested-field, label {
            font-weight: 500;
            color: #ffffff !important;
        }

        /* Texto blanco para secciones */
        .section-title {
            color: #ffffff !important;
            font-weight: bold;
        }

        /* Estilos adicionales para compatibilidad */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #333 inset !important;
            -webkit-text-fill-color: #fff !important;
            border: 1px solid #555;
        }

        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #444 inset !important;
            -webkit-text-fill-color: #fff !important;
        }
    </style>

@endsection
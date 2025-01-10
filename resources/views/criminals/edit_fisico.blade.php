@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content_header')
    <h1 class="text-center">
        EDITAR CARACTERISTICAS FÍSICAS</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('criminals.update', $criminal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                    <div>
                        <label>RASGOS FÍSICOS</label>
                        @php
                            $lastCharacteristic = $criminal->physicalCharacteristics->last();
                        @endphp
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estatura (mts):</label>
                                    <input type="number" class="form-control @error('height') is-invalid @enderror"
                                        name="height" placeholder="Talla" min="120" max="210"
                                        value="{{ old('height', $lastCharacteristic->height ?? '') }}">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Peso (kg):</label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        name="weight" placeholder="Peso" min="35" max="120"
                                        value="{{ old('weight', $lastCharacteristic->weight ?? '') }}">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Complexión:</label>
                                    <select class="form-control @error('confleccion_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Color de piel:</label>
                                    <select class="form-control @error('skin_color_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sexo:</label>
                                    <select class="form-control @error('sex') is-invalid @enderror" name="sex">
                                        <option value="">Seleccionar</option>
                                        <option value="MASCULINO"
                                            {{ old('sex', $lastCharacteristic->sex ?? '') == 'MASCULINO' ? 'selected' : '' }}>
                                            MASCULINO</option>
                                        <option value="FEMENINO"
                                            {{ old('sex', $lastCharacteristic->sex ?? '') == 'FEMENINO' ? 'selected' : '' }}>
                                            FEMENINO</option>
                                    </select>
                                    @error('sex')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Género:</label>
                                    <select class="form-control @error('criminal_gender_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipos de Ojos:</label>
                                    <select class="form-control @error('eye_type_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Naríz:</label>
                                    <select class="form-control @error('nose_type_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de labios:</label>
                                    <select class="form-control @error('lip_type_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de orejas:</label>
                                    <select class="form-control @error('ear_type_id') is-invalid @enderror"
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
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="distinctive_marks">Características Particulares:</label>
                            <input type="text" class="form-control @error('distinctive_marks') is-invalid @enderror"
                                name="distinctive_marks" placeholder="Descripción"
                                value="{{ old('distinctive_marks', $lastCharacteristic->distinctive_marks ?? '') }}">
                            @error('distinctive_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div>
                        <div><label>FOTOGRAFÍAS:</label></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <!-- Foto de rostro -->
                                <label>Rostro:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="face_photo"
                                        id="facePhotoInput" onchange="previewImage(this, 'previewFace')"
                                        style="display: none;">
                                    <label class="custom-file-label" for="facePhotoInput">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewFace"
                                        src="{{ asset($criminal->photographs->last()->face_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa"
                                        style="width: 100%; max-width: 100px; margin-top: 10px; cursor: pointer;"
                                        onclick="document.getElementById('facePhotoInput').click();">
                                </div>

                                <!-- Foto de perfil izquierdo -->
                                <label>Perfil Izquierdo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="profile_izq_photo"
                                        id="profile_izq" onchange="previewImage(this, 'previewIzq')">
                                    <label class="custom-file-label" for="profile_izq">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewIzq"
                                        src="{{ asset($criminal->photographs->last()->profile_izq_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('profile_izq').click();">
                                </div>

                                <!-- Foto de cuerpo completo -->
                                <label>Cuerpo Completo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="full_body_photo"
                                        id="full_body_photo" onchange="previewImage(this, 'previewFullBody')">
                                    <label class="custom-file-label" for="full_body_photo">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewFullBody"
                                        src="{{ asset($criminal->photographs->last()->full_body_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('full_body_photo').click();">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Foto de medio cuerpo -->
                                <label>Medio Cuerpo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="frontal_photo"
                                        id="frontal_photo" onchange="previewImage(this, 'previewFrontal')">
                                    <label class="custom-file-label" for="frontal_photo">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewFrontal"
                                        src="{{ asset($criminal->photographs->last()->frontal_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('frontal_photo').click();">
                                </div>

                                <!-- Foto de perfil derecho -->
                                <label>Perfil Derecho:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="profile_der_photo"
                                        id="profile_der_photo" onchange="previewImage(this, 'previewDer')">
                                    <label class="custom-file-label" for="profile_der_photo">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewDer"
                                        src="{{ asset($criminal->photographs->last()->profile_der_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('profile_der_photo').click();">
                                </div>

                                <!-- Foto adicional -->
                                <label>Foto Adicional:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="aditional_photo"
                                        id="aditional_photo" onchange="previewImage(this, 'previewaditional')">
                                    <label class="custom-file-label" for="aditional_photo">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewaditional"
                                        src="{{ asset($criminal->photographs->last()->aditional_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('aditional_photo').click();">
                                </div>
                            </div>
                        </div>

                        <!-- Foto en barra -->
                        <label>Foto en Barra:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="barra_photo" id="barra_photo"
                                onchange="previewImage(this, 'previewBarra')">
                            <label class="custom-file-label" for="barra_photo">Seleccionar...</label>
                        </div>
                        <div class="center-image-container">
                            <img id="previewBarra"
                                src="{{ asset($criminal->photographs->last()->barra_photo ?? 'vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                alt="Vista previa" style="width: 100%; max-width: 100px; margin-top: 10px;"
                                onclick="document.getElementById('barra_photo').click();">
                        </div>

                        <script>
                            function previewImage(input, previewId) {
                                let file = input.files[0];
                                let label = input.nextElementSibling;

                                // Actualizar el nombre del archivo en el label
                                label.innerText = file ? file.name : "Seleccionar...";

                                // Mostrar vista previa si es una imagen
                                if (file && file.type.startsWith("image/")) {
                                    let reader = new FileReader();
                                    reader.onload = function(e) {
                                        let preview = document.getElementById(previewId);
                                        preview.src = e.target.result;
                                    }
                                    reader.readAsDataURL(file);
                                } else {
                                    // Restablecer a la imagen predeterminada si el archivo no es válido
                                    let preview = document.getElementById(previewId);
                                    preview.src = "{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}";
                                }
                            }
                        </script>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <!-- Botón Guardar con color verde -->
                    <button type="submit" class="btn btn-success mx-2">Guardar Cambios</button>
                
                    <!-- Botón Cancelar con color rojo y redirección -->
                    <button class="btn btn-danger mx-2" type="button" onclick="window.history.back()">Cancelar</button>
                </div>
                
            </form>
        </div>
    </div>


    <script>
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
    </script>

    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #333 inset !important;
            /* Color de fondo oscuro */
            -webkit-text-fill-color: #fff !important;
            /* Color del texto */
            border: 1px solid #555;
            /* Asegurar que se mantenga un borde consistente */
        }

        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #444 inset !important;
            /* Color de fondo al hover o focus */
            -webkit-text-fill-color: #fff !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 25px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
            /* Color verde */
        }

        input:not(:checked)+.slider {
            background-color: #dc3545;
            /* Color rojo */
        }

        input:checked+.slider:before {
            transform: translateX(25px);
        }
    </style>

@endsection

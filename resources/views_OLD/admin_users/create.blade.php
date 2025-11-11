@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content_header')
    <h1 class="text-center">
        CREAR NUEVO USUARIO</h1>
@stop
@section('content')
    @if ($errors->has('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ $errors->first('error') }}
        </div>
    @endif

    <script>
        // Esperar 4 segundos y luego ocultar la alerta
        setTimeout(() => {
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                errorAlert.style.transition = "opacity 0.5s ease";
                errorAlert.style.opacity = 0;
                setTimeout(() => errorAlert.remove(), 500); // Eliminar después de que la transición termine
            }
        }, 4000);
    </script>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
                @csrf

                <div class="row mb-2 justify-content-center">
                    <!-- Foto del usuario centrada -->
                    <div class="col-12 text-center mb-3">
                        <label for="profile_photo" style="cursor: pointer;">
                            <img src="{{ asset('storage/incognito.jpg') }}" width="150" alt="Foto de Perfil"
                                class="rounded-circle border border-secondary mb-2" id="profilePhotoPreview">
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*"
                            onchange="previewProfilePhoto(event)">
                    </div>
                    

                    <!-- Información del usuario -->
                    <div class="col-10">
                        <!-- Grado -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="grade" class="form-label">Grado:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="grade" name="grade"
                                    class="form-control @error('grade') is-invalid @enderror" placeholder="Ingrese el grado"
                                    value="{{ old('grade') }}">
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nombre Completo -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="fullName" class="form-label">Nombre Completo:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="fullName" name="name"
                                    class="form-control @error('name') is-invalid @enderror" required
                                    placeholder="Ingrese el nombre completo" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- CI Policía -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="ciPolice" class="form-label">CI Policía:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="ciPolice" name="ci_police"
                                    class="form-control @error('ci_police') is-invalid @enderror" required
                                    placeholder="XXXXXXX-EXT" value="{{ old('ci_police') }}" oninput="generatePassword()">
                                @error('ci_police')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="email" class="form-label">Email:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" required
                                    placeholder="Ingrese el correo electrónico" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="phone" class="form-label">Teléfono:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Ingrese el número de teléfono" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Escalafón -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="escalafon" class="form-label">Escalafón:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="escalafon" name="escalafon"
                                    class="form-control @error('escalafon') is-invalid @enderror"
                                    placeholder="Ingrese el escalafón" value="{{ old('escalafon') }}">
                                @error('escalafon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="row mb-2">
                            <div class="col-md-4 col-12">
                                <label for="password" class="form-label">Contraseña:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="password" name="password" class="form-control" readonly
                                    placeholder="La contraseña se generará automáticamente">
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="row mb-3">
                            <div class="col-md-4 col-12">
                                <label for="roles" class="form-label">Roles:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($roles as $role)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Estado con interruptor -->
                        <div class="row mb-3">
                            <div class="col-md-4 col-12">
                                <label for="estado" class="form-label">Estado:</label>
                            </div>
                            <div class="col-md-8 col-12 d-flex align-items-center">
                                <input type="hidden" name="estado" value="0">
                                <label class="switch">
                                    <input type="checkbox" id="estado" name="estado" value="1"
                                        {{ old('estado', 1) ? 'checked' : '' }}>
                                    <span class="slider rounded-pill bg-success"></span>
                                </label>
                                <span class="ms-3" id="estado-label">Activo</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-success">Crear Usuario</button>
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

        function generatePassword() {
            const ci = document.getElementById('ciPolice').value;
            const passwordField = document.getElementById('password');
            // Extraer solo la parte numérica de ciPolice
            const numericCi = ci.replace(/\D/g, '');
            passwordField.value = numericCi ? `${numericCi}daci` : '';
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
        }

        input:not(:checked)+.slider {
            background-color: #dc3545;
        }

        input:checked+.slider:before {
            transform: translateX(25px);
        }
    </style>
@endsection

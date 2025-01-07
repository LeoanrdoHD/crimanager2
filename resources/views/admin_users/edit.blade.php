@extends('adminlte::page')
@section('content_header')
    <h1 class="text-center">
        EDITAR INFORMACIÓN DEL USUARIO</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-2 justify-content-center">
                    <!-- Foto del usuario centrada -->
                    <div class="col-12 text-center mb-3">
                        <label for="profile_photo" style="cursor: pointer;">
                            <img src="{{ asset($user->profile_photo_url) }}" width="150" alt="Foto de Perfil"
                                class="rounded-circle border border-secondary mb-2" id="profilePhotoPreview">
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*"
                            onchange="previewProfilePhoto(event)">
                    </div>

                    <!-- Información del usuario -->
                    <div class="col-10">
                        <div class="row mb-2">
                            <!-- Grado -->
                            <div class="col-md-4 col-12">
                                <label for="grade" class="form-label">Grado:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="grade" name="grade" class="form-control"
                                    value="{{ ucwords(strtolower($user->grade)) }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Nombre Completo (solo lectura) -->
                            <div class="col-md-4 col-12">
                                <label for="fullName" class="form-label">Nombre Completo:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="fullName" class="form-control"
                                    value="{{ ucwords(strtolower($user->name)) }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- CI Policía -->
                            <div class="col-md-4 col-12">
                                <label for="ciPolice" class="form-label">CI Policía:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="ciPolice" name="ci_police" class="form-control"
                                    value="{{ $user->ci_police }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Email (solo lectura) -->
                            <div class="col-md-4 col-12">
                                <label for="email" class="form-label">Email:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="email" id="email" class="form-control" value="{{ $user->email }}"
                                    readonly>
                            </div>
                        </div>
<!-- Contraseña -->
<div class="row mb-2">
    <div class="col-md-4 col-12">
        <label for="password" class="form-label">Contraseña:</label>
    </div>
    <div class="col-md-8 col-12 d-flex align-items-center">
        <input type="text" id="password" name="password" class="form-control me-2" readonly
            placeholder="***********">
        <button type="button" class="btn btn-warning btn-sm" onclick="confirmPasswordReset()">Reestablecer Contraseña</button>
    </div>
</div>

<input type="hidden" name="reestablecer_password" id="reestablecer_password" value="false">

<script>
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
        // Cambiar el valor del campo oculto a true
        document.getElementById('reestablecer_password').value = 'true';
    }
</script>

                        <div class="row mb-2">
                            <!-- Teléfono -->
                            <div class="col-md-4 col-12">
                                <label for="phone" class="form-label">Teléfono:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ $user->phone }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Escalafón -->
                            <div class="col-md-4 col-12">
                                <label for="escalafon" class="form-label">Escalafón:</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" id="escalafon" name="escalafon" class="form-control"
                                    value="{{ $user->escalafon }}">
                            </div>
                        </div>
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
                                                {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
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
                                <label class="switch">
                                    <input type="checkbox" id="estado" name="estado" value="1"
                                        {{ $user->estado ? 'checked' : '' }} onclick="toggleSwitch(this)">
                                    <span
                                        class="slider rounded-pill {{ $user->estado ? 'bg-success' : 'bg-danger' }}"></span>
                                </label>
                                <span class="ms-3" id="estado-label">{{ $user->estado ? 'Activo' : 'Inactivo' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
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

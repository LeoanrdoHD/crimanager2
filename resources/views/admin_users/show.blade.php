@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content_header')
    <h1 class="text-center">
        DETALLES DEL USUARIO</h1>
@stop
@section('content')
@if(session('info'))
    <div class="alert alert-success" id="sessionMessage">
        {{ session('info') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('sessionMessage').style.display = 'none';
        }, 3000); // 5000 milisegundos = 5 segundos
    </script>
@endif

<div class="card">
    <div class="card-body">
        <div class="row mb-2 justify-content-center">
            <!-- Foto del usuario centrada -->
            <div class="col-12 text-center mb-3">
                <label for="profile_photo" style="cursor: pointer;">
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" width="150" alt="Foto de Perfil"
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
                        <input type="text" id="grade" class="form-control"
                            value="{{ ucwords(strtolower($user->grade)) }}" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <!-- Nombre Completo -->
                    <div class="col-md-4 col-12">
                        <label for="fullName" class="form-label">Nombre Completo:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" id="fullName" class="form-control"
                            value="{{ ucwords(strtolower($user->name)) }}" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="ciPolice" class="form-label">CI Policía:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" id="ciPolice" class="form-control" value="{{ $user->ci_police }}"
                            readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="email" class="form-label">Email:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="phone" class="form-label">Teléfono:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" id="phone" class="form-control" value="{{ $user->phone }}" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="escalafon" class="form-label">Escalafón:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" id="escalafon" class="form-control" value="{{ $user->escalafon }}"
                            readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="rol" class="form-label">Rol:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <input type="text" id="rol" class="form-control" value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
                    </div>
                    
                </div>
                <!-- Estado con interruptor -->
                <div class="row mb-2">
                    <div class="col-md-4 col-12">
                        <label for="estado" class="form-label">Estado:</label>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="switch">
                            <!-- Checkbox oculto -->
                            <input type="checkbox" id="estado" {{ $user->estado ? 'checked' : '' }} disabled>
                            <!-- Slider personalizado -->
                            <span class="slider {{ $user->estado ? 'active' : '' }}"></span>
                        </div>
                        <span class="ms-2">{{ $user->estado ? 'Activo' : 'Inactivo' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-center">
        <!-- Botón Editar -->
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>


    <style>
        /* Contenedor del switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        /* Estilo del checkbox oculto */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Slider del switch */
        .slider {
            position: absolute;
            cursor: not-allowed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ff4d4d;
            /* Rojo para inactivo */
            transition: 0.4s;
            border-radius: 25px;
        }

        /* Slider verde cuando está activo */
        .slider.active {
            background-color: #4CAF50;
            /* Verde para activo */
        }

        /* Punto interior del slider */
        .slider::before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 3.5px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        /* Mover el punto interior cuando está activo */
        input:checked+.slider::before {
            transform: translateX(24px);
        }
    </style>


@endsection

@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-user.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/edit-user.js') }}"></script>
@endsection

@section('content_header')
    <h1 class="text-center">
        CREAR NUEVO USUARIO</h1>
@stop

@section('content')
<div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
    @if ($errors->has('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="createUserForm">
                @csrf

                <div class="row mb-2 justify-content-center">
                    <!-- Foto del usuario centrada -->
                    <div class="col-10 text-center mb-3">
                        <div class="image-upload-container">
                            <label for="profile_photo" style="cursor: pointer;">
                                <img src="{{ asset('storage/incognito.jpg') }}" width="150" alt="Foto de Perfil"
                                    class="rounded-circle border border-secondary mb-2 preview-image" id="profilePhotoPreview">
                            </label>
                            <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*"
                                onchange="previewProfilePhoto(event)">
                            <div class="camera-options">
                                <button type="button" class="camera-btn primary" onclick="document.getElementById('profile_photo').click()">
                                    📷 Seleccionar
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información del usuario -->
                    <div class="col-10">
                        <!-- Información Personal -->
                        <div class="section-title">Información Personal</div>
                        
                        <!-- Grado -->
                        <div class="form-group">
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
                        </div>

                        <!-- Nombre Completo -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="fullName" class="form-label required-field">Nombre Completo:</label>
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
                        </div>

                        <!-- CI Policía -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="ciPolice" class="form-label required-field">CI Policía:</label>
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
                        </div>

                        <!-- Información de Contacto -->
                        <div class="section-title">Información de Contacto</div>

                        <!-- Email -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="email" class="form-label required-field">Email:</label>
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
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
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
                        </div>

                        <!-- Información Profesional -->
                        <div class="section-title">Información Profesional</div>

                        <!-- Escalafón -->
                        <div class="form-group">
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
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="password" class="form-label">Contraseña:</label>
                                </div>
                                <div class="col-md-8 col-12">
                                    <input type="text" id="password" name="password" class="form-control" readonly
                                        placeholder="La contraseña se generará automáticamente">
                                </div>
                            </div>
                        </div>

                        <!-- Configuración del Sistema -->
                        <div class="section-title">Configuración del Sistema</div>

                        <!-- Roles -->
                        <div class="form-group">
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
                        </div>

                        <!-- Estado con interruptor -->
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-md-4 col-12">
                                    <label for="estado" class="form-label">Estado:</label>
                                </div>
                                <div class="col-md-8 col-12 d-flex align-items-center">
                                    <input type="hidden" name="estado" value="0">
                                    <label class="switch">
                                        <input type="checkbox" id="estado" name="estado" value="1"
                                            {{ old('estado', 1) ? 'checked' : '' }} onchange="toggleSwitch(this)">
                                        <span class="slider rounded-pill bg-success"></span>
                                    </label>
                                    <span class="ms-3" id="estado-label">Activo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <!-- Botones de acción -->
                    <div class="action-buttons-container">
                        <button type="button" class="camera-btn danger" onclick="window.history.back()">
                            ❌ Cancelar
                        </button>
                        <button type="submit" class="camera-btn primary">
                            ✅ Crear Usuario
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
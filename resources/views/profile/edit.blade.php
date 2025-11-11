@extends('adminlte::page')

@section('title', 'Editar Perfil')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-user.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/profile-edit.js') }}"></script>
@endsection

@section('content_header')
    <h1 class="text-center">
        EDITAR PERFIL DE USUARIO
    </h1>
@stop

@section('content')
    <!-- Mensajes de éxito/error -->
    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" id="error-alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif
<div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ request()->is('user/profile/edit') ? route('user.profile.update') : route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <div class="row mb-2 justify-content-center">
                    <!-- Foto del usuario centrada -->
                    <div class="col-10 text-center mb-3">
                        <div class="image-upload-container">
                            <label for="photo" style="cursor: pointer;">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->name }}"
                                        width="150"
                                        class="rounded-circle border border-secondary mb-2 preview-image"
                                        id="profilePhotoPreview">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white font-weight-bold border border-secondary mb-2 mx-auto preview-image"
                                        style="width: 150px; height: 150px; font-size: 48px;"
                                        id="profilePhotoPreview">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </label>
                            <input type="file" id="photo" name="photo" class="d-none" accept="image/*"
                                onchange="previewProfilePhoto(event)">
                            <div class="camera-options">
                                <button type="button" class="camera-btn primary" onclick="document.getElementById('photo').click()">
                                    📷 Cambiar Foto
                                </button>
                                @if (Auth::user()->profile_photo_path)
                                    <button type="button" class="camera-btn danger" onclick="removePhoto()">
                                        🗑️ Remover
                                    </button>
                                @endif
                            </div>
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información del usuario -->
                    <div class="col-10">
                        <!-- Información Personal -->
                        <div class="section-title">Información Personal</div>

                        <!-- Nombre Completo (solo lectura) -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="name" class="form-label">Nombre Completo: <small class="text-muted">(No editable)</small></label>
                                </div>
                                <div class="col-md-8 col-12 readonly-field">
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', Auth::user()->name) }}" readonly>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- CI Policía (solo lectura) -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="ci_police" class="form-label">CI Policía: <small class="text-muted">(No editable)</small></label>
                                </div>
                                <div class="col-md-8 col-12 readonly-field">
                                    <input type="text" id="ci_police" name="ci_police" class="form-control"
                                        value="{{ old('ci_police', Auth::user()->ci_police) }}" readonly>
                                    @error('ci_police')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="section-title">Información de Contacto</div>

                        <!-- Email (solo lectura) -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="email" class="form-label">Email: <small class="text-muted">(No editable)</small></label>
                                </div>
                                <div class="col-md-8 col-12 readonly-field">
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email) }}" readonly>
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
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone', Auth::user()->phone) }}" autocomplete="tel">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información Profesional -->
                        <div class="section-title">Información Profesional</div>

                        <!-- Grado -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="grade" class="form-label">Grado:</label>
                                </div>
                                <div class="col-md-8 col-12">
                                    <input type="text" id="grade" name="grade" class="form-control"
                                        value="{{ old('grade', Auth::user()->grade) }}" autocomplete="grade">
                                    @error('grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Escalafón -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="escalafon" class="form-label">Escalafón:</label>
                                </div>
                                <div class="col-md-8 col-12">
                                    <input type="text" id="escalafon" name="escalafon" class="form-control"
                                        value="{{ old('escalafon', Auth::user()->escalafon) }}" autocomplete="escalafon">
                                    @error('escalafon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <!-- Botones de acción -->
                    <div class="action-buttons-container">
                        <a href="{{ request()->is('user/profile/edit') ? route('user.profile.show') : route('profile.show') }}" class="camera-btn danger">
                            ❌ Cancelar
                        </a>
                        <button type="submit" class="camera-btn primary" id="saveBtn">
                            💾 Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Cambiar Contraseña -->
    <div class="card mt-4">
        <div class="card-body">
            

            <form action="{{ request()->is('user/profile/edit') ? route('user.password.update') : route('password.update') }}" method="POST" id="passwordForm">
                @csrf
                @method('PUT')

                <div class="row mb-2 justify-content-center">
                    <div class="col-10">
                        <div class="section-title">Cambiar Contraseña</div>
            <p class="text-muted mb-4">
                {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerte seguro.') }}
            </p>
                        <!-- Contraseña Actual -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="current_password" class="form-label">Contraseña Actual:</label>
                                </div>
                                <div class="col-md-8 col-12 d-flex align-items-center">
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-control me-2" autocomplete="current-password" required>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="togglePassword('current_password')">
                                        👁️ Ver
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nueva Contraseña -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="password" class="form-label">Nueva Contraseña:</label>
                                </div>
                                <div class="col-md-8 col-12 d-flex align-items-center">
                                    <input type="password" id="password" name="password"
                                        class="form-control me-2" autocomplete="new-password" required>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="togglePassword('password')">
                                        👁️ Ver
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-group">
                            <div class="row mb-2">
                                <div class="col-md-4 col-12">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña:</label>
                                </div>
                                <div class="col-md-8 col-12 d-flex align-items-center">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control me-2" autocomplete="new-password" required>
                                    <button type="button" class="camera-btn secondary"
                                        onclick="togglePassword('password_confirmation')">
                                        👁️ Ver
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="action-buttons-container">
                        <button type="submit" class="camera-btn primary">
                            🔑 Actualizar Contraseña
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@stop
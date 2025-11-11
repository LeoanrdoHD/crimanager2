@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-user.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/edit-user.js') }}"></script>
@endsection

@section('content_header')
    <h1 class="text-center">
        DETALLES DEL USUARIO</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success" id="sessionMessage">
            {{ session('info') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 justify-content-center">
                        <!-- Foto del usuario centrada -->
                        <div class="col-10 text-center mb-3">
                            <div class="image-upload-container view-only">
                                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('storage/incognito.jpg') }}"
                                    width="150" alt="Foto de Perfil"
                                    class="rounded-circle border border-secondary mb-2 preview-image view-only"
                                    id="profilePhotoPreview">
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
                                        <input type="text" id="grade" class="form-control"
                                            value="{{ ucwords(strtolower($user->grade)) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Nombre Completo -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="fullName" class="form-label">Nombre Completo:</label>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="fullName" class="form-control"
                                            value="{{ ucwords(strtolower($user->name)) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- CI Policía -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="ciPolice" class="form-label">CI Policía:</label>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="ciPolice" class="form-control"
                                            value="{{ $user->ci_police }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="section-title">Información de Contacto</div>

                            <!-- Email -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="email" class="form-label">Email:</label>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <input type="email" id="email" class="form-control"
                                            value="{{ $user->email }}" readonly>
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
                                        <input type="text" id="phone" class="form-control"
                                            value="{{ $user->phone }}" readonly>
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
                                        <input type="text" id="escalafon" class="form-control"
                                            value="{{ $user->escalafon }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Configuración del Sistema -->
                            <div class="section-title">Configuración del Sistema</div>

                            <!-- Roles -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="rol" class="form-label">Roles:</label>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <input type="text" id="rol" class="form-control"
                                            value="{{ $user->roles->pluck('name')->join(', ') }}" readonly>
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
                                        <label class="switch">
                                            <input type="checkbox" id="estado" {{ $user->estado ? 'checked' : '' }}
                                                disabled>
                                            <span
                                                class="slider rounded-pill {{ $user->estado ? 'bg-success' : 'bg-danger' }}"></span>
                                        </label>
                                        <span class="ms-3">{{ $user->estado ? 'Activo' : 'Inactivo' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <!-- Botón Editar -->
                    <div class="action-buttons-container">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="camera-btn primary view-only">
                            ✏️ Editar Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

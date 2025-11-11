@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit-user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-show.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/profile-show.js') }}"></script>
@endsection

@section('content_header')
    <h1 class="text-center">
        PERFIL DE USUARIO
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
            <!-- Información del Perfil -->
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 justify-content-center">
                        <!-- Foto del usuario centrada -->
                        <div class="col-10 text-center mb-3">
                            <div class="image-upload-container view-only">
                                @if (Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->name }}" width="150"
                                        class="rounded-circle border border-secondary mb-2 preview-image view-only">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white font-weight-bold border border-secondary mb-2 mx-auto preview-image view-only"
                                        style="width: 150px; height: 150px; font-size: 48px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Información del usuario -->
                        <div class="col-10">
                            <!-- Información Personal -->
                            <div class="section-title">Información Personal</div>

                            <!-- Nombre Completo -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="name" class="form-label">Nombre Completo:</label>
                                    </div>
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="text" id="name" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- CI Policía -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="ci_police" class="form-label">CI Policía:</label>
                                    </div>
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="text" id="ci_police" class="form-control"
                                            value="{{ Auth::user()->ci_police }}" readonly>
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
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="email" id="email" class="form-control"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="phone" class="form-label">Teléfono:</label>
                                    </div>
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="text" id="phone" class="form-control"
                                            value="{{ Auth::user()->phone ?? 'No especificado' }}" readonly>
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
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="text" id="grade" class="form-control"
                                            value="{{ Auth::user()->grade ?? 'No especificado' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Escalafón -->
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4 col-12">
                                        <label for="escalafon" class="form-label">Escalafón:</label>
                                    </div>
                                    <div class="col-md-8 col-12 readonly-field">
                                        <input type="text" id="escalafon" class="form-control"
                                            value="{{ Auth::user()->escalafon ?? 'No especificado' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="action-buttons-container">
                            <a href="{{ request()->is('user/profile') ? route('user.profile.edit') : route('profile.edit') }}"
                                class="camera-btn primary view-only">
                                ✏️ Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas del Usuario -->
            @if (isset($statistics))
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row mb-2 justify-content-center">
                            <div class="col-10">
                                <div class="section-title">Estadísticas de Uso</div>

                                <div class="row statistics-grid justify-content-center">
                                    <!-- Total de Ingresos -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                                        <div class="stat-card primary">
                                            <div class="stat-icon">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h4>{{ $statistics['total_sessions'] ?? 0 }}</h4>
                                                <span>Total Ingresos</span>
                                                <small>Histórico completo</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ingresos Esta Semana -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                                        <div class="stat-card info">
                                            <div class="stat-icon">
                                                <i class="fas fa-calendar-week"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h4>{{ $statistics['this_week_sessions'] ?? 0 }}</h4>
                                                <span>Esta Semana</span>
                                                <small>Últimos 7 días</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ingresos Este Mes -->
                                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                                        <div class="stat-card success">
                                            <div class="stat-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h4>{{ $statistics['current_month_sessions'] ?? 0 }}</h4>
                                                <span>Este Mes</span>
                                                <small>{{ now()->format('F Y') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Último ingreso -->
                                    <div class="col-lg-10 col-md-6 col-12 mb-3 mx-auto text-center text-white">
                                        <div>
                                            <i class="fas fa-clock fa-2x mb-2"></i>
                                            <h4 class="mb-1">
                                                {{ $statistics['last_login'] ? $statistics['last_login']->format('d/m') : 'N/A' }}
                                            </h4>
                                            <span class="d-block">Último Ingreso</span>
                                            <small>{{ $statistics['last_login'] ? $statistics['last_login']->diffForHumans() : 'Sin registro' }}</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Sesiones del Navegador -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row mb-2 justify-content-center">
                        <div class="col-10">
                            <div class="section-title">Sesiones del Navegador</div>
                            <p class="text-muted mb-4">
                                {{ __('Administra y cierra sesión de tus sesiones activas en otros navegadores y dispositivos.') }}
                            </p>

                            <!-- Lista de sesiones activas -->
                            @if (isset($activeSessions) && $activeSessions->count() > 0)
                                <div class="mb-4">
                                    <h6 class="text-white mb-3 font-weight-bold">
                                        <i class="fas fa-list mr-2"></i>
                                        {{ __('Sesiones Activas') }} ({{ $activeSessions->count() }})
                                    </h6>

                                    <div class="row sessions-grid">
                                        @foreach ($activeSessions as $session)
                                            <div class="col-md-6 col-12 mb-3">
                                                <div class="session-card">
                                                    <div class="session-icon">
                                                        @if ($session->device_type == 'Móvil')
                                                            <i class="fas fa-mobile-alt"></i>
                                                        @elseif ($session->device_type == 'Tablet')
                                                            <i class="fas fa-tablet-alt"></i>
                                                        @else
                                                            <i class="fas fa-desktop"></i>
                                                        @endif
                                                    </div>
                                                    <div class="session-content">
                                                        <h6>
                                                            {{ $session->browser }} - {{ $session->platform }}
                                                            @if ($session->is_current)
                                                                <span class="session-badge current">
                                                                    <i class="fas fa-circle mr-1"></i>Esta sesión
                                                                </span>
                                                            @else
                                                                <span class="session-badge online">
                                                                    En línea
                                                                </span>
                                                            @endif
                                                        </h6>
                                                        <small>
                                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                                            IP: {{ $session->ip_address }}
                                                            @if ($session->location != 'N/A')
                                                                • {{ $session->location }}
                                                            @endif
                                                        </small>
                                                        <div class="session-time">
                                                            <small>
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ $session->last_activity_formatted }}
                                                                @if ($session->login_at_formatted != 'N/A')
                                                                    <br>
                                                                    <i class="fas fa-sign-in-alt mr-1"></i>
                                                                    Inició: {{ $session->login_at_formatted }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <div class="action-buttons-container">
                                        <button type="button" class="camera-btn danger" data-toggle="modal"
                                            data-target="#logoutModal">
                                            🚪 Cerrar Otras Sesiones
                                            @if (isset($activeSessions) && $activeSessions->where('is_current', false)->count() > 0)
                                                <span class="session-count">
                                                    {{ $activeSessions->where('is_current', false)->count() }}
                                                </span>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    {{ __('No hay sesiones activas para mostrar en este momento.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de Sesiones -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row mb-2 justify-content-center">
                        <div class="col-10">
                            <div class="section-title">Historial de Sesiones</div>
                            <p class="text-muted mb-4">
                                {{ __('Tus últimas 5 sesiones cerradas con información detallada de conexión.') }}
                            </p>

                            @if (isset($recentSessions) && $recentSessions->count() > 0)
                                <div class="sessions-history-table">
                                    <table class="history-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IP</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Sistema</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentSessions as $session)
                                                <tr>
                                                    <td class="text-muted">{{ $session->id }}</td>
                                                    <td>{{ $session->ip_address }}</td>
                                                    <td class="text-success">
                                                        {{ $session->login_at ? $session->login_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td class="text-danger">
                                                        {{ $session->logout_at ? $session->logout_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td class="text-muted">{{ Str::limit($session->system ?? 'N/A', 30) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    {{ __('No hay historial de sesiones disponible.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cerrar otras sesiones -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sign-out-alt mr-2 text-danger"></i>
                        {{ __('Cerrar Otras Sesiones del Navegador') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form
                    action="{{ request()->is('user/profile') ? route('user.logout.other.sessions') : route('logout.other.sessions') }}"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            {{ __('Por favor, introduce tu contraseña para confirmar que deseas cerrar sesión de tus otras sesiones del navegador en todos tus dispositivos.') }}
                        </p>

                        @if (isset($activeSessions) && $activeSessions->where('is_current', false)->count() > 0)
                            <div class="mb-3">
                                <h6 class="font-weight-bold">{{ __('Sesiones que se cerrarán:') }}</h6>
                                <div class="sessions-to-close">
                                    @foreach ($activeSessions->where('is_current', false) as $session)
                                        <div class="session-item">
                                            <div class="session-device">
                                                @if ($session->device_type == 'Móvil')
                                                    <i class="fas fa-mobile-alt text-primary"></i>
                                                @elseif ($session->device_type == 'Tablet')
                                                    <i class="fas fa-tablet-alt text-info"></i>
                                                @else
                                                    <i class="fas fa-desktop text-warning"></i>
                                                @endif
                                            </div>
                                            <div class="session-details">
                                                <small class="font-weight-bold">{{ $session->browser }} -
                                                    {{ $session->platform }}</small><br>
                                                <small class="text-muted">
                                                    {{ $session->ip_address }}
                                                    @if ($session->location != 'N/A')
                                                        • {{ $session->location }}
                                                    @endif
                                                    • {{ $session->last_activity_formatted }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ __('No hay otras sesiones activas para cerrar.') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="modal_password" class="form-label">{{ __('Contraseña') }}</label>
                            <input type="password" id="modal_password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action-buttons-container">
                            <button type="button" class="camera-btn secondary" data-dismiss="modal">
                                ❌ Cancelar
                            </button>
                            <button type="submit" class="camera-btn danger"
                                {{ isset($activeSessions) && $activeSessions->where('is_current', false)->count() == 0 ? 'disabled' : '' }}>
                                🚪 Cerrar Sesiones
                                @if (isset($activeSessions) && $activeSessions->where('is_current', false)->count() > 0)
                                    ({{ $activeSessions->where('is_current', false)->count() }})
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

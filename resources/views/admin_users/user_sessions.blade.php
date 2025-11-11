@extends('adminlte::page')
@vite(['resources/js/app.js'])

@section('title', 'Crimanager - Sesiones de Usuario')

@section('content_header')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1 class="text-center text-white">
        REGISTRO DE INGRESOS AL SISTEMA
    </h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Variables CSS para tema oscuro */
        :root {
            --dark-bg: #1f2937;
            --dark-surface: #374151;
            --dark-surface-light: #4b5563;
            --dark-text: #f9fafb;
            --dark-text-muted: #9ca3af;
            --dark-border: #4b5563;
            --accent-primary: #3b82f6;
            --accent-success: #10b981;
            --accent-warning: #f59e0b;
            --accent-danger: #ef4444;
        }

        /* Estadísticas del dashboard */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--dark-surface) 0%, var(--dark-surface-light) 100%);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            color: var(--dark-text);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-primary);
            border-radius: 12px 12px 0 0;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .stats-card.active::before {
            background: var(--accent-success);
        }

        .stats-card.unique::before {
            background: var(--accent-warning);
        }

        .stats-card.today::before {
            background: var(--accent-danger);
        }

        /* Indicador visual para estadísticas filtradas */
        .stats-card.filtered {
            position: relative;
            border-color: var(--accent-warning);
            background: linear-gradient(135deg, var(--dark-surface) 0%, rgba(245, 158, 11, 0.1) 100%);
        }

        .stats-card.filtered::after {
            content: 'Filtrado';
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--accent-warning);
            color: var(--dark-bg);
            font-size: 0.6rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-card.filtered .stats-number {
            color: var(--accent-warning);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stats-label {
            font-size: 0.875rem;
            opacity: 0.8;
            font-weight: 500;
        }

        /* Filtros mejorados */
        .filter-section {
            background: #333536FF;
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        /* TITULO DE FILTROS */
        .filter-group label {
            color: var(--dark-text);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
        }

        .filter-group .form-control,
        .filter-group .form-select {
            background-color: #495057 !important;
            color: #ffffff !important;
            border: -1px solid #b6b6b6;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .filter-group .form-control:focus,
        .filter-group .form-select:focus {
            background-color: #495057 !important;
            color: #ffffff !important;
            color: var(--dark-text);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.15),
                0 0 0 0.2rem rgba(130, 130, 131, 0.25);
        }

        /* Tabla responsive mejorada */
        .table-light-custom th {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #000000;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
            white-space: nowrap;
        }

        .table-light-custom td {
            padding: 0.75rem;
            font-size: 0.875rem;
            vertical-align: middle;
            border-color: #dee2e6;
            color: #000000;
        }

        /* TITULOS DE LA TABLA LETRAS Y ESPACIO */

        .table th {
            background: #ffffff !important;
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
            color: #000000 !important;
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        /* LETRAS Y LIENEAS ENTRE FILAS */
        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #757474;
            color: #000000 !important;
        }

        /* LINEAS VERTICALES  */
        .table tbody tr:hover {
            background-color: #a4a4a4 !important;
            transform: scale(1.01);
        }

        /* DataTables en modo oscuro */
        /* BOTONES DE PAGINACION */
        .page-item .page-link {
            background-color: #343a40 !important;
            border-color: #495057 !important;
            color: #ffffff !important;
        }

        /* DEL QUE ESTA ACTIVO */
        .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        /* AL PASAR EL MOUSE */
        .page-item:hover .page-link {
            background-color: #454d55 !important;
            border-color: #495057 !important;
            color: #ffffff !important;
        }

        /* NO DISPONIBLES PARA SELECCION */
        .page-item.disabled .page-link {
            background-color: #495057 !important;
            border-color: #495057 !important;
            color: #6c757d !important;
        }

        /* Estados y badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.2);
            color: var(--accent-success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-inactive {
            background-color: rgba(156, 163, 175, 0.2);
            color: var(--dark-text-muted);
            border: 1px solid rgba(156, 163, 175, 0.3);
        }

        .status-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: currentColor;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Avatar de usuario */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .user-info {
            min-width: 0;
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.125rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            color: #585858;
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Información de dispositivo */
        .device-info {
            font-size: 0.75rem;
            color: #585858;
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .device-info span:first-child {
            color: #585858;
            font-weight: 500;
        }

        .ip-address {
            font-family: 'Monaco', 'Consolas', monospace;
            background: #f8f9fa;
            color: #585858;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            border: 1px solid #dee2e6;
        }

        /* Ubicación */
        .location-text {
            color: #585858;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .location-text i {
            color: #495057;
        }

        /* Duración de sesión */
        .session-time {
            font-size: 0.75rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.25rem;
        }

        .session-time i {
            color: #495057;
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 0.25rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 6px;
            border: 1px solid;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            white-space: nowrap;
        }

        .btn-info-custom {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
            color: var(--accent-primary);
        }

        .btn-info-custom:hover {
            background: rgba(59, 130, 246, 0.2);
            border-color: var(--accent-primary);
            color: var(--accent-primary);
        }

        .btn-danger-custom {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--accent-danger);
        }

        .btn-danger-custom:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--accent-danger);
            color: var(--accent-danger);
        }

        /* Responsividad */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hide-lg {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .hide-md {
                display: none !important;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .hide-sm {
                display: none !important;
            }

            .stats-number {
                font-size: 1.75rem;
            }
        }

        /* Modal styles */
        .modal-content {
            background: var(--dark-surface);
            color: var(--dark-text);
            border: 1px solid var(--dark-border);
        }

        .modal-header {
            border-bottom: 1px solid var(--dark-border);
        }

        .modal-footer {
            border-top: 1px solid var(--dark-border);
        }

        .btn-close {
            filter: invert(1);
        }

        /* Responsive para el botón */
        @media (max-width: 767px) {
            .btn {
                padding: 0.6rem 0.5rem;
                font-size: 0.875rem;
            }

            .btn i {
                font-size: 1.2rem;
                margin-bottom: 0.25rem;
                display: block;
            }

            .container-fluid {
                padding: 3px;
            }

            .container-fluid .card,
            .container-fluid .card-body {
                all: unset;
                /* Quita todos los estilos */
                display: block;
                /* Asegura que siga siendo bloque */
            }
        }
    </style>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Panel de estadísticas -->
        <div class="row g-3" style="margin-bottom: 5px;">
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <div class="stats-number" id="total-sessions">{{ $sessions->count() }}</div>
                    <div class="stats-label">Total de Sesiones</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card active">
                    <div class="stats-number" id="active-sessions">{{ $sessions->whereNull('logout_at')->count() }}</div>
                    <div class="stats-label">Sesiones Activas</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card unique">
                    <div class="stats-number" id="unique-users">{{ $sessions->pluck('user_id')->unique()->count() }}</div>
                    <div class="stats-label">Usuarios Únicos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card today">
                    <div class="stats-number" id="today-sessions">{{ $sessions->where('login_at', '>=', today())->count() }}
                    </div>
                    <div class="stats-label">Sesiones Hoy</div>
                </div>
            </div>
        </div>

        <!-- Filtros avanzados -->
        <div class="filter-section">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="status-filter">Estado de Sesión</label>
                    <select id="status-filter" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="active">Sesiones Activas</option>
                        <option value="inactive">Sesiones Cerradas</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="device-filter">Tipo de Dispositivo</label>
                    <select id="device-filter" class="form-select">
                        <option value="">Todos los dispositivos</option>
                        <option value="Desktop">Escritorio</option>
                        <option value="Mobile">Móvil</option>
                        <option value="Tablet">Tablet</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date-from">Fecha desde</label>
                    <input type="date" id="date-from" class="form-control">
                </div>
                <div class="filter-group">
                    <label for="date-to">Fecha hasta</label>
                    <input type="date" id="date-to" class="form-control">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-filters"
                    style="border: 1px solid white; background: transparent; color: white;">
                    <i class="fas fa-times me-1"></i>
                    Limpiar Filtros
                </button>
            </div>
        </div>
    </div>
    <!-- Tabla de sesiones -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-custom">
                    <table class="table table-light-custom table-hover table-striped" id="sessionsTable">
                        <thead>
                            <tr>
                                <th style="width: 80px;">#ID</th>
                                <th style="min-width: 200px;">Usuario</th>
                                <th class="hide-sm" style="width: 120px;">IP Address</th>
                                <th class="hide-md" style="width: 100px;">Sistema</th>
                                <th class="hide-lg" style="width: 150px;">Ubicación</th>
                                <th class="hide-sm" style="width: 150px;">Inicio de Sesión</th>
                                <th style="width: 120px;">Estado</th>
                                <th style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sessions as $session)
                                <tr data-session-id="{{ $session->id }}" data-user-id="{{ $session->user_id }}"
                                    data-status="{{ $session->logout_at ? 'inactive' : 'active' }}"
                                    data-login-date="{{ $session->login_at->format('Y-m-d') }}"
                                    data-today="{{ $session->login_at->isToday() ? '1' : '0' }}"
                                    data-device="{{ $session->device }}">
                                    <td>
                                        <span class="session-id">#{{ $session->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 mobile-compact"
                                            data-user-id="{{ $session->user_id }}">
                                            <div class="user-avatar"
                                                style="background: {{ sprintf('#%06X', crc32($session->user->name ?? 'User') & 0xffffff) }}">
                                                {{ strtoupper(substr($session->user->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <div class="user-info">
                                                <div class="user-name">
                                                    {{ $session->user->name ?? 'Usuario Desconocido' }}
                                                </div>
                                                <div class="user-email">{{ $session->user->email ?? 'Sin email' }}
                                                </div>
                                                <div class="mobile-device-info d-md-none">
                                                    {{ $session->device ?? 'N/A' }} •
                                                    {{ $session->system ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hide-sm">
                                        <span class="ip-address">{{ $session->ip_address ?? 'N/A' }}</span>
                                    </td>
                                    <td class="hide-md">
                                        <div class="device-info">
                                            <span>{{ $session->system ?? 'N/A' }}</span>
                                            <span>{{ $session->device ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="hide-lg">
                                        <div class="location-text"
                                            title="{{ $session->location ?? 'Ubicación desconocida' }}">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $session->location ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="hide-sm">
                                        <div>
                                            <div>{{ $session->login_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $session->login_at->format('H:i:s') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($session->logout_at)
                                            <div class="status-badge status-inactive" data-status="inactive">
                                                <span class="status-indicator"></span>
                                                <span>Cerrada</span>
                                            </div>
                                            <div class="session-time">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ $session->login_at->diff($session->logout_at)->format('%H:%I:%S') }}</span>
                                            </div>
                                        @else
                                            <div class="status-badge status-active" data-status="active">
                                                <span class="status-indicator"></span>
                                                <span>En línea</span>
                                            </div>
                                            <div class="session-time">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ $session->login_at->diffForHumans() }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-action btn-info-custom"
                                                data-bs-toggle="modal" data-bs-target="#sessionModal{{ $session->id }}"
                                                title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-md-inline">Detalles</span>
                                            </button>

                                            @can('editar.Usuarios')
                                                @if (is_null($session->logout_at))
                                                    <button type="button"
                                                        class="btn btn-action btn-danger-custom terminate-session-btn"
                                                        data-session-id="{{ $session->id }}"
                                                        data-user-name="{{ $session->user->name ?? 'Usuario' }}"
                                                        title="Terminar sesión">
                                                        <i class="fas fa-sign-out-alt"></i>
                                                        <span class="d-none d-md-inline">Terminar</span>
                                                    </button>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay sesiones registradas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para detalles de sesión -->
    @foreach ($sessions as $session)
        <div class="modal fade" id="sessionModal{{ $session->id }}" tabindex="-1"
            aria-labelledby="sessionModalLabel{{ $session->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sessionModalLabel{{ $session->id }}">
                            <i class="fas fa-user-clock text-info"></i>
                            Detalles de Sesión #{{ $session->id }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="text-info mb-3">
                                    <i class="fas fa-user"></i> Información del Usuario
                                </h6>
                                <div class="mb-3">
                                    <strong>Nombre:</strong>
                                    <span class="ms-2">{{ $session->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Email:</strong>
                                    <span class="ms-2">{{ $session->user->email ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Rol:</strong>
                                    <span class="ms-2">
                                        @if ($session->user && $session->user->roles->isNotEmpty())
                                            {{ $session->user->roles->pluck('name')->join(', ') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-warning mb-3">
                                    <i class="fas fa-network-wired"></i> Información Técnica
                                </h6>
                                <div class="mb-3">
                                    <strong>IP:</strong>
                                    <span class="ip-address ms-2">{{ $session->ip_address ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Sistema:</strong>
                                    <span class="ms-2">{{ $session->system ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Dispositivo:</strong>
                                    <span class="ms-2">{{ $session->device ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Última Actividad:</strong>
                                    <span class="ms-2">
                                        @if ($session->last_activity)
                                            {{ \Carbon\Carbon::parse($session->last_activity)->format('d/m/Y H:i:s') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-clock"></i> Tiempos de Sesión
                                </h6>
                                <div class="mb-3">
                                    <strong>Inicio:</strong>
                                    <span class="ms-2">{{ $session->login_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Fin:</strong>
                                    <span class="ms-2">
                                        @if ($session->logout_at)
                                            {{ $session->logout_at->format('d/m/Y H:i:s') }}
                                        @else
                                            <span class="badge bg-success">Sesión activa</span>
                                        @endif
                                    </span>
                                </div>
                                @if ($session->logout_at)
                                    <div class="mb-3">
                                        <strong>Duración:</strong>
                                        <span
                                            class="ms-2">{{ $session->login_at->diff($session->logout_at)->format('%d días %H horas %I minutos') }}</span>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <strong>Duración actual:</strong>
                                        <span class="ms-2">{{ $session->login_at->diffForHumans(null, true) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger mb-3">
                                    <i class="fas fa-map-marker-alt"></i> Ubicación y Dispositivo
                                </h6>
                                <div class="mb-3">
                                    <strong>Ubicación:</strong>
                                    <span class="ms-2">{{ $session->location ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Sistema Operativo:</strong>
                                    <span class="ms-2">{{ $session->system ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Tipo de Dispositivo:</strong>
                                    <span class="ms-2">{{ $session->device ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Dirección IP:</strong>
                                    <span class="ip-address ms-2">{{ $session->ip_address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        @can('editar.Usuarios')
                            @if (is_null($session->logout_at))
                                <button type="button" class="btn btn-danger terminate-session-btn"
                                    data-session-id="{{ $session->id }}"
                                    data-user-name="{{ $session->user->name ?? 'Usuario' }}" data-bs-dismiss="modal">
                                    <i class="fas fa-sign-out-alt"></i> Terminar Sesión
                                </button>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReOrder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Variables globales para almacenar datos originales
            let originalStats = {
                total: {{ $sessions->count() }},
                active: {{ $sessions->whereNull('logout_at')->count() }},
                unique: {{ $sessions->pluck('user_id')->unique()->count() }},
                today: {{ $sessions->where('login_at', '>=', today())->count() }}
            };

            // Verificar que existe el token CSRF
            if (!document.querySelector('meta[name="csrf-token"]')) {
                console.error(
                    'CSRF token meta tag not found. Please add <meta name="csrf-token" content="{{ csrf_token() }}"> to your layout head section.'
                );
            }

            // Configuración optimizada de DataTable
            const table = $('#sessionsTable').DataTable({
                responsive: true,
                colReorder: true,
                order: [
                    [5, "desc"]
                ], // Ordenar por fecha de inicio de sesión
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"B>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Exportar Excel',
                        className: 'btn btn-success btn-sm me-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Registro de Sesiones - ' + new Date().toLocaleDateString()
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> Exportar PDF',
                        className: 'btn btn-danger btn-sm me-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Registro de Sesiones',
                        customize: function(doc) {
                            doc.styles.tableHeader.fillColor = '#374151';
                            doc.styles.tableHeader.color = '#f9fafb';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        className: 'btn btn-secondary btn-sm me-1',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Registro de Sesiones de Usuario',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '9pt');
                        }
                    },
                    {
                        text: '<i class="fas fa-sync-alt"></i> Actualizar',
                        className: 'btn btn-info btn-sm',
                        action: function() {
                            updateStats();
                            location.reload(); // Recargar para obtener datos actualizados
                        }
                    }
                ],
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                language: {
                    decimal: ",",
                    emptyTable: "No hay sesiones registradas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ sesiones",
                    infoEmpty: "Mostrando 0 a 0 de 0 sesiones",
                    infoFiltered: "(filtrado de _MAX_ sesiones totales)",
                    thousands: ".",
                    lengthMenu: "Mostrar _MENU_ sesiones por página",
                    loadingRecords: "Cargando sesiones...",
                    processing: "Procesando...",
                    search: "Buscar sesiones:",
                    searchPlaceholder: "Buscar usuario, IP, ubicación...",
                    zeroRecords: "No se encontraron sesiones que coincidan con la búsqueda",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

            // Event listeners para filtros
            $('#status-filter').on('change', function() {
                const value = $(this).val();
                if (value === 'active') {
                    table.column(6).search('En línea', false, true, false).draw();
                } else if (value === 'inactive') {
                    table.column(6).search('Cerrada', false, true, false).draw();
                } else {
                    table.column(6).search('').draw();
                }
            });

            $('#device-filter').on('change', function() {
                const value = $(this).val();
                table.search(value).draw();
            });

            // Filtros de fecha
            let dateFilterApplied = false;

            $('#date-from, #date-to').on('change', function() {
                const dateFrom = $('#date-from').val();
                const dateTo = $('#date-to').val();

                if (dateFilterApplied) {
                    $.fn.dataTable.ext.search.pop();
                    dateFilterApplied = false;
                }

                if (dateFrom || dateTo) {
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (settings.nTable.id !== 'sessionsTable') return true;

                        const rowNode = table.row(dataIndex).node();
                        const loginDate = $(rowNode).attr('data-login-date');

                        if (!loginDate) return true;

                        const rowDate = new Date(loginDate);
                        const fromDate = dateFrom ? new Date(dateFrom) : null;
                        const toDate = dateTo ? new Date(dateTo) : null;

                        if (fromDate && rowDate < fromDate) return false;
                        if (toDate && rowDate > toDate) return false;

                        return true;
                    });
                    dateFilterApplied = true;
                }

                table.draw();
            });

            // Botón limpiar filtros
            $('#clear-filters').on('click', function() {
                $('#status-filter, #device-filter, #date-from, #date-to').val('');

                if (dateFilterApplied) {
                    $.fn.dataTable.ext.search.pop();
                    dateFilterApplied = false;
                }

                table.search('').columns().search('').draw();

                const btn = $(this);
                const originalText = btn.html();
                btn.html('<i class="fas fa-check"></i> Filtros limpiados')
                    .addClass('btn-success')
                    .removeClass('btn-outline-secondary');

                setTimeout(() => {
                    btn.html(originalText)
                        .removeClass('btn-success')
                        .addClass('btn-outline-secondary');
                }, 2000);
            });

            // Event listener para terminar sesión
            $(document).on('click', '.terminate-session-btn', function() {
                const sessionId = $(this).data('session-id');
                const userName = $(this).data('user-name');
                terminateSession(sessionId, userName);
            });

            // Función para actualizar estadísticas desde el servidor
            window.updateStats = function() {
                const statsRoute = "{{ route('admin.sessions.stats') }}";

                fetch(statsRoute, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Actualizar las estadísticas mostradas
                        animateValue('total-sessions', parseInt($('#total-sessions').text()), data.total);
                        animateValue('active-sessions', parseInt($('#active-sessions').text()), data
                            .active);
                        animateValue('unique-users', parseInt($('#unique-users').text()), data.unique);
                        animateValue('today-sessions', parseInt($('#today-sessions').text()), data.today);
                    })
                    .catch(error => {
                        console.error('Error actualizando estadísticas:', error);
                    });
            };
        });

        // Función para terminar sesión
        function terminateSession(sessionId, userName = '') {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                Swal.fire({
                    title: 'Error',
                    text: 'Token CSRF no encontrado. Recarga la página e intenta nuevamente.',
                    icon: 'error',
                    background: '#374151',
                    color: '#f9fafb',
                    confirmButtonColor: '#ef4444'
                });
                return;
            }

            Swal.fire({
                title: '¿Terminar sesión?',
                text: `Esta acción cerrará inmediatamente la sesión${userName ? ` de ${userName}` : ''}`,
                icon: 'warning',
                showCancelButton: true,
                background: '#374151',
                color: '#f9fafb',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, terminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Terminando sesión...',
                        allowOutsideClick: false,
                        background: '#374151',
                        color: '#f9fafb',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Construir la URL usando la ruta de Laravel
                    const terminateRoute = "{{ route('admin.sessions.terminate', ':id') }}".replace(':id',
                        sessionId);

                    fetch(terminateRoute, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                session_id: sessionId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.message ||
                                        `HTTP error! status: ${response.status}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Sesión terminada',
                                    text: data.message || 'La sesión ha sido cerrada exitosamente',
                                    icon: 'success',
                                    background: '#374151',
                                    color: '#f9fafb',
                                    confirmButtonColor: '#10b981'
                                }).then(() => {
                                    // Actualizar la fila en la tabla
                                    updateSessionRow(sessionId);
                                    // Actualizar estadísticas
                                    updateActiveSessionsCount();
                                });
                            } else {
                                throw new Error(data.message || 'Error desconocido');
                            }
                        })
                        .catch(error => {
                            console.error('Error terminando sesión:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo terminar la sesión: ' + error.message,
                                icon: 'error',
                                background: '#374151',
                                color: '#f9fafb',
                                confirmButtonColor: '#ef4444'
                            });
                        });
                }
            });
        }

        // Función para actualizar la fila de la tabla
        function updateSessionRow(sessionId) {
            const row = $(`tr[data-session-id="${sessionId}"]`);
            if (row.length) {
                row.attr('data-status', 'inactive');

                const statusBadge = row.find('.status-badge');
                statusBadge.removeClass('status-active').addClass('status-inactive');
                statusBadge.attr('data-status', 'inactive');
                statusBadge.find('span:last').text('Cerrada');

                const sessionTime = row.find('.session-time span');
                sessionTime.text('Terminada ahora');

                row.find('.terminate-session-btn').remove();

                $(`#sessionModal${sessionId}`).modal('hide');
            }
        }

        // Función para actualizar contador de sesiones activas
        function updateActiveSessionsCount() {
            const currentActive = parseInt($('#active-sessions').text());
            if (currentActive > 0) {
                animateValue('active-sessions', currentActive, currentActive - 1);
            }
        }

        // Función para animar cambios en números
        function animateValue(elementId, start, end, duration = 800) {
            const element = document.getElementById(elementId);
            if (!element) return;

            const range = end - start;
            if (range === 0) return;

            const minTimer = 16;
            let stepTime = Math.abs(Math.floor(duration / Math.abs(range)));
            stepTime = Math.max(stepTime, minTimer);

            const startTime = new Date().getTime();
            const endTime = startTime + duration;
            let timer;

            function run() {
                const now = new Date().getTime();
                const remaining = Math.max((endTime - now) / duration, 0);
                const value = Math.round(end - (remaining * range));

                element.innerHTML = value;

                if (value === end) {
                    clearInterval(timer);
                }
            }

            timer = setInterval(run, stepTime);
            run();
        }

        // Fallback para SweetAlert si no está disponible
        if (typeof Swal === 'undefined') {
            window.Swal = {
                fire: function(options) {
                    if (typeof options === 'string') {
                        alert(options);
                        return Promise.resolve({
                            isConfirmed: true
                        });
                    }
                    if (options.showCancelButton) {
                        const result = confirm(options.text || options.title);
                        return Promise.resolve({
                            isConfirmed: result
                        });
                    }
                    alert(options.text || options.title);
                    return Promise.resolve({
                        isConfirmed: true
                    });
                },
                showLoading: function() {},
            };
        }

        // Manejo de errores AJAX
        $(document).ajaxError(function(event, xhr, settings, error) {
            if (xhr.status === 419) {
                Swal.fire({
                    title: 'Sesión expirada',
                    text: 'Tu sesión ha expirado. Por favor, recarga la página.',
                    icon: 'warning',
                    background: '#374151',
                    color: '#f9fafb',
                    confirmButtonColor: '#f59e0b',
                    confirmButtonText: 'Recargar página'
                }).then(() => {
                    location.reload();
                });
            }
        });
    </script>
@stop

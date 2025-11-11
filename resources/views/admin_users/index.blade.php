@extends('adminlte::page')

@section('title', 'Crimanager - Gestión de Usuarios')

@section('content_header')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="col-11 mx-auto text-center" style="margin-bottom: 5px;">
        <h1 class="text-white fw-bold">
            <i class="fas fa-users me-2"></i>
            GESTIÓN DE USUARIOS DEL SISTEMA
        </h1>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --light-color: #343a40;
            --dark-color: #d62121;
            --border-radius: 8px;
            --box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
            --transition: all 0.3s ease;
        }

        /* AdminLTE Dark Mode */
        body {
            background-color: #454d55 !important;
            color: #ffffff !important;
        }

        .content-wrapper {
            background-color: #454d55 !important;
            color: #ffffff !important;
        }

        /* Card principal */
        .main-card {
            background: #343a40 !important;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid #495057;
            overflow: hidden;
        }

        .card-header {
            background: #343a40 !important;
            color: #ffffff !important;
            border: none;
            padding: 1.5rem;
            border-bottom: 1px solid #495057;
        }

        .card-body {
            padding: 2rem;
            background: #343a40 !important;
            color: #ffffff !important;
        }

        /* Botones mejorados */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover:before {
            left: 100%;
        }

        .btn-create {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }

        /* Filtros avanzados */
        .filter-section {
            background: #333536FF;
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-weight: 600;
            color: #ffffff !important;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: var(--border-radius);
            border: 1px solid #888888 !important;
            transition: var(--transition);
            background-color: #454d55 !important;
            color: #ffffff !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
            background-color: #454d55 !important;
            color: #ffffff !important;
        }

        .form-control option,
        .form-select option {
            background-color: #454d55 !important;
            color: #ffffff !important;
        }

        /* Switch mejorado */
        .status-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .status-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            transition: var(--transition);
            border-radius: 30px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .switch-slider.active {
            background: linear-gradient(135deg, #51cf66, #40c057);
        }

        .switch-slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            top: 3px;
            background: white;
            transition: var(--transition);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .status-switch input:checked+.switch-slider:before {
            transform: translateX(30px);
        }

        /* Estados con iconos */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-inactive {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border: 1px solid #f5c6cb;
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

        /* Botones en modo oscuro */
        .btn-outline-secondary {
            background-color: transparent !important;
            border-color: #495057 !important;
            color: #adb5bd !important;
        }

        .btn-outline-secondary:hover {
            background-color: #454d55 !important;
            border-color: #495057 !important;
            color: #ffffff !important;
        }

        .btn-outline-primary {
            background-color: transparent !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        /* Imágenes mejoradas */
        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            transition: var(--transition);
            cursor: pointer;
        }

        .profile-image:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .profile-image.loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Botones de acción mejorados */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            min-width: 80px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .btn-view {
            background: linear-gradient(135deg, var(--info-color), #138496);
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, var(--warning-color), #d39e00);
            color: #212529;
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Roles con badges */
        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .role-badge {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: rgb(5, 5, 5);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Alertas mejoradas */
        .alert-enhanced {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Modal en modo oscuro */
        .modal-content {
            background-color: #343a40 !important;
            border: 1px solid #495057 !important;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: 1px solid #495057 !important;
            background-color: #343a40 !important;
        }

        .modal-title {
            color: #ffffff !important;
        }

        .btn-close {
            filter: invert(1);
        }

        /* Text colors en modo oscuro */
        .text-muted {
            color: #6c757d !important;
        }

        .text-decoration-none {
            color: var(--primary-color) !important;
        }

        .text-decoration-none:hover {
            color: #0056b3 !important;
        }

        /* Estadísticas */
        .stats-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            flex: 1;
            background: #343a40 !important;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
            transition: var(--transition);
            border: 1px solid #495057;
            color: #ffffff !important;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color) !important;
        }

        .stat-label {
            color: #adb5bd !important;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Links */
        a {
            color: var(--primary-color) !important;
        }

        /* Badges */
        .badge {
            color: white !important;
        }

        /* Header title */
        .content-header h1 {
            color: #ffffff !important;
        }

        /* Estilos para el menú de exportación */
        .export-dropdown-menu {
            background: #495057;
            border: 1px solid #6c757d;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 8px 0;
        }

        .export-dropdown-menu .dropdown-item {
            padding: 8px 16px;
            color: #ffffff !important;
            text-decoration: none;
            display: block;
            transition: background-color 0.15s ease-in-out;
        }

        .export-dropdown-menu .dropdown-item:hover {
            background-color: #6c757d;
            color: #ffffff !important;
        }

        .export-dropdown-menu .dropdown-header {
            padding: 4px 16px;
            margin-bottom: 4px;
            font-size: 0.875rem;
            color: #ffffff !important;
            font-weight: 600;
        }

        .export-dropdown-menu .dropdown-divider {
            height: 0;
            margin: 8px 0;
            overflow: hidden;
            border-top: 1px solid #6c757d;
        }

        .export-dropdown-menu .dropdown-item-text {
            padding: 4px 16px;
            color: #ffffff !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
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

            .filter-row {
                flex-direction: column;
            }

            .filter-group {
                min-width: 100%;
            }

            .action-buttons {
                justify-content: center;
            }

            .btn-action {
                min-width: 70px;
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.5rem 0.25rem;
            }

            .profile-image {
                width: 40px;
                height: 40px;
            }
        }

        /* Estados de carga */
        .table-loading {
            position: relative;
        }

        .table-loading:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(52, 58, 64, 0.8);
            z-index: 1000;
        }

        /* Tooltips mejorados */
        .tooltip {
            font-size: 0.875rem;
        }

        .tooltip-inner {
            background: #343a40;
            border-radius: var(--border-radius);
        }
    </style>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Estadísticas -->
        <div class="row g-3" style="margin-bottom: 5px;">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number" id="total-count">{{ count($usuarios) }}</div>
                    <div class="stat-label">Total Usuarios</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-success" id="active-count">
                        {{ collect($usuarios)->where('estado', 1)->count() }}
                    </div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-danger" id="inactive-count">
                        {{ collect($usuarios)->where('estado', 0)->count() }}
                    </div>
                    <div class="stat-label">Usuarios Inactivos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-info" id="roles-count">
                        {{ collect($usuarios)->pluck('roles')->flatten()->unique('name')->count() }}
                    </div>
                    <div class="stat-label">Roles Diferentes</div>
                </div>
            </div>
        </div>

        <!-- Filtros avanzados -->
        <div class="filter-section">
            <h6 class="mb-3">
                <i class="fas fa-filter me-2"></i>
                Filtros Avanzados
            </h6>
            <div class="row g-3 filter-row">
                <div class="col-12 col-md">
                    <div class="filter-group">
                        <label for="filter-role">Filtrar por Rol</label>
                        <select class="form-select" id="filter-role">
                            <option value="">Todos los Roles</option>
                            @foreach (collect($usuarios)->pluck('roles')->flatten()->unique('name') as $role)
                                <option value="{{ strtoupper($role->name) }}">{{ strtoupper($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="filter-group">
                        <label for="filter-status">Filtrar por Estado</label>
                        <select class="form-select" id="filter-status">
                            <option value="">Todos los Estados</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="filter-group">
                        <label for="filter-grade">Filtrar por Grado</label>
                        <select class="form-select" id="filter-grade">
                            <option value="">Todos los Grados</option>
                            @foreach (collect($usuarios)->pluck('grade')->unique()->sort() as $grade)
                                <option value="{{ $grade }}">{{ ucwords(strtolower($grade)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-2 align-items-center">
                    <!-- Columna izquierda: Crear -->
                    <div class="col-12 col-md-auto">
                        @can('crear.Usuarios')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-create w-100 h-100 py-1">
                                <i class="fas fa-plus me-2"></i>
                                Crear Nuevo Usuario
                            </a>
                        @endcan
                    </div>

                    <!-- Columna derecha: Limpiar y Exportar -->
                    <div class="col-12 col-md d-flex justify-content-md-end gap-2">
                        <div class="col-6 col-md-auto p-0">
                            <button type="button" class="btn w-100 h-100" id="clear-filters"
                                style="border: 1px solid white; background: transparent; color: white;">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </button>
                        </div>
                        <div class="col-6 col-md-auto p-0">
                            <button type="button" id="exportBtn" class="btn btn-success w-100 h-100">
                                <i class="fas fa-download d-md-none"></i>
                                <span class="d-none d-md-inline">Exportar</span>
                                <span class="d-md-none">Exportar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabla -->
    <div class="container-fluid">
        <div class="main-card">
            <div class="card-body">
                <table class="table table-hover" id="usuarios-table">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Grado, Nombres y Apellidos</th>
                            <th scope="col">CI/DNI</th>
                            <th scope="col">Fotografía</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Rol(es)</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $user)
                            <tr data-user-id="{{ $user->id }}">
                                <td>
                                    <span class="badge bg-light text-dark">{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ ucwords(strtolower($user->grade ?? '')) }}</strong>
                                        <span class="ms-2">{{ ucwords(strtolower($user->name)) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <code>{{ $user->ci_police }}</code>
                                </td>
                                <td>
                                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset($user->profile_photo_url) }}"
                                        alt="Foto de {{ $user->name }}" class="profile-image loading"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Click para ampliar"
                                        onclick="showImageModal('{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset($user->profile_photo_url) }}', '{{ $user->name }}')"
                                        onload="this.classList.remove('loading')"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0zMiA0OEMzOC42Mjc0IDQ4IDQ0IDQyLjYyNzQgNDQgMzZDNDQgMjkuMzcyNiAzOC42Mjc0IDI0IDMyIDI0QzI1LjM3MjYgMjQgMjAgMjkuMzcyNiAyMCAzNkMyMCA0Mi42Mjc0IDI1LjM3MjYgNDggMzIgNDhaIiBmaWxsPSIjQ0REMkQ5Ii8+CjxwYXRoIGQ9Ik0zMiAzNkMzNS4zMTM3IDM2IDM4IDMzLjMxMzcgMzggMzBDMzggMjYuNjg2MyAzNS4zMTM3IDI0IDMyIDI0QzI4LjY4NjMgMjQgMjYgMjYuNjg2MyAyNiAzMEMyNiAzMy4zMTM3IDI4LjY4NjMgMzYgMzIgMzZaIiBmaWxsPSIjOUNBM0FGIi8+Cjwvc3ZnPg=='; this.classList.remove('loading');" />
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    @if ($user->phone)
                                        <a href="tel:{{ $user->phone }}" class="text-decoration-none">
                                            {{ $user->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="role-badges">
                                        @forelse ($user->roles as $role)
                                            <span class="role-badge">{{ strtoupper($role->name) }}</span>
                                        @empty
                                            <span class="text-muted">Sin rol</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="status-switch" data-bs-toggle="tooltip" title="Estado del usuario">
                                            <input type="checkbox" {{ $user->estado ? 'checked' : '' }} disabled>
                                            <span class="switch-slider {{ $user->estado ? 'active' : '' }}"></span>
                                        </label>
                                        <span
                                            class="status-badge {{ $user->estado ? 'status-active' : 'status-inactive' }}">
                                            <i class="fas fa-{{ $user->estado ? 'check-circle' : 'times-circle' }}"></i>
                                            {{ $user->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @can('ver.Usuarios')
                                            <button type="button" class="btn btn-action btn-view" data-bs-toggle="tooltip"
                                                title="Ver detalles completos"
                                                onclick="showUserDetails({{ $user->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endcan

                                        @can('editar.Usuarios')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-action btn-edit" data-bs-toggle="tooltip"
                                                title="Editar usuario">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('eliminar.Usuarios')
                                            <button type="button" class="btn btn-action btn-delete" data-bs-toggle="tooltip"
                                                title="Eliminar usuario"
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal para ver imagen completa -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fotografía de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="" class="img-fluid rounded" id="modal-image">
                    <p class="mt-2 text-muted" id="modal-name"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles del usuario -->
    <div class="modal fade" id="userDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-circle me-2"></i>
                        Detalles del Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="spinner-border" role="status" id="details-loading">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <div id="user-details-content" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmar Acción
                    </h5>
                </div>
                <div class="modal-body">
                    <p id="confirm-message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm-action">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-enhanced alert-dismissible fade show" role="alert" id="success-alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-enhanced alert-dismissible fade show" role="alert" id="error-alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        let table;

        $(document).ready(function() {
            // Inicializar tooltips
            initializeTooltips();

            // Inicializar DataTable con todas las funcionalidades
            table = initializeDataTable();

            // Configurar filtros
            setupFilters(table);

            // Configurar botón de exportar personalizado
            setupExportButton();

            // Auto-hide alerts
            autoHideAlerts();

            // Lazy loading de imágenes
            setupLazyLoading();

            // Actualizar estadísticas en tiempo real
            updateStatistics();

            // Funciones adicionales
            enhancedSearch();
            handleImageErrors();

            // Animaciones de entrada
            animateCards();
        });

        // Función para inicializar tooltips
        function initializeTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Función para inicializar DataTable
        function initializeDataTable() {
            return $('#usuarios-table').DataTable({
                responsive: true,
                colReorder: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todos"]
                ],
                order: [
                    [0, 'asc']
                ],
                // DOM sin botones de exportar
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>' +
                    '<"row"<"col-md-12"t>>' +
                    '<"row"<"col-md-5"i><"col-md-7"p>>',
                language: {
                    decimal: ",",
                    emptyTable: "No hay usuarios registrados en el sistema",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
                    infoEmpty: "Mostrando 0 a 0 de 0 usuarios",
                    infoFiltered: "(filtrado de _MAX_ usuarios totales)",
                    thousands: ".",
                    lengthMenu: "Mostrar _MENU_ usuarios por página",
                    loadingRecords: "Cargando usuarios...",
                    processing: "Procesando...",
                    search: "Buscar usuario:",
                    zeroRecords: "No se encontraron usuarios que coincidan con la búsqueda",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    },
                    aria: {
                        sortAscending: ": activar para ordenar la columna de forma ascendente",
                        sortDescending: ": activar para ordenar la columna de forma descendente"
                    }
                },
                columnDefs: [{
                        targets: [3, 8],
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: [0],
                        width: "5%"
                    },
                    {
                        targets: [1],
                        width: "20%"
                    },
                    {
                        targets: [2],
                        width: "10%"
                    },
                    {
                        targets: [3],
                        width: "8%"
                    },
                    {
                        targets: [4],
                        width: "15%"
                    },
                    {
                        targets: [5],
                        width: "10%"
                    },
                    {
                        targets: [6],
                        width: "12%"
                    },
                    {
                        targets: [7],
                        width: "10%"
                    },
                    {
                        targets: [8],
                        width: "10%"
                    }
                ],
                drawCallback: function() {
                    // Reinicializar tooltips después de cada redibujado
                    initializeTooltips();

                    // Actualizar estadísticas
                    updateStatistics();

                    // Configurar lazy loading de nuevas imágenes
                    setupLazyLoading();
                }
            });
        }

        // Función para configurar filtros
        function setupFilters(table) {
            // Filtro por rol
            $('#filter-role').on('change', function() {
                const selectedRole = this.value;
                if (selectedRole) {
                    table.column(6).search(selectedRole).draw();
                } else {
                    table.column(6).search('').draw();
                }
                updateFilteredStatistics(table);
            });

            // Filtro por estado
            $('#filter-status').on('change', function() {
                const selectedStatus = this.value;
                if (selectedStatus === 'activo') {
                    table.column(7).search('Activo').draw();
                } else if (selectedStatus === 'inactivo') {
                    table.column(7).search('Inactivo').draw();
                } else {
                    table.column(7).search('').draw();
                }
                updateFilteredStatistics(table);
            });

            // Filtro por grado
            $('#filter-grade').on('change', function() {
                const selectedGrade = this.value;
                if (selectedGrade) {
                    table.column(1).search(selectedGrade).draw();
                } else {
                    table.column(1).search('').draw();
                }
                updateFilteredStatistics(table);
            });

            // Limpiar filtros
            $('#clear-filters').on('click', function() {
                $('#filter-role, #filter-status, #filter-grade').val('');
                table.search('').columns().search('').draw();
                updateStatistics();

                // Animación visual
                $(this).addClass('animate__animated animate__pulse');
                setTimeout(() => {
                    $(this).removeClass('animate__animated animate__pulse');
                }, 1000);
            });
        }

        // Función para configurar botón de exportar personalizado
        function setupExportButton() {
            $('#exportBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Remover menús anteriores
                $('.export-dropdown-menu').remove();

                const exportMenu = $(`
                    <div class="export-dropdown-menu dropdown-menu show" style="position: absolute; z-index: 1050;">
                        <h6 class="dropdown-header">Exportar datos</h6>
                        <a class="dropdown-item" href="#" data-export="excel">
                            <i class="fas fa-file-excel text-success me-2"></i>Exportar a Excel
                        </a>
                        <a class="dropdown-item" href="#" data-export="csv">
                            <i class="fas fa-file-csv text-primary me-2"></i>Exportar a CSV
                        </a>
                        <a class="dropdown-item" href="#" data-export="pdf">
                            <i class="fas fa-file-pdf text-danger me-2"></i>Exportar a PDF
                        </a>
                        <a class="dropdown-item" href="#" data-export="print">
                            <i class="fas fa-print text-info me-2"></i>Imprimir
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item-text small text-muted">
                            Se exportarán solo los datos visibles
                        </div>
                    </div>
                `);

                // Posicionar y mostrar menú
                const rect = this.getBoundingClientRect();
                exportMenu.css({
                    position: 'fixed',
                    top: rect.bottom + 5,
                    left: rect.left - 120,
                    minWidth: '200px'
                });

                $('body').append(exportMenu);

                // Manejar clicks en opciones de exportación
                exportMenu.find('[data-export]').on('click', function(e) {
                    e.preventDefault();
                    const exportType = $(this).data('export');

                    // Mostrar indicador de carga
                    showLoadingToast();

                    setTimeout(() => {
                        switch (exportType) {
                            case 'excel':
                                exportToExcel();
                                break;
                            case 'csv':
                                exportToCSV();
                                break;
                            case 'pdf':
                                exportToPDF();
                                break;
                            case 'print':
                                printTable();
                                break;
                        }

                        showSuccessToast();
                    }, 500);

                    exportMenu.remove();
                });

                // Cerrar menú al hacer click fuera
                $(document).one('click', function(e) {
                    if (!$(e.target).closest('.export-dropdown-menu, #exportBtn').length) {
                        exportMenu.remove();
                    }
                });
            });
        }

        // Función para mostrar toast de carga
        function showLoadingToast() {
            const loadingToast = $('<div class="toast align-items-center text-white bg-primary border-0" role="alert">')
                .html(
                    '<div class="d-flex"><div class="toast-body"><i class="fas fa-spinner fa-spin me-2"></i>Exportando...</div></div>'
                );

            $('body').append(loadingToast);
            loadingToast.toast({
                delay: 3000
            }).toast('show');

            setTimeout(() => loadingToast.remove(), 3500);
        }

        // Función para mostrar toast de éxito
        function showSuccessToast() {
            const successToast = $('<div class="toast align-items-center text-white bg-success border-0" role="alert">')
                .html(
                    '<div class="d-flex"><div class="toast-body"><i class="fas fa-check me-2"></i>Exportación completada</div></div>'
                );

            $('body').append(successToast);
            successToast.toast({
                delay: 2000
            }).toast('show');

            setTimeout(() => successToast.remove(), 2500);
        }

        // Función para exportar a Excel
        function exportToExcel() {
            const data = table.rows({
                search: 'applied'
            }).data().toArray();

            let content = `
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>CI/DNI</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Roles</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach(row => {
                const cleanRow = [
                    $(row[0]).text().trim(),
                    $(row[1]).text().trim(),
                    $(row[2]).text().trim(),
                    $(row[4]).text().trim(),
                    $(row[5]).text().trim(),
                    $(row[6]).text().trim(),
                    $(row[7]).find('.status-badge').text().trim()
                ];

                content += '<tr>';
                cleanRow.forEach(cell => {
                    content += `<td>${cell}</td>`;
                });
                content += '</tr>';
            });

            content += '</tbody></table>';

            const blob = new Blob([content], {
                type: 'application/vnd.ms-excel'
            });
            downloadFile(blob, `usuarios_${getCurrentDate()}.xls`);
        }

        // Función para exportar a CSV
        function exportToCSV() {
            const data = table.rows({
                search: 'applied'
            }).data().toArray();

            let csv = 'ID,Nombre Completo,CI/DNI,Email,Teléfono,Roles,Estado\n';

            data.forEach(row => {
                const cleanRow = [
                    $(row[0]).text().trim(),
                    $(row[1]).text().trim(),
                    $(row[2]).text().trim(),
                    $(row[4]).text().trim(),
                    $(row[5]).text().trim(),
                    $(row[6]).text().trim(),
                    $(row[7]).find('.status-badge').text().trim()
                ];

                csv += '"' + cleanRow.join('","') + '"\n';
            });

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            downloadFile(blob, `usuarios_${getCurrentDate()}.csv`);
        }

        // Función para exportar a PDF usando pdfmake (que ya tienes cargado)
        function exportToPDF() {
            try {
                // Verificar si pdfMake está disponible
                if (typeof pdfMake === 'undefined') {
                    alert('Error: La librería pdfMake no está cargada correctamente.');
                    console.error('pdfMake no está definido');
                    return;
                }

                // Obtener datos de la tabla filtrada
                const data = table.rows({
                    search: 'applied'
                }).data().toArray();

                // Procesar datos para el PDF
                const tableBody = [];

                // Headers de la tabla
                tableBody.push([{
                        text: 'ID',
                        style: 'tableHeader'
                    },
                    {
                        text: 'Nombre Completo',
                        style: 'tableHeader'
                    },
                    {
                        text: 'CI/DNI',
                        style: 'tableHeader'
                    },
                    {
                        text: 'Email',
                        style: 'tableHeader'
                    },
                    {
                        text: 'Teléfono',
                        style: 'tableHeader'
                    },
                    {
                        text: 'Roles',
                        style: 'tableHeader'
                    },
                    {
                        text: 'Estado',
                        style: 'tableHeader'
                    }
                ]);

                // Datos de la tabla
                data.forEach((row, index) => {
                    const cleanRow = [{
                            text: $(row[0]).text().trim(),
                            alignment: 'center'
                        },
                        {
                            text: $(row[1]).text().trim(),
                            alignment: 'left'
                        },
                        {
                            text: $(row[2]).text().trim(),
                            alignment: 'center'
                        },
                        {
                            text: $(row[4]).text().trim(),
                            alignment: 'left'
                        },
                        {
                            text: $(row[5]).text().trim() || 'No especificado',
                            alignment: 'center'
                        },
                        {
                            text: $(row[6]).text().trim(),
                            alignment: 'left'
                        },
                        {
                            text: $(row[7]).find('.status-badge').text().trim(),
                            alignment: 'center',
                            color: $(row[7]).find('.status-badge').text().trim().includes('Activo') ?
                                '#155724' : '#721c24'
                        }
                    ];
                    tableBody.push(cleanRow);
                });

                // Calcular estadísticas
                const totalUsers = data.length;
                const activeUsers = data.filter(row => $(row[7]).find('.status-badge').text().trim().includes('Activo'))
                    .length;
                const inactiveUsers = totalUsers - activeUsers;

                // Configuración del documento PDF
                const docDefinition = {
                    pageSize: 'A4',
                    pageOrientation: 'landscape',
                    pageMargins: [40, 60, 40, 60],

                    header: {
                        margin: [0, 20, 0, 0],
                        table: {
                            widths: ['*'],
                            body: [
                                [{
                                    text: 'LISTA DE USUARIOS DEL SISTEMA - CRIMANAGER',
                                    style: 'header',
                                    alignment: 'center'
                                }]
                            ]
                        },
                        layout: 'noBorders'
                    },

                    footer: function(currentPage, pageCount) {
                        return {
                            margin: [40, 0],
                            table: {
                                widths: ['*', '*'],
                                body: [
                                    [{
                                            text: 'Generado por CRIMANAGER',
                                            alignment: 'left',
                                            fontSize: 8
                                        },
                                        {
                                            text: `Página ${currentPage} de ${pageCount}`,
                                            alignment: 'right',
                                            fontSize: 8
                                        }
                                    ]
                                ]
                            },
                            layout: 'noBorders'
                        };
                    },

                    content: [
                        // Información de fecha y filtros
                        {
                            table: {
                                widths: ['*', '*'],
                                body: [
                                    [{
                                            text: `Fecha de generación: ${new Date().toLocaleDateString('es-ES', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}`,
                                            fontSize: 10
                                        },
                                        {
                                            text: `Total de registros: ${totalUsers}`,
                                            fontSize: 10,
                                            alignment: 'right'
                                        }
                                    ]
                                ]
                            },
                            layout: 'noBorders',
                            margin: [0, 0, 0, 20]
                        },

                        // Tabla principal
                        {
                            table: {
                                headerRows: 1,
                                widths: [30, '*', 60, 120, 70, 80, 50],
                                body: tableBody
                            },
                            layout: {
                                fillColor: function(rowIndex, node, columnIndex) {
                                    return (rowIndex === 0) ? '#343a40' : (rowIndex % 2 === 0 ? '#f8f9fa' :
                                        null);
                                },
                                hLineWidth: function(i, node) {
                                    return (i === 0 || i === 1 || i === node.table.body.length) ? 2 : 1;
                                },
                                vLineWidth: function(i, node) {
                                    return 0;
                                },
                                hLineColor: function(i, node) {
                                    return '#dee2e6';
                                }
                            }
                        },

                        // Espaciado
                        {
                            text: ' ',
                            margin: [0, 20, 0, 0]
                        },

                        // Estadísticas finales
                        {
                            table: {
                                widths: ['*', '*', '*'],
                                body: [
                                    [{
                                            text: `Total de Usuarios\n${totalUsers}`,
                                            style: 'statsBox',
                                            alignment: 'center',
                                            fillColor: '#e9ecef'
                                        },
                                        {
                                            text: `Usuarios Activos\n${activeUsers}`,
                                            style: 'statsBox',
                                            alignment: 'center',
                                            fillColor: '#d4edda',
                                            color: '#155724'
                                        },
                                        {
                                            text: `Usuarios Inactivos\n${inactiveUsers}`,
                                            style: 'statsBox',
                                            alignment: 'center',
                                            fillColor: '#f8d7da',
                                            color: '#721c24'
                                        }
                                    ]
                                ]
                            },
                            layout: {
                                hLineWidth: function(i) {
                                    return 1;
                                },
                                vLineWidth: function(i) {
                                    return 1;
                                },
                                hLineColor: function(i) {
                                    return '#adb5bd';
                                },
                                vLineColor: function(i) {
                                    return '#adb5bd';
                                }
                            }
                        }
                    ],

                    styles: {
                        header: {
                            fontSize: 18,


                            margin: [0, 0, 0, 20]
                        },
                        tableHeader: {
                            bold: true,
                            fontSize: 10,
                            color: '#ffffff',
                            alignment: 'center'
                        },
                        statsBox: {
                            fontSize: 12,
                            bold: true,
                            margin: [5, 10, 5, 10]
                        }
                    },

                    defaultStyle: {
                        fontSize: 8,
                        columnGap: 5
                    }
                };

                // Generar y descargar el PDF
                const fileName = `usuarios_${getCurrentDate()}_${new Date().getTime()}.pdf`;

                pdfMake.createPdf(docDefinition).download(fileName);

                console.log('PDF generado exitosamente con pdfMake:', fileName);

            } catch (error) {
                console.error('Error al generar PDF con pdfMake:', error);

                // Fallback más detallado
                if (confirm('Error al generar el PDF. ¿Desea usar la función de imprimir como alternativa?')) {
                    printTable();
                }
            }
        }

        // Función alternativa más simple para pdfMake
        function exportToPDFSimple() {
            try {
                if (typeof pdfMake === 'undefined') {
                    throw new Error('pdfMake no está disponible');
                }

                const data = table.rows({
                    search: 'applied'
                }).data().toArray();

                // Crear contenido simple
                const content = [{
                        text: 'LISTA DE USUARIOS - CRIMANAGER',
                        style: 'header'
                    },
                    {
                        text: `Fecha: ${new Date().toLocaleDateString()}`,
                        margin: [0, 0, 0, 20]
                    },
                    {
                        text: 'Usuarios:',
                        style: 'subheader'
                    }
                ];

                // Agregar usuarios de forma simple
                data.forEach((row, index) => {
                    const userInfo = [
                        `${index + 1}. ${$(row[1]).text().trim()}`,
                        `   Email: ${$(row[4]).text().trim()}`,
                        `   Estado: ${$(row[7]).find('.status-badge').text().trim()}`,
                        ' ' // Espacio
                    ];

                    userInfo.forEach(line => {
                        content.push({
                            text: line,
                            fontSize: 10
                        });
                    });
                });

                const docDefinition = {
                    content: content,
                    styles: {
                        header: {
                            fontSize: 16,
                            bold: true,
                            alignment: 'center',
                            margin: [0, 0, 0, 20]
                        },
                        subheader: {
                            fontSize: 12,
                            bold: true,
                            margin: [0, 10, 0, 10]
                        }
                    }
                };

                pdfMake.createPdf(docDefinition).download(`usuarios_simple_${getCurrentDate()}.pdf`);

            } catch (error) {
                console.error('Error en PDF simple:', error);
                alert('Error al generar PDF. Usando función de imprimir.');
                printTable();
            }
        }

        // Función para probar si pdfMake funciona correctamente
        function testPdfMake() {
            try {
                console.log('Probando pdfMake...');
                console.log('pdfMake disponible:', typeof pdfMake !== 'undefined');

                if (typeof pdfMake !== 'undefined') {
                    console.log('pdfMake versión:', pdfMake.version || 'Versión no disponible');

                    // Test simple
                    const testDoc = {
                        content: [{
                                text: 'Test PDF',
                                fontSize: 16
                            },
                            {
                                text: 'Si ves esto, pdfMake funciona correctamente.'
                            }
                        ]
                    };

                    console.log('Creando PDF de prueba...');
                    pdfMake.createPdf(testDoc).download('test.pdf');
                    return true;
                } else {
                    console.error('pdfMake no está definido');
                    return false;
                }
            } catch (error) {
                console.error('Error en test de pdfMake:', error);
                return false;
            }
        }

        // Agregar un botón de test (opcional, para debugging)
        function addTestButton() {
            const testBtn = document.createElement('button');
            testBtn.textContent = 'Test PDF';
            testBtn.className = 'btn btn-info btn-sm';
            testBtn.onclick = testPdfMake;

            // Agregar al final de los filtros
            document.querySelector('.filter-row').appendChild(testBtn);
        }

        // Función para imprimir tabla
        function printTable() {
            const data = table.rows({
                search: 'applied'
            }).data().toArray();

            let printContent = `
                <html>
                <head>
                    <title>Lista de Usuarios</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; font-weight: bold; }
                        .header { text-align: center; margin-bottom: 20px; }
                        .date { text-align: right; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>LISTA DE USUARIOS DEL SISTEMA</h1>
                        <h2>CRIMANAGER</h2>
                    </div>
                    <div class="date">Fecha: ${new Date().toLocaleDateString()}</div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>CI/DNI</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Roles</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            data.forEach(row => {
                const cleanRow = [
                    $(row[0]).text().trim(),
                    $(row[1]).text().trim(),
                    $(row[2]).text().trim(),
                    $(row[4]).text().trim(),
                    $(row[5]).text().trim(),
                    $(row[6]).text().trim(),
                    $(row[7]).find('.status-badge').text().trim()
                ];

                printContent += '<tr>';
                cleanRow.forEach(cell => {
                    printContent += `<td>${cell}</td>`;
                });
                printContent += '</tr>';
            });

            printContent += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        }

        // Función auxiliar para descargar archivos
        function downloadFile(blob, filename) {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        // Función auxiliar para obtener fecha actual
        function getCurrentDate() {
            return new Date().toISOString().split('T')[0];
        }

        // Función para auto-ocultar alertas
        function autoHideAlerts() {
            setTimeout(() => {
                $('.alert-enhanced').fadeOut('slow');
            }, 5000);
        }

        // Función para configurar lazy loading
        function setupLazyLoading() {
            const images = document.querySelectorAll('.profile-image:not(.loaded)');

            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.classList.add('loaded');
                            observer.unobserve(img);
                        }
                    });
                });

                images.forEach(img => imageObserver.observe(img));
            }
        }

        // Función para mostrar modal de imagen
        function showImageModal(imageSrc, userName) {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            document.getElementById('modal-image').src = imageSrc;
            document.getElementById('modal-name').textContent = userName;
            modal.show();
        }

        // Función para mostrar detalles del usuario
        function showUserDetails(userId) {
            const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
            const loadingEl = document.getElementById('details-loading');
            const contentEl = document.getElementById('user-details-content');

            // Mostrar loading
            loadingEl.style.display = 'block';
            contentEl.style.display = 'none';

            modal.show();

            // Simular carga de datos (aquí harías una petición AJAX real)
            setTimeout(() => {
                const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);
                const userData = extractUserDataFromRow(userRow);

                contentEl.innerHTML = generateUserDetailsHTML(userData);
                loadingEl.style.display = 'none';
                contentEl.style.display = 'block';
            }, 1000);
        }

        // Función para extraer datos del usuario de la fila
        function extractUserDataFromRow(row) {
            const cells = row.querySelectorAll('td');
            return {
                id: cells[0].textContent.trim(),
                name: cells[1].textContent.trim(),
                ci: cells[2].textContent.trim(),
                image: cells[3].querySelector('img').src,
                email: cells[4].textContent.trim(),
                phone: cells[5].textContent.trim(),
                roles: cells[6].textContent.trim(),
                status: cells[7].querySelector('.status-badge').textContent.trim()
            };
        }

        // Función para generar HTML de detalles del usuario
        function generateUserDetailsHTML(userData) {
            return `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="${userData.image}" alt="Foto de ${userData.name}" 
                             class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                        <h5>${userData.name}</h5>
                        <p class="text-muted">ID: ${userData.id}</p>
                    </div>
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>CI/DNI:</strong></div>
                            <div class="col-sm-8">${userData.ci}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Email:</strong></div>
                            <div class="col-sm-8">
                                <a href="mailto:${userData.email}">${userData.email}</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Teléfono:</strong></div>
                            <div class="col-sm-8">
                                <a href="tel:${userData.phone}">${userData.phone}</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Rol(es):</strong></div>
                            <div class="col-sm-8">${userData.roles}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Estado:</strong></div>
                            <div class="col-sm-8">${userData.status}</div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Función para confirmar eliminación
        function confirmDelete(userId, userName) {
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            document.getElementById('confirm-message').innerHTML =
                `¿Está seguro de que desea eliminar al usuario <strong>${userName}</strong>?<br>
                <small class="text-muted">Esta acción no se puede deshacer.</small>`;

            document.getElementById('confirm-action').onclick = function() {
                deleteUser(userId);
                modal.hide();
            };

            modal.show();
        }

        // Función para eliminar usuario (simulada)
        function deleteUser(userId) {
            // Mostrar loading en el botón
            const userRow = document.querySelector(`tr[data-user-id="${userId}"]`);
            const deleteBtn = userRow.querySelector('.btn-delete');
            const originalContent = deleteBtn.innerHTML;

            deleteBtn.innerHTML = '<div class="spinner"></div>';
            deleteBtn.disabled = true;

            // Simular petición AJAX
            setTimeout(() => {
                showAlert('Usuario eliminado correctamente', 'success');
                userRow.remove();
                updateStatistics();
            }, 2000);
        }

        // Función para mostrar alertas
        function showAlert(message, type) {
            const alertEl = document.createElement('div');
            alertEl.className = `alert alert-${type} alert-enhanced alert-dismissible fade show`;
            alertEl.setAttribute('role', 'alert');
            alertEl.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(alertEl);

            setTimeout(() => {
                alertEl.remove();
            }, 5000);
        }

        // Función para actualizar estadísticas
        function updateStatistics() {
            const totalRows = $('#usuarios-table tbody tr').length;
            const activeRows = $('#usuarios-table tbody tr:contains("Activo")').length;
            const inactiveRows = totalRows - activeRows;

            $('#total-count').text(totalRows);
            $('#active-count').text(activeRows);
            $('#inactive-count').text(inactiveRows);

            // Actualizar badges en el header
            $('#total-usuarios').text(`Total: ${totalRows} usuarios`);
            $('#usuarios-activos').text(`Activos: ${activeRows}`);
        }

        // Función para actualizar estadísticas filtradas
        function updateFilteredStatistics(table) {
            const info = table.page.info();
            const visibleRows = info.recordsDisplay;

            // Contar activos en los resultados filtrados
            let activeCount = 0;
            table.rows({
                page: 'current',
                search: 'applied'
            }).every(function() {
                const data = this.data();
                if (data[7] && data[7].includes('Activo')) {
                    activeCount++;
                }
            });

            $('#total-count').text(visibleRows);
            $('#active-count').text(activeCount);
            $('#inactive-count').text(visibleRows - activeCount);
        }

        // Función para búsqueda en tiempo real mejorada
        function enhancedSearch() {
            let searchTimeout;
            const searchInput = $('.dataTables_filter input');

            searchInput.off('keyup search input').on('keyup search input', function() {
                const searchTerm = this.value;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    table.search(searchTerm).draw();
                    updateFilteredStatistics(table);
                }, 300);
            });
        }

        // Función para manejar errores de carga de imágenes
        function handleImageErrors() {
            document.querySelectorAll('.profile-image').forEach(img => {
                img.addEventListener('error', function() {
                    this.src =
                        'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0zMiA0OEMzOC42Mjc0IDQ4IDQ0IDQyLjYyNzQgNDQgMzZDNDQgMjkuMzcyNiAzOC42Mjc0IDI0IDMyIDI0QzI1LjM3MjYgMjQgMjAgMjkuMzcyNiAyMCAzNkMyMCA0Mi42Mjc0IDI1LjM3MjYgNDggMzIgNDhaIiBmaWxsPSIjQ0REMkQ5Ii8+CjxwYXRoIGQ9Ik0zMiAzNkMzNS4zMTM3IDM2IDM4IDMzLjMxMzcgMzggMzBDMzggMjYuNjg2MyAzNS4zMTM3IDI0IDMyIDI0QzI4LjY4NjMgMjQgMjYgMjYuNjg2MyAyNiAzMEMyNiAzMy4zMTM3IDI4LjY4NjMgMzYgMzIgMzZaIiBmaWxsPSIjOUNBM0FGIi8+Cjwvc3ZnPg==';
                    this.classList.remove('loading');
                });
            });
        }

        // Función para animaciones de entrada
        function animateCards() {
            const cards = document.querySelectorAll('.stat-card, .main-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Función de accesibilidad - navegación por teclado
        document.addEventListener('keydown', function(e) {
            // Ctrl + F para enfocar búsqueda
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.querySelector('.dataTables_filter input').focus();
            }

            // Escape para cerrar modales
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    bootstrap.Modal.getInstance(modal)?.hide();
                });
            }
        });
    </script>
@stop

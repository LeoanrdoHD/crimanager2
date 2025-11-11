@extends('adminlte::page')

@section('title', 'Crimanager')

@section('content_header')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <h1 class="text-center">BUSCAR FICHA DE DELINCUENTES</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.min.css">

    <style>
        .search-container {
            background: #333536FF;
            border: 1px solid #242424FF;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 20px;
        }

        .filter-section {
            background: rgb(32, 32, 32);
            border: 1px ssolid #242424FF;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .filter-title {
            font-weight: 600;
            color: #FAF9F9FF;
            border-bottom: 2px solid #242424FF;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .btn-group-custom {
            gap: 8px;
        }

        .btn-outline-secondary:hover {
            background-color: #EEEEEEFF;
            border-color: #6c757d;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .criminal-photo {
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .action-buttons .btn {
            margin: 2px;
            font-size: 0.875rem;
        }

        .collapse-indicator {
            transition: transform 0.2s;
        }

        .collapsed .collapse-indicator {
            transform: rotate(-90deg);
        }

        .dt-buttons {
            display: none !important;
        }

        /* Placeholders en color blanco */
        .search-container input::placeholder,
        .search-container select option:first-child,
        .filter-section input::placeholder,
        .filter-section select option:first-child {
            color: #ffffff !important;
            opacity: 0.8;
        }

        .search-container input::-webkit-input-placeholder,
        .filter-section input::-webkit-input-placeholder {
            color: #ffffff !important;
            opacity: 0.8;
        }

        .search-container input::-moz-placeholder,
        .filter-section input::-moz-placeholder {
            color: #ffffff !important;
            opacity: 0.8;
        }

        .search-container input:-ms-input-placeholder,
        .filter-section input:-ms-input-placeholder {
            color: #ffffff !important;
            opacity: 0.8;
        }

        .search-container input:-moz-placeholder,
        .filter-section input:-moz-placeholder {
            color: #ffffff !important;
            opacity: 0.8;
        }

        /* Inputs con texto blanco */
        .search-container input,
        .search-container select,
        .filter-section input,
        .filter-section select {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .search-container input:focus,
        .search-container select:focus,
        .filter-section input:focus,
        .filter-section select:focus {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25) !important;
        }

        /* Opciones de select */
        .search-container select option,
        .filter-section select option {
            background-color: #495057 !important;
            color: #ffffff !important;
        }

        /* Botones grises a negros con letras blancas */
        .btn-outline-secondary,
        .btn-secondary {
            background-color: #000000 !important;
            border-color: #000000 !important;
            color: #ffffff !important;
        }

        .btn-outline-secondary:hover,
        .btn-outline-secondary:focus,
        .btn-outline-secondary:active,
        .btn-secondary:hover,
        .btn-secondary:focus,
        .btn-secondary:active {
            background-color: #333333 !important;
            border-color: #333333 !important;
            color: #ffffff !important;
        }

        /* Botón de filtros avanzados */
        .btn-group-custom .btn-outline-secondary {
            background-color: #000000 !important;
            border-color: #000000 !important;
            color: #ffffff !important;
        }

        /* Botón limpiar */
        #clearFilters {
            background-color: #000000 !important;
            border-color: #000000 !important;
            color: #ffffff !important;
        }

        /* Botón configurar columnas */
        .btn[data-bs-target="#columnToggleModal"] {
            background-color: #000000 !important;
            border-color: #000000 !important;
            color: #ffffff !important;
        }

        /* Indicador de colapso */
        .collapse-indicator {
            color: #ffffff !important;
        }

        /* Labels en blanco */
        .search-container .form-label,
        .filter-section .form-label,
        .filter-title {
            color: #ffffff !important;
        }

        /* Títulos de secciones */
        .search-container h5,
        .search-container h6 {
            color: #ffffff !important;
        }

        /* Para inputs de fecha */
        .search-container input[type="date"],
        .filter-section input[type="date"] {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .search-container input[type="date"]::-webkit-calendar-picker-indicator,
        .filter-section input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        /* Para inputs de número */
        .search-container input[type="number"],
        .filter-section input[type="number"] {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
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

        /* Toast notifications */
        .toast {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 9999 !important;
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


        /* Botón "Todos" en la paginación */
        .btn-show-all {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            margin-left: 8px;
            transition: all 0.15s ease-in-out;
        }

        .btn-show-all:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

            .container-fluid{
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
    @if (session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Tabla de criminales -->
    <div class="container-fluid">
        <!-- Panel de Filtros Avanzados -->
        <div class="search-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-search me-2"></i>Filtros de Búsqueda
                </h5>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#advancedFilters" aria-expanded="false">
                    <span class="collapse-indicator">▼</span> Filtros Avanzados
                </button>
            </div>

            <!-- Filtros básicos (siempre visibles) -->
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label class="form-label">Búsqueda General</label>
                    <input type="text" id="globalSearch" class="form-control" placeholder="Buscar en toda la tabla...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" id="filterName" class="form-control" placeholder="Filtrar por nombre">
                </div>
                <div class="col-md-3">
                    <label class="form-label">CI/DNI</label>
                    <input type="text" id="filterCI" class="form-control" placeholder="Filtrar por CI/DNI">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Alias</label>
                    <input type="text" id="filterAlias" class="form-control" placeholder="Filtrar por alias">
                </div>
            </div>

            <!-- Filtros avanzados (colapsables) -->
            <div class="collapse" id="advancedFilters">
                <div class="filter-section">
                    <h6 class="filter-title">Datos Personales</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Nacionalidad</label>
                            <select id="filterNationality" class="form-select">
                                <option value="">Todas las nacionalidades</option>
                                @foreach ($nacionalidad as $nationality)
                                    <option value="{{ $nationality->nationality_name }}">
                                        {{ $nationality->nationality_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Edad (Desde)</label>
                            <input type="number" id="filterAgeFrom" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Edad (Hasta)</label>
                            <input type="number" id="filterAgeTo" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ocupación/Profesión</label>
                            <select id="filterProfession" class="form-select">
                                <option value="">Todas las ocupaciones</option>
                                @foreach ($ocupacion as $ocupation)
                                    <option value="{{ $ocupation->ocupation_name }}">{{ $ocupation->ocupation_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <h6 class="filter-title">Información Criminal</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Especialidad/Motivo de Captura</label>
                            <select id="filterSpecialty" class="form-select">
                                <option value="">Todas las especialidades</option>
                                @foreach ($cri_esp as $criminal_specialties)
                                    <option value="{{ $criminal_specialties->specialty_name }}">
                                        {{ $criminal_specialties->specialty_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Situación Legal</label>
                            <select id="filterLegalStatus" class="form-select">
                                <option value="">Todas las situaciones</option>
                                @foreach ($t_aprehe as $apprehension_types)
                                    <option value="{{ $apprehension_types->type_name }}">
                                        {{ $apprehension_types->type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Lugar de Captura</label>
                            <input type="text" id="filterCaptureLocation" class="form-control"
                                placeholder="Filtrar por lugar">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Captura</label>
                            <input type="date" id="filterCaptureDate" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <h6 class="filter-title">Organización</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Pertenece a Organización</label>
                            <input type="text" id="filterOrganization" class="form-control"
                                placeholder="Filtrar por organización">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Rol en Organización</label>
                            <input type="text" id="filterRole" class="form-control" placeholder="Filtrar por rol">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Actividad</label>
                            <input type="text" id="filterActivity" class="form-control"
                                placeholder="Filtrar por actividad">
                        </div>
                    </div>
                </div>
            </div>


            <!-- Botones de acción - Versión Simple y Responsiva -->
            <div class="mt-3">
                <div class="row g-2">
                    <!-- Botones principales -->
                    <div class="col-6 col-md-auto">
                        <button type="button" id="applyFilters" class="btn btn-primary w-100">
                            <i class="fas fa-search d-md-none"></i>
                            <span class="d-none d-md-inline">Aplicar Filtros</span>
                            <span class="d-md-none">Aplicar</span>
                        </button>
                    </div>
                    <div class="col-6 col-md-auto">
                        <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times d-md-none"></i>
                            <span class="d-none d-md-inline">Limpiar</span>
                            <span class="d-md-none">Limpiar</span>
                        </button>
                    </div>

                    <!-- Botones secundarios -->
                    <div class="col-6 col-md-auto">
                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal"
                            data-bs-target="#columnToggleModal">
                            <i class="fas fa-columns d-md-none"></i>
                            <span class="d-none d-md-inline">Configurar Columnas</span>
                            <span class="d-md-none">Columnas</span>
                        </button>
                    </div>
                    <div class="col-6 col-md-auto ms-md-auto">
                        <button type="button" id="exportBtn" class="btn btn-success w-100">
                            <i class="fas fa-download d-md-none"></i>
                            <span class="d-none d-md-inline">Exportar</span>
                            <span class="d-md-none">Exportar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de configuración de columnas -->
        <div class="modal fade" id="columnToggleModal" tabindex="-1" aria-labelledby="columnToggleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="columnToggleModalLabel">
                            <i class="fas fa-columns me-2"></i>Seleccionar columnas a mostrar
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" id="selectNoneColumns"
                                    class="btn btn-sm btn-outline-secondary me-2">
                                    Deseleccionar Todas
                                </button>
                                <button type="button" id="selectBasicColumns" class="btn btn-sm btn-outline-info">
                                    Solo Básicas
                                </button>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <!-- Columnas básicas -->
                            <div class="col">
                                <h6 class="text-primary border-bottom pb-2">Información Básica</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="0"
                                        checked>
                                    <label class="form-check-label">Nro.</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="1"
                                        checked>
                                    <label class="form-check-label">Nombre</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="2"
                                        checked>
                                    <label class="form-check-label">Apellido</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="3"
                                        checked>
                                    <label class="form-check-label">CI o DNI</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="4"
                                        checked>
                                    <label class="form-check-label">Alias</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="5"
                                        checked>
                                    <label class="form-check-label">Fotografía</label>
                                </div>
                            </div>

                            <!-- Información Personal -->
                            <div class="col">
                                <h6 class="text-info border-bottom pb-2">Información Personal</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="9">
                                    <label class="form-check-label">Edad</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="10">
                                    <label class="form-check-label">Estatura</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="11">
                                    <label class="form-check-label">Peso</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="12">
                                    <label class="form-check-label">Nacionalidad</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="13">
                                    <label class="form-check-label">Complexión</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="14">
                                    <label class="form-check-label">Características Particulares</label>
                                </div>
                            </div>

                            <!-- Información Criminal -->
                            <div class="col">
                                <h6 class="text-warning border-bottom pb-2">Información Criminal</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="6"
                                        checked>
                                    <label class="form-check-label">Historial de Capturas</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="19">
                                    <label class="form-check-label">Especialidad</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="23">
                                    <label class="form-check-label">Lugar de Captura</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="24">
                                    <label class="form-check-label">Tipo de Registro</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="25">
                                    <label class="form-check-label">Situación Legal</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="33">
                                    <label class="form-check-label">Detalle de Captura</label>
                                </div>
                            </div>

                            <!-- Organización -->
                            <div class="col">
                                <h6 class="text-danger border-bottom pb-2">Organización</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="7"
                                        checked>
                                    <label class="form-check-label">Pertenece a</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="20">
                                    <label class="form-check-label">Actividad de la Organización</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="21">
                                    <label class="form-check-label">Rol en una Organización</label>
                                </div>
                            </div>

                            <!-- Contacto y Ubicación -->
                            <div class="col">
                                <h6 class="text-success border-bottom pb-2">Contacto y Ubicación</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="15">
                                    <label class="form-check-label">Celular</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="17">
                                    <label class="form-check-label">Dirección</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="16">
                                    <label class="form-check-label">Prisión</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="18">
                                    <label class="form-check-label">Profesión</label>
                                </div>
                            </div>

                            <!-- Otros datos -->
                            <div class="col">
                                <h6 class="text-secondary border-bottom pb-2">Otros Datos</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="22">
                                    <label class="form-check-label">Placa de Vehículo</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="26">
                                    <label class="form-check-label">Nro. CUD</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="27">
                                    <label class="form-check-label">Tipo de Condena</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="28">
                                    <label class="form-check-label">Otros Nombres</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="29">
                                    <label class="form-check-label">Otros CI</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="30">
                                    <label class="form-check-label">Otra Nacionalidad</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="31">
                                    <label class="form-check-label">Nombre Cómplice</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="32">
                                    <label class="form-check-label">CI Cómplice</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input column-toggle" type="checkbox" data-column="8"
                                        checked>
                                    <label class="form-check-label">Acciones</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="applyColumns" class="btn btn-primary">Aplicar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover" id="criminales">
                    <thead>
                        <tr>
                            <th scope="col">Nro.</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">CI o DNI</th>
                            <th scope="col">Alias</th>
                            <th scope="col">Fotografía</th>
                            <th scope="col">Historial de Capturas</th>
                            <th scope="col">Pertenece a:</th>
                            <th scope="col">Acciones</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Estatura</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Nacionalidad</th>
                            <th scope="col">Complexión</th>
                            <th scope="col">Características Particulares</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Prisión</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Profesión</th>
                            <th scope="col">Especialidad</th>
                            <th scope="col">Actividad de la Organización</th>
                            <th scope="col">Rol en una Organización</th>
                            <th scope="col">Placa de Vehículo</th>
                            <th scope="col">Lugar de Captura</th>
                            <th scope="col">Tipo de Registro</th>
                            <th scope="col">Situación Legal</th>
                            <th scope="col">Nro. CUD</th>
                            <th scope="col">Tipo de Condena</th>
                            <th scope="col">Otros Nombres</th>
                            <th scope="col">Otros CI</th>
                            <th scope="col">Otra Nacionalidad</th>
                            <th scope="col">Nombre Cómplice</th>
                            <th scope="col">CI Cómplice</th>
                            <th scope="col">Detalle Captura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($crimi as $criminals)
                            <tr>
                                <td>{{ $criminals->id }}</td>
                                <td>{{ $criminals->first_name }}</td>
                                <td>{{ $criminals->last_nameP }} {{ $criminals->last_nameM }}</td>
                                <td>{{ $criminals->identity_number }}</td>
                                <td>{{ $criminals->alias_name }}</td>
                                <td>
                                    @php
                                        $ultimaFoto = $fotos->where('criminal_id', $criminals->id)->last();
                                    @endphp
                                    @if ($ultimaFoto)
                                        <img src="{{ asset($ultimaFoto->face_photo) }}" width="60" height="60"
                                            alt="Foto" class="criminal-photo" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#photoModal_{{ $criminals->id }}">
                                    @else
                                        <div class="text-muted small">Sin foto</div>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            <a href="{{ route('criminals.history', ['criminal_id' => $criminals->id, 'history_id' => $arrest_and_apprehension_histories->id]) }}"
                                                class="badge bg-info text-decoration-none me-1 mb-1">
                                                {{ \Carbon\Carbon::parse($arrest_and_apprehension_histories->arrest_date)->format('d-m-Y') }}
                                            </a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($orga as $criminal_organization)
                                        @if ($criminal_organization->criminal_id === $criminals->id)
                                            <span>
                                                {{ $criminal_organization->organization->organization_name }}
                                            </span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/criminals/search_cri/{{ $criminals->id }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        @can('agregar.criminal')
                                            <a href="arrest/show_file/{{ $criminals->id }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-plus"></i> Agregar
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                                <td>{{ $criminals->age ?? 'N/A' }}</td>
                                <td>
                                    @forelse ($criminals->physicalCharacteristics as $characteristic)
                                        {{ $characteristic->height }} cm
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($criminals->physicalCharacteristics as $characteristic)
                                        {{ $characteristic->weight ?? 'N/A' }} kg
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>{{ $criminals->nationality->nationality_name ?? 'N/A' }}</td>
                                <td>
                                    @forelse ($criminals->physicalCharacteristics as $characteristic)
                                        {{ $characteristic->confleccion->conflexion_name ?? 'N/A' }}
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($criminals->physicalCharacteristics as $characteristic)
                                        {{ $characteristic->distinctive_marks ?? 'N/A' }}
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>
                                    @foreach ($phone_cri as $criminal_phone_number)
                                        @if ($criminal_phone_number->criminal_id === $criminals->id)
                                            <span
                                                class="badge bg-secondary mb-1">{{ $criminal_phone_number->phone_number }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($criminals->prision as $prison)
                                        {{ $prison->prison_name }}
                                    @endforeach
                                </td>
                                <td>
                                    @forelse ($criminals->criminalAddresses as $address)
                                        {{ $address->street }}
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>{{ $criminals->occupation->ocupation_name ?? 'N/A' }}</td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            <span
                                                class="badge bg-danger mb-1">{{ $arrest_and_apprehension_histories->criminalSpecialty->specialty_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($orga as $criminal_organization)
                                        @if ($criminal_organization->criminal_id === $criminals->id)
                                            {{ $criminal_organization->organization->Criminal_Organization_Specialty }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($orga as $criminal_organization)
                                        @if ($criminal_organization->criminal_id === $criminals->id)
                                            {{ $criminal_organization->criminal_rol }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($vehicle as $criminal_vehicle)
                                        @if ($criminal_vehicle->criminal_id === $criminals->id)
                                            <span class="badge bg-info">{{ $criminal_vehicle->license_plate }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            {{ $arrest_and_apprehension_histories->arrest_location }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            @if ($arrest_and_apprehension_histories->apprehensionType)
                                                <span
                                                    class="badge bg-primary">{{ $arrest_and_apprehension_histories->apprehensionType->type_name }}</span>
                                            @else
                                                N/A
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            <span
                                                class="status-badge badge bg-{{ $arrest_and_apprehension_histories->legalStatus->status_name == 'Libre' ? 'success' : 'warning' }}">
                                                {{ $arrest_and_apprehension_histories->legalStatus->status_name }}
                                            </span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            {{ $arrest_and_apprehension_histories->cud_number ?? 'N/A' }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($condena as $conviction)
                                        @if ($conviction->criminal_id === $criminals->id)
                                            <span
                                                class="badge bg-dark">{{ $conviction->detentionType->detention_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($aliase as $criminal_o_identidades)
                                        @if ($criminal_o_identidades->criminal_id === $criminals->id)
                                            <span
                                                class="badge bg-secondary mb-1">{{ $criminal_o_identidades->alias_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($aliase as $criminal_o_identidades)
                                        @if ($criminal_o_identidades->criminal_id === $criminals->id)
                                            {{ $criminal_o_identidades->alias_identity_number }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($aliase as $criminal_o_identidades)
                                        @if ($criminal_o_identidades->criminal_id === $criminals->id)
                                            {{ $criminal_o_identidades->nationality->nationality_name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($complice as $criminalComplice)
                                        @if ($criminalComplice->criminal_id === $criminals->id)
                                            <span>{{ $criminalComplice->complice_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($complice as $criminalComplice)
                                        @if ($criminalComplice->criminal_id === $criminals->id)
                                            {{ $criminalComplice->CI_complice }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($history_cri as $arrest_and_apprehension_histories)
                                        @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                            <div class="small">
                                                {{ Str::limit($arrest_and_apprehension_histories->arrest_details, 50) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            @if ($ultimaFoto)
                                <div class="modal fade" id="photoModal_{{ $criminals->id }}" tabindex="-1"
                                    aria-labelledby="photoModalLabel_{{ $criminals->id }}" aria-hidden="true"
                                    data-criminal-index="{{ $loop->index }}">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content bg-dark">
                                            <div class="modal-header border-secondary">
                                                <h5 class="modal-title text-success"
                                                    id="photoModalLabel_{{ $criminals->id }}">
                                                    <i class="fas fa-user me-2"></i>{{ $criminals->first_name }}
                                                    {{ $criminals->last_nameP }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body text-center p-2 position-relative">
                                                <!-- Botón Anterior -->
                                                <button type="button"
                                                    class="btn btn-outline-light btn-sm position-absolute top-50 start-0 translate-middle-y ms-2 modal-nav-btn"
                                                    data-direction="prev" style="z-index: 10;">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>

                                                <!-- Imagen -->
                                                <img src="{{ asset($ultimaFoto->face_photo) }}"
                                                    class="img-fluid rounded shadow" alt="Fotografía de Rostro"
                                                    style="max-height: 70vh; object-fit: contain;">

                                                <!-- Botón Siguiente -->
                                                <button type="button"
                                                    class="btn btn-outline-light btn-sm position-absolute top-50 end-0 translate-middle-y me-2 modal-nav-btn"
                                                    data-direction="next" style="z-index: 10;">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>

                                                <div class="mt-3">
                                                    <p class="text-light mb-1">
                                                        <strong>{{ $criminals->first_name }}
                                                            {{ $criminals->last_nameP }}</strong>
                                                    </p>
                                                    <small class="text-muted">
                                                        Fotografía Rostro | Fecha del registro:
                                                        {{ \Carbon\Carbon::parse($ultimaFoto->created_at)->format('d/m/Y') }}
                                                    </small>

                                                    <!-- Indicador de posición -->
                                                    <div class="mt-2">
                                                        <small class="text-info modal-navigation-indicator">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            {{ $loop->iteration }} de {{ $loop->count }} | Usa ← → para
                                                            navegar
                                                        </small>
                                                    </div>

                                                    <!-- Botón Ver Historial -->
                                                    <div class="mt-3">
                                                        <a href="/criminals/search_cri/{{ $criminals->id }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye me-1"></i> Ver Historial
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="/js/export_criminals.js"></script>

    <script>
        $(document).ready(function() {
            // Variables globales para modal navigation
            let photoModals = [];
            let currentModalIndex = 0;
            let table; // Variable para la instancia de DataTable

            // Inicialización de DataTables
            table = $('#criminales').DataTable({
                responsive: true,
                colReorder: true,
                // dom y buttons eliminados, solo exportación personalizada
                columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        visible: true
                    },
                    {
                        targets: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
                            27, 28, 29, 30, 31, 32, 33
                        ],
                        visible: false
                    }
                ],
                language: {
                    decimal: ",",
                    emptyTable: "No hay datos disponibles en la tabla",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                    infoFiltered: "(filtrado de _MAX_ entradas totales)",
                    thousands: ".",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron registros coincidentes",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "Todos"]
                ],
                order: [
                    [0, 'desc']
                ]
            });

            // ==============================
            // FUNCIÓN PARA ACTUALIZAR MODALES SEGÚN FILTROS
            // ==============================
            function updatePhotoModalsFromFilteredData() {
                photoModals = [];

                console.log('Actualizando modales desde datos filtrados...');

                // Obtener solo las filas visibles (filtradas) de la tabla
                const visibleRows = table.rows({
                    filter: 'applied',
                    page: 'all' // Importante: incluir todas las páginas filtradas
                }).nodes();

                console.log('Filas visibles encontradas:', visibleRows.length);

                $(visibleRows).each(function(index, row) {
                    const imgElement = $(row).find('img[data-bs-target^="#photoModal_"]');
                    if (imgElement.length > 0) {
                        const modalId = imgElement.attr('data-bs-target');
                        if (modalId) {
                            const modalElement = document.querySelector(modalId);
                            if (modalElement) {
                                photoModals.push({
                                    element: modalElement,
                                    index: index,
                                    id: modalElement.id,
                                    row: row,
                                    criminalName: $(row).find('td:nth-child(2)').text() + ' ' + $(
                                        row).find('td:nth-child(3)').text()
                                });
                            }
                        }
                    }
                });

                console.log('Modales de fotos actualizados:', photoModals.length);

                // Actualizar indicadores de navegación en modales abiertos
                updateNavigationIndicators();
            }

            // ==============================
            // FUNCIÓN PARA ACTUALIZAR INDICADORES DE NAVEGACIÓN
            // ==============================
            function updateNavigationIndicators() {
                const activeModal = document.querySelector('.modal.show');
                if (activeModal && photoModals.length > 0) {
                    const currentModalId = activeModal.id;
                    const currentIndex = photoModals.findIndex(modal => modal.id === currentModalId);

                    if (currentIndex !== -1) {
                        const indicator = $(activeModal).find('.modal-navigation-indicator');
                        if (indicator.length) {
                            const totalRows = table.rows().count();
                            const isFiltered = photoModals.length < totalRows;

                            indicator.html(`
                                <i class="fas fa-info-circle me-1"></i>
                                ${currentIndex + 1} de ${photoModals.length} | Usa ← → para navegar
                                ${isFiltered ? '<br><small class="text-warning">(Resultados filtrados)</small>' : ''}
                            `);
                        }
                    }
                }
            }

            // ==============================
            // FUNCIÓN PARA NAVEGAR ENTRE MODALES
            // ==============================
            function navigateModal(direction) {
                const currentModal = bootstrap.Modal.getInstance(document.querySelector('.modal.show'));
                if (!currentModal || photoModals.length === 0) {
                    console.log('No hay modal activo o no hay modales disponibles');
                    return;
                }

                const currentModalId = document.querySelector('.modal.show').id;
                currentModalIndex = photoModals.findIndex(modal => modal.id === currentModalId);

                if (currentModalIndex === -1) {
                    console.log('Modal actual no encontrado en la lista');
                    return;
                }

                let nextIndex;
                if (direction === 'next') {
                    nextIndex = (currentModalIndex + 1) % photoModals.length;
                } else {
                    nextIndex = (currentModalIndex - 1 + photoModals.length) % photoModals.length;
                }

                console.log(`Navegando ${direction}: de ${currentModalIndex} a ${nextIndex}`);

                // Cerrar modal actual
                currentModal.hide();

                // Abrir siguiente modal después de que se cierre el actual
                setTimeout(() => {
                    const nextModal = new bootstrap.Modal(photoModals[nextIndex].element);
                    nextModal.show();
                }, 150);
            }

            // ==============================
            // EVENT LISTENERS PARA NAVEGACIÓN DE MODALES
            // ==============================

            // Event listeners para botones de navegación
            $(document).on('click', '.modal-nav-btn', function(e) {
                e.preventDefault();
                const direction = $(this).data('direction');
                console.log('Click en botón de navegación:', direction);
                navigateModal(direction);
            });

            // Navegación con teclado
            $(document).on('keydown', function(e) {
                if (document.querySelector('.modal.show')) {
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        console.log('Navegación con teclado: izquierda');
                        navigateModal('prev');
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        console.log('Navegación con teclado: derecha');
                        navigateModal('next');
                    }
                }
            });

            // ==============================
            // ACTUALIZAR MODALES CUANDO CAMBIE LA TABLA
            // ==============================
            table.on('draw', function() {
                console.log('Tabla redibujada, actualizando modales...');
                // Actualizar la lista de modales cada vez que se redibuje la tabla
                setTimeout(() => {
                    updatePhotoModalsFromFilteredData();
                }, 100);
            });

            // Inicializar modales al cargar la página
            setTimeout(() => {
                console.log('Inicializando modales...');
                updatePhotoModalsFromFilteredData();
            }, 500);

            // ==============================
            // ACTUALIZAR INDICADORES CUANDO SE ABRA UN MODAL
            // ==============================
            $(document).on('shown.bs.modal', '[id^="photoModal_"]', function() {
                console.log('Modal abierto, actualizando indicadores...');
                updateNavigationIndicators();
            });

            // ==============================
            // RESTO DE FUNCIONALIDAD DE DATATABLE
            // ==============================

            // Ocultar los botones por defecto de DataTables y usar los personalizados
            $('.dt-buttons').hide();

            // Filtro de búsqueda global personalizado
            $('#globalSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filtros por columna específica
            $('#filterName').on('keyup', function() {
                table.column(1).search(this.value).draw();
            });

            $('#filterCI').on('keyup', function() {
                table.column(3).search(this.value).draw();
            });

            $('#filterAlias').on('keyup', function() {
                table.column(4).search(this.value).draw();
            });

            // Filtros de selección (select)
            $('#filterProfession').on('change', function() {
                table.column(18).search(this.value).draw();
            });

            $('#filterSpecialty').on('change', function() {
                table.column(19).search(this.value).draw();
            });

            $('#filterNationality').on('change', function() {
                table.column(12).search(this.value).draw();
            });

            $('#filterLegalStatus').on('change', function() {
                table.column(25).search(this.value).draw();
            });

            $('#filterOrganization').on('keyup', function() {
                table.column(7).search(this.value).draw();
            });

            $('#filterRole').on('keyup', function() {
                table.column(21).search(this.value).draw();
            });

            $('#filterActivity').on('keyup', function() {
                table.column(20).search(this.value).draw();
            });

            $('#filterCaptureLocation').on('keyup', function() {
                table.column(23).search(this.value).draw();
            });

            // Filtro de rango de edad
            $('#filterAgeFrom, #filterAgeTo').on('keyup change', function() {
                table.draw();
            });

            // Filtro personalizado para rango de edad
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min = parseInt($('#filterAgeFrom').val(), 10);
                    var max = parseInt($('#filterAgeTo').val(), 10);
                    var age = parseFloat(data[9]) || 0; // Columna de edad (índice 9)

                    if ((isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && age <= max) ||
                        (min <= age && isNaN(max)) ||
                        (min <= age && age <= max)) {
                        return true;
                    }
                    return false;
                }
            );

            // Botón aplicar filtros
            $('#applyFilters').on('click', function() {
                table.draw();

                // Mostrar mensaje de confirmación
                const toast = $(
                        '<div class="toast align-items-center text-white bg-success border-0" role="alert">'
                    )
                    .html(
                        '<div class="d-flex"><div class="toast-body">Filtros aplicados correctamente</div></div>'
                    );

                $('body').append(toast);
                toast.toast({
                    delay: 3000
                }).toast('show');

                setTimeout(() => toast.remove(), 3500);
            });

            // Botón limpiar filtros
            $('#clearFilters').on('click', function() {
                $('#globalSearch, #filterName, #filterCI, #filterAlias, #filterOrganization, #filterRole, #filterActivity, #filterCaptureLocation, #filterAgeFrom, #filterAgeTo, #filterCaptureDate')
                    .val('');
                $('#filterNationality, #filterLegalStatus, #filterProfession, #filterSpecialty').val('');
                table.search('').columns().search('').draw();

                // Mostrar mensaje de confirmación
                const toast = $(
                        '<div class="toast align-items-center text-white bg-info border-0" role="alert">')
                    .html(
                        '<div class="d-flex"><div class="toast-body">Filtros limpiados correctamente</div></div>'
                    );

                $('body').append(toast);
                toast.toast({
                    delay: 2000
                }).toast('show');

                setTimeout(() => toast.remove(), 2500);
            });

            // Manejo de visibilidad de columnas
            $('.column-toggle').on('change', function() {
                const columnIndex = $(this).data('column');
                const column = table.column(columnIndex);
                column.visible($(this).is(':checked'));
            });

            // Botones de selección de columnas
            $('#selectAllColumns').on('click', function() {
                $('.column-toggle').prop('checked', true).trigger('change');
            });

            $('#selectNoneColumns').on('click', function() {
                $('.column-toggle').prop('checked', false).trigger('change');
            });

            $('#selectBasicColumns').on('click', function() {
                $('.column-toggle').prop('checked', false);
                $('[data-column="0"], [data-column="1"], [data-column="2"], [data-column="3"], [data-column="4"], [data-column="5"], [data-column="6"], [data-column="7"], [data-column="8"]')
                    .prop('checked', true).trigger('change');
            });

            // Aplicar cambios de columnas
            $('#applyColumns').on('click', function() {
                $('#columnToggleModal').modal('hide');

                const toast = $(
                        '<div class="toast align-items-center text-white bg-info border-0" role="alert">')
                    .html(
                        '<div class="d-flex"><div class="toast-body">Configuración de columnas aplicada</div></div>'
                    );

                $('body').append(toast);
                toast.toast({
                    delay: 3000
                }).toast('show');

                setTimeout(() => toast.remove(), 3500);
            });

            // Botón de exportar personalizado (adaptado a columnas dinámicas y exclusión de foto/acciones)
            $('#exportBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

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
                            Se exportarán solo las columnas visibles (sin fotografía ni acciones)
                        </div>
                    </div>
                `);

                const rect = this.getBoundingClientRect();
                exportMenu.css({
                    position: 'fixed',
                    top: rect.bottom + 5,
                    left: rect.left - 120,
                    minWidth: '200px'
                });

                $('body').append(exportMenu);

                exportMenu.find('[data-export]').on('click', function(e) {
                    e.preventDefault();
                    const exportType = $(this).data('export');

                    const loadingToast = $(
                        '<div class="toast align-items-center text-white bg-primary border-0" role="alert">'
                    ).html(
                        '<div class="d-flex"><div class="toast-body"><i class="fas fa-spinner fa-spin me-2"></i>Exportando...</div></div>'
                    );
                    $('body').append(loadingToast);
                    loadingToast.toast({
                        delay: 3000
                    }).toast('show');

                    setTimeout(() => {
                        switch (exportType) {
                            case 'excel':
                                window.criminalsExport.exportToExcel(table);
                                break;
                            case 'csv':
                                window.criminalsExport.exportToCSV(table);
                                break;
                            case 'pdf':
                                window.criminalsExport.exportToPDF(table);
                                break;
                            case 'print':
                                window.criminalsExport.printTable(table);
                                break;
                        }
                        loadingToast.remove();
                        const successToast = $(
                            '<div class="toast align-items-center text-white bg-success border-0" role="alert">'
                        ).html(
                            '<div class="d-flex"><div class="toast-body"><i class="fas fa-check me-2"></i>Exportación completada</div></div>'
                        );
                        $('body').append(successToast);
                        successToast.toast({
                            delay: 2000
                        }).toast('show');
                        setTimeout(() => successToast.remove(), 2500);
                    }, 500);
                    exportMenu.remove();
                });

                $(document).one('click', function(e) {
                    if (!$(e.target).closest('.export-dropdown-menu, #exportBtn').length) {
                        exportMenu.remove();
                    }
                });
            });

            // Auto-ocultar alerta de éxito
            setTimeout(function() {
                $('#success-alert').fadeOut();
            }, 5000);

            // Animación del indicador de colapso
            $('[data-bs-toggle="collapse"]').on('click', function() {
                $(this).find('.collapse-indicator').toggleClass('collapsed');
            });

            // Mejorar responsive de la tabla
            $(window).on('resize', function() {
                table.columns.adjust().responsive.recalc();
            });

            // Personalizar la paginación para incluir botón "Todos"
            $('.dataTables_paginate').each(function() {
                const paginateContainer = $(this);

                // Verificar si ya existe el botón "Todos"
                if (!paginateContainer.find('.btn-show-all').length) {
                    const showAllBtn = $(
                        '<button class="btn btn-sm btn-outline-secondary btn-show-all ms-2">Todos</button>'
                    );

                    showAllBtn.on('click', function(e) {
                        e.preventDefault();

                        if (table.page.len() === -1) {
                            // Si ya está mostrando todos, volver a la paginación normal
                            table.page.len(25).draw();
                            $(this).removeClass('btn-secondary').addClass('btn-outline-secondary')
                                .text('Todos');

                            // Toast de confirmación
                            const toast = $(
                                    '<div class="toast align-items-center text-white bg-info border-0" role="alert">'
                                )
                                .html(
                                    '<div class="d-flex"><div class="toast-body">Paginación restaurada (25 por página)</div></div>'
                                );

                            $('body').append(toast);
                            toast.toast({
                                delay: 2000
                            }).toast('show');
                            setTimeout(() => toast.remove(), 2500);
                        } else {
                            // Mostrar todos los registros
                            table.page.len(-1).draw();
                            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary')
                                .text('Paginado');

                            // Toast de confirmación
                            const toast = $(
                                    '<div class="toast align-items-center text-white bg-success border-0" role="alert">'
                                )
                                .html(
                                    '<div class="d-flex"><div class="toast-body">Mostrando todos los registros</div></div>'
                                );

                            $('body').append(toast);
                            toast.toast({
                                delay: 2000
                            }).toast('show');
                            setTimeout(() => toast.remove(), 2500);
                        }
                    });

                    paginateContainer.append(showAllBtn);
                }
            });

            // Re-agregar el botón después de cada redibujado de la tabla
            table.on('draw', function() {
                setTimeout(function() {
                    $('.dataTables_paginate').each(function() {
                        const paginateContainer = $(this);

                        if (!paginateContainer.find('.btn-show-all').length) {
                            const showAllBtn = $(
                                '<button class="btn btn-sm btn-outline-secondary btn-show-all ms-2">Todos</button>'
                            );

                            // Verificar el estado actual y ajustar el botón
                            if (table.page.len() === -1) {
                                showAllBtn.removeClass('btn-outline-secondary').addClass(
                                    'btn-secondary').text('Paginado');
                            }

                            showAllBtn.on('click', function(e) {
                                e.preventDefault();

                                if (table.page.len() === -1) {
                                    table.page.len(25).draw();
                                    $(this).removeClass('btn-secondary').addClass(
                                        'btn-outline-secondary').text('Todos');

                                    const toast = $(
                                            '<div class="toast align-items-center text-white bg-info border-0" role="alert">'
                                        )
                                        .html(
                                            '<div class="d-flex"><div class="toast-body">Paginación restaurada (25 por página)</div></div>'
                                        );

                                    $('body').append(toast);
                                    toast.toast({
                                        delay: 2000
                                    }).toast('show');
                                    setTimeout(() => toast.remove(), 2500);
                                } else {
                                    table.page.len(-1).draw();
                                    $(this).removeClass('btn-outline-secondary')
                                        .addClass('btn-secondary').text('Paginado');

                                    const toast = $(
                                            '<div class="toast align-items-center text-white bg-success border-0" role="alert">'
                                        )
                                        .html(
                                            '<div class="d-flex"><div class="toast-body">Mostrando todos los registros</div></div>'
                                        );

                                    $('body').append(toast);
                                    toast.toast({
                                        delay: 2000
                                    }).toast('show');
                                    setTimeout(() => toast.remove(), 2500);
                                }
                            });

                            paginateContainer.append(showAllBtn);
                        }
                    });
                }, 100);
            });
        });
    </script>
@stop

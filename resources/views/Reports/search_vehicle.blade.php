@extends('adminlte::page')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">
        BUSCAR POR VEHÍCULOS</h1>
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .vehicle-photos-thumb {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin: 2px;
            cursor: pointer;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }

        .vehicle-photos-thumb:hover {
            border-color: #007bff;
            transform: scale(1.05);
        }

        .photo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .vehicle-info-badge {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px;
            margin: 2px 0;
            font-size: 0.85em;
        }

        .modal-vehicle-photo {
            max-height: 70vh;
            object-fit: contain;
        }

        /* Asegurar que los modales se muestren correctamente */
        .modal {
            z-index: 1050;
        }

        .modal.show {
            z-index: 1055;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        /* Estilo para el placeholder del input de búsqueda */
        #search-input::placeholder {
            color: #e0e0e0 !important;
        }

        /* Estilos para badges de historial con y sin vehículos */
        .history-badge-with-vehicle {
            background-color: #17a2b8 !important;
            /* Celeste/Cyan */
            color: white !important;
            border: none;
        }

        .history-badge-with-vehicle:hover {
            background-color: #138496 !important;
            color: white !important;
        }

        .history-badge-without-vehicle {
            background-color: #dc3545 !important;
            /* Rojo */
            color: white !important;
            border: none;
        }

        .history-badge-without-vehicle:hover {
            background-color: #c82333 !important;
            color: white !important;
        }

        /* === ESTILOS RESPONSIVOS === */

        /* Contenedor principal responsivo */
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        @media (min-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* Controles superiores responsivos */
        .table-controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .table-controls {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .entries-control,
        .search-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 767px) {
            .search-control input {
                width: 100% !important;
                max-width: none !important;
            }
        }

        /* Tabla responsiva */
        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 1200px;
            /* Ancho mínimo para mantener estructura */
            margin-bottom: 0;
        }

        /* Adaptación de celdas en móviles */
        @media (max-width: 767px) {
            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 6px 4px;
                vertical-align: middle;
            }

            /* Fotos más pequeñas en móvil */
            .table img {
                width: 50px !important;
                height: 50px !important;
            }

            .vehicle-photos-thumb {
                width: 40px;
                height: 40px;
            }

            /* Badges más compactos */
            .badge {
                font-size: 0.65em;
                padding: 2px 6px;
            }

            /* Botones más compactos */
            .btn-sm {
                font-size: 0.7rem;
                padding: 2px 6px;
            }

            /* Info de vehículo más compacta */
            .vehicle-info-badge {
                font-size: 0.7em;
                padding: 4px 6px;
                margin: 1px 0;
            }
        }

        /* Cards responsivas para vista móvil alternativa */
        .mobile-card-view {
            display: none;
        }

        @media (max-width: 576px) {
            .table-responsive-custom {
                display: none;
            }

            .mobile-card-view {
                display: block;
            }

            .criminal-card {
                background: rgb(25, 25, 25);
                border-radius: 12px;
                margin-bottom: 20px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .criminal-header {
                background: linear-gradient(135deg, #000000 0%, #764ba2 100%);
                color: white;
                padding: 15px;
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .criminal-photo {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid white;
            }

            .criminal-info h5 {
                margin: 0;
                font-size: 1.1rem;
                font-weight: 600;
            }

            .criminal-info small {
                opacity: 0.9;
            }

            .criminal-body {
                padding: 0;
            }

            .vehicle-item {
                border-bottom: 1px solid #2d2d2d;
                padding: 15px;
            }

            .vehicle-item:last-child {
                border-bottom: none;
            }

            .vehicle-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }

            .vehicle-plate {
                background: #007bff;
                color: rgb(0, 0, 0);
                padding: 4px 12px;
                border-radius: 15px;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .vehicle-details {
                background: #033e79;
                padding: 10px;
                border-radius: 8px;
                margin-bottom: 10px;
            }

            .vehicle-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                align-items: center;
            }

            .history-badges {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-top: 10px;
            }
        }

        /* Paginación responsiva */
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin-top: 20px;
        }

        @media (min-width: 768px) {
            .pagination-wrapper {
                flex-direction: row;
                justify-content: space-between;
            }
        }

        .pagination {
            margin: 0;
        }

        @media (max-width: 576px) {
            .pagination {
                font-size: 0.8rem;
            }

            .pagination .page-link {
                padding: 4px 8px;
            }
        }

        /* Modales responsivos */
        @media (max-width: 767px) {
            .modal-dialog {
                margin: 10px;
                max-width: none;
                width: auto;
            }

            .modal-xl {
                max-width: none;
            }

            .modal-content {
                border-radius: 12px;
            }

            .modal-header {
                padding: 10px 15px;
            }

            .modal-title {
                font-size: 1rem;
            }

            .modal-body {
                padding: 15px;
            }

            .photo-grid {
                justify-content: center;
            }

            .vehicle-photos-thumb {
                width: 50px;
                height: 50px;
            }
        }

        /* Mejoras para scroll horizontal */
        .table-responsive-custom::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #a3a3a3;
            border-radius: 4px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Indicador de scroll */
        .scroll-indicator {
            text-align: center;
            padding: 10px;
            background: #e3f2fd;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 0.8rem;
            color: #1976d2;
            display: none;
        }

        @media (max-width: 991px) {
            .scroll-indicator {
                display: block;
            }
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
    </style>
@stop

@section('content')
    @if (session('success'))
        <div id="success-alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 10px 20px; background-color: #4caf50; color: white; border-radius: 5px;">
            {{ session('success') }}
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    document.getElementById('success-alert').style.display = 'none';
                }, 3000);
            });
        </script>
    @endif

    <!-- Tabla de criminales con vehículos -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <!-- Campo de búsqueda manual y selector de registros por página -->
                <div class="table-controls">
                    <div class="entries-control">
                        <label for="entries-select" class="form-label mb-0" style="color: #ffffff;">Mostrar:</label>
                        <select id="entries-select" class="form-select form-select-sm" style="width: auto;">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span style="color: #ffffff;">entradas</span>
                    </div>

                    <div class="search-control">
                        <label for="search-input" class="form-label mb-0" style="color: #ffffff;">Buscar:</label>
                        <div style="width: 300px;">
                            <input type="text" id="search-input" class="form-control"
                                placeholder="Ingrese los datos a buscar" style="color: white;">
                        </div>
                    </div>
                </div>

                <!-- Indicador de scroll para pantallas pequeñas -->
                <div class="scroll-indicator">
                    <i class="fas fa-hand-paper"></i> Desliza horizontalmente para ver más información
                </div>

                <!-- Vista de tabla (pantallas medianas y grandes) -->
                <div class="table-responsive-custom">
                    <table class="table" id="criminales">
                        <thead>
                            <tr>
                                <th scope="col">Nro.</th>
                                <th scope="col">Nombre y Apellidos</th>
                                <th scope="col">CI o DNI</th>
                                <th scope="col">Alias</th>
                                <th scope="col">Fotografía</th>
                                <th scope="col">Nro. de Placa</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Propietario</th>
                                <th scope="col">Fotos del Vehículo</th>
                                <th scope="col">Historial de Capturas</th>
                                <th scope="col">Botones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Obtener solo criminales que tienen vehículos registrados
                                $criminalsWithVehicles = $crimi->filter(function ($criminal) use ($vehicle) {
                                    return $vehicle->where('criminal_id', $criminal->id)->isNotEmpty();
                                });
                            @endphp

                            @foreach ($criminalsWithVehicles as $criminal_index => $criminals)
                                @php
                                    // Obtener vehículos del criminal actual - IMPORTANTE: usar values() para reiniciar índices
                                    $criminalVehicles = $vehicle->where('criminal_id', $criminals->id)->values();
                                    // Obtener historiales del criminal actual
                                    $criminalHistory = $history_cri->where('criminal_id', $criminals->id);
                                    $ultimaFoto = $fotos->where('criminal_id', $criminals->id)->last();

                                    // Crear un array con los IDs de historiales que tienen vehículos asociados
                                    $historyIdsWithVehicles = [];
                                    foreach ($criminalHistory as $history) {
                                        if (isset($history->criminalVehicle) && count($history->criminalVehicle) > 0) {
                                            $historyIdsWithVehicles[] = $history->id;
                                        }
                                    }
                                @endphp

                                @foreach ($criminalVehicles as $vehicle_index => $criminal_vehicle)
                                    @php
                                        // Para cada vehículo, buscar SUS fotografías específicas
                                        $vehicleSpecificPhotos = collect();

                                        // Buscar en todos los historiales del criminal
                                        foreach ($criminalHistory as $history) {
                                            if (isset($history->criminalVehicle)) {
                                                foreach ($history->criminalVehicle as $historyVehicle) {
                                                    // Comparar por placa para encontrar ESTE vehículo específico
                                                    if (
                                                        $historyVehicle->license_plate ===
                                                        $criminal_vehicle->license_plate
                                                    ) {
                                                        $vehiclePhotos = [
                                                            'front_photo' => $historyVehicle->front_photo,
                                                            'left_side_photo' => $historyVehicle->left_side_photo,
                                                            'right_side_photo' => $historyVehicle->right_side_photo,
                                                            'rear_photo' => $historyVehicle->rear_photo,
                                                        ];

                                                        foreach ($vehiclePhotos as $photoType => $photoPath) {
                                                            if ($photoPath && file_exists(public_path($photoPath))) {
                                                                $vehicleSpecificPhotos->push([
                                                                    'photo' => $photoPath,
                                                                    'type' => $photoType,
                                                                    'type_label' => [
                                                                        'front_photo' => 'Frontal',
                                                                        'left_side_photo' => 'Lateral Izq.',
                                                                        'right_side_photo' => 'Lateral Der.',
                                                                        'rear_photo' => 'Trasera',
                                                                    ][$photoType],
                                                                    'vehicle' => $historyVehicle,
                                                                    'history_date' => $history->arrest_date ?? null,
                                                                    'modal_id' => "vehicle_photo_{$criminals->id}_{$criminal_vehicle->id}_{$history->id}_{$photoType}",
                                                                ]);
                                                            }
                                                        }
                                                        break; // Salir cuando encuentre el vehículo
                                                    }
                                                }
                                            }
                                        }
                                    @endphp

                                    <tr>
                                        {{-- INFORMACIÓN DEL CRIMINAL - Solo en la primera fila de cada criminal --}}
                                        @if ($vehicle_index === 0)
                                            <td rowspan="{{ $criminalVehicles->count() }}">{{ $criminals->id }}</td>
                                            <td rowspan="{{ $criminalVehicles->count() }}">
                                                {{ $criminals->first_name }} {{ $criminals->last_nameP }}
                                                {{ $criminals->last_nameM }}
                                            </td>
                                            <td rowspan="{{ $criminalVehicles->count() }}">{{ $criminals->identity_number }}
                                            </td>
                                            <td rowspan="{{ $criminalVehicles->count() }}">
                                                {{ $criminals->alias_name ?? 'Sin alias' }}</td>
                                            <td rowspan="{{ $criminalVehicles->count() }}">
                                                @if ($ultimaFoto)
                                                    <img src="{{ asset($ultimaFoto->face_photo) }}" width="80"
                                                        height="80" alt="Foto Frontal"
                                                        style="border-radius: 50%; object-fit: cover; cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#facePhotoModal_{{ $criminals->id }}">
                                                @else
                                                    <img src="{{ asset('storage/incognito.jpg') }}" width="80"
                                                        height="80" alt="Foto Incógnito"
                                                        style="border-radius: 50%; object-fit: cover; cursor: pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#facePhotoModal_{{ $criminals->id }}">
                                                @endif
                                            </td>
                                        @endif

                                        {{-- INFORMACIÓN DEL VEHÍCULO - Se muestra en cada fila --}}
                                        <td>
                                            <span class="badge bg-primary">{{ $criminal_vehicle->license_plate }}</span>
                                        </td>
                                        <td>
                                            <div class="vehicle-info-badge">
                                                <strong>{{ $criminal_vehicle->vehicleType->vehicle_type_name ?? 'N/A' }}</strong><br>
                                                {{ $criminal_vehicle->brandVehicle->brand_name ?? 'N/A' }}
                                                {{ $criminal_vehicle->model ?? 'N/A' }}<br>
                                                <small class="text-muted">Año:
                                                    {{ $criminal_vehicle->year ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $criminal_vehicle->user_name ?? 'No especificado' }}</td>

                                        {{-- FOTOGRAFÍAS DEL VEHÍCULO --}}
                                        <td>
                                            @if ($vehicleSpecificPhotos->isNotEmpty())
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#vehiclePhotosModal_{{ $criminals->id }}_{{ $criminal_vehicle->id }}">
                                                    <i class="fas fa-camera"></i> Ver
                                                    <span
                                                        class="badge bg-light text-dark">{{ $vehicleSpecificPhotos->count() }}</span>
                                                </button>
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        {{ $vehicleSpecificPhotos->count() }}
                                                        foto{{ $vehicleSpecificPhotos->count() > 1 ? 's' : '' }}
                                                    </small>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-camera-slash"></i> Sin fotos
                                                </span>
                                            @endif
                                        </td>

                                        {{-- HISTORIAL Y BOTONES - Solo en la primera fila de cada criminal --}}
                                        @if ($vehicle_index === 0)
                                            <td rowspan="{{ $criminalVehicles->count() }}">
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($criminalHistory as $arrest_and_apprehension_histories)
                                                        @php
                                                            // Determinar si este historial tiene vehículos asociados
                                                            $hasVehicles = in_array(
                                                                $arrest_and_apprehension_histories->id,
                                                                $historyIdsWithVehicles,
                                                            );
                                                            $badgeClass = $hasVehicles
                                                                ? 'history-badge-with-vehicle'
                                                                : 'history-badge-without-vehicle';
                                                        @endphp
                                                        <a href="{{ route('criminals.history', ['criminal_id' => $criminals->id, 'history_id' => $arrest_and_apprehension_histories->id]) }}"
                                                            class="badge {{ $badgeClass }} text-decoration-none">
                                                            {{ \Carbon\Carbon::parse($arrest_and_apprehension_histories->arrest_date)->format('d/m/Y') }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </td>

                                            <td rowspan="{{ $criminalVehicles->count() }}">
                                                <div class="d-flex flex-column gap-1">
                                                    <a href="/criminals/search_cri/{{ $criminals->id }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Vista de cards (solo móviles pequeños) -->
                <div class="mobile-card-view" id="mobile-cards-container">
                    @foreach ($criminalsWithVehicles as $criminals)
                        @php
                            $criminalVehicles = $vehicle->where('criminal_id', $criminals->id);
                            $criminalHistory = $history_cri->where('criminal_id', $criminals->id);
                            $ultimaFoto = $fotos->where('criminal_id', $criminals->id)->last();

                            // Crear un array con los IDs de historiales que tienen vehículos asociados para vista móvil
                            $historyIdsWithVehicles = [];
                            foreach ($criminalHistory as $history) {
                                if (isset($history->criminalVehicle) && count($history->criminalVehicle) > 0) {
                                    $historyIdsWithVehicles[] = $history->id;
                                }
                            }
                        @endphp

                        <div class="criminal-card">
                            <div class="criminal-header">
                                <div>
                                    @if ($ultimaFoto)
                                        <img src="{{ asset($ultimaFoto->face_photo) }}" class="criminal-photo"
                                            alt="Foto Frontal" data-bs-toggle="modal"
                                            data-bs-target="#facePhotoModal_{{ $criminals->id }}">
                                    @else
                                        <img src="{{ asset('storage/incognito.jpg') }}" class="criminal-photo"
                                            alt="Foto Incógnito" data-bs-toggle="modal"
                                            data-bs-target="#facePhotoModal_{{ $criminals->id }}">
                                    @endif
                                </div>
                                <div class="criminal-info flex-grow-1">
                                    <h5>{{ $criminals->first_name }} {{ $criminals->last_nameP }}
                                        {{ $criminals->last_nameM }}
                                    </h5>
                                    <small>
                                        CI: {{ $criminals->identity_number }}
                                        @if ($criminals->alias_name)
                                            | Alias: {{ $criminals->alias_name }}
                                        @endif
                                    </small>
                                </div>
                                <div>
                                    <a href="/criminals/search_cri/{{ $criminals->id }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="criminal-body">
                                @foreach ($criminalVehicles as $criminal_vehicle)
                                    @php
                                        $vehicleSpecificPhotos = collect();
                                        foreach ($criminalHistory as $history) {
                                            if (isset($history->criminalVehicle)) {
                                                foreach ($history->criminalVehicle as $historyVehicle) {
                                                    if (
                                                        $historyVehicle->license_plate ===
                                                        $criminal_vehicle->license_plate
                                                    ) {
                                                        $vehiclePhotos = [
                                                            'front_photo' => $historyVehicle->front_photo,
                                                            'left_side_photo' => $historyVehicle->left_side_photo,
                                                            'right_side_photo' => $historyVehicle->right_side_photo,
                                                            'rear_photo' => $historyVehicle->rear_photo,
                                                        ];
                                                        foreach ($vehiclePhotos as $photoType => $photoPath) {
                                                            if ($photoPath && file_exists(public_path($photoPath))) {
                                                                $vehicleSpecificPhotos->push([
                                                                    'photo' => $photoPath,
                                                                    'type' => $photoType,
                                                                    'type_label' => [
                                                                        'front_photo' => 'Frontal',
                                                                        'left_side_photo' => 'Lateral Izq.',
                                                                        'right_side_photo' => 'Lateral Der.',
                                                                        'rear_photo' => 'Trasera',
                                                                    ][$photoType],
                                                                    'vehicle' => $historyVehicle,
                                                                    'history_date' => $history->arrest_date ?? null,
                                                                    'modal_id' => "vehicle_photo_{$criminals->id}_{$criminal_vehicle->id}_{$history->id}_{$photoType}",
                                                                ]);
                                                            }
                                                        }
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp

                                    <div class="vehicle-item">
                                        <div class="vehicle-header">
                                            <div class="vehicle-plate">{{ $criminal_vehicle->license_plate }}</div>
                                        </div>

                                        <div class="vehicle-details">
                                            <strong>{{ $criminal_vehicle->vehicleType->vehicle_type_name ?? 'N/A' }}</strong><br>
                                            {{ $criminal_vehicle->brandVehicle->brand_name ?? 'N/A' }}
                                            {{ $criminal_vehicle->model ?? 'N/A' }}<br>
                                            <small class="text-muted">
                                                Año: {{ $criminal_vehicle->year ?? 'N/A' }} |
                                                Propietario: {{ $criminal_vehicle->user_name ?? 'No especificado' }}
                                            </small>
                                        </div>

                                        <div class="vehicle-actions">
                                            @if ($vehicleSpecificPhotos->isNotEmpty())
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#vehiclePhotosModal_{{ $criminals->id }}_{{ $criminal_vehicle->id }}">
                                                    <i class="fas fa-camera"></i> {{ $vehicleSpecificPhotos->count() }}
                                                    Fotos
                                                </button>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="fas fa-camera-slash"></i> Sin fotografías
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if ($criminalHistory->isNotEmpty())
                                    <div style="padding: 15px; background: #252525; border-top: 1px solid #eee;">
                                        <small class="text-muted d-block mb-2">Historial de capturas:</small>
                                        <div class="history-badges">
                                            @foreach ($criminalHistory as $arrest_and_apprehension_histories)
                                                @php
                                                    // Determinar si este historial tiene vehículos asociados
                                                    $hasVehicles = in_array(
                                                        $arrest_and_apprehension_histories->id,
                                                        $historyIdsWithVehicles,
                                                    );
                                                    $badgeClass = $hasVehicles
                                                        ? 'history-badge-with-vehicle'
                                                        : 'history-badge-without-vehicle';
                                                @endphp
                                                <a href="{{ route('criminals.history', ['criminal_id' => $criminals->id, 'history_id' => $arrest_and_apprehension_histories->id]) }}"
                                                    class="badge {{ $badgeClass }} text-decoration-none">
                                                    {{ \Carbon\Carbon::parse($arrest_and_apprehension_histories->arrest_date)->format('d/m/Y') }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Información de paginación y controles -->
                <div class="pagination-wrapper">
                    <div id="table-info" style="color: #b7b7b7;">
                        Mostrando <span id="start-entry">1</span> a <span id="end-entry">25</span> de <span
                            id="total-entries">0</span> entradas
                    </div>

                    <nav aria-label="Table pagination">
                        <ul class="pagination pagination-sm mb-0" id="pagination-controls">
                            <li class="page-item" id="prev-page">
                                <a class="page-link" href="#" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <!-- Los números de página se generarán dinámicamente -->
                            <li class="page-item" id="next-page">
                                <a class="page-link" href="#" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales de fotografías de vehículos -->
    @foreach ($criminalsWithVehicles as $criminals)
        @php
            $criminalVehicles = $vehicle->where('criminal_id', $criminals->id);
            $criminalHistory = $history_cri->where('criminal_id', $criminals->id);
        @endphp

        @foreach ($criminalVehicles as $criminal_vehicle)
            @php
                // Para cada vehículo, buscar SUS fotografías específicas
                $vehicleSpecificPhotos = collect();

                foreach ($criminalHistory as $history) {
                    if (isset($history->criminalVehicle)) {
                        foreach ($history->criminalVehicle as $historyVehicle) {
                            if ($historyVehicle->license_plate === $criminal_vehicle->license_plate) {
                                $vehiclePhotos = [
                                    'front_photo' => $historyVehicle->front_photo,
                                    'left_side_photo' => $historyVehicle->left_side_photo,
                                    'right_side_photo' => $historyVehicle->right_side_photo,
                                    'rear_photo' => $historyVehicle->rear_photo,
                                ];

                                foreach ($vehiclePhotos as $photoType => $photoPath) {
                                    if ($photoPath && file_exists(public_path($photoPath))) {
                                        $vehicleSpecificPhotos->push([
                                            'photo' => $photoPath,
                                            'type' => $photoType,
                                            'type_label' => [
                                                'front_photo' => 'Frontal',
                                                'left_side_photo' => 'Lateral Izq.',
                                                'right_side_photo' => 'Lateral Der.',
                                                'rear_photo' => 'Trasera',
                                            ][$photoType],
                                            'vehicle' => $historyVehicle,
                                            'history_date' => $history->arrest_date ?? null,
                                            'modal_id' => "vehicle_photo_{$criminals->id}_{$criminal_vehicle->id}_{$history->id}_{$photoType}",
                                        ]);
                                    }
                                }
                                break;
                            }
                        }
                    }
                }
            @endphp

            @if ($vehicleSpecificPhotos->isNotEmpty())
                <!-- Modal principal para este vehículo específico -->
                <div class="modal fade" id="vehiclePhotosModal_{{ $criminals->id }}_{{ $criminal_vehicle->id }}"
                    tabindex="-1"
                    aria-labelledby="vehiclePhotosModalLabel_{{ $criminals->id }}_{{ $criminal_vehicle->id }}"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="vehiclePhotosModalLabel_{{ $criminals->id }}_{{ $criminal_vehicle->id }}">
                                    <i class="fas fa-car me-2"></i>Fotografías del Vehículo -
                                    {{ $criminal_vehicle->license_plate ?? 'Sin placa' }}
                                    ({{ $criminals->first_name }} {{ $criminals->last_nameP }})
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h6 class="border-bottom pb-2">
                                            <i class="fas fa-car me-1"></i>
                                            {{ $criminal_vehicle->license_plate ?? 'Sin placa' }}
                                            @if ($criminal_vehicle->brandVehicle)
                                                - {{ $criminal_vehicle->brandVehicle->brand_name }}
                                                {{ $criminal_vehicle->model }}
                                            @endif
                                        </h6>
                                        <div class="photo-grid">
                                            @foreach ($vehicleSpecificPhotos as $photoData)
                                                <div class="text-center">
                                                    <img src="{{ asset($photoData['photo']) }}"
                                                        class="vehicle-photos-thumb" data-bs-toggle="modal"
                                                        data-bs-target="#{{ $photoData['modal_id'] }}"
                                                        alt="{{ $photoData['type_label'] }}">
                                                    <div class="small text-muted mt-1">{{ $photoData['type_label'] }}
                                                    </div>
                                                    @if ($photoData['history_date'])
                                                        <div class="small text-muted">
                                                            {{ \Carbon\Carbon::parse($photoData['history_date'])->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modales individuales para cada fotografía de este vehículo -->
                @foreach ($vehicleSpecificPhotos as $photoData)
                    <div class="modal fade" id="{{ $photoData['modal_id'] }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-success">
                                        <i class="fas fa-car me-2"></i>{{ $photoData['type_label'] }} -
                                        {{ $criminal_vehicle->license_plate ?? 'Vehículo' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white"
                                        onclick="returnToVehiclePhotos('{{ $criminals->id }}_{{ $criminal_vehicle->id }}', '{{ $photoData['modal_id'] }}')"></button>
                                </div>
                                <div class="modal-body text-center p-2">
                                    <img src="{{ asset($photoData['photo']) }}"
                                        class="img-fluid rounded shadow modal-vehicle-photo"
                                        alt="{{ $photoData['type_label'] }} - {{ $criminal_vehicle->license_plate ?? 'Vehículo' }}">
                                    <div class="mt-3">
                                        <p class="text-light mb-1">
                                            <strong>{{ $criminal_vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                {{ $criminal_vehicle->model ?? 'Modelo N/A' }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            {{ $criminal_vehicle->vehicleColor->color_name ?? 'Color N/A' }} |
                                            {{ $criminal_vehicle->year ?? 'Año N/A' }}
                                            @if ($photoData['history_date'])
                                                | Captura:
                                                {{ \Carbon\Carbon::parse($photoData['history_date'])->format('d/m/Y') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="returnToVehiclePhotos('{{ $criminals->id }}_{{ $criminal_vehicle->id }}', '{{ $photoData['modal_id'] }}')">
                                            <i class="fas fa-arrow-left me-1"></i>Volver a Fotografías
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    @endforeach

    <!-- Modales de fotografías del rostro -->
    @foreach ($criminalsWithVehicles as $criminals)
        @php
            $ultimaFoto = $fotos->where('criminal_id', $criminals->id)->last();
        @endphp

        <div class="modal fade" id="facePhotoModal_{{ $criminals->id }}" tabindex="-1"
            aria-labelledby="facePhotoModalLabel_{{ $criminals->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title text-success" id="facePhotoModalLabel_{{ $criminals->id }}">
                            <i class="fas fa-user me-2"></i>Fotografía -
                            {{ $criminals->first_name }} {{ $criminals->last_nameP }} {{ $criminals->last_nameM }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-3">
                        @if ($ultimaFoto)
                            <img src="{{ asset($ultimaFoto->face_photo) }}" class="img-fluid rounded shadow"
                                alt="Fotografía de {{ $criminals->first_name }} {{ $criminals->last_nameP }}"
                                style="max-height: 60vh; max-width: 100%; object-fit: contain; display: block; margin: 0 auto;">
                        @else
                            <img src="{{ asset('storage/incognito.jpg') }}" class="img-fluid rounded shadow"
                                alt="Fotografía no disponible"
                                style="max-height: 60vh; max-width: 100%; object-fit: contain; display: block; margin: 0 auto;">
                            <div class="mt-3">
                                <p class="text-light">No hay fotografía disponible</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <p class="text-light mb-1">
                                <strong>{{ $criminals->first_name }} {{ $criminals->last_nameP }}
                                    {{ $criminals->last_nameM }}</strong>
                            </p>
                            <small class="text-muted">
                                CI: {{ $criminals->identity_number }} |
                                Alias: {{ $criminals->alias_name ?? 'N/A' }}
                            </small>
                        </div>
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
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js"></script>
    <script>
        $(document).ready(function() {
            // Variables para paginación
            let currentPage = 1;
            let entriesPerPage = 25;
            let allCriminalGroups = [];
            let filteredCriminalGroups = [];
            let allCriminalCards = [];
            let filteredCriminalCards = [];

            // Inicializar tabla
            $('#criminales').addClass('table-striped table-hover');
            initializePagination();

            // Función para agrupar filas por criminal
            function groupRowsByCriminal() {
                const groups = [];
                const rows = $('#criminales tbody tr').toArray();
                let currentGroup = [];

                for (let i = 0; i < rows.length; i++) {
                    const row = $(rows[i]);
                    // Si la fila tiene rowspan en la primera columna, es el inicio de un nuevo criminal
                    if (row.find('td[rowspan]').length > 0) {
                        // Guardar el grupo anterior si existe
                        if (currentGroup.length > 0) {
                            groups.push(currentGroup);
                        }
                        // Iniciar nuevo grupo
                        currentGroup = [rows[i]];
                    } else {
                        // Agregar fila al grupo actual
                        currentGroup.push(rows[i]);
                    }
                }

                // Agregar el último grupo
                if (currentGroup.length > 0) {
                    groups.push(currentGroup);
                }

                return groups;
            }

            // Función para obtener todas las cards móviles
            function getAllCriminalCards() {
                return $('.criminal-card').toArray();
            }

            // Función para inicializar la paginación
            function initializePagination() {
                allCriminalGroups = groupRowsByCriminal();
                filteredCriminalGroups = allCriminalGroups.slice();
                allCriminalCards = getAllCriminalCards();
                filteredCriminalCards = allCriminalCards.slice();
                updatePagination();
                showPage(1);
            }

            // Función para mostrar una página específica
            function showPage(page) {
                currentPage = page;
                const startIndex = (page - 1) * entriesPerPage;
                const endIndex = startIndex + entriesPerPage;

                // Vista de tabla
                $('#criminales tbody tr').hide();
                for (let i = startIndex; i < endIndex && i < filteredCriminalGroups.length; i++) {
                    const criminalGroup = filteredCriminalGroups[i];
                    criminalGroup.forEach(row => {
                        $(row).show();
                    });
                }

                // Vista móvil
                $('.criminal-card').hide();
                for (let i = startIndex; i < endIndex && i < filteredCriminalCards.length; i++) {
                    $(filteredCriminalCards[i]).show();
                }

                updatePaginationInfo();
                updatePaginationControls();
            }

            // Función para actualizar la información de paginación
            function updatePaginationInfo() {
                const totalEntries = Math.max(filteredCriminalGroups.length, filteredCriminalCards.length);
                const startEntry = totalEntries === 0 ? 0 : (currentPage - 1) * entriesPerPage + 1;
                const endEntry = Math.min(currentPage * entriesPerPage, totalEntries);

                $('#start-entry').text(startEntry);
                $('#end-entry').text(endEntry);
                $('#total-entries').text(totalEntries);
            }

            // Función para actualizar los controles de paginación
            function updatePaginationControls() {
                const totalEntries = Math.max(filteredCriminalGroups.length, filteredCriminalCards.length);
                const totalPages = Math.ceil(totalEntries / entriesPerPage);
                const pagination = $('#pagination-controls');

                // Limpiar números de página existentes
                pagination.find('.page-number').remove();

                // Habilitar/deshabilitar botones prev/next
                $('#prev-page').toggleClass('disabled', currentPage === 1);
                $('#next-page').toggleClass('disabled', currentPage === totalPages || totalPages === 0);

                // Agregar números de página
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

                if (endPage - startPage < maxVisiblePages - 1) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageItem = $(`
                        <li class="page-item page-number ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                    $('#next-page').before(pageItem);
                }
            }

            // Función para actualizar paginación después de filtrar
            function updatePagination() {
                const totalEntries = Math.max(filteredCriminalGroups.length, filteredCriminalCards.length);
                const totalPages = Math.ceil(totalEntries / entriesPerPage);
                if (currentPage > totalPages) {
                    currentPage = Math.max(1, totalPages);
                }
            }

            // Event listener para cambio de entradas por página
            $('#entries-select').on('change', function() {
                entriesPerPage = parseInt($(this).val());
                currentPage = 1;
                updatePagination();
                showPage(1);
            });

            // Event listener para búsqueda
            $('#search-input').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();

                if (searchValue === '') {
                    filteredCriminalGroups = allCriminalGroups.slice();
                    filteredCriminalCards = allCriminalCards.slice();
                } else {
                    // Filtrar grupos de tabla
                    filteredCriminalGroups = allCriminalGroups.filter(function(criminalGroup) {
                        return criminalGroup.some(function(row) {
                            return $(row).text().toLowerCase().includes(searchValue);
                        });
                    });

                    // Filtrar cards móviles
                    filteredCriminalCards = allCriminalCards.filter(function(card) {
                        return $(card).text().toLowerCase().includes(searchValue);
                    });
                }

                currentPage = 1;
                updatePagination();
                showPage(1);
            });

            // Event listeners para controles de paginación
            $(document).on('click', '#prev-page:not(.disabled) a', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            });

            $(document).on('click', '#next-page:not(.disabled) a', function(e) {
                e.preventDefault();
                const totalEntries = Math.max(filteredCriminalGroups.length, filteredCriminalCards.length);
                const totalPages = Math.ceil(totalEntries / entriesPerPage);
                if (currentPage < totalPages) {
                    showPage(currentPage + 1);
                }
            });

            $(document).on('click', '.page-number a', function(e) {
                e.preventDefault();
                const page = parseInt($(this).data('page'));
                showPage(page);
            });

            // Función para manejar cambios de tamaño de ventana
            function handleResize() {
                // Reinicializar paginación cuando cambie el tamaño de ventana
                // para asegurar consistencia entre vistas
                showPage(currentPage);
            }

            // Debounce para evitar múltiples llamadas
            let resizeTimer;
            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(handleResize, 250);
            });
        });

        // Función para volver al modal principal de fotografías de vehículos
        function returnToVehiclePhotos(rowId, currentModalId) {
            // Cerrar el modal actual inmediatamente
            var currentModal = bootstrap.Modal.getInstance(document.getElementById(currentModalId));
            if (currentModal) {
                currentModal.hide();
            }

            // Limpiar cualquier backdrop residual
            setTimeout(function() {
                // Remover backdrops duplicados
                const backdrops = document.querySelectorAll('.modal-backdrop');
                if (backdrops.length > 1) {
                    for (let i = 1; i < backdrops.length; i++) {
                        backdrops[i].remove();
                    }
                }

                // Abrir el modal principal usando el rowId específico
                var mainModal = new bootstrap.Modal(document.getElementById('vehiclePhotosModal_' + rowId));
                mainModal.show();
            }, 300);
        }

        // Limpiar backdrops al cerrar cualquier modal
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar event listener a todos los modales para limpiar backdrops
            document.addEventListener('hidden.bs.modal', function(event) {
                // Esperar un poco para asegurar que Bootstrap termine su limpieza
                setTimeout(function() {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    const openModals = document.querySelectorAll('.modal.show');

                    // Si no hay modales abiertos, remover todos los backdrops
                    if (openModals.length === 0) {
                        backdrops.forEach(backdrop => backdrop.remove());
                        // Remover la clase modal-open del body si no hay modales
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }
                    // Si hay modales abiertos pero más backdrops de los necesarios
                    else if (backdrops.length > openModals.length) {
                        for (let i = openModals.length; i < backdrops.length; i++) {
                            if (backdrops[i]) {
                                backdrops[i].remove();
                            }
                        }
                    }
                }, 100);
            });

            // Event listeners para manejar la navegación con el teclado (ESC)
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    // Buscar si hay un modal individual de vehículo abierto
                    const openModals = document.querySelectorAll('.modal.show');
                    openModals.forEach(function(modal) {
                        // Verificar si es un modal individual de foto (contiene vehicle_photo_ pero NO vehiclePhotosModal_)
                        if (modal.id.includes('vehicle_photo_') && !modal.id.includes(
                                'vehiclePhotosModal_')) {
                            // Extraer criminal_id y vehicle_id del modal ID
                            // Formato: vehicle_photo_{criminal_id}_{vehicle_id}_{history_id}_{photoType}
                            const modalIdParts = modal.id.split('_');
                            if (modalIdParts.length >= 5) {
                                const criminalId = modalIdParts[
                                    2]; // criminal_id está en posición 2
                                const vehicleId = modalIdParts[3]; // vehicle_id está en posición 3
                                const rowId = criminalId + '_' + vehicleId;

                                // Usar la función returnToVehiclePhotos para volver al modal principal
                                returnToVehiclePhotos(rowId, modal.id);
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop

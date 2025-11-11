@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])


@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">
        REGISTRO DE INGRESOS AL SISTEMA</h1>
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@stop

@section('content')
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

        /* Botón circular dentro del slider */
        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 2.5px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        /* Posición del botón cuando está activo */
        input:checked+.slider:before {
            transform: translateX(25px);
        }
    </style>
       <!-- Tabla de criminales -->
    <div class="container">
        <table class="table" id="criminales">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>IP</th>
                    <th>Sistema</th>
                    <th>Dispositivo</th>
                    <th>Ubicación</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Final</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session->id }}</td>
                        <td>{{ $session->user->name }}</td> <!-- Suponiendo que tu modelo User tiene el campo 'name' -->
                        <td>{{ $session->ip_address }}</td>
                        <td>{{ $session->system }}</td>
                        <td>{{ $session->device }}</td>
                        <td>{{ $session->location }}</td>
                        <td>{{ $session->login_at->format('d/m/Y H:i:s') }}</td> <!-- Formateo de la fecha -->
                        <td>
                            @if ($session->logout_at)
                                {{ $session->logout_at->format('d/m/Y H:i:s') }}
                            @else
                                <span class="badge badge-success" style="font-weight: normal; font-size: 12px;">En línea</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
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
    var table = $('#criminales').DataTable({
        responsive: true,
        colReorder: true, // Habilita la extensión ColReorder
        order: [[6, "desc"]], // Ordena por la columna 6 (Hora de Inicio) en orden descendente
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
            },
            aria: {
                sortAscending: ": activar para ordenar la columna ascendente",
                sortDescending: ": activar para ordenar la columna descendente"
            }
        }
    });
});

    </script>


@stop

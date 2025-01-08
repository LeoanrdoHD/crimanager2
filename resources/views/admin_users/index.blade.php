@extends('adminlte::page')
@vite(['resources/js/app.js', 'resources/css/app.css'])


@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">
        LISTA DE USUARIOS DEL SISTEMA</h1>
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
    @can('crear.Usuarios')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        Crear Nuevo Usuario
    </a>
    @endcan
    
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

    <!-- Tabla de criminales -->
    <div class="container">
        <table class="table" id="criminales">
            <thead>
                <tr>
                    <th scope="col">N°.</th>
                    <th scope="col">Grado Nombres y Apellidos</th>
                    <th scope="col">CI o DNI</th>
                    <th scope="col">Fotografia</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Rol</th>
                    <th scope="col">estado</th>
                    <th scope="col">Botones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $users)
                    <tr>
                        <td>{{ $users->id }}</td>
                        <td>{{ ucwords(strtolower($users->grade)) }}. {{ ucwords(strtolower($users->name)) }}</td>
                        <td>{{ $users->ci_police }}</td>
                        <td>
                            @if ($users->profile_photo_path)
                                <!-- Mostrar imagen desde el almacenamiento -->
                                <img src="{{ asset('storage/' . $users->profile_photo_path) }}" width="75" alt="Foto de Perfil"
                                    style="border-radius: 40%; object-fit: cover;">
                            @else
                                <!-- Mostrar imagen genérica -->
                                <img src="{{ asset($users->profile_photo_url) }}" width="75" alt="Foto de Perfil"
                                    style="border-radius: 40%; object-fit: cover;">
                            @endif
                        </td>
                        
                        <td>{{ $users->email }}</td>
                        <td>{{ $users->phone }}</td>
                        <td>
                            <p>
                                @foreach ($users->roles as $role)
                                    {{ strtoupper($role->name) }} <br>
                                @endforeach
                            </p>
                        </td>


                        <td>
                            <label class="switch">
                                <input type="checkbox" {{ $users->estado ? 'checked' : '' }} disabled>
                                <span class="slider {{ $users->estado ? 'active' : 'inactive' }}"></span>
                            </label>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $users->id) }}" class="btn btn-primary d-block mb-2"
                                style="padding: 2px 8px; font-size: 12px; min-height: 25px; line-height: 1.2;">
                                Ver Todo
                            </a>
                            <a href="{{ route('admin.users.edit', $users->id) }}" class="btn btn-warning d-block"
                                style="padding: 2px 8px; font-size: 12px; min-height: 25px; line-height: 1.2;">
                                Editar
                            </a>


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
            // Inicialización de DataTables con ColReorder habilitado
            var table = $('#criminales').DataTable({
                responsive: true,
                colReorder: true, // Habilita la extensión ColReorder
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

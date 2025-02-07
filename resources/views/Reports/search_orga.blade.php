@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">
        BUSCAR POR ORGANIZACIONES</h1>
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
                    <th scope="col">Nro.</th>
                    <th scope="col">Nombre y Apellidos</th>
                    <th scope="col">CI o DNI</th>
                    <th scope="col">Alias</th>
                    <th scope="col">Fotografía</th>
                    <th scope="col">Historial de Capturas</th>
                    <th scope="col">Organización</th>
                    <th scope="col">Actividad</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Botones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crimi as $criminals)
                    <tr>
                        <td>{{ $criminals->id }}</td>
                        <td>{{ $criminals->first_name }} {{ $criminals->last_nameP }} {{ $criminals->last_nameM }}</td>
                        <td>{{ $criminals->identity_number }}</td>
                        <td>{{ $criminals->alias_name }}</td>
                        <td>
                            @php
                                $ultimaFoto = $fotos->where('criminal_id', $criminals->id)->last();
                            @endphp
                        
                            @if ($ultimaFoto)
                                <img src="{{ asset($ultimaFoto->face_photo) }}" 
                                    width="80" 
                                    alt="Foto Frontal" 
                                    style="border-radius: 50%; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/incognito.jpg') }}" 
                                    width="80" 
                                    alt="Foto Incógnito" 
                                    style="border-radius: 50%; object-fit: cover;">
                            @endif
                        </td>
                        
                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    <a href="{{ route('criminals.history', ['criminal_id' => $criminals->id, 'history_id' => $arrest_and_apprehension_histories->id]) }}">
                                        {{ \Carbon\Carbon::parse($arrest_and_apprehension_histories->arrest_date)->format('d-m-Y') }}
                                    </a><br>
                                @endif
                            @endforeach
                        </td>   
                        <td>
                            @foreach ($orga as $criminal_organization)
                                @if ($criminal_organization->criminal_id === $criminals->id)
                                    <p>
                                        {{ $criminal_organization->organization->organization_name }}
                                    </p><br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($orga as $criminal_organization)
                                @if ($criminal_organization->criminal_id === $criminals->id)
                                    <p>
                                        {{ $criminal_organization->organization->Criminal_Organization_Specialty }}
                                    </p><br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($orga as $criminal_organization)
                                @if ($criminal_organization->criminal_id === $criminals->id)
                                    <p>
                                        {{ $criminal_organization->criminal_rol }}
                                    </p><br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class="d-flex flex-column align-items-start">
                                <a href="/criminals/search_cri/{{ $criminals->id }}"
                                    class="btn btn-primary btn-sm w-100 mb-2">Ver Todo</a>
                                @can('agregar.criminal')
                                    <a href="/criminals/arrest/show_file/{{ $criminals->id }}"
                                        class="btn btn-success btn-sm w-100">Agregar</a>
                                @endcan
                            </div>
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

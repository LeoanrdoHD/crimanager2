@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">BUSCAR FICHA DE DELINCUENTES</h1>
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css">
@stop

@section('content')
    <!--<div class="card bg-white">
                                    <div class="card-body bg-transparent">-->
    @if (session('success'))
        <div id="success-alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 10px 20px; background-color: #4caf50; color: white; border-radius: 5px;">
            {{ session('success') }}
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Mostrar el mensaje y luego ocultarlo después de 3 segundos
                setTimeout(() => {
                    document.getElementById('success-alert').style.display = 'none';
                }, 3000);
            });
        </script>
    @endif
    <div class="container">
        <table class="table" id="criminales">
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
                    <th scope="col">Botones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crimi as $criminals)
                    <tr>
                        <th scope="row">{{ $criminals->id }}</th>
                        <td>{{ $criminals->first_name }}</td>
                        <td>{{ $criminals->last_name }}</td>
                        <td>{{ $criminals->identity_number }}</td>
                        <td>{{ $criminals->alias_name }}</td>

                        <td>
                            @foreach ($fotos as $photographs)
                                @if ($photographs->criminal_id === $criminals->id)
                                    <img src="{{ asset($photographs->face_photo) }}" width="50" alt="Foto Frontal"
                                        style="border-radius: 50%; object-fit: cover;">
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    <a href="{{ $arrest_and_apprehension_histories->id }}">
                                        {{ $arrest_and_apprehension_histories->arrest_date }}
                                    </a>
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($criminals->organizations as $organization)
                                {{ $organization->organization_name }}<br>
                            @endforeach
                        </td>
                        <td><a href="/criminals/search_cri/{{ $criminals->id }}" class="btn btn-primary">Ver Todo</a>
                            <a href="arrest/show_file/{{ $criminals->id }}" class="btn btn-primary">Agregar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!--</div></div>-->
@stop
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>
    <script>
        $('#criminales').DataTable({
            responsive: true,

        });
    </script>
@endsection

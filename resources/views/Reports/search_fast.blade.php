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

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#columnToggleModal">
        Configurar columnas
    </button>

    <!-- Modal -->
    <div class="modal fade" id="columnToggleModal" tabindex="-1" aria-labelledby="columnToggleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnToggleModalLabel">Seleccionar columnas a mostrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor con grilla de 3 columnas -->
                    <div id="columnToggleContainer" class="row">
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="0" checked>
                                <label class="form-check-label">Nro.</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="1" checked>
                                <label class="form-check-label">Nombre</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="2" checked>
                                <label class="form-check-label">Apellido</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="3" checked>
                                <label class="form-check-label">CI o DNI</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="4" checked>
                                <label class="form-check-label">Alias</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="5" checked>
                                <label class="form-check-label">Fotografía</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="6" checked>
                                <label class="form-check-label">Historial de Capturas</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="7" checked>
                                <label class="form-check-label">Pertenece a</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="8" checked>
                                <label class="form-check-label">Botones</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById("applyColumns").addEventListener("click", function() {
            const checkboxes = document.querySelectorAll(".column-toggle");
            checkboxes.forEach((checkbox) => {
                const column = checkbox.getAttribute("data-column");
                const isChecked = checkbox.checked;

                // Aplica la visibilidad de la columna según el estado del checkbox
                const tableColumn = document.querySelectorAll(
                    `table tr td:nth-child(${+column + 1}), table tr th:nth-child(${+column + 1})`);
                tableColumn.forEach((cell) => {
                    cell.style.display = isChecked ? "" : "none";
                });
            });

            // Cierra el modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("columnToggleModal"));
            modal.hide();
        });
    </script>


    <!-- Tabla de criminales -->
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
                        <td>{{ $criminals->last_nameP }} {{ $criminals->last_nameM }}</td>
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
                        <td><a href="/criminals/search_fast/{{ $criminals->id }}" class="btn btn-primary">Ver Todo</a>
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
    <script>
        $(document).ready(function() {
            // Inicializar el DataTable
            var table = $('#criminales').DataTable({
                responsive: true,
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

            // Manejar visibilidad de columnas
            $('.column-toggle').on('change', function() {
                var column = table.column($(this).data('column'));
                column.visible($(this).is(':checked'));
            });
        });
    </script>
@stop

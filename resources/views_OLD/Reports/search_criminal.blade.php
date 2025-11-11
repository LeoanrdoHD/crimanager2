@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">
        DESCARGAR HISTORIAL COMPLETO</h1>
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

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#columnToggleModal">
        Configurar columnas
    </button>

    <!-- Modal -->
    <div class="modal fade" id="columnToggleModal" tabindex="-1" aria-labelledby="columnToggleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Modal ancho -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnToggleModalLabel">Seleccionar columnas a mostrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenedor con grilla responsiva -->
                    <div id="columnToggleContainer" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        <!-- Columna 1 -->
                        <div class="col">
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
                        <!-- Columna 2 -->
                        <div class="col">
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
                        <!-- Columna 3 -->
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="6" checked>
                                <label class="form-check-label">Historial de Capturas</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="7" checked>
                                <label class="form-check-label">Pertenece a</label>
                            </div>
                        </div>
                        <!-- Nuevas columnas -->
                        <div class="col">
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
                        </div>
                        <div class="col">
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
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="15">
                                <label class="form-check-label">Celular</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="16">
                                <label class="form-check-label">Prisión</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="17">
                                <label class="form-check-label">Dirección</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="18">
                                <label class="form-check-label">Profesión</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="19">
                                <label class="form-check-label">Especialidad</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="20">
                                <label class="form-check-label">Actividad de la Organización</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="21">
                                <label class="form-check-label">Rol en una Organización</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="22">
                                <label class="form-check-label">Placa de Vehículo</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="23">
                                <label class="form-check-label">Lugar de Captura</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="24">
                                <label class="form-check-label">Tipo de Registro</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="25">
                                <label class="form-check-label">Situación Legal</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="26">
                                <label class="form-check-label">Nro. CUD</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check mb-2">
                                <input class="form-check-input column-toggle" type="checkbox" data-column="27">
                                <label class="form-check-label">Tipo de Condena</label>
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
                                <img src="{{ asset($ultimaFoto->face_photo) }}" width="80" alt="Foto Frontal"
                                    style="border-radius: 50%; object-fit: cover;">
                            @else
                                <p>No hay fotografía disponible.</p>
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
                            <div class="d-flex flex-column align-items-start">
                                <a href="/criminals/search_cri/{{ $criminals->id }}"
                                    class="btn btn-primary btn-sm w-100 mb-2">Ver</a>
                                <a href="{{ route('generate-pdf', $criminals->id) }}"
                                    class="btn btn-warning btn-sm w-100 mb-2">Descargar 1</a>
                                <a href="{{ route('generate-pdf-rapido', $criminals->id) }}"
                                    class="btn btn-success btn-sm w-100">Descargar 2</a>
                            </div>
                        </td>
                        <!-- Columnas adicionales con datos vacíos si no están disponibles -->
                        <td>{{ $criminals->age ?? '' }}</td>
                        <td>
                            @forelse ($criminals->physicalCharacteristics as $characteristic)
                                <p>{{ $characteristic->height }} cm</p>
                            @empty
                                <p>No Registrado</p>
                            @endforelse
                        </td>
                        <td>
                            @forelse ($criminals->physicalCharacteristics as $characteristic)
                                <p> {{ $characteristic->weight ?? 'No especificado' }} kg</p>

                            @empty
                                <p>No Registrado</p>
                            @endforelse
                        </td>
                        <td>{{ $criminals->nationality->nationality_name ?? '' }}</td>
                        <td>
                            @forelse ($criminals->physicalCharacteristics as $characteristic)
                                <p>
                                    {{ $characteristic->confleccion->conflexion_name ?? 'No especificado' }}</p>
                            @empty
                                <p>No Registrado</p>
                            @endforelse
                        </td>
                        <td>
                            @forelse ($criminals->physicalCharacteristics as $characteristic)
                                <p>
                                    {{ $characteristic->distinctive_marks ?? 'No especificadas' }}</p>

                            @empty
                                <p>No Registrado</p>
                            @endforelse
                        </td>
                        <td>
                            @foreach ($phone_cri as $criminal_phone_number)
                                @if ($criminal_phone_number->criminal_id === $criminals->id)
                                    <p>
                                        {{ $criminal_phone_number->phone_number }}
                                    </p><br>
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
                                </p>
                            @empty
                                <p>No hay direcciones registradas para este criminal.</p>
                            @endforelse
                        </td>
                        <td>{{ $criminals->occupation->ocupation_name ?? '' }}</td>
                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    {{ $arrest_and_apprehension_histories->criminalSpecialty->specialty_name }}
                                    <br>
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
                            @foreach ($vehicle as $criminal_vehicle)
                                @if ($criminal_vehicle->criminal_id === $criminals->id)
                                    <p>
                                        {{ $criminal_vehicle->license_plate }}
                                    </p><br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    {{ $arrest_and_apprehension_histories->arrest_location }}<br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    {{ $arrest_and_apprehension_histories->legalStatus->status_name }}
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    @if ($arrest_and_apprehension_histories->apprehensionType)
                                        {{ $arrest_and_apprehension_histories->apprehensionType->type_name }}<br>
                                    @else
                                        ---<br>
                                    @endif
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @foreach ($history_cri as $arrest_and_apprehension_histories)
                                @if ($arrest_and_apprehension_histories->criminal_id === $criminals->id)
                                    {{ $arrest_and_apprehension_histories->cud_number }}<br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($condena as $conviction)
                                @if ($conviction->criminal_id === $criminals->id)
                                    <p>
                                        {{ $conviction->detentionType->detention_name }}
                                    </p><br>
                                @endif
                            @endforeach
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
                columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7],
                        visible: true
                    }, // Columnas visibles por defecto
                    {
                        targets: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,
                            27
                        ],
                        visible: false
                    } // Columnas opcionales ocultas por defecto
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
                    },
                    aria: {
                        sortAscending: ": activar para ordenar la columna ascendente",
                        sortDescending: ": activar para ordenar la columna descendente"
                    }
                }
            });

            // Manejo de visibilidad de columnas según los checkboxes
            $('.column-toggle').on('change', function() {
                const columnIndex = $(this).data(
                    'column'); // Índice de la columna correspondiente al checkbox
                const column = table.column(columnIndex);

                // Mostrar u ocultar columna según el estado del checkbox
                column.visible($(this).is(':checked'));

                // Reorganizar columnas para mantener Botones al final
                moveButtonsColumnToEnd(table);
            });

            // Asegurar que la columna de botones siempre esté al final tras cerrar el modal
            $('#columnToggleModal').on('hidden.bs.modal', function() {
                moveButtonsColumnToEnd(table);
            });

            // Función para mover la columna de botones al final
            function moveButtonsColumnToEnd(tableInstance) {
                const allColumns = tableInstance.columns().nodes().length;
                const buttonsColumnIndex = 8; // Índice fijo para la columna de botones

                // Obtener índices visibles excepto el de la columna de botones
                const visibleColumns = tableInstance.columns(':visible').indexes().toArray().filter(index =>
                    index !== buttonsColumnIndex);

                // Reordenar columnas: visibles + columna de botones
                const newOrder = [...visibleColumns, buttonsColumnIndex];
                tableInstance.colReorder.order(newOrder);
            }

            // Mover la columna de botones al final al inicializar
            moveButtonsColumnToEnd(table);
        });
    </script>
@stop

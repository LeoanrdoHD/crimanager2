@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')
@section('content_header')
    <h1 class="text-center">
        Registro de Captura de: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}
    </h1>
@endsection

@section('content')
    <style>
        h3 {
            color: #28a745;
            /* Verde oscuro */
            font-weight: 700;
            /* Grosor medio */
            text-transform: uppercase;
            /* Convierte el texto a mayúsculas */
            font-size: 25px;
            /* Tamaño ligeramente mayor que el h4 */
            letter-spacing: 0.5px;
            /* Espaciado sutil entre letras */
            margin-bottom: 12px;
            /* Espacio debajo */
        }

        h4.section-title {
            color: #28a745;
            /* Verde oscuro */
            font-weight: 700;
            /* Grosor medio */
            text-transform: uppercase;
            /* Convierte el texto a mayúsculas */
            font-size: 18px;
            /* Tamaño reducido */
            letter-spacing: 0.5px;
            /* Menor espaciado entre letras */
            margin-bottom: 10px;
            /* Ajusta el espacio debajo del título */
        }



        .card {
            background-color: #333;
            /* Fondo oscuro */
            color: rgb(255, 255, 255);
            /* Texto blanco */
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header h3 {
            margin: 0;
            text-align: center;
            font-weight: bold;
        }

        .card-body {
            padding: 1px;
        }

        .row {
            margin-bottom: 1px;
        }

        .col-md-4,
        .col-md-3,
        .col-md-5 {
            padding: 10px;
        }

        p {
            margin: 6px 0;
            /* Reduce espacio entre líneas */
            font-size: 16px;
            /* Ajusta el tamaño del texto */
            text-transform: uppercase;
            /* Convierte a mayúsculas */
        }


        strong {
            text-transform: uppercase;
            font-weight: bold;
        }

        h5 {
            text-transform: uppercase;
            color: #ddd;
            margin-bottom: 10px;
            border-bottom: 1px solid #555;
            padding-bottom: 5px;
            font-size: 14px;
        }

        .img-thumbnail {
            border-radius: 10%;
            /* Ajusta redondez de las imágenes */
            object-fit: cover;
            max-width: 100%;
        }

        .g-3 .col-6 {
            margin-bottom: 10px;
            /* Reduce espacio entre imágenes */
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        hr {
            border: 0.5px solid #555;
            margin: 5px 0;
        }

        /* Ajuste de alineación en Características Físicas */
        .characteristics-row {
            display: flex;
            flex-wrap: wrap;
            /* Permite ajuste de líneas */
            gap: 5px;
            /* Espacio entre columnas */
        }

        .characteristics-row>div {
            flex: 1 1 45%;
            /* 2 columnas por fila */
        }
    </style>
    <div class="todo">
    <div class="card">
        <div class="card-header">
            <h3>Información del Criminal</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Información de Nombres y Documento (4/12 columnas) -->
                <div class="col-md-4">
                    <p><strong>Nombres y Apellidos:</strong> {{ $criminal->first_name }} {{ $criminal->last_nameP }}
                        {{ $criminal->last_nameM }}</p>
                    <p><strong>Alias:</strong> {{ $criminal->alias_name }}</p>
                    <p><strong>Número de Identidad:</strong> {{ $criminal->identity_number }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $criminal->date_of_birth }}</p>
                    <p><strong>Edad:</strong> {{ $criminal->age }}</p>
                    <label>Lugar de Nacimiento:</label>
                    <p><strong></strong> {{ $criminal->country->country_name ?? 'No especificado' }} -
                        {{ $criminal->state->state_name ?? 'No especificado' }} -
                        {{ $criminal->city->city_name ?? 'No especificada' }}</p>
                    <p><strong>Nacionalidad:</strong>
                        {{ $criminal->nationality->nationality_name ?? 'No especificado' }}</p>
                    <p><strong>Estado Civil:</strong> {{ $criminal->civilState->civil_state_name ?? 'No especificado' }}
                    </p>
                    <p><strong>Ocupación:</strong> {{ $criminal->occupation->ocupation_name ?? 'No especificado' }}</p>

                </div>

                <div class="col-md-3">
                    @if ($criminal->photographs->first())
                        <img src="{{ asset($criminal->photographs->first()->face_photo) }}"
                            alt="Foto Frontal de {{ $criminal->first_name }}" class="img-fluid1 img-thumbnail1"
                            style="width: 100%; max-width: 225px; border-radius: 20%; object-fit: cover;">
                        <p><strong>Fotografía Rostro</strong></p>
                    @else
                        <p>No hay fotografía de Rostro disponible.</p>
                    @endif
                </div>

                <!-- Galería de Fotografías Restantes (5/12 columnas) -->
                <div class="col-md-5">
                    <h5>Otras Fotografías:</h5>
                    <div class="row g-3">
                        <!-- Fotografía de cuerpo completo -->
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->frontal_photo) }}"
                                class="img-fluid img-thumbnail" alt="Foto de Barra"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p><strong>Fotografía Frontal</strong></p>
                        </div>
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->full_body_photo) }}"
                                class="img-fluid img-thumbnail" alt="Foto de Cuerpo Completo"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p class="text-center"><strong>Cuerpo Completo</strong></p>
                        </div>
                        <!-- Fotografía de Perfil Izquierdo -->
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->profile_izq_photo) }}"
                                class="img-fluid img-thumbnail" alt="Perfil Izquierdo"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p><strong>Perfil Izquierdo</strong></p>
                        </div>
                        <!-- Fotografía de Perfil Derecho -->
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->profile_der_photo) }}"
                                class="img-fluid img-thumbnail" alt="Perfil Derecho"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p><strong>Perfil Derecho</strong></p>
                        </div>
                        <!-- Fotografía Adicional -->
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->aditional_photo) }}"
                                class="img-fluid img-thumbnail" alt="Foto Adicional"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p><strong>Fotografía Adicional</strong></p>
                        </div>
                        <!-- Fotografía de Barra -->
                        <div class="col-6 col-sm-4">
                            <img src="{{ asset($criminal->photographs->first()->barra_photo) }}"
                                class="img-fluid img-thumbnail" alt="Foto de Barra"
                                style="width: 50%; max-width: 125px; border-radius: 20%; object-fit: cover;">
                            <p><strong>Fotografía de Barra</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <h4 class="section-title">Direccion de Residencia:</h4>
                    @forelse ($criminal->criminalAddresses as $address)
                        <p><strong></strong> {{ $address->country->country_name ?? 'No especificado' }} -
                            {{ $address->state->state_name ?? 'No especificado' }} -
                            {{ $address->city->city_name ?? 'No especificada' }}</p>
                        <p><strong>Dirección:</strong> {{ $address->street ?? 'No especificado' }}</p>
                    @empty
                        <p>No hay direcciones registradas para este criminal.</p>
                    @endforelse
                </div>
                <div class="col-md-3">
                    <h4 class="section-title">Referencias:</h4>
                    @forelse ($criminal->criminalPartner as $Partner)
                        <p><strong>Persona de Referencia:</strong> {{ $Partner->partner_name ?? 'No especificado' }}</p>
                        <p><strong>Relacion con el Delincuente:</strong>
                            {{ $Partner->relationshipType->relationship_type_name ?? 'No especificado' }}</p>
                        <p><strong>Dirección:</strong> {{ $Partner->partner_address ?? 'No especificado' }}</p>
                    @empty
                        <p>No hay direcciones registradas para este criminal.</p>
                    @endforelse
                </div>

                <div class="col-md-5">
                    <h4 class="section-title">Caracteristicas Fisicas:</h4>
                    @forelse ($criminal->physicalCharacteristics as $characteristic)
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-5">
                                <p><strong>Altura:</strong> {{ $characteristic->height ?? 'No especificado' }} cm</p>
                                <p><strong>Peso:</strong> {{ $characteristic->weight ?? 'No especificado' }} kg</p>
                                <p><strong>Sexo:</strong> {{ $characteristic->sex ?? 'No especificado' }}</p>
                                <p><strong>Género:</strong>
                                    {{ $characteristic->criminalGender->gender_name ?? 'No especificado' }}</p>
                                <p><strong>Complexión:</strong>
                                    {{ $characteristic->confleccion->conflexion_name ?? 'No especificado' }}</p>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-7">
                                <p><strong>Color de Piel:</strong>
                                    {{ $characteristic->skinColor->skin_color_name ?? 'No especificado' }}</p>
                                <p><strong>Tipo de Ojos:</strong>
                                    {{ $characteristic->eyeType->eye_type_name ?? 'No especificado' }}</p>
                                <p><strong>Tipo de Oídos:</strong>
                                    {{ $characteristic->earType->ear_type_name ?? 'No especificado' }}</p>
                                <p><strong>Tipo de Labios:</strong>
                                    {{ $characteristic->lipType->lip_type_name ?? 'No especificado' }}</p>
                                <p><strong>Tipo de Nariz:</strong>
                                    {{ $characteristic->noseType->nose_type_name ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Marcas Distintivas:</strong>
                                    {{ $characteristic->distinctive_marks ?? 'No especificadas' }}</p>
                            </div>
                        </div>
                    @empty
                        <p>No hay características físicas disponibles para este criminal.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Detalles del Historial de Arresto</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p>
                        <strong>Registro de Captura:</strong>
                        <span style="font-style: italic;">
                            Fecha: {{ $history->arrest_date }}, Hora: {{ $history->arrest_time }}
                        </span>
                    </p>

                    @if ($history->legalStatus)
                        <p><strong>Situación Legal:</strong> {{ $history->legalStatus->status_name }}</p>
                    @endif

                    @if ($history->apprehensionType)
                        <p><strong>Tipo de Captura:</strong> {{ $history->apprehensionType->type_name }}</p>
                    @endif

                    @if ($history->cud_number)
                        <p><strong>Número de CUD:</strong> {{ $history->cud_number }}</p>
                    @endif

                    @if ($history->arrest_location)
                        <p><strong>Lugar de Captura:</strong> {{ $history->arrest_location }}</p>
                    @endif

                    @if ($history->criminal_specialty_id)
                        <p><strong>Especialidad o Motivo de Captura:</strong>
                            {{ $history->criminalSpecialty->specialty_name }}
                        </p>
                    @endif

                    @if ($history->arrest_details)
                        <p><strong>Detalles de Captura:</strong> {{ $history->arrest_details }}</p>
                    @endif
                </div>
                <!-- HERRAMIENTAS Y ARMAS -->
                <div class="col-md-4">
                    <h4 class="section-title">Objetos, Armas y Herramientas Usadas:</h4>

                    @if ($history->criminalTools->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalTools as $tool)
                                <div class="tool-item">
                                    <p><strong>Tipo:</strong> {{ $tool->toolType->tool_type_name }}</p>
                                    <p><strong>Descripción:</strong> {{ $tool->tool_details }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron herramientas relacionadas para este historial.</p>
                    @endif

                </div>
                <div class="col-md-4">
                    <h4 class="section-title">Numero de Telefono Usados:</h4>

                    @if ($history->phoneNumber->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->phoneNumber as $phone)
                                <div class="tool-item">
                                    <p><strong>Compañia:</strong> {{ $phone->phone_number }}</p>
                                    <p><strong>Nro. Celular:</strong> {{ $phone->company->companies_name }}</p>
                                    <p><strong>Nro. IMEI:</strong> {{ $phone->imei_number }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron nuneros de telefono relacionadas para este historial.</p>
                    @endif

                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <h4 class="section-title">Otras Identidades:</h4>
                    @if ($history->criminalAliase->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalAliase as $aliase)
                                <div class="tool-item">
                                    <p><strong>Nombres y Apellidos:</strong> {{ $aliase->alias_name }}</p>
                                    <p><strong>Nro de Identidad:</strong> {{ $aliase->alias_identity_number }}</p>
                                    <p><strong>Nacionalidad:</strong> {{ $aliase->nationality->nationality_name }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron Identidades relacionadas para este historial.</p>
                    @endif
                    <h4 class="section-title">Otra Direccion de Residencia:</h4>
                    @if ($history->criminalAliase->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalAliase as $aliase)
                                <div class="tool-item">
                                    <strong>PAIS - ESTADO - CIUDAD:</strong>
                                    <p> {{ $address->country->country_name ?? 'No especificado' }} -
                                        {{ $address->state->state_name ?? 'No especificado' }} -
                                        {{ $address->city->city_name ?? 'No especificada' }}</p>
                                    <p><strong>Dirección:</strong> {{ $address->street ?? 'No especificado' }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron direcciones relacionadas para este historial.</p>
                    @endif
                </div>
                <!-- HERRAMIENTAS Y ARMAS -->
                <div class="col-md-4">
                    <h4 class="section-title">Nombre de Complices:</h4>

                    @if ($history->criminalComplice->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalComplice as $complice)
                                <div class="tool-item">
                                    <p><strong>Nombres Y Apellidos:</strong> {{ $complice->complice_name }}</p>
                                    <p><strong>Nro. de Identidad:</strong> {{ $complice->CI_complice }}</p>
                                    <p><strong>Otros detalles:</strong> {{ $complice->detail_complice }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron complices relacionados para este historial.</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <h4 class="section-title">Organizacion Criminal:</h4>
                    @if ($history->criminalOrganization->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalOrganization as $grupo)
                                <div class="tool-item">
                                    <p><strong>Nombre:</strong> {{ $grupo->organization->organization_name }}</p>
                                    <p><strong>Especialidad:</strong>
                                        {{ $grupo->organization->Criminal_Organization_Specialty }}</p>
                                    <p><strong>Rol en la Organizacion:</strong> {{ $grupo->criminal_rol }}</p>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron Organizaciones criminales relacionadas para este historial.</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h4 class="section-title">Vehículos Usados en el Hecho:</h4>
                    @if ($history->criminalVehicle->isNotEmpty())
                        <div class="row">
                            @foreach ($history->criminalVehicle as $vehicle)
                                <div class="col-md-6 mb-4"> <!-- Dividimos en 2 columnas -->
                                    <div class="tool-item">
                                        <p><strong>Color:</strong> {{ $vehicle->vehicleColor->color_name }}</p>
                                        <p><strong>Tipo:</strong> {{ $vehicle->vehicleType->vehicle_type_name }}</p>
                                        <p><strong>Año:</strong> {{ $vehicle->year }}</p>
                                        <p><strong>Marca:</strong> {{ $vehicle->brandVehicle->brand_name }}</p>
                                        <p><strong>Modelo:</strong> {{ $vehicle->model }}</p>
                                        <p><strong>Industria:</strong> {{ $vehicle->industry->industry_name }}</p>
                                        <p><strong>Placa:</strong> {{ $vehicle->license_plate }}</p>
                                        <p><strong>Servicio:</strong> {{ $vehicle->vehicleService->service_name }}</p>
                                        <p><strong>Detalles:</strong> {{ $vehicle->details }}</p>
                                    </div>
                                    <hr class="separator"> <!-- Línea separadora -->
                                </div>
                                <div class="col-md-6 mb-4"> <!-- Dividimos en 2 columnas -->
                                    <div class="tool-item">
                                        @if ($vehicle->itv_valid)
                                            <p><strong>ITV válido:</strong> Sí</p>
                                            <p><strong>Tipo:</strong> {{ $vehicle->user_name }}</p>
                                            <p><strong>Año:</strong> {{ $vehicle->user_ci }}</p>
                                            <p><strong>Relación con el propietario:</strong>
                                                {{ $vehicle->relationshipWithOwner->relationship_name }}</p>
                                            <p><strong>Marca:</strong> {{ $vehicle->observations }}</p>
                                            <p><strong>Modelo:</strong> {{ $vehicle->driver_name }}</p>
                                        @else
                                            <p>No tiene inspección técnica vehicular (ITV).</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron Identidades relacionadas para este historial.</p>
                    @endif
                </div>

                <!-- CONDENAS -->
                <div class="col-md-4">
                    <h4 class="section-title">CONDENAS:</h4>
                    @if ($history->criminalConviction->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->criminalConviction as $condena)
                                <div class="tool-item">
                                    <p><strong>Tipo de Condena:</strong> {{ $condena->detentionType->detention_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No se encontraron complices relacionados para este historial.</p>
                    @endif
                    @if ($history->preventiveDetentions->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->preventiveDetentions as $preventivo)
                                <div class="tool-item">
                                    <p><strong>Prisión:</strong> {{ $preventivo->prison->prison_name }}</p>
                                    <p><strong>Dirección de la Prisión:</strong> {{ $preventivo->prison->prison_location }}
                                    </p>
                                    <strong>PAÍS - ESTADO - CIUDAD:</strong>
                                    <p>{{ $preventivo->prison->country->country_name }} -
                                        {{ $preventivo->prison->state->state_name }} -
                                        {{ $preventivo->prison->city->city_name }}</p>
                                    <p><strong>Fecha de Entrada:</strong> {{ $preventivo->prison_entry_date }}</p>
                                    <p><strong>Fecha de Salida:</strong> {{ $preventivo->prison_release_date }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($history->extraditions->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->extraditions as $extradicion)
                                <div class="tool-item">
                                    </p>
                                    <strong>PAÍS - CIUDAD:</strong>
                                    <p>{{ $extradicion->country->country_name }} -
                                        {{ $extradicion->state->state_name }}</p>
                                    <p><strong>Fecha de Extradición:</strong> {{ $extradicion->extradition_date }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($history->houseArrests->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->houseArrests as $harrest)
                                <div class="tool-item">
                                    <p><strong>Dirección de Arresto Domiciliario:</strong>
                                        {{ $harrest->house_arrest_address }}
                                    </p>
                                    <strong>PAÍS - ESTADO - CIUDAD:</strong>
                                    <p>{{ $harrest->country->country_name }} -
                                        {{ $harrest->state->state_name }} -
                                        {{ $harrest->city->city_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($history->liberties->isNotEmpty())
                        <div class="tools-list">
                            @foreach ($history->liberties as $liberty)
                                <div class="tool-item">
                                    <p><strong>Dirección:</strong>
                                        {{ $liberty->house_address }}
                                    </p>
                                    <strong>PAÍS - ESTADO - CIUDAD:</strong>
                                    <p>{{ $liberty->country->country_name }} -
                                        {{ $liberty->state->state_name }} -
                                        {{ $liberty->city->city_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="text-center">
        <style>
            .btn-export-pdf {
                background-color: red;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
            }
            .btn-imprimir {
                background-color: rgb(64, 131, 232);
                color: white;
                padding: 8px 15px;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
        <a href="{{ route('generate-pdf', $criminal->id) }}" class="btn-export-pdf">Exportar a PDF</a>
        <button id="printButton" class="btn-imprimir">Imprimir</button>

        <script>
            document.getElementById('printButton').addEventListener('click', function() {
                const printContents = document.querySelector('.todo').outerHTML;
                const originalContents = document.body.innerHTML;

                const printHTML = `
                        <html>
                        <head>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    color: #000 !important;
                                    background-color: #fff;
                                }
                                .card {
                                    border: 1px solid #ccc;
                                    margin: 10px;
                                    padding: 20px;
                                    border-radius: 10px;
                                    background-color: #fff;
                                }
                                .img-thumbnail {
                                    object-fit: cover;
                                    width: 200px;
                                    height: 150px;
                                    margin: 10px;
                                }
                                h3, h4, p, strong {
                                    color: #000 !important;
                                      text-transform: uppercase;
                                }
                                      
                            </style>
                        </head>
                        <body>
                            ${printContents}
                        </body>
                        </html>
                    `;

                document.body.innerHTML = printHTML;
                window.print();
                document.body.innerHTML = originalContents;
                window.location.reload();
            });
        </script>
    </div>
    <br>
@endsection

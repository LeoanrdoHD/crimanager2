<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLA A TODOAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        h3 {
            color: #101110FF;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 25px;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        h4.section-title {
            color: #030303FF;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .listah {
            font-size: 18px;
            font-weight: bold;
            color: #0A0A0AFF;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .card {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
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
            margin: 4px 0;
            font-size: 12px;
            text-transform: capitalize;
        }

        strong {
            text-transform: capitalize;
            font-weight: bold;
            font-size: 12px;
        }

        h5 {
            text-transform: uppercase;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 13px;
        }

        .img-thumbnail {
            border-radius: 10%;
            object-fit: cover;
            max-width: 100%;
        }

        .g-3 .col-6 {
            margin-bottom: 10px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        hr {
            border: 0.5px solid #ddd;
            margin: 5px 0;
        }

        .characteristics-row {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .characteristics-row>div {
            flex: 1 1 45%;
        }

        .arrest-history {
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 20px;
            padding: 15px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .tool-item,
        .tool-item p {
            margin: 0;
        }

        .separator {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        .arrest-history {
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f8f9fa;
            color: #333;
            margin-bottom: 20px;
            padding: 15px;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        /* New styles for two columns */
        .two-columns {
            display: flex;
            flex-wrap: wrap;
        }

        .two-columns>div {
            flex: 1 1 50%;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Footer style */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="two-columns">

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
                        <p><strong>Estado Civil:</strong>
                            {{ $criminal->civilState->civil_state_name ?? 'No especificado' }}</p>
                        <p><strong>Ocupación:</strong> {{ $criminal->occupation->ocupation_name ?? 'No especificado' }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="section-title">Direcciones de Residencia:</h4>
                        @forelse ($criminal->criminalAddresses as $address)
                            <p><strong></strong> {{ $address->country->country_name ?? 'No especificado' }} -
                                {{ $address->state->state_name ?? 'No especificado' }} -
                                {{ $address->city->city_name ?? 'No especificada' }}</p>
                            <p><strong>Dirección:</strong> {{ $address->street ?? 'No especificado' }}</p>
                        @empty
                            <p>No hay direcciones registradas para este criminal.</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-3">
                    @forelse ($criminal->criminalPartner as $Partner)
                        <p><strong>Persona de Referencia:</strong> {{ $Partner->partner_name ?? 'No especificado' }}
                        </p>
                        <p><strong>Relacion con el Delincuente:</strong>
                            {{ $Partner->relationshipType->relationship_type_name ?? 'No especificado' }}</p>
                        <p><strong>Dirección:</strong> {{ $Partner->partner_address ?? 'No especificado' }}</p>
                    @empty
                        <p>No hay direcciones registradas para este criminal.</p>
                    @endforelse
                </div>

                <div class="col-md-5">
                    <h4 class="section-title">Caracteristicas Físicas:</h4>
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
        <div class="card">
            <div class="card-header">
                <h3>Lista de Historial de Arrestos</h3>
            </div>
            <div class="card-body">
                @if ($criminal->arrestHistories->isNotEmpty())
                    @foreach ($criminal->arrestHistories as $history)
                        <div class="arrest-history mb-4 p-3" <p class=" text-center">
                            @php
                                // Convertir la fecha y hora usando el espacio de nombres completo
                                $formattedDate = \Carbon\Carbon::parse($history->arrest_date)->translatedFormat(
                                    'l d \d\e F \d\e Y',
                                );
                                $formattedTime = \Carbon\Carbon::parse($history->arrest_time)->format('H:i');

                                // Determinar si es mañana o tarde
                                $formattedTimePeriod =
                                    \Carbon\Carbon::parse($history->arrest_time)->format('H') < 12
                                        ? 'de la mañana'
                                        : 'de la tarde';
                            @endphp

                            <strong class="listah">Historial de arresto del {{ $formattedDate }} a las
                                {{ $formattedTime }} {{ $formattedTimePeriod }}</strong>

                            </p>
                            <div class="row">
                                <!-- Columna 1: Detalles del Arresto -->
                                <div class="col-md-4">

                                    @if ($history->legalStatus)
                                        <p><strong>Situación Legal:</strong> {{ $history->legalStatus->status_name }}
                                        </p>
                                    @endif

                                    @if ($history->apprehensionType)
                                        <p><strong>Tipo de Captura:</strong>
                                            {{ $history->apprehensionType->type_name }}
                                        </p>
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

                                <!-- Columna 2: Herramientas y Armas -->
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

                                <!-- Columna 3: Números de Teléfono -->
                                <div class="col-md-4">
                                    <h4 class="section-title">Números de Teléfono Usados:</h4>

                                    @if ($history->phoneNumber->isNotEmpty())
                                        <div class="tools-list">
                                            @foreach ($history->phoneNumber as $phone)
                                                <div class="tool-item">
                                                    <p><strong>Compañía:</strong> {{ $phone->company->companies_name }}
                                                    </p>
                                                    <p><strong>Nro. Celular:</strong> {{ $phone->phone_number }}</p>
                                                    <p><strong>Nro. IMEI:</strong> {{ $phone->imei_number }}</p>
                                                    <hr class="separator"> <!-- Línea separadora -->
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No se encontraron números de teléfono relacionados para este historial.</p>
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
                                                    <p><strong>Nombres y Apellidos:</strong> {{ $aliase->alias_name }}
                                                    </p>
                                                    <p><strong>Nro de Identidad:</strong>
                                                        {{ $aliase->alias_identity_number }}
                                                    </p>
                                                    <p><strong>Nacionalidad:</strong>
                                                        {{ $aliase->nationality->nationality_name }}</p>
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
                                                    <p><strong>Dirección:</strong>
                                                        {{ $address->street ?? 'No especificado' }}
                                                    </p>
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
                                                    <p><strong>Nombres Y Apellidos:</strong>
                                                        {{ $complice->complice_name }}
                                                    </p>
                                                    <p><strong>Nro. de Identidad:</strong> {{ $complice->CI_complice }}
                                                    </p>
                                                    <p><strong>Otros detalles:</strong>
                                                        {{ $complice->detail_complice }}
                                                    </p>
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
                                                    <p><strong>Nombre:</strong>
                                                        {{ $grupo->organization->organization_name }}
                                                    </p>
                                                    <p><strong>Especialidad:</strong>
                                                        {{ $grupo->organization->Criminal_Organization_Specialty }}</p>
                                                    <p><strong>Rol en la Organizacion:</strong>
                                                        {{ $grupo->criminal_rol }}
                                                    </p>
                                                    <hr class="separator"> <!-- Línea separadora -->
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No se encontraron Organizaciones criminales relacionadas para este historial.
                                        </p>
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
                                                        <p><strong>Color:</strong>
                                                            {{ $vehicle->vehicleColor->color_name }}
                                                        </p>
                                                        <p><strong>Tipo:</strong>
                                                            {{ $vehicle->vehicleType->vehicle_type_name }}</p>
                                                        <p><strong>Año:</strong> {{ $vehicle->year }}</p>
                                                        <p><strong>Marca:</strong>
                                                            {{ $vehicle->brandVehicle->brand_name }}
                                                        </p>
                                                        <p><strong>Modelo:</strong> {{ $vehicle->model }}</p>
                                                        <p><strong>Industria:</strong>
                                                            {{ $vehicle->industry->industry_name }}
                                                        </p>
                                                        <p><strong>Placa:</strong> {{ $vehicle->license_plate }}</p>
                                                        <p><strong>Servicio:</strong>
                                                            {{ $vehicle->vehicleService->service_name }}</p>
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
                                                                {{ $vehicle->relationshipWithOwner->relationship_name }}
                                                            </p>
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
                                                    <p><strong>Tipo de Condena:</strong>
                                                        {{ $condena->detentionType->detention_name }}</p>
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
                                                    <p><strong>Prisión:</strong> {{ $preventivo->prison->prison_name }}
                                                    </p>
                                                    <p><strong>Dirección de la Prisión:</strong>
                                                        {{ $preventivo->prison->prison_location }}
                                                    </p>
                                                    <strong>PAÍS - ESTADO - CIUDAD:</strong>
                                                    <p>{{ $preventivo->prison->country->country_name }} -
                                                        {{ $preventivo->prison->state->state_name }} -
                                                        {{ $preventivo->prison->city->city_name }}</p>
                                                    <p><strong>Fecha de Entrada:</strong>
                                                        {{ $preventivo->prison_entry_date }}
                                                    </p>
                                                    <p><strong>Fecha de Salida:</strong>
                                                        {{ $preventivo->prison_release_date }}
                                                    </p>
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
                                                    <p><strong>Fecha de Extradición:</strong>
                                                        {{ $extradicion->extradition_date }}</p>
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
                    @endforeach
                @else
                    <p>No hay registros de arresto disponibles para este criminal.</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var connectors = ["es", "la", "y", "o", "u", "que", "de", "en", "con", "a", "el", "los", "las"];
            var paragraphs = document.querySelectorAll("p");
            var footer = document.createElement("div");
            paragraphs.forEach(function(paragraph) {
                var words = paragraph.innerText.split(" ");
                var formattedText = words.map(function(word) {
                    return connectors.includes(word.toLowerCase()) ? word.toLowerCase() : word
                        .charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                }).join(" ");
                paragraph.innerText = formattedText;
            });
            footer.className = "footer";
            footer.innerText = "GENERADO EL " + new Date().toLocaleString() + " DACI ORURO";
            document.body.appendChild(footer);
        });
    </script>
</body>

</html>

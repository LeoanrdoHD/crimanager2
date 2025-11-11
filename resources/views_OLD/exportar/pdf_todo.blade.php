<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Delincuente</title>
    <style>
        @page {
            background: transparent;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            position: relative;
            height: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-size: 12px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 1.2em;
        }

        .header-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .logo {
            height: 60px;
            flex-shrink: 0;
            /* Impide que el logo se encoja */
        }

        .section-title {
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
            font-size: 12px;
        }

        .photo-cell {
            text-align: center;
        }

        .table-inner {
            width: 100%;
            margin-top: 10px;
        }

        .table-inner td {
            text-align: center;
            padding: 4px;
        }

        .spaced {
            padding-bottom: 10px;
        }

        .info-item {
            margin-bottom: 5px;
            /* Reduce el espacio entre elementos */
            line-height: 1;
            /* Reduce el interlineado */
            display: flex;
            align-items: baseline;
        }

        .label-bold {
            font-weight: bold;
            /* Negrita para etiquetas */
            margin-right: 5px;
            /* Espaciado con el contenido */
        }

        .text-uppercase {
            text-transform: uppercase;
            /* Convierte el texto a mayúsculas */
            font-weight: normal;
            /* Letras normales */
        }

        /* Elementos de información */
        .info-item {
            margin-bottom: 5px;
            display: flex;
            align-items: baseline;
        }

        /* Texto predeterminado */
        .no-data {
            font-style: italic;
            color: #666;
        }

        .signature-cell,
        .seal-cell {
            text-align: center;
            vertical-align: middle;
            padding-top: 70px;
            /* Espaciado solo arriba */
        }

        .signature-cell span,
        .seal-cell span {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            /* Espacio entre la línea y el texto */
        }

        .signature-line {
            border-top: 1px solid black;
            width: 70%;
            /* Ajusta el ancho de la línea según sea necesario */
            margin: 0 auto;
        }

        .watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 180%;
            height: 180%;
            z-index: -1;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgba(0, 0, 0, 0.1);
            /* Color gris claro con opacidad */
            font-size: 150px;
            /* Tamaño del texto */
            font-weight: bold;
            /* Texto grueso */
            transform: rotate(-45deg);
            /* Girar todo el contenedor de texto */
            pointer-events: none;
            /* No afecta la interacción con el contenido */
            overflow: hidden;
        }

        .watermark-text {
            position: absolute;
            font-size: 150px;
            /* Tamaño ajustado para repetición */
            color: rgba(0, 0, 0, 0.1);
            /* Color claro para la marca */
            font-weight: bold;
            white-space: nowrap;
        }

        /* Repetición uniforme sin superposición */
        .watermark-text:nth-child(1) {
            top: 0%;
            left: 10%;
        }

        .watermark-text:nth-child(2) {
            top: 12%;
            left: -20%;
        }

        .watermark-text:nth-child(3) {
            top: 24%;
            left: -40%;
        }

        .watermark-text:nth-child(4) {
            top: 36%;
            left: -60%;
        }
    </style>
</head>

<body>
    <div class="watermark">
        <div class="watermark-text">D.A.C.D.A.C.I. D.A.C.I.</div>
        <div class="watermark-text">D.A.C.I D.A.C.I. D.A.C.I. </div>
        <div class="watermark-text">D.A.C.I. D.A.C.I. D.A.C.I.</div>
        <div class="watermark-text">D.A.C.I. D.A.C.I ORURO.</div>
    </div>
    <div class="header-title">
        <table style="width: 100%; table-layout: fixed; border: none;">
            <tr>
                <!-- Logo izquierdo (2 columnas) -->
                <td style="width: 20.66%; text-align: left; border: none;">
                    <img src="{{ public_path('storage/logo-pol.jpeg') }}" alt="Logo" style="height: 80px;">
                </td>

                <!-- Texto centrado (8 columnas) -->
                <td style="width: 66.66%; text-align: center; border: none;">
                    <span style="font-weight: bold; font-size: 14px;">
                        POLICÍA BOLIVIANA<br>
                        DIRECCIÓN DEPARTAMENTAL DE LA FUERZA ESPECIAL DE LUCHA CONTRA EL CRIMEN<br>
                        DEPARTAMENTO DE ANÁLISIS CRIMINAL E INTELIGENCIA
                    </span>
                </td>

                <!-- Logo derecho (2 columnas) -->
                <td style="width: 20.66%; text-align: right; border: none;">
                    <img src="{{ public_path('storage/logo_daci.png') }}" alt="Logo" style="height: 80px;">
                </td>
            </tr>
        </table>
    </div>


    <table>
        <!-- Fila de título de sección -->
        <tr>
            <td colspan="12" class="section-title">PERFIL DEL DELINCUENTE</td>
        </tr>
        <!-- Fila de Datos Generales -->
        <tr>
            <th colspan="5">DATOS GENERALES</th>
            <th colspan="2">FOTOGRAFIA ROSTRO</th>
            <th colspan="5">RASGOS FÍSICOS</th>
        </tr>
        <tr>
            <td colspan="5">
                <div class="info-item">
                    <span class="label-bold">Nombres y Apellidos:</span>
                    <span class="text-uppercase">
                        {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Alias:</span>
                    <span class="text-uppercase">{{ $criminal->alias_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Número de Identidad:</span>
                    <span class="text-uppercase">{{ $criminal->identity_number }}</span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Fecha de Nacimiento:</span>
                    <span class="text-uppercase">{{ $criminal->date_of_birth }}</span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Edad:</span>
                    <span class="text-uppercase">{{ $criminal->age }} AÑOS</span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Lugar de Nacimiento:</span>
                    <span class="text-uppercase">
                        {{ $criminal->country->country_name ?? 'No especificado' }} -
                        {{ $criminal->state->state_name ?? 'No especificado' }} -
                        {{ $criminal->city->city_name ?? 'No especificada' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Nacionalidad:</span>
                    <span class="text-uppercase">
                        {{ $criminal->nationality->nationality_name ?? 'No especificado' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Estado Civil:</span>
                    <span class="text-uppercase">
                        {{ $criminal->civilState->civil_state_name ?? 'No especificado' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="label-bold">Ocupación:</span>
                    <span class="text-uppercase">
                        {{ $criminal->occupation->ocupation_name ?? 'No especificado' }}
                    </span>
                </div>
            </td>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @if ($criminal->photographs->last())
                    <img src="{{ public_path($criminal->photographs->last()->face_photo) }}"
                        alt="Foto Frontal de {{ $criminal->first_name }}" class="img-fluid1 img-thumbnail1"
                        style="width:80%; height: auto; max-width: 150px; object-fit: cover;">
                @else
                    <p>No hay fotografía de Rostro disponible.</p>
                @endif
            </td>
            <td colspan="5">
                @forelse ($criminal->physicalCharacteristics as $characteristic)
                    <div class="physical-characteristics">
                        <!-- Columna 1 -->
                        <div class="column">
                            <div class="info-item">
                                <span class="label-bold">Altura:</span>
                                <span>{{ $characteristic->height ?? 'No especificado' }} cm</span>
                                <span class="label-bold"> Peso:</span>
                                <span>{{ $characteristic->weight ?? '-' }} kg</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Sexo:</span>
                                <span>{{ $characteristic->sex ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Género:</span>
                                <span>{{ $characteristic->criminalGender->gender_name ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Complexión:</span>
                                <span>{{ $characteristic->confleccion->conflexion_name ?? 'No especificado' }}</span>
                            </div>
                        </div>
                        <!-- Columna 2 -->
                        <div class="column">
                            <div class="info-item">
                                <span class="label-bold">Color de Piel:</span>
                                <span>{{ $characteristic->skinColor->skin_color_name ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Tipo de Ojos:</span>
                                <span>{{ $characteristic->eyeType->eye_type_name ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Tipo de Oídos:</span>
                                <span>{{ $characteristic->earType->ear_type_name ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Tipo de Labios:</span>
                                <span>{{ $characteristic->lipType->lip_type_name ?? 'No especificado' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label-bold">Tipo de Nariz:</span>
                                <span>{{ $characteristic->noseType->nose_type_name ?? 'No especificado' }}</span>
                            </div>
                        </div>
                        <!-- Marcas distintivas -->
                        <div class="full-width">
                            <div class="info-item">
                                <span class="label-bold">Marcas Distintivas:</span>
                                <span>{{ $characteristic->distinctive_marks ?? 'No especificadas' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-data">No hay características físicas disponibles para este criminal.</p>
                @endforelse

            </td>
        </tr>

        <!-- Otras Fotos -->
        <tr>
            <td colspan="12" class="section-title">OTRAS FOTOS</td>
        </tr>
        <tr>
            <td colspan="12">
        <tr>
            <th colspan="2">MEDIO CUERPO</th>
            <th colspan="2">PERFIL IZQ</th>
            <th colspan="2">PERFIL DERECHO</th>
            <th colspan="2">CUERPO COMPLETO</th>
            <th colspan="2">FOTO EXTRA</th>
            <th colspan="2">EN BARRA</th>
        </tr>
        <tr>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @if ($criminal->photographs->last())
                    <img src="{{ public_path($criminal->photographs->last()->frontal_photo) }}"
                        alt="Foto Frontal de {{ $criminal->first_name }}" class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>No hay fotografía de Rostro disponible.</p>
                @endif
            </td>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @if ($criminal->photographs->last())
                    <img src="{{ public_path($criminal->photographs->last()->profile_izq_photo) }}"
                        alt="Foto de Perfil Izquierdo de {{ $criminal->first_name }}"
                        class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>No hay fotografía de Perfil Izquierdo disponible.</p>
                @endif
            </td>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @if ($criminal->photographs->last())
                    <img src="{{ public_path($criminal->photographs->last()->profile_der_photo) }}"
                        alt="Foto de Perfil Derecho de {{ $criminal->first_name }}" class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>No hay fotografía de Perfil Derecho disponible.</p>
                @endif
            </td>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @if ($criminal->photographs->last())
                    <img src="{{ public_path($criminal->photographs->last()->full_body_photo) }}"
                        alt="Foto de Cuerpo Completo de {{ $criminal->first_name }}"
                        class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>No hay fotografía de Cuerpo Completo disponible.</p>
                @endif
            </td>
            <td colspan="2" class="photo-cell" style="text-align: center;">
                @php
                    $lastPhoto = $criminal->photographs->last(); // Obtener el último registro de fotografía
                    $photoPath = $lastPhoto ? public_path($lastPhoto->aditional_photo) : null; // Generar la ruta absoluta
                @endphp

                @if ($lastPhoto && file_exists($photoPath))
                    <img src="{{ asset($lastPhoto->aditional_photo) }}" alt=""
                        class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>VACIO</p>
                @endif
            </td>

            <td colspan="2" class="photo-cell" style="text-align: center;">
                @php
                    $lastPhoto = $criminal->photographs->last(); // Obtener el último registro de fotografía
                    $photoPath = $lastPhoto ? public_path($lastPhoto->barra_photo) : null; // Generar la ruta absoluta
                @endphp

                @if ($lastPhoto && file_exists($photoPath))
                    <img src="{{ asset($lastPhoto->barra_photo) }}" alt="" class="img-fluid1 img-thumbnail1"
                        style="width:80%; height:auto; max-width:150px; object-fit:cover;">
                @else
                    <p>VACIO.</p>
                @endif
            </td>



        </tr>
        <!-- Domicilio y Referencias -->
        <tr>
            <th colspan="6">DOMICILIO</th>
            <th colspan="6">REFERENCIAS</th>
        </tr>
        <tr>
            <td colspan="6">
                @php
                    $lastAddress = $criminal->criminalAddresses->last();
                @endphp

                @if ($lastAddress)
                    <div class="address-info">
                        <div class="info-item">
                            <span class="label-bold">País:</span>
                            <span
                                class="text-uppercase">{{ $lastAddress->country->country_name ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Departamento:</span>
                            <span
                                class="text-uppercase">{{ $lastAddress->state->state_name ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Ciudad:</span>
                            <span
                                class="text-uppercase">{{ $lastAddress->city->city_name ?? 'No especificada' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Dirección:</span>
                            <span class="text-uppercase">{{ $lastAddress->street ?? 'No especificado' }}</span>
                        </div>
                    </div>
                @else
                    <p class="no-data">No hay direcciones registradas para este criminal.</p>
                @endif

            </td>
            <td colspan="6">
                @forelse ($criminal->criminalPartner as $partner)
                    <div class="partner-info">
                        <div class="info-item">
                            <span class="label-bold">Persona de Referencia:</span>
                            <span class="text-uppercase">{{ $partner->partner_name ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Relación con el Delincuente:</span>
                            <span
                                class="text-uppercase">{{ $partner->relationshipType->relationship_type_name ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Dirección:</span>
                            <span class="text-uppercase">{{ $partner->partner_address ?? 'No especificado' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="no-data">No hay información registrada de compañeros para este criminal.</p>
                @endforelse

            </td>
        </tr>
        <!-- Historial de Arrestos -->
        <tr>
            <td colspan="12" class="section-title">HISTORIAL DE CAPTURAS</td>
        </tr>

        @foreach ($criminal->arrestHistories as $index => $history)
            <tr>
                <td colspan="12">
                    <p class="text-center">
                        @php
                            $formattedDate = \Carbon\Carbon::parse($history->arrest_date)->translatedFormat(
                                'l d \d\e F \d\e Y',
                            );
                            $formattedTime = \Carbon\Carbon::parse($history->arrest_time)->format('H:i'); // 24-hour format
                        @endphp
                        <strong class="listah">Nro. {{ $index + 1 }} del {{ $formattedDate }} a las
                            {{ $formattedTime }}</strong>
                    </p>
                </td>
            </tr>

            <!-- Detalles de Captura -->
            <tr>
                <td colspan="12">
                    <div class="info-item">
                        <span class="label-bold">Situación Legal:</span>
                        <span
                            class="text-uppercase">{{ $history->legalStatus->status_name ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label-bold">Tipo de Captura:</span>
                        <span
                            class="text-uppercase">{{ $history->apprehensionType->type_name ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label-bold">Número de CUD:</span>
                        <span class="text-uppercase">{{ $history->cud_number ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label-bold">Lugar de Captura:</span>
                        <span class="text-uppercase">{{ $history->arrest_location ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label-bold">Especialidad:</span>
                        <span
                            class="text-uppercase">{{ $history->criminalSpecialty->specialty_name ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label-bold">Detalles de Captura:</span>
                        <span class="text-uppercase">{{ $history->arrest_details ?? 'No especificado' }}</span>
                    </div>
                </td>
            </tr>

            <!-- Objetos, Teléfonos, Otras Identidades -->
            <tr>
                <th colspan="4">OBJETOS, ARMAS O HERRAMIENTAS</th>
                <th colspan="4">NÚMEROS DE TELÉFONOS USADOS</th>
                <th colspan="4">OTRAS IDENTIDADES</th>
            </tr>
            <tr>
                <td colspan="4">
                    @foreach ($history->criminalTools as $tool)
                        <div class="info-item">
                            <span class="label-bold">Tipo:</span>
                            <span
                                class="text-uppercase">{{ $tool->toolType->tool_type_name ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Descripción:</span>
                            <span class="text-uppercase">{{ $tool->tool_details ?? 'No especificado' }}</span>
                        </div>
                    @endforeach
                </td>
                <td colspan="4">
                    @foreach ($history->phoneNumber as $phone)
                        <div class="info-item">
                            <span class="label-bold">Nro. Celular:</span>
                            <span class="text-uppercase">{{ $phone->phone_number }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Compañía:</span>
                            <span class="text-uppercase">{{ $phone->company->companies_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Nro. IMEI:</span>
                            <span class="text-uppercase">{{ $phone->imei_number }}</span>
                        </div>
                    @endforeach
                </td>
                <td colspan="4">
                    @foreach ($history->criminalAliase as $aliase)
                        <div class="info-item">
                            <span class="label-bold">Nombres y Apellidos:</span>
                            <span class="text-uppercase">{{ $aliase->alias_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Nro de Identidad:</span>
                            <span class="text-uppercase">{{ $aliase->alias_identity_number ?? 'No especificado' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Nacionalidad:</span>
                            <span class="text-uppercase">{{ $aliase->nationality->nationality_name ?? 'No especificado' }}</span>
                        </div>
                    @endforeach
                </td>
            </tr>

            <!-- Cómplices y Organizaciones -->
            <tr>
                <th colspan="6">COMPLICES</th>
                <th colspan="6">ORGANIZACIONES</th>
            </tr>
            <tr>
                <td colspan="6">
                    @foreach ($history->criminalComplice as $complice)
                        <div class="info-item">
                            <span class="label-bold">Nombres y Apellidos:</span>
                            <span class="text-uppercase">{{ $complice->complice_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Nro. de Identidad:</span>
                            <span class="text-uppercase">{{ $complice->CI_complice }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Otros detalles:</span>
                            <span class="text-uppercase">{{ $complice->detail_complice }}</span>
                        </div>
                    @endforeach
                </td>
                <td colspan="6">
                    @foreach ($history->criminalOrganization as $group)
                        <div class="info-item">
                            <span class="label-bold">Nombre:</span>
                            <span class="text-uppercase">{{ $group->organization->organization_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Especialidad:</span>
                            <span
                                class="text-uppercase">{{ $group->organization->Criminal_Organization_Specialty }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Rol en la Organización:</span>
                            <span class="text-uppercase">{{ $group->criminal_rol }}</span>
                        </div>
                    @endforeach
                </td>
            </tr>

            <!-- Vehículo usado en el hecho -->
            <tr>
                <td colspan="12" class="section-title">VEHÍCULO USADO EN EL HECHO</td>
            </tr>
            <tr>
                <td colspan="12">
                    @foreach ($history->criminalVehicle as $vehicle)
                        <div class="info-item">
                            <span class="label-bold">Color:</span>
                            <span class="text-uppercase">{{ $vehicle->vehicleColor->color_name }}</span>
                            <span class="label-bold">Clase:</span>
                            <span class="text-uppercase">{{ $vehicle->vehicleType->vehicle_type_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Modelo:</span>
                            <span class="text-uppercase">{{ $vehicle->year }}</span>
                            <span class="label-bold">Marca:</span>
                            <span class="text-uppercase">{{ $vehicle->brandVehicle->brand_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Tipo:</span>
                            <span class="text-uppercase">{{ $vehicle->model}}</span>
                            <span class="label-bold">Industria:</span>
                            <span class="text-uppercase">{{ $vehicle->industry->industry_name}}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Placa:</span>
                            <span class="text-uppercase">{{ $vehicle->license_plate }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label-bold">Detalles:</span>
                            <span class="text-uppercase">{{ $vehicle->details }}</span>
                        </div>
                    @endforeach
                </td>
            </tr>
        @endforeach

        <tr>
            <td colspan="6" class="signature-cell">
                <div class="signature-line"></div>
                <span>JEFE DE DIVISIÓN:</span>
            </td>
            <td colspan="6" class="seal-cell">
                <span>SELLO DACI</span>
            </td>
        </tr>
        <tr>
            <td colspan="12" class="text-justify">
                <span>Generado a las {{ \Carbon\Carbon::now('America/La_Paz')->format('H:i:s') }} del
                    {{ \Carbon\Carbon::now('America/La_Paz')->translatedFormat('l d \d\e F \d\e Y') }}</span>
                <span style="float: right;"> Usuario:
                    {{ Auth::user()->name ?? 'Usuario desconocido' }}
                </span>

            </td>
        </tr>

    </table>
</body>

</html>

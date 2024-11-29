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
        .card {
            background-color: #333;
            /* Fondo oscuro */
            color: white;
            /* Texto blanco */
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header h3 {
            margin: 0;
            text-align: center;
            color: #ddd;
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

        .arrest-history {
    border: 1px solid #dddddd3b;
    border-radius: 10px;
    background-color: #201F1FFF;
    margin-bottom: 20px;
    padding: 15px;
}

.section-title {
    font-size: 18px;
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.tool-item,
.tool-item p {
    margin: 0;
}

.separator {
    border: 0;
    border-top: 1px solid #4a4a4a;
    margin: 10px 0;
}

    </style>
    <div class="card">
        <div class="card-header">
            <h3>Información del Criminal</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Información de Nombres y Documento (4/12 columnas) -->
                <div class="col-md-4" >
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
                            alt="Foto Frontal de {{ $criminal->first_name }}" class="img-fluid img-thumbnail"
                            style="width: 100%; max-width: 225px; border-radius: 20%; object-fit: cover;">
                        <p><strong>Fotografía Rostro</strong></p>
                    @else
                        <p>No hay fotografía de Rostro disponible.</p>
                    @endif
                </div>

                <!-- Galería de Fotografías Restantes (5/12 columnas) -->
                <div class="col-md-5" style="border: 1px solid #dddddd3b; border-radius: 10px; background-color: #24242492;">
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
                   
                    <label>Direccion de Recidencia:</label>
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
                    <label>Caracteristicas Fisicas:</label>
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
    <div class="card mt-4">
        <div class="card-header">
            <h3>Detalles del Historial de Arresto</h3>
        </div>
        <div class="card-body">
            @if ($criminal->arrestHistories->isNotEmpty())
                @foreach ($criminal->arrestHistories as $history)
                    <div class="arrest-history mb-4 p-3" style="border: 1px solid #dddddd3b; border-radius: 10px; background-color: #272727FF;">
                        <p class=" text-center">
                            <strong >Registro de Captura:   Fecha: {{ $history->arrest_date }}, Hora: {{ $history->arrest_time }}</strong>
                        </p>
                        <div class="row">
                            <!-- Columna 1: Detalles del Arresto -->
                            <div class="col-md-4">
                                           
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
                                                <p><strong>Compañía:</strong> {{ $phone->company->companies_name }}</p>
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
                    </div>
                @endforeach
            @else
                <p>No hay registros de arresto disponibles para este criminal.</p>
            @endif
        </div>
        
    </div>
    
    
    
@endsection

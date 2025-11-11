@extends('adminlte::page')

@section('title', 'Crimanager')
@section('content_header')
    <h1 class="text-center">
        Registro de Captura de: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}
    </h1>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/criminal-todo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            text-transform: uppercase;
            /* Convierte a mayúsculas */
        }

        .col-md-4,
        .col-md-3,
        .col-md-5 {
            padding: 10px;
        }

        .parrafo-1 {
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

        /* Estilos adicionales para los tabs */
        .nav-tabs .nav-link.active {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: #fff !important;
        }

        .nav-tabs .nav-link:hover {
            background-color: #555 !important;
            border-color: #555 !important;
            color: #fff !important;
        }

        .tab-content {
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tab-pane {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <div class="todo">
        <!-- Información Principal del Criminal -->
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-12">
                <div class="main-card mt-4" style="background: #000000; color: #ffffff;">

                    <div class="card-header">
                        <h3 class="section-title-main">
                            <i class="fas fa-user me-2"></i>Información del Criminal
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row g-2">
                            <!-- Información Personal -->
                            <div class="col-12 col-lg-4">
                                <div class="info-group">
                                    <div class="info-item">
                                        <strong>Nombres y Apellidos:</strong>
                                        <span>{{ $criminal->first_name }} {{ $criminal->last_nameP }}
                                            {{ $criminal->last_nameM }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Alias:</strong>
                                        <span>{{ $criminal->alias_name ?? 'No especificado' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Número de Identidad:</strong>
                                        <span>{{ $criminal->identity_number ?? 'No especificado' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Fecha de Nacimiento:</strong>
                                        <span>{{ $criminal->date_of_birth ? \Carbon\Carbon::parse($criminal->date_of_birth)->format('d/m/Y') : 'No especificada' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Edad:</strong>
                                        <span>{{ $criminal->age ?? 'No especificada' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Lugar de Nacimiento:</strong>
                                        <span>{{ $criminal->country->country_name ?? 'No especificado' }} -
                                            {{ $criminal->state->state_name ?? 'No especificado' }} -
                                            {{ $criminal->city->city_name ?? 'No especificada' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Nacionalidad:</strong>
                                        <span>{{ $criminal->nationality->nationality_name ?? 'No especificado' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Estado Civil:</strong>
                                        <span>{{ $criminal->civilState->civil_state_name ?? 'No especificado' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Ocupación:</strong>
                                        <span>{{ $criminal->occupation->ocupation_name ?? 'No especificado' }}</span>
                                    </div>
                                </div>
                            </div>

                            @php
                                // Convertir la fecha del arresto a un formato comparable con la fecha de las fotos
                                $arrestDate = \Carbon\Carbon::parse($history->arrest_date)->format('Y-m-d');

                                // Buscar la fotografía que coincida con la fecha del arresto
                                $photo = $criminal->photographs->firstWhere(function ($photo) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($photo->created_at)->format('Y-m-d') === $arrestDate;
                                });

                                // Si no se encuentra una foto que coincida, obtener la última foto
                                if (!$photo) {
                                    $photo = $criminal->photographs->last();
                                }

                                // Definir las fotografías disponibles según la fecha del arresto
                                $frontalPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$frontalPhoto) {
                                    $frontalPhoto = $criminal->photographs->last();
                                }

                                $fullBodyPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$fullBodyPhoto) {
                                    $fullBodyPhoto = $criminal->photographs->last();
                                }

                                $profileIzqPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$profileIzqPhoto) {
                                    $profileIzqPhoto = $criminal->photographs->last();
                                }

                                $profileDerPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$profileDerPhoto) {
                                    $profileDerPhoto = $criminal->photographs->last();
                                }

                                $aditionalPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$aditionalPhoto) {
                                    $aditionalPhoto = $criminal->photographs->last();
                                }

                                $barraPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                                    return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
                                });
                                if (!$barraPhoto) {
                                    $barraPhoto = $criminal->photographs->last();
                                }
                            @endphp

                            <!-- Foto Principal Expandida -->
                            <div class="col-12 col-lg-4">
                                <div class="main-photo-container-expanded">
                                    @if ($photo && $photo->face_photo)
                                        <div class="main-photo-wrapper" data-bs-toggle="modal"
                                            data-bs-target="#mainPhotoModal">
                                            <img src="{{ asset($photo->face_photo) }}"
                                                alt="Foto de {{ $criminal->first_name }}" class="main-photo-expanded">
                                        </div>
                                        <h5 class="photo-title-main">Fotografía Principal (Rostro)</h5>
                                    @else
                                        <div class="no-photo-expanded">
                                            <i class="fas fa-user fa-4x"></i>
                                            <p class="mt-3">No hay fotografía disponible</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Galería de Fotografías con Tabs -->
                            <div class="col-12 col-lg-4">
                                <div class="photo-gallery-expanded">
                                    @if ($frontalPhoto || $fullBodyPhoto || $profileIzqPhoto || $profileDerPhoto || $aditionalPhoto || $barraPhoto)
                                        <div class="photo-tabs-container">
                                            <ul class="nav nav-tabs nav-justified photo-tabs-custom" id="photoTabs"
                                                role="tablist">
                                                @if ($frontalPhoto && $frontalPhoto->frontal_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active photo-tab-btn" id="frontal-tab"
                                                            data-bs-toggle="tab" data-bs-target="#frontal" type="button"
                                                            role="tab">
                                                            <i class="fas fa-user"></i><span class="tab-text">Frontal</span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if ($fullBodyPhoto && $fullBodyPhoto->full_body_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link photo-tab-btn" id="fullbody-tab"
                                                            data-bs-toggle="tab" data-bs-target="#fullbody" type="button"
                                                            role="tab">
                                                            <i class="fas fa-male"></i><span class="tab-text">Cuerpo</span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if ($profileIzqPhoto && $profileIzqPhoto->profile_izq_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link photo-tab-btn" id="profile-izq-tab"
                                                            data-bs-toggle="tab" data-bs-target="#profile-izq"
                                                            type="button" role="tab">
                                                            <i class="fas fa-arrow-left"></i><span
                                                                class="tab-text">P.Izq</span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if ($profileDerPhoto && $profileDerPhoto->profile_der_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link photo-tab-btn" id="profile-der-tab"
                                                            data-bs-toggle="tab" data-bs-target="#profile-der"
                                                            type="button" role="tab">
                                                            <i class="fas fa-arrow-right"></i><span
                                                                class="tab-text">P.Der</span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if ($aditionalPhoto && $aditionalPhoto->aditional_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link photo-tab-btn" id="additional-tab"
                                                            data-bs-toggle="tab" data-bs-target="#additional" type="button"
                                                            role="tab">
                                                            <i class="fas fa-plus"></i><span class="tab-text">Extra</span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if ($barraPhoto && $barraPhoto->barra_photo)
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link photo-tab-btn" id="barra-tab"
                                                            data-bs-toggle="tab" data-bs-target="#barra" type="button"
                                                            role="tab">
                                                            <i class="fas fa-barcode"></i><span
                                                                class="tab-text">Barra</span>
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>

                                            <div class="tab-content photo-tab-content" id="photoTabContent">
                                                @if ($frontalPhoto && $frontalPhoto->frontal_photo)
                                                    <div class="tab-pane fade show active" id="frontal"
                                                        role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_frontal">
                                                            <img src="{{ asset($frontalPhoto->frontal_photo) }}"
                                                                class="tab-photo-expanded" alt="Fotografía Frontal">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Fotografía Frontal</h6>
                                                    </div>
                                                @endif
                                                @if ($fullBodyPhoto && $fullBodyPhoto->full_body_photo)
                                                    <div class="tab-pane fade" id="fullbody" role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_fullbody">
                                                            <img src="{{ asset($fullBodyPhoto->full_body_photo) }}"
                                                                class="tab-photo-expanded" alt="Cuerpo Completo">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Cuerpo Completo</h6>
                                                    </div>
                                                @endif
                                                @if ($profileIzqPhoto && $profileIzqPhoto->profile_izq_photo)
                                                    <div class="tab-pane fade" id="profile-izq" role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_profile_izq">
                                                            <img src="{{ asset($profileIzqPhoto->profile_izq_photo) }}"
                                                                class="tab-photo-expanded" alt="Perfil Izquierdo">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Perfil Izquierdo</h6>
                                                    </div>
                                                @endif
                                                @if ($profileDerPhoto && $profileDerPhoto->profile_der_photo)
                                                    <div class="tab-pane fade" id="profile-der" role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_profile_der">
                                                            <img src="{{ asset($profileDerPhoto->profile_der_photo) }}"
                                                                class="tab-photo-expanded" alt="Perfil Derecho">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Perfil Derecho</h6>
                                                    </div>
                                                @endif
                                                @if ($aditionalPhoto && $aditionalPhoto->aditional_photo)
                                                    <div class="tab-pane fade" id="additional" role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_additional">
                                                            <img src="{{ asset($aditionalPhoto->aditional_photo) }}"
                                                                class="tab-photo-expanded" alt="Foto Adicional">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Foto Adicional</h6>
                                                    </div>
                                                @endif
                                                @if ($barraPhoto && $barraPhoto->barra_photo)
                                                    <div class="tab-pane fade" id="barra" role="tabpanel">
                                                        <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                            data-bs-target="#photoModal_barra">
                                                            <img src="{{ asset($barraPhoto->barra_photo) }}"
                                                                class="tab-photo-expanded" alt="Foto de Barra">
                                                        </div>
                                                        <h6 class="photo-title-secondary">Foto de Barra</h6>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="no-photos-alert-expanded">
                                            <i class="fas fa-images fa-2x"></i>
                                            <p class="mt-3">No hay fotografías disponibles</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Segunda fila de información -->
                        <div class="row g-2 mt-2">
                            <!-- Domicilio -->
                            <div class="col-12 col-lg-4">
                                <div class="info-section">
                                    <h6 class="section-subtitle">
                                        <i class="fas fa-home me-1"></i>Domicilio de Referencia
                                    </h6>
                                    @forelse ($criminal->criminalAddresses as $address)
                                        <div class="info-item">
                                            <strong>Ubicación:</strong>
                                            <span>{{ $address->country->country_name ?? 'No especificado' }} -
                                                {{ $address->state->state_name ?? 'No especificado' }} -
                                                {{ $address->city->city_name ?? 'No especificada' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Dirección:</strong>
                                            <span>{{ $address->street ?? 'No especificado' }}</span>
                                        </div>
                                    @empty
                                        <div class="no-data">No hay direcciones registradas</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Referencias -->
                            <div class="col-12 col-lg-4">
                                <div class="info-section">
                                    <h6 class="section-subtitle">
                                        <i class="fas fa-users me-1"></i>Referencias
                                    </h6>
                                    @forelse ($criminal->criminalPartner as $Partner)
                                        <div class="info-item">
                                            <strong>Persona de Referencia:</strong>
                                            <span>{{ $Partner->partner_name ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Relación:</strong>
                                            <span>{{ $Partner->relationshipType->relationship_type_name ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <strong>Dirección:</strong>
                                            <span>{{ $Partner->partner_address ?? 'No especificado' }}</span>
                                        </div>
                                    @empty
                                        <div class="no-data">No hay referencias registradas</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Características Físicas -->
                            <div class="col-12 col-lg-4">
                                <div class="info-section">
                                    <h6 class="section-subtitle">
                                        <i class="fas fa-id-card me-1"></i>Características Físicas
                                    </h6>
                                    @forelse ($criminal->physicalCharacteristics as $characteristic)
                                        <div class="characteristics-grid">
                                            <div class="info-item">
                                                <strong>Altura:</strong>
                                                <span>{{ $characteristic->height ?? 'N/A' }} cm</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Peso:</strong>
                                                <span>{{ $characteristic->weight ?? 'N/A' }} kg</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Sexo:</strong>
                                                <span>{{ $characteristic->sex ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Género:</strong>
                                                <span>{{ $characteristic->criminalGender->gender_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Complexión:</strong>
                                                <span>{{ $characteristic->confleccion->conflexion_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Color de Piel:</strong>
                                                <span>{{ $characteristic->skinColor->skin_color_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Ojos:</strong>
                                                <span>{{ $characteristic->eyeType->eye_type_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Oídos:</strong>
                                                <span>{{ $characteristic->earType->ear_type_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Labios:</strong>
                                                <span>{{ $characteristic->lipType->lip_type_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="info-item">
                                                <strong>Nariz:</strong>
                                                <span>{{ $characteristic->noseType->nose_type_name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        @if ($characteristic->distinctive_marks)
                                            <div class="info-item mt-2">
                                                <strong>Marcas Distintivas:</strong>
                                                <span>{{ $characteristic->distinctive_marks }}</span>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="no-data">No hay características físicas disponibles</div>
                                    @endforelse

                                    @can('agregar.criminal')
                                        <div class="edit-button-container">
                                            <a href="{{ route('criminals.edit', $criminal->id) }}" class="btn-edit">
                                                <i class="fas fa-edit me-1"></i>Editar
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales para las fotografías principales con lógica de fecha -->
        @php
            // Reutilizar las variables ya definidas en la sección anterior
            $arrestDate = \Carbon\Carbon::parse($history->arrest_date)->format('Y-m-d');

            // Buscar la fotografía que coincida con la fecha del arresto
            $photo = $criminal->photographs->firstWhere(function ($photo) use ($arrestDate) {
                return \Carbon\Carbon::parse($photo->created_at)->format('Y-m-d') === $arrestDate;
            });

            // Si no se encuentra una foto que coincida, obtener la última foto
            if (!$photo) {
                $photo = $criminal->photographs->last();
            }

            // Definir las fotografías específicas por tipo
            $frontalPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$frontalPhoto) {
                $frontalPhoto = $criminal->photographs->last();
            }

            $fullBodyPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$fullBodyPhoto) {
                $fullBodyPhoto = $criminal->photographs->last();
            }

            $profileIzqPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$profileIzqPhoto) {
                $profileIzqPhoto = $criminal->photographs->last();
            }

            $profileDerPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$profileDerPhoto) {
                $profileDerPhoto = $criminal->photographs->last();
            }

            $aditionalPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$aditionalPhoto) {
                $aditionalPhoto = $criminal->photographs->last();
            }

            $barraPhoto = $criminal->photographs->firstWhere(function ($p) use ($arrestDate) {
                return \Carbon\Carbon::parse($p->created_at)->format('Y-m-d') === $arrestDate;
            });
            if (!$barraPhoto) {
                $barraPhoto = $criminal->photographs->last();
            }
        @endphp

        <!-- Modal para foto principal (rostro) -->
        @if ($photo && $photo->face_photo)
            <div class="modal fade" id="mainPhotoModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-user me-2"></i>Fotografía Principal - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($photo->face_photo) }}" class="img-fluid rounded shadow"
                                alt="Fotografía Principal" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía de Rostro | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para foto frontal -->
        @if ($frontalPhoto && $frontalPhoto->frontal_photo)
            <div class="modal fade" id="photoModal_frontal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-user me-2"></i>Fotografía Frontal - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($frontalPhoto->frontal_photo) }}" class="img-fluid rounded shadow"
                                alt="Fotografía Frontal" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Vista Frontal | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para foto de cuerpo completo -->
        @if ($fullBodyPhoto && $fullBodyPhoto->full_body_photo)
            <div class="modal fade" id="photoModal_fullbody" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-male me-2"></i>Cuerpo Completo - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($fullBodyPhoto->full_body_photo) }}" class="img-fluid rounded shadow"
                                alt="Cuerpo Completo" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Cuerpo Completo | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para perfil izquierdo -->
        @if ($profileIzqPhoto && $profileIzqPhoto->profile_izq_photo)
            <div class="modal fade" id="photoModal_profile_izq" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-arrow-left me-2"></i>Perfil Izquierdo - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($profileIzqPhoto->profile_izq_photo) }}" class="img-fluid rounded shadow"
                                alt="Perfil Izquierdo" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Perfil Izquierdo | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para perfil derecho -->
        @if ($profileDerPhoto && $profileDerPhoto->profile_der_photo)
            <div class="modal fade" id="photoModal_profile_der" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-arrow-right me-2"></i>Perfil Derecho - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($profileDerPhoto->profile_der_photo) }}" class="img-fluid rounded shadow"
                                alt="Perfil Derecho" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Perfil Derecho | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para foto adicional -->
        @if ($aditionalPhoto && $aditionalPhoto->aditional_photo)
            <div class="modal fade" id="photoModal_additional" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-plus me-2"></i>Foto Adicional - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($aditionalPhoto->aditional_photo) }}" class="img-fluid rounded shadow"
                                alt="Foto Adicional" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Adicional | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para foto de barra -->
        @if ($barraPhoto && $barraPhoto->barra_photo)
            <div class="modal fade" id="photoModal_barra" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-barcode me-2"></i>Foto de Barra - {{ $criminal->first_name }}
                                {{ $criminal->last_nameP }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-2">
                            <img src="{{ asset($barraPhoto->barra_photo) }}" class="img-fluid rounded shadow"
                                alt="Foto de Barra" style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía de Barra | Fecha del arresto:
                                    {{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-12">
                <div class="card mt-4" style="background: #000000; color: #ffffff;">
                    <div class="card-header">
                        <h3 class="section-title-main">
                            <i class="fas fa-save me-2"></i>Datos guardados del arresto
                        </h3>
                    </div>
                    <!-- Primera fila: Detalles del Arresto -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="arrest-detail-card">
                                <div class="detail-card-header">
                                    <h6 class="detail-card-title">
                                        <i class="fas fa-info-circle me-2"></i>Detalles del Arresto
                                    </h6>
                                </div>
                                <div class="detail-card-body">
                                    <div class="arrest-details-grid-enhanced">
                                        <div class="detail-item-enhanced">
                                            <span class="detail-label">Fecha de Captura:</span>
                                            <span class="detail-value">
                                                <span
                                                    class="badge bg-info">{{ \Carbon\Carbon::parse($history->arrest_date)->format('d/m/Y') }}</span>
                                            </span>
                                        </div>
                                        <div class="detail-item-enhanced">
                                            <span class="detail-label">Hora de Captura:</span>
                                            <span class="detail-value">
                                                <span
                                                    class="badge bg-info">{{ \Carbon\Carbon::parse($history->arrest_time)->format('H:i') }}</span>
                                            </span>
                                        </div>
                                        @if ($history->legalStatus)
                                            <div class="detail-item-enhanced">
                                                <span class="detail-label">Situación Legal:</span>
                                                <span class="detail-value">
                                                    <span
                                                        class="badge bg-primary">{{ $history->legalStatus->status_name }}</span>
                                                </span>
                                            </div>
                                        @endif
                                        @if ($history->apprehensionType)
                                            <div class="detail-item-enhanced">
                                                <span class="detail-label">Tipo de Captura:</span>
                                                <span
                                                    class="detail-value">{{ $history->apprehensionType->type_name }}</span>
                                            </div>
                                        @endif
                                        @if ($history->cud_number)
                                            <div class="detail-item-enhanced">
                                                <span class="detail-label">Número de CUD:</span>
                                                <span class="detail-value"><code>{{ $history->cud_number }}</code></span>
                                            </div>
                                        @endif
                                        @if ($history->arrest_location)
                                            <div class="detail-item-enhanced">
                                                <span class="detail-label">Lugar de Captura:</span>
                                                <span class="detail-value">{{ $history->arrest_location }}</span>
                                            </div>
                                        @endif
                                        @if ($history->criminal_specialty_id && $history->criminalSpecialty)
                                            <div class="detail-item-enhanced">
                                                <span class="detail-label">Especialidad:</span>
                                                <span
                                                    class="detail-value">{{ $history->criminalSpecialty->specialty_name }}</span>
                                            </div>
                                        @endif
                                        @if ($history->arrest_details)
                                            <div class="detail-item-enhanced full-width">
                                                <span class="detail-label">Detalles:</span>
                                                <span class="detail-value">{{ $history->arrest_details }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: Herramientas, Teléfonos y Cómplices -->
                    <div class="row g-3 mb-4">
                        <!-- Herramientas y Armas -->
                        <div class="col-12 col-lg-4">
                            <div class="special-detail-card">
                                <div class="special-detail-header">
                                    <h6 class="special-detail-title">
                                        <i class="fas fa-tools me-1"></i>Herramientas y Armas
                                    </h6>
                                </div>
                                <div class="special-detail-body">
                                    @if ($history->criminalTools && $history->criminalTools->isNotEmpty())
                                        @foreach ($history->criminalTools as $tool)
                                            <div class="special-item">
                                                <div class="special-item-type">
                                                    {{ $tool->toolType->tool_type_name ?? 'No especificado' }}
                                                </div>
                                                <div class="special-item-details">
                                                    {{ $tool->tool_details ?? 'Sin detalles' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-data-special">No se encontraron herramientas</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Números de Teléfono -->
                        <div class="col-12 col-lg-4">
                            <div class="special-detail-card">
                                <div class="special-detail-header">
                                    <h6 class="special-detail-title">
                                        <i class="fas fa-phone me-1"></i>Números de Teléfono
                                    </h6>
                                </div>
                                <div class="special-detail-body">
                                    @if ($history->phoneNumber && $history->phoneNumber->isNotEmpty())
                                        @foreach ($history->phoneNumber as $phone)
                                            <div class="special-item">
                                                <div class="special-item-type">
                                                    <i class="fas fa-mobile-alt me-1"></i>
                                                    {{ $phone->phone_number ?? 'No especificado' }}
                                                </div>
                                                <div class="special-item-details">
                                                    {{ $phone->company->companies_name ?? 'N/A' }}
                                                    |
                                                    IMEI: {{ $phone->imei_number ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-data-special">No se encontraron números de teléfono</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Cómplices -->
                        <div class="col-12 col-lg-4">
                            <div class="special-detail-card">
                                <div class="special-detail-header">
                                    <h6 class="special-detail-title">
                                        <i class="fas fa-users me-1"></i>Cómplices
                                    </h6>
                                </div>
                                <div class="special-detail-body">
                                    @if ($history->criminalComplice && $history->criminalComplice->isNotEmpty())
                                        @foreach ($history->criminalComplice as $complice)
                                            <div class="special-item">
                                                <div class="special-item-type">
                                                    {{ $complice->complice_name ?? 'No especificado' }}
                                                </div>
                                                <div class="special-item-details">
                                                    CI: {{ $complice->CI_complice ?? 'N/A' }} |
                                                    {{ $complice->detail_complice ?? 'Sin detalles' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-data-special">No se encontraron cómplices</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tercera fila: Otras Identidades y Organizaciones -->
                    <div class="row g-3 mb-4">
                        <!-- Otras Identidades -->
                        <div class="col-12 col-lg-4">
                            <div class="arrest-detail-card">
                                <div class="detail-card-header">
                                    <h6 class="detail-card-title">
                                        <i class="fas fa-user-secret me-2"></i>Otras Identidades
                                    </h6>
                                </div>
                                <div class="detail-card-body">
                                    @if ($history->criminalAliase && $history->criminalAliase->isNotEmpty())
                                        <div class="simple-details-grid">
                                            @foreach ($history->criminalAliase as $aliase)
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">Alias:</span>
                                                    <span
                                                        class="detail-value">{{ $aliase->alias_name ?? 'No especificado' }}</span>
                                                </div>
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">CI:</span>
                                                    <span
                                                        class="detail-value">{{ $aliase->alias_identity_number ?? 'N/A' }}</span>
                                                </div>
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">Nacionalidad:</span>
                                                    <span
                                                        class="detail-value">{{ $aliase->nationality->nationality_name ?? 'N/A' }}</span>
                                                </div>
                                                @if (!$loop->last)
                                                    <hr class="detail-separator">
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="no-data-simple">No se encontraron identidades</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Organización Criminal -->
                        <div class="col-12 col-lg-4">
                            <div class="arrest-detail-card">
                                <div class="detail-card-header">
                                    <h6 class="detail-card-title">
                                        <i class="fas fa-skull-crossbones me-2"></i>Organización Criminal
                                    </h6>
                                </div>
                                <div class="detail-card-body">
                                    @if ($history->criminalOrganization && $history->criminalOrganization->isNotEmpty())
                                        <div class="simple-details-grid">
                                            @foreach ($history->criminalOrganization as $grupo)
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">Organización:</span>
                                                    <span
                                                        class="detail-value">{{ $grupo->organization->organization_name ?? 'No especificada' }}</span>
                                                </div>
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">Especialidad:</span>
                                                    <span
                                                        class="detail-value">{{ $grupo->organization->Criminal_Organization_Specialty ?? 'N/A' }}</span>
                                                </div>
                                                <div class="detail-item-enhanced">
                                                    <span class="detail-label">Rol:</span>
                                                    <span class="detail-value">{{ $grupo->criminal_rol ?? 'N/A' }}</span>
                                                </div>
                                                @if (!$loop->last)
                                                    <hr class="detail-separator">
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="no-data-simple">No se encontraron organizaciones</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Condenas y Situación Legal -->
                        <div class="col-12 col-lg-4">
                            <div class="arrest-detail-card">
                                <div class="detail-card-header">
                                    <h6 class="detail-card-title">
                                        <i class="fas fa-gavel me-2"></i>Condenas y Situación Legal
                                    </h6>
                                </div>
                                <div class="detail-card-body">
                                    @if ($history->criminalConviction && $history->criminalConviction->isNotEmpty())
                                        <div class="legal-section-compact mb-3">
                                            <div class="legal-type-compact text-danger">
                                                <i class="fas fa-hammer me-2"></i>Condenas
                                            </div>
                                            @foreach ($history->criminalConviction as $condena)
                                                <div class="legal-item-compact conviction mb-2">
                                                    <div class="card bg-dark border-danger">
                                                        <div class="card-body p-2">
                                                            <span class="badge bg-danger w-100">
                                                                {{ $condena->detentionType->detention_name }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        @can('agregar.criminal')
                                            <div class="text-center mb-3">
                                                <a href="{{ route('criminals.edit_condena', ['criminal' => $criminal->id, 'history' => $history->id]) }}"
                                                    class="btn btn-warning btn-sm w-100 fw-bold shadow">
                                                    <i class="fas fa-plus-circle me-2"></i>Agregar Condena
                                                </a>
                                            </div>
                                        @endcan
                                    @endif

                                    @if ($history->preventiveDetentions && $history->preventiveDetentions->isNotEmpty())
                                        <div class="legal-section-compact mb-3">
                                            <div class="legal-type-compact text-info">
                                                <i class="fas fa-building me-2"></i>Detención Preventiva
                                            </div>
                                            @foreach ($history->preventiveDetentions as $preventivo)
                                                <div class="legal-item-compact detention mb-2">
                                                    <div class="card bg-dark border-info">
                                                        <div class="card-body p-2">
                                                            <h6 class="text-info mb-2 small">
                                                                {{ $preventivo->prison->prison_name ?? 'No especificada' }}
                                                            </h6>
                                                            <div class="small text-light">
                                                                <div><strong><i
                                                                            class="fas fa-map-marker-alt me-1"></i>Dirección:</strong>
                                                                    {{ $preventivo->prison->prison_location ?? 'N/A' }}
                                                                </div>
                                                                <div><strong><i
                                                                            class="fas fa-globe me-1"></i>Ubicación:</strong>
                                                                    {{ $preventivo->prison->country->country_name ?? 'N/A' }}
                                                                    -
                                                                    {{ $preventivo->prison->state->state_name ?? 'N/A' }}
                                                                    -
                                                                    {{ $preventivo->prison->city->city_name ?? 'N/A' }}
                                                                </div>
                                                                <div class="row mt-1">
                                                                    <div class="col-6">
                                                                        <strong><i
                                                                                class="fas fa-sign-in-alt me-1 text-success"></i>Entrada:</strong><br>
                                                                        <small
                                                                            class="text-success">{{ $preventivo->prison_entry_date ?? 'N/A' }}</small>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <strong><i
                                                                                class="fas fa-sign-out-alt me-1 text-warning"></i>Salida:</strong><br>
                                                                        <small
                                                                            class="text-warning">{{ $preventivo->prison_release_date ?? 'N/A' }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($history->extraditions && $history->extraditions->isNotEmpty())
                                        <div class="legal-section-compact mb-3">
                                            <div class="legal-type-compact text-warning">
                                                <i class="fas fa-plane me-2"></i>Extradiciones
                                            </div>
                                            @foreach ($history->extraditions as $extradicion)
                                                <div class="legal-item-compact extradition mb-2">
                                                    <div class="card bg-dark border-warning">
                                                        <div class="card-body p-2">
                                                            <div class="small text-light">
                                                                <div><strong><i
                                                                            class="fas fa-globe me-1"></i>Destino:</strong>
                                                                    {{ $extradicion->country->country_name ?? 'N/A' }} -
                                                                    {{ $extradicion->state->state_name ?? 'N/A' }}
                                                                </div>
                                                                <div><strong><i
                                                                            class="fas fa-calendar me-1"></i>Fecha:</strong>
                                                                    <span
                                                                        class="badge bg-warning text-dark">{{ $extradicion->extradition_date ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($history->houseArrests && $history->houseArrests->isNotEmpty())
                                        <div class="legal-section-compact mb-3">
                                            <div class="legal-type-compact text-success">
                                                <i class="fas fa-home me-2"></i>Arresto Domiciliario
                                            </div>
                                            @foreach ($history->houseArrests as $harrest)
                                                <div class="legal-item-compact house-arrest mb-2">
                                                    <div class="card bg-dark border-success">
                                                        <div class="card-body p-2">
                                                            <div class="small text-light">
                                                                <div><strong><i
                                                                            class="fas fa-home me-1"></i>Dirección:</strong>
                                                                    {{ $harrest->house_arrest_address ?? 'N/A' }}
                                                                </div>
                                                                <div><strong><i
                                                                            class="fas fa-globe me-1"></i>Ubicación:</strong>
                                                                    {{ $harrest->country->country_name ?? 'N/A' }} -
                                                                    {{ $harrest->state->state_name ?? 'N/A' }} -
                                                                    {{ $harrest->city->city_name ?? 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if ($history->liberties && $history->liberties->isNotEmpty())
                                        <div class="legal-section-compact mb-3">
                                            <div class="legal-type-compact text-primary">
                                                <i class="fas fa-unlock me-2"></i>Libertad
                                            </div>
                                            @foreach ($history->liberties as $liberty)
                                                <div class="legal-item-compact liberty mb-2">
                                                    <div class="card bg-dark border-primary">
                                                        <div class="card-body p-2">
                                                            <div class="small text-light">
                                                                <div><strong><i
                                                                            class="fas fa-home me-1"></i>Dirección:</strong>
                                                                    {{ $liberty->house_address ?? 'N/A' }}
                                                                </div>
                                                                <div><strong><i
                                                                            class="fas fa-globe me-1"></i>Ubicación:</strong>
                                                                    {{ $liberty->country->country_name ?? 'N/A' }} -
                                                                    {{ $liberty->state->state_name ?? 'N/A' }} -
                                                                    {{ $liberty->city->city_name ?? 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (
                                        (!$history->criminalConviction || $history->criminalConviction->isEmpty()) &&
                                            (!$history->preventiveDetentions || $history->preventiveDetentions->isEmpty()) &&
                                            (!$history->extraditions || $history->extraditions->isEmpty()) &&
                                            (!$history->houseArrests || $history->houseArrests->isEmpty()) &&
                                            (!$history->liberties || $history->liberties->isEmpty()))
                                        <div class="no-data-simple">No se encontraron condenas o situaciones legales
                                            relacionadas para este historial.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cuarta fila: Vehículos (SIN MODALES DENTRO) -->
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="arrest-detail-card">
                                <div class="detail-card-header">
                                    <h6 class="detail-card-title">
                                        <i class="fas fa-car me-2"></i>Vehículos Usados
                                    </h6>
                                </div>
                                <div class="detail-card-body">
                                    @if ($history->criminalVehicle->isNotEmpty())
                                        @foreach ($history->criminalVehicle as $vehicleIndex => $vehicle)
                                            @php
                                                // ID único para cada vehículo
                                                $vehicleModalId = "vm_details_v{$vehicleIndex}";
                                            @endphp

                                            <div class="vehicle-card-enhanced">
                                                <div class="vehicle-header-enhanced">
                                                    <span class="vehicle-title-enhanced">Vehículo
                                                        {{ $loop->iteration }}</span>
                                                    <span
                                                        class="vehicle-plate-enhanced">{{ $vehicle->license_plate ?? 'N/A' }}</span>
                                                </div>

                                                <div class="row g-3">
                                                    <!-- Detalles del Vehículo -->
                                                    <div class="col-12 col-lg-4">
                                                        <div class="vehicle-section">
                                                            <h6 class="vehicle-section-title">Detalles del Vehículo</h6>
                                                            <div class="vehicle-details-list">
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Color:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->vehicleColor->color_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Marca:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->brandVehicle->brand_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Modelo:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->model ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Año:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->year ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Tipo:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->vehicleType->vehicle_type_name ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="vehicle-detail-item">
                                                                    <span class="vehicle-label">Servicio:</span>
                                                                    <span
                                                                        class="vehicle-value">{{ $vehicle->vehicleService->service_name ?? 'N/A' }}</span>
                                                                </div>
                                                                @if ($vehicle->details)
                                                                    <div class="vehicle-detail-item full-width">
                                                                        <span class="vehicle-label">Detalles:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->details }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($vehicle->observations)
                                                                    <div class="vehicle-detail-item full-width">
                                                                        <span class="vehicle-label">Observaciones:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->observations }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Datos de ITV -->
                                                    <div class="col-12 col-lg-4">
                                                        <div class="vehicle-section">
                                                            <h6 class="vehicle-section-title">Datos de ITV y Propietario
                                                            </h6>
                                                            <div class="vehicle-details-list">
                                                                @if ($vehicle->itv_valid)
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="itv-status-enhanced valid">ITV
                                                                            Válido</span>
                                                                    </div>
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="vehicle-label">Propietario:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->user_name ?? 'N/A' }}</span>
                                                                    </div>
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="vehicle-label">CI Propietario:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->user_ci ?? 'N/A' }}</span>
                                                                    </div>
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="vehicle-label">Relación:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->relationshipWithOwner->relationship_name ?? 'N/A' }}</span>
                                                                    </div>
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="vehicle-label">Conductor:</span>
                                                                        <span
                                                                            class="vehicle-value">{{ $vehicle->driver_name ?? 'N/A' }}</span>
                                                                    </div>
                                                                @else
                                                                    <div class="vehicle-detail-item">
                                                                        <span class="itv-status-enhanced invalid">Sin
                                                                            ITV</span>
                                                                    </div>
                                                                    <div class="no-data-vehicle">
                                                                        <p>No hay información de propietario disponible</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Fotografías (SOLO THUMBNAILS - SIN MODALES) -->
                                                    <div class="col-12 col-lg-4">
                                                        <div class="vehicle-section">
                                                            <h6 class="vehicle-section-title">Fotografías</h6>
                                                            <div class="vehicle-photos-enhanced">
                                                                @php
                                                                    $hasPhotos =
                                                                        $vehicle->front_photo ||
                                                                        $vehicle->left_side_photo ||
                                                                        $vehicle->right_side_photo ||
                                                                        $vehicle->rear_photo;
                                                                    $photoCount = collect([
                                                                        $vehicle->front_photo,
                                                                        $vehicle->left_side_photo,
                                                                        $vehicle->right_side_photo,
                                                                        $vehicle->rear_photo,
                                                                    ])
                                                                        ->filter()
                                                                        ->count();
                                                                @endphp

                                                                @if ($hasPhotos)
                                                                    <div class="photos-grid-enhanced">
                                                                        @if ($vehicle->front_photo && file_exists(public_path($vehicle->front_photo)))
                                                                            <div class="photo-thumb-enhanced"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#{{ $vehicleModalId }}_front">
                                                                                <img src="{{ asset($vehicle->front_photo) }}"
                                                                                    alt="Frontal">
                                                                                <span
                                                                                    class="photo-label-enhanced">Frontal</span>
                                                                            </div>
                                                                        @endif
                                                                        @if ($vehicle->left_side_photo && file_exists(public_path($vehicle->left_side_photo)))
                                                                            <div class="photo-thumb-enhanced"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#{{ $vehicleModalId }}_left">
                                                                                <img src="{{ asset($vehicle->left_side_photo) }}"
                                                                                    alt="Lateral Izq">
                                                                                <span class="photo-label-enhanced">Lat.
                                                                                    Izq</span>
                                                                            </div>
                                                                        @endif
                                                                        @if ($vehicle->right_side_photo && file_exists(public_path($vehicle->right_side_photo)))
                                                                            <div class="photo-thumb-enhanced"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#{{ $vehicleModalId }}_right">
                                                                                <img src="{{ asset($vehicle->right_side_photo) }}"
                                                                                    alt="Lateral Der">
                                                                                <span class="photo-label-enhanced">Lat.
                                                                                    Der</span>
                                                                            </div>
                                                                        @endif
                                                                        @if ($vehicle->rear_photo && file_exists(public_path($vehicle->rear_photo)))
                                                                            <div class="photo-thumb-enhanced"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#{{ $vehicleModalId }}_rear">
                                                                                <img src="{{ asset($vehicle->rear_photo) }}"
                                                                                    alt="Trasera">
                                                                                <span
                                                                                    class="photo-label-enhanced">Trasera</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="photo-count-info">
                                                                        <small><i
                                                                                class="fas fa-camera me-1"></i>{{ $photoCount }}
                                                                            fotografía{{ $photoCount > 1 ? 's' : '' }}
                                                                            disponible{{ $photoCount > 1 ? 's' : '' }}</small>
                                                                    </div>
                                                                @else
                                                                    <div class="no-photos-vehicle">
                                                                        <i class="fas fa-camera-retro fa-2x"></i>
                                                                        <p class="mt-2">No hay fotografías disponibles
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (!$loop->last)
                                                <hr class="vehicle-separator">
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="no-data-simple">No se encontraron vehículos</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- ============================================ --}}
        {{-- SECCIÓN DE MODALES CORREGIDA - FUERA DEL CONTENIDO --}}
        {{-- ============================================ --}}
        @if ($history->criminalVehicle && $history->criminalVehicle->isNotEmpty())
            @foreach ($history->criminalVehicle as $vehicleIndex => $vehicle)
                @php
                    // Mismo ID que se usa en los thumbnails
                    $vehicleModalId = "vm_details_v{$vehicleIndex}";
                @endphp

                {{-- Modal para foto FRONTAL --}}
                @if ($vehicle->front_photo && file_exists(public_path($vehicle->front_photo)))
                    <div class="modal fade" id="{{ $vehicleModalId }}_front" tabindex="-1"
                        aria-labelledby="{{ $vehicleModalId }}_front_label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-success" id="{{ $vehicleModalId }}_front_label">
                                        <i class="fas fa-car me-2"></i>Vista Frontal -
                                        {{ $vehicle->license_plate ?? 'Vehículo' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body text-center p-2">
                                    <img src="{{ asset($vehicle->front_photo) }}" class="img-fluid rounded shadow"
                                        alt="Vista Frontal - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                        style="max-height: 70vh; object-fit: contain;">
                                    <div class="mt-3">
                                        <p class="text-light mb-1">
                                            <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }} |
                                            {{ $vehicle->year ?? 'Año N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Modal para foto LATERAL IZQUIERDA --}}
                @if ($vehicle->left_side_photo && file_exists(public_path($vehicle->left_side_photo)))
                    <div class="modal fade" id="{{ $vehicleModalId }}_left" tabindex="-1"
                        aria-labelledby="{{ $vehicleModalId }}_left_label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-success" id="{{ $vehicleModalId }}_left_label">
                                        <i class="fas fa-car me-2"></i>Vista Lateral Izquierda -
                                        {{ $vehicle->license_plate ?? 'Vehículo' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body text-center p-2">
                                    <img src="{{ asset($vehicle->left_side_photo) }}" class="img-fluid rounded shadow"
                                        alt="Vista Lateral Izquierda - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                        style="max-height: 70vh; object-fit: contain;">
                                    <div class="mt-3">
                                        <p class="text-light mb-1">
                                            <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }} |
                                            {{ $vehicle->year ?? 'Año N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Modal para foto LATERAL DERECHA --}}
                @if ($vehicle->right_side_photo && file_exists(public_path($vehicle->right_side_photo)))
                    <div class="modal fade" id="{{ $vehicleModalId }}_right" tabindex="-1"
                        aria-labelledby="{{ $vehicleModalId }}_right_label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-success" id="{{ $vehicleModalId }}_right_label">
                                        <i class="fas fa-car me-2"></i>Vista Lateral Derecha -
                                        {{ $vehicle->license_plate ?? 'Vehículo' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body text-center p-2">
                                    <img src="{{ asset($vehicle->right_side_photo) }}" class="img-fluid rounded shadow"
                                        alt="Vista Lateral Derecha - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                        style="max-height: 70vh; object-fit: contain;">
                                    <div class="mt-3">
                                        <p class="text-light mb-1">
                                            <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }} |
                                            {{ $vehicle->year ?? 'Año N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Modal para foto TRASERA --}}
                @if ($vehicle->rear_photo && file_exists(public_path($vehicle->rear_photo)))
                    <div class="modal fade" id="{{ $vehicleModalId }}_rear" tabindex="-1"
                        aria-labelledby="{{ $vehicleModalId }}_rear_label" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark">
                                <div class="modal-header border-secondary">
                                    <h5 class="modal-title text-success" id="{{ $vehicleModalId }}_rear_label">
                                        <i class="fas fa-car me-2"></i>Vista Trasera -
                                        {{ $vehicle->license_plate ?? 'Vehículo' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body text-center p-2">
                                    <img src="{{ asset($vehicle->rear_photo) }}" class="img-fluid rounded shadow"
                                        alt="Vista Trasera - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                        style="max-height: 70vh; object-fit: contain;">
                                    <div class="mt-3">
                                        <p class="text-light mb-1">
                                            <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }} |
                                            {{ $vehicle->year ?? 'Año N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <!-- Bootstrap 5 CSS y JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <a href="{{ route('document.generate.complete', $criminal->id) }}" class="btn-export-pdf">Exportar a PDF</a>

        <script>
            // Efecto hover para las tarjetas
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 8px 15px rgba(0, 0, 0, 0.4)';
                    this.style.transition = 'all 0.3s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.3)';
                });
            });

            // Lazy loading para imágenes
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const parent = this.parentElement;
                    if (parent) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'alert alert-dark text-center';
                        errorDiv.innerHTML =
                            '<i class="fas fa-image fa-2x mb-2"></i><p class="parrafo-1">Imagen no disponible</p>';
                        parent.appendChild(errorDiv);
                    }
                });
            });
        </script>
    </div>
    <br>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/criminal-ver.js') }}"></script>
@stop

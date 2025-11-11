@extends('adminlte::page')

@section('title', 'Crimanager')
@section('content_header')
    @if (session('success'))
        <div id="success-alert" class="success-notification">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="text-center mb-3">
        Registro de Captura de: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}
    </h1>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/criminal-todo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stop

@section('content')

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

                        <!-- Foto Principal Expandida -->
                        <div class="col-12 col-lg-4">
                            <div class="main-photo-container-expanded">
                                @if ($criminal->photographs && $criminal->photographs->last() && $criminal->photographs->last()->face_photo)
                                    <div class="main-photo-wrapper" data-bs-toggle="modal" data-bs-target="#mainPhotoModal">
                                        <img src="{{ asset($criminal->photographs->last()->face_photo) }}"
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
                                @if ($criminal->photographs && $criminal->photographs->last())
                                    <div class="photo-tabs-container">
                                        <ul class="nav nav-tabs nav-justified photo-tabs-custom" id="photoTabs"
                                            role="tablist">
                                            @if ($criminal->photographs->last()->frontal_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active photo-tab-btn" id="frontal-tab"
                                                        data-bs-toggle="tab" data-bs-target="#frontal" type="button"
                                                        role="tab">
                                                        <i class="fas fa-user"></i><span class="tab-text">Frontal</span>
                                                    </button>
                                                </li>
                                            @endif
                                            @if ($criminal->photographs->last()->full_body_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link photo-tab-btn" id="fullbody-tab"
                                                        data-bs-toggle="tab" data-bs-target="#fullbody" type="button"
                                                        role="tab">
                                                        <i class="fas fa-male"></i><span class="tab-text">Cuerpo</span>
                                                    </button>
                                                </li>
                                            @endif
                                            @if ($criminal->photographs->last()->profile_izq_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link photo-tab-btn" id="profile-izq-tab"
                                                        data-bs-toggle="tab" data-bs-target="#profile-izq" type="button"
                                                        role="tab">
                                                        <i class="fas fa-arrow-left"></i><span class="tab-text">P.Izq</span>
                                                    </button>
                                                </li>
                                            @endif
                                            @if ($criminal->photographs->last()->profile_der_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link photo-tab-btn" id="profile-der-tab"
                                                        data-bs-toggle="tab" data-bs-target="#profile-der" type="button"
                                                        role="tab">
                                                        <i class="fas fa-arrow-right"></i><span
                                                            class="tab-text">P.Der</span>
                                                    </button>
                                                </li>
                                            @endif
                                            @if ($criminal->photographs->last()->aditional_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link photo-tab-btn" id="additional-tab"
                                                        data-bs-toggle="tab" data-bs-target="#additional" type="button"
                                                        role="tab">
                                                        <i class="fas fa-plus"></i><span class="tab-text">Extra</span>
                                                    </button>
                                                </li>
                                            @endif
                                            @if ($criminal->photographs->last()->barra_photo)
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link photo-tab-btn" id="barra-tab"
                                                        data-bs-toggle="tab" data-bs-target="#barra" type="button"
                                                        role="tab">
                                                        <i class="fas fa-barcode"></i><span class="tab-text">Barra</span>
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>

                                        <div class="tab-content photo-tab-content" id="photoTabContent">
                                            @if ($criminal->photographs->last()->frontal_photo)
                                                <div class="tab-pane fade show active" id="frontal" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_frontal">
                                                        <img src="{{ asset($criminal->photographs->last()->frontal_photo) }}"
                                                            class="tab-photo-expanded" alt="Fotografía Frontal">
                                                    </div>
                                                    <h6 class="photo-title-secondary">Fotografía Frontal</h6>
                                                </div>
                                            @endif
                                            @if ($criminal->photographs->last()->full_body_photo)
                                                <div class="tab-pane fade" id="fullbody" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_fullbody">
                                                        <img src="{{ asset($criminal->photographs->last()->full_body_photo) }}"
                                                            class="tab-photo-expanded" alt="Cuerpo Completo">
                                                    </div>
                                                    <h6 class="photo-title-secondary">Cuerpo Completo</h6>
                                                </div>
                                            @endif
                                            @if ($criminal->photographs->last()->profile_izq_photo)
                                                <div class="tab-pane fade" id="profile-izq" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_profile_izq">
                                                        <img src="{{ asset($criminal->photographs->last()->profile_izq_photo) }}"
                                                            class="tab-photo-expanded" alt="Perfil Izquierdo">
                                                    </div>
                                                    <h6 class="photo-title-secondary">Perfil Izquierdo</h6>
                                                </div>
                                            @endif
                                            @if ($criminal->photographs->last()->profile_der_photo)
                                                <div class="tab-pane fade" id="profile-der" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_profile_der">
                                                        <img src="{{ asset($criminal->photographs->last()->profile_der_photo) }}"
                                                            class="tab-photo-expanded" alt="Perfil Derecho">
                                                    </div>
                                                    <h6 class="photo-title-secondary">Perfil Derecho</h6>
                                                </div>
                                            @endif
                                            @if ($criminal->photographs->last()->aditional_photo)
                                                <div class="tab-pane fade" id="additional" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_additional">
                                                        <img src="{{ asset($criminal->photographs->last()->aditional_photo) }}"
                                                            class="tab-photo-expanded" alt="Foto Adicional">
                                                    </div>
                                                    <h6 class="photo-title-secondary">Foto Adicional</h6>
                                                </div>
                                            @endif
                                            @if ($criminal->photographs->last()->barra_photo)
                                                <div class="tab-pane fade" id="barra" role="tabpanel">
                                                    <div class="tab-photo-container-expanded" data-bs-toggle="modal"
                                                        data-bs-target="#photoModal_barra">
                                                        <img src="{{ asset($criminal->photographs->last()->barra_photo) }}"
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

    <!-- Modales para las fotografías principales -->
    @if ($criminal->photographs && $criminal->photographs->last())
        <!-- Modal para foto principal (rostro) -->
        @if ($criminal->photographs->last()->face_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->face_photo) }}"
                                class="img-fluid rounded shadow" alt="Fotografía Principal"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía de Rostro | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modales para fotos secundarias -->
        @if ($criminal->photographs->last()->frontal_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->frontal_photo) }}"
                                class="img-fluid rounded shadow" alt="Fotografía Frontal"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Frontal | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($criminal->photographs->last()->full_body_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->full_body_photo) }}"
                                class="img-fluid rounded shadow" alt="Cuerpo Completo"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Cuerpo Completo | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($criminal->photographs->last()->profile_izq_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->profile_izq_photo) }}"
                                class="img-fluid rounded shadow" alt="Perfil Izquierdo"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Perfil Izquierdo | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($criminal->photographs->last()->profile_der_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->profile_der_photo) }}"
                                class="img-fluid rounded shadow" alt="Perfil Derecho"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Perfil Derecho | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($criminal->photographs->last()->aditional_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->aditional_photo) }}"
                                class="img-fluid rounded shadow" alt="Foto Adicional"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía Adicional | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($criminal->photographs->last()->barra_photo)
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
                            <img src="{{ asset($criminal->photographs->last()->barra_photo) }}"
                                class="img-fluid rounded shadow" alt="Foto de Barra"
                                style="max-height: 70vh; object-fit: contain;">
                            <div class="mt-3">
                                <p class="text-light mb-1">
                                    <strong>{{ $criminal->first_name }} {{ $criminal->last_nameP }}</strong>
                                </p>
                                <small class="text-muted">
                                    Fotografía de Barra | Fecha del registro:
                                    {{ \Carbon\Carbon::parse($criminal->photographs->last()->created_at)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <!-- Historial de Arrestos -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
            <div class="main-card mt-4" style="background: #000000; color: #ffffff;">
                <div class="card-header">
                    <h3 class="section-title-main">
                        <i class="fas fa-history me-2"></i>Historial de Arrestos por Fecha
                    </h3>
                </div>
                <div class="card-body">
                    @if ($criminal->arrestHistories && $criminal->arrestHistories->isNotEmpty())
                        <div class="accordion-container-enhanced" id="accordionArrestHistory">
                            @foreach ($criminal->arrestHistories as $index => $history)
                                @php
                                    $formattedDate = $history->arrest_date
                                        ? \Carbon\Carbon::parse($history->arrest_date)->translatedFormat(
                                            'l d \d\e F \d\e Y',
                                        )
                                        : 'Fecha no especificada';
                                    $formattedTime = $history->arrest_time
                                        ? \Carbon\Carbon::parse($history->arrest_time)->format('H:i')
                                        : 'Hora no especificada';
                                    $accordionId = 'collapse' . $index;
                                    $headingId = 'heading' . $index;
                                @endphp

                                <div class="accordion-item-enhanced" data-index="{{ $index }}">
                                    <div class="accordion-header-enhanced" id="{{ $headingId }}">
                                        <button class="accordion-button-enhanced collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $accordionId }}"
                                            aria-expanded="false" aria-controls="{{ $accordionId }}">
                                            <div class="accordion-header-content-enhanced">
                                                <div class="arrest-info-enhanced">
                                                    <div class="arrest-date-enhanced">
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        {{ $formattedDate }} - {{ $formattedTime }}
                                                    </div>
                                                    @if ($history->criminal_specialty_id && $history->criminalSpecialty)
                                                        <div class="arrest-specialty-enhanced">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            {{ $history->criminalSpecialty->specialty_name }}
                                                        </div>
                                                    @endif
                                                </div>
                                                @if ($history->legalStatus)
                                                    <div class="arrest-status-enhanced">
                                                        <span class="status-badge-enhanced">
                                                            {{ $history->legalStatus->status_name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </button>
                                    </div>

                                    <div id="{{ $accordionId }}" class="accordion-collapse collapse"
                                        aria-labelledby="{{ $headingId }}" data-bs-parent="#accordionArrestHistory">
                                        <div class="accordion-body-enhanced">
                                            <!-- Primera fila: Detalles del Arresto -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-12">
                                                    <div class="arrest-detail-card">
                                                        <div class="detail-card-header">
                                                            <h6 class="detail-card-title">
                                                                <i class="fas fa-info-circle me-2"></i>Detalles del
                                                                Arresto
                                                            </h6>
                                                        </div>
                                                        <div class="detail-card-body">
                                                            <div class="arrest-details-grid-enhanced">
                                                                @if ($history->legalStatus)
                                                                    <div class="detail-item-enhanced">
                                                                        <span class="detail-label">Situación
                                                                            Legal:</span>
                                                                        <span class="detail-value">
                                                                            <span
                                                                                class="badge bg-info">{{ $history->legalStatus->status_name }}</span>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                                @if ($history->apprehensionType)
                                                                    <div class="detail-item-enhanced">
                                                                        <span class="detail-label">Tipo de
                                                                            Captura:</span>
                                                                        <span
                                                                            class="detail-value">{{ $history->apprehensionType->type_name }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($history->cud_number)
                                                                    <div class="detail-item-enhanced">
                                                                        <span class="detail-label">Número de
                                                                            CUD:</span>
                                                                        <span
                                                                            class="detail-value"><code>{{ $history->cud_number }}</code></span>
                                                                    </div>
                                                                @endif
                                                                @if ($history->arrest_location)
                                                                    <div class="detail-item-enhanced">
                                                                        <span class="detail-label">Lugar de
                                                                            Captura:</span>
                                                                        <span
                                                                            class="detail-value">{{ $history->arrest_location }}</span>
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
                                                                        <span
                                                                            class="detail-value">{{ $history->arrest_details }}</span>
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
                                                                <div class="no-data-special">No se encontraron
                                                                    herramientas
                                                                </div>
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
                                                                <div class="no-data-special">No se encontraron números
                                                                    de
                                                                    teléfono</div>
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
                                                                <div class="no-data-special">No se encontraron
                                                                    cómplices</div>
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
                                                                <i class="fas fa-user-secret me-2"></i>Otras
                                                                Identidades
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
                                                                <div class="no-data-simple">No se encontraron
                                                                    identidades</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Organización Criminal -->
                                                <div class="col-12 col-lg-4">
                                                    <div class="arrest-detail-card">
                                                        <div class="detail-card-header">
                                                            <h6 class="detail-card-title">
                                                                <i class="fas fa-skull-crossbones me-2"></i>Organización
                                                                Criminal
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
                                                                            <span
                                                                                class="detail-value">{{ $grupo->criminal_rol ?? 'N/A' }}</span>
                                                                        </div>
                                                                        @if (!$loop->last)
                                                                            <hr class="detail-separator">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="no-data-simple">No se encontraron
                                                                    organizaciones
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Condenas y Situación Legal -->
                                                <div class="col-12 col-lg-4">
                                                    <div class="arrest-detail-card">
                                                        <div class="detail-card-header">
                                                            <h6 class="detail-card-title">
                                                                <i class="fas fa-gavel me-2"></i>Condenas y Situación
                                                                Legal
                                                            </h6>
                                                        </div>
                                                        <div class="detail-card-body">
                                                            <div class="legal-status-grid-compact">
                                                                @if ($history->criminalConviction && $history->criminalConviction->isNotEmpty())
                                                                    <div class="legal-section-compact">
                                                                        <div class="legal-type-compact">Condenas</div>
                                                                        @foreach ($history->criminalConviction as $condena)
                                                                            <div class="legal-item-compact conviction">
                                                                                {{ $condena->detentionType->detention_name ?? 'No especificada' }}
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                @if ($history->preventiveDetentions && $history->preventiveDetentions->isNotEmpty())
                                                                    <div class="legal-section-compact">
                                                                        <div class="legal-type-compact">Detención
                                                                            Preventiva
                                                                        </div>
                                                                        @foreach ($history->preventiveDetentions as $preventivo)
                                                                            <div class="legal-item-compact detention">
                                                                                <div class="prison-name-compact">
                                                                                    {{ $preventivo->prison->prison_name ?? 'No especificada' }}
                                                                                </div>
                                                                                <div class="prison-details-compact">
                                                                                    {{ $preventivo->prison->prison_location ?? 'N/A' }},
                                                                                    {{ $preventivo->prison->country->country_name ?? 'N/A' }}
                                                                                </div>
                                                                                <div class="prison-dates-compact">
                                                                                    <span class="entry-compact">Entrada:
                                                                                        {{ $preventivo->prison_entry_date ?? 'N/A' }}</span>
                                                                                    <span class="exit-compact">Salida:
                                                                                        {{ $preventivo->prison_release_date ?? 'N/A' }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                @if ($history->extraditions && $history->extraditions->isNotEmpty())
                                                                    <div class="legal-section-compact">
                                                                        <div class="legal-type-compact">Extradiciones
                                                                        </div>
                                                                        @foreach ($history->extraditions as $extradicion)
                                                                            <div class="legal-item-compact extradition">
                                                                                <div>
                                                                                    {{ $extradicion->country->country_name ?? 'N/A' }}
                                                                                    -
                                                                                    {{ $extradicion->state->state_name ?? 'N/A' }}
                                                                                </div>
                                                                                <div class="extradition-date-compact">
                                                                                    {{ $extradicion->extradition_date ?? 'N/A' }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                @if ($history->houseArrests && $history->houseArrests->isNotEmpty())
                                                                    <div class="legal-section-compact">
                                                                        <div class="legal-type-compact">Arresto
                                                                            Domiciliario
                                                                        </div>
                                                                        @foreach ($history->houseArrests as $harrest)
                                                                            <div class="legal-item-compact house-arrest">
                                                                                <div>
                                                                                    {{ $harrest->house_arrest_address ?? 'N/A' }}
                                                                                </div>
                                                                                <div>
                                                                                    {{ $harrest->country->country_name ?? 'N/A' }}
                                                                                    -
                                                                                    {{ $harrest->state->state_name ?? 'N/A' }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif

                                                                @if ($history->liberties && $history->liberties->isNotEmpty())
                                                                    <div class="legal-section-compact">
                                                                        <div class="legal-type-compact">Libertad</div>
                                                                        @foreach ($history->liberties as $liberty)
                                                                            <div class="legal-item-compact liberty">
                                                                                <div>
                                                                                    {{ $liberty->house_address ?? 'N/A' }}
                                                                                </div>
                                                                                <div>
                                                                                    {{ $liberty->country->country_name ?? 'N/A' }}
                                                                                    -
                                                                                    {{ $liberty->state->state_name ?? 'N/A' }}
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
                                                                    <div class="no-data-simple">No se encontraron
                                                                        condenas o
                                                                        situaciones legales</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cuarta fila: Vehículos (SIN MODALES) -->
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
                                                                        $vehicleModalId = "vm_h{$index}_v{$vehicleIndex}";
                                                                    @endphp

                                                                    <div class="vehicle-card-enhanced">
                                                                        <div class="vehicle-header-enhanced">
                                                                            <span class="vehicle-title-enhanced">Vehículo
                                                                                {{ $loop->iteration }}</span>
                                                                            <span
                                                                                class="vehicle-plate-enhanced">{{ $vehicle->license_plate }}</span>
                                                                        </div>

                                                                        <div class="row g-3">
                                                                            <!-- Detalles del Vehículo -->
                                                                            <div class="col-12 col-lg-4">
                                                                                <div class="vehicle-section">
                                                                                    <h6 class="vehicle-section-title">
                                                                                        Detalles del Vehículo</h6>
                                                                                    <div class="vehicle-details-list">
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Color:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->vehicleColor->color_name ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Marca:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->brandVehicle->brand_name ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Modelo:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->model ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Año:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->year ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Tipo:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->vehicleType->vehicle_type_name ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        <div class="vehicle-detail-item">
                                                                                            <span
                                                                                                class="vehicle-label">Servicio:</span>
                                                                                            <span
                                                                                                class="vehicle-value">{{ $vehicle->vehicleService->service_name ?? 'N/A' }}</span>
                                                                                        </div>
                                                                                        @if ($vehicle->details)
                                                                                            <div
                                                                                                class="vehicle-detail-item full-width">
                                                                                                <span
                                                                                                    class="vehicle-label">Detalles:</span>
                                                                                                <span
                                                                                                    class="vehicle-value">{{ $vehicle->details }}</span>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($vehicle->observations)
                                                                                            <div
                                                                                                class="vehicle-detail-item full-width">
                                                                                                <span
                                                                                                    class="vehicle-label">Observaciones:</span>
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
                                                                                    <h6 class="vehicle-section-title">
                                                                                        Datos de ITV y Propietario</h6>
                                                                                    <div class="vehicle-details-list">
                                                                                        @if ($vehicle->itv_valid)
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="itv-status-enhanced valid">ITV
                                                                                                    Válido</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="vehicle-label">Propietario:</span>
                                                                                                <span
                                                                                                    class="vehicle-value">{{ $vehicle->user_name ?? 'N/A' }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="vehicle-label">CI
                                                                                                    Propietario:</span>
                                                                                                <span
                                                                                                    class="vehicle-value">{{ $vehicle->user_ci ?? 'N/A' }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="vehicle-label">Relación:</span>
                                                                                                <span
                                                                                                    class="vehicle-value">{{ $vehicle->relationshipWithOwner->relationship_name ?? 'N/A' }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="vehicle-label">Conductor:</span>
                                                                                                <span
                                                                                                    class="vehicle-value">{{ $vehicle->driver_name ?? 'N/A' }}</span>
                                                                                            </div>
                                                                                        @else
                                                                                            <div
                                                                                                class="vehicle-detail-item">
                                                                                                <span
                                                                                                    class="itv-status-enhanced invalid">Sin
                                                                                                    ITV</span>
                                                                                            </div>
                                                                                            <div class="no-data-vehicle">
                                                                                                <p>No hay información de
                                                                                                    propietario disponible
                                                                                                </p>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Fotografías (SOLO THUMBNAILS - SIN MODALES) -->
                                                                            <div class="col-12 col-lg-4">
                                                                                <div class="vehicle-section">
                                                                                    <h6 class="vehicle-section-title">
                                                                                        Fotografías</h6>
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
                                                                                            <div
                                                                                                class="photos-grid-enhanced">
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
                                                                                                        <span
                                                                                                            class="photo-label-enhanced">Lat.
                                                                                                            Izq</span>
                                                                                                    </div>
                                                                                                @endif
                                                                                                @if ($vehicle->right_side_photo && file_exists(public_path($vehicle->right_side_photo)))
                                                                                                    <div class="photo-thumb-enhanced"
                                                                                                        data-bs-toggle="modal"
                                                                                                        data-bs-target="#{{ $vehicleModalId }}_right">
                                                                                                        <img src="{{ asset($vehicle->right_side_photo) }}"
                                                                                                            alt="Lateral Der">
                                                                                                        <span
                                                                                                            class="photo-label-enhanced">Lat.
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
                                                                                                <i
                                                                                                    class="fas fa-camera-retro fa-2x"></i>
                                                                                                <p class="mt-2">No hay
                                                                                                    fotografías disponibles
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
                                                                <div class="no-data-simple">No se encontraron vehículos
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ============================================ --}}
                        {{-- SECCIÓN DE MODALES - FUERA DEL ACORDEÓN     --}}
                        {{-- ============================================ --}}
                        @if ($criminal->arrestHistories && $criminal->arrestHistories->isNotEmpty())
                            @foreach ($criminal->arrestHistories as $historyIndex => $history)
                                @if ($history->criminalVehicle && $history->criminalVehicle->isNotEmpty())
                                    @foreach ($history->criminalVehicle as $vehicleIndex => $vehicle)
                                        @php
                                            // Mismo ID que se usa en los thumbnails
                                            $vehicleModalId = "vm_h{$historyIndex}_v{$vehicleIndex}";
                                        @endphp

                                        {{-- Modal para foto frontal --}}
                                        @if ($vehicle->front_photo && file_exists(public_path($vehicle->front_photo)))
                                            <div class="modal fade" id="{{ $vehicleModalId }}_front" tabindex="-1"
                                                aria-labelledby="{{ $vehicleModalId }}_front_label" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header border-secondary">
                                                            <h5 class="modal-title text-success"
                                                                id="{{ $vehicleModalId }}_front_label">
                                                                <i class="fas fa-car me-2"></i>Vista Frontal -
                                                                {{ $vehicle->license_plate ?? 'Vehículo' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-2">
                                                            <img src="{{ asset($vehicle->front_photo) }}"
                                                                class="img-fluid rounded shadow"
                                                                alt="Vista Frontal - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                                                style="max-height: 70vh; object-fit: contain;">
                                                            <div class="mt-3">
                                                                <p class="text-light mb-1">
                                                                    <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                                        {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                                                </p>
                                                                <small class="text-muted">
                                                                    {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }}
                                                                    |
                                                                    {{ $vehicle->year ?? 'Año N/A' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Modal para foto lateral izquierda --}}
                                        @if ($vehicle->left_side_photo && file_exists(public_path($vehicle->left_side_photo)))
                                            <div class="modal fade" id="{{ $vehicleModalId }}_left" tabindex="-1"
                                                aria-labelledby="{{ $vehicleModalId }}_left_label" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header border-secondary">
                                                            <h5 class="modal-title text-success"
                                                                id="{{ $vehicleModalId }}_left_label">
                                                                <i class="fas fa-car me-2"></i>Vista Lateral Izquierda -
                                                                {{ $vehicle->license_plate ?? 'Vehículo' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-2">
                                                            <img src="{{ asset($vehicle->left_side_photo) }}"
                                                                class="img-fluid rounded shadow"
                                                                alt="Vista Lateral Izquierda - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                                                style="max-height: 70vh; object-fit: contain;">
                                                            <div class="mt-3">
                                                                <p class="text-light mb-1">
                                                                    <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                                        {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                                                </p>
                                                                <small class="text-muted">
                                                                    {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }}
                                                                    |
                                                                    {{ $vehicle->year ?? 'Año N/A' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Modal para foto lateral derecha --}}
                                        @if ($vehicle->right_side_photo && file_exists(public_path($vehicle->right_side_photo)))
                                            <div class="modal fade" id="{{ $vehicleModalId }}_right" tabindex="-1"
                                                aria-labelledby="{{ $vehicleModalId }}_right_label" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header border-secondary">
                                                            <h5 class="modal-title text-success"
                                                                id="{{ $vehicleModalId }}_right_label">
                                                                <i class="fas fa-car me-2"></i>Vista Lateral Derecha -
                                                                {{ $vehicle->license_plate ?? 'Vehículo' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-2">
                                                            <img src="{{ asset($vehicle->right_side_photo) }}"
                                                                class="img-fluid rounded shadow"
                                                                alt="Vista Lateral Derecha - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                                                style="max-height: 70vh; object-fit: contain;">
                                                            <div class="mt-3">
                                                                <p class="text-light mb-1">
                                                                    <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                                        {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                                                </p>
                                                                <small class="text-muted">
                                                                    {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }}
                                                                    |
                                                                    {{ $vehicle->year ?? 'Año N/A' }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Modal para foto trasera --}}
                                        @if ($vehicle->rear_photo && file_exists(public_path($vehicle->rear_photo)))
                                            <div class="modal fade" id="{{ $vehicleModalId }}_rear" tabindex="-1"
                                                aria-labelledby="{{ $vehicleModalId }}_rear_label" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header border-secondary">
                                                            <h5 class="modal-title text-success"
                                                                id="{{ $vehicleModalId }}_rear_label">
                                                                <i class="fas fa-car me-2"></i>Vista Trasera -
                                                                {{ $vehicle->license_plate ?? 'Vehículo' }}
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-2">
                                                            <img src="{{ asset($vehicle->rear_photo) }}"
                                                                class="img-fluid rounded shadow"
                                                                alt="Vista Trasera - {{ $vehicle->license_plate ?? 'Vehículo' }}"
                                                                style="max-height: 70vh; object-fit: contain;">
                                                            <div class="mt-3">
                                                                <p class="text-light mb-1">
                                                                    <strong>{{ $vehicle->brandVehicle->brand_name ?? 'Marca N/A' }}
                                                                        {{ $vehicle->model ?? 'Modelo N/A' }}</strong>
                                                                </p>
                                                                <small class="text-muted">
                                                                    {{ $vehicle->vehicleColor->color_name ?? 'Color N/A' }}
                                                                    |
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
                            @endforeach
                        @endif
                        {{-- ============================================ --}}
                        {{-- FIN SECCIÓN DE MODALES                      --}}
                        {{-- ============================================ --}}
                    @else
                        <div class="no-arrests-alert-enhanced">
                            <i class="fas fa-info-circle fa-2x"></i>
                            <div class="no-arrests-content">
                                <h6>Sin registros disponibles</h6>
                                <p>No hay registros de arresto disponibles para este criminal.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Botón de exportar -->
    <div class="export-container">
        <a href="{{ route('document.generate.complete', $criminal->id) }}" class="btn-export">
            <i class="fas fa-file-pdf me-2"></i>Exportar a PDF
        </a>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/criminal-ver.js') }}"></script>
@stop

@extends('adminlte::page')

@section('title', 'Reconocimiento Facial')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-white">
            <i class="fas fa-search mr-2"></i>
            Reconocimiento Facial
        </h1>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-camera mr-2"></i>
                        Comparación de Rostros
                    </h3>
                </div>
                
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Sube una foto para compararla con la base de datos de criminales registrados
                    </p>
                    
                    <form method="POST" enctype="multipart/form-data" action="/face-check" id="faceForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="photo" class="form-label">
                                <i class="fas fa-image mr-1"></i>
                                Selecciona una foto
                            </label>
                            <div class="custom-file">
                                <input type="file" 
                                       name="photo" 
                                       id="photo" 
                                       class="custom-file-input" 
                                       accept="image/*" 
                                       required>
                                <label class="custom-file-label" for="photo">
                                    Seleccionar archivo...
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Formatos soportados: JPG, PNG, GIF (máximo 5MB)
                            </small>
                            
                            <!-- Vista previa de la imagen -->
                            <div id="preview" class="preview-container mt-3"></div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                                <i class="fas fa-search mr-2"></i>
                                Comparar Rostros
                            </button>
                        </div>
                        
                        <!-- Indicador de carga -->
                        <div class="loading-container text-center mt-3" id="loading" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <p class="text-muted mt-2">
                                <i class="fas fa-clock mr-1"></i>
                                Procesando imagen... esto puede tomar unos segundos
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Errores de validación -->
    @if ($errors->any())
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="alert alert-danger">
                    <h5>
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Errores de validación
                    </h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Resultados -->
    @if(isset($result))
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 col-lg-8">
                @if(isset($result['error']))
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-times-circle mr-2"></i>
                                Error en el procesamiento
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">
                                <strong>Error:</strong> {{ $result['error'] }}
                            </p>
                        </div>
                    </div>
                @elseif($result['match'])
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-check-circle mr-2"></i>
                                ¡Coincidencia encontrada!
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Información del criminal -->
                            @if(isset($result['criminal_info']) && $result['criminal_info'])
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <h5 class="text-dark">
                                                    <i class="fas fa-user mr-2"></i>
                                                    Información del Criminal
                                                </h5>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Nombre:</strong></td>
                                                                <td>
                                                                    {{ $result['criminal_info']['first_name'] }}
                                                                    @if(isset($result['criminal_info']['last_nameP']))
                                                                        {{ $result['criminal_info']['last_nameP'] }}
                                                                    @endif
                                                                    @if(isset($result['criminal_info']['last_nameM']))
                                                                        {{ $result['criminal_info']['last_nameM'] }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @if(isset($result['criminal_info']['identity_number']))
                                                                <tr>
                                                                    <td><strong>CI:</strong></td>
                                                                    <td>{{ $result['criminal_info']['identity_number'] }}</td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($result['criminal_info']['date_of_birth']))
                                                                <tr>
                                                                    <td><strong>Nacimiento:</strong></td>
                                                                    <td>{{ $result['criminal_info']['date_of_birth'] }}</td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($result['criminal_info']['age']))
                                                                <tr>
                                                                    <td><strong>Edad:</strong></td>
                                                                    <td>{{ $result['criminal_info']['age'] }} años</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><strong>ID:</strong></td>
                                                                <td>{{ $result['criminal_info']['id'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <div class="info-box bg-info">
                                            <div class="info-box-content">
                                                <h5 class="text-white">
                                                    <i class="fas fa-chart-line mr-2"></i>
                                                    Detalles de Comparación
                                                </h5>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-sm text-white">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>Archivo:</strong></td>
                                                                <td>{{ $result['filename'] ?? 'Desconocido' }}</td>
                                                            </tr>
                                                            @if(isset($result['confidence']))
                                                                <tr>
                                                                    <td><strong>Confianza:</strong></td>
                                                                    <td>
                                                                        <span class="badge badge-light">
                                                                            {{ number_format($result['confidence'] * 100, 2) }}%
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($result['processing_time']))
                                                                <tr>
                                                                    <td><strong>Tiempo:</strong></td>
                                                                    <td>{{ number_format($result['processing_time'], 2) }}s</td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($result['photos_processed']))
                                                                <tr>
                                                                    <td><strong>Fotos:</strong></td>
                                                                    <td>{{ $result['photos_processed'] }}/{{ $result['total_photos'] ?? 'N/A' }}</td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($result['method']))
                                                                <tr>
                                                                    <td><strong>Método:</strong></td>
                                                                    <td>{{ $result['method'] }}</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Advertencia -->
                                @if(isset($result['warning']))
                                    <div class="alert alert-warning mt-3">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>Advertencia:</strong> {{ $result['warning'] }}
                                    </div>
                                @endif
                                
                                <!-- Botón para ver perfil completo -->
                                @if(isset($result['criminal_info']['id']))
                                    <div class="text-center mt-4">
                                        <a href="/criminals/search_cri/{{ $result['criminal_info']['id'] }}" 
                                           class="btn btn-outline-primary btn-lg">
                                            <i class="fas fa-user-circle mr-2"></i>
                                            Ver perfil completo del criminal
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-search mr-2"></i>
                                No se encontró coincidencia
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <p class="mb-2">
                                        <strong>Resultado:</strong> {{ $result['message'] ?? 'La persona no se encuentra en la base de datos.' }}
                                    </p>
                                    
                                    @if(isset($result['processing_time']) || isset($result['photos_processed']))
                                        <div class="mt-3">
                                            <h6><i class="fas fa-info-circle mr-1"></i> Información del proceso:</h6>
                                            <ul class="list-unstyled">
                                                @if(isset($result['processing_time']))
                                                    <li>
                                                        <i class="fas fa-clock mr-1 text-muted"></i>
                                                        Tiempo de procesamiento: {{ number_format($result['processing_time'], 2) }} segundos
                                                    </li>
                                                @endif
                                                @if(isset($result['photos_processed']))
                                                    <li>
                                                        <i class="fas fa-images mr-1 text-muted"></i>
                                                        Fotos analizadas: {{ $result['photos_processed'] }} fotos
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-4 text-center">
                                    <i class="fas fa-user-slash fa-4x text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    /* Tema oscuro personalizado */
    body {
        background-color: #1a1a1a !important;
    }
    
    .card-dark {
        background-color: #2d2d2d;
        border-color: #404040;
    }
    
    .card-dark .card-header {
        background-color: #404040;
        border-color: #555;
        color: #fff;
    }
    
    .card-dark .card-body {
        background-color: #2d2d2d;
        color: #e9ecef;
    }
    
    .custom-file-label {
        background-color: #404040;
        border-color: #555;
        color: #e9ecef;
    }
    
    .custom-file-label::after {
        background-color: #555;
        border-color: #666;
        color: #fff;
    }
    
    .preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .preview-container img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 2px solid #555;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    .loading-container {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .info-box {
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table-sm td {
        padding: 0.5rem;
        border-bottom: 1px solid #404040;
    }
    
    /* Responsividad mejorada */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 10px;
        }
        
        .card-body {
            padding: 20px 15px;
        }
        
        .btn-lg {
            padding: 12px 25px;
            font-size: 16px;
        }
        
        .info-box {
            margin-bottom: 15px;
        }
        
        .preview-container img {
            max-height: 200px;
        }
    }
    
    @media (max-width: 576px) {
        .card-title {
            font-size: 1.1rem;
        }
        
        .btn-lg {
            width: 100%;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Actualizar etiqueta del archivo seleccionado
    $('.custom-file-input').on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo...');
        
        // Vista previa de la imagen
        const file = this.files[0];
        const preview = $('#preview');
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.html(`
                    <div class="text-center">
                        <img src="${e.target.result}" alt="Vista previa" class="img-fluid">
                        <p class="text-muted mt-2 mb-0">
                            <small><i class="fas fa-file-image mr-1"></i> ${file.name}</small>
                        </p>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        } else {
            preview.html('');
        }
    });
    
    // Manejar envío del formulario
    $('#faceForm').on('submit', function(e) {
        const submitBtn = $('#submitBtn');
        const loading = $('#loading');
        
        // Validar que se haya seleccionado un archivo
        if (!$('#photo').val()) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Archivo requerido',
                text: 'Por favor selecciona una imagen para continuar.',
                confirmButtonColor: '#007bff'
            });
            return;
        }
        
        // Mostrar estado de carga
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Procesando...');
        loading.show();
        
        // Agregar timeout de seguridad
        setTimeout(function() {
            if (submitBtn.prop('disabled')) {
                submitBtn.prop('disabled', false);
                submitBtn.html('<i class="fas fa-search mr-2"></i>Comparar Rostros');
                loading.hide();
            }
        }, 60000); // 60 segundos timeout
    });
    
    // Animación suave para las alertas
    $('.alert').hide().fadeIn(500);
    $('.card').hide().fadeIn(700);
});
</script>
@stop
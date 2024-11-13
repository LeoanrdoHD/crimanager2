@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1 class="class text-center">Agregar Historial a: {{ $criminal->first_name }} {{ $criminal->last_name }}</h1>
    <style>
        /* Estilo para alinear y centrar los checkboxes horizontalmente */
        .checkbox-container {
            display: flex;
            justify-content: center; /* Centra los checkboxes horizontalmente */
            gap: 10px;
            flex-wrap: wrap; /* Permite que los checkboxes pasen a la siguiente línea en pantallas pequeñas */
            margin-bottom: 20px;
        }
    
        /* Estilo para los separadores */
        .section-divider {
            border: 1px solid rgba(244, 244, 244, 0.478);
            width: 100%;
            display: none; /* Oculto inicialmente */
        }
    
        /* Ocultar secciones inicialmente */
        .section-content {
            display: none;
        }
    </style>
    
@stop
@section('content')

    @if (session('success'))
        <div id="success-alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 10px 20px; background-color: #4caf50; color: white; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div id="error-alert"
            style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 10px 20px; background-color: #f44336; color: white; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                const successAlert = document.getElementById('success-alert');
                if (successAlert) successAlert.style.display = 'none';

                const errorAlert = document.getElementById('error-alert');
                if (errorAlert) errorAlert.style.display = 'none';
            }, 3000);
        });
    </script>

    <div class="container">
        <form class="form-arrest" action="{{ route('criminals.store_arrest') }}" method="POST">
            @csrf
            <h2 class="class text-center text-lg ">PERFIL DEL DELINCUENTE</h2>
            <div class="grid grid-cols-3 gap-10">
                <div class="form-group">
                    <label>Nombres y Apellidos:</label>
                    <input type="text" class="form-control" name="nom_apell"
                        value="{{ $criminal->first_name }} {{ $criminal->last_name }}" disabled>
                </div>
                <div class="flex justify-center items-center"> <!-- Centrado con flexbox -->
                    @foreach ($fotos as $photographs)
                        @if ($photographs->criminal_id === $criminal->id)
                            <img src="{{ asset($photographs->frontal_photo) }}" width="100" alt="Foto Frontal"
                                style="border-radius: 50%; object-fit: cover;">
                        @endif
                    @endforeach
                </div>
                <div class="form-group">
                    <label>Cédula de Identidad/DNI:</label>
                    <input type="text" class="form-control" name="identity_number"
                        value="{{ $criminal->identity_number }}" disabled>
                </div>
            </div>
            <hr style="border: 1px solid rgba(244, 244, 244, 0.478); width: 100%;">
            <div class="class text-center text-lg">Llenar los siguientes datos</div>
        </form>
    </div>
    @include('criminals.partials.section1_situacion')
    <hr style="border: 1px solid rgba(244, 244, 244, 0.347); width: 100%;">
    <h2 class="class text-center text-lg ">Seleccione los Campos a LLenar</h2>
    <br>
    <div class="checkbox-container">
        <label><input type="checkbox" id="telefonosCheck" onclick="updateSections()"> Teléfonos</label>
        <label><input type="checkbox" id="armasCheck" onclick="updateSections()"> Armas</label>
        <label><input type="checkbox" id="aliasCheck" onclick="updateSections()"> Alias</label>
        <label><input type="checkbox" id="complicesCheck" onclick="updateSections()"> Cómplices</label>
        <label><input type="checkbox" id="organizacionCheck" onclick="updateSections()"> Organización</label>
        <label><input type="checkbox" id="condenasCheck" onclick="updateSections()"> Condenas</label>
        <label><input type="checkbox" id="vehiculosCheck" onclick="updateSections()"> Vehículos</label>
    </div>

    <!-- Secciones -->
    <div id="telefonos" class="section-content">
        @include('criminals.partials.section2_telefonos')
    </div>
    <hr id="telefonosHr" class="section-divider">

    <div id="armas" class="section-content">
        @include('criminals.partials.section4_armas')
    </div>
    <hr id="armasHr" class="section-divider">

    <div id="alias" class="section-content">
        @include('criminals.partials.section3_alias')
    </div>
    <hr id="aliasHr" class="section-divider">

    <div id="complices" class="section-content">
        @include('criminals.partials.section6_complices')
    </div>
    <hr id="complicesHr" class="section-divider">

    <div id="organizacion" class="section-content">
        @include('criminals.partials.section7_organizacion')
    </div>
    <hr id="organizacionHr" class="section-divider">

    <div id="condenas" class="section-content">
        @include('criminals.partials.section8_condenas')
    </div>
    <hr id="condenasHr" class="section-divider">
    <div id="vehiculos" class="section-content">
        @include('criminals.partials.section5_vehiculos')
    </div>
    <hr id="vehiculosHr" class="section-divider">

    <script>
        function updateSections() {
            // Lista de todas las secciones y sus checkboxes correspondientes
            const sections = [
                { checkboxId: 'telefonosCheck', sectionId: 'telefonos', hrId: 'telefonosHr' },
                { checkboxId: 'armasCheck', sectionId: 'armas', hrId: 'armasHr' },
                { checkboxId: 'aliasCheck', sectionId: 'alias', hrId: 'aliasHr' },
                { checkboxId: 'complicesCheck', sectionId: 'complices', hrId: 'complicesHr' },
                { checkboxId: 'organizacionCheck', sectionId: 'organizacion', hrId: 'organizacionHr' },
                { checkboxId: 'condenasCheck', sectionId: 'condenas', hrId: 'condenasHr' },
                { checkboxId: 'vehiculosCheck', sectionId: 'vehiculos', hrId: 'vehiculosHr' },
            ];

            // Actualiza la visibilidad de cada sección según el estado del checkbox
            sections.forEach(section => {
                const checkbox = document.getElementById(section.checkboxId);
                const sectionDiv = document.getElementById(section.sectionId);
                const hrDiv = document.getElementById(section.hrId);

                if (checkbox.checked) {
                    sectionDiv.style.display = "block";
                    hrDiv.style.display = "block";
                } else {
                    sectionDiv.style.display = "none";
                    hrDiv.style.display = "none";
                }
            });
        }
    </script>
@endsection

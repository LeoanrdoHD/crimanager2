@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1 class="class text-center">Agregar Historial a: {{ $criminal->first_name }} {{ $criminal->last_nameP }}
        {{ $criminal->last_nameM }}</h1>
    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #333 inset !important;
            /* Color de fondo oscuro */
            -webkit-text-fill-color: #fff !important;
            /* Color del texto */
            border: 1px solid #555;
            /* Asegurar que se mantenga un borde consistente */
        }

        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #444 inset !important;
            /* Color de fondo al hover o focus */
            -webkit-text-fill-color: #fff !important;
        }

        /* Estilo para alinear y centrar los checkboxes horizontalmente */
        .checkbox-container {
            display: flex;
            justify-content: center;
            /* Centra los checkboxes horizontalmente */
            gap: 10px;
            flex-wrap: wrap;
            /* Permite que los checkboxes pasen a la siguiente línea en pantallas pequeñas */
            margin-bottom: 20px;
        }

        /* Estilo para los separadores */
        .section-divider {
            border: 1px solid rgba(244, 244, 244, 0.478);
            width: 100%;
            display: none;
            /* Oculto inicialmente */
        }

        /* Ocultar secciones inicialmente */
        .section-content {
            display: none;
        }

        .form-group {
            margin-bottom: 10px;
            /* Reducir el espacio entre los grupos de formularios */
        }

        #newCityField {
            margin-top: 5px;
            /* Reducir el margen superior */
        }

        #newCityField label {
            margin-bottom: 3px;
            /* Reducir el margen debajo del label */
        }

        #newCityField input {
            margin-top: 3px;
            /* Reducir el margen superior del input */
        }
    </style>

@stop
@section('content')
    <style>
        .card-body {
            background: linear-gradient(rgba(0, 0, 0, 0.308),
                    rgba(0, 0, 0, 0.247)),

                background-size: cover;
            background-position: center;
            border-radius: 8px;
            color: white;
            /* Texto blanco para contraste */
            padding: 20px;
        }

        .form-group {
            margin-bottom: 10px;
            /* Ajusta el espacio entre los campos */
        }
    </style>
    <div class="card">
        <div class="card-body">
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
                    const sections = [{
                            checkboxId: 'telefonosCheck',
                            sectionId: 'telefonos',
                            hrId: 'telefonosHr'
                        },
                        {
                            checkboxId: 'armasCheck',
                            sectionId: 'armas',
                            hrId: 'armasHr'
                        },
                        {
                            checkboxId: 'aliasCheck',
                            sectionId: 'alias',
                            hrId: 'aliasHr'
                        },
                        {
                            checkboxId: 'complicesCheck',
                            sectionId: 'complices',
                            hrId: 'complicesHr'
                        },
                        {
                            checkboxId: 'organizacionCheck',
                            sectionId: 'organizacion',
                            hrId: 'organizacionHr'
                        },
                        {
                            checkboxId: 'condenasCheck',
                            sectionId: 'condenas',
                            hrId: 'condenasHr'
                        },
                        {
                            checkboxId: 'vehiculosCheck',
                            sectionId: 'vehiculos',
                            hrId: 'vehiculosHr'
                        },
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

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Seleccionar todos los formularios con la clase 'ajax-form'
                    document.querySelectorAll('.ajax-form').forEach(form => {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

                            // Crear una solicitud AJAX
                            const formData = new FormData(form);
                            fetch(form.action, {
                                    method: form.method,
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest', // Esto ayuda a Laravel a reconocer que es una solicitud AJAX
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Crear el contenedor del mensaje o seleccionarlo si ya existe
                                    let alertBox = document.getElementById('alert-box');
                                    if (!alertBox) {
                                        alertBox = document.createElement('div');
                                        alertBox.id = 'alert-box';
                                        alertBox.style.position = 'fixed';
                                        alertBox.style.top = '20px';
                                        alertBox.style.right = '20px';
                                        alertBox.style.zIndex = '9999';
                                        alertBox.style.padding = '10px 20px';
                                        alertBox.style.color = 'white';
                                        alertBox.style.borderRadius = '5px';
                                        document.body.appendChild(alertBox);
                                    }

                                    // Establecer el mensaje y el estilo
                                    alertBox.textContent = data.message;
                                    alertBox.style.backgroundColor = data.success ? '#4caf50' :
                                        '#f44336';

                                    // Mostrar el mensaje y ocultarlo después de 5 segundos
                                    alertBox.style.display = 'block';
                                    setTimeout(() => {
                                        alertBox.style.display = 'none';
                                    }, 5000);

                                    // Opcional: Reiniciar el formulario después de enviarlo
                                    if (data.success) form.reset();
                                })
                                .catch(error => {
                                    console.error('Error en la solicitud AJAX:', error);

                                    // Mostrar un mensaje de error en caso de fallo en la solicitud
                                    let alertBox = document.getElementById('alert-box');
                                    if (!alertBox) {
                                        alertBox = document.createElement('div');
                                        alertBox.id = 'alert-box';
                                        alertBox.style.position = 'fixed';
                                        alertBox.style.top = '20px';
                                        alertBox.style.right = '20px';
                                        alertBox.style.zIndex = '9999';
                                        alertBox.style.padding = '10px 20px';
                                        alertBox.style.color = 'white';
                                        alertBox.style.borderRadius = '5px';
                                        document.body.appendChild(alertBox);
                                    }

                                    alertBox.textContent = 'Ocurrió un error inesperado';
                                    alertBox.style.backgroundColor = '#f44336';
                                    alertBox.style.display = 'block';

                                    setTimeout(() => {
                                        alertBox.style.display = 'none';
                                    }, 5000);
                                });
                        });
                    });
                });
            </script>
        </div>
    </div>
@endsection

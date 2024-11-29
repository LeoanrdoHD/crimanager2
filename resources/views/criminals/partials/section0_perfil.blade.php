@vite('resources/css/app.css')
<div>
    <div class="container">
        <div>
            <form class="form-criminal" action="{{ route('criminals.store_criminal') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-10">
                    <div>
                        <label>DATOS GENERALES DE LEY</label>
                        <div class="form-group">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Ingrese el nombre"
                                value="{{ old('first_name') }}">
                            @error('first_name')
                                <br>
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-10">
                            <div class="form-group">
                                <label>Apellido Paterno:</label>
                                <input type="text" class="form-control" name="last_nameP"
                                    placeholder="Ingrese los apellido Paterno" value="{{ old('last_nameP') }}">
                            </div>
                            <div class="form-group">
                                <label>Apellido Materno:</label>
                                <input type="text" class="form-control" name="last_nameM"
                                    placeholder="Ingrese los apellido Materno" value="{{ old('last_nameM') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Cedula de Identidad/DNI:</label>
                            <input type="text" class="form-control" name="identity_number"
                                placeholder="Ingrese el numero de documento" value="{{ old('identity_number') }}">
                        </div>
                        <div class="grid grid-cols-2 gap-10">
                            <div class="form-group">
                                <label>Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                                    placeholder="día/mes/año" value="{{ old('date_of_birth') }}">
                            </div>
                            <div class="form-group">
                                <label>Edad:</label>
                                <input type="text" class="form-control" name="age" id="age"
                                    placeholder="Edad" readonly value="{{ old('age') }}">
                            </div>
                        </div>
                        <script>
                            document.getElementById('date_of_birth').addEventListener('change', function() {
                                const dob = new Date(this.value);
                                const today = new Date();
                                let age = today.getFullYear() - dob.getFullYear();
                                const monthDifference = today.getMonth() - dob.getMonth();

                                // Ajustar si el cumpleaños aún no ha ocurrido este año
                                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                                    age--;
                                }

                                document.getElementById('age').value = age >= 0 ? age : '';
                            });
                        </script>
                        <label>Lugar de Nacimiento:</label>
                        <div class="grid grid-cols-3 gap-10">
                            <!-- Selección de País -->
                            <div class="form-group">
                                <label for="country">País:</label>
                                <select id="country" name="country_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($pais as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('country_id') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCountryField" class="form-control" name="new_country_name"
                                    placeholder="Nombre del nuevo país"
                                    style="display: {{ old('country_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_country_name') }}">
                            </div>

                            <!-- Selección de Estado -->
                            <div class="form-group">
                                <label for="state">Estado/Departamento:</label>
                                <select id="state" name="state_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($provincia as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('state_id') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newStateField" class="form-control" name="new_state_name"
                                    placeholder="Nombre del nuevo estado"
                                    style="display: {{ old('state_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_state_name') }}">
                            </div>

                            <!-- Selección de Ciudad -->
                            <div class="form-group">
                                <label>Ciudad/Municipio:</label>
                                <select id="citySelect" name="city_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ciudad as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('city_id') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCityField" class="form-control" name="new_city_name"
                                    placeholder="Nombre de la nueva ciudad"
                                    style="display: {{ old('city_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_city_name') }}">
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const countrySelect = document.getElementById("country");
                                const stateSelect = document.getElementById("state");
                                const citySelect = document.getElementById("citySelect");

                                const newCountryField = document.getElementById("newCountryField");
                                const newStateField = document.getElementById("newStateField");
                                const newCityField = document.getElementById("newCityField");

                                // Manejar selección de país
                                countrySelect.addEventListener("change", function() {
                                    const countryId = this.value;

                                    if (countryId === "otro") {
                                        newCountryField.style.display = "block";
                                        stateSelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                        citySelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                    } else {
                                        newCountryField.style.display = "none";
                                        if (countryId) {
                                            fetch(`/states/${countryId}`)
                                                .then(response => response.json())
                                                .then(states => {
                                                    stateSelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    citySelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    states.forEach(state => {
                                                        stateSelect.innerHTML +=
                                                            `<option value="${state.id}">${state.state_name}</option>`;
                                                    });
                                                });
                                        } else {
                                            stateSelect.innerHTML = '<option value="">Seleccionar</option>';
                                            citySelect.innerHTML = '<option value="">Seleccionar</option>';
                                        }
                                    }
                                });

                                // Manejar selección de estado
                                stateSelect.addEventListener("change", function() {
                                    const stateId = this.value;

                                    if (stateId === "otro") {
                                        newStateField.style.display = "block";
                                        citySelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                    } else {
                                        newStateField.style.display = "none";
                                        if (stateId) {
                                            fetch(`/cities/${stateId}`)
                                                .then(response => response.json())
                                                .then(cities => {
                                                    citySelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    cities.forEach(city => {
                                                        citySelect.innerHTML +=
                                                            `<option value="${city.id}">${city.city_name}</option>`;
                                                    });
                                                });
                                        } else {
                                            citySelect.innerHTML = '<option value="">Seleccionar</option>';
                                        }
                                    }
                                });

                                // Manejar selección de ciudad
                                citySelect.addEventListener("change", function() {
                                    if (this.value === "otro") {
                                        newCityField.style.display = "block";
                                    } else {
                                        newCityField.style.display = "none";
                                    }
                                });
                            });
                        </script>

                        <div class="form-group">
                            <label>Nacionalidad</label>
                            <select class="form-control" name="nationality_id" id="nationalitySelect">
                                <option value="">Seleccione Nacionalidad</option>
                                @foreach ($nacionalidad as $nationality)
                                    <option value="{{ $nationality->id }}">{{ $nationality->nationality_name }}
                                    </option>
                                @endforeach
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Campo de texto para nueva nacionalidad (inicialmente oculto) -->
                        <div class="form-group" id="otherNationalityDiv" style="display: none;">
                            <label>Ingrese Nueva Nacionalidad</label>
                            <input type="text" class="form-control" name="otra_nacionalidad"
                                placeholder="Especifique la nacionalidad">
                        </div>
                        <script>
                            document.getElementById('nationalitySelect').addEventListener('change', function() {
                                const otherNationalityDiv = document.getElementById('otherNationalityDiv');
                                if (this.value === 'otro') {
                                    otherNationalityDiv.style.display = 'block';
                                } else {
                                    otherNationalityDiv.style.display = 'none';
                                }
                            });
                        </script>
                        <div class="form-group">
                            <label>Estado Civil</label>
                            <select class="form-control" name="civil_state_id">
                                <option value="">Seleccione Estado Civil</option>
                                @foreach ($civil_s as $civil_state)
                                    <option value="{{ $civil_state->id }}">{{ $civil_state->civil_state_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alias:</label>
                            <input type="text" class="form-control" name="alias_name"
                                placeholder="Ingrese el Alias Usado por el delincuente">
                        </div>
                        <div class="form-group">
                            <label>Ocupación/Profesión</label>
                            <select class="form-control" name="ocupation_id" id="ocupationSelect">
                                <option value="">Seleccionar</option>
                                @foreach ($ocupacion as $ocupation)
                                    <option value="{{ $ocupation->id }}">{{ $ocupation->ocupation_name }}
                                    </option>
                                @endforeach
                                <option value="otra">Otra</option>
                            </select>
                        </div>

                        <!-- Campo de texto para nueva ocupación (inicialmente oculto) -->
                        <div class="form-group" id="otherOcupationDiv" style="display: none;">
                            <label>Ingrese Nueva Ocupación/Profesión</label>
                            <input type="text" class="form-control" name="otra_ocupacion"
                                placeholder="Especifique la ocupación o profesión">
                        </div>
                        <script>
                            document.getElementById('ocupationSelect').addEventListener('change', function() {
                                const otherOcupationDiv = document.getElementById('otherOcupationDiv');
                                if (this.value === 'otra') {
                                    otherOcupationDiv.style.display = 'block';
                                } else {
                                    otherOcupationDiv.style.display = 'none';
                                }
                            });
                        </script>
                        <label>Lugar de Recidencia:</label>
                        <!-- Selección de País -->
                        <div class="grid grid-cols-3 gap-10">
                            <div class="form-group">
                                <label for="country_a">País:</label>
                                <select id="country_a" name="country_id_a" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($pais as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id_a') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('country_id_a') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCountryField_a" class="form-control"
                                    name="new_country_name_a" placeholder="Nombre del nuevo país"
                                    style="display: {{ old('country_id_a') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_country_name_a') }}">
                            </div>

                            <!-- Selección de Estado -->
                            <div class="form-group">
                                <label for="state_a">Estado/Departamento:</label>
                                <select id="state_a" name="state_id_a" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($provincia as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id_a') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('state_id_a') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newStateField_a" class="form-control"
                                    name="new_state_name_a" placeholder="Nombre del nuevo estado"
                                    style="display: {{ old('state_id_a') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_state_name_a') }}">
                            </div>

                            <!-- Selección de Ciudad -->
                            <div class="form-group">
                                <label for="citySelect_a">Ciudad/Municipio:</label>
                                <select id="citySelect_a" name="city_id_a" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ciudad as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id_a') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('city_id_a') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCityField_a" class="form-control"
                                    name="new_city_name_a" placeholder="Nombre de la nueva ciudad"
                                    style="display: {{ old('city_id_a') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_city_name_a') }}">
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const countrySelect = document.getElementById("country_a");
                                const stateSelect = document.getElementById("state_a");
                                const citySelect = document.getElementById("citySelect_a");

                                const newCountryField = document.getElementById("newCountryField_a");
                                const newStateField = document.getElementById("newStateField_a");
                                const newCityField = document.getElementById("newCityField_a");

                                // Manejar selección de país
                                countrySelect.addEventListener("change", function() {
                                    const countryId = this.value;

                                    if (countryId === "otro") {
                                        newCountryField.style.display = "block";
                                        stateSelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                        citySelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                    } else {
                                        newCountryField.style.display = "none";
                                        if (countryId) {
                                            fetch(`/states/${countryId}`)
                                                .then(response => response.json())
                                                .then(states => {
                                                    stateSelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    citySelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    states.forEach(state => {
                                                        stateSelect.innerHTML +=
                                                            `<option value="${state.id}">${state.state_name}</option>`;
                                                    });
                                                });
                                        } else {
                                            stateSelect.innerHTML = '<option value="">Seleccionar</option>';
                                            citySelect.innerHTML = '<option value="">Seleccionar</option>';
                                        }
                                    }
                                });

                                // Manejar selección de estado
                                stateSelect.addEventListener("change", function() {
                                    const stateId = this.value;

                                    if (stateId === "otro") {
                                        newStateField.style.display = "block";
                                        citySelect.innerHTML =
                                            '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                    } else {
                                        newStateField.style.display = "none";
                                        if (stateId) {
                                            fetch(`/cities/${stateId}`)
                                                .then(response => response.json())
                                                .then(cities => {
                                                    citySelect.innerHTML =
                                                        '<option value="">Seleccionar</option><option value="otro">Otro</option>';
                                                    cities.forEach(city => {
                                                        citySelect.innerHTML +=
                                                            `<option value="${city.id}">${city.city_name}</option>`;
                                                    });
                                                });
                                        } else {
                                            citySelect.innerHTML = '<option value="">Seleccionar</option>';
                                        }
                                    }
                                });

                                // Manejar selección de ciudad
                                citySelect.addEventListener("change", function() {
                                    if (this.value === "otro") {
                                        newCityField.style.display = "block";
                                    } else {
                                        newCityField.style.display = "none";
                                    }
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label>Direccion:</label>
                            <input type="text" class="form-control" name="street"
                                placeholder="Ingrese la direccion">
                        </div>
                        <div class="form-group">
                            <label>Persona de referencia</label>
                            <input type="text" class="form-control" name="partner_name"
                                placeholder="Nombre y Apellido">
                        </div>
                        <div class="form-group">
                            <label>Relacion con el delincuente</label>
                            <select class="form-control" name="relationship_type_id">
                                <option value="">Seleccionar</option>
                                @foreach ($t_relacion as $relationship_type)
                                    <option value="{{ $relationship_type->id }}">
                                        {{ $relationship_type->relationship_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Domicilio de la referencia:</label>
                            <input type="text" class="form-control" name="partner_address"
                                placeholder="Ingrese la direccion">
                        </div>
                    </div>
                    <div>
                        <label>RASGOS FISICOS</label>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Estatura (mts:)</label>
                                <input type="number" class="form-control" name="height" placeholder="Talla"
                                    min="120" max="210">
                            </div>
                            <div class="form-group">
                                <label>Peso (kg):</label>
                                <input type="number" class="form-control" name="weight" placeholder="Peso"
                                    min="35" max="120">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Conflexión:</label>
                                <select class="form-control" name="confleccion_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($conflexion as $confleccion)
                                        <option value="{{ $confleccion->id }}">
                                            {{ $confleccion->conflexion_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Color de piel:</label>
                                <select class="form-control" name="skin_color_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($color as $skin_color)
                                        <option value="{{ $skin_color->id }}">
                                            {{ $skin_color->skin_color_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Sexo:</label>
                                <select class="form-control" name="sex">
                                    <option value="">Seleccionar</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Genero:</label>
                                <select class="form-control" name="criminal_gender_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($genero as $criminal_gender)
                                        <option value="{{ $criminal_gender->id }}">
                                            {{ $criminal_gender->gender_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Tipos de Ojos:</label>
                                <select class="form-control" name="eye_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ojos as $eye_type)
                                        <option value="{{ $eye_type->id }}">
                                            {{ $eye_type->eye_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Nariz:</label>
                                <select class="form-control" name="nose_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($naris as $nose_type)
                                        <option value="{{ $nose_type->id }}">
                                            {{ $nose_type->nose_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="form-group">
                                <label>Tipo de labios:</label>
                                <select class="form-control" name="lip_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($labios as $lip_type)
                                        <option value="{{ $lip_type->id }}">
                                            {{ $lip_type->lip_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de orejas:</label>
                                <select class="form-control" name="ear_type_id">
                                    <option value="">Seleccionar</option>
                                    @foreach ($orejas as $ear_type)
                                        <option value="{{ $ear_type->id }}">
                                            {{ $ear_type->ear_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputnames">Caracteristicas Particulares:</label>
                            <input type="text" class="form-control" name="distinctive_marks"
                                placeholder="Descripccion">
                        </div>
                        <div><label>FOTOGRAFIAS:</label></div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label>Rostro:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="face_photo"
                                        id="facePhotoInput" onchange="previewImage(this, 'previewFace')"
                                        style="display: none;">
                                    <label class="custom-file-label" for="facePhotoInput">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewFace"
                                        src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100px; margin-top: 10px; cursor: pointer;"
                                        onclick="document.getElementById('facePhotoInput').click();">
                                </div>

                                <label>Perfil Izquierdo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="profile_izq_photo"
                                        id="profile_izq" onchange="previewImage(this, 'previewIzq')">
                                    <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewIzq"
                                        src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('profile_izq').click();">
                                </div>


                                <label>Cuerpo Completo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="full_body_photo"
                                        id="full_body_photo" onchange="previewImage(this, 'previewFullBody')">
                                    <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                                </div>
                                <div class="center-image-container">
                                    <img id="previewFullBody"
                                        src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                        alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                        onclick="document.getElementById('full_body_photo').click();">
                                </div>
                            </div>
                            <div>
                                <label>Medio Cuerpo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="frontal_photo"
                                        id="frontal_photo" onchange="previewImage(this, 'previewFrontal')">
                                    <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                                    <div class="invalid-feedback">Ejemplo de retroalimentación de archivo no válido
                                    </div>
                                    <div class="center-image-container">
                                        <img id="previewFrontal"
                                            src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                            alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                            onclick="document.getElementById('frontal_photo').click();">
                                    </div>

                                    <label>Perfil Derecho:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="profile_der_photo"
                                            id="profile_der_photo" onchange="previewImage(this, 'previewDer')">
                                        <label class="custom-file-label"
                                            for="validatedCustomFile">Seleccionar...</label>
                                    </div>
                                    <div class="center-image-container">
                                        <img id="previewDer"
                                            src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                            alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                            onclick="document.getElementById('profile_der_photo').click();">
                                    </div>

                                    <label>Foto Adicional:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="aditional_photo"
                                            id="aditional_photo" onchange="previewImage(this, 'previewaditional')">
                                        <label class="custom-file-label"
                                            for="validatedCustomFile">Seleccionar...</label>
                                    </div>
                                    <div class="center-image-container">
                                        <img id="previewaditional"
                                            src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                            alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                            onclick="document.getElementById('aditional_photo').click();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label>Foto en Barra:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="barra_photo" id="barra_photo"
                                onchange="previewImage(this, 'previewBarra')">
                            <label class="custom-file-label" for="validatedCustomFile">Seleccionar...</label>
                        </div>
                        <div class="center-image-container">
                            <img id="previewBarra"
                                src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                alt="Vista previa" style="width: 100px; margin-top: 10px;"
                                onclick="document.getElementById('barra_photo').click();">
                        </div>

                        <script>
                            function previewImage(input, previewId) {
                                let file = input.files[0];
                                let label = input.nextElementSibling;

                                // Actualizar el nombre del archivo en el label
                                label.innerText = file ? file.name : "Seleccionar...";

                                // Mostrar vista previa si es una imagen
                                if (file && file.type.startsWith("image/")) {
                                    let reader = new FileReader();
                                    reader.onload = function(e) {
                                        let preview = document.getElementById(previewId);
                                        preview.src = e.target.result;
                                    }
                                    reader.readAsDataURL(file);
                                } else {
                                    // Restablecer a la imagen predeterminada si el archivo no es válido
                                    let preview = document.getElementById(previewId);
                                    preview.src = "{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}";
                                }
                            }
                        </script>

                    </div>
                </div>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
        </form>
    </div>
</div>
</div>

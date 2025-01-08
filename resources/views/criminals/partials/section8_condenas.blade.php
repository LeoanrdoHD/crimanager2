@vite('resources/css/app.css')
<div>
    <div class="class text-center"><label>Registro de Sentencias Judiciales </label></div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest8') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div class="grid grid-cols-1 gap-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label>Tipo de Pena:</label>
                    <select class="form-control w-full" name="detention_type_id" id="detentionType"
                        onchange="mostrarCampos()">
                        <option value="">Seleccionar</option>
                        @foreach ($tcondena as $detention_type)
                            <option value="{{ $detention_type->id }}">{{ $detention_type->detention_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="camposDetencionPreventiva" style="display: none;">
                    <label>Prisión:</label>
                    <select class="form-control w-full" name="prison_name" id="prisonSelect"
                        onchange="llenarCamposPrision()">
                        <option value="">Seleccionar</option>
                        @foreach ($prision as $prison)
                            <option value="{{ $prison->id }}" data-direccion="{{ $prison->prison_location }}"
                                data-pais="{{ $prison->country->country_name }}"
                                data-estado="{{ $prison->state->state_name }}"
                                data-ciudad="{{ $prison->city->city_name }}">
                                {{ $prison->prison_name }}
                            </option>
                        @endforeach
                        <option value="otro">Otro</option>
                    </select>

                    <div id="camposOtraPrision" style="display: none; margin-top: 10px;">
                        <label>Nombre de la Prisión:</label>
                        <input type="text" class="form-control w-full" name="otra_prision_nombre"
                            placeholder="Nombre de la prisión">
                        <label>Dirección de la Prisión:</label>
                        <input type="text" class="form-control w-full" name="prison_location"
                            placeholder="Dirección">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="country_p">País:</label>
                                <select id="country_p" name="country_id_p" class="form-control w-full">
                                    <option value="">Seleccionar</option>
                                    @foreach ($pais as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id_p') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('country_id_p') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCountryField_p" class="form-control w-full"
                                    name="new_country_name_p" placeholder="Nombre del nuevo país"
                                    style="display: {{ old('country_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_country_name_p') }}">
                            </div>

                            <div class="form-group">
                                <label for="state_p">Estado/Departamento:</label>
                                <select id="state_p" name="province_id_p" class="form-control w-full">
                                    <option value="">Seleccionar</option>
                                    @foreach ($provincia as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('province_id_p') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('province_id_p') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newStateField_p" class="form-control w-full"
                                    name="new_state_name_p" placeholder="Nombre del nuevo estado"
                                    style="display: {{ old('province_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_state_name_p') }}">
                            </div>

                            <div class="form-group">
                                <label for="citySelect_p">Ciudad/Municipio:</label>
                                <select id="citySelect_p" name="city_id_p" class="form-control w-full">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ciudad as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id_p') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('city_id_p') == 'otro' ? 'selected' : '' }}>Otro
                                    </option>
                                </select>
                                <input type="text" id="newCityField_p" class="form-control w-full"
                                    name="new_city_name_p" placeholder="Nombre de la nueva ciudad"
                                    style="display: {{ old('city_id_p') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                    value="{{ old('new_city_name_p') }}">
                            </div>
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const prisonSelect = document.getElementById("prisonSelect");
                                const camposOtraPrision = document.getElementById("camposOtraPrision");
                                const camposPrisionSeleccionada = document.getElementById("camposPrisionSeleccionada");

                                const prisonLocationField = document.getElementById("prisonLocation");
                                const paisField = document.getElementById("pais");
                                const depField = document.getElementById("dep");
                                const cityField = document.getElementById("city");

                                prisonSelect.addEventListener("change", function() {
                                    const selectedOption = this.options[this.selectedIndex];
                                    const prisonId = this.value;

                                    if (prisonId === "otro") {
                                        // Mostrar campos para ingresar nueva prisión
                                        camposOtraPrision.style.display = "block";
                                        camposPrisionSeleccionada.style.display = "none";

                                        // Limpiar campos de prisión seleccionada
                                        prisonLocationField.value = "";
                                        paisField.value = "";
                                        depField.value = "";
                                        cityField.value = "";

                                    } else if (prisonId) {
                                        // Mostrar detalles de la prisión seleccionada
                                        camposOtraPrision.style.display = "none";
                                        camposPrisionSeleccionada.style.display = "block";

                                        // Llenar campos con los datos de la prisión seleccionada
                                        prisonLocationField.value = selectedOption.getAttribute("data-direccion") || "";
                                        paisField.value = selectedOption.getAttribute("data-pais") || "";
                                        depField.value = selectedOption.getAttribute("data-estado") || "";
                                        cityField.value = selectedOption.getAttribute("data-ciudad") || "";
                                    } else {
                                        // Si no hay selección, ocultar todo
                                        camposOtraPrision.style.display = "none";
                                        camposPrisionSeleccionada.style.display = "none";

                                        // Limpiar campos
                                        prisonLocationField.value = "";
                                        paisField.value = "";
                                        depField.value = "";
                                        cityField.value = "";
                                    }
                                });
                            });
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const countrySelect = document.getElementById("country_p");
                                const stateSelect = document.getElementById("state_p");
                                const citySelect = document.getElementById("citySelect_p");

                                const newCountryField = document.getElementById("newCountryField_p");
                                const newStateField = document.getElementById("newStateField_p");
                                const newCityField = document.getElementById("newCityField_p");

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
                    </div>

                    <!-- Campos para mostrar los detalles de la prisión seleccionada -->
                    <div id="camposPrisionSeleccionada" style="margin-top: 10px;">
                        <label>Dirección de la Prisión:</label>
                        <input type="text" class="form-control" id="prisonLocation" readonly>
                        <label>País:</label>
                        <input type="text" class="form-control" id="pais" readonly>
                        <label>Departamento/Estado:</label>
                        <input type="text" class="form-control" id="dep" readonly>
                        <label>Ciudad:</label>
                        <input type="text" class="form-control" id="city" readonly>
                    </div>

                    <label>Fecha de Ingreso:</label>
                    <input type="date" class="form-control" name="prison_entry_date">
                    <label>Fecha de Salida:</label>
                    <input type="date" class="form-control" name="prison_release_date">
                </div>
                <!-- Campos para Detención Domiciliaria -->
                <div id="camposDetencionDomiciliaria" style="display: none;">
                    <label>Dirección de Detención Domiciliaria:</label>
                    <input type="text" class="form-control w-full" name="house_arrest_address"
                        placeholder="Ingrese una dirección">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label for="country_d">País:</label>
                            <select id="country_d" name="country_id_d" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($pais as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id_d') == $country->id ? 'selected' : '' }}>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('country_id_d') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCountryField_d" class="form-control w-full"
                                name="new_country_name_d" placeholder="Nombre del nuevo país"
                                style="display: {{ old('country_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_country_name_d') }}">
                        </div>

                        <!-- Selección de Estado -->
                        <div class="form-group">
                            <label for="state_d">Estado/Departamento:</label>
                            <select id="state_d" name="province_id_d" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($provincia as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('province_id_d') == $state->id ? 'selected' : '' }}>
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('province_id_d') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newStateField_d" class="form-control w-full"
                                name="new_state_name_d" placeholder="Nombre del nuevo estado"
                                style="display: {{ old('province_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_state_name_d') }}">
                        </div>

                        <!-- Selección de Ciudad -->
                        <div class="form-group">
                            <label for="citySelect_d">Ciudad/Municipio:</label>
                            <select id="citySelect_d" name="city_id_d" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($ciudad as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id_d') == $city->id ? 'selected' : '' }}>
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('city_id_d') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCityField_d" class="form-control w-full"
                                name="new_city_name_d" placeholder="Nombre de la nueva ciudad"
                                style="display: {{ old('city_id_d') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_city_name_d') }}">
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const countrySelect = document.getElementById("country_d");
                            const stateSelect = document.getElementById("state_d");
                            const citySelect = document.getElementById("citySelect_d");

                            const newCountryField = document.getElementById("newCountryField_d");
                            const newStateField = document.getElementById("newStateField_d");
                            const newCityField = document.getElementById("newCityField_d");

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
                </div>
                <!-- Campos para Extradición -->
                <div id="camposExtradicion" style="display: none;">
                    <label>Fecha de Extradición:</label>
                    <input type="date" class="form-control w-full" name="extradition_date">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label for="country_e">País:</label>
                            <select id="country_e" name="country_id_e" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($pais as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id_e') == $country->id ? 'selected' : '' }}>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('country_id_e') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCountryField_e" class="form-control w-full"
                                name="new_country_name_e" placeholder="Nombre del nuevo país"
                                style="display: {{ old('country_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_country_name_e') }}">
                        </div>

                        <!-- Selección de Estado -->
                        <div class="form-group">
                            <label for="state_e">Estado/Departamento:</label>
                            <select id="state_e" name="province_id_e" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($provincia as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('province_id_e') == $state->id ? 'selected' : '' }}>
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('province_id_e') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newStateField_e" class="form-control w-full"
                                name="new_state_name_e" placeholder="Nombre del nuevo estado"
                                style="display: {{ old('province_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_state_name_e') }}">
                        </div>

                        <!-- Selección de Ciudad -->
                        <div class="form-group">
                            <label for="citySelect_e">Ciudad/Municipio:</label>
                            <select id="citySelect_e" name="city_id_e" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($ciudad as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id_e') == $city->id ? 'selected' : '' }}>
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('city_id_e') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCityField_e" class="form-control w-full"
                                name="new_city_name_e" placeholder="Nombre de la nueva ciudad"
                                style="display: {{ old('city_id_e') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_city_name_e') }}">
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const countrySelect = document.getElementById("country_e");
                            const stateSelect = document.getElementById("state_e");
                            const citySelect = document.getElementById("citySelect_e");

                            const newCountryField = document.getElementById("newCountryField_e");
                            const newStateField = document.getElementById("newStateField_e");
                            const newCityField = document.getElementById("newCityField_e");

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
                </div>
                <!-- Campos para Libertad -->
                <div id="camposLibertad" style="display: none;">
                    <label>Dirección:</label>
                    <input type="text" class="form-control w-full" name="house_address"
                        placeholder="Ingrese una dirección">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label for="country_l">País:</label>
                            <select id="country_l" name="country_id_l" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($pais as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id_l') == $country->id ? 'selected' : '' }}>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('country_id_l') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCountryField_l" class="form-control w-full"
                                name="new_country_name_l" placeholder="Nombre del nuevo país"
                                style="display: {{ old('country_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_country_name_l') }}">
                        </div>

                        <!-- Selección de Estado -->
                        <div class="form-group">
                            <label for="state_l">Estado/Departamento:</label>
                            <select id="state_l" name="province_id_l" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($provincia as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('province_id_l') == $state->id ? 'selected' : '' }}>
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('province_id_l') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newStateField_l" class="form-control w-full"
                                name="new_state_name_l" placeholder="Nombre del nuevo estado"
                                style="display: {{ old('province_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_state_name_l') }}">
                        </div>

                        <!-- Selección de Ciudad -->
                        <div class="form-group">
                            <label for="citySelect_l">Ciudad/Municipio:</label>
                            <select id="citySelect_l" name="city_id_l" class="form-control w-full">
                                <option value="">Seleccionar</option>
                                @foreach ($ciudad as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id_l') == $city->id ? 'selected' : '' }}>
                                        {{ $city->city_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('city_id_l') == 'otro' ? 'selected' : '' }}>Otro
                                </option>
                            </select>
                            <input type="text" id="newCityField_l" class="form-control w-full"
                                name="new_city_name_l" placeholder="Nombre de la nueva ciudad"
                                style="display: {{ old('city_id_l') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                                value="{{ old('new_city_name_l') }}">
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const countrySelect = document.getElementById("country_l");
                            const stateSelect = document.getElementById("state_l");
                            const citySelect = document.getElementById("citySelect_l");

                            const newCountryField = document.getElementById("newCountryField_l");
                            const newStateField = document.getElementById("newStateField_l");
                            const newCityField = document.getElementById("newCityField_l");

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
                </div>


            </div>
        </div>
        <br>
        <div>
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>
    <script>
        function mostrarCampos() {
            const detentionType = document.getElementById("detentionType").value;

            // Ocultar todos los campos
            document.getElementById("camposDetencionPreventiva").style.display = "none";
            document.getElementById("camposOtraPrision").style.display = "none";
            document.getElementById("camposDetencionDomiciliaria").style.display = "none";
            document.getElementById("camposExtradicion").style.display = "none";
            document.getElementById("camposLibertad").style.display = "none";

            // Mostrar campos según el tipo de detención seleccionado
            if (detentionType === "1") {
                document.getElementById("camposDetencionPreventiva").style.display = "block";
            } else if (detentionType === "2") {
                document.getElementById("camposDetencionDomiciliaria").style.display = "block";
            } else if (detentionType === "3") {
                document.getElementById("camposExtradicion").style.display = "block";
            } else if (detentionType === "4") {
                document.getElementById("camposLibertad").style.display = "block";
            }
        }

        function llenarCamposPrision() {
            const select = document.getElementById("prisonSelect");
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                // Obtener los datos del atributo data-*
                const direccion = selectedOption.getAttribute("data-direccion") || "N/A";
                const pais = selectedOption.getAttribute("data-pais") || "N/A";
                const estado = selectedOption.getAttribute("data-estado") || "N/A";
                const ciudad = selectedOption.getAttribute("data-ciudad") || "N/A";

                // Depuración en la consola
                console.log("Datos seleccionados:");
                console.log("Dirección:", direccion);
                console.log("País:", pais);
                console.log("Estado:", estado);
                console.log("Ciudad:", ciudad);

                // Actualizar los campos del formulario
                document.getElementById("prisonLocation").value = direccion;
                document.getElementById("pais").value = pais;
                document.getElementById("dep").value = estado;
                document.getElementById("city").value = ciudad;
            } else {
                console.error("No se seleccionó ninguna opción válida.");
            }
        }
    </script>

</div>

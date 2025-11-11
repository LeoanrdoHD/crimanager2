@vite('resources/css/app.css')

<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest4') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        <div class="text-center"><label>Alias y otras identidades:</label></div>
        <div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                <div>
                    <label>OTRAS IDENTIDADES</label>
                    <div class="form-group">
                        <label>Otros Nombre:</label>
                        <input type="text" class="form-control w-full" name="alias_name" placeholder="Nombre y Apellidos">
                    </div>
                    <div class="form-group">
                        <label>Otros Numeros de Identidad:</label>
                        <input type="text" class="form-control w-full" name="alias_identity_number"
                            placeholder="Ingresar CI/DNI">
                    </div>
                </div>
                <div>
                    <br>
                    <div class="form-group">
                        <label>Otras Nacionalidades</label>
                        <select class="form-control w-full" name="nationality_id" id="nationalitySelect">
                            <option value="">Seleccione Nacionalidad</option>
                            @foreach ($nacionalidad as $nationality)
                                <option value="{{ $nationality->id }}">{{ $nationality->nationality_name }}</option>
                            @endforeach
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    
                    <!-- Campo de texto para nueva nacionalidad (inicialmente oculto) -->
                    <div class="form-group" id="otherNationalityDiv" style="display: none;">
                        <label>Ingrese Nueva Nacionalidad</label>
                        <input type="text" class="form-control w-full" name="otra_nacionalidad"
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
                        <label>Otros Direcciones de Residencia:</label>
                        <input type="text" class="form-control w-full" name="street" placeholder="Ingresar Direccion">
                    </div>
                    <label>Lugar de residencia:</label>
                    <!-- Selección de País -->
                    <div class="form-group">
                        <label for="country">País:</label>
                        <select id="country" name="country_id" class="form-control w-full">
                            <option value="">Seleccionar</option>
                            @foreach ($pais as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->country_name }}
                                </option>
                            @endforeach
                            <option value="otro" {{ old('country_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <input type="text" id="newCountryField" class="form-control w-full" name="new_country_name"
                            placeholder="Nombre del nuevo país"
                            style="display: {{ old('country_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                            value="{{ old('new_country_name') }}">
                    </div>

                    <!-- Selección de Estado -->
                    <div class="form-group">
                        <label for="state">Estado/Departamento:</label>
                        <select id="state" name="state_id" class="form-control w-full">
                            <option value="">Seleccionar</option>
                            @foreach ($provincia as $state)
                                <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                    {{ $state->state_name }}
                                </option>
                            @endforeach
                            <option value="otro" {{ old('state_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <input type="text" id="newStateField" class="form-control w-full" name="new_state_name"
                            placeholder="Nombre del nuevo estado"
                            style="display: {{ old('state_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                            value="{{ old('new_state_name') }}">
                    </div>

                    <!-- Selección de Ciudad -->
                    <div class="form-group">
                        <label>Ciudad/Municipio:</label>
                        <select id="citySelect" name="city_id" class="form-control w-full">
                            <option value="">Seleccionar</option>
                            @foreach ($ciudad as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                    {{ $city->city_name }}
                                </option>
                            @endforeach
                            <option value="otro" {{ old('city_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <input type="text" id="newCityField" class="form-control w-full" name="new_city_name"
                            placeholder="Nombre de la nueva ciudad"
                            style="display: {{ old('city_id') == 'otro' ? 'block' : 'none' }}; margin-top: 5px;"
                            value="{{ old('new_city_name') }}">
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
                </div>
                <div class="flex justify-center">
                    <button class="btn btn-primary" type="submit">GUARDAR</button>
                </div>
            </div>
        </div>
    </form>
</div>

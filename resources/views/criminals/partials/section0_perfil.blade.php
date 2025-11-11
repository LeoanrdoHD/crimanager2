@vite('resources/css/app.css')
<link rel="stylesheet" href="{{ asset('css/criminal-form.css') }}">
<meta name="default-image-path" content="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}">

<div class="container">
    <div class="card">
        <div class="card-body">
            <form class="form-criminal" action="{{ route('criminals.store_criminal') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- SECCIÓN IZQUIERDA: DATOS GENERALES -->
                    <div>
                        <div class="section-title">DATOS GENERALES DE LEY (Llenar todo en Mayúsculas)</div>
                        
                        <!-- Nombres -->
                        <div class="form-group">
                            <label class="required-field">Nombres:</label>
                            <input type="text" 
                                   class="form-control w-full @error('first_name') border-red-500 @enderror" 
                                   name="first_name"
                                   placeholder="Ingrese el nombre" 
                                   value="{{ old('first_name') }}"
                                   required>
                            @error('first_name')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Apellido Paterno:</label>
                                <input type="text" 
                                       class="form-control w-full @error('last_nameP') border-red-500 @enderror" 
                                       name="last_nameP"
                                       placeholder="Apellido Paterno" 
                                       value="{{ old('last_nameP') }}"
                                       required>
                                @error('last_nameP')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Apellido Materno:</label>
                                <input type="text" 
                                       class="form-control w-full @error('last_nameM') border-red-500 @enderror" 
                                       name="last_nameM"
                                       placeholder="Apellido Materno" 
                                       value="{{ old('last_nameM') }}">
                                @error('last_nameM')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Cédula de Identidad -->
                        <div class="form-group">
                            <label class="required-field">Cédula de Identidad/DNI:</label>
                            <input type="text" 
                                   class="form-control w-full @error('identity_number') border-red-500 @enderror" 
                                   name="identity_number"
                                   placeholder="Ej: 1234567-OR, 12345678-ABC, 123456789" 
                                   value="{{ old('identity_number') }}"
                                   maxlength="23"
                                   title="Formato: De 1 a 20 dígitos, opcionalmente seguidos de guion y de 1 a 3 letras mayúsculas"
                                   required>
                            @error('identity_number')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                            <small class="text-gray-400 text-xs mt-1">
                                Formatos válidos: Solo números, o números seguidos de guion y letras (Ej: 1234567-OR, 12345678-ABC)
                            </small>
                        </div>

                        <!-- Fecha de Nacimiento y Edad -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Fecha de Nacimiento:</label>
                                <input type="date" 
                                       class="form-control w-full @error('date_of_birth') border-red-500 @enderror" 
                                       name="date_of_birth"
                                       id="date_of_birth" 
                                       value="{{ old('date_of_birth') }}"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('date_of_birth')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="required-field">Edad:</label>
                                <input type="number" 
                                       class="form-control w-full bg-gray-100 @error('age') border-red-500 @enderror" 
                                       name="age" 
                                       id="age"
                                       placeholder="Edad" 
                                       readonly 
                                       value="{{ old('age') }}"
                                       required>
                                @error('age')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Lugar de Nacimiento -->
                        <div class="section-title" style="margin-top: 20px;">Lugar de Nacimiento</div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="country" class="required-field">País:</label>
                                <select id="country" name="country_id" class="form-control w-full @error('country_id') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($pais as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('country_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newCountryField" 
                                       class="form-control w-full mt-2 @error('new_country_name') border-red-500 @enderror" 
                                       name="new_country_name" 
                                       placeholder="Nombre del nuevo país"
                                       style="display: {{ old('country_id') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_country_name') }}">
                                @error('country_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_country_name')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="state" class="required-field">Estado/Departamento:</label>
                                <select id="state" name="state_id" class="form-control w-full @error('state_id') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($provincia as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('state_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newStateField" 
                                       class="form-control w-full mt-2 @error('new_state_name') border-red-500 @enderror" 
                                       name="new_state_name" 
                                       placeholder="Nombre del nuevo estado"
                                       style="display: {{ old('state_id') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_state_name') }}">
                                @error('state_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_state_name')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="citySelect" class="required-field">Ciudad/Municipio:</label>
                                <select id="citySelect" name="city_id" class="form-control w-full @error('city_id') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($ciudad as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('city_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newCityField" 
                                       class="form-control w-full mt-2 @error('new_city_name') border-red-500 @enderror" 
                                       name="new_city_name"
                                       placeholder="Nombre de la nueva ciudad"
                                       style="display: {{ old('city_id') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_city_name') }}">
                                @error('city_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_city_name')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Nacionalidad -->
                        <div class="form-group">
                            <label class="required-field">Nacionalidad:</label>
                            <select class="form-control w-full @error('nationality_id') border-red-500 @enderror" name="nationality_id" id="nationalitySelect" required>
                                <option value="">Seleccione Nacionalidad</option>
                                @foreach ($nacionalidad as $nationality)
                                    <option value="{{ $nationality->id }}" {{ old('nationality_id') == $nationality->id ? 'selected' : '' }}>
                                        {{ $nationality->nationality_name }}
                                    </option>
                                @endforeach
                                <option value="otro" {{ old('nationality_id') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('nationality_id')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group" id="otherNationalityDiv" style="display: {{ old('nationality_id') == 'otro' ? 'block' : 'none' }};">
                            <label class="required-field">Ingrese Nueva Nacionalidad:</label>
                            <input type="text" 
                                   class="form-control w-full @error('otra_nacionalidad') border-red-500 @enderror" 
                                   name="otra_nacionalidad"
                                   placeholder="Especifique la nacionalidad" 
                                   value="{{ old('otra_nacionalidad') }}">
                            @error('otra_nacionalidad')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Estado Civil -->
                        <div class="form-group">
                            <label class="required-field">Estado Civil:</label>
                            <select class="form-control w-full @error('civil_state_id') border-red-500 @enderror" name="civil_state_id" required>
                                <option value="">Seleccione Estado Civil</option>
                                @foreach ($civil_s as $civil_state)
                                    <option value="{{ $civil_state->id }}" {{ old('civil_state_id') == $civil_state->id ? 'selected' : '' }}>
                                        {{ $civil_state->civil_state_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('civil_state_id')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Alias -->
                        <div class="form-group">
                            <label class="required-field">Alias:</label>
                            <input type="text" 
                                   class="form-control w-full @error('alias_name') border-red-500 @enderror" 
                                   name="alias_name"
                                   placeholder="Ingrese el Alias Usado por el delincuente"
                                   value="{{ old('alias_name') }}"
                                   required>
                            @error('alias_name')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Ocupación -->
                        <div class="form-group">
                            <label class="required-field">Ocupación/Profesión:</label>
                            <select class="form-control w-full @error('ocupation_id') border-red-500 @enderror" name="ocupation_id" id="ocupationSelect" required>
                                <option value="">Seleccionar</option>
                                @foreach ($ocupacion as $ocupation)
                                    <option value="{{ $ocupation->id }}" {{ old('ocupation_id') == $ocupation->id ? 'selected' : '' }}>
                                        {{ $ocupation->ocupation_name }}
                                    </option>
                                @endforeach
                                <option value="otra" {{ old('ocupation_id') == 'otra' ? 'selected' : '' }}>Otra</option>
                            </select>
                            @error('ocupation_id')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group" id="otherOcupationDiv" style="display: {{ old('ocupation_id') == 'otra' ? 'block' : 'none' }};">
                            <label class="required-field">Ingrese Nueva Ocupación/Profesión:</label>
                            <input type="text" 
                                   class="form-control w-full @error('otra_ocupacion') border-red-500 @enderror" 
                                   name="otra_ocupacion"
                                   placeholder="Especifique la ocupación o profesión"
                                   value="{{ old('otra_ocupacion') }}">
                            @error('otra_ocupacion')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Lugar de Residencia -->
                        <div class="section-title" style="margin-top: 20px;">Lugar de Residencia</div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="country_a" class="required-field">País:</label>
                                <select id="country_a" name="country_id_a" class="form-control w-full @error('country_id_a') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($pais as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id_a') == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('country_id_a') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newCountryField_a" 
                                       class="form-control w-full mt-2 @error('new_country_name_a') border-red-500 @enderror" 
                                       name="new_country_name_a" 
                                       placeholder="Nombre del nuevo país"
                                       style="display: {{ old('country_id_a') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_country_name_a') }}">
                                @error('country_id_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_country_name_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="state_a" class="required-field">Estado/Departamento:</label>
                                <select id="state_a" name="state_id_a" class="form-control w-full @error('state_id_a') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($provincia as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id_a') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('state_id_a') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newStateField_a" 
                                       class="form-control w-full mt-2 @error('new_state_name_a') border-red-500 @enderror" 
                                       name="new_state_name_a" 
                                       placeholder="Nombre del nuevo estado"
                                       style="display: {{ old('state_id_a') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_state_name_a') }}">
                                @error('state_id_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_state_name_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="citySelect_a" class="required-field">Ciudad/Municipio:</label>
                                <select id="citySelect_a" name="city_id_a" class="form-control w-full @error('city_id_a') border-red-500 @enderror" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($ciudad as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id_a') == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                    <option value="otro" {{ old('city_id_a') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                <input type="text" 
                                       id="newCityField_a" 
                                       class="form-control w-full mt-2 @error('new_city_name_a') border-red-500 @enderror" 
                                       name="new_city_name_a"
                                       placeholder="Nombre de la nueva ciudad"
                                       style="display: {{ old('city_id_a') == 'otro' ? 'block' : 'none' }};" 
                                       value="{{ old('new_city_name_a') }}">
                                @error('city_id_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                                @error('new_city_name_a')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="form-group">
                            <label class="required-field">Dirección:</label>
                            <input type="text" 
                                   class="form-control w-full @error('street') border-red-500 @enderror" 
                                   name="street" 
                                   value="{{ old('street') }}"
                                   placeholder="Ingrese la dirección"
                                   required>
                            @error('street')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Persona de referencia -->
                        <div class="section-title" style="margin-top: 20px;">Datos de Referencia</div>
                        <div class="form-group">
                            <label>Persona de referencia:</label>
                            <input type="text" 
                                   class="form-control w-full @error('partner_name') border-red-500 @enderror" 
                                   name="partner_name"
                                   value="{{ old('partner_name') }}" 
                                   placeholder="Nombre y Apellido">
                            @error('partner_name')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Relación con el delincuente:</label>
                            <select class="form-control w-full @error('relationship_type_id') border-red-500 @enderror" name="relationship_type_id">
                                <option value="">Seleccionar</option>
                                @foreach ($t_relacion as $relationship_type)
                                    <option value="{{ $relationship_type->id }}" {{ old('relationship_type_id') == $relationship_type->id ? 'selected' : '' }}>
                                        {{ $relationship_type->relationship_type_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('relationship_type_id')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Domicilio de la referencia:</label>
                            <input type="text" 
                                   class="form-control w-full @error('partner_address') border-red-500 @enderror" 
                                   name="partner_address"
                                   value="{{ old('partner_address') }}" 
                                   placeholder="Ingrese la dirección">
                            @error('partner_address')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- SECCIÓN DERECHA: RASGOS FÍSICOS Y FOTOGRAFÍAS -->
                    <div>
                        <div class="section-title">RASGOS FÍSICOS</div>
                        
                        <!-- Estatura y Peso -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Estatura (cm):</label>
                                <input type="number" 
                                       class="form-control w-full @error('height') border-red-500 @enderror" 
                                       name="height" 
                                       placeholder="Altura en cm" 
                                       min="120" 
                                       max="210"
                                       value="{{ old('height') }}"
                                       required>
                                @error('height')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Peso (kg):</label>
                                <input type="number" 
                                       class="form-control w-full @error('weight') border-red-500 @enderror" 
                                       name="weight" 
                                       placeholder="Peso en kg" 
                                       min="35" 
                                       max="200"
                                       value="{{ old('weight') }}">
                                @error('weight')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Complexión y Color de Piel -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Complexión:</label>
                                <select class="form-control w-full @error('confleccion_id') border-red-500 @enderror" name="confleccion_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($conflexion as $confleccion)
                                        <option value="{{ $confleccion->id }}" {{ old('confleccion_id') == $confleccion->id ? 'selected' : '' }}>
                                            {{ $confleccion->conflexion_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('confleccion_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="required-field">Color de piel:</label>
                                <select class="form-control w-full @error('skin_color_id') border-red-500 @enderror" name="skin_color_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($color as $skin_color)
                                        <option value="{{ $skin_color->id }}" {{ old('skin_color_id') == $skin_color->id ? 'selected' : '' }}>
                                            {{ $skin_color->skin_color_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skin_color_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Sexo y Género -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Sexo:</label>
                                <select class="form-control w-full @error('sex') border-red-500 @enderror" name="sex" required>
                                    <option value="">Seleccionar</option>
                                    <option value="MASCULINO" {{ old('sex') == 'MASCULINO' ? 'selected' : '' }}>MASCULINO</option>
                                    <option value="FEMENINO" {{ old('sex') == 'FEMENINO' ? 'selected' : '' }}>FEMENINO</option>
                                </select>
                                @error('sex')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="required-field">Género:</label>
                                <select class="form-control w-full @error('criminal_gender_id') border-red-500 @enderror" name="criminal_gender_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($genero as $criminal_gender)
                                        <option value="{{ $criminal_gender->id }}" {{ old('criminal_gender_id') == $criminal_gender->id ? 'selected' : '' }}>
                                            {{ $criminal_gender->gender_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('criminal_gender_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Características Faciales -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Tipo de Ojos:</label>
                                <select class="form-control w-full @error('eye_type_id') border-red-500 @enderror" name="eye_type_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($ojos as $eye_type)
                                        <option value="{{ $eye_type->id }}" {{ old('eye_type_id') == $eye_type->id ? 'selected' : '' }}>
                                            {{ $eye_type->eye_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('eye_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="required-field">Tipo de Nariz:</label>
                                <select class="form-control w-full @error('nose_type_id') border-red-500 @enderror" name="nose_type_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($naris as $nose_type)
                                        <option value="{{ $nose_type->id }}" {{ old('nose_type_id') == $nose_type->id ? 'selected' : '' }}>
                                            {{ $nose_type->nose_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nose_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="required-field">Tipo de Labios:</label>
                                <select class="form-control w-full @error('lip_type_id') border-red-500 @enderror" name="lip_type_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($labios as $lip_type)
                                        <option value="{{ $lip_type->id }}" {{ old('lip_type_id') == $lip_type->id ? 'selected' : '' }}>
                                            {{ $lip_type->lip_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lip_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="required-field">Tipo de Orejas:</label>
                                <select class="form-control w-full @error('ear_type_id') border-red-500 @enderror" name="ear_type_id" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($orejas as $ear_type)
                                        <option value="{{ $ear_type->id }}" {{ old('ear_type_id') == $ear_type->id ? 'selected' : '' }}>
                                            {{ $ear_type->ear_type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ear_type_id')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Características Particulares -->
                        <div class="form-group">
                            <label class="required-field">Características Particulares:</label>
                            <textarea class="form-control w-full @error('distinctive_marks') border-red-500 @enderror" 
                                      name="distinctive_marks" 
                                      rows="3"
                                      placeholder="Describa marcas distintivas, tatuajes, cicatrices, etc."
                                      required>{{ old('distinctive_marks') }}</textarea>
                            @error('distinctive_marks')
                                <small class="text-red-400 text-sm">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- FOTOGRAFÍAS - Sección actualizada con cámara -->
                        <div class="section-title" style="margin-top: 20px;">FOTOGRAFÍAS</div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <!-- Rostro -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 required-field">Rostro:</label>
                                <input type="file" 
                                       class="hidden @error('face_photo') border-red-500 @enderror" 
                                       name="face_photo"
                                       id="facePhotoInput" 
                                       onchange="previewImage(this, 'previewFace')"
                                       accept="image/*"
                                       required>
                                <img id="previewFace"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa rostro"
                                     class="preview-image"
                                     onclick="showCameraOptions('facePhotoInput')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('facePhotoInput', 'user')"
                                            title="Usar cámara frontal">
                                        📱 Frontal
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('facePhotoInput')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('face_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Medio Cuerpo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 required-field">Medio Cuerpo:</label>
                                <input type="file" 
                                       class="hidden @error('frontal_photo') border-red-500 @enderror" 
                                       name="frontal_photo"
                                       id="frontal_photo" 
                                       onchange="previewImage(this, 'previewFrontal')"
                                       accept="image/*"
                                       required>
                                <img id="previewFrontal"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa medio cuerpo"
                                     class="preview-image"
                                     onclick="showCameraOptions('frontal_photo')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('frontal_photo', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('frontal_photo')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('frontal_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Perfil Izquierdo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 required-field">Perfil Izquierdo:</label>
                                <input type="file" 
                                       class="hidden @error('profile_izq_photo') border-red-500 @enderror" 
                                       name="profile_izq_photo"
                                       id="profile_izq" 
                                       onchange="previewImage(this, 'previewIzq')"
                                       accept="image/*"
                                       required>
                                <img id="previewIzq"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa perfil izquierdo"
                                     class="preview-image"
                                     onclick="showCameraOptions('profile_izq')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('profile_izq', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('profile_izq')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('profile_izq_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Perfil Derecho -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 required-field">Perfil Derecho:</label>
                                <input type="file" 
                                       class="hidden @error('profile_der_photo') border-red-500 @enderror" 
                                       name="profile_der_photo"
                                       id="profile_der_photo" 
                                       onchange="previewImage(this, 'previewDer')"
                                       accept="image/*"
                                       required>
                                <img id="previewDer"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa perfil derecho"
                                     class="preview-image"
                                     onclick="showCameraOptions('profile_der_photo')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('profile_der_photo', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('profile_der_photo')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('profile_der_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Cuerpo Completo -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2 required-field">Cuerpo Completo:</label>
                                <input type="file" 
                                       class="hidden @error('full_body_photo') border-red-500 @enderror" 
                                       name="full_body_photo"
                                       id="full_body_photo" 
                                       onchange="previewImage(this, 'previewFullBody')"
                                       accept="image/*"
                                       required>
                                <img id="previewFullBody"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa cuerpo completo"
                                     class="preview-image"
                                     onclick="showCameraOptions('full_body_photo')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('full_body_photo', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('full_body_photo')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('full_body_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Foto Adicional -->
                            <div class="image-upload-container">
                                <label class="text-sm font-medium mb-2">Foto Adicional:</label>
                                <input type="file" 
                                       class="hidden @error('aditional_photo') border-red-500 @enderror" 
                                       name="aditional_photo"
                                       id="aditional_photo" 
                                       onchange="previewImage(this, 'previewaditional')"
                                       accept="image/*">
                                <img id="previewaditional"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa foto adicional"
                                     class="preview-image"
                                     onclick="showCameraOptions('aditional_photo')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('aditional_photo', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('aditional_photo')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('aditional_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto en Barra (Ancho completo) -->
                        <div class="form-group mt-6">
                            <label class="text-sm font-medium mb-2 block">Foto en Barra:</label>
                            <div class="image-upload-container barra-photo-container">
                                <input type="file" 
                                       class="hidden @error('barra_photo') border-red-500 @enderror" 
                                       name="barra_photo" 
                                       id="barra_photo"
                                       onchange="previewImage(this, 'previewBarra')"
                                       accept="image/*">
                                <img id="previewBarra"
                                     src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                     alt="Vista previa foto barra"
                                     class="preview-image"
                                     style="width: 200px; height: 100px;"
                                     onclick="showCameraOptions('barra_photo')">
                                
                                <div class="camera-options">
                                    <button type="button" 
                                            class="camera-btn primary" 
                                            onclick="openCamera('barra_photo', 'environment')"
                                            title="Usar cámara trasera">
                                        📷 Cámara
                                    </button>
                                    <button type="button" 
                                            class="camera-btn secondary" 
                                            onclick="openFileSelector('barra_photo')"
                                            title="Seleccionar archivo">
                                        📁 Archivo
                                    </button>
                                </div>
                                
                                @error('barra_photo')
                                    <small class="text-red-400 text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-center space-x-4 mt-8 pt-6 border-t border-gray-600">
                    @can('agregar.criminal')
                        <button class="btn bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2" 
                                type="submit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>GUARDAR</span>
                        </button>
                    @endcan

                    <button class="btn bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center space-x-2" 
                            type="button" 
                            onclick="if(confirm('¿Está seguro de cancelar? Se perderán todos los datos ingresados.')) { history.back(); }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>CANCELAR</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/criminal-form.js') }}"></script>
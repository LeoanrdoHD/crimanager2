@vite('resources/css/app.css')

<div>
    <form class="form-criminal" action="{{ route('criminals.store_arrest4') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        <div class="class text-center"><label>Alias y otras identidades:</label></div>
        <div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label>OTRAS IDENTIDADES</label>
                    <div class="form-group">
                        <label>Otros Nombre:</label>
                        <input type="text" class="form-control" name="alias_name" placeholder="Nombre y Apellidos">
                    </div>
                    <div class="form-group">
                        <label>Otros Numeros de Identidad::</label>
                        <input type="text" class="form-control" name="alias_identity_number"
                            placeholder="Ingresar CI/DNI">
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Otras Nacionalidades</label>
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
                    <br>
                    <div class="form-group">
                        <label>Otros Direcciones de Residencia:</label>
                        <input type="text" class="form-control" name="street" placeholder="Ingresar Direccion">
                    </div>
                    <label>Lugar de recidencia:</label>
                    <div class="grid grid-cols-3 gap-10">
                        <div class="form-group">
                            <label>Pais:</label>
                            <select class="form-control" name="country_id_a">
                                <option value="">Seleccionar</option>
                                @foreach ($pais as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Departamento:</label>
                            <select class="form-control" name="city_id_a">
                                <option value="">Seleccionar</option>
                                @foreach ($ciudad as $city)
                                    <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Municipio:</label>
                            <select class="form-control" name="province_id">
                                <option value="">Seleccionar</option>
                                @foreach ($provincia as $province)
                                    <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">GUARDAR</button>
                </div>
            </div>
        </div>
    </form>
</div>

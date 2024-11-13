@vite('resources/css/app.css')
<div>
    <div class="class text-center"><label>:</label></div>
    <form class="form-criminal" action="{{ route('criminals.store_arrest8') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div class="grid grid-cols-2 gap-10">
            <div>
                <div>
                    <label>Tipo de Pena:</label>
                    <select class="form-control" name="detention_type_id" id="detentionType" onchange="mostrarCampos()">
                        <option value="">Seleccionar</option>
                        @foreach ($tcondena as $detention_type)
                            <option value="{{ $detention_type->id }}">{{ $detention_type->detention_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="camposDetencionPreventiva" style="display: none;">
                    <label>Prisión:</label>
                    <select class="form-control" name="prison_name" id="prisonSelect" onchange="llenarCamposPrision()">
                        <option value="">Seleccionar</option>
                        @foreach ($prision as $prison)
                            <option value="{{ $prison->id }}" data-direccion="{{ $prison->prison_location }}"
                                data-pais="{{ $prison->country_id }}" data-ciudad="{{ $prison->city_id }}"
                                data-provincia="{{ $prison->province_id }}">
                                {{ $prison->prison_name }}
                            </option>
                        @endforeach
                        <option value="otro">Otro</option>
                    </select>

                    <!-- Campos de dirección de la prisión (solo si se selecciona "Otro") -->
                    <div id="camposOtraPrision" style="display: none; margin-top: 10px;">
                        <label>Nombre de la Prisión:</label>
                        <input type="text" class="form-control" name="otra_prision_nombre"
                            placeholder="Nombre de la prisión">
                        <label>Dirección de la Prisión:</label>
                        <input type="text" class="form-control" name="prison_location" placeholder="Dirección">
                        <label>País:</label>
                        <select class="form-control" name="country_id_p">
                            <option value="">Seleccionar</option>
                            @foreach ($pais as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <label>Ciudad:</label>
                        <select class="form-control" name="city_id_p">
                            <option value="">Seleccionar</option>
                            @foreach ($ciudad as $city)
                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                        <label>Provincia:</label>
                        <select class="form-control" name="province_id_p">
                            <option value="">Seleccionar</option>
                            @foreach ($provincia as $province)
                                <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campos para mostrar los detalles de la prisión seleccionada -->
                    <div id="camposPrisionSeleccionada" style="margin-top: 10px;">
                        <label>Dirección de la Prisión:</label>
                        <input type="text" class="form-control" id="prisonLocation" readonly>
                        <label>País:</label>
                        <input type="text" class="form-control" id="country" readonly>
                        <label>Ciudad:</label>
                        <input type="text" class="form-control" id="city" readonly>
                        <label>Provincia:</label>
                        <input type="text" class="form-control" id="province" readonly>
                    </div>

                    <label>Fecha de Ingreso:</label>
                    <input type="date" class="form-control" name="prison_entry_date">
                    <label>Fecha de Salida:</label>
                    <input type="date" class="form-control" name="prison_release_date">
                </div>
                <!-- Campos para Detención Domiciliaria -->
                <div id="camposDetencionDomiciliaria" style="display: none;">
                    <label>Dirección de Detención Domiciliaria:</label>
                    <input type="text" class="form-control" name="house_arrest_address"
                        placeholder="Ingrese una dirección">
                    <label>País:</label>
                    <select class="form-control" name="country_id_h">
                        <option value="">Seleccionar</option>
                        @foreach ($pais as $country)
                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    <label>Ciudad:</label>
                    <select class="form-control" name="city_id_h">
                        <option value="">Seleccionar</option>
                        @foreach ($ciudad as $city)
                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                    <label>Provincia:</label>
                    <select class="form-control" name="province_id_h">
                        <option value="">Seleccionar</option>
                        @foreach ($provincia as $province)
                            <option value="{{ $province->id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campos para Extradición -->
                <div id="camposExtradicion" style="display: none;">
                    <label>Fecha de Extradición:</label>
                    <input type="date" class="form-control" name="extradition_date">
                    <label>País:</label>
                    <select class="form-control" name="country_id_e">
                        <option value="">Seleccionar</option>
                        @foreach ($pais as $country)
                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    <label>Ciudad:</label>
                    <select class="form-control" name="city_id_e">
                        <option value="">Seleccionar</option>
                        @foreach ($ciudad as $city)
                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Campos para Libertad -->
                <div id="camposLibertad" style="display: none;">
                    <label>Dirección:</label>
                    <input type="text" class="form-control" name="house_address"
                        placeholder="Ingrese una dirección">
                    <label>País:</label>
                    <select class="form-control" name="country_id_l">
                        <option value="">Seleccionar</option>
                        @foreach ($pais as $country)
                            <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    <label>Ciudad:</label>
                    <select class="form-control" name="city_id_l">
                        <option value="">Seleccionar</option>
                        @foreach ($ciudad as $city)
                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                        @endforeach
                    </select>
                    <label>Región:</label>
                    <select class="form-control" name="province_id_l">
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
        var select = document.getElementById("prisonSelect");
        var selectedOption = select.options[select.selectedIndex];

        if (selectedOption.value === "otro") {
            document.getElementById("camposOtraPrision").style.display = "block";
            document.getElementById("camposPrisionSeleccionada").style.display = "none";
        } else {
            document.getElementById("camposOtraPrision").style.display = "none";
            document.getElementById("camposPrisionSeleccionada").style.display = "block";

            // Llenar los campos de la prisión seleccionada
            document.getElementById("prisonLocation").value = selectedOption.getAttribute("data-direccion");
            document.getElementById("country").value = selectedOption.getAttribute("data-pais");
            document.getElementById("city").value = selectedOption.getAttribute("data-ciudad");
            document.getElementById("province").value = selectedOption.getAttribute("data-provincia");
        }
    }
    </script>

</div>

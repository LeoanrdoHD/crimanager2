@vite('resources/css/app.css')
<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest5') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div class="text-center mb-6">
            <label class="text-lg font-semibold">Vehículos Usados por el Delincuente</label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
            <!-- Columna: Datos del Vehículo -->
            <div>
                <div class="text-center mb-4">
                    <label class="font-semibold">Datos del Vehículo:</label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="form-group">
                        <label>Color:</label>
                        <select class="form-control" name="vehicle_color_id">
                            <option value="">Seleccionar</option>
                            @foreach ($vcolor as $vehicle_color)
                                <option value="{{ $vehicle_color->id }}">{{ $vehicle_color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Clase:</label>
                        <select class="form-control" name="type_id" id="type_id">
                            <option value="">Seleccionar</option>
                            @foreach ($vtype as $vehicle_type)
                                <option value="{{ $vehicle_type->id }}">{{ $vehicle_type->vehicle_type_name }}</option>
                            @endforeach
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div class="form-group" id="other_vehicle_type_group" style="display: none;">
                        <label>Otro clase de vehículo:</label>
                        <input type="text" class="form-control" name="other_vehicle_type"
                            placeholder="Ingrese otra clase">
                    </div>
                </div>

                <script>
                    document.getElementById('type_id').addEventListener('change', function() {
                        var otherVehicleTypeGroup = document.getElementById('other_vehicle_type_group');
                        if (this.value === 'other') {
                            otherVehicleTypeGroup.style.display = 'block';
                        } else {
                            otherVehicleTypeGroup.style.display = 'none';
                        }
                    });
                </script>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="number" class="form-control" name="year" placeholder="Año" min="1950"
                            max="2124">
                    </div>

                    <div class="form-group">
                        <label>Marca:</label>
                        <select class="form-control" name="brand_id">
                            <option value="">Seleccionar</option>
                            @foreach ($marca as $brand_vehicle)
                                <option value="{{ $brand_vehicle->id }}">{{ $brand_vehicle->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipo:</label>
                        <input type="text" class="form-control" name="model" placeholder="Tipo">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="form-group">
                        <label>Industria:</label>
                        <select class="form-control" name="industry_id">
                            <option value="">Seleccionar</option>
                            @foreach ($industria as $industrie)
                                <option value="{{ $industrie->id }}">{{ $industrie->industry_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Número de Placa:</label>
                        <input type="text" class="form-control" name="license_plate"
                            placeholder="Ingrese Número de Placa">
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label>Tipo de Servicio:</label>
                    <select class="form-control" name="vehicle_service_id">
                        <option value="">Seleccionar</option>
                        @foreach ($servicio as $vehicle_service)
                            <option value="{{ $vehicle_service->id }}">{{ $vehicle_service->service_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-4">
                    <label>Detalles del Vehículo:</label>
                    <input type="text" class="form-control" name="details" placeholder="Descripción de detalles">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <div class="form-group">
                            <label>Foto Frontal: (*)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="front_photo" id="front_photo"
                                    onchange="previewImage(this, 'previewFront')">
                                <label class="custom-file-label" for="front_photo">Seleccionar...</label>
                            </div>
                            <div class="center-image-container">
                                <img id="previewFront"
                                    src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa"
                                    style="width: 100%; max-width: 100px; margin-top: 10px; cursor: pointer;"
                                    onclick="document.getElementById('front_photo').click();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Foto Trasera: (*)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="rear_photo" id="rear_photo"
                                    onchange="previewImage(this, 'previewRear')">
                                <label class="custom-file-label" for="rear_photo">Seleccionar...</label>
                            </div>
                            <div class="center-image-container">
                                <img id="previewRear"
                                    src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa"
                                    style="width: 100%; max-width: 100px; margin-top: 10px; cursor: pointer;"
                                    onclick="document.getElementById('rear_photo').click();">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Foto Lateral Izquierda: (*)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="left_side_photo"
                                    id="left_side_photo" onchange="previewImage(this, 'previewLeftSide')">
                                <label class="custom-file-label" for="left_side_photo">Seleccionar...</label>
                            </div>
                            <div class="center-image-container">
                                <img id="previewLeftSide"
                                    src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa"
                                    style="width: 100%; max-width: 100px; margin-top: 10px; cursor: pointer;"
                                    onclick="document.getElementById('left_side_photo').click();">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Lateral Derecha: (*)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="right_side_photo"
                                    id="right_side_photo" onchange="previewImage(this, 'previewRightSide')">
                                <label class="custom-file-label" for="right_side_photo">Seleccionar...</label>
                            </div>
                            <div class="center-image-container">
                                <img id="previewRightSide"
                                    src="{{ asset('vendor/adminlte/dist/img/Add_Image_icon-icons.png') }}"
                                    alt="Vista previa"
                                    style="width: 100%; max-width: 100px; margin-top: 10px; cursor: pointer;"
                                    onclick="document.getElementById('right_side_photo').click();">
                            </div>
                        </div>
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

            <!-- Columna: Datos de ITV -->
            <div>
                <div class="text-center mb-4">
                    <label class="font-semibold">Datos de ITV:</label>
                </div>

                <div class="form-group">
                    <label>¿El vehículo tiene ITV?</label>
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="itv_valid" value="0">
                        <input type="checkbox" class="custom-control-input" id="itvSwitch" name="itv_valid"
                            value="1" onchange="toggleITVFields()">
                        <label class="custom-control-label" for="itvSwitch">Sí</label>
                    </div>
                </div>

                <div id="itvFields" style="display: none;">
                    <div class="form-group mt-4">
                        <label>Nombre de Usuario ITV:</label>
                        <input type="text" class="form-control" name="user_name" placeholder="Ingrese nombre">
                    </div>

                    <div class="form-group mt-4">
                        <label>CI del Usuario ITV:</label>
                        <input type="text" class="form-control" name="user_ci" placeholder="Ingrese CI">
                    </div>

                    <div class="form-group mt-4">
                        <label>Relación con el delincuente:</label>
                        <select class="form-control" name="relationship_with_owner_id" id="relationshipSelect">
                            <option value="">Seleccionar</option>
                            @foreach ($relusuario as $relationship_with_owner)
                                <option value="{{ $relationship_with_owner->id }}">
                                    {{ $relationship_with_owner->relationship_name }}</option>
                            @endforeach
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div class="form-group mt-4" id="otherRelationshipField" style="display: none;">
                        <label>Especifique la nueva relación:</label>
                        <input type="text" class="form-control" name="other_relationship"
                            placeholder="Ingrese otra relación">
                    </div>

                    <script>
                        document.getElementById('relationshipSelect').addEventListener('change', function() {
                            const otherField = document.getElementById('otherRelationshipField');
                            if (this.value === 'other') {
                                otherField.style.display = 'block';
                            } else {
                                otherField.style.display = 'none';
                            }
                        });
                    </script>

                    <div class="form-group mt-4">
                        <label>Otras Observaciones:</label>
                        <input type="text" class="form-control" name="observations"
                            placeholder="Ingrese observaciones">
                    </div>

                    <div class="form-group mt-4">
                        <label>Nombre del Conductor:</label>
                        <input type="text" class="form-control" name="driver_name"
                            placeholder="Ingrese nombre del conductor">
                    </div>
                </div>

                <script>
                    function toggleITVFields() {
                        var itvSwitch = document.getElementById("itvSwitch");
                        var itvFields = document.getElementById("itvFields");
                        if (itvSwitch.checked) {
                            itvFields.style.display = "block";
                        } else {
                            itvFields.style.display = "none";
                        }
                    }
                </script>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="text-center mt-6">
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>
</div>

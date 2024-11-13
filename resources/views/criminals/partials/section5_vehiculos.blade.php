@vite('resources/css/app.css')
<div>
    <form class="form-criminal" action="{{ route('criminals.store_arrest5') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        <div class="class text-center"><label>Vehiculos Usados por el Delincuente</label></div>
        <div class="grid grid-cols-2 gap-10">
            <div>
                <div class="class text-center"><label>Datos del Vehiculo:</label></div>
                <div class="grid grid-cols-3 gap-10">
                    <div class="form-group">
                        <label for="inputAddress2">Color</label>
                        <select class="form-control" name="vehicle_color_id">
                            <option value="">Seleccionar</option>
                            @foreach ($vcolor as $vehicle_color)
                                <option value="{{ $vehicle_color->id }}">{{ $vehicle_color->color_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Vehículo:</label>
                        <select class="form-control" name="type_id" id="type_id">
                            <option value="">Seleccionar</option>
                            @foreach ($vtype as $vehicle_type)
                                <option value="{{ $vehicle_type->id }}">{{ $vehicle_type->vehicle_type_name }}</option>
                            @endforeach
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="other_vehicle_type_group" style="display: none;">
                        <label>Otro tipo de vehículo:</label>
                        <input type="text" class="form-control" name="other_vehicle_type" placeholder="Ingrese otro tipo">
                    </div>
                    <script>
                        document.getElementById('type_id').addEventListener('change', function () {
                            var otherVehicleTypeGroup = document.getElementById('other_vehicle_type_group');
                            if (this.value === 'other') {
                                otherVehicleTypeGroup.style.display = 'block';
                            } else {
                                otherVehicleTypeGroup.style.display = 'none';
                            }
                        });
                    </script>
                    <div class="form-group">
                        <label>Año de Fabricacion:</label>
                        <input type="number" class="form-control" name="year" placeholder="Año" min="1950"
                            max="2124">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-10">
                    <div class="form-group">
                        <label for="inputAddress2">Marca</label>
                        <select class="form-control" name="brand_id">
                            <option value="">Seleccionar</option>
                            @foreach ($marca as $brand_vehicle)
                                <option value="{{ $brand_vehicle->id }}">{{ $brand_vehicle->brand_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Modelo</label>
                        <input type="text" class="form-control" name="model" placeholder="Modelo">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-10">
                    <div class="form-group">
                        <label for="inputAddress2">Industria</label>
                        <select class="form-control" name="industry_id">
                            <option value="">Seleccionar</option>
                            @foreach ($industria as $industrie)
                                <option value="{{ $industrie->id }}">{{ $industrie->industry_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Numero de Placa:</label>
                        <input type="text" class="form-control" name="license_plate"
                            placeholder="Ingrese Numero de PLanca">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-10">
                    <div class="form-group">
                        <label for="inputAddress2">Tipo de servicio:</label>
                        <select class="form-control" name="vehicle_service_id">
                            <option value="">Seleccionar</option>
                            @foreach ($servicio as $vehicle_service)
                                <option value="{{ $vehicle_service->id }}">{{ $vehicle_service->service_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Detalles del Vehiculo:</label>
                    <input type="text" class="form-control" name="details" placeholder="Descripccion de detalles">
                </div>
            </div>

            <div>
                <div class="text-center"><label>Datos de ITV:</label></div>
                
                <div class="form-group">
                    <label for="itvSwitch">¿El vehículo tiene ITV?</label>
                    <div class="custom-control custom-switch">
                        <!-- Campo oculto para enviar 0 si el switch está apagado -->
                        <input type="hidden" name="itv_valid" value="0">
                        
                        <!-- Switch que envía 1 si está activado -->
                        <input type="checkbox" class="custom-control-input" id="itvSwitch" name="itv_valid" value="1" onchange="toggleITVFields()">
                        <label class="custom-control-label" for="itvSwitch">Sí</label>
                    </div>
                </div>
            
                <div id="itvFields" style="display: none;">
                    <div class="form-group">
                        <label for="inputAddress">Nombre de Usuario ITV:</label>
                        <input type="text" class="form-control" name="user_name" placeholder="Descripción de detalles">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress">CI del Usuario ITV:</label>
                        <input type="text" class="form-control" name="user_ci" placeholder="Descripción de detalles">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Relación con el delincuente:</label>
                        <select class="form-control" name="relationship_with_owner_id" id="relationshipSelect">
                            <option value="">Seleccionar</option>
                            @foreach ($relusuario as $relationship_with_owner)
                                <option value="{{ $relationship_with_owner->id }}">{{ $relationship_with_owner->relationship_name }}</option>
                            @endforeach
                            <option value="other">Otro</option> <!-- Opción para 'Otro' -->
                        </select>
                    </div>
                    
                    <!-- Campo de entrada para 'Otro', oculto por defecto -->
                    <div class="form-group" id="otherRelationshipField" style="display: none;">
                        <label for="other_relationship">Especifique la nueva relación:</label>
                        <input type="text" class="form-control" name="other_relationship" placeholder="Ingrese otra relación">
                    </div>
                    
                    <script>
                        // Mostrar el campo de entrada cuando se seleccione la opción 'Otro'
                        document.getElementById('relationshipSelect').addEventListener('change', function () {
                            const otherField = document.getElementById('otherRelationshipField');
                            if (this.value === 'other') {
                                otherField.style.display = 'block';
                            } else {
                                otherField.style.display = 'none';
                            }
                        });
                    </script>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Otras Observaciones</label>
                        <input type="text" class="form-control" name="observations" placeholder="Descripción">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputAddress2">Nombre del Conductor:</label>
                        <input type="text" class="form-control" name="driver_name" placeholder="Descripción">
                    </div>
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
        
            
            <div>
                <button class="btn btn-primary" type="submit">GUARDAR</button>
            </div>
    </form>
</div>

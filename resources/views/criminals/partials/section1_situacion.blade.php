@vite('resources/css/app.css')
<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        
        
        <div class="class text-center text-lg">Datos de Detención:</div>
        <div><label>Llenar los siguientes datos:</label></div>
        <div class="grid grid-cols-2 gap-10">
            <div>
                <div class="form-group">
                    <label>Tipo de Registro:</label>
                    <select class="form-control" name="legal_status_id" id="legalStatusSelect">
                        <option value="">Seleccionar</option>
                        @foreach ($lstatus as $legal_statuses)
                            <option value="{{ $legal_statuses->id }}">{{ $legal_statuses->status_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Campo de Tipo de Detención, inicialmente oculto -->
                <div id="apprehensionTypeDiv" class="form-group" style="display: none;">
                    <label>Situacion Legal:</label>
                    <select class="form-control" name="apprehension_type_id">
                        <option value="">Seleccionar</option>
                        @foreach ($t_aprehe as $apprehension_types)
                            <option value="{{ $apprehension_types->id }}">{{ $apprehension_types->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Campo de Número de CUD, inicialmente oculto -->
                <div id="cudNumberDiv" class="form-group" style="display: none;">
                    <label>Numero de CUD:</label>
                    <input type="text" class="form-control" name="cud_number" placeholder="Ingrese EL CUD">
                </div>
    
                <!-- Campo de Fecha de Captura -->
                <div id="arrestDateDiv" class="form-group">
                    <label>Fecha de Captura:</label>
                    <input type="date" class="form-control" name="arrest_date" placeholder="dia/mes/año">
                </div>
            </div>
            
            <div>
                <!-- Campo de Hora de Captura -->
                <div id="arrestTimeDiv" class="form-group">
                    <label>Hora de Captura:</label>
                    <input type="time" class="form-control" name="arrest_time" placeholder="dia/mes/año">
                </div>
                
                <!-- Campo de Lugar de Captura -->
                <div id="arrestLocationDiv" class="form-group">
                    <label>Lugar de Captura:</label>
                    <input type="text" class="form-control" name="arrest_location" placeholder="Ingrese la Direccion">
                </div>
                
                <!-- Campo de Detalle de la Captura -->
                <div id="arrestDetailsDiv" class="form-group">
                    <label>Detalle de la Captura:</label>
                    <input type="text" class="form-control" name="arrest_details" placeholder="Breve descripción">
                </div>
                
                <div class="form-group">
                    <label>Especialidad/Motivo de captura</label>
                    <select class="form-control" name="criminal_specialty_id" id="criminalSpecialtySelect">
                        <option value="">Seleccionar</option>
                        @foreach ($cri_esp as $criminal_specialties)
                            <option value="{{ $criminal_specialties->id }}">{{ $criminal_specialties->specialty_name }}</option>
                        @endforeach
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <!-- Campo de entrada para nueva especialidad, inicialmente oculto -->
                <div class="form-group" id="otherSpecialtyDiv" style="display: none;">
                    <label>Ingrese Nueva Especialidad/Motivo de Captura</label>
                    <input type="text" class="form-control" name="otra_especialidad" placeholder="Especifique la especialidad">
                </div>
                <script>
                    document.getElementById('criminalSpecialtySelect').addEventListener('change', function() {
                        const otherSpecialtyDiv = document.getElementById('otherSpecialtyDiv');
                        if (this.value === 'otro') {
                            otherSpecialtyDiv.style.display = 'block';
                        } else {
                            otherSpecialtyDiv.style.display = 'none';
                        }
                    });
                </script>
            </div>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>
    
    <script>
        document.getElementById('legalStatusSelect').addEventListener('change', function() {
            const selectedValue = this.value;
            
            // Select elements to show or hide
            const apprehensionTypeDiv = document.getElementById('apprehensionTypeDiv');
            const cudNumberDiv = document.getElementById('cudNumberDiv');
            
            // Fields to hide when "En Captura" is selected
            const arrestDateDiv = document.getElementById('arrestDateDiv');
            const arrestTimeDiv = document.getElementById('arrestTimeDiv');
            const arrestLocationDiv = document.getElementById('arrestLocationDiv');
            const arrestDetailsDiv = document.getElementById('arrestDetailsDiv');
    
            if (selectedValue === '2') { // Aprehendido
                apprehensionTypeDiv.style.display = 'block';
                cudNumberDiv.style.display = 'block';
                arrestDateDiv.style.display = 'block';
                arrestTimeDiv.style.display = 'block';
                arrestLocationDiv.style.display = 'block';
                arrestDetailsDiv.style.display = 'block';
            } else if (selectedValue === '3') { // En Captura
                apprehensionTypeDiv.style.display = 'block';
                cudNumberDiv.style.display = 'block';
                arrestDateDiv.style.display = 'none';
                arrestTimeDiv.style.display = 'none';
                arrestLocationDiv.style.display = 'none';
                arrestDetailsDiv.style.display = 'none';
            } else { // Otras opciones
                apprehensionTypeDiv.style.display = 'none';
                cudNumberDiv.style.display = 'none';
                arrestDateDiv.style.display = 'block';
                arrestTimeDiv.style.display = 'block';
                arrestLocationDiv.style.display = 'block';
                arrestDetailsDiv.style.display = 'block';
            }
        });
    </script>
    
    
</div>

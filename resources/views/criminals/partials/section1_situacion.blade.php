@vite('resources/css/app.css')
<div class="grid grid-cols-1 sm:grid-cols-1 gap-10">
    <form class="ajax-form" action="{{ route('criminals.store_arrest') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div>
            <div class="text-center text-lg">Datos de Detención:</div>
            <label>Llenar los siguientes datos:</label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
            <!-- Primera columna -->
            <div>
                <div class="form-group">
                    <label>Tipo de Registro:</label>
                    <select class="form-control w-full" name="legal_status_id" id="legalStatusSelect">
                        <option value="">Seleccionar</option>
                        @foreach ($lstatus as $legal_statuses)
                            <option value="{{ $legal_statuses->id }}">{{ $legal_statuses->status_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="apprehensionTypeDiv" class="form-group" style="display: none;">
                    <label>Situación Legal:</label>
                    <select class="form-control w-full" name="apprehension_type_id">
                        <option value="">Seleccionar</option>
                        @foreach ($t_aprehe as $apprehension_types)
                            <option value="{{ $apprehension_types->id }}">{{ $apprehension_types->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="cudNumberDiv" class="form-group" style="display: none;">
                    <label>Número de CUD:</label>
                    <input type="text" class="form-control w-full" name="cud_number" placeholder="Ingrese EL CUD">
                </div>

                <div id="arrestDateDiv" class="form-group">
                    <label>Fecha de Captura:</label>
                    <input type="date" class="form-control w-full" name="arrest_date" placeholder="día/mes/año">
                </div>
            </div>

            <!-- Segunda columna -->
            <div>
                <div id="arrestTimeDiv" class="form-group">
                    <label>Hora de Captura:</label>
                    <input type="time" class="form-control w-full" name="arrest_time" placeholder="hh:mm">
                </div>

                <div id="arrestLocationDiv" class="form-group">
                    <label>Lugar de Captura:</label>
                    <input type="text" class="form-control w-full" name="arrest_location"
                        placeholder="Ingrese la Dirección">
                </div>
            </div>

            <div>
                <div id="arrestDetailsDiv" class="form-group">
                    <label>Detalle de la Captura:</label>
                    <input type="text" class="form-control w-full" name="arrest_details"
                        placeholder="Breve descripción">
                </div>

                <div class="form-group">
                    <label>Especialidad/Motivo de Captura</label>
                    <select class="form-control w-full" name="criminal_specialty_id" id="criminalSpecialtySelect">
                        <option value="">Seleccionar</option>
                        @foreach ($cri_esp as $criminal_specialties)
                            <option value="{{ $criminal_specialties->id }}">{{ $criminal_specialties->specialty_name }}
                            </option>
                        @endforeach
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div id="otherSpecialtyDiv" class="form-group" style="display: none;">
                    <label>Ingrese Nueva Especialidad/Motivo de Captura:</label>
                    <input type="text" class="form-control w-full" name="otra_especialidad"
                        placeholder="Especifique la especialidad">
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>
</div>

<script>
    // Mostrar u ocultar campos basados en la selección del tipo de registro
    document.getElementById('legalStatusSelect').addEventListener('change', function() {
        const selectedValue = this.value;
        const apprehensionTypeDiv = document.getElementById('apprehensionTypeDiv');
        const cudNumberDiv = document.getElementById('cudNumberDiv');
        const arrestDateDiv = document.getElementById('arrestDateDiv');
        const arrestTimeDiv = document.getElementById('arrestTimeDiv');
        const arrestLocationDiv = document.getElementById('arrestLocationDiv');
        const arrestDetailsDiv = document.getElementById('arrestDetailsDiv');

        if (selectedValue === '2') {
            apprehensionTypeDiv.style.display = 'block';
            cudNumberDiv.style.display = 'block';
            arrestDateDiv.style.display = 'block';
            arrestTimeDiv.style.display = 'block';
            arrestLocationDiv.style.display = 'block';
            arrestDetailsDiv.style.display = 'block';
        } else if (selectedValue === '3') {
            apprehensionTypeDiv.style.display = 'block';
            cudNumberDiv.style.display = 'block';
            arrestDateDiv.style.display = 'none';
            arrestTimeDiv.style.display = 'none';
            arrestLocationDiv.style.display = 'none';
            arrestDetailsDiv.style.display = 'none';
        } else {
            apprehensionTypeDiv.style.display = 'none';
            cudNumberDiv.style.display = 'none';
            arrestDateDiv.style.display = 'block';
            arrestTimeDiv.style.display = 'block';
            arrestLocationDiv.style.display = 'block';
            arrestDetailsDiv.style.display = 'block';
        }
    });

    // Mostrar el campo "Otra especialidad" cuando se selecciona "Otro"
    document.getElementById('criminalSpecialtySelect').addEventListener('change', function() {
        const otherSpecialtyDiv = document.getElementById('otherSpecialtyDiv');
        if (this.value === 'otro') {
            otherSpecialtyDiv.style.display = 'block';
        } else {
            otherSpecialtyDiv.style.display = 'none';
        }
    });
</script>

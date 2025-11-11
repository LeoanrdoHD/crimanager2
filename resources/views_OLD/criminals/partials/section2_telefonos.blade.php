@vite('resources/css/app.css')
<div>
    <div class="container">
        <div class="text-center mb-4">
            <label class="text-lg font-semibold">Teléfonos Usados por el Delincuente:</label>
        </div>
        <div>
            <form class="ajax-form" action="{{ route('criminals.store_arrest2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

                <div id="phone-fields-container">
                    <!-- Grupo inicial de campos -->
                    <div class="phone-fields grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label>Número de Celular:</label>
                            <input type="text" class="form-control w-full" name="phone_number[]" placeholder="Ingrese el número de celular">
                        </div>
                        <div class="form-group">
                            <label>Compañía Telefónica:</label>
                            <select class="form-control w-full" name="company_id[]">
                                <option value="">Seleccionar...</option>
                                @foreach ($compania as $company)
                                    <option value="{{ $company->id }}">{{ $company->companies_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Número de IMEI:</label>
                            <input type="text" class="form-control w-full" name="imei_number[]" placeholder="Ingrese el número de IMEI">
                        </div>
                    </div>
                </div>

                <!-- Botón para agregar más campos -->
                <div class="mt-4 flex justify-center sm:justify-start">
                    <button type="button" class="btn btn-secondary" onclick="addPhoneFields()">Agregar Otro</button>
                </div>

                <!-- Botón para enviar el formulario -->
                <div class="mt-6 flex justify-center sm:justify-start">
                    <button class="btn btn-primary" type="submit">GUARDAR</button>
                </div>
            </form>

            <!-- Script para agregar más campos -->
            <script>
                function addPhoneFields() {
                    const container = document.getElementById('phone-fields-container');
                    const newFields = document.createElement('div');
                    newFields.className = 'phone-fields grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4';
                    newFields.innerHTML = `
                        <div class="form-group">
                            <label>Número de Celular:</label>
                            <input type="text" class="form-control w-full" name="phone_number[]" placeholder="Ingrese el número de celular">
                        </div>
                        <div class="form-group">
                            <label>Compañía Telefónica:</label>
                            <select class="form-control w-full" name="company_id[]">
                                <option value="">Seleccionar...</option>
                                @foreach ($compania as $company)
                                    <option value="{{ $company->id }}">{{ $company->companies_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Número de IMEI:</label>
                            <input type="text" class="form-control w-full" name="imei_number[]" placeholder="Ingrese el número de IMEI">
                        </div>
                    `;
                    container.appendChild(newFields);
                }
            </script>
        </div>
    </div>
</div>

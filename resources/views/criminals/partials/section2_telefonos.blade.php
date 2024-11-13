@vite('resources/css/app.css')
<div>
    <div class="container">
        <div class="class text-center"><label>Telefonos Usados por el delincuente:</label></div>
        <div>
            <form class="form-criminal" action="{{ route('criminals.store_arrest2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
            
                <div id="phone-fields-container">
                    <div class="phone-fields grid grid-cols-3 gap-10">
                        <div class="form-group">
                            <label>Numero de Celular:</label>
                            <input type="text" class="form-control" name="phone_number[]" placeholder="Ingrese el numero de celular">
                        </div>
                        <div class="form-group">
                            <label>Compañia Telefonica</label>
                            <select class="form-control" name="company_id[]">
                                <option value="">Seleccionar...</option>
                                @foreach ($compania as $company)
                                    <option value="{{ $company->id }}">{{ $company->companies_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Numero de IMEI:</label>
                            <input type="text" class="form-control" name="imei_number[]" placeholder="Ingrese el numero de IMEI">
                        </div>
                    </div>
                </div>
            
                <div class="mt-3">
                    <button type="button" class="btn btn-secondary" onclick="addPhoneFields()">Agregar Otro</button>
                </div>
            
                <div class="mt-4">
                    <button class="btn btn-primary" type="submit">GUARDAR</button>
                </div>
            </form>
            
            <script>
                function addPhoneFields() {
                    const container = document.getElementById('phone-fields-container');
                    const newFields = document.createElement('div');
                    newFields.className = 'phone-fields grid grid-cols-3 gap-10 mt-4';
                    newFields.innerHTML = `
                        <div class="form-group">
                            <label>Numero de Celular:</label>
                            <input type="text" class="form-control" name="phone_number[]" placeholder="Ingrese el numero de celular">
                        </div>
                        <div class="form-group">
                            <label>Compañia Telefonica</label>
                            <select class="form-control" name="company_id[]">
                                <option value="">Seleccionar...</option>
                                @foreach ($compania as $company)
                                    <option value="{{ $company->id }}">{{ $company->companies_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Numero de IMEI:</label>
                            <input type="text" class="form-control" name="imei_number[]" placeholder="Ingrese el numero de IMEI">
                        </div>
                    `;
                    container.appendChild(newFields);
                }
            </script>
        </div>
    </div>
</div>

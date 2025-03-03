@vite('resources/css/app.css')

<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest6') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div class="class text-center">
            <label>Complices del Delincuente:</label>
        </div>

        <div id="complice-fields-container">
            <!-- Grupo inicial de campos para cómplices -->
            <div class="complice-fields grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="form-group">
                    <label for="inputnames">Nombre y Apellido:</label>
                    <input type="text" class="form-control w-full" name="complice_name[]" placeholder="Ingresar Nombre y Apellido">
                </div>

                <div class="form-group">
                    <label for="inputAddress2">CI/DNI del Cómplice:</label>
                    <input type="text" class="form-control w-full" name="CI_complice[]" placeholder="Ingrese CI/DNI">
                </div>

                <div class="form-group">
                    <label for="inputAddress2">Otros Detalles:</label>
                    <input type="text" class="form-control w-full" name="detail_complice[]" placeholder="Ingresar Breve Descripción">
                </div>
            </div>
        </div>

        <!-- Botón para agregar más campos -->
        <div class="mt-4 flex justify-center sm:justify-start">
            <button type="button" class="btn btn-secondary" onclick="addCompliceFields()">Agregar Otro Cómplice</button>
        </div>

        <!-- Botón para enviar el formulario -->
        <div class="text-center mt-4">
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>
</div>

<!-- Script para agregar más campos -->
<script>
    function addCompliceFields() {
        const container = document.getElementById('complice-fields-container');
        const newFields = document.createElement('div');
        newFields.className = 'complice-fields grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-4';
        newFields.innerHTML = `
            <div class="form-group">
                <label for="inputnames">Nombre y Apellido:</label>
                <input type="text" class="form-control w-full" name="complice_name[]" placeholder="Ingresar Nombre y Apellido">
            </div>

            <div class="form-group">
                <label for="inputAddress2">CI/DNI del Cómplice:</label>
                <input type="text" class="form-control w-full" name="CI_complice[]" placeholder="Ingrese CI/DNI">
            </div>

            <div class="form-group">
                <label for="inputAddress2">Otros Detalles:</label>
                <input type="text" class="form-control w-full" name="detail_complice[]" placeholder="Ingresar Breve Descripción">
            </div>
        `;
        container.appendChild(newFields);
    }
</script>

@vite('resources/css/app.css')

<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest3') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">

        <div class="class text-center">
            <label>Objetos, Herramientas y Armas Usados:</label>
        </div>

        <!-- Contenedor para las herramientas -->
        <div id="tools-container">
            <div class="tool-entry">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div class="form-group">
                        <label>Tipo:</label>
                        <select class="form-control w-full" name="tool_type_id[]" id="tool_type_select">
                            <option value="">Seleccionar</option>
                            @foreach ($arma as $tools_type)
                                <option value="{{ $tools_type->id }}">{{ $tools_type->tool_type_name }}</option>
                            @endforeach
                            <option value="other">Otro</option>
                        </select>
                    </div>

                    <div class="form-group" id="other_tool_type_div" style="display: none;">
                        <label>Especificar otro tipo:</label>
                        <input type="text" class="form-control w-full" name="other_tool_type[]" placeholder="Ingrese nuevo tipo de herramienta">
                    </div>

                    <div class="form-group">
                        <label>Detalles del Objeto, Arma o Herramienta:</label>
                        <input type="text" class="form-control w-full" name="tool_details[]" placeholder="Describir el arma, objeto o herramienta">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para añadir más entradas -->
        <button type="button" class="btn btn-secondary mt-4" id="add-more-tools">Añadir otro</button>

        <div class="text-center mt-4">
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>

    <!-- Script para manejar la opción "Otro" y añadir nuevas herramientas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toolsContainer = document.getElementById('tools-container');
            const addMoreToolsButton = document.getElementById('add-more-tools');

            // Función para añadir una nueva entrada de herramienta
            addMoreToolsButton.addEventListener('click', function() {
                const newToolEntry = toolsContainer.querySelector('.tool-entry').cloneNode(true);
                toolsContainer.appendChild(newToolEntry);

                // Actualizar eventos para el campo select de la nueva entrada
                updateToolSelectEvents();
            });

            // Función para manejar la opción "Otro" en cada select de tipo de herramienta
            function updateToolSelectEvents() {
                const toolTypeSelects = document.querySelectorAll('#tool_type_select');
                toolTypeSelects.forEach((select) => {
                    const otherToolTypeDiv = select.closest('.tool-entry').querySelector('#other_tool_type_div');

                    select.addEventListener('change', function() {
                        if (select.value === 'other') {
                            otherToolTypeDiv.style.display = 'block';
                        } else {
                            otherToolTypeDiv.style.display = 'none';
                        }
                    });
                });
            }

            // Llamar la función para inicializar eventos al cargar la página
            updateToolSelectEvents();
        });
    </script>

</div>

@vite('resources/css/app.css')
<div>
    <form class="ajax-form" action="{{ route('criminals.store_arrest7') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="criminal_id" value="{{ $criminal->id }}">
        <div class="class text-center"><label>Organizaciones Criminales a las que Pertenece:</label></div>
        <div class="grid grid-cols-3 gap-5">
            <div class="form-group">
                <label for="inputnames">Nombre de la Organización:</label>
                <select class="form-control" name="organization_id" id="organizationSelect"
                    onchange="toggleOtherInput()">
                    <option value="">Seleccionar</option>
                    @foreach ($orga as $organization)
                        <option value="{{ $organization->id }}" data-specialty="{{ $organization->Criminal_Organization_Specialty }}">
                            {{ $organization->organization_name }}
                        </option>
                    @endforeach
                    <option value="other">Otro</option>
                </select>
            </div>

            <!-- Campo de entrada para una nueva organización -->
            <div id="otherOrganizationField" style="display: none; margin-top: 10px;">
                <label for="otherOrganization">Ingrese el nombre de la nueva organización:</label>
                <input type="text" class="form-control" id="otherOrganization" name="other_organization"
                    placeholder="Nombre de la organización">
            </div>

            <div class="form-group">
                <label for="inputAddress2">Actividad ilícita principal:</label>
                <input type="text" class="form-control" id="specialtyInput" name="Criminal_Organization_Specialty"
                    placeholder="Que rol cumple">
            </div>

            <div class="form-group">
                <label for="inputAddress2">Rol en la Organización:</label>
                <input type="text" class="form-control" name="criminal_rol" placeholder="Que rol cumple">
            </div>
        </div>

        <div>
            <button class="btn btn-primary" type="submit">GUARDAR</button>
        </div>
    </form>

    <script>
        function toggleOtherInput() {
            const select = document.getElementById("organizationSelect");
            const otherField = document.getElementById("otherOrganizationField");
            const specialtyInput = document.getElementById("specialtyInput");

            // Mostrar el campo de entrada si se selecciona "Otro"
            if (select.value === "other") {
                otherField.style.display = "block";
                specialtyInput.value = ""; // Vaciar el campo si se elige "Otro"
                specialtyInput.placeholder = "Ingrese la actividad ilícita";
            } else {
                otherField.style.display = "none";
                document.getElementById("otherOrganization").value =
                ""; // Limpiar el campo de entrada si se elige otra opción

                // Obtener la especialidad de la organización seleccionada
                const selectedOption = select.options[select.selectedIndex];
                const specialty = selectedOption.getAttribute("data-specialty");

                // Actualizar el campo de especialidad
                specialtyInput.value = specialty || ""; // Si no hay especialidad, deja el campo vacío
            }
        }
    </script>

</div>

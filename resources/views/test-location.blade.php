<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Selectores Dinámicos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Lugar de Nacimiento</h2>
    <div class="form-group">
        <label>País:</label>
        <select class="form-control" id="country">
            <option value="">Seleccionar</option>
        </select>
    </div>
    <div class="form-group">
        <label>Estado:</label>
        <select class="form-control" id="state">
            <option value="">Seleccionar</option>
        </select>
    </div>
    <div class="form-group">
        <label>Ciudad:</label>
        <select class="form-control" id="city">
            <option value="">Seleccionar</option>
        </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Obtener los países al cargar la página
        $.ajax({
            url: 'http://127.0.0.1:8000/countries', // Ruta del controlador
            method: 'GET',
            success: function (response) {
                let countries = response;
                let countrySelect = $('#country');
                countrySelect.empty();
                countrySelect.append('<option value="">Seleccionar</option>');

                countries.forEach(function (country) {
                    countrySelect.append('<option value="' + country.country_name + '">' + country.country_name + '</option>');
                });
            },
            error: function (error) {
                console.error("Error al obtener los países:", error);
            }
        });

        // Obtener los estados cuando se selecciona un país
        $('#country').change(function () {
            let countryName = $(this).val();
            if (countryName) {
                $.ajax({
                    url: 'http://127.0.0.1:8000/states/' + encodeURIComponent(countryName),
                    method: 'GET',
                    success: function (response) {
                        let states = response;
                        let stateSelect = $('#state');
                        stateSelect.empty();
                        stateSelect.append('<option value="">Seleccionar</option>');

                        states.forEach(function (state) {
                            stateSelect.append('<option value="' + state.state_name + '">' + state.state_name + '</option>');
                        });
                    },
                    error: function (error) {
                        console.error("Error al obtener los estados:", error);
                    }
                });
            } else {
                $('#state').empty().append('<option value="">Seleccionar</option>');
                $('#city').empty().append('<option value="">Seleccionar</option>');
            }
        });

        // Obtener las ciudades cuando se selecciona un estado
        $('#state').change(function () {
            let stateName = $(this).val();
            if (stateName) {
                $.ajax({
                    url: 'http://127.0.0.1:8000/cities/' + encodeURIComponent(stateName),
                    method: 'GET',
                    success: function (response) {
                        let cities = response;
                        let citySelect = $('#city');
                        citySelect.empty();
                        citySelect.append('<option value="">Seleccionar</option>');

                        cities.forEach(function (city) {
                            citySelect.append('<option value="' + city.city_name + '">' + city.city_name + '</option>');
                        });
                    },
                    error: function (error) {
                        console.error("Error al obtener las ciudades:", error);
                    }
                });
            } else {
                $('#city').empty().append('<option value="">Seleccionar</option>');
            }
        });
    });
</script>

</body>
</html>

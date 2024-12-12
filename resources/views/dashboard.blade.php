@extends('adminlte::page')

@section('content_header')
    <h1 class="class text-center">Estadisticas del Sistema</h1>
@stop

@section('content')
    <!-- Gráficos de Usuarios -->
    <h3 class="class">Estadistica de Usuarios</h3>
    <div class="row">
        <!-- Gráfico de Usuarios Registrados por Mes -->
        <div class="col-md-5 col-sm-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white">Usuarios Registrados por Mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="userMonthlyChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Usuarios por Rol -->
        <div class="col-md-4 col-sm-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white">Usuarios por Rol</h3>
                </div>
                <div class="card-body">
                    <canvas id="userRolesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <h3 class="class">Estadistica de Delincuentes</h3>
    <!-- Gráficos de Criminales -->
    <div class="row">
        <!-- Gráfico de Criminales Registrados por Año -->
        <div class="col-md-5 col-sm-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white">Criminales Registrados por Año</h3>
                </div>
                <div class="card-body">
                    <canvas id="criminalYearlyChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Criminales por Tipo de Delito -->
        <div class="col-md-4 col-sm-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-white">Criminales por Tipo de Delito</h3>
                </div>
                <div class="card-body">
                    <canvas id="criminalTypesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Asegúrate de que Chart.js esté cargado -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Datos Ficticios

        // Usuarios Registrados por Mes (12 meses)
        var userMonthlyData = [10, 12, 15, 14, 18, 22, 24, 26, 20, 18, 19, 20];

        // Distribución de Usuarios por Rol
        var userRoles = [40, 30, 50]; // Admin, Editor, Usuario

        // Criminales Registrados por Año (7 años)
        var criminalYearlyData = [5, 7, 10, 8, 15, 12, 13];

        // Distribución de Criminales por Tipo de Delito
        var criminalTypes = [20, 30, 15, 15]; // Robo, Asesinato, Violación, Fraude

        // Gráfico de Usuarios Registrados por Mes
        var ctx1 = document.getElementById('userMonthlyChart').getContext('2d');
        var userMonthlyChart = new Chart(ctx1, {
            type: 'line',  // Gráfico de líneas
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                datasets: [{
                    label: 'Usuarios Registrados',
                    data: userMonthlyData,  // Usar los datos mensuales de usuarios
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Cambiar color de las leyendas
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white' // Cambiar color de las etiquetas del eje Y
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white' // Cambiar color de las etiquetas del eje X
                        }
                    }
                }
            }
        });

        // Gráfico de Usuarios por Rol
        var ctx2 = document.getElementById('userRolesChart').getContext('2d');
        var userRolesChart = new Chart(ctx2, {
            type: 'pie',  // Gráfico circular
            data: {
                labels: ['Administrador', 'Editor', 'Usuario'],
                datasets: [{
                    label: 'Usuarios por Rol',
                    data: userRoles,  // Usar la distribución por rol de usuarios
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Cambiar color de las leyendas
                        }
                    }
                }
            }
        });

        // Gráfico de Criminales Registrados por Año
        var ctx3 = document.getElementById('criminalYearlyChart').getContext('2d');
        var criminalYearlyChart = new Chart(ctx3, {
            type: 'bar',  // Gráfico de barras
            data: {
                labels: ['2018', '2019', '2020', '2021', '2022', '2023', '2024'],
                datasets: [{
                    label: 'Criminales Registrados',
                    data: criminalYearlyData,  // Usar los datos anuales de criminales
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Cambiar color de las leyendas
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white' // Cambiar color de las etiquetas del eje Y
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white' // Cambiar color de las etiquetas del eje X
                        }
                    }
                }
            }
        });

        // Gráfico de Criminales por Tipo de Delito
        var ctx4 = document.getElementById('criminalTypesChart').getContext('2d');
        var criminalTypesChart = new Chart(ctx4, {
            type: 'pie',  // Gráfico circular
            data: {
                labels: ['Robo', 'Asesinato', 'Violación', 'Fraude'],
                datasets: [{
                    label: 'Tipos de Delitos',
                    data: criminalTypes,  // Usar la distribución por tipo de delito
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FFCC00']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Cambiar color de las leyendas
                        }
                    }
                }
            }
        });
    </script>
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stop


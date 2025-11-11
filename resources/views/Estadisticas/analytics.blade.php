@extends('adminlte::page')

@section('title', 'Dashboard Analítico Criminal')

@section('content')
    <div class="container-fluid px-4">
        {{-- Header con métricas principales --}}
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><i class="fas fa-chart-bar me-2 text-primary"></i>Dashboard Analítico Criminal</h1>
        </div>

        {{-- Métricas principales --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Total Criminales</div>
                                <div class="text-lg fw-bold">{{ $crimi->count() }}</div>
                            </div>
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">Con Historial</div>
                                <div class="text-lg fw-bold">{{ $history_cri->pluck('criminal_id')->unique()->count() }}
                                </div>
                            </div>
                            <i class="fas fa-history fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">En Libertad</div>
                                <div class="text-lg fw-bold">
                                    {{ $history_cri->where('legalStatus.status_name', 'Libre')->count() }}</div>
                            </div>
                            <i class="fas fa-user-check fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-white-75 small">En Prisión</div>
                                <div class="text-lg fw-bold">
                                    {{ $history_cri->where('legalStatus.status_name', '!=', 'Libre')->count() }}</div>
                            </div>
                            <i class="fas fa-user-lock fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Primera fila de gráficos --}}
        <div class="row mb-4">
            {{-- Nacionalidades más comunes --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-flag me-2 text-success"></i>Nacionalidades
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @php
                                $nacionalidades = $crimi
                                    ->whereNotNull('nationality.nationality_name')
                                    ->groupBy('nationality.nationality_name')
                                    ->map(fn($group) => $group->count())
                                    ->sortDesc();

                                $total = $nacionalidades->sum();

                                $topSix = $nacionalidades->take(6);
                                $othersCount = $nacionalidades->slice(6)->sum();

                                if ($othersCount > 0) {
                                    $finalNacionalidades = $topSix->put('Otros', $othersCount);
                                } else {
                                    $finalNacionalidades = $topSix;
                                }
                            @endphp

                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nacionalidad</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($finalNacionalidades as $nacionalidad => $cantidad)
                                        @php
                                            $porcentaje = round(($cantidad / $total) * 100, 2);
                                        @endphp
                                        <tr>
                                            <td>{{ Str::limit($nacionalidad, 25) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $cantidad }}</span>
                                            </td>
                                            <td class="text-center">{{ $porcentaje }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td class="text-center">{{ $total }}</td>
                                        <td class="text-center">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gráfico de Especialidades Criminales --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Especialidades Criminales
                        </h5>
                    </div>
                    @php
                        // Agrupamos y contamos las especialidades
                        $specialtyCounts = collect($history_cri)
                            ->groupBy(fn($item) => $item->criminalSpecialty->specialty_name ?? 'Sin especialidad')
                            ->map->count()
                            ->sortDesc();

                        $total = $specialtyCounts->sum();

                        // Tomamos las 6 más populares
                        $topSix = $specialtyCounts->take(6);

                        // Sumamos el resto como "Otros"
                        $othersCount = $specialtyCounts->slice(6)->sum();

                        // Creamos colección final con top 6 + "Otros" si hay resto
                        if ($othersCount > 0) {
                            $finalCounts = $topSix->put('Otros', $othersCount);
                        } else {
                            $finalCounts = $topSix;
                        }
                    @endphp
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Especialidad</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($finalCounts as $specialty => $count)
                                        @php
                                            $percentage = round(($count / $total) * 100, 2);
                                        @endphp
                                        <tr>
                                            <td>{{ $specialty }}</td>
                                            <td class="text-center">{{ $count }}</td>
                                            <td class="text-center">{{ $percentage }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr class="fw-bold">
                                        <td>Total</td>
                                        <td class="text-center">{{ $total }}</td>
                                        <td class="text-center">100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- Segunda fila de gráficos --}}
        <div class="row mb-4">
            {{-- Gráfico de Tendencia de Capturas --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Tendencia de Capturas por Mes
                        </h5>

                        <button id="backButton" class="btn btn-sm btn-secondary" style="display:none;">← Volver</button>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="arrestChart" style="width: 100%; height: 350px;"></canvas>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('arrestChart').getContext('2d');
                let arrestChart;
                let currentPeriod = 'year';
                let currentParent = null;
                const cache = {}; // cache simple para almacenar datos ya consultados

                // Paleta de colores vibrantes y modernos
                const vibrantColors = [
                    'rgba(255, 99, 132, 0.8)', // Rosa vibrante
                    'rgba(54, 162, 235, 0.8)', // Azul brillante
                    'rgba(255, 206, 86, 0.8)', // Amarillo dorado
                    'rgba(75, 192, 192, 0.8)', // Verde agua
                    'rgba(153, 102, 255, 0.8)', // Púrpura
                    'rgba(255, 159, 64, 0.8)', // Naranja
                    'rgba(199, 199, 199, 0.8)', // Gris
                    'rgba(83, 102, 255, 0.8)', // Azul índigo
                    'rgba(255, 99, 255, 0.8)', // Magenta
                    'rgba(99, 255, 132, 0.8)', // Verde lima
                    'rgba(255, 193, 7, 0.8)', // Ámbar
                    'rgba(156, 39, 176, 0.8)', // Púrpura oscuro
                    'rgba(33, 150, 243, 0.8)', // Azul material
                    'rgba(76, 175, 80, 0.8)', // Verde material
                    'rgba(244, 67, 54, 0.8)', // Rojo material
                    'rgba(255, 87, 34, 0.8)', // Naranja profundo
                    'rgba(96, 125, 139, 0.8)', // Azul gris
                    'rgba(121, 85, 72, 0.8)', // Marrón
                    'rgba(158, 158, 158, 0.8)', // Gris medio
                    'rgba(0, 188, 212, 0.8)' // Cian
                ];

                // Función para obtener colores vibrantes
                function getVibrantColor(index) {
                    return vibrantColors[index % vibrantColors.length];
                }

                // Para evitar llamadas rápidas sucesivas
                let debounceTimeout = null;

                function fetchChartData(period = 'year', parent = null) {
                    const cacheKey = period + '|' + (parent ?? '');

                    if (cache[cacheKey]) {
                        // Usa datos cacheados
                        updateChart(cache[cacheKey], period, parent);
                        return;
                    }

                    if (debounceTimeout) clearTimeout(debounceTimeout);

                    debounceTimeout = setTimeout(() => {
                        let url = `{{ route('estadisticas.arrest-chart-data') }}?period=${period}`;
                        if (parent) url += `&parent=${parent}`;

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                cache[cacheKey] = data; // Guardar en cache
                                updateChart(data, period, parent);
                            })
                            .catch(err => console.error('Error cargando datos:', err));
                    }, 200); // Espera 200ms para evitar llamadas repetidas
                }

                function updateChart(data, period, parent) {
                    const labels = data.map(item => item.period);
                    const counts = data.map(item => item.count);
                    const colors = labels.map((_, index) => getVibrantColor(index));
                    const borderColors = colors.map(c => c.replace('0.8', '1'));
                    const hoverColors = colors.map(c => c.replace('0.8', '0.95'));

                    if (arrestChart) {
                        arrestChart.data.labels = labels;
                        arrestChart.data.datasets[0].data = counts;
                        arrestChart.data.datasets[0].backgroundColor = colors;
                        arrestChart.data.datasets[0].borderColor = borderColors;
                        arrestChart.data.datasets[0].hoverBackgroundColor = hoverColors;
                        arrestChart.update();
                    } else {
                        arrestChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Cantidad de Arrestos',
                                    data: counts,
                                    backgroundColor: colors,
                                    borderColor: borderColors,
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    hoverBackgroundColor: hoverColors,
                                    hoverBorderColor: borderColors,
                                    hoverBorderWidth: 3,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                layout: {
                                    padding: {
                                        top: 20,
                                        bottom: 20,
                                        left: 10,
                                        right: 10
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        grid: {
                                            display: true,
                                            color: 'rgba(255, 255, 255, 0.1)',
                                            borderColor: 'rgba(255, 255, 255, 0.3)',
                                        },
                                        ticks: {
                                            color: 'white',
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            },
                                            maxRotation: 45,
                                            minRotation: 0
                                        },
                                        title: {
                                            display: true,
                                            text: period === 'year' ? 'Años' : period === 'month' ? 'Meses' : 'Días',
                                            color: 'white',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        stepSize: 1,
                                        grid: {
                                            display: true,
                                            color: 'rgba(255, 255, 255, 0.1)',
                                            borderColor: 'rgba(255, 255, 255, 0.3)',
                                        },
                                        ticks: {
                                            precision: 0,
                                            color: 'white',
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Número de Arrestos',
                                            color: 'white',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top',
                                        labels: {
                                            color: 'white',
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            padding: 20,
                                            usePointStyle: true,
                                            pointStyle: 'circle'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleColor: 'white',
                                        bodyColor: 'white',
                                        borderColor: 'white',
                                        borderWidth: 1,
                                        titleFont: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                        bodyFont: {
                                            size: 13
                                        },
                                        cornerRadius: 8,
                                        displayColors: true,
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                return `Período: ${tooltipItems[0].label}`;
                                            },
                                            label: function(context) {
                                                return `Arrestos: ${context.parsed.y}`;
                                            }
                                        }
                                    },
            
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeInOutQuart'
                                },
                                interaction: {
                                    intersect: false,
                                    mode: 'index'
                                },
                                onClick: (evt, elements) => {
                                    if (!elements.length) return;
                                    const index = elements[0].index;
                                    const label = arrestChart.data.labels[index];

                                    if (currentPeriod === 'year') {
                                        currentPeriod = 'month';
                                        currentParent = label;
                                    } else if (currentPeriod === 'month') {
                                        currentPeriod = 'day';
                                        currentParent = label;
                                    } else {
                                        return;
                                    }

                                    fetchChartData(currentPeriod, currentParent);
                                    document.getElementById('backButton').style.display = 'inline-block';
                                }
                            }
                        });
                    }
                }

                document.getElementById('backButton').addEventListener('click', () => {
                    if (currentPeriod === 'day') {
                        currentPeriod = 'month';
                        currentParent = currentParent.split(' ')[0].slice(0, 7);
                    } else if (currentPeriod === 'month') {
                        currentPeriod = 'year';
                        currentParent = null;
                        document.getElementById('backButton').style.display = 'none';
                    }
                    fetchChartData(currentPeriod, currentParent);
                });

                // Carga inicial con años
                fetchChartData();
            </script>

            {{-- Estado Legal Actual --}}

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-gavel me-2 text-success"></i>Situación Legal
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            // Agrupar todos los arrestos por status_name
                            $grouped = $history_cri->groupBy(fn($h) => $h->legalStatus->status_name ?? 'Desconocido');

                            $total = $history_cri->count();
                        @endphp
                        @if ($total > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Situación Legal</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grouped as $status => $items)
                                            @php
                                                $count = $items->count();
                                                $percentage = round(($count / $total) * 100, 2);
                                                $badgeColor = $status === 'Libre' ? 'success' : 'warning';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $badgeColor }}">{{ $status }}</span>
                                                </td>
                                                <td class="text-center">{{ $count }}</td>
                                                <td class="text-center">{{ $percentage }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="fw-bold">
                                            <td>Total</td>
                                            <td class="text-center">{{ $total }}</td>
                                            <td class="text-center">100%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No hay datos de arrestos.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Nueva fila: Tipo de Registro y Top Reincidentes --}}
        <div class="row mb-4">
            {{-- Tipo de Registro --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-list me-2 text-info"></i>Tipo de Aprehensión
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            // Filtrar arrestos que tengan tipo de aprehensión definido
                            $arrestsWithType = $history_cri->filter(fn($h) => $h->apprehensionType !== null);

                            // Agrupar por nombre de tipo de aprehensión
                            $grouped = $arrestsWithType->groupBy(fn($h) => $h->apprehensionType->type_name ?? 'N/A');

                            $total = $arrestsWithType->count();
                        @endphp

                        @if ($total > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Tipo de Aprehensión</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grouped as $type => $items)
                                            @php
                                                $count = $items->count();
                                                $percentage = round(($count / $total) * 100, 2);
                                            @endphp
                                            <tr>
                                                <td>{{ $type }}</td>
                                                <td class="text-center">{{ $count }}</td>
                                                <td class="text-center">{{ $percentage }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="fw-bold">
                                            <td>Total</td>
                                            <td class="text-center">{{ $total }}</td>
                                            <td class="text-center">100%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No hay datos de tipos de aprehensión.</p>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Top Reincidentes --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-redo me-2 text-danger"></i>Top 10 Reincidentes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark sticky-top">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>CI</th>
                                        <th class="text-center">Capturas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Calcular reincidentes basado en el historial de capturas
                                        $topReincidentes = $history_cri
                                            ->groupBy('criminal_id')
                                            ->map(function ($arrests, $criminalId) use ($crimi) {
                                                $criminal = $crimi->firstWhere('id', $criminalId);
                                                return [
                                                    'id' => $criminalId,
                                                    'name' => $criminal
                                                        ? $criminal->first_name . ' ' . $criminal->last_nameP
                                                        : 'N/A',
                                                    'ci' => $criminal ? $criminal->identity_number : 'N/A',
                                                    'arrests_count' => $arrests->count(),
                                                ];
                                            })
                                            ->filter(function ($item) {
                                                return $item['arrests_count'] > 1; // Solo reincidentes
                                            })
                                            ->sortByDesc('arrests_count')
                                            ->take(10);
                                    @endphp
                                    @foreach ($topReincidentes as $index => $reincidente)
                                        <tr>
                                            <td><span class="badge bg-danger">{{ $index + 1 }}</span></td>
                                            <td>{{ Str::limit($reincidente['name'], 25) }}</td>
                                            <td>{{ $reincidente['ci'] }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-warning">{{ $reincidente['arrests_count'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($topReincidentes->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No hay datos de
                                                reincidentes
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tercera fila: Tablas de análisis --}}
        <div class="row mb-4">
            {{-- Top 10 Organizaciones --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sitemap me-2 text-danger"></i>Top Organizaciones Criminales
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Organización</th>
                                        <th class="text-center">Miembros</th>
                                        <th class="text-center">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $organizaciones = $orga
                                            ->groupBy('organization.organization_name')
                                            ->map(function ($group) {
                                                return $group->count();
                                            })
                                            ->sortDesc()
                                            ->take(10);
                                        $totalMiembros = $orga->count();
                                    @endphp
                                    @foreach ($organizaciones as $name => $count)
                                        <tr>
                                            <td>{{ Str::limit($name, 30) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-danger">{{ $count }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $totalMiembros > 0 ? round(($count / $totalMiembros) * 100, 1) : 0 }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($organizaciones->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No hay datos de
                                                organizaciones</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Análisis por Edad --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-birthday-cake me-2 text-info"></i>Distribución por Rango de Edad
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Rango de Edad</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rangosEdad = $crimi
                                            ->whereNotNull('age')
                                            ->groupBy(function ($criminal) {
                                                $age = $criminal->age;
                                                if ($age < 18) {
                                                    return '0-17';
                                                }
                                                if ($age < 25) {
                                                    return '18-24';
                                                }
                                                if ($age < 35) {
                                                    return '25-34';
                                                }
                                                if ($age < 45) {
                                                    return '35-44';
                                                }
                                                if ($age < 55) {
                                                    return '45-54';
                                                }
                                                if ($age < 65) {
                                                    return '55-64';
                                                }
                                                return '65+';
                                            })
                                            ->map(function ($group) {
                                                return $group->count();
                                            })
                                            ->sortKeys();
                                        $total = $rangosEdad->sum();
                                    @endphp
                                    @foreach ($rangosEdad as $rango => $cantidad)
                                        <tr>
                                            <td>{{ $rango }} años</td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $cantidad }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{ $total > 0 ? round(($cantidad / $total) * 100, 1) : 0 }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cuarta fila: Análisis adicionales --}}
        <div class="row mb-4">
            {{-- Prisiones más utilizadas --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-building me-2 text-secondary"></i>Prisiones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Prisión</th>
                                        <th class="text-center">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $prisionesStats = collect();
                                        foreach ($crimi as $criminal) {
                                            foreach ($criminal->prision as $prison) {
                                                $prisionesStats->push($prison->prison_name);
                                            }
                                        }
                                        $prisionesGrouped = $prisionesStats->countBy()->sortDesc()->take(8);
                                    @endphp
                                    @foreach ($prisionesGrouped as $nombre => $cantidad)
                                        <tr>
                                            <td>{{ Str::limit($nombre, 25) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $cantidad }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($prisionesGrouped->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No hay datos de
                                                prisiones
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profesiones más comunes --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-briefcase me-2 text-primary"></i>Profesiones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Profesión</th>
                                        <th class="text-center">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $profesiones = $crimi
                                            ->whereNotNull('occupation')
                                            ->groupBy('occupation.ocupation_name')
                                            ->map(function ($group) {
                                                return $group->count();
                                            })
                                            ->sortDesc()
                                            ->take(8);
                                    @endphp
                                    @foreach ($profesiones as $profesion => $cantidad)
                                        <tr>
                                            <td>{{ Str::limit($profesion, 25) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $cantidad }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($profesiones->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No hay datos de
                                                profesiones
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tipos de condena --}}
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-hammer me-2 text-dark"></i>Tipos de Condena
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tipo</th>
                                        <th class="text-center">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tiposCondena = $condena
                                            ->groupBy('detentionType.detention_name')
                                            ->map(function ($group) {
                                                return $group->count();
                                            })
                                            ->sortDesc()
                                            ->take(8);
                                    @endphp
                                    @foreach ($tiposCondena as $tipo => $cantidad)
                                        <tr>
                                            <td>{{ Str::limit($tipo, 25) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-dark">{{ $cantidad }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($tiposCondena->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No hay datos de condenas
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mapa de calor de capturas por ubicación --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>Lugares de Captura Más Frecuentes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $lugaresCapturas = $history_cri
                                    ->filter(function ($history) {
                                        return !empty($history->arrest_location);
                                    })
                                    ->groupBy('arrest_location')
                                    ->map(function ($group) {
                                        return $group->count();
                                    })
                                    ->sortDesc()
                                    ->take(12);
                            @endphp
                            @foreach ($lugaresCapturas as $lugar => $cantidad)
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center p-3">
                                            <h6 class="card-title text-truncate">{{ $lugar ?: 'Sin especificar' }}
                                            </h6>
                                            <span class="badge bg-danger fs-6">{{ $cantidad }}</span>
                                            <div class="small text-muted mt-1">capturas</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts para los gráficos --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Configuración global de Chart.js
            Chart.defaults.responsive = true;
            Chart.defaults.maintainAspectRatio = false;
        </script>
    @endpush

    @push('styles')
        <style>
            .text-lg {
                font-size: 1.5rem;
            }

            .card {
                border: none;
                border-radius: 0.5rem;
            }

            .shadow-sm {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .table-responsive {
                max-height: 400px;
            }

            .badge {
                font-size: 0.8em;
            }
        </style>
    @endpush
@endsection

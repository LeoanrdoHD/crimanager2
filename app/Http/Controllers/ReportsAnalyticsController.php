<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\arrest_and_apprehension_history;
use App\Models\photograph;
use App\Models\criminal_phone_number;
use App\Models\criminal_vehicle;
use App\Models\criminal_organization;
use App\Models\conviction;
use App\Models\criminal_complice;
use App\Models\criminal_aliase;
use App\Models\nationality;
use App\Models\relationship_type;
use App\Models\criminal;
use App\Models\legal_statuse;
use App\Models\apprehension_type;
use App\Models\criminal_specialty;
use App\Models\ocupation;

use Carbon\Carbon;
use DB;

class ReportsAnalyticsController extends Controller
{
    /**
     * Dashboard principal de analytics criminal
     */
    public function analytics()
    {
        // Llamas a la función que devuelve el análisis temporal
        // Datos básicos (utilizando las mismas consultas del controlador original)
        $history_cri = arrest_and_apprehension_history::with('legalStatus', 'criminalSpecialty', 'apprehensionType')->get();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::with('organization')->get();
        $condena = conviction::with('detentionType')->get();
        $complice = criminal_complice::all();
        $aliase = criminal_aliase::all();
        $nacionalidad = nationality::all();
        $t_relacion = relationship_type::all();
        $criminals = criminal::get();
        $lstatus = legal_statuse::all();
        $t_aprehe = apprehension_type::all();
        $cri_esp = criminal_specialty::all();
        $ocupacion = ocupation::all();

        // Datos completos con relaciones para análisis profundo
        $crimi = Criminal::with(
            'civilState',
            'country',
            'state',
            'city',
            'nationality',
            'occupation',
            'photographs',
            'arrestHistories',
            'criminalAddresses.country',
            'criminalAddresses.state',
            'criminalAddresses.city',
            'physicalCharacteristics.earType',
            'physicalCharacteristics.eyeType',
            'physicalCharacteristics.lipType',
            'physicalCharacteristics.noseType',
            'physicalCharacteristics.skinColor',
            'physicalCharacteristics.Confleccion',
            'physicalCharacteristics.criminalGender',
            'criminalPartner.relationshipType'
        )->get();

        $history = arrest_and_apprehension_history::with(
            'criminalTools.toolType',
            'phoneNumber.company',
            'criminalAliase.nationality',
            'criminalComplice',
            'criminalOrganization.organization',
            'criminalVehicle.vehicleColor',
            'criminalVehicle.vehicleType',
            'criminalVehicle.brandVehicle',
            'criminalVehicle.industry',
            'criminalVehicle.vehicleService',
            'criminalVehicle.relationshipWithOwner',
            'criminalConviction.detentionType',
            'extraditions',
            'houseArrests',
            'preventiveDetentions.prison',
            'liberties',
        )->get();

        // Cálculos estadísticos avanzados corregidos
        $analytics = $this->calculateAdvancedStatistics($crimi, $history, $history_cri, $orga, $condena, $phone_cri, $vehicle, $fotos, $aliase, $complice, $t_aprehe);

        return view('estadisticas.analytics', array_merge(

            compact(
                'crimi',
                'history_cri',
                'history',
                'fotos',
                'phone_cri',
                'vehicle',
                'orga',
                'condena',
                'complice',
                'aliase',
                'nacionalidad',
                'ocupacion',
                'cri_esp',
                'lstatus',
                't_aprehe',
                'analytics'
            )
        ));
    }
    /**
     * Estadísticas específicas por nacionalidad
     */
    public function nationalityStats()
    {
        $crimi = Criminal::with('nationality', 'arrestHistories')->get();
        $history_cri = arrest_and_apprehension_history::all();

        $nationalityStats = $crimi->groupBy('nationality.nationality_name')->map(function ($criminals, $nationality) use ($history_cri) {
            return [
                'name' => $nationality ?: 'Sin especificar',
                'total' => $criminals->count(),
                'with_arrests' => $criminals->filter(function ($criminal) use ($history_cri) {
                    return $history_cri->where('criminal_id', $criminal->id)->count() > 0;
                })->count(),
                'average_age' => $criminals->avg('age'),
                'arrests_count' => $history_cri->whereIn('criminal_id', $criminals->pluck('id'))->count(),
            ];
        })->sortByDesc('total');

        return response()->json($nationalityStats->values());
    }

    /**
     * Análisis temporal de capturas
     */
    public function showArrestChart(Request $request)
    {
        $period = $request->get('period', 'year'); // 'year', 'month', 'day'
        $parent = $request->get('parent'); // año, o año-mes

        $history_cri = arrest_and_apprehension_history::select('arrest_date', 'criminal_id')->get();

        $filtered = $history_cri->filter(function ($item) use ($parent, $period) {
            if (!$parent) return true; // sin filtro, todo
            $date = Carbon::parse($item->arrest_date);

            if ($period == 'month') {
                // filtra solo datos del año $parent
                return $date->format('Y') == $parent;
            }
            if ($period == 'day') {
                // filtra solo datos del mes $parent (ejemplo '2025-01')
                return $date->format('Y-m') == $parent;
            }
            return true;
        });

        $grouped = $filtered->groupBy(function ($item) use ($period) {
            $date = Carbon::parse($item->arrest_date);

            switch ($period) {
                case 'year':
                    return $date->format('Y');
                case 'month':
                    return $date->format('Y-m');
                case 'day':
                    // Aquí agrupamos días en rangos de 5 días
                    $day = (int)$date->format('d');
                    $rangeStart = floor(($day - 1) / 5) * 5 + 1;
                    $rangeEnd = $rangeStart + 4;
                    return $date->format('Y-m') . " $rangeStart-$rangeEnd";
                default:
                    return $date->format('Y-m');
            }
        });

        $temporalData = $grouped->map(function ($group, $key) {
            return [
                'period' => $key,
                'count' => $group->count(),
                'unique_criminals' => $group->pluck('criminal_id')->unique()->count(),
            ];
        })->sortKeys()->values();

        return response()->json($temporalData);
    }



    /**
     * Análisis de organizaciones criminales
     */
    public function organizationAnalysis()
    {
        $orga = criminal_organization::with('organization')->get();
        $history_cri = arrest_and_apprehension_history::all();

        $organizationStats = $orga->groupBy('organization.organization_name')->map(function ($members, $orgName) use ($history_cri) {
            $memberIds = $members->pluck('criminal_id');
            return [
                'name' => $orgName,
                'total_members' => $members->count(),
                'total_arrests' => $history_cri->whereIn('criminal_id', $memberIds)->count(),
                'active_members' => $members->filter(function ($member) use ($history_cri) {
                    return $history_cri->where('criminal_id', $member->criminal_id)
                        ->where('arrest_date', '>=', Carbon::now()->subYear())
                        ->count() > 0;
                })->count(),
                'activity_specialty' => $members->first()->organization->Criminal_Organization_Specialty ?? 'No especificada'
            ];
        })->sortByDesc('total_members');

        return response()->json($organizationStats->values());
    }

    /**
     * Análisis de reincidencia
     */
    public function recidivismAnalysis()
    {
        $history_cri = arrest_and_apprehension_history::all();
        $crimi = Criminal::all();

        $recidivismData = $history_cri->groupBy('criminal_id')->map(function ($arrests, $criminalId) use ($crimi) {
            $criminal = $crimi->find($criminalId);
            return [
                'criminal_id' => $criminalId,
                'name' => $criminal ? $criminal->first_name . ' ' . $criminal->last_nameP : 'Desconocido',
                'arrests_count' => $arrests->count(),
                'first_arrest' => $arrests->min('arrest_date'),
                'last_arrest' => $arrests->max('arrest_date'),
                'time_between_arrests' => $arrests->count() > 1 ?
                    Carbon::parse($arrests->min('arrest_date'))->diffInDays(Carbon::parse($arrests->max('arrest_date'))) : 0
            ];
        })->filter(function ($data) {
            return $data['arrests_count'] > 1; // Solo reincidentes
        })->sortByDesc('arrests_count');

        // Estadísticas de reincidencia
        $recidivismStats = [
            'total_criminals' => $crimi->count(),
            'total_recidivists' => $recidivismData->count(),
            'recidivism_rate' => round(($recidivismData->count() / $crimi->count()) * 100, 2),
            'average_arrests_per_recidivist' => round($recidivismData->avg('arrests_count'), 2),
            'top_recidivists' => $recidivismData->take(10)->values()
        ];

        return response()->json($recidivismStats);
    }

    /**
     * Análisis geográfico
     */
    public function geographicAnalysis()
    {
        $crimi = Criminal::with('criminalAddresses.country', 'criminalAddresses.state', 'criminalAddresses.city')->get();
        $history_cri = arrest_and_apprehension_history::all();

        // Por país de residencia
        $countryStats = $crimi->flatMap(function ($criminal) {
            return $criminal->criminalAddresses->pluck('country.country_name');
        })->countBy()->sortDesc();

        // Por estado de residencia
        $stateStats = $crimi->flatMap(function ($criminal) {
            return $criminal->criminalAddresses->pluck('state.state_name');
        })->countBy()->sortDesc();

        // Por lugares de captura
        $arrestLocationStats = $history_cri->countBy('arrest_location')->sortDesc();

        return response()->json([
            'residence_by_country' => $countryStats,
            'residence_by_state' => $stateStats,
            'arrests_by_location' => $arrestLocationStats
        ]);
    }

    /**
     * Análisis de características físicas
     */
    public function physicalCharacteristicsAnalysis()
    {
        $crimi = Criminal::with('physicalCharacteristics')->get();

        $physicalStats = [
            'age_distribution' => $this->getAgeDistribution($crimi),
            'height_distribution' => $this->getHeightDistribution($crimi),
            'weight_distribution' => $this->getWeightDistribution($crimi),
            'complexion_distribution' => $this->getComplexionDistribution($crimi),
            'gender_distribution' => $this->getGenderDistribution($crimi)
        ];

        return response()->json($physicalStats);
    }

    /**
     * Análisis de vehículos
     */
    public function vehicleAnalysis()
    {
        $vehicle = criminal_vehicle::with('vehicleType', 'brandVehicle', 'vehicleColor')->get();

        $vehicleStats = [
            'by_type' => $vehicle->groupBy('vehicleType.type_name')->map->count()->sortDesc(),
            'by_brand' => $vehicle->groupBy('brandVehicle.brand_name')->map->count()->sortDesc(),
            'by_color' => $vehicle->groupBy('vehicleColor.color_name')->map->count()->sortDesc(),
            'total_vehicles' => $vehicle->count(),
            'criminals_with_vehicles' => $vehicle->pluck('criminal_id')->unique()->count()
        ];

        return response()->json($vehicleStats);
    }

    /**
     * Exportar datos para reportes
     */
    public function exportData(Request $request)
    {
        $format = $request->get('format', 'json'); // json, csv, pdf

        $data = [
            'summary' => $this->getSummaryStats(),
            'nationalities' => $this->nationalityStats(),
            'organizations' => $this->organizationAnalysis(),
            'recidivism' => $this->recidivismAnalysis(),
            'geographic' => $this->geographicAnalysis(),
            'generated_at' => Carbon::now()->toDateTimeString()
        ];

        switch ($format) {
            case 'csv':
                return $this->exportToCsv($data);
            case 'pdf':
                return $this->exportToPdf($data);
            default:
                return response()->json($data);
        }
    }

    // ===== MÉTODOS PRIVADOS AUXILIARES =====

    private function calculateAdvancedStatistics($crimi, $history, $history_cri, $orga, $condena, $phone_cri, $vehicle, $fotos, $aliase, $complice, $t_aprehe)
    {
        // Criminales en prisión = aquellos con condena de "Detención Preventiva"
        $criminalesEnPrision = $condena->where('detentionType.detention_name', 'Detención Preventiva')->pluck('criminal_id')->unique()->count();

        // Reincidentes ordenados por cantidad de arrestos
        $reincidentes = $history_cri->groupBy('criminal_id')
            ->map(function ($arrests, $criminalId) use ($crimi) {
                $criminal = $crimi->where('id', $criminalId)->first();
                return [
                    'criminal_id' => $criminalId,
                    'name' => $criminal ? $criminal->first_name . ' ' . $criminal->last_nameP : 'Desconocido',
                    'arrests_count' => $arrests->count(),
                    'ci' => $criminal ? $criminal->identity_number : 'N/A'
                ];
            })
            ->filter(function ($data) {
                return $data['arrests_count'] > 1;
            })
            ->sortByDesc('arrests_count')
            ->take(10)
            ->values();

        return [
            // Estadísticas básicas corregidas
            'total_criminals' => $crimi->count(),
            'criminals_with_history' => $crimi->filter(function ($criminal) use ($history_cri) {
                return $history_cri->where('criminal_id', $criminal->id)->count() > 0;
            })->count(),
            'total_arrests' => $history_cri->count(),
            'criminals_with_photos' => $fotos->pluck('criminal_id')->unique()->count(),
            'criminals_en_libertad' => $history_cri->where('legalStatus.status_name', 'Libre')->count(),
            'criminals_en_prision' => $criminalesEnPrision,

            // Top reincidentes
            'top_reincidentes' => $reincidentes,

            // Distribución por nacionalidad (corregida)
            'nationality_distribution' => $crimi->filter(function ($criminal) {
                return $criminal->nationality && $criminal->nationality->nationality_name;
            })->groupBy('nationality.nationality_name')->map(function ($group) {
                return $group->count();
            })->sortDesc(),

            // Especialidades criminales (corregida)
            'specialty_distribution' => $history_cri->filter(function ($history) {
                return $history->criminalSpecialty && $history->criminalSpecialty->specialty_name;
            })->groupBy('criminalSpecialty.specialty_name')->map(function ($group) {
                return $group->count();
            })->sortDesc(),

            // Estados legales (corregida - basada en situación legal)
            'legal_status_distribution' => $history_cri->filter(function ($history) {
                return $history->legalStatus && $history->legalStatus->status_name;
            })->groupBy('legalStatus.status_name')->map(function ($group) {
                return $group->count();
            }),

            // Tipos de registro (nueva estadística)
            'registration_type_distribution' => $history_cri->filter(function ($history) {
                return $history->apprehensionType && $history->apprehensionType->type_name;
            })->groupBy('apprehensionType.type_name')->map(function ($group) {
                return $group->count();
            })->sortDesc(),

            // Tendencia de capturas por mes (corregida)
            'arrests_by_month' => $history_cri->filter(function ($history) {
                return $history->arrest_date;
            })->groupBy(function ($history) {
                return Carbon::parse($history->arrest_date)->format('Y-m');
            })->map(function ($group) {
                return $group->count();
            })->sortBy(function ($count, $month) {
                return $month;
            }),

            // Análisis temporal
            'arrests_last_30_days' => $history_cri->where('arrest_date', '>=', Carbon::now()->subDays(30))->count(),
            'arrests_last_year' => $history_cri->where('arrest_date', '>=', Carbon::now()->subYear())->count(),

            // Análisis demográfico
            'average_age' => round($crimi->whereNotNull('age')->avg('age'), 1),
            'age_ranges' => $this->getAgeRanges($crimi),

            // Análisis criminal
            'recidivism_rate' => $this->calculateRecidivismRate($history_cri, $crimi),

            // Análisis organizacional
            'total_organizations' => $orga->pluck('organization_id')->unique()->count(),
            'criminals_in_organizations' => $orga->count(),
            'top_organizations' => $orga->filter(function ($org) {
                return $org->organization && $org->organization->organization_name;
            })->groupBy('organization.organization_name')->map(function ($group) {
                return $group->count();
            })->sortDesc()->take(5),

            // Análisis de contactos y vehículos
            'criminals_with_phones' => $phone_cri->pluck('criminal_id')->unique()->count(),
            'criminals_with_vehicles' => $vehicle->pluck('criminal_id')->unique()->count(),
            'total_aliases' => $aliase->count(),
            'criminals_with_accomplices' => $complice->pluck('criminal_id')->unique()->count(),

            // Análisis de condenas
            'total_convictions' => $condena->count(),
            'conviction_types' => $condena->filter(function ($conviction) {
                return $conviction->detentionType && $conviction->detentionType->detention_name;
            })->groupBy('detentionType.detention_name')->map(function ($group) {
                return $group->count();
            })->sortDesc()
        ];
    }

    private function getAgeRanges($crimi)
    {
        $ranges = [
            '18-25' => $crimi->whereBetween('age', [18, 25])->count(),
            '26-35' => $crimi->whereBetween('age', [26, 35])->count(),
            '36-45' => $crimi->whereBetween('age', [36, 45])->count(),
            '46-55' => $crimi->whereBetween('age', [46, 55])->count(),
            '56+' => $crimi->where('age', '>=', 56)->count(),
        ];
        return $ranges;
    }

    private function calculateRecidivismRate($history_cri, $crimi)
    {
        $recidivists = $history_cri->groupBy('criminal_id')->filter(function ($arrests) {
            return $arrests->count() > 1;
        })->count();

        return round(($recidivists / $crimi->count()) * 100, 2);
    }

    private function getAgeDistribution($crimi)
    {
        return $crimi->whereNotNull('age')->groupBy(function ($criminal) {
            if ($criminal->age < 25) return '18-24';
            if ($criminal->age < 35) return '25-34';
            if ($criminal->age < 45) return '35-44';
            if ($criminal->age < 55) return '45-54';
            return '55+';
        })->map->count();
    }

    private function getHeightDistribution($crimi)
    {
        return $crimi->flatMap(function ($criminal) {
            return $criminal->physicalCharacteristics->pluck('height');
        })->filter()->groupBy(function ($height) {
            if ($height < 160) return 'Bajo (<160cm)';
            if ($height < 170) return 'Medio (160-169cm)';
            if ($height < 180) return 'Alto (170-179cm)';
            return 'Muy Alto (≥180cm)';
        })->map->count();
    }

    private function getWeightDistribution($crimi)
    {
        return $crimi->flatMap(function ($criminal) {
            return $criminal->physicalCharacteristics->pluck('weight');
        })->filter()->groupBy(function ($weight) {
            if ($weight < 60) return 'Delgado (<60kg)';
            if ($weight < 80) return 'Medio (60-79kg)';
            if ($weight < 100) return 'Robusto (80-99kg)';
            return 'Muy Robusto (≥100kg)';
        })->map->count();
    }

    private function getComplexionDistribution($crimi)
    {
        return $crimi->flatMap(function ($criminal) {
            return $criminal->physicalCharacteristics->pluck('confleccion.conflexion_name');
        })->countBy()->sortDesc();
    }

    private function getGenderDistribution($crimi)
    {
        return $crimi->flatMap(function ($criminal) {
            return $criminal->physicalCharacteristics->pluck('criminalGender.gender_name');
        })->countBy();
    }

    private function getSummaryStats()
    {
        // Implementar estadísticas resumidas
        return [
            'total_records' => Criminal::count(),
            'last_updated' => Carbon::now()->toDateTimeString()
        ];
    }

    private function exportToCsv($data)
    {
        // Implementar exportación a CSV
        $filename = 'criminal_analytics_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
        // Lógica de exportación
        return response()->streamDownload(function () use ($data) {
            // Generar CSV
        }, $filename);
    }

    private function exportToPdf($data)
    {
        // Implementar exportación a PDF
        $filename = 'criminal_analytics_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
        // Lógica de exportación
        return response()->streamDownload(function () use ($data) {
            // Generar PDF
        }, $filename);
    }
}

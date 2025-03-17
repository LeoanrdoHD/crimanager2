<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\arrest_and_apprehension_history;
use App\Models\Criminal_Specialty;

class EstadisticasController extends Controller
{
    public function index()
    {
        // Datos por defecto (inicialmente por año)
        $arrestsByYear = $this->getArrestosData('year');
        

        $specialtiesData = arrest_and_apprehension_history::join('criminal_specialties', 'arrest_and_apprehension_history.criminal_specialty_id', '=', 'criminal_specialties.id')
            ->selectRaw('criminal_specialties.specialty_name, COUNT(*) as total')
            ->groupBy('criminal_specialties.specialty_name')
            ->orderBy('total', 'desc')
            ->pluck('total', 'criminal_specialties.specialty_name');


        return view('estadisticas_sistema', [
            'arrestsByYear' => $arrestsByYear,
    
            'criminalSpecialties' => $specialtiesData
        ]);
    }

    public function getArrestos(Request $request)
    {
        $filter = $request->query('filter', 'year');
        $arrestData = $this->getArrestosData($filter);

        return response()->json($arrestData);
    }

    private function getArrestosData($filter)
    {
        $column = 'YEAR(arrest_date)'; // Por defecto es por año

        if ($filter === 'month') {
            $column = "DATE_FORMAT(arrest_date, '%Y-%m')";
        } elseif ($filter === 'week') {
            $column = "YEARWEEK(arrest_date)";
        }

        return arrest_and_apprehension_history::selectRaw("$column as period, COUNT(*) as total")
            ->groupBy('period')
            ->orderBy('period', 'DESC')
            ->pluck('total', 'period');
    }
}

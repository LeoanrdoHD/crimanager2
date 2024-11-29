<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;  // Asegúrate de importar Log
use App\Models\State;


class LocationController extends Controller
{
   // Controlador
   public function getStatesByCountry($countryId)
   {
       $states = State::where('country_id', $countryId)->get();
   
       if ($states->isEmpty()) {
           return response()->json(['error' => 'No se encontraron estados para este país.'], 404);
       }
   
       return response()->json($states);
   }
   
   public function getCitiesByState($stateId)
   {
       $cities = City::where('state_id', $stateId)->get();
   
       if ($cities->isEmpty()) {
           return response()->json(['error' => 'No se encontraron ciudades para este estado.'], 404);
       }
   
       return response()->json($cities);
   }
   
}

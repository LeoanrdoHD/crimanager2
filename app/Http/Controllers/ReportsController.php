<?php

namespace App\Http\Controllers;

use App\Models\arrest_and_apprehension_history;
use App\Models\criminal;
use App\Models\criminal_phone_number;
use App\Models\photograph;
use Illuminate\Http\Request;

class ReportsController extends Controller
{

    public function search_cri()
    {
     
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $crimi = Criminal::with(    'civilState',
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
        'criminalPartner.relationshipType')->get();
        $history = arrest_and_apprehension_history::with(    
       'criminalTools.toolType','phoneNumber.company')->get();
        
        return view('criminals.search_cri', compact('crimi', 'history_cri', 'fotos','history','phone_cri'));
    }

    public function show_crimi($criminal_id)
    {
        // Obtén el criminal correspondiente
        $criminal = Criminal::with([
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
        ])
            ->findOrFail($criminal_id);

        // Obtén el historial específico asociado al criminal
        $history = arrest_and_apprehension_history::where('criminal_id', $criminal_id)
            ->firstOrFail();

        // Redirige a la vista con los datos
        return view('criminals.show_file', compact('criminal', 'history'));
    }
    public function showFileHistory($criminal_id, $history_id)
    {
        // Cargar el criminal con todas sus relaciones
        $criminal = Criminal::with([
            'civilState',
            'country',
            'state',
            'city',
            'nationality',
            'occupation',
            'photographs',
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
            'arrestHistories.legalStatus',
            'arrestHistories.apprehensionType',
            'arrestHistories.detentionType',
            'arrestHistories.criminalSpecialty',
            'criminalPartner.relationshipType'
        ])->findOrFail($criminal_id);

        // Cargar el historial específico con sus herramientas relacionadas
        $history = arrest_and_apprehension_history::with('criminalTools.toolType','phoneNumber.company')
            ->where('id', $history_id)
            ->where('criminal_id', $criminal_id)
            ->firstOrFail();

        // Redirige a la vista con los datos
        return view('reports.show_filehistory', compact('criminal', 'history'));
    }

    public function search_criminal()
    {
        $crimi = criminal::all();
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $criminals = Criminal::with('organizations')->get();
        return view('reports.search_criminal', compact('crimi', 'criminals', 'history_cri', 'fotos'));
    }

    public function show_criminal(Criminal $file)
    {

        return view('reports.show_filecri', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_orga()
    {
        $crimi = criminal::all();
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $criminals = Criminal::with('organizations')->get();
        return view('reports.search_orga', compact('crimi', 'criminals', 'history_cri', 'fotos'));
    }

    public function show_orga(Criminal $file)
    {

        return view('reports.show_fileorg', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_vehicle()
    {
        $crimi = criminal::all();
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $criminals = Criminal::with('organizations')->get();
        return view('reports.search_vehicle', compact('crimi', 'criminals', 'history_cri', 'fotos'));
    }

    public function show_vehicle(Criminal $file)
    {

        return view('reports.show_filevehi', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_fast()
    {
        $crimi = criminal::all();
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $criminals = Criminal::with('organizations')->get();
        return view('reports.search_fast', compact('crimi', 'criminals', 'history_cri', 'fotos'));
    }

    public function show_fast(Criminal $file)
    {

        return view('reports.show_filefast', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
}

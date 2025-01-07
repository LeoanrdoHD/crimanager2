<?php

namespace App\Http\Controllers;

use App\Models\arrest_and_apprehension_history;
use App\Models\conviction;
use App\Models\criminal;
use App\Models\criminal_organization;
use App\Models\criminal_phone_number;
use App\Models\criminal_vehicle;
use App\Models\photograph;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;


class ReportsController extends Controller
{

    public function search_cri()
    {

        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::all();
        $condena = conviction::all();
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

        return view('criminals.search_cri', compact('crimi', 'history_cri', 'fotos', 'history', 'phone_cri', 'vehicle', 'orga', 'condena'));
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

    public function generatePDF($criminal_id) {
        // ... tu código aquí
        

$options = new Options();
$options->set('isRemoteEnabled', true);
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
        // Cargar la vista
        $pdf = PDF::loadView('exportar.pdf_todo', compact('criminal'));
    
        // Descargar el PDF
        return $pdf->download('criminal.pdf');

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
        )
            ->where('id', $history_id)
            ->where('criminal_id', $criminal_id)
            ->firstOrFail();

        // Redirige a la vista con los datos
        return view('reports.show_filehistory', compact('criminal', 'history'));
    }

    public function search_criminal()
    {
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::all();
        $condena = conviction::all();
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

        return view('reports.search_criminal', compact('crimi', 'history_cri', 'fotos', 'history', 'phone_cri', 'vehicle', 'orga', 'condena'));
    }

    public function show_criminal(Criminal $file)
    {

        return view('reports.show_filecri', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_orga()
    {
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::all();
        $condena = conviction::all();
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

        return view('reports.search_orga', compact('crimi', 'history_cri', 'fotos', 'history', 'phone_cri', 'vehicle', 'orga', 'condena'));
    }

    public function show_orga(Criminal $file)
    {

        return view('reports.show_fileorg', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_vehicle()
    {
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::all();
        $condena = conviction::all();
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

        return view('reports.search_vehicle', compact('crimi', 'history_cri', 'fotos', 'history', 'phone_cri', 'vehicle', 'orga', 'condena'));
    }

    public function show_vehicle(Criminal $file)
    {

        return view('reports.show_filevehi', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
    public function search_fast()
    {
        $history_cri = arrest_and_apprehension_history::all();
        $fotos = photograph::all();
        $phone_cri = criminal_phone_number::all();
        $vehicle = criminal_vehicle::all();
        $orga = criminal_organization::all();
        $condena = conviction::all();
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

        return view('reports.search_fast', compact('crimi', 'history_cri', 'fotos', 'history', 'phone_cri', 'vehicle', 'orga', 'condena'));
    }

    public function show_fast(Criminal $file)
    {

        return view('reports.show_filefast', ['criminal' => $file]);
        //return view('criminals.show_file',compact('crimi','history_cri','fotos'));
    }
}

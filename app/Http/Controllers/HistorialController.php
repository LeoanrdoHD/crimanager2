<?php

namespace App\Http\Controllers;

use App\Models\apprehension_type;
use App\Models\arrest_and_apprehension_history;
use App\Models\brand_vehicle;
use App\Models\city;
use App\Models\civil_state;
use App\Models\company;
use App\Models\conviction;
use App\Models\country;
use App\Models\criminal;
use App\Models\criminal_address;
use App\Models\criminal_aliase;
use App\Models\criminal_complice;
use App\Models\criminal_organization;
use App\Models\relationship_type;
use App\Models\criminal_partner;
use App\Models\criminal_phone_number;
use Illuminate\Support\Facades\Storage;

use App\Models\criminal_specialty;
use App\Models\criminal_tool;
use App\Models\criminal_vehicle;
use App\Models\detention_type;
use App\Models\extradition;
use App\Models\house_arrest;
use App\Models\industrie;
use App\Models\legal_statuse;
use App\Models\liberty;
use App\Models\nationality;
use App\Models\organization;
use App\Models\photograph;
use App\Models\physical_characteristic;
use App\Models\preventive_detention;
use App\Models\prison;
use App\Models\state;
use App\Models\relationship_with_owner;
use App\Models\tools_type;
use App\Models\vehicle_color;
use App\Models\vehicle_service;
use App\Models\vehicle_type;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;


use Illuminate\Http\Request;

class HistorialController extends Controller
{

    public function create_arrest(Criminal $file)
    {
        $history_cri = arrest_and_apprehension_history::get();
        $date_crimi = criminal::all();
        $lstatus = legal_statuse::all();
        $t_aprehe = apprehension_type::all();
        $fotos = photograph::all();
        $cri_esp = criminal_specialty::all();
        $compania = company::all();
        $pais = country::all();
        $ciudad = city::all();
        $provincia = state::all();
        $tcondena = detention_type::all();
        $arma = tools_type::all();
        $nacionalidad = nationality::all();
        $vcolor = vehicle_color::all();
        $vtype = vehicle_type::all();
        $marca = brand_vehicle::all();
        $industria = industrie::all();
        $servicio = vehicle_service::all();
        $relusuario = relationship_with_owner::all();
        $orga = organization::all();
        $prision = Prison::with(['country', 'state', 'city'])->get();


        $date_criminal = criminal::get();
        return view('criminals.create_arrest', ['criminal' => $file], compact('date_crimi', 'orga', 'servicio', 'vcolor', 'marca', 'vtype', 'nacionalidad', 'tcondena', 'arma', 'lstatus', 'relusuario', 't_aprehe', 'fotos', 'cri_esp', 'compania', 'prision', 'pais', 'industria', 'ciudad', 'provincia'))->with('arrest_and_apprehension_histories', $history_cri);
    }

    public function search_arrest(Criminal $file)
    {
        return view('criminals.search_arrest', compact('criminals'));
    }

    public function store_arrest(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'criminal_id' => 'required|integer|exists:criminals,id', 
                'legal_status_id' => 'required|integer|exists:legal_statuses,id', 
                'apprehension_type_id' => 'nullable|integer|exists:apprehension_types,id', 
                'arrest_date' => 'required|date|after_or_equal:2000-01-01',
                'arrest_time' => 'nullable|date_format:H:i',
                'arrest_location' => 'required|string|max:100', 
                'arrest_details' => 'required|string|max:255',
                'cud_number' => 'nullable|string|max:20', 
                'criminal_specialty_id' => 'required' 
            ]);
            $criminal_specialtyID = $request->criminal_specialty_id;
            if ($criminal_specialtyID === 'otro' && $request->filled('otra_especialidad')) {
                $newSpecialty = criminal_specialty::create([
                    'specialty_name' => $request->otra_especialidad,
                ]);
                $criminal_specialtyID = $newSpecialty->id; // Actualiza el ID con el de la nueva nacionalidad
            }
        
            $historial = arrest_and_apprehension_history::create([
                'criminal_id' => $request->criminal_id,
                'legal_status_id' => $request->legal_status_id,
                'apprehension_type_id' => $request->apprehension_type_id,
                'arrest_date' => $request->arrest_date ?? now(), // Si `arrest_date` es nulo, usa la fecha actual.
                'arrest_time' => $request->arrest_time,
                'arrest_location' => $request->arrest_location,
                'arrest_details' => $request->arrest_details,
                'cud_number' => $request->cud_number,
                'criminal_specialty_id' => $criminal_specialtyID,
            ]);
            // Guardar el ID en la sesión
            session(['arrest_and_apprehension_history_id' => $historial->id]);

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Historial Registrado con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store_arrest2(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            // Validar los datos
            $request->validate([
                'criminal_id' => 'required|exists:criminals,id',
                'phone_number.*' => 'required|string|unique:criminal_phone_numbers,phone_number|regex:/^\+?[0-9]{7,15}$/',
                'company_id.*' => 'required|exists:companies,id',
                'imei_number.*' => 'nullable|string|size:15|unique:criminal_phone_numbers,imei_number|regex:/^[0-9]+$/',
            ]);

            // Iterar a través de los arrays de datos recibidos
            $phoneNumbers = $request->phone_number;
            $companyIds = $request->company_id;
            $imeiNumbers = $request->imei_number;

            foreach ($phoneNumbers as $index => $phoneNumber) {
                $companyId = $companyIds[$index];
                $imeiNumber = $imeiNumbers[$index] ?? null;

                // Crear registro en la tabla `criminal_phone_numbers`
                criminal_phone_number::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                    'phone_number' => $phoneNumber,
                    'company_id' => $companyId,
                    'imei_number' => $imeiNumber,
                ]);
            }

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los registros de teléfonos se realizaron correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }


    public function store_arrest3(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            // Validar los datos principales
            $request->validate([
                'criminal_id' => 'required|exists:criminals,id', // ID de criminal es obligatorio
                'tool_type_id' => 'required|array', // Debe ser un array para manejar múltiples entradas
                'tool_type_id.*' => 'required', // Cada tipo de herramienta es obligatorio
                'tool_details' => 'required|array', // Detalles deben ser un array para múltiples entradas
                'tool_details.*' => 'required|string|max:255', // Cada detalle debe ser una cadena
            ]);

            // Iterar sobre cada entrada de herramienta/objeto
            foreach ($request->tool_type_id as $index => $toolTypeId) {
                // Comprobar si se seleccionó "otro" y agregarlo si es necesario
                if ($toolTypeId === 'other' && !empty($request->other_tool_type[$index])) {
                    $newTool = tools_type::create([
                        'tool_type_name' => $request->other_tool_type[$index],
                    ]);
                    $toolTypeId = $newTool->id; // Actualizar el ID del tipo de herramienta
                }

                // Crear registro en la tabla `criminal_tool`
                criminal_tool::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                    'tool_type_id' => $toolTypeId,
                    'tool_details' => $request->tool_details[$index],
                ]);
            }

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los Datos Fueron Registrados con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store_arrest4(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            $nationalityID = $request->nationality_id;

            // Verificar si seleccionó "Otro" y hay un valor en 'otra_nacionalidad'
            if ($nationalityID === 'otro' && $request->filled('otra_nacionalidad')) {
                $newNationality = Nationality::create([
                    'nationality_name' => $request->otra_nacionalidad,
                ]);
                $nationalityID = $newNationality->id; // Actualiza el ID con el de la nueva nacionalidad
            }
            // Crear registro en la tabla `criminals_aliases`
            criminal_aliase::create([
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                'alias_name' => $request->alias_name,
                'alias_identity_number' => $request->alias_identity_number,
                'nationality_id' => $nationalityID,
            ]);

            //Llenado Tabla paises
            // Manejo de País
            if ($request->filled('new_country_name')) {
                $country = Country::firstOrCreate(
                    ['country_name' => $request->new_country_name] // Buscar por nombre
                );
                $countryId = $country->id; // Usar el ID del país encontrado o creado
            } else {
                $countryId = $request->country_id; // Usar el ID del país seleccionado
            }

            // Manejo de Estado/Provincia
            if ($request->filled('new_state_name')) {
                $state = State::firstOrCreate(
                    [
                        'state_name' => $request->new_state_name, // Buscar por nombre
                        'country_id' => $countryId,              // Y por el país asociado
                    ]
                );
                $stateId = $state->id; // Usar el ID del estado encontrado o creado
            } else {
                $stateId = $request->province_id; // Usar el ID del estado seleccionado
            }

            // Manejo de Ciudad
            if ($request->filled('new_city_name')) {
                $city = City::firstOrCreate(
                    [
                        'city_name' => $request->new_city_name, // Buscar por nombre
                        'state_id' => $stateId,                // Y por el estado asociado
                    ]
                );
                $cityId = $city->id; // Usar el ID de la ciudad encontrada o creada
            } else {
                $cityId = $request->city_id; // Usar el ID de la ciudad seleccionada
            }

            criminal_address::create([
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                'country_id' => $countryId,
                'state_id' => $stateId,
                'city_id' => $cityId,
                'street' => $request->street,
            ]);

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los Datos Fueron Registrados con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
    public function store_arrest5(Request $request)
    {
        try {
            DB::beginTransaction();


            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            $vehicleTypeId = $request->type_id;
            if ($vehicleTypeId === 'other' && $request->filled('other_vehicle_type')) {
                $newVehicleType = vehicle_type::create([
                    'vehicle_type_name' => $request->other_vehicle_type,
                ]);
                $vehicleTypeId = $newVehicleType->id; // Actualiza el ID con el del nuevo tipo de vehículo
            }
            // Obtener o crear la relación
            $relationshipWithOwnerId = $request->relationship_with_owner_id;
            if ($relationshipWithOwnerId === 'other' && $request->filled('other_relationship')) {
                $newRelationship = relationship_with_owner::create([
                    'relationship_name' => $request->other_relationship,
                ]);
                $relationshipWithOwnerId = $newRelationship->id; // Actualiza el ID con el nuevo tipo de relación
            }

            $request->validate([
                'criminal_id' => 'required|exists:criminals,id',
                'arrest_and_apprehension_history_id' => 'nullable|exists:arrest_and_apprehension_histories,id',
                'vehicle_color_id' => 'required|exists:vehicle_colors,id',
                'type_id' => 'nullable',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'brand_id' => 'required|exists:brand_vehicles,id',
                'model' => 'required|string|max:255',
                'industry_id' => 'required|exists:industries,id',
                'license_plate' => 'required|string|max:20',
                'vehicle_service_id' => 'required|exists:vehicle_services,id',
                'details' => 'required|string|max:500',
                'itv_valid' => 'boolean',
                'user_name' => 'nullable|string|max:255',
                'user_ci' => 'nullable|string|max:20',
                'relationship_with_owner_id' => 'nullable',
                'observations' => 'nullable|string|max:500',
                'driver_name' => 'nullable|string|max:255',
                'other_vehicle_type' => 'nullable||string|max:30',
                'front_photo' => 'nullable|image|max:15360', // Máximo 15 MB (15360 KB)
                'left_side_photo' => 'nullable|image|max:15360',
                'right_side_photo' => 'nullable|image|max:15360',
                'rear_photo' => 'nullable|image|max:15360',
            ]);
            $imagenes = [
                'front_photo' => $request->file('front_photo'),
                'left_side_photo' => $request->file('left_side_photo'),
                'right_side_photo' => $request->file('right_side_photo'),
                'rear_photo' => $request->file('rear_photo')
            ];
            
            $destino_img = 'vehicle_photographs';
            $rutas = [];
            
            foreach ($imagenes as $key => $imagen) {
                if ($imagen) {
                    $filename = time() . '-' . $imagen->getClientOriginalName();
            
                    // Guarda en el disco `public` para que esté accesible en `storage/app/public/vehicle_photographs`
                    $path = $imagen->storeAs($destino_img, $filename, 'public');
            
                    // Genera una URL pública para acceder a la imagen
                    $rutas[$key] = Storage::url($path);
                } else {
                    $rutas[$key] = null;
                }
            }

            // Crear registro en la tabla `criminals`
            criminal_vehicle::create([
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                'vehicle_color_id' => $request->vehicle_color_id,
                'type_id' => $vehicleTypeId,
                'year' => $request->year,
                'brand_id' => $request->brand_id,
                'model' => $request->model,
                'industry_id' => $request->industry_id,
                'license_plate' => $request->license_plate,
                'vehicle_service_id' => $request->vehicle_service_id,
                'details' => $request->details,
                'itv_valid' => $request->itv_valid ?? 0,
                'user_name' => !empty($request->user_name) ? $request->user_name : null,
                'user_ci' => !empty($request->user_ci) ? $request->user_ci : null,
                'relationship_with_owner_id' => $relationshipWithOwnerId,
                'observations' => !empty($request->observations) ? $request->observations : null,
                'driver_name' => !empty($request->driver_name) ? $request->driver_name : null,
                'front_photo' => $rutas['front_photo'],
                'left_side_photo' => $rutas['left_side_photo'],
                'right_side_photo' => $rutas['right_side_photo'],
                'rear_photo' => $rutas['rear_photo']
            ]);

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Vehiculo Registrado con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store_arrest6(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            // Recorrer los arrays de cómplices y registrar cada uno de ellos
            $compliceNames = $request->complice_name;
            $compliceCIs = $request->CI_complice;
            $compliceDetails = $request->detail_complice;

            for ($i = 0; $i < count($compliceNames); $i++) {
                // Crear registro para cada cómplice
                criminal_complice::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                    'complice_name' => $compliceNames[$i],
                    'CI_complice' => $compliceCIs[$i],
                    'detail_complice' => $compliceDetails[$i],
                ]);
            }

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los Datos Fueron Registrados con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store_arrest7(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            // Verificar si se seleccionó "Otro" y crear nueva organización si es necesario
            $organizationId = $request->organization_id;
            if ($organizationId === "other" && $request->filled('other_organization')) {
                // Crear nueva organización
                $newOrganization = Organization::create([
                    'organization_name' => $request->other_organization,
                    'Criminal_Organization_Specialty' => $request->Criminal_Organization_Specialty,
                    // Agrega otros campos necesarios según tu tabla de `organizations`
                ]);
                $organizationId = $newOrganization->id;
            }

            // Crear registro en la tabla `criminal_organizations`
            criminal_organization::create([
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                'organization_id' => $organizationId, // Usar el ID de la nueva organización o el seleccionado
                'criminal_rol' => $request->criminal_rol,
            ]);

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los Datos Fueron Registrados con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function store_arrest8(Request $request)
    {
        try {
            DB::beginTransaction();

            $arrestAndApprehensionHistoryId = session('arrest_and_apprehension_history_id');

            // Verificar si el historial de arresto ya está asociado a otro criminal
            $existingHistory = null;
            if ($arrestAndApprehensionHistoryId) {
                $existingHistory = arrest_and_apprehension_history::where('id', $arrestAndApprehensionHistoryId)
                    ->where('criminal_id', '!=', $request->criminal_id)
                    ->first();
            }

            // Inicializar variables para los datos de la prisión
            $prisonID = $request->prison_name;
            if ($prisonID === "otro" && $request->filled('otra_prision_nombre')) {
                // Manejo de País
                if ($request->filled('new_country_name_p')) {
                    $country = Country::firstOrCreate(
                        ['country_name' => $request->new_country_name_p] // Buscar por nombre
                    );
                    $countryId = $country->id; // Usar el ID del país encontrado o creado
                } else {
                    $countryId = $request->country_id_p; // Usar el ID del país seleccionado
                }

                // Manejo de Estado/Provincia
                if ($request->filled('new_state_name_p')) {
                    $state = State::firstOrCreate(
                        [
                            'state_name' => $request->new_state_name_p, // Buscar por nombre
                            'country_id' => $countryId,                // Y por el país asociado
                        ]
                    );
                    $stateId = $state->id; // Usar el ID del estado encontrado o creado
                } else {
                    $stateId = $request->province_id_p; // Usar el ID del estado seleccionado
                }

                // Manejo de Ciudad
                if ($request->filled('new_city_name_p')) {
                    $city = City::firstOrCreate(
                        [
                            'city_name' => $request->new_city_name_p, // Buscar por nombre
                            'state_id' => $stateId,                  // Y por el estado asociado
                        ]
                    );
                    $cityId = $city->id; // Usar el ID de la ciudad encontrada o creada
                } else {
                    $cityId = $request->city_id_p; // Usar el ID de la ciudad seleccionada
                }

                // Crear nueva organización
                $Nprison = Prison::create([
                    'prison_name' => $request->otra_prision_nombre,
                    'prison_location' => $request->prison_location,
                    'country_id' => $countryId,
                    'state_id' => $stateId,
                    'city_id' => $cityId,
                ]);
                $prisonID = $Nprison->id;
            }

            // Crear el registro en la tabla `conviction`
            $condena = conviction::create([
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                'detention_type_id' => $request->detention_type_id,
            ]);

            // Llenar solo la tabla correspondiente según el tipo de detención
            switch ($request->detention_type_id) {
                case 1: // DETENCION PREVENTIVA
                    preventive_detention::create([
                        'criminal_id' => $request->criminal_id,
                        'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                        'conviction_id' => $condena->id,
                        'prison_id' => $prisonID,
                        'prison_entry_date' => $request->prison_entry_date,
                        'prison_release_date' => $request->prison_release_date,
                    ]);
                    break;

                case 2: // DETENCION DOMICILIARIA
                    // Manejo de País
                    if ($request->filled('new_country_name_d')) {
                        $country = Country::firstOrCreate(
                            ['country_name' => $request->new_country_name_d] // Buscar por nombre
                        );
                        $countryId = $country->id; // Usar el ID del país encontrado o creado
                    } else {
                        $countryId = $request->country_id_d; // Usar el ID del país seleccionado
                    }

                    // Manejo de Estado/Provincia
                    if ($request->filled('new_state_name_d')) {
                        $state = State::firstOrCreate(
                            [
                                'state_name' => $request->new_state_name_d, // Buscar por nombre
                                'country_id' => $countryId,                // Y por el país asociado
                            ]
                        );
                        $stateId = $state->id; // Usar el ID del estado encontrado o creado
                    } else {
                        $stateId = $request->province_id_d; // Usar el ID del estado seleccionado
                    }

                    // Manejo de Ciudad
                    if ($request->filled('new_city_name_d')) {
                        $city = City::firstOrCreate(
                            [
                                'city_name' => $request->new_city_name_d, // Buscar por nombre
                                'state_id' => $stateId,                  // Y por el estado asociado
                            ]
                        );
                        $cityId = $city->id; // Usar el ID de la ciudad encontrada o creada
                    } else {
                        $cityId = $request->city_id_d; // Usar el ID de la ciudad seleccionada
                    }

                    house_arrest::create([
                        'criminal_id' => $request->criminal_id,
                        'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                        'conviction_id' => $condena->id,
                        'house_arrest_address' => $request->house_arrest_address,
                        'country_id' => $request->country_id_d,
                        'state_id' => $request->province_id_d,
                        'city_id' => $request->city_id_d,

                    ]);
                    break;

                case 3: // EXTRADICION
                    // Manejo de País
                    if ($request->filled('new_country_name_e')) {
                        $country = Country::firstOrCreate(
                            ['country_name' => $request->new_country_name_e] // Buscar por nombre
                        );
                        $countryId = $country->id; // Usar el ID del país encontrado o creado
                    } else {
                        $countryId = $request->country_id_e; // Usar el ID del país seleccionado
                    }

                    // Manejo de Estado/Provincia
                    if ($request->filled('new_state_name_e')) {
                        $state = State::firstOrCreate(
                            [
                                'state_name' => $request->new_state_name_e, // Buscar por nombre
                                'country_id' => $countryId,                // Y por el país asociado
                            ]
                        );
                        $stateId = $state->id; // Usar el ID del estado encontrado o creado
                    } else {
                        $stateId = $request->province_id_e; // Usar el ID del estado seleccionado
                    }

                    extradition::create([
                        'criminal_id' => $request->criminal_id,
                        'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                        'conviction_id' => $condena->id,
                        'extradition_date' => $request->extradition_date,
                        'country_id' => $request->country_id_e,
                        'state_id' => $request->province_id_e,
                    ]);
                    break;

                case 4: // 
                    // Manejo de País
                    if ($request->filled('new_country_name_l')) {
                        $country = Country::firstOrCreate(
                            ['country_name' => $request->new_country_name_l] // Buscar por nombre
                        );
                        $countryId = $country->id; // Usar el ID del país encontrado o creado
                    } else {
                        $countryId = $request->country_id_l; // Usar el ID del país seleccionado
                    }

                    // Manejo de Estado/Provincia
                    if ($request->filled('new_state_name_l')) {
                        $state = State::firstOrCreate(
                            [
                                'state_name' => $request->new_state_name_l, // Buscar por nombre
                                'country_id' => $countryId,                // Y por el país asociado
                            ]
                        );
                        $stateId = $state->id; // Usar el ID del estado encontrado o creado
                    } else {
                        $stateId = $request->province_id_l; // Usar el ID del estado seleccionado
                    }

                    // Manejo de Ciudad
                    if ($request->filled('new_city_name_l')) {
                        $city = City::firstOrCreate(
                            [
                                'city_name' => $request->new_city_name_l, // Buscar por nombre
                                'state_id' => $stateId,                  // Y por el estado asociado
                            ]
                        );
                        $cityId = $city->id; // Usar el ID de la ciudad encontrada o creada
                    } else {
                        $cityId = $request->city_id_l; // Usar el ID de la ciudad seleccionada
                    }

                    liberty::create([
                        'criminal_id' => $request->criminal_id,
                        'arrest_and_apprehension_history_id' => $existingHistory ? null : $arrestAndApprehensionHistoryId,
                        'conviction_id' => $condena->id,
                        'country_id' => $countryId,
                        'state_id' => $stateId,
                        'city_id' => $cityId,
                        'house_address' => $request->house_address,
                    ]);
                    break;
            }

            // Confirmar la transacción
            DB::commit();

            // Enviar respuesta JSON de éxito
            return response()->json(['success' => true, 'message' => 'Los Datos Fueron Registrados con Exito.']);
        } catch (\Exception $e) {
            DB::rollBack();

            // Enviar respuesta JSON de error
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function edit_condena($criminal_id, $history_id)
    {
        // Lógica para editar condena
        $criminal = Criminal::findOrFail($criminal_id);
        $history = arrest_and_apprehension_history::findOrFail($history_id);
        $pais = country::all();
        $ciudad = city::all();
        $provincia = state::all();
        $tcondena = detention_type::all();
        $prision = Prison::with(['country', 'state', 'city'])->get();

        return view('criminals.edit_condena', compact('criminal', 'history', 'pais', 'provincia', 'ciudad', 'tcondena', 'prision'));
    }

    public function update_condena(Request $request, $criminal_id, $history_id)
{
    try {
        DB::beginTransaction();

        // Verificar si el historial de arresto ya está asociado a otro criminal
        $session_history_id = session('arrest_and_apprehension_history_id');
        $existingHistory = null;

        // Usar el history_id del parámetro de la ruta, no el de la sesión
        $final_history_id = $history_id;

        if ($session_history_id) {
            $existingHistory = arrest_and_apprehension_history::where('id', $session_history_id)
                ->where('criminal_id', '!=', $request->criminal_id)
                ->first();
        }

        // Verificar si se han recibido datos esenciales para proceder
        if (!$request->has('detention_type_id') || !$request->has('criminal_id')) {
            return response()->json(['success' => false, 'message' => 'Debe proporcionar todos los datos necesarios.']);
        }

        // Inicializar variables para los datos de la prisión
        $prisonID = $request->prison_name;
        if ($prisonID === "otro" && $request->filled('otra_prision_nombre')) {
            // Manejo de País
            if ($request->filled('new_country_name_p')) {
                $country = Country::firstOrCreate(
                    ['country_name' => $request->new_country_name_p]
                );
                $countryId = $country->id;
            } else {
                $countryId = $request->country_id_p;
            }

            // Manejo de Estado/Provincia
            if ($request->filled('new_state_name_p')) {
                $state = State::firstOrCreate(
                    [
                        'state_name' => $request->new_state_name_p,
                        'country_id' => $countryId,
                    ]
                );
                $stateId = $state->id;
            } else {
                $stateId = $request->province_id_p;
            }

            // Manejo de Ciudad
            if ($request->filled('new_city_name_p')) {
                $city = City::firstOrCreate(
                    [
                        'city_name' => $request->new_city_name_p,
                        'state_id' => $stateId,
                    ]
                );
                $cityId = $city->id;
            } else {
                $cityId = $request->city_id_p;
            }

            // Crear nueva prisión
            $Nprison = Prison::create([
                'prison_name' => $request->otra_prision_nombre,
                'prison_location' => $request->prison_location,
                'country_id' => $countryId,
                'state_id' => $stateId,
                'city_id' => $cityId,
            ]);
            $prisonID = $Nprison->id;
        }

        // Crear o actualizar el registro en la tabla `conviction`
        $condena = conviction::updateOrCreate(
            [
                'criminal_id' => $request->criminal_id,
                'arrest_and_apprehension_history_id' => $existingHistory ? null : $final_history_id,
                'detention_type_id' => $request->detention_type_id,
            ]
        );

        // Llenar solo la tabla correspondiente según el tipo de detención
        switch ($request->detention_type_id) {
            case 1: // DETENCION PREVENTIVA
                preventive_detention::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $final_history_id,
                    'conviction_id' => $condena->id,
                    'prison_id' => $prisonID,
                    'prison_entry_date' => $request->prison_entry_date,
                    'prison_release_date' => $request->prison_release_date,
                ]);
                break;

            case 2: // DETENCION DOMICILIARIA
                // Manejo de País para detención domiciliaria
                if ($request->filled('new_country_name_d')) {
                    $country = Country::firstOrCreate(
                        ['country_name' => $request->new_country_name_d]
                    );
                    $countryId_d = $country->id;
                } else {
                    $countryId_d = $request->country_id_d;
                }

                // Manejo de Estado/Provincia para detención domiciliaria
                if ($request->filled('new_state_name_d')) {
                    $state = State::firstOrCreate(
                        [
                            'state_name' => $request->new_state_name_d,
                            'country_id' => $countryId_d,
                        ]
                    );
                    $stateId_d = $state->id;
                } else {
                    $stateId_d = $request->province_id_d;
                }

                // Manejo de Ciudad para detención domiciliaria
                if ($request->filled('new_city_name_d')) {
                    $city = City::firstOrCreate(
                        [
                            'city_name' => $request->new_city_name_d,
                            'state_id' => $stateId_d,
                        ]
                    );
                    $cityId_d = $city->id;
                } else {
                    $cityId_d = $request->city_id_d;
                }

                house_arrest::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $final_history_id,
                    'conviction_id' => $condena->id,
                    'house_arrest_address' => $request->house_arrest_address,
                    'country_id' => $countryId_d,
                    'state_id' => $stateId_d,
                    'city_id' => $cityId_d,
                ]);
                break;

            case 3: // EXTRADICION
                // Manejo de País para extradición
                if ($request->filled('new_country_name_e')) {
                    $country = Country::firstOrCreate(
                        ['country_name' => $request->new_country_name_e]
                    );
                    $countryId_e = $country->id;
                } else {
                    $countryId_e = $request->country_id_e;
                }

                // Manejo de Estado/Provincia para extradición
                if ($request->filled('new_state_name_e')) {
                    $state = State::firstOrCreate(
                        [
                            'state_name' => $request->new_state_name_e,
                            'country_id' => $countryId_e,
                        ]
                    );
                    $stateId_e = $state->id;
                } else {
                    $stateId_e = $request->province_id_e;
                }

                extradition::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $final_history_id,
                    'conviction_id' => $condena->id,
                    'extradition_date' => $request->extradition_date,
                    'country_id' => $countryId_e,
                    'state_id' => $stateId_e,
                ]);
                break;

            case 4: // LIBERTAD
                // Manejo de País para libertad
                if ($request->filled('new_country_name_l')) {
                    $country = Country::firstOrCreate(
                        ['country_name' => $request->new_country_name_l]
                    );
                    $countryId_l = $country->id;
                } else {
                    $countryId_l = $request->country_id_l;
                }

                // Manejo de Estado/Provincia para libertad
                if ($request->filled('new_state_name_l')) {
                    $state = State::firstOrCreate(
                        [
                            'state_name' => $request->new_state_name_l,
                            'country_id' => $countryId_l,
                        ]
                    );
                    $stateId_l = $state->id;
                } else {
                    $stateId_l = $request->province_id_l;
                }

                // Manejo de Ciudad para libertad
                if ($request->filled('new_city_name_l')) {
                    $city = City::firstOrCreate(
                        [
                            'city_name' => $request->new_city_name_l,
                            'state_id' => $stateId_l,
                        ]
                    );
                    $cityId_l = $city->id;
                } else {
                    $cityId_l = $request->city_id_l;
                }

                liberty::create([
                    'criminal_id' => $request->criminal_id,
                    'arrest_and_apprehension_history_id' => $existingHistory ? null : $final_history_id,
                    'conviction_id' => $condena->id,
                    'country_id' => $countryId_l,
                    'state_id' => $stateId_l,
                    'city_id' => $cityId_l,
                    'house_address' => $request->house_address,
                ]);
                break;
        }

        // Confirmar la transacción
        DB::commit();

        // Redirigir con un mensaje de éxito usando el $final_history_id
        return redirect()->route('criminals.history', [
            'criminal_id' => $criminal_id,
            'history_id' => $final_history_id
        ])->with('success', 'Se agregó correctamente.');

    } catch (\Exception $e) {
        // Rollback en caso de error
        DB::rollBack();

        // Enviar respuesta JSON de error
        return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
    }
}
}

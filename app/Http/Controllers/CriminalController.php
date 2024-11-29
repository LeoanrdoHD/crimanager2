<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\apprehension_type;
use App\Models\arrest_and_apprehension_history;
use App\Models\city;
use App\Models\civil_state;
use App\Models\company;
use App\Models\confleccion;
use App\Models\country;
use App\Models\criminal;
use App\Models\criminal_address;
use App\Models\criminal_gender;
use App\Models\criminal_organization;
use App\Models\relationship_type;
use App\Models\criminal_partner;
use Illuminate\Support\Facades\Storage;

use App\Models\criminal_specialty;
use App\Models\ear_type;
use App\Models\eye_type;
use App\Models\legal_statuse;
use App\Models\lip_type;
use App\Models\nationality;
use App\Models\nose_type;
use App\Models\ocupation;
use App\Models\organization;
use App\Models\photograph;
use App\Models\physical_characteristic;
use App\Models\state;
use App\Models\skin_color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class CriminalController extends Controller
{
    public function create_criminal()
    {
        $civil_s = civil_state::all();
        $pais = country::all();
        $ciudad = city::all();
        $provincia = state::all();
        $nacionalidad = nationality::all();
        $t_relacion = relationship_type::all();
        $criminals = criminal::get();
        $date_crimi = criminal::all();
        $lstatus = legal_statuse::all();
        $t_aprehe = apprehension_type::all();
        $cri_esp = criminal_specialty::all();
        $ocupacion = ocupation::all();
        $conflexion = confleccion::all();
        $color = skin_color::all();
        $genero = criminal_gender::all();
        $ojos = eye_type::all();
        $naris = nose_type::all();
        $labios = lip_type::all();
        $orejas = ear_type::all();
        $compania = company::all();
        $date_criminal = criminal::get();
        return view('criminals.create_criminal', compact('civil_s', 'pais', 'ciudad', 't_relacion', 'date_crimi', 'lstatus', 't_aprehe', 'cri_esp', 'nacionalidad', 'ocupacion', 'conflexion', 'color', 'genero', 'ojos', 'naris', 'labios', 'orejas', 'provincia', 'compania'))->with('criminals', $criminals);
    }

    public function store_criminal(Request $request)
    {

        try {
            $request->validate([
                'first_name' => 'required|string|min:3|max:80',
                'last_nameP' => 'nullable|string|min:1|max:40',
                'last_nameM' => 'nullable|string|min:1|max:40',
                'identity_number' => 'required|string|max:20|unique:criminals,identity_number',
                'date_of_birth' => 'required|date|before:today',
                'age' => 'nullable|integer|min:0|max:120',
                'country_id' => 'required',
                'city_id' => 'required',
                'state_id' => 'string|max:60',
                'nationality_id' => 'required',
                'civil_state_id' => 'required|exists:civil_states,id',
                'alias_name' => 'nullable|string|min:3|max:60',
                'ocupation_id' => 'required',
                'street' => 'string|max:255',
                'partner_name' => 'nullable|string|min:5|max:120',
                'relationship_type_id' => 'nullable|exists:relationship_types,id',
                'partner_address' => 'nullable|string|min:5|max:255',
                'height' => 'required|numeric|min:110|max:210',
                'weight' => 'required|numeric|min:35|max:120',
                'confleccion_id' => 'required',
                'skin_color_id' => 'required',
                'sex' => 'required|in:MASCULINO,FEMENINO',
                'criminal_gender_id' => 'required',
                'eye_type_id' => 'required',
                'nose_type_id' => 'required',
                'lip_type_id' => 'required',
                'ear_type_id' => 'required',
                'distinctive_marks' => 'nullable|string|max:255',
                'face_photo' => 'required|image|mimes:jpg,jpeg,png|max:4000',
                'profile_izq_photo' => 'required|image|mimes:jpg,jpeg,png|max:4000',
                'full_body_photo' => 'required|image|mimes:jpg,jpeg,png|max:4000',
                'frontal_photo' => 'required|image|mimes:jpg,jpeg,png|max:4000',
                'profile_der_photo' => 'required|image|mimes:jpg,jpeg,png|max:4000',
                'aditional_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4000',
                'barra_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:4000',
                'otra_ocupacion' => 'nullable|string',
            ]);
            DB::beginTransaction();
            // Crear registro en la tabla `criminals`
            $nationalityID = $request->nationality_id;
            // Verificar si seleccionó "Otro" y hay un valor en 'otra_nacionalidad'
            if ($nationalityID === 'otro' && $request->filled('otra_nacionalidad')) {
                $newNationality = Nationality::create([
                    'nationality_name' => $request->otra_nacionalidad,
                ]);
                $nationalityID = $newNationality->id; // Actualiza el ID con el de la nueva nacionalidad
            }

            $ocupationID = $request->ocupation_id;
            // Verificar si seleccionó "Otra" y hay un valor en 'otra_ocupacion'
            if ($ocupationID === 'otra' && $request->filled('otra_ocupacion')) {
                $newOcupation = Ocupation::create([
                    'ocupation_name' => $request->otra_ocupacion,
                ]);
                $ocupationID = $newOcupation->id; // Actualiza el ID con el de la nueva ocupación
            }
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
                $stateId = $request->state_id; // Usar el ID del estado seleccionado
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

            $crimi = Criminal::create([
                'first_name' => $request->first_name,
                'last_nameP' => $request->last_nameP ?: ' ',
                'last_nameM' => $request->last_nameM ?: ' ',
                'identity_number' => $request->identity_number,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'country_id' => $countryId,
                'state_id' => $stateId,
                'city_id' => $cityId,
                //'is_member_of_criminal_organization'=> $request->is_member_of_criminal_organization,
                //'use_vehicle'=> $request->use_vehicle,
                'civil_state_id' => $request->civil_state_id,
                'nationality_id' => $nationalityID,
                'alias_name' => $request->alias_name,
                'ocupation_id' => $ocupationID,
            ]);

            // Manejo de País
            if ($request->filled('new_country_name_a')) {
                $country = Country::firstOrCreate(
                    ['country_name' => $request->new_country_name_a] // Buscar por nombre
                );
                $countryId = $country->id; // Usar el ID del país encontrado o creado
            } else {
                $countryId = $request->country_id_a; // Usar el ID del país seleccionado
            }

            // Manejo de Estado/Provincia
            if ($request->filled('new_state_name_a')) {
                $state = State::firstOrCreate(
                    [
                        'state_name' => $request->new_state_name_a, // Buscar por nombre
                        'country_id' => $countryId,                // Y por el país asociado
                    ]
                );
                $stateId = $state->id; // Usar el ID del estado encontrado o creado
            } else {
                $stateId = $request->state_id_a; // Usar el ID del estado seleccionado
            }

            // Manejo de Ciudad
            if ($request->filled('new_city_name_a')) {
                $city = City::firstOrCreate(
                    [
                        'city_name' => $request->new_city_name_a, // Buscar por nombre
                        'state_id' => $stateId,                  // Y por el estado asociado
                    ]
                );
                $cityId = $city->id; // Usar el ID de la ciudad encontrada o creada
            } else {
                $cityId = $request->city_id_a; // Usar el ID de la ciudad seleccionada
            }

            // Crear registro en la tabla `criminal_addresses`
            criminal_address::create([
                'criminal_id' => $crimi->id,
                // Asegúrate de que exista en el request si se usa
                'country_id' => $countryId,
                'city_id' => $cityId,
                'state_id' => $stateId,
                'street' => $request->street,
            ]);

            criminal_partner::create([
                'criminal_id' => $crimi->id,
                'partner_name' => $request->partner_name,
                'relationship_type_id' => $request->relationship_type_id,
                'partner_address' => $request->partner_address,
                //'city_id' => $request->city_id, // Asegúrate de que exista en el request si se usa
                //'nationality_id' => $request->nationality_id,
            ]);

            physical_characteristic::create([
                'criminal_id' => $crimi->id,
                'weight' => $request->weight,
                'height' => $request->height,
                'confleccion_id' => $request->confleccion_id,
                'skin_color_id' => $request->skin_color_id,
                'sex' => $request->sex,
                'criminal_gender_id' => $request->criminal_gender_id,
                'eye_type_id' => $request->eye_type_id,
                'ear_type_id' => $request->ear_type_id,
                'lip_type_id' => $request->lip_type_id,
                'nose_type_id' => $request->nose_type_id,
                'distinctive_marks' => $request->distinctive_marks,
            ]);

            $imagenes = [
                'face_photo' => $request->file('face_photo'),
                'frontal_photo' => $request->file('frontal_photo'),
                'full_body_photo' => $request->file('full_body_photo'),
                'profile_izq_photo' => $request->file('profile_izq_photo'),
                'profile_der_photo' => $request->file('profile_der_photo'),
                'aditional_photo' => $request->file('aditional_photo'),
                'barra_photo' => $request->file('barra_photo')
            ];

            $destino_img = 'fotos_criminal/';
            $rutas = [];

            foreach ($imagenes as $key => $imagen) {
                if ($imagen) {
                    $filename = time() . '-' . $imagen->getClientOriginalName();

                    // Guarda en el disco `public` para que esté accesible en `storage/app/public/fotos_criminal`
                    $path = $imagen->storeAs($destino_img, $filename, 'public');

                    // Genera una URL pública para acceder a la imagen
                    $rutas[$key] = Storage::url($path);
                } else {
                    $rutas[$key] = null;
                }
            }

            // Crear el registro en la base de datos
            Photograph::create([
                'criminal_id' => $crimi->id,
                'face_photo' => $rutas['face_photo'],
                'frontal_photo' => $rutas['frontal_photo'],
                'full_body_photo' => $rutas['full_body_photo'],
                'profile_izq_photo' => $rutas['profile_izq_photo'],
                'profile_der_photo' => $rutas['profile_der_photo'],
                'aditional_photo' => $rutas['aditional_photo'],
                'barra_photo' => $rutas['barra_photo'],
            ]);

            // Confirmar la transacción
            DB::commit();
            return redirect()->route('criminals.search_cri')->with('success', 'Perfil creado con éxito');
            // Confirmar la transacción
        } catch (\Exception $e) {
            DB::rollBack();

            // Redirigir de vuelta con el mensaje de error
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}

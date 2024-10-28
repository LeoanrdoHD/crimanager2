<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\civil_state;
use App\Models\criminal;
use App\Models\criminal_address;
use App\Models\relationship_type;
use App\Models\criminal_partner;
use App\Models\criminal_speciality;
use App\Models\nationality;
use App\Models\photograph;
use App\Models\physical_characteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class CriminalController extends Controller
{
    public function create_criminal()
    {
        $civil_s = civil_state::all();
        $pais = nationality::all();
        $ciudad = city::all();
        $t_relacion = relationship_type::all();
        $criminals = criminal::get();
        return view('criminals.create_criminal',compact('civil_s','pais','ciudad','t_relacion'))->with('criminals', $criminals);
    }
    /**public function create_od()
    {
        $civil_s = civil_state::all();
        $criminal_spe = criminal_speciality::all();
        return view('criminals.create_criminal',compact('civil_s'));
    }**/

    public function search_criminal()
    {
        $criminals = criminal::all();
        return view('criminals.search_criminal', compact('criminals'));
    }
    public function store_criminal(Request $request)
    {
        try {
            DB::beginTransaction();

            // Crear registro en la tabla `criminals`
            $crimi = Criminal::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'identity_number' => $request->identity_number,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                //'is_member_of_criminal_organization'=> $request->is_member_of_criminal_organization,
                //'use_vehicle'=> $request->use_vehicle,
                'civil_state_id'=> $request->civil_state_id,
                'nationality_id'=> $request->nationality_id,
                //'criminal_specialty_id'=> $request->criminal_specialty_id,
            ]);

            // Crear registro en la tabla `criminal_addresses`
            criminal_address::create([
                'criminal_id' => $crimi->id,
                'street' => $request->street,
                'city_id' => $request->city_id, // Asegúrate de que exista en el request si se usa
                'nationality_id' => $request->nationality_id,
            ]);

            criminal_partner::create([
                'criminal_id' => $crimi->id,
                'partner_name' => $request->partner_name,
                'partner_ci' => $request->partner_ci,
                'relationship_type_id'=> $request->relationship_type_id,
                'partner_address' => $request->partner_address,
                //'city_id' => $request->city_id, // Asegúrate de que exista en el request si se usa
                //'nationality_id' => $request->nationality_id,
            ]);

            physical_characteristic::create([
                'criminal_id' => $crimi->id,
                'weight' => $request->weight,
                'height' => $request->height,
                'sex' => $request->sex,
                //'criminal_gender_id'=> $request->criminal_gender_id,
                //'skin_color_id'=> $request->skin_color_id,
                //'eye_type_id'=> $request->eye_type_id,
                //'ear_type_id'=> $request->ear_type_id,
                //'lip_type_id'=> $request->plip_type_id,
                //'nose_type_id'=> $request->nose_type_id,
                'complexion' => $request->complexion,
                'distinctive_marks' => $request->distinctive_marks,
            ]);
            photograph::create([
                'criminal_id' => $crimi->id,
                'frontal_photo' => $request->frontal_photo,
                'full_body_photo' => $request->full_body_photo,
                'profile_izq_photo' => $request->profile_izq_photo,
                'profile_der_photo' => $request->profile_der_photo,
            ]);

            // Confirmar la transacción
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'El registro se realizó correctamente.',
            ], 200);
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            // Manejar o registrar el error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function create_arrest()
    {
        return view('criminals.create_arrest');
    }
    public function search_arrest()
    {
        $criminals = criminal::all();
        return view('criminals.search_arrest', compact('criminals'));
    }
    public function store_arrest(Request $request)
    {
        return $request->all();
    }
}

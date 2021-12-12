<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Symptom;
use App\Model\SymptomSpecialty;
use App\Model\Specialty;

use Validator;
use Carbon\Carbon;
use DB;

class AdminSymptomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $symptoms = Symptom::all();
        $specialties = Specialty::pluck('specialty', 'id');

        $symptom_specialty_all = SymptomSpecialty::all();
        $symptom_specialty = array();
        foreach ($symptom_specialty_all as $value) {
            if (!array_key_exists($value->symptom_id, $symptom_specialty)) {
                $symptom_specialty[$value->symptom_id] = array();
            }
            array_push($symptom_specialty[$value->symptom_id], $specialties[$value->specialty_id]);
        }

        return view('admin.symptoms.index', [
                    'symptoms' => $symptoms,
                    'specialties' => $symptom_specialty
                ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::pluck('specialty', 'id');
        return view('admin.symptoms.add')
                    ->with('specialties',$specialties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'     => 'required',
            'specialties' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/symptom/create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $symptom = new Symptom;
        $symptom->symptoms = $request->name;
        $symptom->save();

        $symptom_id = $symptom->id;

        foreach ($request->specialties as $specialty_id) {
            $symptom_specialty = new SymptomSpecialty;
            $symptom_specialty->symptom_id = $symptom_id;
            $symptom_specialty->specialty_id = (int)$specialty_id;
            $symptom_specialty->save();
            unset($symptom_specialty);
        }

        return redirect('admin/symptom');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
           return redirect('admin/symptom');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $symptom = Symptom::find($id);
        $specialties = Specialty::pluck('specialty', 'id');
        $symptom_specialties = SymptomSpecialty::where('symptom_id', $id)->pluck('specialty_id');
        return view('admin.symptoms.edit', [
                'symptom' => $symptom,
                'specialties' => $specialties,
                'symptom_specialties' => $symptom_specialties
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required',
            'specialties' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/symptom/'.$id.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        $symptom = Symptom::find($id);
        $symptom->symptoms = $request->name;
        $symptom->save();

        $symptom_id = $id;

        $symptoms_specialty = SymptomSpecialty::where('symptom_id', $symptom_id)->pluck('specialty_id');

        foreach ($symptoms_specialty as $value) {
            $symptom_specialty[] = $value;
        }

        $specialties_to_add = array_diff($request->specialties, $symptom_specialty);
        $specialties_to_delete = array_diff($symptom_specialty, $request->specialties);

        $delete_query = SymptomSpecialty::where('symptom_id', $symptom_id)
                                            ->whereIn('specialty_id', $specialties_to_delete)
                                            ->delete();

        foreach ($specialties_to_add as $specialty_id) {
            $symptom_specialty = new SymptomSpecialty;
            $symptom_specialty->symptom_id = $symptom_id;
            $symptom_specialty->specialty_id = (int)$specialty_id;
            $symptom_specialty->save();
            unset($symptom_specialty);
        }

        return redirect('admin/symptom');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try{
            // Delete the link between specialty and symptom
            SymptomSpecialty::where('symptom_id', $id)->delete();

            // Delete the symptom
            Symptom::find($id)->delete();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
        }

        return redirect('admin/symptom');
    }
}

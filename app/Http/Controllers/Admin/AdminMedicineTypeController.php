<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\MedicineType;
use App\Model\Doctor\DoctorMedicineType;

use Validator;
use Carbon\Carbon;
use DB;

class AdminMedicineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicine_types = MedicineType::all();
        return view('admin.medicine-type.index')
                ->with('medicine_types', $medicine_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'medicine_type'     => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/medicine-types')
                    ->withErrors($validator)
                    ->withInput();
        }

        $medicine_type = new MedicineType();
        $medicine_type->medicine_type = $request->medicine_type;
        $medicine_type->save();

        return redirect('admin/medicine-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        
    }*/

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
            'medicine_type_new'     => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/medicine-types')
                    ->withErrors($validator)
                    ->withInput();
        }

        $medicine_type = MedicineType::find($id);
        $medicine_type->medicine_type = $request->medicine_type_new;
        $medicine_type->save();

        return redirect('admin/medicine-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            
            $medicine_type = MedicineType::find($id);

            // Check if any doctor associated with specialty
            $doctor_count = DoctorMedicineType::where('medicine_type_id', $id)->count();
            if ($doctor_count > 0) {
                return redirect('admin/medicine-types')->with('error', 'Cannot remove medicine type already associated with a doctor');
            }

            $medicine_type->delete();

            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
        }

        return redirect('admin/medicine-types')->with('status', 'Medicine Type Deleted');
    }
}

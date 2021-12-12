<?php

namespace App\Http\Controllers\Caregiver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Socialite;
use App\Model\Doctor;
use App\Model\Patient\PatientProfile;
use App\Model\TenantDetail;
use App\Model\Tenant\OrganisationDetail;

use Illuminate\Support\Facades\Validator;
use DB;


class OrganisationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=OrganisationDetail::with('user','parent_user')->where('parent_user_id', Auth::id())->orderby('id','DESC')->get();
        return view('caregiver.organisation.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('caregiver.organisation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
          $this->validate($request,[
             'mobile_no' => 'required|numeric|digits:10|unique:users',
             'email' => 'required|email|max:191|unique:users',
             'name'=>'required'
          ]);
         try{
            DB::beginTransaction();
            $user = new User;
            $user->shdct_user_id = substr(number_format(time() * rand(),0,'',''),0,6);
            $user->user_role = '10';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->password = bcrypt(123456);
            $user->save();
            $user->shdct_user_id = 'C2PORG'.$user->id;
            $user->is_self = 0;
            $user->save();

            // Create 
            $OrganisationDetail = new OrganisationDetail;
            $OrganisationDetail->parent_user_id = Auth::id();
            $OrganisationDetail->user_id = $user->id;
            $OrganisationDetail->concern_person =$request->name;
            $OrganisationDetail->concern_person_mobile =$request->mobile_no;
             
            $rs = $OrganisationDetail->save();
            DB::commit();
           
            
           return redirect('caregiver/organisation')->with('success','Organisation Added successfully!');
        }
        catch(\Exception $e){
             //dd($e);
            DB::rollback();
            alert()->error('Something Went Wrong', 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user=OrganisationDetail::with('user','parent_user')->where('parent_user_id', Auth::id())->where('id',$id)->first();
         return view('caregiver.organisation.create',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$pid)
    {
         
          $this->validate($request,[
                'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no, ' .$pid,
                'email' => 'required|email|max:191|unique:users,email, ' .$pid,
                'name'=>'required'
          ]);
          try{
            DB::beginTransaction();
            
            $OrganisationDetail = OrganisationDetail::find($id);
            $OrganisationDetail->parent_user_id = Auth::id();
            $OrganisationDetail->concern_person =$request->name;
            $OrganisationDetail->concern_person_mobile =$request->mobile_no;
            $OrganisationDetail->save();
            $user = User::find($pid);
           
            $user->user_role = '10';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->save();
            DB::commit();
           
            
           return redirect('caregiver/organisation')->with('success','Organisation updated successfully!');
        }
        catch(\Exception $e){
               
            DB::rollback();
            alert()->error('Something Went Wrong', 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

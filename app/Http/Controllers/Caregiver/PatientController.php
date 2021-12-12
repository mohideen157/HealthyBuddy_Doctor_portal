<?php

namespace App\Http\Controllers\Caregiver;
use App\Helpers\Helper;
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
use Redirect;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orgid=OrganisationDetail::where('parent_user_id', Auth::id())->pluck('id');
        
        $user=User::with('patientProfile')->where('user_role',4)->where('organisation_id', [Auth::id()])->orderby('id','DESC')->get();
        return view('caregiver.patient.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $org=OrganisationDetail::where('parent_user_id', Auth::id())->pluck('concern_person','id');

         return view('caregiver.patient.create',compact('org'));
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

          $mobile='91'.$request->mobile_no;
          $rs=User::where('mobile_no', $mobile)->first();
          if(!is_null($rs))
          {
           return Redirect::back()->withErrors(['Mobile No. Already used']);
          }

         try{
            DB::beginTransaction();
            $pwd=mt_rand(1000, 9999);
            $user = new User;
            $user->shdct_user_id = substr(number_format(time() * rand(),0,'',''),0,6);
            $user->user_role = '4';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = '91'.$request->mobile_no;
            $user->organisation_id =Auth::id();
            $user->password = bcrypt($pwd);
            $user->is_self = 1;
            $user->save();
            $user->shdct_user_id = 'C2PDR'.$user->id;
            
            $user->save();

            // Create 
            $PatientProfile = new PatientProfile;
            $PatientProfile->patient_id = $user->id;
            $PatientProfile->gender = '';
            $PatientProfile->height_feet = '';
            $PatientProfile->height_inch = '';
            $PatientProfile->blood_group = '';
            $PatientProfile->dob = '';
            $rs = $PatientProfile->save();
            
           $data['recipient_no']=$request->mobile_no;
           $data['msgtxt']="Thank you for being registered in Cover2Protect.Please download the APP from the below link https://play.google.com/store/apps/details?id=indg.com.cover2protect&hl=en .Please login through your mobile number and password: $pwd";
           $sendsms=Helper::sendSMS($data);
           
           $data['msgtxt']="Thank you for being registered in Cover2Protect.Please download the APP from the below link <a href='https://play.google.com/store/apps/details?id=indg.com.cover2protect&hl=en'>Download</a> .Please login through your mobile number and password $pwd ";
           $mobile='91'.$request->mobile_no;
           $sendmail = Helper::apk($mobile,$data);
            DB::commit();
           return redirect('caregiver/patient')->with('success','Patient Added successfully!');
        }
        catch(\Exception $e){
            dd($e);
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
        $user=User::with('patientProfile')->where('user_role',4)->where('id',$id)->first();
        $org=OrganisationDetail::where('parent_user_id', Auth::id())->pluck('concern_person','id');
         return view('caregiver.patient.create',compact('user','org'));
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
         //dd($request->all());
          $this->validate($request,[
                'mobile_no' => 'required|numeric|digits:10|unique:users,mobile_no, ' .$id,
                'email' => 'required|email|max:191|unique:users,email, ' .$id,
                'name'=>'required'
          ]);
          try{
            DB::beginTransaction();
            $user = User::find($id);
            $user->shdct_user_id = substr(number_format(time() * rand(),0,'',''),0,6);
            $user->user_role = '4';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->organisation_id = $request->organisation_id;
            $user->save();
            
            

            // Create 
            $PatientProfile =PatientProfile::where('patient_id',$id)->first();
            $PatientProfile->patient_id = $user->id;
            $PatientProfile->gender = '';
            $PatientProfile->height_feet = '';
            $PatientProfile->height_inch = '';
            $PatientProfile->blood_group = '';
            $PatientProfile->dob = '';
            $rs = $PatientProfile->save();
            DB::commit();
           
            
           return redirect('caregiver/patient')->with('success','Patient updated successfully!');
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

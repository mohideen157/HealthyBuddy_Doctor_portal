<?php 

namespace Myaibud\Controllers;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use Socialite;
use App\Model\Doctor;
use App\Model\TenantDetail;
use App\Model\Doctor\DocSpecialization;
use App\Model\Doctor\DoctorSpecialization;
use App\Model\Tenant\OrganisationDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Redirect;
 
class HomeController extends Controller
{

    public function index()
    {
        return "Archito Testing..";
    }
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
   public function register(Request $request)
   {
      $sp=DocSpecialization::pluck('specialization','id');
        
      return view('register',compact('sp'));
   }
   public function registersuccess(Request $request)
   {
       
        
      return view('registersuccess');
   }
  
   public function register_user(Request $request)
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
        $user = new User;
        $user->shdct_user_id = substr(number_format(time() * rand(),0,'',''),0,6);
        $user->user_role = '11';  
        $user->name = $request->name;
        $user->email =  $request->email;
        $user->mobile_no =$mobile;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->shdct_user_id = 'C2PDR'.$user->id;
        $user->is_self = 1;
        $user->save();

        // Create 
        // $tenant_detail = new TenantDetail;
        // $tenant_detail->user_id = $user->id;
        // $tenant_detail->concern_person =  $request->name;
        // $tenant_detail->concern_person_mobile = $request->mobile_no;
        // $tenant_detail->details = 'N/A';
        // $tenant_detail->slug = str_slug($request->name);
        // $status = $tenant_detail->save();

        ///
        $Doctor =new Doctor;
        $Doctor->user_id= $user->id;
        $Doctor->experiance='N/A';
        $Doctor->landline='N/A';
        $Doctor->address=$request->address;
        $Doctor->profile_details='N/A';
        $Doctor->landline='N/A';
        $Doctor->save();
        $DoctorSpecialization=new DoctorSpecialization;
        $DoctorSpecialization->doctor_id=$Doctor->id;
        $DoctorSpecialization->specialization=$request->specialization;
        $DoctorSpecialization->save();
        DB::commit();

        $data['recipient_no']=$request->mobile_no;
        $data['msgtxt']="Thank you for being registered in Cover2Protect. ";
        $sendsms=Helper::sendSMS($data);
       return redirect('register-success');
    }
      catch(\Exception $e){
           dd($e);
          DB::rollback();
         return redirect()->back()->with('allredyused', 'something wrong'); 
      }

    
   }
}
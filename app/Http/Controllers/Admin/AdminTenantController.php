<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AdminTenantRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ResetPassword;
use App\Mail\WelcomeMail;
use App\Model\PasswordResetCodes;
use App\Model\TenantDetail;
use App\User;
use Config;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class AdminTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users  = User::with('tenant_details')->whereUserRole(9)->get();
        return view('admin.tenant.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tenant.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminTenantRequest $request)
    {
        try{
            DB::beginTransaction();

            // create new tenanat with role 9
            $user = new User();
            $user->shdct_user_id = substr(number_format(time() * rand(),0,'',''),0,6);
            $user->user_role = '9';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->password = bcrypt('123456');
            $user->save();

            $user->shdct_user_id = Config::get('sheDoctr.db.tenantPrefix').$user->id;
            $user->save();

            // Create 
            $tenant_detail = new TenantDetail();
            $tenant_detail->user_id = $user->id;
            $tenant_detail->landline = $request->landline;
            $tenant_detail->concern_person =  $request->concern_person;
            $tenant_detail->concern_person_mobile = $request->concern_person_mobile;
            $tenant_detail->address = $request->address;
            $tenant_detail->details = $request->details;
            $tenant_detail->slug = strtolower($request->slug);
            $status = $tenant_detail->save();

            DB::commit();
            Helper::send_welcome_and_reset_password_email($user);
            alert()->success('Tenant Created Successfully', 'Success');
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->error('Something Went Wrong', 'Failed');
        }

        return redirect()->route('admin.tenant');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('tenant_details')->find($id);
        return view('admin.tenant.create-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminTenantRequest $request, $id)
    {
        // Update tenanat by id
        $user = User::find($id);
        if($user)
        {
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->save();

            // Update tenant details 
            $tenant_detail = TenantDetail::whereUserId($id)->first();
            $tenant_detail->landline = $request->landline;
            $tenant_detail->concern_person =  $request->concern_person;
            $tenant_detail->concern_person_mobile = $request->concern_person_mobile;
            $tenant_detail->address = $request->address;
            $tenant_detail->details = $request->details;
            $tenant_detail->slug = strtolower($request->slug);
            $status = $tenant_detail->save();

            alert()->success('Tenant Updated Successfully', 'Success');
        }else{
            alert()->error('Something Went Wrong', 'Failed');
        }

        return redirect()->route('admin.tenant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $status = User::destroy($request->id);
        return response()->json($status);
    }
}

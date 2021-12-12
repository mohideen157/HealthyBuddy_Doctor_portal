<?php

namespace App\Http\Controllers\Tenant;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Tenant\OrganisationRequest;
use App\Model\Tenant\OrganisationDetail;
use App\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisations = OrganisationDetail::with('user')->whereParentUserId(Auth::id())->get();
        return view('tenant.organisation.index', compact('organisations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.organisation.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganisationRequest $request)
    {
        try{
            DB::beginTransaction();

            // create new oragnisation with role 10
            $user = new User();
            $user->user_role = '10';  
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->password = bcrypt('123456');
            $user->save();

            $user->shdct_user_id = Config::get('sheDoctr.db.organisationPrefix').$user->id;
            $user->save();

            // Create 
            $org_detail = new OrganisationDetail();
            $org_detail->user_id = $user->id;
            $org_detail->parent_user_id = auth()->user()->id;
            $org_detail->landline = $request->landline;
            $org_detail->concern_person =  $request->concern_person;
            $org_detail->concern_person_mobile = $request->concern_person_mobile;
            $org_detail->address = $request->address;
            $org_detail->details = $request->details;
            $status = $org_detail->save();

            DB::commit();
            Helper::send_welcome_and_reset_password_email($user);
            alert()->success('Organisation Created Successfully', 'Success');
        }
        catch(\Exception $e){
            DB::rollback();
            alert()->error('Something Went Wrong', 'Failed');
        }
        
        return redirect()->route('tenant.organisation');
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
    public function edit($tenant_name, $id)
    {
        $user = User::with('organisation_details')->find($id);
        return view('tenant.organisation.create-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganisationRequest $request, $tenanat_name, $id)
    {
        $user = User::find($id);
        if($user){
            $user->name = $request->name;
            $user->email =  $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->save();

            // Create 
            $org_detail = OrganisationDetail::whereUserId($user->id)->first();
            $org_detail->landline = $request->landline;
            $org_detail->concern_person =  $request->concern_person;
            $org_detail->concern_person_mobile = $request->concern_person_mobile;
            $org_detail->address = $request->address;
            $org_detail->details = $request->details;
            $status = $org_detail->save();
            
            alert()->success('Organisation Updated Successfully', 'Success');
        }
        else{
            alert()->error('Something Went Wrong', 'Failed');
        }
        return redirect()->route('tenant.organisation');
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

    //get the organisation associated with tenant
    public function get_organisation(Request $request)
    {
        $organisation_details = OrganisationDetail::with('user:id,name')->whereParentUserId($request->id)->get();
        return response()->json($organisation_details);
    }
}

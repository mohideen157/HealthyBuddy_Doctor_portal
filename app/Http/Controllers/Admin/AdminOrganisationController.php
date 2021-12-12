<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\OrganisationRequest;
use App\Model\Tenant\OrganisationDetail;
use App\User;
use Illuminate\Http\Request;

class AdminOrganisationController extends Controller
{
    public function index()
    {
    	$users = User::with('organisation_details.parent_user')->whereUserRole(10)->get();

    	return view('admin.organisations.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with('organisation_details')->find($id);

        return view('admin.organisations.create-edit', compact('user'));
    }

    public function update(OrganisationRequest $request, $id)
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
            alert()->errors('Something Went Wrong', 'Failed');
        }
        return redirect()->route('admin.organisation');
    }

    public function delete(Request $request)
    {
        $status = User::destroy($request->id);
        return response()->json($status);
    }
}

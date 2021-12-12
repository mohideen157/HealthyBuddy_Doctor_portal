<?php

namespace App\Http\Controllers\c2pApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganisationResource;
use App\Http\Resources\TenantCollection;
use App\Http\Resources\TenantResource;
use App\Model\Tenant\OrganisationDetail;
use App\User;
use Illuminate\Http\Request;

class TenantApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = User::whereUserRole(9)->get();
        
        if($tenants->isNotEmpty())
        {
            $data = TenantResource::collection($tenants);
            return response()->json(['status' => 'Success', 'message' => 'Tenants Successfully Retrieve', 'data' => $data]);
        }

        return response()->json(['status' => 'Failed', 'message' => 'No Containt found']);
    }

    public function show($id)
    {
        //
    }

    public function tenant_organisation($id)
    {
        $tenant_organisations = OrganisationDetail::whereParentUserId($id)->get();

        if($tenant_organisations->isNotEmpty())
        {
            $data = OrganisationResource::collection($tenant_organisations);
            return response()->json(['status' => 'Success', 'message' => 'Tenants Organisations Successfully Retrieve', 'data' => $data]);
        }
        return response()->json(['status' => 'Failed', 'message' => 'No Containt found']);
    }
}

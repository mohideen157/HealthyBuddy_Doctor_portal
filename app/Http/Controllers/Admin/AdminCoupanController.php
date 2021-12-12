<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminCoupan;

use Validator;
use Carbon\Carbon;
use DB;

class AdminCoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = AdminCoupan::all();
        return view('admin.coupan.index')
                ->with('settings', $settings);
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
            'description' => 'required',
            'value' => 'required',
            'No_of_users' => 'required',
            //'type' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/coupon')
                    ->withErrors($validator)
                    ->withInput();
        }

        $admin_coupan = new AdminCoupan();
        $admin_coupan->name = $request->name;
        if ($request->has('description')) {
            $admin_coupan->description = $request->description;
        }
        $admin_coupan->total_user = $request->No_of_users;
        $admin_coupan->val = $request->value;
        $admin_coupan->type = $request->type;
        //$admin_coupan->active = $request->status;
        $admin_coupan->save();
        return redirect('admin/coupon');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = AdminCoupan::find($id);
        return view('admin.coupan.edit')
                ->with('setting', $setting);
    }
    public function status($id)
    {
        $setting = AdminCoupan::find($id); 
        if($setting->active==0)
            $setting->active=1;
        else
          $setting->active=0;  
        $setting->save();   

        return redirect('admin/coupon');
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
            'description' => 'required',
            'value' => 'required',
            'No_of_users' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/coupaon')
                    ->withErrors($validator)
                    ->withInput();
        }
        $admin_coupan = AdminCoupan::find($id);
        $admin_coupan->name = $request->name;
        if ($request->has('description')) {
            $admin_coupan->description = $request->description;
        }
        $admin_coupan->total_user = $request->No_of_users;
        $admin_coupan->type = $request->type;
        $admin_coupan->val = $request->value;
        //$admin_coupan->active = $request->status;
        $admin_coupan->save();

        return redirect('admin/coupon');
    }
}

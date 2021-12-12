<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AdminSettings;

use Validator;
use Carbon\Carbon;
use DB;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = AdminSettings::all();
        return view('admin.settings.index')
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
            'key'     => 'required',
            'description' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/settings')
                    ->withErrors($validator)
                    ->withInput();
        }

        $admin_settings = new AdminSettings();;
        $admin_settings->key = $request->key;
        if ($request->has('description')) {
            $admin_settings->description = $request->description;
        }
        $admin_settings->value = $request->value;
        $admin_settings->save();

        return redirect('admin/settings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = AdminSettings::find($id);
        return view('admin.settings.edit')
                ->with('setting', $setting);
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
            'key' => 'required',
            'description' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
         return redirect('admin/settings')
                    ->withErrors($validator)
                    ->withInput();
        }

        $admin_settings = AdminSettings::find($id);
        $admin_settings->key = $request->key;
        $admin_settings->description = $request->description;
        $admin_settings->value = $request->value;
        $admin_settings->save();

        return redirect('admin/settings');
    }
}

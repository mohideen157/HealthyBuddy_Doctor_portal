<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    function aws_setting()
   {
       $rs=DB::table('aws_setting')->where('id',1)->get();
       $row=[];
       foreach ($rs as $key => $value) {
        $row['Aws_key']=$value->Aws_key;
        $row['Aws_Secret']=$value->Aws_Secret;
        $row['success']=true;
       }
       return response()->json([ 'data' => $row],200);
   }

}

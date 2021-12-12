<?php

namespace Myaibud\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\History;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class HistoryController extends Controller
{
	public function syncHistory(Request $request)
	{
		try {
			$user = Helper::isUserLoggedIn();

			foreach (json_decode($request->history) ?? [] as $value) 
			{
				if(History::whereSynched($value->synchedId)->exists()){
					continue;
				}

				if (isset($value->synchedId)) {
					$user->history()->create([
						'afib' => $value->AFIB,
						'arrhythmia' => $value->Arrythmia,
						'artrialage' => 0,
						'bp' => $value->Bp,
						'hr' => $value->Heartrate,
						'hrvlevel' => $value->HRVLevel,
						'rpwv' => $value->rPWV,
						'synched' => $value->synchedId,
						'date' => $value->date,
					]);
				}
			}
			return response()->json([
				'success' => true,
				'message' => 'History updated successfully'
			]);
		} catch (Exception $e) {
			return response()->json([
				'success' => false,
				'error' => '500 Server Error',
				'message' => 'Something went wrong, please try again..'
			]);
		}
	}

	public function getBp(){
		$today = Carbon::today()->subMonth(1)->toDateString();

		$bp = History::select('bp', 'date')
						->whereUserId(Auth::id())
						->whereDate('date', '>=', $today)
						->orderBy('date')
						->get();

		if($bp->isNotEmpty()){
			//Get First and Last Date
			$start_date = date('d M',strtotime($bp->first()->date));
			$end_date = date('d M',strtotime($bp->last()->date));
			
			$bp_m = $bp->map(function($arr, $key){
				$str = explode('/', $arr->bp);
				$count = ++$key;
				$total = array_sum((array)$str[0]);
				//dd($total);
				return  [
					'sp' => $str[0],
					'dp' => $str[1],
					'date' => date('d M', strtotime($arr->date)), 
				];
			});
			$rs=[];
			$sp=[];
			$dp=[];
			foreach ($bp_m as $key => $value) {
				  $sp[]=$value['sp'];
				  $dp[]=$value['dp'];
				  if(count($sp)>0 && count($dp)>0)
				  {
					$avg=array_sum($sp)/count($sp);
					$dp_avg=array_sum($dp)/count($dp);
				  }else{
					  $avg=$value->sp;
					  $dp_avg=$value->dp;
				  }
				
				  $value['bp_avg']= number_format((float)$avg, 2, '.', '');
				  $value['dp_avg']=number_format((float)$dp_avg, 2, '.', '');
				  $rs[]=$value;			  
				  	
			}

			return response()->json(['success' => true, 'message' => "BP data for graph", 'start_date' => $start_date, 'end_date' => $end_date, 'data' => $rs]);
		}
		else{
			return response()->json(['success' => false, 'message' => 'No Containt Found']);
		}		
	}

	public function getRpwv(){
		$today = Carbon::today()->subMonth(1)->toDateString();

		$rpwv = History::select('rpwv', 'date')
						->whereUserId(Auth::id())
						->whereDate('date', '>=', $today)
						->orderBy('date')
						->get();

		if($rpwv->isNotEmpty()){
			$rpwv = $rpwv->map(function($r){
				return [
					'rpwv' => $r->rpwv,
					'date' => date('d M', strtotime($r->date))
				];
			});

			// new code for average rpwv
			$rs=[];
			$sp=[];
			foreach ($rpwv as $key => $value) {
				  $sp[]=$value['rpwv'];
				  if(count($sp)>0)
				  {
					$avg=array_sum($sp)/count($sp);
				  }else{
					  $avg=$value->sp;
				  }
				
				  $value['rpwv_avg']= number_format((float)$avg, 2, '.', '');
				  $rs[]=$value;				   
			}

			return response()->json(['success' => true, 'message' => "Rpwv data for graph", 'data' => $rs]);
		}
		else{
			return response()->json(['success' => false, 'message' => 'No Containt Found']);
		}	
	}

	public function getAfib(){
		$today = Carbon::today()->subMonth(1)->toDateString();

		$afib = History::select('afib', 'date')
						->whereUserId(Auth::id())
						->whereDate('date', '>=', $today)
						->orderBy('date')
						->get();

		if($afib->isNotEmpty()){
			$afib = $afib->map(function($a){
				return [
					'afib' => $a->afib,
					'date' => date('d M', strtotime($a->date))
				];
			});

			$rs=[];
			$sp=[];
			foreach ($afib as $key => $value) {
				  $sp[]=$value['afib'];
				  if(count($sp)>0)
				  {
					$avg=array_sum($sp)/count($sp);
				  }else{
					  $avg=$value->sp;
				  }
				
				  $value['afib_avg']= number_format((float)$avg, 2, '.', '');
				  $rs[]=$value;				   
			}

			return response()->json(['success' => true, 'message' => "afib data for graph", 'data' => $rs]);
		}
		else{
			return response()->json(['success' => false, 'message' => 'No Containt Found']);
		}	
	}


	public function getHr(){
		$today = Carbon::today()->subMonth(1)->toDateString();

		$hr = History::select('hr', 'date')
					->whereUserId(Auth::id())
					->whereDate('date', '>=', $today)
					->orderBy('date')
					->get();

		if($hr->isNotEmpty()){
			$hr = $hr->map(function($hr){
				return [
					'hr' => $hr->hr,
					'date' => date('d M', strtotime($hr->date))
				];
			});

			
			$rs=[];
			$sp=[];
			foreach ($hr as $key => $value) {
				  $sp[]=$value['hr'];
				  if(count($sp)>0)
				  {
					$avg=array_sum($sp)/count($sp);
				  }else{
					  $avg=$value->sp;
				  }
				
				  $value['hr_avg']= number_format((float)$avg, 2, '.', '');
				  $rs[]=$value;				   
			}

			return response()->json(['success' => true, 'message' => "hr data for graph", 'data' => $rs]);
		}
		else{
			return response()->json(['success' => false, 'message' => 'No Containt Found']);
		}	
	}

	public function getArrhythmia(){

		$today = Carbon::today()->subMonth(1)->toDateString();
	
		$arrhythmia_count = History::whereUserId(Auth::id())
								->whereDate('date', '>=', $today)
								->where('arrhythmia','>=', 1)
								->orderBy('date')
								->get();

		if ($arrhythmia_count->isNotEmpty()) {
			# code...
			$arrhythmia = $arrhythmia_count->map(function($arrhythmia){
				return [
					'arrthythmia' => $arrhythmia->arrhythmia,
					'date' => date('d M', strtotime($arrhythmia->date)),
				];
			});
		}

		return response()->json(['success' => true, 'message' => 'Arrythmia Retrieved successfully', 'data' => $arrhythmia]);
	}

	public function getCalories()
	{
		try 
		{		
			$response = [];		
			$getCalories = Helper::get_calories(Auth::id());

			$data['date'] = $getCalories[0][0];
			$data['calories_gained'] = $getCalories[0][1];
			$data['calories_burned'] = $getCalories[0][2];
			$data['calories_target'] = $getCalories[0][3];

			for($i = 0; $i < count($data['date']); $i++){
				$arr['date'] = $data['date'][$i];
				$arr['calories_gained'] = $data['calories_gained'][$i];
				$arr['calories_burned'] = $data['calories_burned'][$i];
				$arr['calories_target'] = $data['calories_target'][$i];

				array_push($response, $arr);
			}			
		} catch (Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Something went wrong, please try again..'
			]);
		}
		return response()->json(['success' => true, 'message' => 'Calories', 'data' => $response]);
	}
}

<?php

namespace Myaibud\Controllers\API;

use Auth;
use Exception;
use App\Allergy;
use App\ProfileQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Resources\ProfileQuestionResource;

class ProfileQuestionController extends Controller
{

	public function __construct()
	{
		$this->profileQuestion = new ProfileQuestion;
	}

	public function index()
	{
		return response()->json([
			'success' => true,
			'data' => ProfileQuestionResource::collection(
				Auth::user()->profileQuestion()->get()
			)
		]);
	}

	public function upsert(Request $request)
	{
		$patient = Auth::user();

	    $request->validate($this->profileQuestion->upsertRules);

		$profileQuestion = $this->getQuestion(
			$request->question_slug
		)->first();
		// If alredy exists then update
		if (!empty($profileQuestion)) {
			if ($patient->profileQuestion()->update($request->all())) {
				return $this->getQuestion($request->question_slug)->first();
			}
		}
		// Otherwise store
		else {
			return $patient->profileQuestion()->create($request->all());
		}


	}

	public function store(Request $request)
	{
		$profileQuestion = $this->profileQuestion;
		return $profileQuestion->create($request->all());
	}

	public function update(Request $request, $profileQuestion)
	{
		if ($profileQuestion->update($request->all())) {
			return $profileQuestion;
		}
	}

	public function editById($id)
	{
		return $this->profileQuestion->find($id);
	}

	public function edit($questionSlug)
	{
		$data = $this->getQuestion($questionSlug)->get();

		// if($data->count() <= 0) {
		// 	return response()->json([
		// 		'success' => false,
		// 		'data' => [],
		// 		'message' => 'No Data Found'
		// 	]);
		// }
		return response()->json([
			'success' => true,
			'data' => ProfileQuestionResource::collection(
				$data
			)
		]);
	}

	public function getQuestion($questionSlug)
	{
		$patientId = Auth::user()->id;

		if (empty($questionSlug)) {
			return response()->json([
				'message' => 'Please provide question_slug'
			]);
		}
		return $this->profileQuestion
					->where('patient_id', '=', $patientId)
					->where('question_slug', '=', $questionSlug);
	}
}
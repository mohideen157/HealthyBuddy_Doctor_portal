<?php

namespace Myaibud\Controllers\API\Patient;

use App\Allergy;
use App\Disease;
use App\Padometer;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExcerciseResource;
use App\Http\Resources\NutritionResource;
use App\Http\Traits\HhiTrait;
use App\Model\History;
use App\Model\Patient\PatientProfile;
use Auth, Log;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Myaibud\Models\Patient\PatientHealthProfile;
use Myaibud\Models\Patient\PatientHraData;
use Myaibud\Traits\ProfileScoring;
use Myaibud\Models\Patient\MedicalReport;


class PatientHealthProfileController extends Controller
{

    use ProfileScoring;
    use HhiTrait;

    public function __construct()
    {
        $this->patientHealthProfile = new PatientHealthProfile;
        $this->patientHraData = new PatientHraData;
        $this->disease = new Disease;
        $this->allergy = new Allergy;

        $this->dietParentKeys = [
            'diet-type',
            'cup-of-vegetables',
            'cereals-qty',
            'fast-food',
            'drinks',
            'fruits'
        ];

        $this->alcoholKeys = [
            'alcohol',
            'alcohol-interval',
            'alcohol-small-dosage',
            'alcohol-medium-dosage',
            'alcohol-large-dosage'
        ];

        $this->smokingKeys = [
            'smoking',
            'smoking-interval',
            'start-age',
            'end-age',
            'dosage',
            'tobacco'
        ];

        $this->diebeticKeys = [
            'diebetic',
            'medicine'
        ];

        $this->diseaseKeys = [
            'disease',
            'disease-details'
        ];

        $this->allergyKeys = [
            'allergy',
            'allergy-details'
        ];

        $this->medicationKeys = [
            'medication',
            'medication-details'
        ];

        $this->bloodPressureKeys = [
            'blood-pressure',
            'systolic',
            'diastolic'
        ];

        $this->strokeKeys = [
            'stroke',
            'reason-for-stroke'
        ];

        $this->cardiovascKeys = [
            'cardiovascular-or-stroke',
            'coronary-heart-ischemic-heart',
            'angina-pain',
            'regular-medication',
            'heart-attack',
            'ecg',
            'coronary-angiography',
            'bypass-surgery',
            'stent-placement',
            'valve-surgery',

        ];

        $this->tiaKeys = [
            'tia',
            'regular-treatment'
        ];
    }

    public function upsertRecord(Request $request, $record=null, $isInsert=false, $sendId=false)
    {
        try {
            if (empty($request->child_key)) {
                $record = $this->getParentKeyRecord($request->parent_key);
            }
            if (!empty($request->child_key)) {
                $record = $this->getChildKeyRecord($request->parent_key, $request->child_key);
            }

            $responseData = [];
            if (!empty($record) && !$isInsert) {
                if (strtotime($record->created_at) > strtotime('-1 day')) {
                    // update here
                    $responseData = $this->updateActiveRecord($request, $record, 'parent');
                } else {
                    // Deactive the current active record first
                    if ($this->deactivateTheActiveRecord($record)) {
                        // add new active record
                        $responseData = $this->addActiveRecord($request);
                    }
                }
            } else {
                $responseData = $this->addActiveRecord($request);
            }

            $this->calculateQuestionScore($responseData, $request->parent_key, $request->child_key);

            if ($sendId) {
                return $responseData->id;
            }

            // Here we have to calculate total heealth score and and set to the response object
            $responseData->totalScore = $this->getHRA();
            return response()->json([
                'success' => true,
                'data' => $responseData
            ]);

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function upsertTravelFrequncy(Request $request)
    {
        try{
            //First get the active travel frquency record
            $existingTravelFrequency = $this->getChildKeyRecord($request->parent_key, $request->child_key);
            $responseData = [];
            // If found
            if (!empty($existingTravelFrequency)) {
                // If its created before a week only
                if (strtotime($existingTravelFrequency->created_at) > strtotime('-1 day')) {
                    // update here
                    $responseData = $this->updateActiveRecord($request, $existingTravelFrequency, 'parent');
                } else {
                    // Deactive the current active record first
                    if ($this->deactivateTheActiveRecord($existingTravelFrequency)) {
                        // add new active record
                        $responseData = $this->addActiveRecord($request);
                    }
                }
            }
            // If not found
            if (empty($existingTravelFrequency)) {
                // add new active record
                $responseData = $this->addActiveRecord($request);
            }

            return response()->json([
                'success' => true,
                'data' => $responseData
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function getTravelFrequncy($travelType)
    {
        $frequency = $this->getPatienActivetHealthRecord()->where('parent_key', '=', $travelType)->first();
        if (!empty($frequency)) {
            return response()->json([
                'success' => true,
                'data' => $frequency
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertDietData(Request $request, $parentKey)
    {
        if (empty($parentKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Parent key is not given'
            ]);
        }
        if (!in_array($parentKey, $this->dietParentKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getDietData($parentKey)
    {
        $dietData = $this->getPatienActivetHealthRecord()->where('parent_key', '=', $parentKey)->first();
        if (!empty($dietData)) {
            return response()->json([
                'success' => true,
                'data' => $dietData
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertAlcohol(Request $request)
    {

		Log::info('-----------------START--------------');

		Log::info($request->all());

        Log::info('-----------------END----------------');

        if (!in_array($request->parent_key, $this->alcoholKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getAlcohol()
    {
        $alcohol = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'alcohol')->where('child_key', '=', NULL)->first();
        if (!empty($alcohol)) {
            return response()->json([
                'success' => true,
                'data' => $alcohol
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function getAllAlcoholData()
    {
        $alcoholData = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'alcohol')->get();
        $data = new \stdClass;
        $dosage = []; // new \StdClass;
        $dosage[0] = (Object) ['type' => 'small', 'value' => '', 'interval' => ''];
        $dosage[1] = (Object) ['type' => 'medium', 'value' => '', 'interval' => ''];
        $dosage[2] = (Object) ['type' => 'large', 'value' => '', 'interval' => ''];
        $data->time = '';
        $data->dosage = $dosage;
        foreach ($alcoholData as $key => $alcohol) {
            if ($alcohol->child_key == 'alcohol-interval') {
                if (!empty($alcohol->value)) $data->time = $alcohol->value;
            }
            if ($alcohol->child_key == 'alcohol-small-dosage') {
                $value = (!empty($alcohol->value)) ? $alcohol->value : '';
                $extra_info = (!empty($alcohol->extra_info)) ? $alcohol->extra_info : '';
                $dosage[0] = (object) ['type' => 'small', 'value' => $value, 'unit' => $extra_info];
            }
            if ($alcohol->child_key == 'alcohol-medium-dosage') {
                $value = (!empty($alcohol->value)) ? $alcohol->value : '';
                $extra_info = (!empty($alcohol->extra_info)) ? $alcohol->extra_info : '';
                $dosage[1] = (object) ['type' => 'medium', 'value' => $value, 'unit' => $extra_info];
            }
            if ($alcohol->child_key == 'alcohol-large-dosage') {
                $value = (!empty($alcohol->value)) ? $alcohol->value : '';
                $extra_info = (!empty($alcohol->extra_info)) ? $alcohol->extra_info : '';
                $dosage[2] = (object) ['type' => 'laarge', 'value' => $value, 'unit' => $extra_info];
            }
        }
        $data->dosage = $dosage;
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function upsertAlcoholInterval(Request $request)
    {
        if (!in_array($request->parent_key, $this->alcoholKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!empty($request->child_key) && !in_array($request->child_key, $this->alcoholKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getAlcoholInterval(Request $request)
    {
        $alcoholInterval = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'alcohol')
                                ->where('child_key', '=', 'alcohol-interval')
                                ->first();
        if (!empty($alcoholInterval)) {
            return response()->json([
                'success' => true,
                'data' => $alcoholInterval
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertAlcoholDosageData(Request $request, $type)
    {
        if (!in_array($request->parent_key, $this->alcoholKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!empty($request->child_key) && !in_array($request->child_key, $this->alcoholKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        if ($type == 'small' && $request->child_key == 'alcohol-small-dosage') {
            return $this->upsertRecord($request);
        } else if ($type == 'medium' && $request->child_key == 'alcohol-medium-dosage') {
            return $this->upsertRecord($request);
        } else if ($type == 'large' && $request->child_key == 'alcohol-large-dosage') {
            return $this->upsertRecord($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Given child key is not validate for this API'
            ]);
        }
    }

    public function getAlcoholDosageData($type)
    {
        if ($type == 'small') {
            $alcoholDosage = $this->getPatienActivetHealthRecord()
                                    ->where('parent_key', '=', 'alcohol')
                                    ->where('child_key', '=', 'alcohol-small-dosage')
                                    ->first();
        } else if ($type == 'medium') {
            $alcoholDosage = $this->getPatienActivetHealthRecord()
                                    ->where('parent_key', '=', 'alcohol')
                                    ->where('child_key', '=', 'alcohol-medium-dosage')
                                    ->first();
        } else if ($type == 'large') {
            $alcoholDosage = $this->getPatienActivetHealthRecord()
                                    ->where('parent_key', '=', 'alcohol')
                                    ->where('child_key', '=', 'alcohol-large-dosage')
                                    ->first();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Give type is invalid'
            ]);
        }

        if (!empty($alcoholDosage)) {
            return response()->json([
                'success' => true,
                'data' => $alcoholDosage
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => (object) []
            ]);
        }
    }

    public function upsertSmoking(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getAllSmokingData()
    {
        $smokingData = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'smoking')->get();
        $data = new \stdClass;
        $data->time = '';
        $data->start_age = '';
        $data->end_age = '';
        $data->dosage = '';
        $data->tobacco_dosage = '';
        $data->tobacco_dosage_time = '';


        foreach ($smokingData as $key => $smoking) {
            if ($smoking->child_key == 'smoking-interval') {
                if (!empty($smoking->value)) $data->time = $smoking->value;
            }
            if ($smoking->child_key == 'start-age') {
                (!empty($smoking->value)) ? $data->start_age = $smoking->value : $data->start_age = '';
            }
            if ($smoking->child_key == 'end-age') {
                (!empty($smoking->value)) ? $data->end_age = $smoking->value : $data->end_age = '';
            }
            if ($smoking->child_key == 'dosage') {
                (!empty($smoking->value)) ? $data->dosage = $smoking->value : $data->dosage = '';
            }
            if ($smoking->child_key == 'tobacco') {
                (!empty($smoking->value)) ? $data->tobacco_dosage = $smoking->value : $data->tobacco_dosage = '';
                $data->tobacco_dosage_time = $smoking->extra_info;
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    }
    public function getSmoking()
    {
        $smoking = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'smoking')->where('child_key', '=', NULL)->first();
        if (!empty($smoking)) {
            return response()->json([
                'success' => true,
                'data' => $smoking
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSmokingInterval(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!empty($request->child_key) && !in_array($request->child_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSmokingInterval(Request $request)
    {
        $smokingInterval = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'smoking')
                                ->where('child_key', '=', 'smoking-interval')
                                ->first();
        if (!empty($smokingInterval)) {
            return response()->json([
                'success' => true,
                'data' => $smokingInterval
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSmokingStartAge(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!empty($request->child_key) && !in_array($request->child_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSmokingStartAge(Request $request)
    {
        $smokingStartAge = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'smoking')
                                ->where('child_key', '=', 'start-age')
                                ->first();
        if (!empty($smokingStartAge)) {
            return response()->json([
                'success' => true,
                'data' => $smokingStartAge
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSmokingEndAge(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!empty($request->child_key) && !in_array($request->child_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSmokingEndAge(Request $request)
    {
        $smokingEndAge = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'smoking')
                                ->where('child_key', '=', 'end-age')
                                ->first();
        if (!empty($smokingEndAge)) {
            return response()->json([
                'success' => true,
                'data' => $smokingEndAge
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSmokingTobaccoDosage(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSmokingTobaccoDosage()
    {
        $smokingDosage = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'smoking')->where('child_key', '=', 'tobacco')->first();
        if (!empty($smokingDosage)) {
            return response()->json([
                'success' => true,
                'data' => $smokingDosage
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSmokingDosage(Request $request)
    {
        if (!in_array($request->parent_key, $this->smokingKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSmokingDosage()
    {
        $smokingDosage = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'smoking')->where('child_key', '=', 'dosage')->first();
        if (!empty($smokingDosage)) {
            return response()->json([
                'success' => true,
                'data' => $smokingDosage
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertVigorusPhysicalActivity(Request $request)
    {
        if ($request->parent_key != 'vigorus-physical-activity') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getVigorusPhysicalActivity(Request $request)
    {
        $vigorusPhysicalActivity = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'vigorus-physical-activity')->first();
        if (!empty($vigorusPhysicalActivity)) {
            return response()->json([
                'success' => true,
                'data' => $vigorusPhysicalActivity
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertModeratePhysicalActivity(Request $request)
    {
        if ($request->parent_key != 'moderate-physical-activity') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getModeratePhysicalActivity(Request $request)
    {
        $moderatePhysicalActivity = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'moderate-physical-activity')->first();
        if (!empty($moderatePhysicalActivity)) {
            return response()->json([
                'success' => true,
                'data' => $moderatePhysicalActivity
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertLightPhysicalActivity(Request $request)
    {
        if ($request->parent_key != 'light-physical-activity') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getLightPhysicalActivity(Request $request)
    {
        $lightPhysicalActivity = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'light-physical-activity')->first();
        if (!empty($lightPhysicalActivity)) {
            return response()->json([
                'success' => true,
                'data' => $lightPhysicalActivity
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertDiebetic(Request $request)
    {
        if (!in_array($request->parent_key, $this->diebeticKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getDiebetic()
    {
        $diebetic = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'diebetic')->where('child_key', '=', NULL)->first();
        if (!empty($diebetic)) {
            return response()->json([
                'success' => true,
                'data' => $diebetic
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertDiebeticMedicine(Request $request)
    {
        if (!in_array($request->parent_key, $this->diebeticKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!in_array($request->child_key, $this->diebeticKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        return $this->upsertRecord($request);
    }

    public function getDiebeticMedicine()
    {
        $diebeticMedicine = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'diebetic')->where('child_key', '=', 'medicine')->first();
        if (!empty($diebeticMedicine)) {
            return response()->json([
                'success' => true,
                'data' => $diebeticMedicine
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }



    public function upsertBloodCholestrol(Request $request)
    {
        if ($request->parent_key != 'blood-cholestrol') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getBloodCholestrol(Request $request)
    {
        $bloodCholestrol = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'blood-cholestrol')->first();
        if (!empty($bloodCholestrol)) {
            return response()->json([
                'success' => true,
                'data' => $bloodCholestrol
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }


    public function upsertDiastolicBloodPressure(Request $request)
    {
        if (!in_array($request->child_key, $this->bloodPressureKeys) && !in_array($request->parent_key, $this->bloodPressureKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key or Child Key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getDiastolicBloodPressure(Request $request)
    {
        $bloodPressureDiastolic = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'blood-pressure')->where('child_key', '=', 'diastolic')->first();
        if (!empty($bloodPressureDiastolic)) {
            return response()->json([
                'success' => true,
                'data' => $bloodPressureDiastolic
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertSystolicBloodPressure(Request $request)
    {
        if (!in_array($request->child_key, $this->bloodPressureKeys) && !in_array($request->parent_key, $this->bloodPressureKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key or Child Key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getSystolicBloodPressure(Request $request)
    {
        $bloodPressureSystolic = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'blood-pressure')->where('child_key', '=', 'systolic')->first();
        if (!empty($bloodPressureSystolic)) {
            return response()->json([
                'success' => true,
                'data' => $bloodPressureSystolic
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertBloodPressure(Request $request)
    {
        if ($request->parent_key != 'blood-pressure') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getBloodPressure(Request $request)
    {
        $bloodPressure = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'blood-pressure')->first();
        if (!empty($bloodPressure)) {
            return response()->json([
                'success' => true,
                'data' => $bloodPressure
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertCardiovascular(Request $request)
    {
        if ($request->parent_key != 'cardiovascular-or-stroke') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getCardiovascular(Request $request)
    {
        $cardiovascularOrStroke = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->first();
        if (!empty($cardiovascularOrStroke)) {
            return response()->json([
                'success' => true,
                'data' => $cardiovascularOrStroke
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertDisease(Request $request)
    {
        if (!in_array($request->parent_key, $this->diseaseKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if($request->has('value') && $request->value=='No'){
         $HealthProfile=PatientHealthProfile::where('patient_id',Auth::id())
                                                       ->where('child_key','disease-details')
                                                       ->update(['active'=>0]);
        }
            
        return $this->upsertRecord($request);
    }

    public function getDisease()
    {
        $disease = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'disease')->where('child_key', '=', NULL)->first();
        if (!empty($disease)) {
            return response()->json([
                'success' => true,
                'data' => $disease
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertDiseaseDetails(Request $request)
    {
        if (!in_array($request->parent_key, $this->diseaseKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!in_array($request->child_key, $this->diseaseKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        // Here check if manual field is yes if then call upsert disease method to insert it in DB
        if ($request->manual_field == "yes") {
            $this->upsertManualDisease($request);
        }

        if (in_array($request->value, $this->getDiseaseDetails(true)->pluck('value')->toArray())) {
            return response()->json([
                'success' => false,
                'message' => 'Disease already exists'
            ]);
        }

        return $this->upsertRecord($request, null, true);
    }

    public function upsertManualDisease($request)
    {
        $slug = str_replace(" ", "-", strtolower($request->value));
        $disease = $this->disease->where('name', 'LIKE', "%$request->value%")
        ->orWhere('slug', 'LIKE', "%$slug%")
        ->first();

        // Search if disease with given exists or not if not then insert
        if (!$disease) {
            $this->disease->create(['name' => $request->value, 'slug' => $slug]);
        }

    }

    public function deleteDiseaseDetails(Request $request)
    {
        $value = $request->value;
        $record = $this->getPatienActivetHealthRecord()->where('child_key', '=', 'disease-details')->where('value', '=', $value)->first();

        if (empty($record)) {
            return response()->json([
                'success' => false,
                'message' => 'Entity not found'
            ]);
        }
        if ($record->update(['active' => '0'])) {
            return response()->json([
                'success' => true,
                'message' => 'Disease deleted successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Oops, getting some error while deleting'
        ]);
    }

    public function getDiseaseDetails($nonJsonResponse=false)
    {
        $diseaseDetails = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'disease')->where('child_key', '=', 'disease-details');
        if ($nonJsonResponse) {
            return $diseaseDetails;
        }
        if (!empty($diseaseDetails->get())) {
            return response()->json([
                'success' => true,
                'data' => $diseaseDetails->get()
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertAllergy(Request $request)
    {
        if (!in_array($request->parent_key, $this->allergyKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if($request->has('value') && $request->value=='No')
            {
                
             $HealthProfile=PatientHealthProfile::where('patient_id',Auth::id())
                                                       ->where('parent_key','allergy')
                                                       ->where('child_key','allergy-details')
                                                       ->update(['active'=>0]);
            }
        return $this->upsertRecord($request);
    }

    public function getAllergy()
    {
        $allergy = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'allergy')->where('child_key', '=', NULL)->first();
        if (!empty($allergy)) {
            return response()->json([
                'success' => true,
                'data' => $allergy
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertAllergyDetails(Request $request)
    {

        if (!in_array($request->parent_key, $this->allergyKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!in_array($request->child_key, $this->allergyKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        // Here check if manual field is yes if then call upsert allergy method to insert it in DB
        if ($request->manual_field == "yes") {
            $this->upsertManualAllergy($request);
        }

        if (in_array($request->value, $this->getAllergyDetails(true)->pluck('value')->toArray())) {
            return response()->json([
                'success' => false,
                'message' => 'Allergy already exists'
            ]);
        }

        return $this->upsertRecord($request, null, true);
    }



    public function upsertManualAllergy($request)
    {
        $slug = str_replace(" ", "-", strtolower($request->value));
        $allergy = $this->allergy->where('name', 'LIKE', "%$request->value%")
        ->orWhere('slug', 'LIKE', "%$slug%")
        ->first();

        // Search if disease with given exists or not if not then insert
        if (!$allergy) {
            $this->allergy->create(['name' => $request->value, 'slug' => $slug]);
        }

    }

    public function deleteAllergyDetails(Request $request)
    {
        $value = $request->value;
        $record = $this->getPatienActivetHealthRecord()->where('child_key', '=', 'allergy-details')->where('value', '=', $value)->first();

        if (empty($record)) {
            return response()->json([
                'success' => false,
                'message' => 'Entity not found'
            ]);
        }

        if ($record->update(['active' => '0'])) {
            return response()->json([
                'success' => true,
                'message' => 'Allergy deleted successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Oops, getting some error while deleting'
        ]);
    }

    public function getAllergyDetails($nonJsonResponse=false)
    {
        $allergyDetails = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'allergy')->where('child_key', '=', 'allergy-details');
        if($nonJsonResponse) {
            return $allergyDetails;
        }
        if (!empty($allergyDetails->get())) {
            return response()->json([
                'success' => true,
                'data' => $allergyDetails->get()
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertMedication(Request $request)
    {
        if (!in_array($request->parent_key, $this->medicationKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if($request->has('value') && ($request->value=='No'||$request->value=='no'))
            {
                
             $HealthProfile=PatientHealthProfile::where('patient_id',Auth::id())
                                                    ->where('child_key','medication-details')
                                                    ->update(['active'=>0]);
            }
        return $this->upsertRecord($request);
    }

    public function getMedication()
    {
        $medication = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'medication')->where('child_key', '=', NULL)->get();
        if (!empty($medication)) {
            return response()->json([
                'success' => true,
                'data' => $medication
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function insertMedicationDetails(Request $request)
    {

        if (!in_array($request->parent_key, $this->medicationKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        if (!in_array($request->child_key, $this->medicationKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        if (in_array($request->value, $this->getMedicationDetails(null, true)->pluck('value')->toArray())) {
            return response()->json([
                'success' => false,
                'message' => 'Medication already exists'
            ]);
        }

        $extraInfo = json_encode(['dosage' => $request->dosage, 'type' => $request->type, 'per_day' => $request->per_day]);

        $request->request->remove('dosage');
        $request->request->remove('type');
        $request->request->remove('per_day');

        $request->merge(["extra_info"=> $extraInfo]);

        $medicationId =  $this->upsertRecord($request, null, true, true);

        return $this->getMedicationDetails($medicationId);
    }

    public function updateMedicationDetails(Request $request, $id)
    {
        $medicationDetails = $this->getPatienActivetHealthRecord()->find($id);
        if(empty($medicationDetails)) {
            return response()->json([
                'success' => false,
                'message' => 'Given Entity Id not exist'
            ]);
        }
        $extraInfo = json_encode(['dosage' => $request->dosage, 'type' => $request->type, 'per_day' => $request->per_day]);

        if ($medicationDetails->update(['extra_info' => $extraInfo])) {
            return $this->getMedicationDetails($id);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error while updating medication details'
            ]);
        }
    }

    public function getMedicationDetails($id=null, $nonJsonResponse=false)
    {
        if (!empty($id)) {
            $medicationDetails = $this->getPatienActivetHealthRecord()->where('id', '=', $id)->first();
            $extraInfo = json_decode($medicationDetails->extra_info ,true);
            $medicationDetails->dosage = $extraInfo['dosage'];
            $medicationDetails->type = $extraInfo['type'];
            $medicationDetails->per_day = $extraInfo['per_day'];
            $medicationDetails->totalScore = $this->getHRA();
        } else {
            $medicationDetails = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'medication')->where('child_key', '=', 'medication-details');
            if ($nonJsonResponse) {
                return $medicationDetails;
            }
            $medicationDetails = $medicationDetails->get();
            $medicationFormattedData = [];
            foreach($medicationDetails as $medication) {
                $extraInfo = '';
                $extraInfo = json_decode($medication->extra_info, true);
                $medication->dosage = $extraInfo['dosage'];
                $medication->type = $extraInfo['type'];
                $medication->per_day = $extraInfo['per_day'];

                $medicationFormattedData[] = $medication;
            }
            $medicationDetails = $medicationFormattedData;
        }

        if (!empty($medicationDetails)) {
            return response()->json([
                'success' => true,
                'data' => $medicationDetails
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => []
        ]);
    }

    public function deleteMedicationDetails(Request $request)
    {
        $value = $request->value;
        $record = $this->getPatienActivetHealthRecord()->where('child_key', '=', 'medication-details')->where('value', '=', $value)->first();

        if (empty($record)) {
            return response()->json([
                'success' => false,
                'message' => 'Entity not found'
            ]);
        }

        if ($record->update(['active' => '0'])) {
            return response()->json([
                'success' => true,
                'message' => 'Medication deleted successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Oops, getting some error while deleting'
        ]);
    }

    public function deactivateTheActiveRecord($record)
    {
        $patientHealthProfile = $this->patientHealthProfile->find($record->id);
        $patientHealthProfile->active = 0;
        if ($patientHealthProfile->save()) {
            return true;
        }
        return false;
    }


    public function addActiveRecord(Request $request)
    {
        if (empty($request->parent_key)) {
            return response()->json([
                'success' => false,
                'message' => 'Parent key not given to insert a health record'
            ]);
        }

        $patient = Auth::user();
        // add active to true
        $request->merge(["active"=>"1"]);

        return $patient->patientHealthProfile()->create($request->all());
    }

    public function updateActiveRecord(Request $request, $record, $keyToBeUpdating=null)
    {
        $patient = Auth::user();
        if ($this->updateRecord($request, $record->id)) {
            return $this->getActiveRecordById($record->id);
        }
    }

    public function getActiveRecordById($id)
    {
        return $this->getPatienActivetHealthRecord()->where('id', '=', $id)->first();
    }

    public function updateRecord(Request $request, $id)
    {
        $patientHealthProfile = $this->patientHealthProfile->find($id);

        $patientHealthProfile->value = $request->value;
        $patientHealthProfile->unit = $request->unit;
        $patientHealthProfile->extra_info = $request->extra_info;

        if ($patientHealthProfile->save()) {
            return true;
        }
        return false;
    }

    public function getActiveRecord($parentKey, $childKey=null)
    {
        if (!empty($childKey)) {
            return $this->getChildKeyRecord($parentKey, $childKey);
        }

        return $this->getParentKeyRecord($parentKey);
    }

    public function getTravelFrequency()
    {

    }

    public function getParentKeyRecord($parentKey)
    {
        return $this->getPatienActivetHealthRecord()
                    ->where('parent_key', '=', $parentKey)
                    ->where('child_key', '=', null)
                    ->first();
    }

    public function getChildKeyRecord($parentKey, $childKey)
    {
        return $this->getPatienActivetHealthRecord()
                    ->where('parent_key', '=', $parentKey)
                    ->where('child_key', '=', $childKey)->first();
    }


    public function upsertStroke(Request $request)
    {
        if ($request->parent_key != 'stroke') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getStroke(Request $request)
    {
        $stroke = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'stroke')->first();
        if (!empty($stroke)) {
            return response()->json([
                'success' => true,
                'data' => $stroke
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertStrokeReason(Request $request)
    {
        if (!in_array($request->parent_key, $this->strokeKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->strokeKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getStrokeReason()
    {
        $strokeReason = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'stroke')->where('child_key', '=', 'reason-for-stroke')->first();
        if (!empty($strokeReason)) {
            return response()->json([
                'success' => true,
                'data' => $strokeReason
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertTia(Request $request)
    {
        if ($request->parent_key != 'tia') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getTia(Request $request)
    {
        $stroke = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'tia')->first();
        if (!empty($stroke)) {
            return response()->json([
                'success' => true,
                'data' => $stroke
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertTiaTreatment(Request $request)
    {
        if (!in_array($request->parent_key, $this->tiaKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->tiaKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getTiaTreatment()
    {
        $tiaCoronary = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'tia')->where('child_key', '=', 'regular-treatment')->first();
        if (!empty($tiaCoronary)) {
            return response()->json([
                'success' => true,
                'data' => $tiaCoronary
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertCoronary(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getCoronary()
    {
        $tiaCoronary = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'coronary-heart-ischemic-heart')->first();
        if (!empty($tiaCoronary)) {
            return response()->json([
                'success' => true,
                'data' => $tiaCoronary
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertAnginaPain(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getAnginaPain()
    {
        $tiaAnginaPain = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'angina-pain')->first();
        if (!empty($tiaAnginaPain)) {
            return response()->json([
                'success' => true,
                'data' => $tiaAnginaPain
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertRegularMedication(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getRegularMedication()
    {
        $regularMedication = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'regular-medication')->first();
        if (!empty($regularMedication)) {
            return response()->json([
                'success' => true,
                'data' => $regularMedication
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertHeartAttack(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getHeartAttack()
    {
        $tiaHeartAttack = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'heart-attack')->first();
        if (!empty($tiaHeartAttack)) {
            return response()->json([
                'success' => true,
                'data' => $tiaHeartAttack
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertEcg(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getEcg()
    {
        $tiaEcg = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'ecg')->first();
        if (!empty($tiaEcg)) {
            return response()->json([
                'success' => true,
                'data' => $tiaEcg
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertCoronaryAngiography(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getCoronaryAngiography()
    {
        $tiaEcg = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'coronary-angiography')->first();
        if (!empty($tiaEcg)) {
            return response()->json([
                'success' => true,
                'data' => $tiaEcg
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertBypassSurgery(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getBypassSurgery()
    {
        $tiaBypassSurgery = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'bypass-surgery')->first();
        if (!empty($tiaBypassSurgery)) {
            return response()->json([
                'success' => true,
                'data' => $tiaBypassSurgery
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertStentPlacement(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getStentPlacement()
    {
        $tiaStentPlacement = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'stent-placement')->first();
        if (!empty($tiaStentPlacement)) {
            return response()->json([
                'success' => true,
                'data' => $tiaStentPlacement
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function upsertValveSurgery(Request $request)
    {
        if (!in_array($request->parent_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, $this->cardiovascKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getValveSurgery()
    {
        $tiaValveSurgery = $this->getPatienActivetHealthRecord()->where('parent_key', '=', 'cardiovascular-or-stroke')->where('child_key', '=', 'valve-surgery')->first();
        if (!empty($tiaValveSurgery)) {
            return response()->json([
                'success' => true,
                'data' => $tiaValveSurgery
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => (object) []
        ]);
    }

    public function getHraScore()
    {
        return response()->json([
            'success' => true,
            'data' => ['hra' => $this->getHRA()]
        ]);
    }

    public function getPatientHraBandData(Request $request)
    {
        $patient = Auth::user();

        $patientHraData = $this->getActiveHraBandDataRecord($patient);

        return response()->json([
            'success' => true,
            'data' => $patientHraData
        ]);
    }

    public function getBloodPressureAllData()
    {
        $bloodPressureData = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'blood-pressure')->get();
        $data = new \stdClass;
        $data->systolic = '';
        $data->diastolic = '';
        foreach($bloodPressureData as $bloodPressure) {
            if ($bloodPressure->child_key == 'systolic') {
                $data->systolic = $bloodPressure->value;
            }

            if ($bloodPressure->child_key == 'diastolic') {
                $data->diastolic = $bloodPressure->value;
            }
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function getActiveHraBandDataRecord($patient)
    {
        return $this->patientHraData->where('patient_id', '=', $patient->id)
                    ->where('active', '=', '1')
                    ->first();
    }
    public function upsertPatientHraBandData(Request $request)
    {
        try {
            $patient = Auth::user();
            $patientHraData = $this->getActiveHraBandDataRecord($patient);
            if ($patientHraData) {
                $patientHraData->active = '0';
                if (!$patientHraData->save()) {
                    throw new \Exception("Failed to save HRA data..");
                }
            }
            $patientHraData = $this->patientHraData;
            $patientHraData->patient_id = $patient->id;
            $patientHraData->hra = $request->hra;
            if (!empty($request->is_loved_one) && $request->is_loved_one == '1') {
                $patientHraData->is_loved_one = $request->is_loved_one;
            } else {
                $patientHraData->is_loved_one = '0';
            }
            $patientHraData->active = '1';
            if (!$patientHraData->save()) {
                throw new \Exception("Failed to save HRA data..");
            }
            return response()->json([
                'success' => true,
                'message' => "HRA data saved successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function upsertEcgScore(Request $request)
    {
        if (!in_array($request->parent_key, ['hra-band-data'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, ['ecg-score'])) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }

        if (empty($request->score)) {
            return response()->json([
                'success' => false,
                'error' => "Score should not be null"
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function upsertPpgScore(Request $request)
    {
        if (!in_array($request->parent_key, ['hra-band-data'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, ['ppg-score'])) {
            return response()->json([
                'success' => false,
                'message' => 'Child Parent key'
            ]);
        }

        if (empty($request->score)) {
            return response()->json([
                'success' => false,
                'error' => "Score should not be null"
            ]);
        }
        return $this->upsertRecord($request);
    }

    public function getAllCardiovascularData()
    {
        $allCardiovascularData = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'cardiovascular-or-stroke')->get();
        $data = new \stdClass;
        $data->coronary_heart_ischemic_heart = '';
        $data->angina_pain = '';
        $data->regular_medication = '';
        $data->heart_attack = '';
        $data->ecg = '';
        $data->coronary_angiography = '';
        $data->bypass_surgery = '';
        $data->stent_placement = '';
        $data->valve_surgery = '';
        foreach ($allCardiovascularData as $cardio) {
            if ($cardio->child_key == 'coronary-heart-ischemic-heart') $data->coronary_heart_ischemic_heart = $cardio->value;
            if ($cardio->child_key == 'angina-pain') $data->angina_pain = $cardio->value;
            if ($cardio->child_key == 'regular-medication') $data->regular_medication = $cardio->value;
            if ($cardio->child_key == 'heart-attack') $data->heart_attack = $cardio->value;
            if ($cardio->child_key == 'ecg') $data->ecg = $cardio->value;
            if ($cardio->child_key == 'coronary-angiography') $data->coronary_angiography = $cardio->value;
            if ($cardio->child_key == 'bypass-surgery') $data->bypass_surgery = $cardio->value;
            if ($cardio->child_key == 'stent-placement') $data->stent_placement = $cardio->value;
            if ($cardio->child_key == 'valve-surgery') $data->valve_surgery = $cardio->value;
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function upsertNutritionData(Request $request)
    {
        if (!in_array($request->parent_key, ['nutrition'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, ['Breakfast', 'Lunch', 'Snacks', 'Dinner'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }
        try{
            $data = json_decode($request->extra_info, true);
            $date = date('Y-m-d',strtotime($data['date']));
            $time = $data['time'];

            PatientHealthProfile::updateOrcreate([
                'id' => $request->id,
            ],[
                'patient_id' => Auth::id(),
                'parent_key' => $request->parent_key,
                'child_key' => $request->child_key,
                'value' => $date,
                'unit' => $time,
                'extra_info' => $request->extra_info,
            ]);

            return response()->json(['success' => true, 'message' => 'Nutrition Added']);
        }
        catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function getNutritionData(Request $request)
    {
        $nutritions = PatientHealthProfile::select('id', 'extra_info')
                            ->where('patient_id', Auth::id())
                            ->where('parent_key', '=', 'nutrition')
                            ->when($request->type == 1, function($query){
                                $query->where('child_key', 'Breakfast');
                            })
                            ->when($request->type == 2, function($query){
                                $query->where('child_key', 'Lunch');
                            })
                            ->when($request->type == 3, function($query){
                                $query->where('child_key', 'Snacks');
                            })
                            ->when($request->type == 4, function($query){
                                $query->where('child_key', 'Dinner');
                            })
                            ->whereDate('value', $request->date)
                            ->get();

        if($nutritions->isEmpty())
        {
            return response()->json(['success' => false, 'message' => 'No Containt Found']);
        }

        $nutrition = NutritionResource::collection($nutritions);

        return response()->json(['success' => true, 'message' => 'Nutrition Retrieved Successfully', 'date' => $nutrition]);
    }

    public function deleteNutrition($id){

        $status = PatientHealthProfile::whereId($id)
                                        ->where('parent_key', 'nutrition')
                                        ->delete();

        if($status){
            return response()->json(['success' => true, 'message' => 'Nutrition Deleted Successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to Delete']);
    }

    // Excercise Api 
    public function upsertExercise(Request $request){
        if (!in_array($request->parent_key, ['excercise'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }   

        try{
            $data = json_decode($request->extra_info, true);
            $date = date('Y-m-d',strtotime($data['date']));

            PatientHealthProfile::updateOrCreate([
                'id' => $request->id,
            ],[
                'patient_id' => Auth::id(),
                'parent_key' => $request->parent_key,
                'value' => $date,
                'extra_info' => $request->extra_info,
            ]);

            return response()->json(['success' => true, 'message' => 'Excercise Added']);
        }
        catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function getExcerciseData(Request $request){
        $date=$request->date;
        $excercises = PatientHealthProfile::where('patient_id', Auth::id())
                                            ->where(function($q) use($date){
                                                $q->where('parent_key', '=', 'excercise')
                                                ->whereDate('value', $date);
                                            })
                                            ->orwhere(function($q) use ($date) {
                                                $q->whereDate('created_at',$date)
                                                 ->where('patient_id',Auth::id())
                                                  ->where('parent_key','pado-meter');
                                            })
                                            ->get();
       
        return ExcerciseResource::collection($excercises)->additional(
            ['success' => true, 'message' => 'Excercise Data']);
    }

    public function deleteExcercise($id){

        $status = PatientHealthProfile::whereId($id)
                                        ->where('parent_key', 'excercise')
                                        ->delete();

        if($status){
            return response()->json(['success' => true, 'message' => 'Excercise Deleted Successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to Delete']);
    }


    public function get_hhi(){
        $total = 125;

        try{
            $score = $this->calculate_hhi(Auth::id());
        }
        catch(\Exception $e){
            
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
        return response()->json(['success' => true, 'message' => 'HHI Of the Patient', 'score' => $score, 'total' => $total]);
    }

    public function setCaloriesTarget(Request $request){
        if (!in_array($request->parent_key, ['calories'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, ['target'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        try 
        {
            $calories_create = PatientHealthProfile::where('value', $request->date)->where('patient_id',Auth::id())->whereParentKey('calories')->first();
            if ($calories_create) {
                $calories_create->parent_key = $request->parent_key;
                $calories_create->child_key = $request->child_key;
                $calories_create->value = $request->date;
                $calories_create->unit = $request->target;
            } else {
                $calories_create = new PatientHealthProfile();
                $calories_create->patient_id = Auth::id();
                $calories_create->parent_key = $request->parent_key;
                $calories_create->child_key = $request->child_key;
                $calories_create->value = $request->date;
                $calories_create->unit = $request->target;
            }
            $calories_create->save();

            return response()->json(['success' => true, 'message' => 'Calories Target Set']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function getCaloriesTarget(Request $request){

        $newDate = date("Y-m-d", strtotime($request->date));
        $caloriesTarget = PatientHealthProfile::whereParentKey('calories')
                                                ->whereChildKey('target')
                                                ->wherePatientId(Auth::id())
                                                ->where('value',"$newDate")
                                                ->first();
       // $caloriesTarget = PatientHealthProfile::where('patient_id',Auth::id())->get();
        //dd($caloriesTarget);

        if($caloriesTarget){
            return response()->json(['success' => true, 'message' => 'Calories Target', 'data' => $caloriesTarget->unit]);
        }
        else { 
            $last = PatientHealthProfile::whereParentKey('calories')
                                        ->whereChildKey('target')
                                        ->wherePatientId(Auth::id())
                                        ->latest('created_at')->first();

            if ($last) {
                # code...
                return response()->json(['success' => true, 'message' => 'Latest Calories Target', 'data' => $last->unit]);
            }
        }

        return response()->json(['success' => true, 'message' => 'No Calories Target']);

      
    }

    public function upsertHraBandDataDevice2(Request $request)
    {
        if (!in_array($request->parent_key, ['hra-band-data'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        if (!in_array($request->child_key, ['device-2'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Child key'
            ]);
        }

        try{
            // Add Entry in History Table
            $user = Auth::user();
            $extra_info = json_decode($request->extra_info, true);
            
            if(History::whereSynched($extra_info['synchedId'])->exists()){
                return response()->json(['success' => false, 'message' => 'Synced Id already exists']);
            }

            $history = new History();
            $history->user_id = Auth::id();
            $history->afib = $extra_info['AFIB'];
            $history->arrhythmia = $extra_info['Arrythmia'];
            $history->artrialage = 0;
            $history->bp = $extra_info['Bp'];
            $history->hr = $extra_info['Heartrate'];
            $history->hrvlevel = $extra_info['HRVLevel'];
            $history->rpwv = $extra_info['rPWV'];
            $history->synched = $extra_info['synchedId'];
            $history->date = $extra_info['date'];
            $history->save();
            
            return response()->json(['success' => true, 'message' => 'Band Data Saved Successfully']);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }

        return response()->json(['success' => false, 'message' => 'Failed To Add Band Data']);
    }


  //   public function saveEcgImage(Request $request)
  //   {
  //       $patient = Auth::user();

		// $ecgImage = $request->file('ecg_image');
		// if ($ecgImage) {

		// 	$path = public_path().'/images/hra-band-data/device-2/';
		// 	$this->removeOldHraDataImage($patient->id, 'ecg');

		// 	$extension = $ecgImage->getClientOriginalExtension();
		// 	// we have an image, get the image data
		// 	// $data = base64_encode(file_get_contents($_FILES['app_image']['tmp_name']));
		// 	$fileName = 'ecg-' . $patient->id . '.' . $extension;

		// 	if ($ecgImage->move($path, $fileName)) {
		// 		return response()->json([
		// 			'success' => true,
		// 			'image_url' => url('/images/hra-band-data/device-2/' . $fileName)
		// 		]);
		// 	} else {
		// 		return response()->json([
		// 			'success' => false,
		// 			'message' => 'Cant upload profile image, try again later'
		// 		]);
		// 	}
		// }
  //   }

  //   public function removeOldHraDataImage($patientId, $type)
  //   {
  //       $path = public_path().'/images/hra-band-data/device-2/';
  //       $file_pattern = $path . $type . '-' . $patientId . ".*";
  //       array_map( "unlink", glob( $file_pattern ) );
  //   }

  //   public function savePpgImage(Request $request)
  //   {
  //       $patient = Auth::user();

		// $ppgImage = $request->file('ppg_image');
		// if ($ppgImage) {

		// 	$path = public_path().'/images/hra-band-data/device-2/';
		// 	$this->removeOldHraDataImage($patient->id, 'ppg');

		// 	$extension = $ppgImage->getClientOriginalExtension();
		// 	// we have an image, get the image data
		// 	// $data = base64_encode(file_get_contents($_FILES['app_image']['tmp_name']));
		// 	$fileName = 'ppg-' . $patient->id . '.' . $extension;

		// 	if ($ppgImage->move($path, $fileName)) {
		// 		return response()->json([
		// 			'success' => true,
		// 			'image_url' => url('/images/hra-band-data/device-2/' . $fileName)
		// 		]);
		// 	} else {
		// 		return response()->json([
		// 			'success' => false,
		// 			'message' => 'Cant upload profile image, try again later'
		// 		]);
		// 	}

		// }
  //   }

  //   public function getHraBandDataDevice2Image($type)
  //   {
  //       $patient = Auth::user();

  //       if (!empty(glob( public_path() . '/images/hra-band-data/device-2/' . $type .'-'.  $patient->id  . '.*') ) ) {
		// 	$extension = pathinfo( glob( public_path() . '/images/hra-band-data/device-2/' . $type . '-' . $patient->id  . '.*')[0])['extension'];
		// 	return  url('/images/hra-band-data/device-2/' . $type .'-'. $patient->id . '.' . $extension);
		// }

		// return  null;
  //   }

    public function getHraBandDataDevice2()
    {

        $hraBandDevice2Data = $this->getPatienActivetHealthRecord()
                                ->where('parent_key', '=', 'hra-band-data')
                                ->where('child_key', '=', 'device-2')->first();
        $hraBandDevice2Data = json_decode($hraBandDevice2Data->extra_info, TRUE);

        $hraBandDevice2Data['ecg_image_url'] = $this->getHraBandDataDevice2Image('ecg');
        $hraBandDevice2Data['ppg_image_url'] = $this->getHraBandDataDevice2Image('ppg');

        return response()->json([
            'success' => true,
            'data' => $hraBandDevice2Data
        ]);
    }

    public function upsertHereditary(Request $request)
    {
        try{

            if (!in_array($request->parent_key, ['hereditary'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Parent key'
                ]);
            }
            if (!in_array($request->child_key, ['heart-related-condition', 'diabetes', 'high-cholestrol'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Child key'
                ]);
            }

            $today = Carbon::now()->toDateString();

            $hereditary = PatientHealthProfile::where('parent_key', '=', 'hereditary')
                                                ->where('child_key', '=', $request->child_key)
                                                ->where('patient_id', Auth::id())
                                                ->whereDate('created_at', $today)
                                                ->first(); 
            if($hereditary)
            {
                $hereditary->value = $request->value;
                $hereditary->save();
            }
            else{

                $hereditary = PatientHealthProfile::where('parent_key', 'hereditary')
                                                    ->where('child_key', $request->child_key)
                                                    ->where('patient_id', Auth::id())
                                                    ->where('active', 1)
                                                    ->first();

                if($hereditary){
                    $hereditary->active = 0;
                    $hereditary->save();
                }

                $hereditary = new PatientHealthProfile();
                $hereditary->patient_id = Auth::id();
                $hereditary->parent_key = $request->parent_key;
                $hereditary->child_key = $request->child_key;
                $hereditary->value = $request->value;
                $hereditary->active = 1;
                $hereditary->save();
            }
        }
        catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }

        return response()->json(['success' => true, 'message' => 'Data saved']);
    }

    public function getHereditary(Request $request)
    {
        if (!in_array($request->parent_key, ['hereditary'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }

        $hereditary =  PatientHealthProfile::select('parent_key', "child_key", 'value')
                                            ->where('patient_id', Auth::id())
                                            ->where('parent_key', '=', $request->parent_key)
                                            ->get();

        if($hereditary->isNotEmpty()){
            return response()->json(['success' =>true, 'message' => 'Data Retrived Successfully', 'data' => $hereditary]);
        }

        return response()->json(['success' => false, 'message' => 'No Containt Found']);
    }

    public function getPatientHealthProfile(){

        try{   
            $count = 0;
            $total_count = 0;
            $user_id = Auth::id();

            // Calculate patient profile data 
            $data = PatientProfile::select('gender','height_cm','blood_group','weight_kg','occupation','dob','national_id')
                                    ->where('patient_id', $user_id)
                                    ->first();

            if($data){
                $data = $data->toArray();
                $total_count = count($data);
                $data = collect($data);

                $data = $data->filter(function($value, $key){
                    return $value != Null;
                });

                $count = $data->count();
            }

            // Calculate patient health profile

            $parent_key = ['diet-type', 'travel-national', 'travel-international', 'cup-of-vegetables', 'cereals-qty', 'fruits',
                           'fast-food', 'drinks', 'vigorus-physical-activity', 'moderate-physical-activity', 'light-physical-activity',
                           'smoking', 'diebetic', 'blood-cholestrol', 'blood-pressure', 'cardiovascular-or-stroke', 'disease', 'allergy',
                           'medication', 'hereditary', 'alcohol'
                        ];

            $count += PatientHealthProfile::where('patient_id', $user_id)
                                        ->whereActive(1)
                                        ->whereIn('parent_key', $parent_key)
                                        ->get()
                                        ->unique('parent_key')
                                        ->count();

            $total_count += count($parent_key);

            $percentage = round(($count/$total_count)*100);
            $percentage = ($percentage < 100) ? $percentage : 100;

            return response()->json(['success' =>true, 'message' => 'Patient Profile Percentage', 'data' => $percentage]);
        }
        catch(Exception $e){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    public function PadometerHistory(Request $request)
    {
        
        try{
        $padometer = PatientHealthProfile::select('extra_info')->where('patient_id', Auth::id())
        ->where('parent_key', 'pado-meter')

       // ->where('active', 1)
        ->get();
        $data=[];
        $date=[];
        if(!empty($padometer))
        {
            foreach( $padometer as $key=>$value)
            {
             $rs=json_decode($value->extra_info,true);
             if(!in_array(@$rs['date'],$date))
             {
                $data[]=$rs;
             }
             
             $date[]=@$rs['date'];
            }

        }
      
       }catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
        return response()->json(['success' => true, 'message' => 'Pado meter data','data'=>$data]);    
    }
    public function upsertPadoMeterData(Request $request)
    {
        
        if (!in_array($request->parent_key, ['pado-meter'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Parent key'
            ]);
        }
        try {
            $today = Carbon::now()->toDateString();
            
            $padometer = PatientHealthProfile::where('parent_key', 'pado-meter')
                                        ->where('patient_id', Auth::id())
                                        ->whereDate('created_at', $today)
                                        ->first();
             $extra=json_decode($request->extra_info,true);
             $extra['desc']='pedometer';
              
            if($padometer){
                $padometer->extra_info = json_encode($extra);
                $padometer->save();
                ///dd($extra);
            }else{

                $padometer = PatientHealthProfile::where('patient_id', Auth::id())
                                                ->where('parent_key', 'pado-meter')
                                                ->where('active', 1)
                                                ->first();
                if($padometer){
                    $padometer->active = 0;
                    $padometer->save();
                }

                $padometer = new PatientHealthProfile();
                $padometer->parent_key = $request->parent_key;
                $padometer->patient_id = Auth::id();
                $padometer->extra_info = json_encode($extra);
                $padometer->active = 1;
                $padometer->save();
            }

            return response()->json(['success' => true, 'message' => 'Successfully updated']);    
        } 
        catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }
    }

    /**
	 * new medical report
	 *
	 * @api
	 * @param \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function setMedicalReport(Request $request)
	{
		$validator = validator($request->all(), [
            'heart_rate' => 'required',
            'bp' => 'required',
            'sugar_fasting' => 'required',
            'sugar_non_fasting' => 'required',
            'triglycerides' => 'required',
            'hdl_cholesterol' => 'required',
            'ldl_cholesterol' => 'required',
            'report_file' => 'required'
			
		]);


		if ($validator->fails()) {
			
			return response()->json(['error' => $validator->errors()],401);
        }
        if ($request->hasFile('report_file')) {
            $pdf = $request->file('report_file');
            $name =  $pdf->getClientOriginalName();
            $destinationPath = public_path('/medicalReport');
            $pdf->move($destinationPath, $name);
        }
		$medical_report = MedicalReport::create([
			'patient_id' => Auth::id(),
			'heart_rate' => $request->heart_rate,
			'bp' => $request->bp,
			'sugar_fasting' => $request->sugar_fasting,
			'sugar_non_fasting' => $request->sugar_non_fasting,
			'triglycerides' => $request->triglycerides,
			'hdl_cholesterol' => $request->hdl_cholesterol,
            'ldl_cholesterol' => $request->ldl_cholesterol,
            'report_file' => $name
			
		]);

		return response()->json(['success' =>true, 'message' => 'Medical Report Created']);
    }

    /**
     *  function to get medical report
     */
    public function getMedicalReport(){

        $medicalReport = MedicalReport::wherePatientId(Auth::id())
                                        ->get();
       
        if($medicalReport){
            return response()->json(['success' => true, 'message' => 'Medical Report', 'data' => $medicalReport]);
        }

            return response()->json(['success' => false, 'message' => 'Medical Report Not Found']);
    }

    /**
     * function to insert podo meter date and steps
     */
    public function setPadameterSteps(Request $request){
        $validator = validator($request->all(), [
            'date' => 'required',
            'steps' => 'required|numeric'
        ]);

        if ($validator->fails()) {
			
			return response()->json(['error' => $validator->errors()],401);
        }
        
        try 
        {
            $create_padometer_steps = Padometer::where('date', $request->date)->wherePatientId(Auth::id())->first();
            if (!empty($create_padometer_steps)) {
                $create_padometer_steps->date = $request->date;
                $create_padometer_steps->steps = $request->steps;
            } else {
                $create_padometer_steps = new Padometer();
                $create_padometer_steps->patient_id = Auth::id();
                $create_padometer_steps->date = $request->date;
                $create_padometer_steps->steps = $request->steps;
                
            }
            $create_padometer_steps->save();

            return response()->json(['success' => true, 'message' => 'Pado meter steps Target Set']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something Went Wrong', 'error' => $e]);
        }
    }

    public function getPadameterSteps(Request $request){
        
         
        $validator = validator($request->all(), [
            'dates' => 'required',
             
        ]);

        if ($validator->fails()) {
			
			return response()->json(['error' => $validator->errors()],401);
        }
        $create_padometer_steps = Padometer::wherePatientId(Auth::id())
                                        ->where('date',$request->date)
                                        ->get();
       
        if($create_padometer_steps){
            return response()->json(['success' => true, 'message' => 'Pado meter steps details', 'data' => $create_padometer_steps]);
        }

            return response()->json(['success' => false, 'message' => 'Pado meter steps detail Not Found']);
    }
    function PadameterSteps(Request $request){
        $validator = validator($request->all(), [
            'date' => 'required',
             
        ]);
       //dd(Auth::id());
        if ($validator->fails()) {
			
			return response()->json(['error' => $validator->errors()],401);
        }
        $create_padometer_steps = Padometer::wherePatientId(Auth::id())
                                        ->where('date',$request->date)
                                        ->get();
       
        if($create_padometer_steps){
            return response()->json(['success' => true, 'message' => 'Pado meter steps details', 'data' => $create_padometer_steps]);
        }

            return response()->json(['success' => false, 'message' => 'Pado meter steps detail Not Found']);
    }
}

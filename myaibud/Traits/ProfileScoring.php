<?php

namespace Myaibud\Traits;

use Auth;
use Myaibud\Models\Patient\PatientHealthProfile;

trait ProfileScoring
{
    public function calculateQuestionScore($questionRecord, $parentKey, $childKey)
    {
        if ($parentKey == 'cup-of-vegetables') {
            $this->calculateVegetableScore($questionRecord);
        } elseif ($parentKey == 'fruits') {
            $this->calculateFruitScore($questionRecord);
        } elseif ($parentKey == 'cereals-qty') {
            $this->calculateCerealScore($questionRecord);
        } elseif ($parentKey == 'fast-food') {
            $this->calculateFastFoodScore($questionRecord);
        } elseif ($parentKey == 'drinks') {
            $this->calculateDrinkScore($questionRecord);
        } elseif ($parentKey == 'smoking' && $childKey == null) {
            $this->calculateSmokingScore($questionRecord);
        } elseif ($parentKey == 'smoking' && $childKey == 'end-age') {
            $this->calculateSmokingQuitScore($questionRecord);
        } elseif ($parentKey == 'alcohol' && $childKey == null) {
            $this->calculateAlcoholScore($questionRecord);
        } elseif ($parentKey == 'alcohol' && !empty($childKey)) {
            $this->calculateAlcoholConsumptionScore($questionRecord);
        } elseif ($parentKey == 'vigorus-physical-activity') {
            $this->calculateVigorusActivityScore($questionRecord);
        } elseif ($parentKey == 'moderate-physical-activity') {
            $this->calculateModerateActivityScore($questionRecord);
        } elseif ($parentKey == 'light-physical-activity') {
            $this->calculateLightActivityScore($questionRecord);
        } elseif ($parentKey == 'diebetic' && $childKey == null) {
            $this->calculateDiebeticScore($questionRecord);
        } elseif ($parentKey == 'diebetic' && $childKey == 'medicine') {
            $this->calculateDiebeticMedicineScore($questionRecord);
        } elseif ($parentKey == 'blood-cholestrol') {
            $this->calculateBloodCholestrolScore($questionRecord);
        } elseif ($parentKey == 'cardiovascular-or-stroke') {
            $this->calculateCardiovascularScore($questionRecord);
        } elseif ($parentKey == 'hereditary') {
            $this->calculateHereditaryScore($questionRecord);
        }
    }

    public function calculateHereditaryScore($record)
    {
        $value = $record->value;
        if ($value == 'yes') {
            $score = 0;
        } elseif ($value == 'no') {
            $score = 10;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 10
    public function calculateCardiovascularScore($record)
    {
        $value = $record->value;
        if ($value == 'yes') {
            $score = 0;
        } elseif ($value == 'no') {
            $score = 10;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 10
    public function calculateBloodCholestrolScore($record)
    {
        $value = $record->value;
        $score = null;
        if (trim(strtolower($value),' ') == 'less than 200') {
            $score = 10;
        } elseif(trim(strtolower($value), ' ') == '200-400') {
            $score = 5;
        } elseif(trim(strtolower($value), ' ') == 'more than 240') {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 10
    public function calculateDiebeticScore($record)
    {
        $value = $record->value;
        if ($value == 'no') {
            $score = 10;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    public function calculateDiebeticMedicineScore($record)
    {
        $value = $record->value;

        if (strtolower($value) == 'taking medicine with normal sugar levels') {
            $score = 5;
        } elseif (strtolower($value) == 'taking medicine but higher sugar levels') {
            $score = 0;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 4
    public function calculateVigorusActivityScore($record)
    {
        $value = $record->value;
        if ($value > 2) {
            $score = 4;
        } else if ($value > 0 && $value <= 2) {
            $score = 2;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 3
    public function calculateModerateActivityScore($record)
    {
        $value = $record->value;
        if ($value >= 3) {
            $score = 3;
        } else if ($value > 0 && $value <= 3) {
            $score = 2;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 3
    public function calculateLightActivityScore($record)
    {
        $value = $record->value;
        if ($value >= 7) {
            $score = 3;
        } else if ($value >= 4 && $value < 7) {
            $score = 1;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // MAX SCORE = 10
    public function calculateAlcoholConsumptionScore($record)
    {
        if ($record->child_key != 'alcohol-interval') {
            return false;
        }
        $alcoholSmallDosage =  $this->getPatienActivetHealthRecord()
                                        ->where('child_key', '=', 'alcohol-small-dosage')->first();
        $alcoholMediumDosage =  $this->getPatienActivetHealthRecord()
                                        ->where('child_key', '=', 'alcohol-medium-dosage')->first();
        $alcoholLargeDosage =  $this->getPatienActivetHealthRecord()
                                        ->where('child_key', '=', 'alcohol-large-dosage')->first();

        if (!isset($alcoholSmallDosage->value) && !isset($alcoholMediumDosage->value) && !isset($alcoholLargeDosage->value)) {
            return false;
        }
        $alcoholSmallDosage = isset($alcoholSmallDosage->value) ? (int) $alcoholSmallDosage->value : 0 ;
        $alcoholMediumDosage = isset($alcoholMediumDosage->value) ? (int) $alcoholMediumDosage->value : 0 ;
        $alcoholLargeDosage = isset($alcoholLargeDosage->value) ? (int) $alcoholLargeDosage->value : 0 ;
        $totalConsumptionCount = $alcoholSmallDosage + $alcoholMediumDosage + $alcoholLargeDosage;

        if ($totalConsumptionCount <= 3) {
            $score = 10;
        } else {
            $score = 0;
        }

        $record->update(['score' => $score]);
    }

    public function calculateAlcoholScore($record)
    {
        $value = $record->value;
        if ($value == 'yes') {
            $score = 0;
        } elseif ($value == 'no') {
            $score = 5;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // SMOKING MAX SCORE = 10
    public function calculateSmokingQuitScore($record)
    {
        $patient = Auth::user()->patientProfile();
        // dd(Auth::user()->id);
        $startAge = 0;
        $startAge = $this->getPatienActivetHealthRecord()->where('parent_key', '=', $record->parent_key)->where('child_key', '=', 'start-age')->first();
        if (!empty($startAge)) {
            $startAge = (int) $startAge->value;
        }
        $endAge = (int) $record->value;
        $diffYear = $endAge - $startAge;

        if ($diffYear == 1) {
            $score = 5;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    public function calculateSmokingScore($record)
    {
        $value = $record->value;
        if ($value == 'yes') {
            $score = 0;
        } else {
            $score = 10;
        }
        $record->update(['score' => $score]);
    }

    // SODA/SOFT DRINKS MAX SCORE = 2
    public function calculateDrinkScore($record)
    {
        $value = $record->value;

        if ($value < 4) {
            $score = 2;
        } elseif ($value >= 4 && $value < 10) {
            $score = 1;
        } elseif ($value >= 10) {
            $score = 0;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }


    // FAST FOOD MAX SCORE = 2
    public function calculateFastFoodScore($record)
    {
        $value = $record->value;

        if ($value < 7) {
            $score = 2;
        } elseif ($value >= 7 && $value < 15) {
            $score = 1;
        } elseif ($value >= 15) {
            $score = 0;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // FIBRE/CEREALS MAX SCORE = 2
    public function calculateCerealScore($record)
    {
        $value = $record->value;
        if ($value <= 10) {
            $score = 0;
        } elseif ($value >= 11 && $value <= 20) {
            $score = 1;
        } elseif ($value >= 21) {
            $score = 2;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // FRUITS MAX SCORE = 2
    public function calculateFruitScore($record)
    {
        $value = $record->value;
        if ($value <= 7) {
            $score = 0;
        } elseif ($value >= 8 && $value <= 15) {
            $score = 1;
        } elseif ($value >= 16) {
            $score = 2;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // VEGETABLES MAX SCORE = 2
    public function calculateVegetableScore($record)
    {
        $value = $record->value;
        if ($value <= 10) {
            $score = 0;
        } elseif ($value >= 11 && $value <= 15) {
            $score = 1;
        } elseif ($value >= 16) {
            $score = 2;
        } else {
            $score = 0;
        }
        $record->update(['score' => $score]);
    }

    // BMI MAX SCORE = 10
    public function calculateBmiScore($patientProfile)
    {
        $bmi = $patientProfile->first()->bmi;
        if (empty($bmi)) {
            $bmi = 0;
        }
        if ($bmi < 15) {
            $bmiScore = 0;
        } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
            $bmiScore = 10;
        } elseif ( ($bmi >= 15 && $bmi < 18.5) || ($bmi >= 25 && $bmi < 29.9)  ) {
            $bmiScore = 5;
        } elseif ($bmi >= 30) {
            $bmiScore = 0;
        } else {
            $bmiScore = 0;
        }
        $patientProfile->update(['bmi_score' => $bmiScore]);
    }

    public function getPatienActivetHealthRecord()
    {
        $patientHealthProfile = new PatientHealthProfile;
        $patient = Auth::user();
        return $patientHealthProfile
                    ->where('patient_id', '=', $patient->id)
                    ->where('active', '=', '1');
    }

    public function getBandBpScoreCalculation()
    {
        $patient = Auth::user();

        $hraBandData = $this->getActiveHraBandDataRecord($patient);

        if (!empty($hraBandData)) {
            $systolic =  !empty($hraBandData->hra['systolic']) ? (int) $hraBandData->hra['systolic'] : 0;
            $diastolic = !empty($hraBandData->hra['diastolic']) ? (int) $hraBandData->hra['diastolic'] : 0;
            $score = 0;
            if ($systolic < 120 && $diastolic < 80) {
                $score = 10;
            } elseif ( ($systolic >= 120 && $systolic <= 140) && ($diastolic >= 80 && $diastolic <= 90) ) {
                $score = 5;
            } elseif ($systolic > 140 && $diastolic > 90) {
                $score = 0;
            } else {
                $score = 0;
            }
            return $score;
        } else {
            return 0;
        }
    }

    public function getHRA()
    {
        $_score = 150;

        $patientHealthProfile = new PatientHealthProfile;
        $patient = Auth::user();

        $bmiScore = 0;

        // GET BP SCORE
        $hraBandBpScore = $this->getBandBpScoreCalculation();

        if ($patient->patientProfile != null) {
            $bmiScore = $patient->patientProfile->bmi_score;
        }

        $healthScore = (int) $patientHealthProfile
                    ->where('patient_id', '=', $patient->id)
                    ->where('active', '=', '1')->where('score', '!=', null)->sum('score');
        $totalScore = $bmiScore + $healthScore + $hraBandBpScore;
        // dd($bmiScore, $healthScore, $hraBandBpScore);
        $finalScore = $totalScore/$_score * 100;

        return number_format((float)$finalScore, 0, '.', '') . '%';

    }
}

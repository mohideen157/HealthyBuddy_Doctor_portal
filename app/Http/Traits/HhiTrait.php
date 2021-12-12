<?php

namespace App\Http\Traits;


use App\Model\History;
use App\Model\Patient\PatientHhi;
use App\Model\Patient\PatientProfile;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Str;
use Myaibud\Models\Patient\PatientHealthProfile;

trait HhiTrait
{
    public function calculate_hhi($patient_id){
        $score = 0;
        $patient_health_profile = PatientHealthProfile::where('patient_id', $patient_id)
                                                ->where('active', 1);

        $patient_profile = PatientProfile::where('patient_id', $patient_id)->first();

        $bmr = $this->calculate_bmr($patient_profile);
        $calories_intake = $this->calculate_calories_intake($patient_health_profile);
        $calories_burned = $this->calculate_calories_burned($patient_health_profile);

        $score += $this->calculate_ecg_score($patient_id);
        $score += $this->calculate_bmi_score($patient_profile);
        $score += $this->calculate_vegetable_score($patient_health_profile);
        $score += $this->calculate_fruit_score($patient_health_profile);
        $score += $this->calculate_fibre_score($patient_health_profile);
        $score += $this->calculate_fast_food_score($patient_health_profile);
        $score += $this->calculate_soda_score($patient_health_profile);
        $score += $this->calculate_alcohol_score($patient_health_profile);
        $score += $this->calculate_running_score($patient_health_profile);
        $score += $this->calculate_sports_score($patient_health_profile);
        $score += $this->calculate_walking_score($patient_health_profile);
        $score += $this->calculate_diabetic_score($patient_health_profile);
        $score += $this->calculate_cholesterol_score($patient_health_profile);
        $score += $this->calculate_bp_score($patient_health_profile);
        $score += $this->calculate_stroke_score($patient_health_profile);
        $score += $this->calculate_hereditary_score($patient_health_profile);
        $score += $this->calculate_dynamic_calories($patient_profile, $bmr, $calories_intake, $calories_burned);

        $patient_hhi = PatientHhi::where('patient_id', $patient_id)
                                ->whereDate('created_at', today())
                                ->first();

        if(!$patient_hhi){
            $patient_hhi = new PatientHhi();
        }
        
        $patient_hhi->patient_id = $patient_id;
        $patient_hhi->hhi = $score;
        $patient_hhi->save();

        return $score;
    }

    public function calculate_ecg_score($patient_id)
    {
        $history = History::whereUserId($patient_id)->orderByDesc('date')->first();

        if($history){
            if($history->afib > 0 || $history->arrhythmia > 0){
                return 0;
            }
            return 25;
        }
        return 0;
    }

    public function calculate_bmi_score($patient_profile){
        $bmi_score = 0;

        if($patient_profile){
            $bmi = $patient_profile->bmi;

            if($bmi >= 18.5 && $bmi <= 24.9){
                $bmi_score = 10;
            }
            elseif(($bmi >= 15 && $bmi < 18.5) || ($bmi >= 25 && $bmi <=29.9)){
                $bmi_score = 5;
            }
            elseif($bmi >= 30 or $bmi <15){
                $bmi_score = 0;
            }
            return $bmi_score;
        }
        return 0;
    }

    public function calculate_vegetable_score($patient_health_profile){

        $data = clone $patient_health_profile;

        $score = 0;

        $cup_of_vegetables = $data->where('parent_key', 'cup-of-vegetables')
                                        ->first();

        if($cup_of_vegetables){
            $cup_of_vegetables = $cup_of_vegetables->value;

            if($cup_of_vegetables >= 16){
                $score = 2;
            }
            elseif($cup_of_vegetables >= 8 and $cup_of_vegetables <= 15){
                $score = 1;
            }elseif($cup_of_vegetables <= 10){
                $score = 0;
            }

            return $score;
        }
        return 0;
    } 

    public function calculate_fruit_score($patient_health_profile){
        $data = clone $patient_health_profile;
        $score = 0;

        $fruits = $data->where('parent_key', 'fruits')
                                        ->first();

        if($fruits){
            $fruits = $fruits->value;

            if($fruits >= 16){
                $score = 2;
            }
            elseif($fruits >= 8 and $fruits <= 15){
                $score = 1;
            }elseif($fruits <= 7){
                $score = 0;
            }
            return $score;
        }
        return 0;
    }

    public function calculate_fibre_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $fibre = $data->where('parent_key', 'cereals-qty')
                                        ->first();
        if($fibre){
            $fibre = $fibre->value;

            if($fibre >= 21){
                $score = 2;
            }
            elseif($fibre >= 11 and $fibre <= 20){
                $score = 1;
            }elseif($fibre <= 10){
                $score = 0;
            }
            return $score;
        }
        return 0;
    } 

    public function calculate_fast_food_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $fast_food = $data->where('parent_key', 'fast-food')
                                        ->first();
        if($fast_food){
            $fast_food = $fast_food->value;

            if($fast_food < 7){
                $score = 2;
            }
            elseif($fast_food >= 7 && $fast_food < 15){
                $score = 1;
            }elseif($fast_food >= 15){
                $score = 0;
            }
            return $score;
        }
        return 0;
    } 

    public function calculate_soda_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $drinks = $data->where('parent_key', 'drinks')
                                        ->first();
        if($drinks){
            $drinks = $drinks->value;

            if($drinks < 4){
                $score = 2;
            }
            elseif($drinks >= 4 and $drinks < 10){
                $score = 1;
            }elseif($drinks >= 10){
                $score = 0;
            }
            return $score;
        }
        return 0;
    }  

    public function calculate_alcohol_score($patient_health_profile)
    {
        $data = clone $patient_health_profile;
        $data1 = clone $patient_health_profile;
         
        $sum = 0;
        $score = 0;

        $alcohol = $data->where('parent_key', 'alcohol')
                        ->whereNull('child_key')
                        ->first();
        if(is_null($alcohol))
        {
            return $score = 0;
        }
        if($alcohol->value == 'No'){
            $score = 5;
        }
        else{
            $alcohols = $data1->where('parent_key', 'alcohol')
                            ->whereNotNull('child_key')
                            ->get();

            foreach ($alcohols as $alcohol) {
                if($alcohol->extra_info == 'Weekly'){
                    $sum += $alcohol->value;
                }
                elseif($alcohol->extra_info == 'Monthly'){
                    $sum += ($alcohol->value/4);
                }
                elseif($alcohol->extra_info == 'Yearly'){
                    $sum += ($alcohol->value/48);
                }
            }
            if($sum <= 3){
                $score = 10;
            }
            elseif($sum == 0){
                $score = 5;
            }
            elseif($sum > 3){
                $score = 0;
            }
        }
        return $score;
    } 

    public function calculate_running_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $running = $data->where('parent_key', 'vigorus-physical-activity')
                        ->sum('value');

        if($running > 2){
            $score = 4;
        }
        elseif($running > 0 && $running <=2){
            $score = 2;
        }
        elseif($running == 0){
            $score = 0;
        }
        return $score;
    }

    public function calculate_sports_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $sports = $data->where('parent_key', 'moderate-physical-activity')
                        ->sum('value');

        if($sports >= 3){
            $score = 3;
        }
        elseif($sports > 0 and $sports <= 3){
            $score = 2;
        }
        elseif($sports == 0){
            $score = 0;
        }
        return $score;
    }

    public function calculate_walking_score($patient_health_profile){
        $score = 0;
        $data = clone $patient_health_profile;

        $walking = $data->where('parent_key', 'light-physical-activity')
                        ->sum('value');

        if($walking >= 7){
            $score = 3;
        }
        elseif($walking >= 4 and $walking < 7){
            $score = 1;
        }
        elseif($walking < 4){
            $score = 0;
        }
        return $score;
    }

    public function calculate_diabetic_score($patient_health_profile){
        $data1 = clone $patient_health_profile;
        $data2 = clone $patient_health_profile;
        $score = 0;

        $diabetic  = $data1->where('parent_key', 'diebetic')
                            ->whereNull('child_key')->first();

        $diabetic_level = $data2->where('parent_key', 'diebetic')
                                ->where('child_key', 'medicine')
                                ->first();
         
        if(!is_null($diabetic_level)){
            if($diabetic_level->value === 'No'){
            $score = 10;
            }
            elseif($diabetic_level->value === 'Taking Medicine with Normal Sugar Levels' || $diabetic_level->value === 'Controlling HbA1C below 7 without medicines'){
                $score = 5;
            }
            elseif($diabetic_level->value === 'Taking Medicine but Higher Sugar Levels' || $diabetic_level->value === 'Not taking medicine and HbA1C above 7'){
                $score = 0;
            }  
        return $score;  
        }

        return 0;
    }

    public function calculate_cholesterol_score($patient_health_profile){
        $data = clone $patient_health_profile;
        $score = 0;
        
        $cholesterol = $data->where('parent_key', 'blood-cholestrol')
                            ->whereNull('child_key')
                            ->first();
                            
        if($cholesterol){
            if($cholesterol->value === 'Less than 200'){
                $score = 10;
            }
            elseif($cholesterol->value === '200–240'){
                $score = 5;
            }
            elseif($cholesterol->value === 'More than 240'){
                $score = 0;
            }
            return $score;
        }

        return 0;
    }

    public function calculate_bp_score($patient_health_profile){
        $data = clone $patient_health_profile;
        $score = 0;

        $data = $data->where('parent_key', 'hra-band-data')
                            ->where('child_key', 'device-2')
                            ->first();

        if($data){
            $extra_info = json_decode($data->extra_info, true);
            $bp = $extra_info['bp'];

            $systolic = Str::before($bp, '/');
            $diastolic =  Str::after($bp, '/');

            if($systolic < 120 && $diastolic <80){
                $score = 10;
            }
            // S Between 120 – 140  and/or D between 80 – 90
            elseif(($systolic >= 120 && $systolic <= 140) && ($diastolic >= 80 && $diastolic <= 90)){
                $score = 5;
            }
            elseif($systolic > 140 && $diastolic >90){
                $score = 0;
            }
            else{
                $score = 0;
            }
            return $score;
        }
        return 0;
    }

    public function calculate_stroke_score($patient_health_profile)
    {
        $data = clone $patient_health_profile;
        $score = 0;

        $stroke = $data->where('parent_key', 'stroke')
                 ->whereNull('child_key')
                    ->first();

        if($stroke){
            if($stroke->value == 'Yes'){
                $score = 0;
            }
            else{
                $score = 10;
            }
        }
        return $score;
    }

    public function calculate_hereditary_score($patient_health_profile)
    {
        $data = clone $patient_health_profile;
        $score = 0;
        
        $exists = $data->where('parent_key', 'hereditary')
                        ->where('value', 'Yes')
                        ->exists();

        if($exists){
            $score = 0;
        }else{
            $score = 10;
        }

        return $score;
    }

    public function calculate_bmr($patient_profile){

        $age = Helper::age($patient_profile->dob);
        $bmr = 0;

        if($patient_profile){

            if($patient_profile->gender === 'Male'){
                $bmr = 66 + (13.75 * $patient_profile->weight_kg) + (5 * $patient_profile->height_cm) - (6.8 * $age);
            }
            elseif($patient_profile->gender === 'Female'){
                $bmr = 655 + (9.6 * $patient_profile->weight_kg) + (1.8 * $patient_profile->height_cm) - (4.7 * $age);
            }
        }

        $bmr = round($bmr, 1);
        return $bmr;
    }

    public function calculate_calories_intake($patient_health_profile){
        $data = clone $patient_health_profile;
        $today =  Carbon::today()->toDateString();
        $calories_intake = 0;

        $nutritions = $data->where('parent_key', 'nutrition')
                            ->where('value', $today)
                            ->get();

        foreach ($nutritions as $nutrition) {
            $nutrition = json_decode($nutrition->extra_info, true);
            $calories_intake += $nutrition['calories'];
        }
        return $calories_intake;
    }

    public function calculate_calories_burned($patient_health_profile){
        $data = clone $patient_health_profile;
        $today = Carbon::today()->toDateString();
        $calories_burned = 0;

        $pado = $data->where('parent_key', 'pado-meter')
                    ->whereDate('created_at', $today)
                    ->first();

        if($pado){
            $data = json_decode($pado->extra_info, true);
            $calories_burned = $data['calories'];
        }
        return $calories_burned;
    }

    public function calculate_dynamic_calories($patient_profile, $bmr, $calories_intake, $calories_burned){
        $calories_ratio = 0;
        $dynamic_calories_score = 0;

        if($patient_profile){
            $bmi = (float)$patient_profile->bmi;
        }
        if($bmr){
            $calories_ratio = ($calories_intake - $calories_burned)/$bmr;
        }
          
        $dynamic_calories = ($bmi * $calories_ratio);

        if($dynamic_calories >= 18.5 && $dynamic_calories <= 24.9){
            $dynamic_calories_score = 10;
        }
        elseif(($dynamic_calories >= 15 || $dynamic_calories < 18.5) && ($dynamic_calories >= 25 || $dynamic_calories <= 29.9)){
            $dynamic_calories_score = 5;
        }
        elseif($dynamic_calories >= 30 || $dynamic_calories < 15){
            $dynamic_calories_score  = 0;
        }
        return $dynamic_calories_score;
    }
}
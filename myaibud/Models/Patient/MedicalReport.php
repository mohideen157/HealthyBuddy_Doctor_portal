<?php

namespace Myaibud\Models\Patient;

use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    protected $table = 'medical_report';

    protected $fillable = [
        'patient_id',
        'heart_rate',
        'bp',
        'sugar_fasting',
        'sugar_non_fasting',
        'triglycerides',
        'hdl_cholesterol',
        'ldl_cholesterol',
        'report_file'
    ];
}

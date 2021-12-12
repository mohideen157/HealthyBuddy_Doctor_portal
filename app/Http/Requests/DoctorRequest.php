<?php

namespace App\Http\Requests;

use App\Rules\DoctorEmailRule;
use App\Rules\DoctorMobileRule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'mobile_no' => ['required', new DoctorMobileRule],
            'landline'  => 'numeric|unique:doctors,landline,'.request()->route('id').',user_id',
            'email' => ['required','email', 'max:255', new DoctorEmailRule],
            'experiance' => 'required|numeric',
            'current_hospital' => 'nullable|max:255',
            'expertise' => 'required',
            'address' => 'required',
        ];
    }
}

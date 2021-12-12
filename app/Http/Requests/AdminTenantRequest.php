<?php

namespace App\Http\Requests;

use App\Rules\TenantEmailRule;
use App\Rules\TenantMobileRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminTenantRequest extends FormRequest
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
        $id  = request()->route('id');
        
        return [
            'name' => 'required|max:255',
            'mobile_no' => ['required', new TenantMobileRule],
            'landline' => 'numeric|unique:tenant_details,landline,'.$id.',user_id',
            'email' => ['required','max:255', 'email', new TenantEmailRule],
            'concern_person' => 'required|max:255|min:2',
            'concern_person_mobile' => 'required|unique:tenant_details,concern_person_mobile,'.$id.',user_id',
            'address' => 'required',
            'details' => 'required',
            'slug' => 'required|alpha|unique:tenant_details,slug,'.$id.',user_id',
        ];
    }
}

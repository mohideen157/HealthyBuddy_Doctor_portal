<?php

namespace App\Http\Requests\Tenant;

use App\Rules\OrganisationEmailRule;
use App\Rules\OrganisationMobileRule;
use Illuminate\Foundation\Http\FormRequest;

class OrganisationRequest extends FormRequest
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
        $id = request()->route('id');
        return [
            'name' => 'required|max:255',
            'mobile_no' => ['required', new OrganisationMobileRule],
            'landline' => 'numeric|unique:organisation_details,landline,'.$id.',user_id',
            'email' => ['required','max:255','email',new OrganisationEmailRule],
            'concern_person' => 'required|max:255|min:2',
            'concern_person_mobile' => 'required|digits:10|unique:organisation_details,concern_person_mobile,'.$id.',user_id',
            'address' => 'required',
            'details' => 'required',
        ];
    }
}

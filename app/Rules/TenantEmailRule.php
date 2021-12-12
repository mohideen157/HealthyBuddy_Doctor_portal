<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class TenantEmailRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $id  =  request()->route('id');

        $mobile_exists = User::whereUserRole(9)
                                ->where('email', $value)
                                ->when(!is_null('id'), function($query) use ($id){
                                    $query->where('id', '!=', $id);
                                })
                                ->exists();

        if($mobile_exists){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email Already Taken';
    }
}

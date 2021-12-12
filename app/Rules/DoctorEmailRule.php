<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class DoctorEmailRule implements Rule
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

        $email_exists = User::whereUserRole(2)
                                ->where('email', $value)
                                ->when(!is_null('id'), function($query) use ($id){
                                    $query->where('id', '!=', $id);
                                })
                                ->exists();

        if($email_exists){
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

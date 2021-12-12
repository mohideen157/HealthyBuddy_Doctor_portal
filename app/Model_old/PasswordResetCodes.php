<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PasswordResetCodes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_reset_codes';
}

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

    protected $fillable = ['user_id', 'code'];

    public function user()
    {
    	$this->belongsTo('App\User', 'user_id', 'id');
    }
}

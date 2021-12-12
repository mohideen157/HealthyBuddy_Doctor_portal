<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
	 * Get the feedback user
	 */
	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
